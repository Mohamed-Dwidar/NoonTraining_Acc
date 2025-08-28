<?php


namespace Modules\UserModule\app\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\LogModule\Services\LogService;
use Modules\UserModule\Services\UserService;

class UserAuthController extends Controller
{
    private $userService;
    private $logService;

    public function __construct(UserService $userService, LogService $logService)
    {
        $this->userService = $userService;
        $this->logService = $logService;
    }

    public function loginForm()
    {
        if (Auth::guard('user')->check()) {
            // $user = Auth::guard('user')->user();
            // //Add Log
            // $action = 'تسجيل دخول';
            // $description = 'تم تسجيل الدخول بواسطة المستخدم ' . $user->name;
            // $this->logService->recordLog($action, $description, $user->id, null, 'Modules\\UserModule\\app\\Http\\Models\\User');
            return redirect()->route('user.courses');
        } else {
            return view('usermodule::login');
        }
    }

    function login(Request $request)
    {
        $rememberme = request()->has('rememberme') ? 1 : 0;
        if (auth('user')->attempt(
            [
                'email' => $request->email,
                'password' => $request->password
            ],
            $rememberme
        )) {
            $user = auth('user')->user();
            //Add Log
            $action = 'تسجيل دخول';
            $description = 'تم تسجيل الدخول بواسطة المستخدم ' . $user->name;
            $this->logService->recordLog($action, $description, $user->id, $user->id, get_class($user));
            return redirect()->intended('user');
        }
        return redirect()->back()->withErrors(['error' => 'البريد الأليكتروني او كلمة المرور ']);
    }

    public function changePassword()
    {
        $user = auth()->guard('user')->user();
        return view('usermodule::user.change_password', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'old_password' => 'required',
                'password' => 'required|confirmed|min:4',
            ]
        );
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $user = auth()->guard('user')->user();
        $request['id'] = $user->id;
        if (Hash::check($request->old_password, $user->password)) {
            $this->userService->updatePassword($request);

            return redirect()->route(Auth::getDefaultDriver() . '.changePassword')
                ->with('success', 'تم تغيير كلمة المرور بنجاح');
        } else {
            return back()
                ->withErrors(['كلمة المرو القديمة غير صحيحة'])
                ->withInput();
        }
    }

    function logout(Request $request)
    {
        Auth::guard('user')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->to('user');
    }
}
