<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use \App\Models\User;
use \App\Models\Extension;
use \App\Models\UserExtension;
use \App\Models\UserTransaction;

use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use DateTime;


class PaymentController extends Controller
{

  private $stripe;
  private $stripe_customer_id;
  public function __construct(){
    $this->middleware(['auth','verified'], ['except' => ['paymentWebhook']]);
    $this->stripe = new \Stripe\StripeClient(env("STRIPE_SECRET_KEY"));
    $this->is_sandbox = true;
  }

  public function payment(Request $request){
    try {
      $v = Validator::make($request->all(), [
        'user_extension_id' => 'required'
      ]);
      if ($v->fails()){
        return response()->json([
          'success' => false,
          'error' => $v->errors(),
          'message' => $v->errors()->first()
        ], 200);
      }else{
        $stripe_customer = $this->get_stripe_customer_id($request->input('payment_method_id'));
        if($stripe_customer){
          $this->stripe_customer_id = $stripe_customer->id;
          $subscriptionID = $this->create_subscription($request->input('user_extension_id'));
          sleep(3);
          return response()->json([
            'success' => true,
            'subscriptionID' => $subscriptionID,
            'message' => 'Purchase successfull',
          ], 200);
        }else{
          return response()->json([
            'success' => false,
            'error' => '',
            'message' => 'Error fetching customer details'
          ], 400);
        }
      }

    } catch (\Exception $e) {
        return response()->json([
          'success' => false,
          'error' => $e->getMessage(),
          'message' => $e->getMessage()
        ], 200);
    }
  }

  public function get_stripe_customer_id($payment_method_id = ''){
    $customer;
    if($payment_method_id){
      if(!Auth::user()->customer_uuid){
        $customer = $this->stripe->customers->create([
          'email' => Auth::user()->email,
          'name' => Auth::user()->name,
          'payment_method' => $payment_method_id,
          'invoice_settings' => array(
            'default_payment_method' => $payment_method_id
          )
        ]);
        User::where('id', \Auth::user()->id)->update(['customer_uuid' => $customer->id]);
      }else{
        $paymentMethod = $this->stripe->paymentMethods->retrieve(
          $payment_method_id,
          []
        );
        $this->stripe->paymentMethods->attach(
          $paymentMethod->id,
          ['customer' => Auth::user()->customer_uuid]
        );
        $this->stripe->customers->update(
          Auth::user()->customer_uuid,[
            'invoice_settings' => array(
            'default_payment_method' => $paymentMethod->id
          )]
        );
        $customer = $this->stripe->customers->retrieve(
          Auth::user()->customer_uuid,
          []
        );
      }
    }else{
      if(Auth::user()->customer_uuid){
        $customer = $this->stripe->customers->retrieve(
          Auth::user()->customer_uuid,
          []
        );
      }
    }
    return $customer;
  }

  public function create_subscription($user_extension_ids){
    $plan_ids = $this->get_all_plans();
    $subscription_items = $this->get_subscribtion_plan($user_extension_ids, $plan_ids);
    $subscription = $this->stripe->subscriptions->create([
      'customer' => $this->stripe_customer_id,
      'items' => $subscription_items,
      'off_session' => true,
      'metadata' => array(
        'extension_ids' => $user_extension_ids
      )
    ]);
    return $subscription->id;
  }

  public function get_all_plans(){
    $allplans = $this->stripe->plans->all(['limit' => 100]);
    $plan_ids = [];
    foreach ($allplans->data as $plandata) {
        $plan_ids[] = $plandata->id;
    }
    return $plan_ids;
  }

  public function get_subscribtion_plan($user_extension_ids, $plan_ids){
    $subscription_items = [];
    foreach(explode(',', $user_extension_ids) as $user_extension){
      $userExtension = UserExtension::with(['Extension'])->find($user_extension);
      $plan_id = $userExtension->Extension->slug.'_'.$userExtension->Extension->id.'_'.number_format($userExtension->Extension->price);
      if(!in_array($plan_id, $plan_ids)){
        $this->create_new_plan($plan_id, $userExtension);
      }
      $subscription_items[] = array('plan'=>$plan_id);
    }
    return $subscription_items;
  }

  public function create_new_plan($plan_id, $userExtension){
    $plan = $this->stripe->plans->create([
      'amount' => $userExtension->Extension->price*100,
      'currency' => 'usd',
      'interval' => 'month',
      'interval_count' => 1,
      'product' => array(
        'name' => $userExtension->Extension->name
      ),
      'id' => $plan_id,
      'metadata' => array(
        'ext_id' => $userExtension->Extension->id,
        'plan_name' => $userExtension->Extension->name
      )
    ]);
    return $plan->id;
  }

  public function paymentWebhook(Request $request){
    Log::debug('Stripe Webhook response');
    Log::debug($request->getContent());
    $event = json_decode($request->getContent());
    Log::debug(print_r($event, true));
    if(is_object($event) && property_exists($event, 'type')){
      if($event->type == 'invoice.payment_succeeded'){
        $subscription_id = $event->data->object->subscription;
    		$customer_id = $event->data->object->customer;
        $charge_id = $event->data->object->charge;
        try{
          $customer = $this->stripe->customers->retrieve(
            $customer_id,
            []
          );
          $price = 0;
          $extensionArr = [];
          foreach ($event->data->object->lines->data as $subscription_prod) {
            if($subscription_prod->type == 'subscription'){
              $user_extension_ids = $subscription_prod->metadata->extension_ids;
              $extension_id = $subscription_prod->plan->metadata->ext_id;
              $extensionArr[] = $extension_id;
              $user = User::where('customer_uuid', $customer_id)->first();
              $userExtension = UserExtension::with(['Extension'])->where('user_id', $user->id)->where('extension_id', $extension_id)->first();
              Log::debug('Stripe Webhook user_extension_ids '.$user_extension_ids);
              $price += $userExtension->Extension->price;
              UserExtension::where('id', $userExtension->id)->update([
                'on_trial' => false,
                'is_expired' => false,
                'status' => true,
                'extension_payment_id' => $subscription_id,
                'extension_expiry' => date('Y-m-d H:i:s', strtotime("+30 days"))
              ]);
            }
          }
          $userTransaction = UserTransaction::create([
            'user_extension_id' => implode(',', $extensionArr),
            'order_id' => $charge_id,
            'gateway_id' => $subscription_id,
            'type' => 'subscription',
            'amount' => $price,
            'currency' => 'USD',
            'accepted' => true
          ]);
        } catch (\Exception $e) {
          Log::debug('Stripe Webhook Error '.$e->getMessage());
        }
      }
      http_response_code(200);
    }
  }

}
