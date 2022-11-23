<?php

namespace App\Http\Controllers;

use App\Models\BusinessModel;
use App\Models\Calendar;
use App\Models\FiveMinuteJournal;
use App\Models\Goal;
use App\Models\GoalPlan;
use App\Models\Image;
use App\Models\Note;
use App\Models\Projects;
use App\Models\Setting;
use App\Models\Task;
use App\Models\Todo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function dashboard()
    {

        $ldate = date("Y-m-d H:i:s");
        $today = Carbon::now();

        $todos = Task::orderBy("id", "desc")
            ->where("workspace_id", $this->user->workspace_id)
            ->limit(4)
            ->get();
        $recent_events = Calendar::orderBy("id", "desc")
            ->where("workspace_id", $this->user->workspace_id)
            ->limit(5)
            ->get();

        $total_notes = Note::where(
            "workspace_id",
            $this->user->workspace_id
        )->count();
        $total_projects = Projects::where(
            "workspace_id",
            $this->user->workspace_id
        )->count();
        $total_models = BusinessModel::where(
            "workspace_id",
            $this->user->workspace_id
        )->count();
        $total_users = User::where(
            "workspace_id",
            $this->user->workspace_id
        )->count();

        $recent_projects = Projects::orderBy("id", "desc")
            ->where("workspace_id", $this->user->workspace_id)
            ->limit(5)
            ->get();
        $recent_notes = Note::orderBy("id", "desc")
            ->where("workspace_id", $this->user->workspace_id)
            ->limit(5)
            ->get();
        $recent_note = Note::orderBy("id", "desc")
            ->where("workspace_id", $this->user->workspace_id)
            ->first();
        $users = User::all()
            ->keyBy("id")
            ->all();

        return \view("dashboard", [
            "selected_navigation" => "dashboard",

            "total_notes" => $total_notes,
            "total_projects" => $total_projects,
            "ldate" => $ldate,
            "today" => $today,
            "recent_projects" => $recent_projects,
            "todos" => $todos,
            "recent_events" => $recent_events,
            "recent_notes" => $recent_notes,
            "recent_note" => $recent_note,
            "total_models" => $total_models,
            "total_users" => $total_users,
            "users" => $users,
        ]);
    }
}
