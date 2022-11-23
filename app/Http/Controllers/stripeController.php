<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Stripe;
use App\Models\PaymentGateway;
use App\Models\SubscriptionPlan;
use App\Models\Workspace;
use Session;

class stripeController extends BaseController
{
     /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe');
    }
   
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
         $request->validate([
            "plan_id" => "required|integer",
            "term" => "required|string",
            
        ]);

        $plan = SubscriptionPlan::find($request->plan_id);
       if($plan){
        $next_renewal_date = date("Y-m-d");
            if ($request->term === "monthly") {
                $amount = $plan->price_monthly;
                $next_renewal_date = date("Y-m-d", strtotime("+1 month"));
            } elseif ($request->term === "yearly") {
                $amount = $plan->price_yearly;
                $next_renewal_date = date("Y-m-d", strtotime("+1 year"));
            } else {
                abort(401);
            }

            $gateway = PaymentGateway::where("api_name", "stripe")->first();

            if (!$gateway) {
                abort(401);
            }
        }
        else return "Plan don't exist";


        //STRIPE
         $curr='USD'; //$request->currency; 
         $price=$amount; //Session::get('amount'); 
          //$amount=($price*100);
           $amount=round($price);

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([ 

                //"billing_address_collection": null,
                "amount" => $amount*100, //100 * 100,
                "currency" => $curr,
                "source" => $request->stripeToken,
                "description" => "This payment is tested purpose phpcodingstuff.com"
        ]);
   
   //STRIPE

// DB update/insert
           $workspace = Workspace::find($this->user->workspace_id);

                $workspace->subscribed = 1;
                $workspace->plan_id = $request->plan_id;
                $workspace->term = $request->term;
                $workspace->subscription_start_date = date("Y-m-d");
                $workspace->next_renewal_date = $next_renewal_date;
                $workspace->price = $amount;
                $workspace->trial = 0;
                $workspace->save();

// DB update/insert

      Session::put('plan_name',$plan->name);
       return redirect("/billing")->with(
                    "status",
                    "Subscribed successfully!"
                );
       // return redirect('/dashboard')->with('stripe_paid', "Payment Collected! You are subscribed!");
           
        //return back();
    }
}
