@extends('layouts.app')

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">g_translate</i>
            </div>
            <h4 class="card-title">Login <a href="javascript:;" class="text-primary pull-right">{{url('/login')}}</a></h4>

          </div>
          <div class="card-body">

            @if ($errors->any())
              <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <i class="material-icons">close</i>
                </button>
                @foreach ($errors->all() as $error)
                    <span>{{ $error }}</span>
                @endforeach
             </div>
             <p class="card-description text-center">&nbsp;</p>
            @endif

            @if (session()->has('status'))
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="material-icons">close</i>
              </button>
              @if(is_array(session('status')))
                  @foreach (session('status') as $message)
                      <span>{{ $message }}</span>
                  @endforeach
              @else
                  <span>{{ session('status') }}</span>
              @endif
             </div>
             <p class="card-description text-center">&nbsp;</p>
            @endif

            <form method="POST" id="translationsLogin" action="{{url('/translations/authentication/login')}}">
              @csrf
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <h5> English</h5>
                  </div>
                  <div class="form-group">
                    <label for="heading_en" class="bmd-label-floating"> Heading</label>
                    <input class="form-control" type="text" name="translations[heading][en]" required="true" aria-required="true" value="{{array_key_exists('heading', $translations)?$translations['heading']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="button_en" class="bmd-label-floating"> Button</label>
                    <input class="form-control" type="text" name="translations[button][en]" required="true" aria-required="true" value="{{array_key_exists('button', $translations)?$translations['button']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="email_address_en" class="bmd-label-floating"> Email Address</label>
                    <input class="form-control" type="text" name="translations[email_address][en]" required="true" aria-required="true" value="{{array_key_exists('email_address', $translations)?$translations['email_address']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="password_en" class="bmd-label-floating"> Password</label>
                    <input class="form-control" type="text" name="translations[password][en]" required="true" aria-required="true" value="{{array_key_exists('password', $translations)?$translations['password']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="password_en" class="bmd-label-floating"> Remember me</label>
                    <input class="form-control" type="text" name="translations[remember_me][en]" required="true" aria-required="true" value="{{array_key_exists('remember_me', $translations)?$translations['remember_me']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="password_en" class="bmd-label-floating"> Forgot your password</label>
                    <input class="form-control" type="text" name="translations[forgot_your_password][en]" required="true" aria-required="true" value="{{array_key_exists('forgot_your_password', $translations)?$translations['forgot_your_password']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="validation_message_en" class="bmd-label-floating"> Validation message</label>
                    <input class="form-control" type="text" name="translations[validation_message][en]" required="true" aria-required="true" value="{{array_key_exists('validation_message', $translations)?$translations['validation_message']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="logout_en" class="bmd-label-floating"> Log Out</label>
                    <input class="form-control" type="text" name="translations[logout][en]" required="true" aria-required="true" value="{{array_key_exists('logout', $translations)?$translations['logout']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="right_division_heading_en" class="bmd-label-floating"> Right division heading</label>
                    <input class="form-control" type="text" name="translations[right_division_heading][en]" required="true" aria-required="true" value="{{array_key_exists('right_division_heading', $translations)?$translations['right_division_heading']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="right_division_line_1_en" class="bmd-label-floating"> Right division Line 1</label>
                    <input class="form-control" type="text" name="translations[right_division_line_1][en]" required="true" aria-required="true" value="{{array_key_exists('right_division_line_1', $translations)?$translations['right_division_line_1']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="right_division_line_2_en" class="bmd-label-floating"> Right division Line 2</label>
                    <input class="form-control" type="text" name="translations[right_division_line_2][en]" required="true" aria-required="true" value="{{array_key_exists('right_division_line_2', $translations)?$translations['right_division_line_2']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="right_division_line_3_en" class="bmd-label-floating"> Right division Line 3</label>
                    <input class="form-control" type="text" name="translations[right_division_line_3][en]" required="true" aria-required="true" value="{{array_key_exists('right_division_line_3', $translations)?$translations['right_division_line_3']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="footer_heading_en" class="bmd-label-floating"> Footer heading</label>
                    <input class="form-control" type="text" name="translations[footer_heading][en]" required="true" aria-required="true" value="{{array_key_exists('footer_heading', $translations)?$translations['footer_heading']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="footer_support_email_en" class="bmd-label-floating"> Footer support email</label>
                    <input class="form-control" type="text" name="translations[footer_support_email][en]" required="true" aria-required="true" value="{{array_key_exists('footer_support_email', $translations)?$translations['footer_support_email']['en']:''}}">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <h5> Danish</h5>
                  </div>
                  <div class="form-group">
                    <label for="heading_da" class="bmd-label-floating"> Heading</label>
                    <input class="form-control" type="text" name="translations[heading][da]" value="{{array_key_exists('heading', $translations)?$translations['heading']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="button_da" class="bmd-label-floating"> Button</label>
                    <input class="form-control" type="text" name="translations[button][da]" value="{{array_key_exists('button', $translations)?$translations['button']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="email_address_da" class="bmd-label-floating"> Email Address</label>
                    <input class="form-control" type="text" name="translations[email_address][da]" value="{{array_key_exists('email_address', $translations)?$translations['email_address']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="password_da" class="bmd-label-floating"> Password</label>
                    <input class="form-control" type="text" name="translations[password][da]" value="{{array_key_exists('password', $translations)?$translations['password']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="remember_me_da" class="bmd-label-floating"> Remember me</label>
                    <input class="form-control" type="text" name="translations[remember_me][da]" value="{{array_key_exists('remember_me', $translations)?$translations['remember_me']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="forgot_your_password_da" class="bmd-label-floating"> Forgot your password</label>
                    <input class="form-control" type="text" name="translations[forgot_your_password][da]" value="{{array_key_exists('forgot_your_password', $translations)?$translations['forgot_your_password']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="validation_message_da" class="bmd-label-floating"> Validation message</label>
                    <input class="form-control" type="text" name="translations[validation_message][da]" value="{{array_key_exists('validation_message', $translations)?$translations['validation_message']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="logout_da" class="bmd-label-floating"> Log Out</label>
                    <input class="form-control" type="text" name="translations[logout][da]" value="{{array_key_exists('logout', $translations)?$translations['logout']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="right_division_heading_da" class="bmd-label-floating"> Right division heading</label>
                    <input class="form-control" type="text" name="translations[right_division_heading][da]" value="{{array_key_exists('right_division_heading', $translations)?$translations['right_division_heading']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="right_division_line_1_da" class="bmd-label-floating"> Right division Line 1</label>
                    <input class="form-control" type="text" name="translations[right_division_line_1][da]" value="{{array_key_exists('right_division_line_1', $translations)?$translations['right_division_line_1']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="right_division_line_2_da" class="bmd-label-floating"> Right division Line 2</label>
                    <input class="form-control" type="text" name="translations[right_division_line_2][da]" value="{{array_key_exists('right_division_line_2', $translations)?$translations['right_division_line_2']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="right_division_line_3_da" class="bmd-label-floating"> Right division Line 3</label>
                    <input class="form-control" type="text" name="translations[right_division_line_3][da]" value="{{array_key_exists('right_division_line_3', $translations)?$translations['right_division_line_3']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="footer_heading_da" class="bmd-label-floating"> Footer heading</label>
                    <input class="form-control" type="text" name="translations[footer_heading][da]" required="true" aria-required="true" value="{{array_key_exists('footer_heading', $translations)?$translations['footer_heading']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="footer_support_email_da" class="bmd-label-floating"> Footer support email</label>
                    <input class="form-control" type="text" name="translations[footer_support_email][da]" value="{{array_key_exists('footer_support_email', $translations)?$translations['footer_support_email']['da']:''}}">
                  </div>
                </div>
              </div>

              <button type="submit" class="btn btn-info pull-right">Save Translations</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')

@endsection
