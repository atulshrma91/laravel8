<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\TranslationLoader\LanguageLine;
use Illuminate\Support\Str;

class TranslationController extends Controller{

  public function __construct(){
      $this->middleware(['auth','verified']);
  }

  public function login(){
    $loginTranslations = LanguageLine::where('group', '=', 'login')->get();
    $translationArr = [];
    if (!$loginTranslations->isEmpty()) {
      foreach($loginTranslations as $translation){
        $translationArr[$translation->key] = $translation->text;
      }
    }
    return view('translations.authentication.login', [
        'translations' => $translationArr
    ]);
  }

  public function saveLoginTranslations(Request $request){
    $v = Validator::make($request->all(), [
      'translations' => 'required|array'
    ]);
    if ($v->fails()){
      return redirect()->back()->withErrors($v->errors())->withInput();
    }else{
      foreach($request->input('translations') as $key => $translation){
        $loginTranslation = LanguageLine::where('group', '=', 'login')->where('key', '=', $key)->first();
        if($loginTranslation){
          LanguageLine::where('id', $loginTranslation->id)->update([
            'text' => $translation,
          ]);
        }else{
          LanguageLine::create([
           'group' => 'login',
           'key' => $key,
           'text' => $translation,
          ]);
        }
      }
      \Artisan::call('cache:clear');
      return redirect()->back()->with(['status' => 'Login page translations saved successfully']);
    }
  }

  public function forgotPassword(){
    $loginTranslations = LanguageLine::where('group', '=', 'forgot_password')->get();
    $translationArr = [];
    if (!$loginTranslations->isEmpty()) {
      foreach($loginTranslations as $translation){
        $translationArr[$translation->key] = $translation->text;
      }
    }
    return view('translations.authentication.forgot_password', [
        'translations' => $translationArr
    ]);
  }

  public function saveForgotPassword(Request $request){
    $v = Validator::make($request->all(), [
      'translations' => 'required|array'
    ]);
    if ($v->fails()){
      return redirect()->back()->withErrors($v->errors())->withInput();
    }else{
      foreach($request->input('translations') as $key => $translation){
        $loginTranslation = LanguageLine::where('group', '=', 'forgot_password')->where('key', '=', $key)->first();
        if($loginTranslation){
          LanguageLine::where('id', $loginTranslation->id)->update([
            'text' => $translation,
          ]);
        }else{
          LanguageLine::create([
           'group' => 'forgot_password',
           'key' => $key,
           'text' => $translation,
          ]);
        }
      }
      \Artisan::call('cache:clear');
      return redirect()->back()->with(['status' => 'Forgot password page translations saved successfully']);
    }
  }

  public function register(){
    $loginTranslations = LanguageLine::where('group', '=', 'register')->get();
    $translationArr = [];
    if (!$loginTranslations->isEmpty()) {
      foreach($loginTranslations as $translation){
        $translationArr[$translation->key] = $translation->text;
      }
    }
    return view('translations.authentication.register', [
        'translations' => $translationArr
    ]);
  }

  public function saveRegister(Request $request){
    $v = Validator::make($request->all(), [
      'translations' => 'required|array'
    ]);
    if ($v->fails()){
      return redirect()->back()->withErrors($v->errors())->withInput();
    }else{
      foreach($request->input('translations') as $key => $translation){
        $loginTranslation = LanguageLine::where('group', '=', 'register')->where('key', '=', $key)->first();
        if($loginTranslation){
          LanguageLine::where('id', $loginTranslation->id)->update([
            'text' => $translation,
          ]);
        }else{
          LanguageLine::create([
           'group' => 'register',
           'key' => $key,
           'text' => $translation,
          ]);
        }
      }
      \Artisan::call('cache:clear');
      return redirect()->back()->with(['status' => 'Register page translations saved successfully']);
    }
  }

  public function verifyEmail(){
    $mailTranslations = LanguageLine::where('group', '=', 'verifyemail')->get();
    $translationArr = [];
    if (!$mailTranslations->isEmpty()) {
      foreach($mailTranslations as $translation){
        $translationArr[$translation->key] = $translation->text;
      }
    }
    return view('translations.mails.verifyemail', [
        'translations' => $translationArr
    ]);
  }

  public function saveVerifyEmail(Request $request){
    $v = Validator::make($request->all(), [
      'translations' => 'required|array'
    ]);
    if ($v->fails()){
      return redirect()->back()->withErrors($v->errors())->withInput();
    }else{
      foreach($request->input('translations') as $key => $translation){
        $mailTranslation = LanguageLine::where('group', '=', 'verifyemail')->where('key', '=', $key)->first();
        if($mailTranslation){
          LanguageLine::where('id', $mailTranslation->id)->update([
            'text' => $translation,
          ]);
        }else{
          LanguageLine::create([
           'group' => 'verifyemail',
           'key' => $key,
           'text' => $translation,
          ]);
        }
      }
      \Artisan::call('cache:clear');
      return redirect()->back()->with(['status' => 'Verify email translations saved successfully']);
    }
  }

  public function previewVerifyEmail(){
    $message = (new \App\Notifications\VerifyEmail(\Auth::user()->id, Str::random(10)))->toMail(\Auth::user());
    return $message->render();
  }

  public function forgotPasswordEmail(){
    $mailTranslations = LanguageLine::where('group', '=', 'forgotpassword')->get();
    $translationArr = [];
    if (!$mailTranslations->isEmpty()) {
      foreach($mailTranslations as $translation){
        $translationArr[$translation->key] = $translation->text;
      }
    }
    return view('translations.mails.forgotpassword', [
        'translations' => $translationArr
    ]);
  }

  public function saveForgotPasswordEmail(Request $request){
    $v = Validator::make($request->all(), [
      'translations' => 'required|array'
    ]);
    if ($v->fails()){
      return redirect()->back()->withErrors($v->errors())->withInput();
    }else{
      foreach($request->input('translations') as $key => $translation){
        $mailTranslation = LanguageLine::where('group', '=', 'forgotpassword')->where('key', '=', $key)->first();
        if($mailTranslation){
          LanguageLine::where('id', $mailTranslation->id)->update([
            'text' => $translation,
          ]);
        }else{
          LanguageLine::create([
           'group' => 'forgotpassword',
           'key' => $key,
           'text' => $translation,
          ]);
        }
      }
      \Artisan::call('cache:clear');
      return redirect()->back()->with(['status' => 'Forgot password email translations saved successfully']);
    }
  }

  public function previewForgotPasswordEmail(){
    $message = (new \App\Notifications\MailResetPasswordNotification(Str::random(10)))->toMail(\Auth::user());
    return $message->render();
  }

  public function termsConditions(){
    $pageTranslations = LanguageLine::where('group', '=', 'termsconditions')->get();
    $translationArr = [];
    if (!$pageTranslations->isEmpty()) {
      foreach($pageTranslations as $translation){
        $translationArr[$translation->key] = $translation->text;
      }
    }
    return view('translations.page.termsconditions', [
        'translations' => $translationArr
    ]);
  }

  public function saveTermsConditions(Request $request){
    $v = Validator::make($request->all(), [
      'translations' => 'required|array'
    ]);
    if ($v->fails()){
      return redirect()->back()->withErrors($v->errors())->withInput();
    }else{
      foreach($request->input('translations') as $key => $translation){
        $mailTranslation = LanguageLine::where('group', '=', 'termsconditions')->where('key', '=', $key)->first();
        if($mailTranslation){
          LanguageLine::where('id', $mailTranslation->id)->update([
            'text' => $translation,
          ]);
        }else{
          LanguageLine::create([
           'group' => 'termsconditions',
           'key' => $key,
           'text' => $translation,
          ]);
        }
      }
      \Artisan::call('cache:clear');
      return redirect()->back()->with(['status' => 'Terms & conditions translations saved successfully']);
    }
  }

  public function menuItems(){
    $pageTranslations = LanguageLine::where('group', '=', 'menuitems')->get();
    $translationArr = [];
    if (!$pageTranslations->isEmpty()) {
      foreach($pageTranslations as $translation){
        $translationArr[$translation->key] = $translation->text;
      }
    }
    return view('translations.page.menuitems', [
        'translations' => $translationArr
    ]);
  }

  public function saveMenuItems(Request $request){
    $v = Validator::make($request->all(), [
      'translations' => 'required|array'
    ]);
    if ($v->fails()){
      return redirect()->back()->withErrors($v->errors())->withInput();
    }else{
      foreach($request->input('translations') as $key => $translation){
        $pageTranslation = LanguageLine::where('group', '=', 'menuitems')->where('key', '=', $key)->first();
        if($pageTranslation){
          LanguageLine::where('id', $pageTranslation->id)->update([
            'text' => $translation,
          ]);
        }else{
          LanguageLine::create([
           'group' => 'menuitems',
           'key' => $key,
           'text' => $translation,
          ]);
        }
      }
      \Artisan::call('cache:clear');
      return redirect()->back()->with(['status' => 'Menu translations saved successfully']);
    }
  }

  public function account(){
    $pageTranslations = LanguageLine::where('group', '=', 'account')->get();
    $translationArr = [];
    if (!$pageTranslations->isEmpty()) {
      foreach($pageTranslations as $translation){
        $translationArr[$translation->key] = $translation->text;
      }
    }
    return view('translations.page.account', [
        'translations' => $translationArr
    ]);
  }

  public function saveAccount(Request $request){
    $v = Validator::make($request->all(), [
      'translations' => 'required|array'
    ]);
    if ($v->fails()){
      return redirect()->back()->withErrors($v->errors())->withInput();
    }else{
      foreach($request->input('translations') as $key => $translation){
        $pageTranslation = LanguageLine::where('group', '=', 'account')->where('key', '=', $key)->first();
        if($pageTranslation){
          LanguageLine::where('id', $pageTranslation->id)->update([
            'text' => $translation,
          ]);
        }else{
          LanguageLine::create([
           'group' => 'account',
           'key' => $key,
           'text' => $translation,
          ]);
        }
      }
      \Artisan::call('cache:clear');
      return redirect()->back()->with(['status' => 'Account translations saved successfully']);
    }
  }

  public function user(){
    $pageTranslations = LanguageLine::where('group', '=', 'user')->get();
    $translationArr = [];
    if (!$pageTranslations->isEmpty()) {
      foreach($pageTranslations as $translation){
        $translationArr[$translation->key] = $translation->text;
      }
    }
    return view('translations.page.user', [
        'translations' => $translationArr
    ]);
  }

  public function saveUser(Request $request){
    $v = Validator::make($request->all(), [
      'translations' => 'required|array'
    ]);
    if ($v->fails()){
      return redirect()->back()->withErrors($v->errors())->withInput();
    }else{
      foreach($request->input('translations') as $key => $translation){
        $pageTranslation = LanguageLine::where('group', '=', 'user')->where('key', '=', $key)->first();
        if($pageTranslation){
          LanguageLine::where('id', $pageTranslation->id)->update([
            'text' => $translation,
          ]);
        }else{
          LanguageLine::create([
           'group' => 'user',
           'key' => $key,
           'text' => $translation,
          ]);
        }
      }
      \Artisan::call('cache:clear');
      return redirect()->back()->with(['status' => 'User translations saved successfully']);
    }
  }

  public function dashboard(){
    $pageTranslations = LanguageLine::where('group', '=', 'dashboard')->get();
    $translationArr = [];
    if (!$pageTranslations->isEmpty()) {
      foreach($pageTranslations as $translation){
        $translationArr[$translation->key] = $translation->text;
      }
    }
    return view('translations.page.dashboard', [
        'translations' => $translationArr
    ]);
  }

  public function saveDashboard(Request $request){
    $v = Validator::make($request->all(), [
      'translations' => 'required|array'
    ]);
    if ($v->fails()){
      return redirect()->back()->withErrors($v->errors())->withInput();
    }else{
      foreach($request->input('translations') as $key => $translation){
        $pageTranslation = LanguageLine::where('group', '=', 'dashboard')->where('key', '=', $key)->first();
        if($pageTranslation){
          LanguageLine::where('id', $pageTranslation->id)->update([
            'text' => $translation,
          ]);
        }else{
          LanguageLine::create([
           'group' => 'dashboard',
           'key' => $key,
           'text' => $translation,
          ]);
        }
      }
      \Artisan::call('cache:clear');
      return redirect()->back()->with(['status' => 'Dashboard translations saved successfully']);
    }
  }

  public function accountsExt(){
    $pageTranslations = LanguageLine::where('group', '=', 'accounts')->get();
    $translationArr = [];
    if (!$pageTranslations->isEmpty()) {
      foreach($pageTranslations as $translation){
        $translationArr[$translation->key] = $translation->text;
      }
    }
    return view('translations.page.accounts', [
        'translations' => $translationArr
    ]);
  }


  public function saveAccountsExt(Request $request){
    $v = Validator::make($request->all(), [
      'translations' => 'required|array'
    ]);
    if ($v->fails()){
      return redirect()->back()->withErrors($v->errors())->withInput();
    }else{
      foreach($request->input('translations') as $key => $translation){
        $pageTranslation = LanguageLine::where('group', '=', 'accounts')->where('key', '=', $key)->first();
        if($pageTranslation){
          LanguageLine::where('id', $pageTranslation->id)->update([
            'text' => $translation,
          ]);
        }else{
          LanguageLine::create([
           'group' => 'accounts',
           'key' => $key,
           'text' => $translation,
          ]);
        }
      }
      \Artisan::call('cache:clear');
      return redirect()->back()->with(['status' => 'Accounts translations saved successfully']);
    }
  }

  public function dealsExt(){
    $pageTranslations = LanguageLine::where('group', '=', 'deals')->get();
    $translationArr = [];
    if (!$pageTranslations->isEmpty()) {
      foreach($pageTranslations as $translation){
        $translationArr[$translation->key] = $translation->text;
      }
    }
    return view('translations.page.deals', [
        'translations' => $translationArr
    ]);
  }


  public function saveDealsExt(Request $request){
    $v = Validator::make($request->all(), [
      'translations' => 'required|array'
    ]);
    if ($v->fails()){
      return redirect()->back()->withErrors($v->errors())->withInput();
    }else{
      foreach($request->input('translations') as $key => $translation){
        $pageTranslation = LanguageLine::where('group', '=', 'deals')->where('key', '=', $key)->first();
        if($pageTranslation){
          LanguageLine::where('id', $pageTranslation->id)->update([
            'text' => $translation,
          ]);
        }else{
          LanguageLine::create([
           'group' => 'deals',
           'key' => $key,
           'text' => $translation,
          ]);
        }
      }
      \Artisan::call('cache:clear');
      return redirect()->back()->with(['status' => 'Deals translations saved successfully']);
    }
  }

}
