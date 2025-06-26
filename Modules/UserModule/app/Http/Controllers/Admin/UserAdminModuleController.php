<?php

namespace Modules\UserModule\app\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\BranchModule\Services\BranchService;
use Modules\PermissionModule\Services\PermissionService;
use Modules\UserModule\Services\UserService;

class UserAdminModuleController extends Controller
{

    private $userService;
    private $branchService;
    private $permissionService;

    public function __construct(UserService $userService, BranchService $branchService, PermissionService $permissionService)
    {
        $this->userService = $userService;
        $this->branchService = $branchService;
        $this->permissionService = $permissionService;
    }

    public function loginForm()
    {
        if (Auth::guard('user')->check()) {

            return redirect()->route('user.dashboard');
        } else {
            return view('usermodule::admin.login');
        }
    }

    public function index()
    {
        if (Auth::guard('user')->check()) {
            return view('usermodule::admin.dashboard');
        } else {
            return redirect('user/login');
        }
    }

    public function login(Request $request)
    {
        if (auth('user')->attempt(
            [
                'email' => $request->email,
                'password' => $request->password,
            ],

        )) {

            return redirect()->route('user.dashboard');
        }
        return redirect()->back()->withErrors(['error' => 'error in password or email']);
    }

    public function listOfUsers()
    {
        $users = $this->userService->findAll();
        return view('usermodule::admin.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $branches = $this->branchService->findAll();
        return view('usermodule::admin.create', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:4|',
            ],
            [
                'email.required' => 'البريد الإلكتروني مطلوب',
                'email.unique' => 'البريد الإلكتروني موجود بالفعل',
                'email.email' => 'البريد الإلكتروني غير صالح',
                'password.min' => 'كلمة المرور يجب ان لا تقل عن 4 ارقام',
                'password.required' => 'كلمة المرور مطلوبه',
                'name.required' => 'الاسم مطلوب',

            ]
        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $this->userService->create($request);

        return redirect()->route(Auth::getDefaultDriver() . '.users.list')
            ->with('success', __('messages.successfully_saved'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $user = $this->userService->findOne($id);
        $branches = $this->branchService->findAll();
        $permissions = $this->permissionService->findAll()->sortByDesc('id');
        return view('usermodule::admin.edit', compact('user', 'branches', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',

            ],
            [
                'email.required' => 'البريد الإلكتروني مطلوب',
                'email.unique' => 'البريد الإلكتروني موجود بالفعل',
                'email.email' => 'البريد الإلكتروني غير صالح',
                'name.required' => 'الاسم مطلوب',
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $user = $this->userService->update($request->all());

        return redirect()->route(Auth::getDefaultDriver() . '.users.list')
            ->with('success', 'Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->userService->deleteOne($id);
        return redirect()->route(Auth::getDefaultDriver() . '.users.list')->with('success', 'deleted Successfully.');
    }

    public function logout(Request $request)
    {
        Auth::guard('user')->logout();
        return redirect()->to('user');
    }
}
