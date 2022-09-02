<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use \App\Models\User;
use \App\Models\Extension;
use \App\Models\UserExtension;
use Carbon\Carbon;


class AuthController extends Controller{

    public function __construct(){
        $this->middleware('guest')->except(['logout', 'verifyEmail', 'verifyUser', 'setLocale', 'termsConditions', 'resendVerificationEmail']);
    }

    public function login(){
      return view('auth.login');
    }

    public function authenticate(Request $request){
      $v = Validator::make($request->all(), [
        'email' => 'required|email|max:255',
        'password' => 'required',
      ]);
      if ($v->fails()){
        return redirect()->back()->withErrors($v->errors())->withInput();
      }else{
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials, $request->input('remember'))) {
          if (is_null(\Auth::user()->last_login)) {
             return redirect('/extensions');
          }else{
            \Auth::user()->update([
                'last_login' => Carbon::now()->toDateTimeString()
            ]);
            return redirect()->intended('login');
          }
        }else{
          return redirect()->back()->withErrors([__('login.validation_message')])->withInput();
        }
      }
    }

    public function register(){
      return view('auth.register');
    }

    public function createUser(Request $request){
      $v = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email|unique:users|max:255',
        'password' => 'required|confirmed|min:6',
      ]);
      if ($v->fails()){
        return redirect()->back()->withErrors($v->errors())->withInput();
      }else{
        $userData = [
          'name' => $request->input('name'),
          'email' => $request->input('email'),
          'username' => Str::random(10),
          'password' => Hash::make($request->input('password'))
        ];
        $user = \App\Models\User::create($userData);
        $user->assignRole('member');
        $this->createUserExtensionAccess($user->id);
        event(new Registered($user));
        return redirect()->route('login')->with(['status' => __('register.validation_message',['email' => $request->input('email')])]);
      }
    }

    public function logout(Request $request){
      if(\Cookie::has('superAdminId')){
        \Cookie::queue(\Cookie::forget('superAdminId'));
      }
      Auth::logout();
      return redirect('/login');
    }

    public function verifyEmail(Request $request){
      return $request->user()->hasVerifiedEmail()
        ? redirect('/extensions')
        : view('auth.verify-email');
    }

    public function verifyUser(EmailVerificationRequest $request) {
        $request->fulfill();
        \Auth::user()->update([
            'last_login' => Carbon::now()->toDateTimeString()
        ]);
        return redirect('/extensions');
    }

    public function forgotPassword() {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __('forgot_password.validation_message')]);
    }

    public function resetPassword($token) {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();

                $user->setRememberToken(Str::random(60));

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => __($status)]);
    }

    public function setLocale($locale){
      if (!in_array($locale, ['en', 'da'])) {
          return redirect()->back();
      }
      \Cookie::queue(\Cookie::make('locale', $locale));
      return redirect()->back();
    }

    public function termsConditions(Request $request){
      return view('termsconditions');
    }

    public function resendVerificationEmail(Request $request) {
      $request->user()->sendEmailVerificationNotification();
      $response = array(
          'status' => 'success',
          'msg' => 'verification-link-sent',
      );
      return response()->json($response);
    }

    public function createUserExtensionAccess($user_id){
       $extensions = Extension::all();
       if(!$extensions->isEmpty()){
         foreach($extensions as $extension){
           $extensionData = [
             'user_id' => $user_id,
             'extension_id' => $extension->id,
             'on_trial' => true,
             'trial_expiry_days' => 30,
             'extension_expiry' => date('Y-m-d', strtotime('+30 days')),
             'status' => false,
           ];
           UserExtension::create($extensionData);
         }
       }
    }
}
