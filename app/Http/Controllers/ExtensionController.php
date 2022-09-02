<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;
use \App\Models\User;
use \App\Models\DealSource;
use \App\Models\Extension;
use \App\Models\UserExtension;
use \App\Models\Category;
use \App\Models\DealCategories;
use Carbon\Carbon;

class ExtensionController extends Controller{

  private $stripe;
  public function __construct(){
      $this->middleware(['auth','verified']);
      $this->stripe = new \Stripe\StripeClient(env("STRIPE_SECRET_KEY"));
  }

  public function index(){
    $payment_methods_data = [];
    $extensions = Extension::with(array('UserExtension' => function($query) {
      $query->where('user_id', '=', \Auth::user()->id);
    }))->get();
    $is_checkout_allowed = UserExtension::where('user_id', '=', \Auth::user()->id)->where(function ($query) {
        $query->where('is_expired', '=', 1)
              ->orWhere('extension_expiry', '<=', date('Y-m-d'));
    })->first();

    if(Auth::user()->customer_uuid){
      $payment_methods = $this->stripe->paymentMethods->all([
        'customer' => Auth::user()->customer_uuid,
        'type' => 'card',
      ]);
      $payment_methods_data = ($payment_methods)?$payment_methods->data:[];
    }
    return view('extensions.index',[
      'extensions' => $extensions,
      'is_checkout_allowed' => $is_checkout_allowed,
      'payment_methods' => $payment_methods_data
    ]);
  }

  public function accountSettings(Request $reuest){
    return view('extensions.settings.accounts');
  }

  public function dealSettings(Request $reuest){
    $deal_sources = DealSource::where(['user_id' => \Auth::user()->id])->get();
    $categories = DealCategories::where(['user_id' => \Auth::user()->id])->get();
    return view('extensions.settings.deals',[
      'deal_sources' => $deal_sources,
      'categories' => $categories
    ]);
  }

  public function addDealCategories(Request $request){
    $v = Validator::make($request->all(), [
      'name' => 'required|unique:deal_categories',
      'color_code' => 'required',
    ]);
    if ($v->fails()){
      return redirect()->back()->withErrors($v->errors())->withInput();
    }else{
      $dealSourceData = [
        'user_id' => \Auth::user()->id,
        'name' => $request->input('name'),
        'color_code' => $request->input('color_code'),
      ];
      $dealSource = DealCategories::create($dealSourceData);
      return redirect()->route('extensions.deals.settings')->with(['status' => 'Category created successfully']);
    }
  }

  public function updateDealCategories(Request $request){
      foreach($request->input('categories') as $ck => $category){
        DealCategories::where('id', $ck)->update(['name' => $category['name'], 'color_code' => $category['color_code']]);
      }
      return response()->json([
        'success' => true
      ]);
  }

  public function deleteDealCategories(Request $request, $id){
    if($request->isJson()){
      DealCategories::find($id)->delete();
      return response()->json([
        'success' => true,
        'url' => route('extensions.deals.settings')
      ]);
    }
  }

  public function addDealSettingsSources(Request $request){
    $v = Validator::make($request->all(), [
      'name' => 'required|unique:deal_sources'
    ]);
    if ($v->fails()){
      return redirect()->back()->withErrors($v->errors())->withInput();
    }else{
      $dealSourceData = [
        'user_id' => \Auth::user()->id,
        'name' => $request->input('name')
      ];
      $dealSource = DealSource::create($dealSourceData);
      return redirect()->route('extensions.deals.settings')->with(['status' => 'Deal heading created successfully']);
    }
  }

  public function updateDealSettingsSources(Request $request, $id){
    if($request->isJson()){
      DealSource::where('id', $id)->update(['name' => $request->input('name')]);
      return response()->json([
        'success' => true
      ]);
    }
  }

  public function deleteDealSettingsSources(Request $request, $id){
    if($request->isJson()){
      DealSource::find($id)->delete();
      return response()->json([
        'success' => true,
        'url' => route('extensions.deals.settings')
      ]);
    }
  }

  public function updateExtensionStatus(Request $request){
    if($request->isJson()){
      $extension = Extension::find($request->input('extension_id'));
      if(\Auth::user()->hasExtension($extension->slug)){
        $user_extension = UserExtension::where(['extension_id' => $request->input('extension_id'), 'user_id' => \Auth::user()->id])->first();
        if($user_extension && !$user_extension->is_expired){
          UserExtension::where(['extension_id' => $request->input('extension_id'), 'user_id' => \Auth::user()->id])->update(['status' => $request->input('status')]);
          return response()->json([
            'success' => true,
            'url' => url('extensions')
          ]);
        }else{
          return response()->json([
            'success' => false,
          ]);
        }
      }else{
        return response()->json([
          'success' => false,
        ]);
      }
    }
  }

  public function formsSettings(Request $reuest){

    return view('extensions.settings.forms');
  }


  public function categoriesSettings(Request $reuest){
    $categories = Category::where(['user_id' => \Auth::user()->id])->get();
    return view('extensions.settings.categories',[
      'categories' => $categories
    ]);
  }

  public function addCategories(Request $request){
    $v = Validator::make($request->all(), [
      'name' => 'required|unique:categories',
      'color_code' => 'required',
    ]);
    if ($v->fails()){
      return redirect()->back()->withErrors($v->errors())->withInput();
    }else{
      $dealSourceData = [
        'user_id' => \Auth::user()->id,
        'name' => $request->input('name'),
        'color_code' => $request->input('color_code'),
      ];
      $dealSource = Category::create($dealSourceData);
      return redirect()->route('extensions.categories.settings')->with(['status' => 'Category created successfully']);
    }
  }

  public function updateCategories(Request $request){
      foreach($request->input('categories') as $ck => $category){
        Category::where('id', $ck)->update(['name' => $category['name'], 'color_code' => $category['color_code']]);
      }
      return response()->json([
        'success' => true
      ]);
  }

  public function deleteCategories(Request $request, $id){
    if($request->isJson()){
      Category::find($id)->delete();
      return response()->json([
        'success' => true,
        'url' => route('extensions.categories.settings')
      ]);
    }
  }

  public function getCheckoutPrice(Request $request){
    if($request->isJson()){
      $price = 0;
      if(is_array($request->input('user_extension')) && !empty($request->input('user_extension'))){
        foreach($request->input('user_extension') as $user_extension){
          $userExtension = UserExtension::with(['Extension'])->find($user_extension);
          $price += $userExtension->Extension->price;
        }
      }
      return response()->json([
        'success' => true,
        'checkout_price' => $price
      ]);
    }
  }

  public function deletePaymentMethod(Request $request){
    if($request->isJson()){
      $this->stripe->paymentMethods->detach(
        $request->input('id'),
        []
      );
      sleep(2);
      return response()->json([
        'success' => true
      ]);
    }
  }

}
