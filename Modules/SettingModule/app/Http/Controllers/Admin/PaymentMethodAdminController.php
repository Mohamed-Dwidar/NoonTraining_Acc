<?php

namespace Modules\SettingModule\app\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\LogModule\Services\LogService;
use Modules\SettingModule\Services\PaymentMethodService;

class PaymentMethodAdminController extends Controller
{
    private $paymentMethodService;
    private $logService;

    public function __construct(PaymentMethodService $paymentMethodService, LogService $logService)
    {
        $this->paymentMethodService = $paymentMethodService;
        $this->logService = $logService;
    }

    public function index()
    {
        $methods = $this->paymentMethodService->findAll();
        return view('settingmodule::admin.payment_methods.index', compact('methods'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255', Rule::unique('payment_methods', 'name')->whereNull('deleted_at')],
        ], [
            'name.required' => 'يجب ادخال اسم طريقة الدفع',
            'name.max' => 'الاسم طويل جدا',
            'name.unique' => 'طريقة الدفع موجودة بالفعل',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $method = $this->paymentMethodService->create($request);

        $this->logService->recordLog('اضافة طريقة دفع', 'تم اضافة : ' . $method->name, url()->current());

        return redirect()->route('admin.settings.payment_methods')->with('success', 'تم الاضافه بنجاح.');
    }

    public function edit($id)
    {
        $method = $this->paymentMethodService->findOne($id);
        if (!$method) {
            return redirect()->route('admin.settings.payment_methods')->withErrors('طريقة الدفع غير موجودة');
        }
        return view('settingmodule::admin.payment_methods.edit', compact('method'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => ['required', 'max:255', Rule::unique('payment_methods', 'name')->ignore($request->id)->whereNull('deleted_at')],
        ], [
            'name.required' => 'يجب ادخال اسم طريقة الدفع',
            'name.max' => 'الاسم طويل جدا',
            'name.unique' => 'طريقة الدفع موجودة بالفعل',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if (!$this->paymentMethodService->findOne($request->id)) {
            return redirect()->route('admin.settings.payment_methods')->withErrors('طريقة الدفع غير موجودة');
        }

        $method = $this->paymentMethodService->update($request);

        $this->logService->recordLog('تعديل طريقة دفع', 'تم تعديل : ' . $method->name, url()->current());

        return redirect()->route('admin.settings.payment_methods')->with('success', 'تم التعديل بنجاح.');
    }

    public function destroy(Request $request)
    {
        $method = $this->paymentMethodService->findOne($request->id);
        if (!$method) {
            return redirect()->route('admin.settings.payment_methods')->withErrors('طريقة الدفع غير موجودة');
        }

        $this->paymentMethodService->deleteOne($method->id);

        $this->logService->recordLog('حذف طريقة دفع', 'تم حذف : ' . $method->name, url()->current());

        return redirect()->route('admin.settings.payment_methods')->with('success', 'تم الحذف بنجاح.');
    }
}
