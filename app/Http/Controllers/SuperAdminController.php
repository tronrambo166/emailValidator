<?php

namespace App\Http\Controllers;

use App\Models\GoalPlan;
use App\Models\Newsletter;
use App\Models\PaymentGateway;
use App\Models\Setting;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App;


class SuperAdminController extends SuperAdminBaseController
{

     public function change(Request $request)
    {
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);
  
        return redirect()->back();
    }


    public function dashboard()
    {

        $current_build_id = config('app.build_id',1);
        $installed_build_id = $this->settings['installed_build_id'] ?? 0;

        if($current_build_id != $installed_build_id)
        {
           return redirect('/super-admin/update-schema');
        }

        $total_users = User::count();
        $total_workspaces = Workspace::count();
        $total_plans = SubscriptionPlan::count();

        $recent_workspaces = Workspace::orderBy("id", "desc")
            ->limit(5)
            ->get();
        $recent_users = User::orderBy("id", "desc")
            ->limit(5)
            ->get();
        $recent_plans = SubscriptionPlan::orderBy("id", "desc")
            ->limit(5)
            ->get();


        $workspaces = Workspace::all()
            ->keyBy("id")
            ->all();
        $plans = SubscriptionPlan::all()
            ->keyBy("id")
            ->all();


        return \view("super-admin-dashboard", [
            "selected_navigation" => "sdashboard",
            "total_users" => $total_users,
            "total_workspaces" => $total_workspaces,
            "recent_workspaces" => $recent_workspaces,
            "recent_users" => $recent_users,
            "recent_plans" => $recent_plans,
            "total_plans" => $total_plans,
            "workspaces" => $workspaces,
            "plans" => $plans,
        ]);
    }

    public function updateSchema()
    {
        $current_build_id = config('app.build_id',1);
        if(!Schema::hasColumn('workspaces','owner_id'))
        {
            Schema::table('workspaces', function (Blueprint $table)
            {
                $table->unsignedInteger('owner_id')->default(0);
            });
            Schema::table('business_plans', function (Blueprint $table)
            {
                $table->string('logo')->nullable();
            });
            Schema::table('subscription_plans', function (Blueprint $table)
            {
                $table->unsignedInteger('maximum_allowed_users')->default(0);
            });
        }

        $setting = Setting::where('workspace_id',$this->user->workspace_id)
            ->where('key','installed_build_id')
            ->first();
        if(!$setting)
        {
            $setting = new Setting();
            $setting->workspace_id = $this->user->workspace_id;
            $setting->key = 'installed_build_id';
        }

        $setting->value = $current_build_id;
        $setting->save();


        return redirect('/super-admin/dashboard');
    }

    public function users()
    {
        $users = User::all();

        $workspaces = Workspace::all()
            ->keyBy("id")
            ->all();

        return \view("super-admin.users", [
            "selected_navigation" => "users",
            "users" => $users,
            "workspaces" => $workspaces,
        ]);
    }
    public function workspaces()
    {
        $users = User::all();

        $workspaces = Workspace::all()
            ->keyBy("id")
            ->all();
        $plans = SubscriptionPlan::all()
            ->keyBy("id")
            ->all();

        return \view("super-admin.workspaces", [
            "selected_navigation" => "workspaces",
            "users" => $users,
            "workspaces" => $workspaces,
            "plans" => $plans,
        ]);
    }


    public function saveWorkspace(Request $request)
    {
        $request->validate([
            "id" => "nullable|integer",
        ]);

        $workspace = false;

        if ($request->id) {
            $workspace = Workspace::find($request->id);
        }

        $workspace->name = $request->name;
        $workspace->plan_id = $request->plan_id;
        if($request->plan_id)
        {
            $workspace->subscribed = 1;
        }
        else{
            $workspace->subscribed = 0;
        }
        if($request->next_renewal_date)
        {
            $workspace->next_renewal_date = $request->next_renewal_date;
        }
        $workspace->save();

        return redirect("super-admin/workspaces");
    }


    public function editWorkspace(Request $request)
    {
        $users = User::all();
        $plans = SubscriptionPlan::all()
            ->keyBy("id")
            ->all();


        $workspaces = Workspace::all()
            ->keyBy("id")
            ->all();
        $workspace =false;

        if ($request->id) {
            $workspace = Workspace::find($request->id);
        }

        return \view("super-admin.edit-workspaces", [
            "selected_navigation" => "workspaces",
            "users" => $users,
            "workspaces" => $workspaces,
            "workspace" => $workspace,
            "plans" => $plans,
        ]);
    }




    public function saasPlans()
    {
        $plans = SubscriptionPlan::all();

        return \view("super-admin.plans", [
            "selected_navigation" => "saas-plans",
            "plans" => $plans,
        ]);
    }
    public function createSaasPlan(Request $request)
    {
        $plan= false;
        $plan_modules = [];
        $features = [];
        if($request->id)
        {
            $plan = SubscriptionPlan::find($request->id);
            if($plan)
            {
                if($plan->modules)
                {
                    $plan_modules = json_decode($plan->modules);
                }
                if($plan->features)
                {
                    $features = json_decode($plan->features);
                }

            }
        }


        $available_modules = SubscriptionPlan::availableModules();

        return \view("super-admin.create-plan", [
            "selected_navigation" => "saas-plans",
            "plan" => $plan,
            "available_modules" => $available_modules,
            "plan_modules" => $plan_modules,
            "features" =>  $features,
        ]);
    }
    public function subscriptionPlanPost(Request $request)
    {
        $request->validate([
            "name" => "required|max:150",
            "id" => "nullable|integer",
            "features" => "nullable|array",
        ]);

        $plan = false;

        if ($request->id) {
            $plan = SubscriptionPlan::find($request->id);
        }

        if (!$plan) {
            $plan = new SubscriptionPlan();
        }

        $plan->name = $request->name;

        $plan->price_yearly = $request->price_yearly;
        $plan->price_monthly = $request->price_monthly;
        $plan->maximum_allowed_users = $request->maximum_allowed_users;
        $plan->description = $this->clean($request->description);

        $features = [];

       /* foreach ($request->features as $feature) {
            if (!empty($feature)) {
                $features[] = $feature;
            }
        }
        if (!empty($features)) {
            $plan->features = json_encode($features);
        } */

        $modules = null;

        $available_modules = SubscriptionPlan::availableModules();

        foreach ($available_modules as $key => $value) {
            if ($request->$key) {
                $modules[] = $key;
            }
        }

        if ($modules) {
            $plan->modules = json_encode($modules);
        }

        $plan->save();

        return redirect("super-admin/subscription-plans");
    }

    public function clean($string){
        return $string = str_replace("'","''",$string);
    }

    public function userProfile(Request $request)
    {
        $skit_user  = false;
        $skit_user_workspace = false;
        $plan = false;

        if($request->id)
        {
            $skit_user = User::find($request->id);

            $skit_user_workspace = Workspace::find($skit_user->workspace_id);

            // if(  $skit_user_workspace->plan_id)
            // {
            //     $plan = SubscriptionPlan::find( $skit_user_workspace->plan_id);
            // }


        }


        return \view("super-admin.user-profile", [
            "selected_navigation" => "users",
            "layout" => "super-admin-portal",
            "skit_user" => $skit_user ,
            "skit_user_workspace"=>  $skit_user_workspace,
            //"plan"=> $plan,
        ]);
    }
    public function addUser(Request $request)
    {
        $focus_user = false;

        if ($request->id) {
            $focus_user = User::find($request->id);
        }

        return \view("super-admin.add-new-user", [
            "selected_navigation" => "users",

            "layout" => "super-admin-portal",
            "focus_user" => $focus_user,
        ]);
    }
    public function adminProfile(Request $request)
    {
        //$available_languages = User::$available_languages;
        $workspace = Workspace::find($this->user->workspace_id);

        return \view("profile.profile", [
            "selected_navigation" => "profile",
            "layout" => "super-admin-portal",
            "available_languages" => ['en','es'],
            "workspace" => $workspace,
        ]);
    }

    public function adminSetting(Request $request)
    {
        $workspace = Workspace::find($this->user->workspace_id);

        return \view("settings.settings", [
            "selected_navigation" => "settings",
            "layout" => "super-admin-portal",
            "workspace" => $workspace,
        ]);
    }

    public function paymentGateways()
    {
        $users = User::all();
        $payment_gateways = PaymentGateway::all()
            ->keyBy("api_name")
            ->all();

        return \view("super-admin.payment-gateways", [
            "selected_navigation" => "payment-gateways",
            "users" => $users,
            "payment_gateways" => $payment_gateways,
        ]);
    }

    public function configurePaymentGateway(Request $request)
    {
        $request->validate([
            "api_name" => "required|string",
        ]);

        $api_name = $request->api_name;
        $gateway = PaymentGateway::where("api_name", $api_name)->first();

        return \view("super-admin.configure-payment-gateway", [
            "selected_navigation" => "payment-gateways",
            "gateway" => $gateway,
            "api_name" => $api_name,
        ]);
    }

    public function configurePaymentGatewayPost(Request $request)
    {
        $payment_gateway = PaymentGateway::where("api_name", "stripe")->first();

        if (!$payment_gateway) {
            $payment_gateway = new PaymentGateway();
            $payment_gateway->name = "Stripe";
            $payment_gateway->api_name = "stripe";
        }

        $payment_gateway->public_key = $request->public_key;
        $payment_gateway->private_key = $request->private_key;
        $payment_gateway->save();

        return redirect("super-admin/payment-gateways");
    }

    public function deleteWorkspace($id)
    {
        $workspace = Workspace::find($id);

        if ($workspace) {
            if ($this->workspace->id === $workspace->id) {
                return redirect("super-admin/workspaces");
            }

            $workspace->delete();
            return redirect("super-admin/workspaces");
        }
    }
    public function deleteUser($id)
    {
        $user = User::find($id);

        if ($user) {
            if ($this->user->id === $user->id) {
                return redirect("super-admin/users");
            }

            $user->delete();
            return redirect("super-admin/users");
        }
    }
    public function newsletterEmail()
    {
        $emails = Newsletter::all();

        $workspaces = Workspace::all()
            ->keyBy("id")
            ->all();

        return \view("super-admin.newsletter", [
            "selected_navigation" => "emails",
            "emails" => $emails,
            "workspaces" => $workspaces,
        ]);
    }
}
