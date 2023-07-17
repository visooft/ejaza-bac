<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ImagesTrait;
use App\Models\Roles;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    use ImagesTrait;
    private $userModel, $roleModel, $dbModel, $carbonModel, $strModel, $mailModel;
    public function __construct(User $user, Roles $role, Str $str, Mail $mail, DB $db, Carbon $carbon)
    {
        $this->roleModel = $role;
        $this->userModel = $user;
        $this->strModel = $str;
        $this->dbModel = $db;
        $this->mailModel = $mail;
        $this->carbonModel = $carbon;
    }

    public function loginPage()
    {
        return view('Admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $userData = $request->only('email', 'password');
        $user = $this->userModel::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', __('dashboard.wrong_email'));
        }
        if ($user->status != 1) {
            return back()->with('error', __('dashboard.administration'));
        } else {
            if (auth()->attempt($userData)) {

                return redirect(route('admin'));
            } else {
                return back()->with('error', __('dashboard.wrong_email'));
            }
        }
    }
    public function updateToken(Request $request)
    {
        try {
            $request->user()->update(['device_token' => $request->token]);
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'success' => false
            ], 500);
        }
    }
    public function showForgetPasswordForm()
    {
        return view('Admin.auth.forgetPassword');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = $this->strModel::random(64);

        $this->dbModel::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => $this->carbonModel::now()
        ]);

        $this->mailModel::send('Admin.auth.email', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        $email = $request->email;
        return view('Admin.auth.message', compact('email'));
    }

    public function showResetPasswordForm($token)
    {
        return view('Admin.auth.forgetPasswordLink', compact('token'));
    }

    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => [
                'required',
                'string',
                'confirmed', Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ],

            'password_confirmation' => 'required'
        ]);

        $updatePassword = $this->dbModel::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if (!$updatePassword) {
            return back()->withInput()->with('error', __('dashboard.code'));
        }

        $user = $this->userModel::where('email', $request->email)
            ->update(['password' => bcrypt($request->password)]);

        $this->dbModel::table('password_resets')->where(['email' => $request->email])->delete();

        return redirect('/login')->with('message', __('dashboard.changePassword'));
    }
    public function logout()
    {
        auth()->logout();
        session()->flush();
        return redirect(route('loginPage'));
    }

    public function MentanecMode()
    {
        $MentanecMode = Setting::where('key', 'mentance_mode')->first();
        $MentanecMode_value = Setting::where('key', 'mentance_mode_value')->first();

        return view('errors.mentance', compact('MentanecMode', 'MentanecMode_value'));
    }
}
