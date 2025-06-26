<?php

namespace Modules\CourseModule\app\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\BranchModule\Services\BranchService;
use Modules\CourseModule\Services\CourseRegPaymentService;
use Modules\CourseModule\Services\CourseRegService;
use Modules\CourseModule\Services\CourseRegStatusService;
use Modules\CourseModule\Services\CourseService;

class CourseAdminController extends Controller
{
    private $courseService;
    private $branchService;
    private $courseRegService;
    private $courseRegPaymentService;
    private $courseRegStatusService;

    public function __construct(CourseService $courseService, BranchService $branchService, CourseRegService $courseRegService, CourseRegPaymentService $courseRegPaymentService, CourseRegStatusService $courseRegStatusService)
    {
        $this->courseService = $courseService;
        $this->branchService = $branchService;
        $this->courseRegService = $courseRegService;
        $this->courseRegPaymentService = $courseRegPaymentService;
        $this->courseRegStatusService = $courseRegStatusService;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        //filter Branch
        if ($request->brnch)
            $request['branch'] = $request->brnch;

        $branches = $this->branchService->findAll();
        $courses = $this->courseService->findAllWithFilter($request->all())->paginate(20);
        return view('coursemodule::admin.index', compact('courses', 'branches'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $branches = $this->branchService->findAll();
        return view('coursemodule::admin.create', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'branch_id' => 'required',
                'name' => 'required',
                'group_nu' => 'required',
                'course_org_nu' => 'required',
                'start_at' => 'required|date',
                'end_at' => 'required|date',
                'price' => 'required|numeric|between:0,9999999999.99',
                'exam_fees' => 'required|numeric|between:0,9999999999.99',
            ],
            [
                'name.required' => 'يجب ادخال اسم الدورة',
                'group_nu.required' => 'يجب ادخال رقم الجروب',
                'course_org_nu.required' => 'يجب ادخال رقم الدورة في المؤسسة العامة',
                'start_at.required' => 'يجب تحديد تاريخ البدء',
                'end_at.required' => 'يجب تحديد تاريخ الانتهاء',
                'start_at.date' => 'يجب ادخال التاريخ بشكل صحيح',
                'end_at.date' => 'يجب ادخال التاريخ بشكل صحيح',
                'price.required' => 'يجب ادخال سعر الدورة',
                'price.numeric' => 'يجب ادخال سعر الدورة بطريقة صحيحة',
                'price.between' => 'يجب ادخال سعر الدورة بطريقة صحيحة',
                'exam_fees.required' => 'يجب ادخال رسوم الاختبار',
                'exam_fees.numeric' => 'يجب ادخال رسوم الاختبار بطريقة صحيحة',
                'exam_fees.between' => 'يجب ادخال رسوم الاختبار بطريقة صحيحة',
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $this->courseService->create($request);

        return redirect()->route(Auth::getDefaultDriver() . '.courses')
            ->with('success', 'تم الاضافه بنجاح.');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(Request $request)
    {
        $course_id = $request->id;
        $request['course_id'] = $request->id;
        $courses_regs = $this->courseRegService->findAllWithFilter($request->all())->get();

        $statuses = $this->courseRegStatusService->findAll();
        $course = $this->courseService->findOne($course_id);
        if ($request->export == 'yes') {
            return Excel::download(new CourseExport($course, $courses_regs), 'تقرير ' . $course->name . '.xlsx');
        }
        // dd($courses_regs[0]->student->payments);

        return view('coursemodule::admin.show', compact('courses_regs', 'course', 'statuses'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $branches = $this->branchService->findAll();
        $course = $this->courseService->findOne($id);
        return view('coursemodule::admin.edit', compact('course', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'branch_id' => 'required',
                'name' => 'required',
                'group_nu' => 'required',
                'course_org_nu' => 'required',
                'start_at' => 'required|date',
                'end_at' => 'required|date',
                'price' => 'required|numeric|between:0,9999999999.99',
                'exam_fees' => 'required|numeric|between:0,9999999999.99',
            ],
            [
                'branch_id.required' => 'يجب تحديد الفرع',
                'name.required' => 'يجب ادخال اسم الدورة',
                'group_nu.required' => 'يجب ادخال رقم الجروب',
                'course_org_nu.required' => 'يجب ادخال رقم الدورة في المؤسسة العامة',
                'start_at.required' => 'يجب تحديد تاريخ البدء',
                'end_at.required' => 'يجب تحديد تاريخ الانتهاء',
                'start_at.date' => 'يجب ادخال التاريخ بشكل صحيح',
                'end_at.date' => 'يجب ادخال التاريخ بشكل صحيح',
                'price.required' => 'يجب ادخال سعر الدورة',
                'price.numeric' => 'يجب ادخال سعر الدورة بطريقة صحيحة',
                'price.between' => 'يجب ادخال سعر الدورة بطريقة صحيحة',
                'exam_fees.required' => 'يجب ادخال رسوم الاختبار',
                'price.numeric' => 'يجب ادخال رسوم الاختبار بطريقة صحيحة',
                'price.between' => 'يجب ادخال رسوم الاختبار بطريقة صحيحة',
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $this->courseService->update($request);

        return redirect()->route(Auth::getDefaultDriver() . '.courses.show', $request->id)
            ->with('success', 'تم التعديل بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->courseService->deleteOne($id);
        return redirect()->route(Auth::getDefaultDriver() . '.courses')
            ->with('success', 'حذف الدورة بنجاح.');
    }

    public function indexArchive()
    {
        $courses = $this->courseService->findAll();
        return view('coursemodule::admin.archive_index', compact('courses'));
    }

    public function assignStudentToCourse(Request $request)
    {
        // $request['course_id'] = $request->course_id;
        $request['status_id'] = 1;

        if ($this->courseRegService->getStudentRegDetails($request->student_id, $request->course_id) != null)
            return back()
                ->withErrors('عفوا... تم التسجيل في هذه الدورة من قبل')
                ->withInput();
        // dd($request->all());
        $this->courseRegService->registerStudentToCourse($request);

        return redirect()->route(Auth::getDefaultDriver() . '.students.view', $request->student_id)
            ->with('success', 'تم الاضافه بنجاح ...');
    }

    public function regAction(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required'
            ]
        );
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $courseDate = $this->courseRegService->takeRegAction($request->all());

        return back()
            ->with('success', 'تمت العمليه بنجاح.');
    }

    public function payAction(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'pay_method' => 'required',
                'amount' => 'required|numeric',
                'paid_at' => 'required|date',
                'pay_type' => 'required'
            ],
            [
                'pay_method.required' => 'يجب اختيار نوع الدفع',
                'amount.required' => 'يجب ادخال قيمة الدفعة',
                'amount.numeric' => 'يجب ادخال قيمة الدفعة بطريقة صحيحة و ان تكون الارقام باللغة الانجليزية',
                'paid_at.required' => 'يجب ادخال تاريخ الدفع',
                'paid_at.date' => 'يجب ادخال التاريخ بشكل صحيح',
                'pay_type.required' => 'يجب اختيار طرية الدفع'
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $this->courseRegPaymentService->takePayAction($request->all());

        $this->courseRegService->checkAndUpdateRegStatus($request->id);

        return back()
            ->with('success', 'تمت العمليه بنجاح.');
    }

    public function updatePaymentType(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'reg_id' => 'required',
                'status' => 'required'
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $this->courseRegService->updatePaymentType($request);
        return back()
            ->with('success', 'تمت العمليه بنجاح.');
    }

    public function updateRegStatus(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'reg_id' => 'required',
                'status' => 'required'
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $this->courseRegService->updateRegStatus($request);
        return back()
            ->with('success', 'تمت العمليه بنجاح.');
    }

    public function receiptAction(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'receipttitle' => 'required'
            ]
        );
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        if (!$request->hasFile('receiptfile'))
            return back()
                ->withErrors('يجب اختيار صورة الإيصال')
                ->withInput();

        $this->courseRegReceipteService->takeReceiptAction($request);

        return back()
            ->with('success', 'تمت العمليه بنجاح.');
    }

    public function destroyReg($id)
    {
        $this->courseRegService->deleteOne($id);
        return back()
            ->with('success', 'تم حذف الموعد بنجاح.');
    }

    public function setCertDelivered($id)
    {
        $this->courseRegService->updateCertDelivered($id, 1);
        $this->courseRegService->checkAndUpdateRegStatus($id);

        return back()
            ->with('success', 'تم استلام الشهاده بنجاح.');
    }

    public function setCertNotDelivered($id)
    {
        $this->courseRegService->updateCertDelivered($id, 0);
        $this->courseRegService->checkAndUpdateRegStatus($id);

        return back()
            ->with('success', 'تم تعديل عدم استلام الشهاده بنجاح.');
    }

    public function ChangePriceForOneStudent(Request $request)
    {
        $price = $this->courseRegService->updatePriceForOneStudent($request);
        $this->courseRegService->checkAndUpdateRegStatus($request->reg_id);
        return response()->json(
            array(
                'success' => "true",
                'new_price' => $price->price,
                'id' => $price->id,

            )
        );
    }

    public function ChangeExamPriceForOneStudent(Request $request)
    {
        $price = $this->courseRegService->updateExamPriceForOneStudent($request);
        $this->courseRegService->checkAndUpdateRegStatus($request->reg_id);
        return response()->json(
            array(
                'success' => "true",
                'new_exam_price' => $price->exam_fees,
                'id' => $price->id,

            )
        );
    }
}
