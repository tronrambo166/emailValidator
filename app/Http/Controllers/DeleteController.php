<?php

namespace App\Http\Controllers;

use App\Models\Audience;
use App\Models\BusinessModel;
use App\Models\BusinessPlan;
use App\Models\Calendar;
use App\Models\Contact;
use App\Models\Document;
use App\Models\EmailCampaign;
use App\Models\FiveMinuteJournal;
use App\Models\Goal;
use App\Models\GoalPlan;
use App\Models\Image;
use App\Models\LeadCaptureForm;
use App\Models\Newsletter;
use App\Models\Note;
use App\Models\Projects;
use App\Models\SmsCampaign;
use App\Models\SmsProvider;
use App\Models\EmailProvider;
use App\Models\SubscriptionPlan;
use App\Models\SwotAnalysis;
use App\Models\Task;
use App\Models\Todo;
use App\Models\ToLearn;
use App\Models\User;
use App\Models\WeeklyPlan;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeleteController extends BaseController
{
    //
    public function delete($action, $id)
    {
        switch ($action) {
            case "event":
                $event = Calendar::where(
                    "workspace_id",
                    $this->user->workspace_id
                )
                    ->where("id", $id)
                    ->first();
                if ($event) {
                    $event->delete();
                    return redirect("/calendar");
                }

                break;

            case "note":
                $note = Note::where("workspace_id", $this->user->workspace_id)
                    ->where("id", $id)
                    ->first();
                if ($note) {
                    $note->delete();
                    return redirect("/notes");
                }

                break;

            case "project":
                $project = Projects::where(
                    "workspace_id",
                    $this->user->workspace_id
                )
                    ->where("id", $id)
                    ->first();
                if ($project) {
                    $project->delete();
                    return redirect("/projects");
                }

                break;

            case "staff":

                $workspace = Workspace::find($this->user->workspace_id);
                $staff = User::where("workspace_id", $this->user->workspace_id)
                    ->where("id", $id)
                    ->first();

                if ($staff) {
                    if(!$workspace->owner_id || $staff->id != $workspace->owner_id ){
                        if ($staff->id === $this->user->id) {
                            abort(401);
                        }

                        $staff->delete();

                        return redirect("/staff");
                    }
                }

                break;

            case "document":
                $document = Document::where(
                    "workspace_id",
                    $this->user->workspace_id
                )
                    ->where("id", $id)
                    ->first();
                if ($document) {
                    if (Storage::exists("public/" . $document->path)) {
                        Storage::delete("public/" . $document->path);
                    }

                    $document->delete();

                    return redirect("/documents");
                }

                break;

            case "subscription-plan":
                $plan = SubscriptionPlan::find($id);

                if ($plan) {
                    $plan->delete();
                    return redirect("super-admin/subscription-plans");
                }

                break;

            case "business-plan":
                $plan = BusinessPlan::where(
                    "workspace_id",
                    $this->user->workspace_id
                )
                    ->where("id", $id)
                    ->first();
                if ($plan) {
                    $plan->delete();
                    return redirect("/business-plans");
                }

                break;
            case "business-model":
                $model = BusinessModel::where(
                    "workspace_id",
                    $this->user->workspace_id
                )
                    ->where("id", $id)
                    ->first();
                if ($model) {
                    $model->delete();
                    return redirect("/business-models");
                }

                break;

            case "swot":
                $model = SwotAnalysis::where(
                    "workspace_id",
                    $this->user->workspace_id
                )
                    ->where("id", $id)
                    ->first();
                if ($model) {
                    $model->delete();
                    return redirect("/swot-list");
                }

                break;

            case "task":
                $task = Task::where("workspace_id", $this->user->workspace_id)
                    ->where("id", $id)
                    ->first();
                if ($task) {
                    $task->delete();
                    return redirect("/admin/tasks/list");
                }

                break;
        }
    }
}
