<?php

namespace App\Http\Controllers;

use App\Models\BusinessModel;
use App\Models\BusinessPlan;
use App\Models\Calendar;
use App\Models\Goal;
use App\Models\GoalPlan;
use App\Models\Setting;
use App\Models\ToLearn;
use App\Models\WeeklyPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlansController extends BaseController
{
    public function calendarAction(Request $request, $action = "")
    {
        if ($this->modules && !in_array("calendar", $this->modules)) {
            abort(401);
        }

        switch ($action) {
            case "":
                $events = Calendar::where(
                    "workspace_id",
                    $this->user->workspace_id
                )->get();

                return \view("plans.calendar", [
                    "selected_navigation" => "calendar",
                    "events" => $events,
                ]);
                break;

            case "event":
                $request->validate([
                    "id" => "nullable|integer",
                ]);

                $event = false;

                if ($request->id) {
                    $event = Calendar::where(
                        "workspace_id",
                        $this->user->workspace_id
                    )
                        ->where("id", $request->id)
                        ->first();
                }

                if ($event) {
                    $date = $event->start_date;
                } else {
                    $date = $request->date ?? date("Y-m-d");
                }

                return \view("plans.event", [
                    "selected_navigation" => "calendar",
                    "event" => $event,
                    "date" => $date,
                ]);
                break;
        }
    }

    public function eventPost(Request $request)
    {
        if ($this->modules && !in_array("calendar", $this->modules)) {
            abort(401);
        }
        $request->validate([
            "title" => "required|max:150",
            "id" => "nullable|integer",
        ]);

        $event = false;

        if ($request->id) {
            $event = Calendar::where("workspace_id", $this->user->workspace_id)
                ->where("id", $request->id)
                ->first();
        }

        if (!$event) {
            $event = new Calendar();
            $event->uuid = Str::uuid();
            $event->workspace_id = $this->user->workspace_id;
        }

        $event->title = $request->title;

        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->description = $request->description;
        $event->save();

        return redirect("/calendar");
    }

    public function businessPlans()
    {
        if ($this->modules && !in_array("business_plan", $this->modules)) {
            abort(401);
        }

        $plans = BusinessPlan::where(
            "workspace_id",
            $this->user->workspace_id
        )->get();

        return \view("plans.business-plans", [
            "selected_navigation" => "business-plans",
            "plans" => $plans,
        ]);
    }
    public function writeBusinessPlans(Request $request)
    {
        if ($this->modules && !in_array("business_plan", $this->modules)) {
            abort(401);
        }

        $plan = false;


        if ($request->id) {
            $plan = BusinessPlan::where(
                "workspace_id",
                $this->user->workspace_id
            )
                ->where("id", $request->id)
                ->first();
        }

        return \view("plans.write-business-plan", [
            "selected_navigation" => "business-plans",
            "plan" => $plan,
        ]);
    }

    public function viewBusinessPlan(Request $request)
    {
        if ($this->modules && !in_array("business_plan", $this->modules)) {
            abort(401);
        }

        $plan = false;

        if ($request->id) {
            $plan = BusinessPlan::where(
                "workspace_id",
                $this->user->workspace_id
            )
                ->where("id", $request->id)
                ->first();
        }

        return \view("plans.view-business-plan", [
            "selected_navigation" => "business-plans",
            "plan" => $plan,
        ]);
    }

    public function businessPlanPost(Request $request)
    {
        $request->validate([
            "company_name" => "required|max:150",
            "name" => "required|max:150",
            "id" => "nullable|integer",
            "logo" => "nullable|file|mimes:jpg,png",

        ]);

        $plan = false;

        if ($request->id) {
            $plan = BusinessPlan::where(
                "workspace_id",
                $this->user->workspace_id
            )
                ->where("id", $request->id)
                ->first();
        }

        if (!$plan) {
            $plan = new BusinessPlan();
            $plan->uuid = Str::uuid();
            $plan->workspace_id = $this->user->workspace_id;
        }

        $plan->name = $request->name;
        $path = null;
        if ($request->logo) {
            $path = $request->file("logo")->store("media", "uploads");

        }
        if (!empty($path)) {
            $plan->logo = $path;
        }

        $plan->date = $request->date;
        $plan->email = $request->email;
        $plan->phone = $request->phone;
        $plan->website = $request->website;
        $plan->company_name = $request->company_name;
        $plan->ex_summary = clean($request->ex_summary);
        $plan->description = clean($request->description);
        $plan->m_analysis = clean($request->m_analysis);
        $plan->management = clean($request->management);
        $plan->product = clean($request->product);
        $plan->marketing = clean($request->marketing);
        $plan->budget = $request->budget;
        $plan->investment = clean($request->investment);
        $plan->finance = clean($request->finance);
        $plan->appendix = clean($request->appendix);
        $plan->save();

        return redirect("/business-plans");
    }

    public function businessModel(Request $request)
    {
        if ($this->modules && !in_array("business_model", $this->modules)) {
            abort(401);
        }

        $model = false;

        if ($request->id) {
            $model = BusinessModel::where(
                "workspace_id",
                $this->user->workspace_id
            )
                ->where("id", $request->id)
                ->first();
        }

        return \view("business-model.design-business-model", [
            "selected_navigation" => "business-models",
            "model" => $model,
        ]);
    }

    public function businessModels()
    {
        if ($this->modules && !in_array("business_model", $this->modules)) {
            abort(401);
        }

        $models = BusinessModel::where(
            "workspace_id",
            $this->user->workspace_id
        )->get();

        return \view("business-model.business-models", [
            "selected_navigation" => "business-models",
            "models" => $models,
        ]);
    }

    public function businessModelPost(Request $request)
    {
        $request->validate([
            "company_name" => "required|max:150",
            "id" => "nullable|integer",
        ]);

        $model = false;

        if ($request->id) {
            $model = BusinessModel::where(
                "workspace_id",
                $this->user->workspace_id
            )
                ->where("id", $request->id)
                ->first();
        }

        if (!$model) {
            $model = new BusinessModel();
            $model->uuid = Str::uuid();
            $model->workspace_id = $this->user->workspace_id;
        }

        $model->email = $request->email;
        $model->company_name = $request->company_name;
        $model->partners = clean($request->partners);
        $model->activities = clean($request->activities);
        $model->resources = clean($request->resources);
        $model->value_propositions = clean($request->value_propositions);
        $model->customer_relationships = clean(
            $request->customer_relationships
        );
        $model->channels = clean($request->channels);
        $model->customer_segments = clean($request->customer_segments);
        $model->cost_structure = clean($request->cost_structure);
        $model->revenue_stream = clean($request->revenue_stream);
        $model->save();

        return redirect("/business-models");
    }

    public function viewBusinessModel(Request $request)
    {
        if ($this->modules && !in_array("business_model", $this->modules)) {
            abort(401);
        }

        $model = false;

        if ($request->id) {
            $model = BusinessModel::where(
                "workspace_id",
                $this->user->workspace_id
            )
                ->where("id", $request->id)
                ->first();
        }

        return \view("business-model.view-model", [
            "selected_navigation" => "business-models",
            "model" => $model,
        ]);
    }
}
