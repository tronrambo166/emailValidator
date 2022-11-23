<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\SmsProvider;
use App\Models\SubscriptionPlan;
use App\Models\Workspace;
use Doctrine\Inflector\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingController extends BaseController
{
    public function settings()
    {
        $workspace = Workspace::find($this->user->workspace_id);

        return \view("settings.settings", [
            "selected_navigation" => "settings",
            "workspace" => $workspace,
        ]);
    }

    public function settingsPost(Request $request)
    {
        $request->validate([
            "workspace_name" => "required|max:150",
            "logo" => "nullable|file|mimes:jpg,png",
            'currency' => 'nullable|string|size:3'
        ]);

        $workspace = Workspace::find($this->user->workspace_id);

        $workspace->name = $request->workspace_name;
        $workspace->save();

        Setting::updateSettings($this->workspace->id,'currency',$request->currency);

        if($request->logo)
        {
            $path = $request->file('logo')->store('media', 'uploads');
            Setting::updateSettings($this->workspace->id,'logo',$path);
        }

        if($this->user->super_admin)
        {
            $free_trial_days = $request->free_trial_days ?? 0;
            Setting::updateSettings($this->workspace->id,'free_trial_days',$free_trial_days);
            return redirect('super-admin/super-admin-setting');
        }

        return redirect("super-admin/settings");
    }

    public function billing()
    {
        $plans= SubscriptionPlan::all();

        $workspace = Workspace::find($this->user->workspace_id);

        $plan = null;

        if($workspace->plan_id)
        {
            $plan = SubscriptionPlan::find($workspace->plan_id);
        }


        return \view("settings.billing", [
            "selected_navigation" => "billing",
            "plans" => $plans,
            "plan" => $plan,
        ]);
    }
}
