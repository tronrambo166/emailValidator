<?php

use App\Http\Controllers\ActionsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DownloadController;

use App\Http\Controllers\PlansController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SwotController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\builderController;
use App\Http\Controllers\adminController;

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//BUILDER ROUTES
Route::get('/cleaner', [builderController::class, "home"])->name('/cleaner');
Route::get('/lang/change', [SuperAdminController::class, "change"])->name('changeLang');
Route::post('/clean_mail', [builderController::class, "clean_mail"])->name('/clean_mail');

Route::get('/validator', [builderController::class, "validator"])->name('/validator');
Route::get('/single_validate', [builderController::class, "single_mail"])->name('/single_mail');
Route::get('/history', [builderController::class, "history"])->name('/history');

//Internal Validate with details
Route::post('/single_validate', [builderController::class, "single_validate"])->name('/single_validate');
Route::post('/mx_check', [builderController::class, "mx_check"])->name('/mx_check');
Route::get('/mail_rep_dld/{info}/{fileName}/{type}', [builderController::class, "mail_rep_dld"])->name('mail_rep_dld');
//BUILDER ROUTES



Route::get("/super-admin/dashboard", [
    SuperAdminController::class,
    "dashboard",
]);


//*****************ADMIN ROUTES*******************/
Route::Group(['prefix' => 'admin'], function () { 
    
    Route::get('/index_admin',[adminController::class, 'index_admin'])->name('index_admin');
        Route::get('/logout','adminController@logout')->name('logout');
        Route::get('/users', [adminController::class, 'users'])->name('users');
        Route::get('/plans', [adminController::class, 'plans'])->name('plans');

        Route::get('/setting', [adminController::class, 'setting'])->name('setting');
         Route::post('/smtp_setting', [adminController::class, 'smtp_setting'])->name('smtp_setting'); 


        Route::get('/approve/{id}', [adminController::class, 'approve'])->name('approve');
        Route::get('/restrict/{id}', [adminController::class, 'restrict'])->name('restrict');
         Route::get('/del_users/{id}', [adminController::class, 'del_users'])->name('del_users');   

        
         Route::post('/update_jobs', [adminController::class, 'update_jobs'])->name('update_jobs');     
         Route::get('/job_edit-{id}-{id_asn}', [adminController::class, 'job_edit'])->name('job_edit');
         Route::get('/job_add', [adminController::class, 'job_add'])->name('job_add');
        
        Route::post('/adminLogin', [adminController::class, 'adminLogin'])->name('adminLogin');


        

    Route::get('forgot/{remail}', [adminController::class, 'forgot'])->name('forgot');
    Route::post('send_reset_email', [adminController::class, 'send_reset_email'])->name('send_reset_email');
    Route::post('reset/{remail}', [adminController::class, 'reset'])->name('reset');
  
        Route::get('/login', function () {
        return view('admin.login');
        })->name('login');
       
    });



//Unused
Route::get("/social-dashboard", 'socialController@dashboard')->name('/social-dashboard');

Route::get("/subscribe", [SubscribeController::class, "subscribe"]);
Route::post("/payment-stripe", [SubscribeController::class, "paymentStripe"])->name('/payment-stripe');
Route::get("/", [AuthController::class, "login"])->name("login");
Route::get("/login", [AuthController::class, "login"])->name("login");
Route::get("/signup", [AuthController::class, "signup"]);
Route::get("/forgot-password", [AuthController::class, "forgotPassword"]);
Route::get("/password-reset", [AuthController::class, "passwordReset"]);
Route::get("/calendar/{action?}", [PlansController::class, "calendarAction"]);
Route::get("/notes", [ActionsController::class, "notes"]);
Route::get("/swot-list", [SwotController::class, "swotList"]);
Route::get("/write-swot", [SwotController::class, "writeSwot"]);
Route::get("/view-swot", [SwotController::class, "viewSwot"]);
Route::get("/add-task", [ActionsController::class, "addTask"]);
Route::get("/add-note", [ActionsController::class, "addNote"]);
Route::get("/view-note", [ActionsController::class, "viewNote"]);
Route::get("/projects", [ProjectController::class, "projects"]);
Route::get("/create-project", [ProjectController::class, "createProject"]);
Route::get("/logout", [AuthController::class, "logout"])->name('userlogout');
Route::get("/view-project", [ProjectController::class, "projectView"]);

Route::get("/view-project-discussion", [
    ProjectController::class,
    "projectViewDiscussion",
]);
Route::get("/view-project-tasks", [
    ProjectController::class,
    "projectViewTasks",
]);
Route::get("/view-project-files", [
    ProjectController::class,
    "projectViewFiles",
]);
Route::get("/user-edit-{id}", [ProfileController::class, "userEdit"]);
Route::get("/download-{id}", [DownloadController::class, "download"]);
Route::get("/dashboard", [DashboardController::class, "dashboard"])->name('dashboard');;
Route::get("/new-user", [ProfileController::class, "newUser"]);
Route::get("/documents", [DocumentController::class, "documents"]);
Route::get("/profile", [ProfileController::class, "profile"]);
Route::get("/staff", [ProfileController::class, "staff"]);
Route::get("/settings", [SettingController::class, "settings"]);
//Route::get("/billing", [SettingController::class, "billing"]);
Route::get("/delete/{action}/{id}", [DeleteController::class, "delete"]);

Route::post("/save-reset-password", [
    AuthController::class,
    "save-reset-password",
])->name('/save-reset-password');
Route::post("/post-new-password", [AuthController::class, "newPasswordPost"])->name('/post-new-password');
Route::post("/user-change-password", [
    ProfileController::class,
    "userChangePasswordPost",
])->name('/user-change-password');
Route::post("/login", [AuthController::class, "loginPost"])->name('/login');
Route::post("/super-admin/login", [
    AuthController::class,
    "superAdminLoginPost",
])->name('/super-admin/login');
Route::post("/signup", [AuthController::class, "signupPost"])->name('/signup');

Route::post("/save-note", [ActionsController::class, "notePost"])->name('/save-note');
Route::post("/save-swot", [SwotController::class, "swotPost"])->name('/save-swot');

Route::post("/save-project", [ProjectController::class, "projectPost"])->name('/save-project');
Route::post("/save-project-message", [
    ProjectController::class,
    "projectMessagePost",
])->name('/save-project-message');

Route::post("/document", [DocumentController::class, "documentPost"])->name('/document');
Route::post("/settings", [SettingController::class, "settingsPost"])->name('/settings');
Route::post("/profile", [ProfileController::class, "profilePost"])->name('/profile');
Route::post("/save-event", [PlansController::class, "eventPost"])->name('/save-event');
Route::post("/user-post", [ProfileController::class, "userPost"])->name('/user-post');
Route::get("/business-plans", [PlansController::class, "businessPlans"])->name('/business-plans');

Route::get("/write-business-plan", [
    PlansController::class,
    "writeBusinessPlans",
]);

Route::get("/view-business-plan", [PlansController::class, "viewBusinessPlan"]);
Route::get("/view-business-model", [
    PlansController::class,
    "viewBusinessModel",
]);

Route::get("/business-models", [PlansController::class, "businessModels"]);
Route::get("/design-business-model", [PlansController::class, "businessModel"]);
Route::post("/business-plan-post", [
    PlansController::class,
    "businessPlanPost",
])->name('/business-plan-post');

Route::post("/business-model-post", [
    PlansController::class,
    "businessModelPost",
])->name('/business-model-post');

Route::prefix("admin")
    ->name("admin.")
    ->group(function () {
        Route::get("/tasks/{action}", [
            TaskController::class,
            "tasksAction",
        ])->name("tasks");
        Route::post("/tasks/{action}", [
            TaskController::class,
            "tasksSave",
        ])->name("tasks.save");

        Route::get("/task-list", [TaskController::class, "taskList"]);

        Route::get("/delete/{action}/{id}", [
            DeleteController::class,
            "delete",
        ])->name("delete");
    });


// Social Routes
 
Route::get('/google', function (){return Socialite::driver('google')->redirect(); })->name('login.google');
Route::get('google/callback','socialController@google');
 
Route::get('/facebook', function () {return Socialite::driver('facebook')->redirect(); })->name('login.facebook');
Route::get('facebook/callback', 'socialController@facebook');


// Payment Routes
Route::get('/stripe', 'stripeController@stripe');
Route::post('/stripe', 'stripeController@stripePost')->name('stripe.post');


Route::get('/refund', function(){
    return view("privacy_policy");
});

Route::get('clear_cache', function () {
    \Artisan::call('config:cache');
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');
    dd("Cache is cleared");
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    //Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');
    Route::get('/dashboard', [builderController::class, "textToEmails"])->name('dashboard');
    Route::post('/ExtractEmails', [builderController::class, "ExtractEmails"])->name('/ExtractEmails');
});
