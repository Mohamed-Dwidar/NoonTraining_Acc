<?php

namespace Modules\ReportModule\app\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\CourseModule\Services\CourseRegService;
use Modules\CourseModule\Services\CourseService;
use Modules\StudentModule\Services\StudentService;
use Maatwebsite\Excel\Facades\Excel;
use Modules\AdminModule\Services\AdminService;
use Modules\BranchModule\Services\BranchService;
use Modules\LogModule\Services\LogService;
use Modules\ReportModule\Exports\CourseExport;
use Modules\ReportModule\Exports\CourseRegExport;
use Modules\ReportModule\Exports\LogExport;
use Modules\UserModule\Services\UserService;

class ReportAdminController extends Controller {
    private $courseRegService;
    private $courseService;
    private $logService;
    private $branchService;
    private $userService;
    private $adminService;

    public function __construct(CourseRegService $courseRegService, CourseService $courseService, LogService $logService, BranchService $branchService, UserService $userService, AdminService $adminService) {
        $this->courseRegService = $courseRegService;
        $this->courseService = $courseService;
        $this->logService = $logService;
        $this->branchService = $branchService;
        $this->userService = $userService;
        $this->adminService = $adminService;
    }

    public function index() {
        return view('reportmodule::admin.index');
    }

    public function ReportAllStudents(Request $request) {
        $branches = $this->branchService->findAll();
        $request['all'] = 1;

        if ($request->brnch)
            $request['branch'] = $request->brnch;

        $query = $this->courseRegService->findAllWithFilter($request->all())
            ->orderBy('course_regs.course_id', 'DESC')
            ->orderBy('course_regs.created_at', 'ASC');

        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($query->get()), 'تقرير بكامل الطلاب.xlsx');
        }

        $courses_regs = $query->paginate(50);
        return view('reportmodule::admin.students_all', compact('courses_regs', 'branches'));
    }

    public function ReportAllCourses(Request $request) {
        $branches = $this->branchService->findAll();
        $request['all'] = 1;

        if ($request->brnch)
            $request['branch'] = $request->brnch;

        $query = $this->courseService->findAllWithFilter($request->all())
            ->orderBy('courses.name', 'ASC')
            ->orderBy('courses.group_nu', 'ASC')
            ->orderBy('courses.course_org_nu', 'ASC');

        if ($request->export == 'yes') {
            return Excel::download(new CourseExport($query->get()), 'تقرير بالدورات .xlsx');
        }

        $courses = $query->paginate(50);
        return view('reportmodule::admin.courses_all', compact('courses', 'branches'));
    }

    public function ReportAllCourseStudents(Request $request) {
        $request['course_id'] = $request->id;

        $courses_regs = $this->courseRegService->findAllWithFilter($request->all())->get();
        $course = $this->courseService->findOne($request->id);
        return Excel::download(new CourseRegExport($courses_regs), 'تقرير بالطلاب المسجلين لدورة ' . $course->fullName . '.xlsx');
    }

    public function reportStudentsNotPaid(Request $request) {
        $branches = $this->branchService->findAll();
        $request['fltr_sts'] = 1;

        if ($request->brnch)
            $request['branch'] = $request->brnch;

        $query = $this->courseRegService->findAllWithFilter($request->all());

        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($query->get()), 'تقرير بالطلاب الغير مسددين إطلاقاٌ.xlsx');
        }

        $courses_regs = $query->paginate(50);
        return view('reportmodule::admin.students_not_paid', compact('courses_regs', 'branches'));
    }

    public function reportStudentsInstallmentPay(Request $request) {
        $branches = $this->branchService->findAll();
        $request['fltr_sts'] = [2, 3];

        if ($request->brnch)
            $request['branch'] = $request->brnch;

        $query = $this->courseRegService->findAllWithFilter($request->all());

        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($query->get()), 'تقرير بالطلاب عليهم أقساط.xlsx');
        }

        $courses_regs = $query->paginate(50);
        return view('reportmodule::admin.students_installment_pay', compact('courses_regs', 'branches'));
    }

    public function reportStudentsExamNotPaid(Request $request) {
        $branches = $this->branchService->findAll();
        $request['fltr_sts'] = [4, 8];

        if ($request->brnch)
            $request['branch'] = $request->brnch;

        $query = $this->courseRegService->findAllWithFilter($request->all());

        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($query->get()), 'تقرير بالطلاب عليهم رسوم الاختبار فقط.xlsx');
        }

        $courses_regs = $query->paginate(50);
        return view('reportmodule::admin.students_exam_not_paid', compact('courses_regs', 'branches'));
    }

    public function reportStudentsPaid(Request $request) {
        $branches = $this->branchService->findAll();
        $request['fltr_sts'] = [4, 6, 7];

        if ($request->brnch)
            $request['branch'] = $request->brnch;

        $query = $this->courseRegService->findAllWithFilter($request->all());

        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($query->get()), 'تقرير بالطلاب المسددين.xlsx');
        }

        $courses_regs = $query->paginate(50);
        return view('reportmodule::admin.students_paid', compact('courses_regs', 'branches'));
    }

    public function reportStudentsReciveCert(Request $request) {
        $branches = $this->branchService->findAll();
        $request['fltr_crt'] = 1;

        if ($request->brnch)
            $request['branch'] = $request->brnch;

        $query = $this->courseRegService->findAllWithFilter($request->all());

        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($query->get()), 'تقرير بالطلاب المستلمين للشهادات.xlsx');
        }

        $courses_regs = $query->paginate(50);
        return view('reportmodule::admin.students_recive_cert', compact('courses_regs', 'branches'));
    }

    public function reportStudentsNotReciveCert(Request $request) {
        $branches = $this->branchService->findAll();
        $request['fltr_crt'] = 0;

        if ($request->brnch)
            $request['branch'] = $request->brnch;

        $query = $this->courseRegService->findAllWithFilter($request->all());

        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($query->get()), 'تقرير بالطلاب الغير مستلمين للشهادات.xlsx');
        }

        $courses_regs = $query->paginate(50);
        return view('reportmodule::admin.students_not_recive_cert', compact('courses_regs', 'branches'));
    }

    public function reportStudentsLeave(Request $request) {
        $branches = $this->branchService->findAll();
        $request['fltr_leave'] = 1;

        if ($request->brnch)
            $request['branch'] = $request->brnch;

        $query = $this->courseRegService->findAllWithFilter($request->all());

        if ($request->export == 'yes') {
            return Excel::download(new CourseRegExport($query->get()), 'تقرير بالطلاب المغادرين.xlsx');
        }

        $courses_regs = $query->paginate(50);
        return view('reportmodule::admin.students_leave', compact('courses_regs', 'branches'));
    }

    /*public function reportStudentsByCompany(Request $request)
    {
        return view('reportmodule::admin.students_by_company', compact('courses_regs'));
    }*/

    public function usersLog(Request $request) {
        if ($request->export == 'yes') {
            $logs = $this->logService->findAllWithFilter($request->all())->get();
            return Excel::download(new LogExport($logs), 'تقرير بالزيارات للمستخدمين.xlsx');
        } else {
            $logs = $this->logService->findAllWithFilter($request->all())->paginate(50);
            $users = $this->userService->findAll();
            $admins = $this->adminService->findAll();
            $branches = $this->branchService->findAll();
            return view('reportmodule::admin.log_users', compact('logs', 'users', 'admins', 'branches'));
        }
    }
}
