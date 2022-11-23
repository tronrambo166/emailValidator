<?php

namespace App\Http\Controllers;

use App\Mail\PasswordReset;
use App\Mail\WelcomeEmail;
use App\Models\Setting;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Session;

class AuthController extends Controller
{
    //
    protected $settings;

    public function __construct()
    {
    
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect("/dashboard");
        }

        return \view("auth.login");
    }

    public function superAdminlogin()
    {
        return  \view("auth.super-admin-login");
    }

    public function passwordReset(Request $request)
    {
        $request->validate([
            "id" => "required|integer",
            "token" => "required|uuid",
        ]);

        $user = User::find($request->id);

        if (!$user) {
            return redirect("/")->withErrors([
                "key" => "Invalid user or link expired",
            ]);
        }

        if ($user->password_reset_key !== $request->token) {
            return redirect("/")->withErrors([
                "key" => "Invalid key",
            ]);
        }

        return \view("auth.reset-password", [
            "id" => $request->id,
            "password_reset_key" => $request->token,
        ]);
    }

    public function signup()
    {
        return \view("auth.signup");
    }

    public function forgotPassword()
    {
        return \view("auth.forgot-password");
    }

    public function resetPasswordPost(Request $request)
    {
        $request->validate([
            "email" => "required|email",
        ]);

        $user = User::where("email", $request->email)->first();

        if (!$user) {
            return redirect()
                ->back()
                ->withErrors([
                    "email" => "No account found with this email",
                ]);
        }

        $user->password_reset_key = Str::uuid();
        $user->save();

        Mail::to($user->email)->send(new PasswordReset($user));

        session()->flash(
            "status",
            "We sent you an email with the instruction to reset the password."
        );

        return redirect("/");
    }

    public function newPasswordPost(Request $request)
    {
        $request->validate([
            "password" => "required|confirmed",
            "id" => "required|integer",
            "password_reset_key" => "required|uuid",
        ]);

        $user = User::find($request->id);

        if (!$user) {
            return redirect()
                ->back()
                ->withErrors([
                    "email" => "No account found with this email",
                ]);
        }

        if ($user->password_reset_key !== $request->password_reset_key) {
            return redirect()
                ->back()
                ->withErrors([
                    "key" => "Invalid key",
                ]);
        }

        $user->password = Hash::make($request->password);

        $user->password_reset_key = null;

        $user->save();

        session()->flash(
            "status",
            "Your password has been reset, login with the new password."
        );

        return redirect("/");
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $check = User::where("email", $request->email)->first();
        
        if($check && $check['facebook'] == 1){
         
            }


        $remember = false;

        if($request->remember)
        {
            $remember = true;
        }

        if (Auth::attempt($credentials, $remember)) {
            $user = User::where('workspace_id',$request->email)->first();
            if($user)
            {
                $workspace = Workspace::find($user->workspace_id);
                if($workspace && $workspace->id != 1 && !$workspace->plan_id)
                {
                    $super_admin_settings = Setting::getSuperAdminSettings();
                    if(!empty($super_admin_settings['free_trial_days']))
                    {
                        $free_trial_days = $super_admin_settings['free_trial_days'];
                        $free_trial_days = (int) $free_trial_days;
                        $workspace_creation_date = $workspace->created_at;
                        $trial_will_expire = strtotime($workspace_creation_date) + ($free_trial_days*24*60*60);
                        if($trial_will_expire < time())
                        {
                            return back()->withErrors([
                                'trial_expired' => __('Your trial has been expired.'),
                            ]);
                        }
                    }
                }
            }
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function superAdminAuthenticate(Request $request)
    {
        $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"],
        ]);

        $user = User::where("email", $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                "email" => __("User not found!"),
            ]);
        }

        if (!$user->super_admin) {
            return back()->withErrors([
                "email" => __("Invalid user."),
            ]);
        }

        if (Hash::check($request->password, $user->password)) {
            Auth::login($user, true);
            $request->session()->regenerate();
            Session::put('super_admin','true');

            return redirect( "/super-admin/dashboard");
        }

        return back()->withErrors([
            "email" => __("Invalid user."),
        ]);
    }

    public function signupPost(Request $request)
    {
        $request->validate([
            "email" => ["required", "email"],
            "first_name" => ["required"],
            "last_name" => ["required"],
            "password" => ["required"],
        ]);

        $check = User::where("email", $request->email)->first();

        if ($check) {
            return back()->withErrors([
                "email" => "User already exist",
            ]);
        }

        $workspace = new Workspace();
        $workspace->name = $request->first_name . "'s workspace";
        $workspace->save();

        $user = new User();

        $password = Hash::make($request->password);

        $user->password = $password;

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;

        $user->email = $request->input("email");

        $user->workspace_id = $workspace->id;



        $user->save();

        $workspace->owner_id = $user->id;
        $workspace->save();

        //Mail::to($user)->send(new WelcomeEmail($user));
        Session::put('signup', 'Sign up success!');
        return redirect(config("app.url") . "/login");
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect("/");
    }
}
