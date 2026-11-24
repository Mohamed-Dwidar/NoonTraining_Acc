<?php

namespace Modules\ReminderModule\app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\LogModule\Services\LogService;
use Modules\ReminderModule\app\Http\Models\Reminder;
use Modules\ReminderModule\app\Http\Models\ReminderTime;
use Modules\ReminderModule\Services\ReminderService;

/**
 * Shared by both portals (Admin\ReminderAdminController, User\ReminderUserController).
 * What each person can see / edit is decided in the Reminder model by the person's type.
 */
abstract class ReminderController extends Controller
{
    protected $reminderService;
    protected $logService;

    public function __construct(ReminderService $reminderService, LogService $logService)
    {
        $this->reminderService = $reminderService;
        $this->logService = $logService;
    }

    /** admin | user */
    abstract protected function portal();

    /** Options of the "user" filter (admin only) */
    protected function creatorsForFilter()
    {
        return [];
    }

    /** Query filters allowed in this portal */
    protected function filters(Request $request)
    {
        return $request->only(['usr', 'sts']);
    }

    protected function person()
    {
        return Auth::guard($this->portal())->user();
    }

    public function index(Request $request)
    {
        $reminders = $this->reminderService->findAllWithFilter($this->filters($request), $this->person());
        $creators = $this->creatorsForFilter();
        $person = $this->person();

        return view('remindermodule::admin.index', compact('reminders', 'creators', 'person'));
    }

    public function create()
    {
        return view('remindermodule::admin.create');
    }

    public function store(Request $request)
    {
        $validator = $this->validator($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $reminder = $this->reminderService->create($request, $this->person());

        $this->logService->recordLog('اضافة إشعار', 'تم اضافة : ' . $this->logTitle($reminder), url()->current());

        return $this->toIndex()->with('success', 'تم الاضافه بنجاح.');
    }

    public function show($id)
    {
        $reminder = $this->reminderService->findOneVisible($id, $this->person());
        if (!$reminder) {
            return $this->notFound();
        }
        $person = $this->person();

        return view('remindermodule::admin.show', compact('reminder', 'person'));
    }

    public function edit($id)
    {
        $reminder = $this->reminderService->findOneVisible($id, $this->person());
        if (!$reminder || !$reminder->canBeManagedBy($this->person())) {
            return $this->notFound();
        }

        return view('remindermodule::admin.edit', compact('reminder'));
    }

    public function update(Request $request)
    {
        $reminder = $this->reminderService->findOneVisible($request->id, $this->person());
        if (!$reminder || !$reminder->canBeManagedBy($this->person())) {
            return $this->notFound();
        }

        $validator = $this->validator($request, $reminder);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $reminder = $this->reminderService->update($reminder, $request);

        $this->logService->recordLog('تعديل إشعار', 'تم تعديل : ' . $this->logTitle($reminder), url()->current());

        return $this->toIndex()->with('success', 'تم التعديل بنجاح.');
    }

    public function destroy(Request $request)
    {
        $reminder = $this->reminderService->findOneVisible($request->id, $this->person());
        if (!$reminder || !$reminder->canBeManagedBy($this->person())) {
            return $this->notFound();
        }

        $this->reminderService->deleteOne($reminder->id);

        $this->logService->recordLog('حذف إشعار', 'تم حذف : ' . $this->logTitle($reminder), url()->current());

        return $this->toIndex()->with('success', 'تم الحذف بنجاح.');
    }

    /** AJAX: mark as read for the logged in person only */
    public function markRead(Request $request)
    {
        $reminder = $this->reminderService->findOneVisible($request->id, $this->person());
        if (!$reminder) {
            return response()->json(['message' => 'الإشعار غير موجود'], 404);
        }

        $reminder = $this->reminderService->markRead($reminder, $this->person());

        return response()->json($this->headerData() + [
            'read_at' => optional($reminder->last_read_at)->format('Y-m-d H:i'),
        ]);
    }

    /** AJAX: refresh the header icon */
    public function latest()
    {
        return response()->json($this->headerData());
    }

    private function headerData()
    {
        $reminders = $this->reminderService->findLatest($this->person());

        return [
            'count' => $this->reminderService->countUnread($this->person()),
            'html' => view('remindermodule::admin.partials.header_list', compact('reminders'))->render(),
        ];
    }

    private function validator(Request $request, ?Reminder $reminder = null)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:191',
            'details' => 'nullable|string|max:5000',
            'remind_date' => 'required|date_format:Y-m-d',
            'remind_time' => 'required|date_format:H:i',
            'is_for_all' => 'required|in:0,1',
            'before' => 'nullable|array|max:10',
            'before.*.value' => 'required|integer|min:1|max:365',
            'before.*.unit' => ['required', Rule::in(array_keys(ReminderTime::UNITS))],
        ], [
            'title.*' => 'يجب ادخال عنوان الإشعار (191 حرف بحد أقصى)',
            'details.*' => 'التفاصيل طويلة جدا',
            'remind_date.*' => 'يجب ادخال تاريخ الإشعار بطريقة صحيحة',
            'remind_time.*' => 'يجب ادخال وقت الإشعار بطريقة صحيحة',
            'is_for_all.*' => 'يجب اختيار لمن يظهر الإشعار',
            'before.array' => 'أوقات التذكير غير صحيحة',
            'before.max' => 'الحد الأقصى لأوقات التذكير هو 10',
            'before.*.value.*' => 'يجب ادخال وقت التذكير رقم من 1 الي 365',
            'before.*.unit.*' => 'يجب اختيار وحدة وقت التذكير',
        ]);

        $validator->after(function ($validator) use ($request, $reminder) {
            if ($validator->errors()->isNotEmpty())
                return;
            foreach ($this->reminderService->findPastTimes($request, $reminder) as $label) {
                $validator->errors()->add('before', 'وقت التذكير قد مضى : ' . $label);
            }
        });

        return $validator;
    }

    /** Users log is open to branch staff, so private titles stay out of it */
    private function logTitle(Reminder $reminder)
    {
        return $reminder->is_for_all ? $reminder->title : 'إشعار خاص';
    }

    private function toIndex()
    {
        return redirect()->route($this->portal() . '.reminders');
    }

    private function notFound()
    {
        return $this->toIndex()->withErrors('الإشعار غير موجود');
    }
}
