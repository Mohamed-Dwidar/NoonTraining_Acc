<?php

namespace Modules\SettingModule\app\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\LogModule\Services\LogService;
use Modules\SettingModule\Services\RegByEmployeeService;

class RegByEmployeeAdminController extends Controller
{
    private $regByEmployeeService;
    private $logService;

    public function __construct(RegByEmployeeService $regByEmployeeService, LogService $logService)
    {
        $this->regByEmployeeService = $regByEmployeeService;
        $this->logService = $logService;
    }

    public function index()
    {
        $employees = $this->regByEmployeeService->findAll();
        return view('settingmodule::admin.reg_by_employees.index', compact('employees'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255', Rule::unique('reg_by_employees', 'name')->whereNull('deleted_at')],
        ], [
            'name.required' => 'يجب ادخال الاسم',
            'name.max' => 'الاسم طويل جدا',
            'name.unique' => 'الاسم موجود بالفعل',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $employee = $this->regByEmployeeService->create($request);

        $this->logService->recordLog('اضافة اسم في تم التسجيل عن طريق', 'تم اضافة : ' . $employee->name, url()->current());

        return redirect()->route('admin.settings.reg_by_employees')->with('success', 'تم الاضافه بنجاح.');
    }

    public function edit($id)
    {
        $employee = $this->regByEmployeeService->findOne($id);
        if (!$employee) {
            return redirect()->route('admin.settings.reg_by_employees')->withErrors('الاسم غير موجود');
        }
        return view('settingmodule::admin.reg_by_employees.edit', compact('employee'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => ['required', 'max:255', Rule::unique('reg_by_employees', 'name')->ignore($request->id)->whereNull('deleted_at')],
        ], [
            'name.required' => 'يجب ادخال الاسم',
            'name.max' => 'الاسم طويل جدا',
            'name.unique' => 'الاسم موجود بالفعل',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if (!$this->regByEmployeeService->findOne($request->id)) {
            return redirect()->route('admin.settings.reg_by_employees')->withErrors('الاسم غير موجود');
        }

        $employee = $this->regByEmployeeService->update($request);

        $this->logService->recordLog('تعديل اسم في تم التسجيل عن طريق', 'تم تعديل : ' . $employee->name, url()->current());

        return redirect()->route('admin.settings.reg_by_employees')->with('success', 'تم التعديل بنجاح.');
    }

    public function destroy(Request $request)
    {
        $employee = $this->regByEmployeeService->findOne($request->id);
        if (!$employee) {
            return redirect()->route('admin.settings.reg_by_employees')->withErrors('الاسم غير موجود');
        }

        $this->regByEmployeeService->deleteOne($employee->id);

        $this->logService->recordLog('حذف اسم من تم التسجيل عن طريق', 'تم حذف : ' . $employee->name, url()->current());

        return redirect()->route('admin.settings.reg_by_employees')->with('success', 'تم الحذف بنجاح.');
    }
}
