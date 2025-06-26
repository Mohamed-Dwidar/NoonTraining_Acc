<?php

namespace Modules\StudentModule\app\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\StudentModule\Services\StudentService;
// use GeniusTS\HijriDate\Date;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Modules\BranchModule\Services\BranchService;
use Modules\LocationModule\Services\CityService;
use Modules\StudentModule\Exports\StudentExport;
use Maatwebsite\Excel\Facades\Excel;
use Modules\CourseModule\Services\CourseService;
use Illuminate\Validation\Rule;

class StudentAdminController extends Controller
{
    private $studentService;
    private $branchService;
    private $cityService;
    private $courseService;

    public function __construct(StudentService $studentService, BranchService $branchService, CityService $cityService, CourseService $courseService)
    {
        $this->studentService = $studentService;
        $this->branchService = $branchService;
        $this->cityService = $cityService;
        $this->courseService = $courseService;
    }

    public function add()
    {
        $branches = $this->branchService->findAll();
        $cities = $this->cityService->getAll();
        return view('studentmodule::admin.create', compact('branches', 'cities'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'branch_id' => 'required',
                'id_nu' => [
                    'required',
                    'digits:10',
                    Rule::unique('students')->where(function ($query) use ($request) {
                        return $query->where('branch_id', $request->branch_id)
                        ->where('deleted_at', Null);
                    }),
                ],
                'phone1' => 'required',
                'city_id' => 'required',
                'company' => 'required',
                'id_expire_date' => 'nullable|date'
            ],
            [
                'name.required' => 'يجب ادخال الاسم',
                'branch_id.required' => 'يجب تحديد الفرع',
                'id_nu.required' => 'يجب ادخال رقم الهوية أو الأقامه',
                'id_nu.digits' => 'رقم الهوية أو الإقامة لا يتعدي ١٠ ارقام وباللغه الانجليزية',
                'id_nu.unique' => 'الطالب مسجل من قبل',
                'phone1.required' => 'يجب ادخال رقم الجوال',
                'city_id.required' => 'يجب تحديد المدينة',
                'company.required' => 'يجب ادخال قطاع العمل',
                'id_expire_date.date' => 'يجب ادخال التاريخ بشكل صحيح',
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $student = $this->studentService->create($request);

        return redirect()->route(Auth::getDefaultDriver() . '.students.view', $student->id)
            ->with('success', 'تم الاضافه بنجاح ...');
    }

    public function index(Request $request)
    {
        //filter Branch
        if ($request->brnch)
            $request['branch'] = $request->brnch;

        $students = $this->studentService->findAllWithFilter($request->all())->paginate(20);
        $branches = $this->branchService->findAll();
        return view('studentmodule::admin.index', compact('students', 'branches'));
    }

    public function show(Request $request, $id)
    {
        $student = $this->studentService->findOne($id);
        $courses = $this->courseService->findAll();
        $today = Date::today();
        // $courses_dates = $this->courseDateService->findAll()->where('end_at', '>=', $today->format('Y-m-d'));
        // dd($student->courses_regs->toArray());
        // foreach ($student->courses_regs as $reg){
        //     print_r($reg->course->id);
        // }
        // exit;
        // if ($request->export == 'yes') {
        //return Excel::download(new StudentExport($student), 'تقرير الطالب - ' . $student->name . '.xlsx');
        // }
        return view('studentmodule::admin.show', compact('student', 'courses'));
    }

    public function edit($id)
    {
        $branches = $this->branchService->findAll();
        $cities = $this->cityService->getAll();
        $student = $this->studentService->findOne($id);
        return view('studentmodule::admin.edit', compact('student', 'branches', 'cities'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'branch_id' => 'required',
                'id_nu' => 'required|digits:10',
                'id_nu' => [
                    'required',
                    'digits:10',
                    Rule::unique('students')->where(function ($query) use ($request) {
                        return $query->where('branch_id', $request->branch_id)
                        ->where('deleted_at', Null);
                    })->ignore($request->id),
                ],
                'phone1' => 'required',
                'city_id' => 'required',
                'company' => 'required',
                'id_expire_date' => 'nullable|date'
            ],
            [
                'name.required' => 'يجب ادخال الاسم',
                'branch_id.required' => 'يجب تحديد الفرع',
                'id_nu.required' => 'يجب ادخال رقم الهوية أو الأقامه',
                'id_nu.digits' => 'رقم الهوية أو الإقامة لا يتعدي ١٠ ارقام وباللغه الانجليزية',
                'id_nu.unique' => 'الطالب مسجل من قبل',
                'phone1.required' => 'يجب ادخال رقم الجوال',
                'city_id.required' => 'يجب تحديد المدينة',
                'company.required' => 'يجب ادخال قطاع العمل',
                'id_expire_date.date' => 'يجب ادخال التاريخ بشكل صحيح',
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $this->studentService->update($request);

        return redirect()->route(Auth::getDefaultDriver() . '.students.view', $request->id)
            ->with('success', 'Updated Successfully.');
    }

    public function destroy($id)
    {
        // if (!in_array('can_del_students', auth('admin')->user()->privileges_keys()))
        //     return back()->withErrors('لا يمكن اتمام هذه العمليه');

        $this->studentService->deleteOne($id);
        return redirect()->route(Auth::getDefaultDriver() . '.students')
            ->with('success', 'Deleted Successfully.');
    }
}
