<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\SubscriptionPlan;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{
    protected $settings;
    protected $super_settings;
    protected $user;
    protected $workspace;
    protected $modules;
    public function __construct()
    {
        parent::__construct();
        $this->middleware("auth");

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            $this->workspace = Workspace::find($this->user->workspace_id);

            $settings_data = Setting::where(
                "workspace_id",
                $this->user->workspace_id
            )->get();
            $settings = [];

            foreach ($settings_data as $setting) {
                $settings[$setting->key] = $setting->value;
            }
            $this->settings = $settings;
            $super_settings = [];

            $super_settings_data = Setting::where('workspace_id',1)->get();
            foreach ($super_settings_data as $super_setting)
            {
                $super_settings[$super_setting->key] = $super_setting->value;
            }

            $this->super_settings = $super_settings;
            View::share("settings", $settings);
            View::share("super_settings", $super_settings);
            View::share("user", $this->user);
            View::share("workspace", $this->workspace);

            $this->modules = null;

            if ($this->workspace->plan_id) {
                $plan = SubscriptionPlan::find($this->workspace->plan_id);
                if ($plan && $plan->modules) {
                    $this->modules = json_decode($plan->modules);
                }
            }

            $language = $this->user->language ?? "en";

            \App::setLocale($language);

            View::share("modules", $this->modules);

            return $next($request);
        });
    }
}
