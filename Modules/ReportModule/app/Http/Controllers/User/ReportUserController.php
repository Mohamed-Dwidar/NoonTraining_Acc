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

class ReportUserController extends Controller
{
    private $courseService;
    private $studentService;
    private $courseRegService;
    private $logService;

    public function __construct(StudentService $studentService, CourseService $courseService, CourseRegService $courseRegService, LogService $logService)
    {
        $this->studentService = $studentService;
        $this->courseService = $courseService;
        $this->courseRegService = $courseRegService;
        $this->logService = $logService;
    }

    public function index()
    {
        return view('reportmodule::admin.index');
    }

    public function ReportAllStudents(Request $request)
    {
        $export = $request->export;
        $request['all'] = 1;
        //filter Branch
        $branches = [];
        $request['branch'] = Auth::guard('user')->user()->branch_id;

        $courses_regs = $this->courseRegService->findAllWithFilter($request->all())
            ->orderBy('course_regs.course_id', 'DESC')
            ->orderBy('course_regs.created_at', 'ASC')
            ->get();
        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($courses_regs), 'تقرير بكامل الطلاب.xlsx');
        }
        return view('reportmodule::admin.students_all', compact('courses_regs', 'branches'));
    }

    public function ReportAllCourses(Request $request)
    {
        $export = $request->export;
        $request['all'] = 1;
        
        //filter Branch
        $branches = [];
        $request['branch'] = Auth::guard('user')->user()->branch_id;
        
        $courses = $this->courseService->findAllWithFilter($request->all())
            ->orderBy('courses.name', 'ASC')
            ->orderBy('courses.group_nu', 'ASC')
            ->orderBy('courses.course_org_nu', 'ASC')
            ->get();
        if ($request->export == 'yes') {
            return Excel::download(new CourseExport($courses), 'تقرير بالدورات .xlsx');
        }
        return view('reportmodule::admin.courses_all', compact('courses', 'branches'));
    }

    public function ReportAllCourseStudents(Request $request)
    {
        //$branches = $this->branchService->findAll();
        //$export = $request->export;
        //$request['fltr_sts'] = 1;
        $request['course_id'] = $request->id;
        //filter Branch
        // if ($request->brnch)
        //     $request['branch'] = $request->brnch;

        $courses_regs = $this->courseRegService->findAllWithFilter($request->all())->get();
        $course = $this->courseService->findOne($request->id);
        // dd($courses_regs->toArray());
        // if ($request->export == 'yes') {
        return Excel::download(new CourseRegExport($courses_regs), 'تقرير بالطلاب المسجلين لدورة ' . $course->fullName . '.xlsx');
        // }
        // return view('reportmodule::admin.students_not_paid', compact('courses_regs', 'branches'));
    }

    public function reportStudentsNotPaid(Request $request)
    {
        $export = $request->export;
        $request['fltr_sts'] = 1;
        //filter Branch
        $branches = [];
        $request['branch'] = Auth::guard('user')->user()->branch_id;

        $courses_regs = $this->courseRegService->findAllWithFilter($request->all())->get();
        // dd($courses_regs->toArray());
        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($courses_regs), 'تقرير بالطلاب الغير مسددين إطلاقاٌ.xlsx');
        }
        return view('reportmodule::admin.students_not_paid', compact('courses_regs', 'branches'));
    }

    public function reportStudentsInstallmentPay(Request $request)
    {
        $export = $request->export;
        $request['fltr_sts'] = [2, 3];
        //filter Branch
        $branches = [];
        $request['branch'] = Auth::guard('user')->user()->branch_id;

        $courses_regs = $this->courseRegService->findAllWithFilter($request->all())->get();
        // dd($courses_regs->toArray());
        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($courses_regs), 'تقرير بالطلاب عليهم أقساط.xlsx');
        }
        return view('reportmodule::admin.students_installment_pay', compact('courses_regs', 'branches'));
    }

    public function reportStudentsExamNotPaid(Request $request)
    {
        $export = $request->export;
        $request['fltr_sts'] = [4, 8];  //[1, 2, 4, 8, 10];
        //filter Branch
        $branches = [];
        $request['branch'] = Auth::guard('user')->user()->branch_id;

        $courses_regs = $this->courseRegService->findAllWithFilter($request->all())->get();
        // dd($courses_regs->toArray());
        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($courses_regs), 'تقرير بالطلاب عليهم رسوم الاختبار فقط.xlsx');
        }
        return view('reportmodule::admin.students_exam_not_paid', compact('courses_regs', 'branches'));
    }

    public function reportStudentsPaid(Request $request)
    {
        $export = $request->export;
        $request['fltr_sts'] = [4, 6, 7];
        //filter Branch
        $branches = [];
        $request['branch'] = Auth::guard('user')->user()->branch_id;

        $courses_regs = $this->courseRegService->findAllWithFilter($request->all())->get();
        // dd($courses_regs->toArray());
        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($courses_regs), 'تقرير بالطلاب المسددين.xlsx');
        }
        return view('reportmodule::admin.students_paid', compact('courses_regs', 'branches'));
    }

    public function reportStudentsReciveCert(Request $request)
    {
        $export = $request->export;
        $request['fltr_crt'] = 1;
        //filter Branch
        $branches = [];
        $request['branch'] = Auth::guard('user')->user()->branch_id;

        $courses_regs = $this->courseRegService->findAllWithFilter($request->all())->get();
        // dd($courses_regs->toArray());
        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($courses_regs), 'تقرير بالطلاب المستلمين للشهادات.xlsx');
        }
        return view('reportmodule::admin.students_recive_cert', compact('courses_regs', 'branches'));
    }

    public function reportStudentsNotReciveCert(Request $request)
    {
        $export = $request->export;
        $request['fltr_crt'] = 0;
        //filter Branch
        $branches = [];
        $request['branch'] = Auth::guard('user')->user()->branch_id;

        $courses_regs = $this->courseRegService->findAllWithFilter($request->all())->get();
        // dd($courses_regs->toArray());
        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($courses_regs), 'تقرير بالطلاب الغير مستلمين للشهادات.xlsx');
        }
        return view('reportmodule::admin.students_not_recive_cert', compact('courses_regs', 'branches'));
    }

    public function reportStudentsLeave(Request $request)
    {
        $export = $request->export;
        $request['fltr_leave'] = 1;
        //filter Branch
        $branches = [];
        $request['branch'] = Auth::guard('user')->user()->branch_id;

        $courses_regs = $this->courseRegService->findAllWithFilter($request->all())->get();
        // dd($courses_regs->toArray());
        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($courses_regs), 'تقرير بالطلاب المغادرين.xlsx');
        }
        return view('reportmodule::admin.students_leave', compact('courses_regs', 'branches'));
    }

    /*public function reportStudentsByCompany(Request $request)
    {
        // $export = $request->export;
        // $request['fltr_sts'] = [4,6,7];
        // $courses_regs = $this->courseRegService->findAllWithFilter($request->all())->get();
        // // dd($courses_regs->toArray());
        // if ($request->export == 'yes') {
        //     return Excel::download(new CourseRegExport($courses_regs), 'تقرير بالطلاب المسددين.xlsx');
        // }
        return view('reportmodule::admin.students_by_company', compact('courses_regs'));
    }*/

    public function usersLog(Request $request)
    {
        $export = $request->export;
        if ($request->export == 'yes') {
            $logs = $this->logService->findAll()->get();
            return Excel::download(new LogExport($logs), 'تقرير بالزيارات للمستخدمين.xlsx');
        } else {
            $logs = $this->logService->findAll()->paginate(20);
            return view('reportmodule::admin.log_users', compact('logs'));
        }
    }
}
