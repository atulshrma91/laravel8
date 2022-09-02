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
            <h4 class="card-title">Register <a href="javascript:;" class="text-primary pull-right">{{url('/register')}}</a></h4>
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

            <form method="POST" id="translationsRegister" action="{{url('/translations/authentication/register')}}">
              @csrf
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <h5> English</h5>
                  </div>
                  <div class="form-group">
                    <label for="register_en" class="bmd-label-floating"> Heading</label>
                    <input class="form-control" type="text" name="translations[heading][en]" required="true" aria-required="true" value="{{array_key_exists('heading', $translations)?$translations['heading']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="name_en" class="bmd-label-floating"> Name</label>
                    <input class="form-control" type="text" name="translations[name][en]" required="true" aria-required="true" value="{{array_key_exists('name', $translations)?$translations['name']['en']:''}}">
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
                    <label for="confirm_password_en" class="bmd-label-floating"> Confirm Password</label>
                    <input class="form-control" type="text" name="translations[confirm_password][en]" required="true" aria-required="true" value="{{array_key_exists('confirm_password', $translations)?$translations['confirm_password']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="terms_and_conditions_en" class="bmd-label-floating"> Terms and conditions</label>
                    <input class="form-control" type="text" name="translations[terms_and_conditions][en]" required="true" aria-required="true" value="{{array_key_exists('terms_and_conditions', $translations)?$translations['terms_and_conditions']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="get_started_en" class="bmd-label-floating"> Button</label>
                    <input class="form-control" type="text" name="translations[get_started][en]" required="true" aria-required="true" value="{{array_key_exists('get_started', $translations)?$translations['get_started']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="validation_message_en" class="bmd-label-floating"> Validation message</label>
                    <input class="form-control" type="text" name="translations[validation_message][en]" required="true" aria-required="true" value="{{array_key_exists('validation_message', $translations)?$translations['validation_message']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="right_division_heading_en" class="bmd-label-floating"> Right division heading</label>
                    <input class="form-control" type="text" name="translations[right_division_heading][en]" required="true" aria-required="true" value="{{array_key_exists('right_division_heading', $translations)?$translations['right_division_heading']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="right_division_line_1_en" class="bmd-label-floating"> Right division Line 1</label>
                    <input class="form-control" type="text" name="translations[right_division_line_1][en]" required="true" aria-required="true" value="{{array_key_exists('right_division_line_1', $translations)?$translations['right_division_line_1']['en']:''}}">
                  </div>

                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <h5> Danish</h5>
                  </div>
                  <div class="form-group">
                    <label for="register_da" class="bmd-label-floating"> Heading</label>
                    <input class="form-control" type="text" name="translations[heading][da]" value="{{array_key_exists('heading', $translations)?$translations['heading']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="name_da" class="bmd-label-floating"> Name</label>
                    <input class="form-control" type="text" name="translations[name][da]" value="{{array_key_exists('name', $translations)?$translations['name']['da']:''}}">
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
                    <label for="confirm_password_da" class="bmd-label-floating"> Confirm Password</label>
                    <input class="form-control" type="text" name="translations[confirm_password][da]" value="{{array_key_exists('confirm_password', $translations)?$translations['confirm_password']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="terms_and_conditions_da" class="bmd-label-floating"> Terms and conditions</label>
                    <input class="form-control" type="text" name="translations[terms_and_conditions][da]" value="{{array_key_exists('terms_and_conditions', $translations)?$translations['terms_and_conditions']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="get_started_da" class="bmd-label-floating"> Button</label>
                    <input class="form-control" type="text" name="translations[get_started][da]" value="{{array_key_exists('get_started', $translations)?$translations['get_started']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="validation_message_da" class="bmd-label-floating"> Validation message</label>
                    <input class="form-control" type="text" name="translations[validation_message][da]" value="{{array_key_exists('validation_message', $translations)?$translations['validation_message']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="right_division_heading_da" class="bmd-label-floating"> Right division heading</label>
                    <input class="form-control" type="text" name="translations[right_division_heading][da]" value="{{array_key_exists('right_division_heading', $translations)?$translations['right_division_heading']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="right_division_line_1_da" class="bmd-label-floating"> Right division Line 1</label>
                    <input class="form-control" type="text" name="translations[right_division_line_1][da]" value="{{array_key_exists('right_division_line_1', $translations)?$translations['right_division_line_1']['da']:''}}">
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
