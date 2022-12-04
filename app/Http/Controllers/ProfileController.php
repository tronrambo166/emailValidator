<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class ProfileController extends BaseController
{
    public function profile(Request $request)
    {
        //$available_languages = User::$available_languages;

        return \view("profile.show", [
            "selected_navigation" => "profile"
            //"available_languages" => $available_languages,
        ]);
    }

    public function profilePost(Request $request)
    {
        $request->validate([
            "first_name" => "nullable|string|max:100",
            "last_name" => "nullable|string|max:100",
            "photo" => "nullable|file|mimes:jpg,png",
            "cover_photo" => "nullable|file",
        ]);

        $user = $this->user;

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->language = $request->language;
        $path = null;
        if ($request->photo) {
            $path = $request->file("photo")->store("media", "uploads");

        }
        if (!empty($path)) {
            $user->photo = $path;
        }



        $cover_path = null;

        if ($request->cover_photo) {
            $cover_path = $request
                ->file("cover_photo")
                ->store("media", "uploads");
        }

        if (!empty($cover_path)) {
            $user->cover_photo = $cover_path;
        }

        $user->phone_number = $request->phone_number;
        $user->save();

        if ($this->user->super_admin) {
            return redirect("super-admin/super-admin-profile");
        }

        return redirect("/profile");
    }

    public function staff()
    {
        $staffs = User::where("workspace_id", $this->user->workspace_id)->get();
        $workspace = Workspace::find($this->user->workspace_id);

        $maximum_allowed_users = Workspace::getMaximumAllowedUsers($this->workspace);
        $users_count_on_this_workspace = Workspace::usersCount($this->workspace->id);
        $plan = Workspace::getPlan($this->workspace);

        return \view("profile.staff", [
            "selected_navigation" => "team",
            "staffs" => $staffs,
            'workspace' => $workspace,
            'plan' => $plan,
            'maximum_allowed_users' => $maximum_allowed_users,
            'users_count_on_this_workspace' => $users_count_on_this_workspace,
        ]);
    }

    public function newUser(Request $request)
    {

        $maximum_allowed_users = Workspace::getMaximumAllowedUsers($this->workspace);
        $users_count_on_this_workspace = Workspace::usersCount($this->workspace->id);

        if($users_count_on_this_workspace >= $maximum_allowed_users)
        {
            abort(401);
        }
        $request->validate([
            "id" => "nullable|integer",
        ]);
        $countries = countries();

        $selected_user = false;

        if ($request->id) {
            $selected_user = User::where(
                "workspace_id",
                $this->user->workspace_id
            )
                ->where("id", $request->id)
                ->first();
        }

        return \view("profile.new-user", [
            "selected_navigation" => "team",
            "selected_user" => $selected_user,
            "countries" => $countries,
        ]);
    }

    public function userPost(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:100",
            
            "email" => "required|email",
            "phone" => "nullable|string|max:50",
            "password" => "required|string|max:50",
            "id" => "nullable|integer",
        ]);

        $maximum_allowed_users = Workspace::getMaximumAllowedUsers($this->workspace);
        $users_count_on_this_workspace = Workspace::usersCount($this->workspace->id);

        //if($users_count_on_this_workspace >= $maximum_allowed_users){ abort(401); }

        $user = false;

        if ($request->id) {
            $user = User::where("workspace_id", $this->user->workspace_id)
                ->where("id", $request->id)
                ->first();
        }

        if (!$user) {
            $user = new User();
            $user->workspace_id = $this->user->workspace_id;
        }

        $user->name = $request->name;
       
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->mobile_number = $request->mobile_number;
        $user->twitter = $request->twitter;
        $user->facebook = $request->facebook;
        $user->linkedin = $request->linkedin;
        $user->address_1 = $request->address_1;
        $user->address_2 = $request->address_2;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->country = $request->country;
        $user->language = $request->language;
        $user->zip = $request->zip;
        $user->update();

        if ($this->user->super_admin) {
            return redirect("super-admin/users");
        }

        return redirect("/profile");
    }

    public function userEdit(Request $request,$id)
    {
        $selected_user = User::find($id);

        $countries = countries();

        if ($selected_user){

            if($this->user->super_admin)
            {
                return \view('super-admin.add-new-user',[
                    'selected_user'=> $selected_user,
                    'countries'=> $countries,


                ]);
            }

            return \view('profile.new-user',[
                'selected_user'=> $selected_user,
                'countries'=> $countries,


            ]);

        }

    }

    public function userChangePasswordPost(Request $request)
    {
        $request->validate([
            "password" => "required",
            "new_password" => "required|confirmed",
        ]);

        $user = $this->user;

        if (!Hash::check($request->password, $user->password)) {
            return redirect("/profile")->withErrors([
                "password" => "Incorrect old password.",
            ]);
        }

        if (config("app.environment") !== "demo") {
            $user->password = Hash::make($request->new_password);
            $user->save();
        }

        return redirect("/profile");
    }
}
