<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use \App\Models\User;
use App\Mail\VerifyNewMail;

class ProfileController extends Controller{

  public function __construct(){
      $this->middleware(['auth','verified']);
  }

  public function index(){
    return view('user.profile.index', [
        'user' => Auth::user()
    ]);
  }

  public function updateProfile(Request $request){
    $v = Validator::make($request->all(), [
      'email' => 'required|email|unique:users,email,'. \Auth::user()->id,
      'password' => 'confirmed',
      'image' => 'mimes:png,jpg,jpeg|max:2048'
    ]);
    if ($v->fails()){
      return redirect()->back()->withErrors($v->errors())->withInput();
    }else{
      $data = [];

      if($request->file('image')) {
          $fileName = time().'_'.$request->file('image')->getClientOriginalName();
          $request->file('image')->move(public_path('uploads/user_image'), $fileName);
          $data['image'] = 'uploads/user_image/'.$fileName;
      }
      if($request->input('email') !== \Auth::user()->email){
        $data['to_update_email'] = $request->input('email');
        $signed_url = '';
        $signed_url = URL::temporarySignedRoute(
            'verify.newmail', now()->addMinutes(60), ['id' => \Auth::user()->id]
        );
        \Mail::to($request->input('email'))->send(new VerifyNewMail(\Auth::user(), $signed_url));
      }
      if($request->input('name')){
        $data['name'] = $request->input('name');
      }
      if($request->input('password')){
        $data['password'] = Hash::make($request->input('password'));
      }
      if($data){
        User::where('id', \Auth::user()->id)->update($data);
        if(isset($data['to_update_email']) && !empty($data['to_update_email'])){
          return redirect()->back()->with(['status' => 'Profile updated successfully. Please verify email to update, verification link will be valid for 60 minutes']);
        }else{
          return redirect()->back()->with(['status' => __('user.success_notify')]);
        }
      }else{
        return redirect()->back()->with(['status' => __('user.failure_notify')]);
      }
    }
  }

  public function verifyNewMail(Request $request, $id){
    if ($request->hasValidSignature()) {
      $message;
      $user = User::find($id);
      if($user){
        if($user->to_update_email){
          User::where('id', $id)->update([
            'email' => $user->to_update_email,
            'to_update_email' => '',
          ]);
          $message = 'Email updated successfully';
        }else{
          $message = 'Looks like your email is already verified';
        }
      }
      return view('user.profile.verify-new-email', [
          'message' => $message
      ]);
    }
  }

  public function account(){
    return view('user.account', [
        'user' => Auth::user()
    ]);
  }

  public function updateAccount(Request $request){
    $v = Validator::make($request->all(), [
      'username' => 'required|unique:users,username,'. \Auth::user()->id
    ]);
    if ($v->fails()){
      return redirect()->back()->withErrors($v->errors())->withInput();
    }else{
      $data = [];
      if($request->input('username') !== \Auth::user()->username){
        $data['username'] = $request->input('username');
      }

      if($data){
        User::where('id', \Auth::user()->id)->update($data);
        return redirect()->back()->with(['status' => __('account.success_notify')]);
      }else{
        return redirect()->back()->with(['status' => __('account.failure_notify')]);
      }
    }
  }

  public function deleteAccount(Request $request){
    if($request->isJson()){
      User::find(\Auth::user()->id)->forceDelete();
      return response()->json([
        'success' => true,
        'url' => url('/register')
      ]);
    }
  }

}
