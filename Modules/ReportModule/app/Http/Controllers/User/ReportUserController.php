<?php

namespace Modules\ReportModule\app\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\CourseModule\Services\CourseRegService;
use Modules\CourseModule\Services\CourseService;
use Modules\StudentModule\Services\StudentService;
use Maatwebsite\Excel\Facades\Excel;
use Modules\LogModule\Services\LogService;
use Modules\ReportModule\Exports\CourseExport;
use Modules\ReportModule\Exports\CourseRegExport;
use Modules\ReportModule\Exports\LogExport;
use Modules\SettingModule\Services\RegByEmployeeService;

class ReportUserController extends Controller {
    private $courseService;
    private $studentService;
    private $courseRegService;
    private $logService;
    private $regByEmployeeService;

    public function __construct(StudentService $studentService, CourseService $courseService, CourseRegService $courseRegService, LogService $logService, RegByEmployeeService $regByEmployeeService) {
        $this->regByEmployeeService = $regByEmployeeService;
        $this->studentService = $studentService;
        $this->courseService = $courseService;
        $this->courseRegService = $courseRegService;
        $this->logService = $logService;
    }

    /** Permission "فلتر التقارير بالموظفين": filter by "تم التسجيل عن طريق" */
    private function canFilterRegBy() {
        return Auth::guard('user')->user()->can('filter_reports_by_reg_by');
    }

    /** Employees without the permission can't filter by "تم التسجيل عن طريق" (also blocks a typed ?regby=) */
    private function guardRegByFilter(Request $request) {
        if (!$this->canFilterRegBy()) {
            $request->query->remove('regby');
        }
    }

    /** Filter options — sent to the view only with the permission (the view shows the filter when they exist) */
    private function regByFilterData() {
        return $this->canFilterRegBy() ? ['reg_by_employees' => $this->regByEmployeeService->findAllForFilter()] : [];
    }

    public function index() {
        return view('reportmodule::admin.index');
    }

    public function ReportAllStudents(Request $request) {
        $this->guardRegByFilter($request);
        $request['all'] = 1;
        $branches = [];
        $request['branch'] = Auth::guard('user')->user()->branch_id;

        $query = $this->courseRegService->findAllWithFilter($request->all())
            ->orderBy('course_regs.course_id', 'DESC')
            ->orderBy('course_regs.created_at', 'ASC');

        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($query->get()), 'تقرير بكامل الطلاب.xlsx');
        }

        $courses_regs = $query->paginate(50);
        return view('reportmodule::admin.students_all', compact('courses_regs', 'branches') + $this->regByFilterData());
    }

    public function ReportAllCourses(Request $request) {
        $this->guardRegByFilter($request);
        $request['all'] = 1;
        $branches = [];
        $request['branch'] = Auth::guard('user')->user()->branch_id;

        $query = $this->courseService->findAllWithFilter($request->all())
            ->orderBy('courses.name', 'ASC')
            ->orderBy('courses.group_nu', 'ASC')
            ->orderBy('courses.course_org_nu', 'ASC');

        if ($request->export == 'yes') {
            return Excel::download(new CourseExport($query->get()), 'تقرير بالدورات .xlsx');
        }

        $courses = $query->paginate(50);
        return view('reportmodule::admin.courses_all', compact('courses', 'branches') + $this->regByFilterData());
    }

    public function ReportAllCourseStudents(Request $request) {
        $this->guardRegByFilter($request);
        $request['course_id'] = $request->id;

        $courses_regs = $this->courseRegService->findAllWithFilter($request->all())->get();
        $course = $this->courseService->findOne($request->id);
        return Excel::download(new CourseRegExport($courses_regs), 'تقرير بالطلاب المسجلين لدورة ' . $course->fullName . '.xlsx');
    }

    public function reportStudentsNotPaid(Request $request) {
        $this->guardRegByFilter($request);
        $request['fltr_sts'] = 1;
        $branches = [];
        $request['branch'] = Auth::guard('user')->user()->branch_id;

        $query = $this->courseRegService->findAllWithFilter($request->all());

        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($query->get()), 'تقرير بالطلاب الغير مسددين إطلاقاٌ.xlsx');
        }

        $courses_regs = $query->paginate(50);
        return view('reportmodule::admin.students_not_paid', compact('courses_regs', 'branches') + $this->regByFilterData());
    }

    public function reportStudentsInstallmentPay(Request $request) {
        $this->guardRegByFilter($request);
        $request['fltr_sts'] = [2, 3];
        $branches = [];
        $request['branch'] = Auth::guard('user')->user()->branch_id;

        $query = $this->courseRegService->findAllWithFilter($request->all());

        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($query->get()), 'تقرير بالطلاب عليهم أقساط.xlsx');
        }

        $courses_regs = $query->paginate(50);
        return view('reportmodule::admin.students_installment_pay', compact('courses_regs', 'branches') + $this->regByFilterData());
    }

    public function reportStudentsExamNotPaid(Request $request) {
        $this->guardRegByFilter($request);
        $request['fltr_sts'] = [4, 8];
        $branches = [];
        $request['branch'] = Auth::guard('user')->user()->branch_id;

        $query = $this->courseRegService->findAllWithFilter($request->all());

        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($query->get()), 'تقرير بالطلاب عليهم رسوم الاختبار فقط.xlsx');
        }

        $courses_regs = $query->paginate(50);
        return view('reportmodule::admin.students_exam_not_paid', compact('courses_regs', 'branches') + $this->regByFilterData());
    }

    public function reportStudentsPaid(Request $request) {
        $this->guardRegByFilter($request);
        $request['fltr_sts'] = [4, 6, 7];
        $branches = [];
        $request['branch'] = Auth::guard('user')->user()->branch_id;

        $query = $this->courseRegService->findAllWithFilter($request->all());

        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($query->get()), 'تقرير بالطلاب المسددين.xlsx');
        }

        $courses_regs = $query->paginate(50);
        return view('reportmodule::admin.students_paid', compact('courses_regs', 'branches') + $this->regByFilterData());
    }

    public function reportStudentsReciveCert(Request $request) {
        $this->guardRegByFilter($request);
        $request['fltr_crt'] = 1;
        $branches = [];
        $request['branch'] = Auth::guard('user')->user()->branch_id;

        $query = $this->courseRegService->findAllWithFilter($request->all());

        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($query->get()), 'تقرير بالطلاب المستلمين للشهادات.xlsx');
        }

        $courses_regs = $query->paginate(50);
        return view('reportmodule::admin.students_recive_cert', compact('courses_regs', 'branches') + $this->regByFilterData());
    }

    public function reportStudentsNotReciveCert(Request $request) {
        $this->guardRegByFilter($request);
        $request['fltr_crt'] = 0;
        $branches = [];
        $request['branch'] = Auth::guard('user')->user()->branch_id;

        $query = $this->courseRegService->findAllWithFilter($request->all());

        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($query->get()), 'تقرير بالطلاب الغير مستلمين للشهادات.xlsx');
        }

        $courses_regs = $query->paginate(50);
        return view('reportmodule::admin.students_not_recive_cert', compact('courses_regs', 'branches') + $this->regByFilterData());
    }

    public function reportStudentsLeave(Request $request) {
        $this->guardRegByFilter($request);
        $request['fltr_leave'] = 1;
        $branches = [];
        $request['branch'] = Auth::guard('user')->user()->branch_id;

        $query = $this->courseRegService->findAllWithFilter($request->all());

        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($query->get()), 'تقرير بالطلاب المغادرين.xlsx');
        }

        $courses_regs = $query->paginate(50);
        return view('reportmodule::admin.students_leave', compact('courses_regs', 'branches') + $this->regByFilterData());
    }

    public function reportLawer(Request $request) {
        $this->guardRegByFilter($request);
        $request['fltr_lawer'] = 1;
        $branches = [];
        $request['branch'] = Auth::guard('user')->user()->branch_id;

        $query = $this->courseRegService->findAllWithFilter($request->all());

        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($query->get()), 'تقرير بالمحالين إلى القضاء.xlsx');
        }

        $courses_regs = $query->paginate(50);
        return view('reportmodule::admin.students_lawer', compact('courses_regs', 'branches') + $this->regByFilterData());
    }

    /*public function reportStudentsByCompany(Request $request)
    {
        return view('reportmodule::admin.students_by_company', compact('courses_regs') + $this->regByFilterData());
    }*/

    public function usersLog(Request $request) {
        if ($request->export == 'yes') {
            $logs = $this->logService->findAll()->get();
            return Excel::download(new LogExport($logs), 'تقرير بالزيارات للمستخدمين.xlsx');
        } else {
            $logs = $this->logService->findAll()->paginate(20);
            return view('reportmodule::admin.log_users', compact('logs'));
        }
    }
}
