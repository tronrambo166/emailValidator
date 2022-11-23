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

use Carbon\Carbon;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use DateTime;
use DateTimeZone;
use Mail;
use App\Models\PaymentGateway;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;


class socialController extends baseSocialController
{


    //Social Login
    public  function google(){
        $user = Socialite::driver('google')->user();
        $this->social_reg($user);

        Session::put('signup', 'Sign up success!');
        return redirect("/social-dashboard");
    }


    public  function facebook(){ 
        $user = Socialite::driver('facebook')->user();dd($user);
        //$this->social_reg($user); 
          Session::has('patient_email');
        
        return redirect('patient_dashboard')->with('success', "You are registered!"); 
         }
         
    

    //Social Login

    //PATIENTS

    public function social_reg($hos)
    {     
          $name=$hos->name;
          $break_name=explode(' ',$name);
          $mail=$hos->email; if($mail=='') $mail=uniqid().'sample@sample.com';
          $image=$hos->avatar;
          //$password=Hash::make($hos->password);            

        $check = User::where("email", $mail)->first();

        if ($check) {
        Session::put('social_login', $mail);
       
        return redirect("/social-dashboard");
        }

        $workspace = new Workspace();
        $workspace->name = $break_name[0] . "'s workspace";
        $workspace->save();

        $user = new User();

       // $password = Hash::make($request->password);

        //$user->password = $password;

        $user->first_name =  $name;
        $user->last_name = '-';

        $user->email = $mail;
        $user->facebook = 1;

        $user->workspace_id = $workspace->id;



        $user->save();

        $workspace->owner_id = $user->id;
        $workspace->save();

        //Mail::to($user)->send(new WelcomeEmail($user));
        Session::put('social_login', $mail);
        redirect("/social-dashboard");
}


 public function dashboard()
    {    //return $user = DB::table('users')->where('email', 'tronrambo166@gmail.com')->first(); 
         //parent::__construct();

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
