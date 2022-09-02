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
            <h4 class="card-title">User <a href="javascript:;" class="text-primary pull-right">{{url('/user')}}</a></h4>
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

            <form method="POST" id="translationsUser" action="{{url('/translations/page/user')}}">
              @csrf
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <h5> English</h5>
                  </div>
                  <div class="form-group">
                    <label for="title_en" class="bmd-label-floating"> Title</label>
                    <input class="form-control" type="text" name="translations[title][en]" required="true" aria-required="true" value="{{array_key_exists('title', $translations)?$translations['title']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_en" class="bmd-label-floating"> Name</label>
                    <input class="form-control" type="text" name="translations[name][en]" required="true" aria-required="true" value="{{array_key_exists('name', $translations)?$translations['name']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_en" class="bmd-label-floating"> Email address</label>
                    <input class="form-control" type="text" name="translations[email_address][en]" required="true" aria-required="true" value="{{array_key_exists('email_address', $translations)?$translations['email_address']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_en" class="bmd-label-floating"> Password</label>
                    <input class="form-control" type="text" name="translations[password][en]" required="true" aria-required="true" value="{{array_key_exists('password', $translations)?$translations['password']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_en" class="bmd-label-floating"> Confirm password</label>
                    <input class="form-control" type="text" name="translations[confirm_password][en]" required="true" aria-required="true" value="{{array_key_exists('confirm_password', $translations)?$translations['confirm_password']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_en" class="bmd-label-floating"> Update Profile</label>
                    <input class="form-control" type="text" name="translations[update_profile][en]" required="true" aria-required="true" value="{{array_key_exists('update_profile', $translations)?$translations['update_profile']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="success_notify_en" class="bmd-label-floating"> Success notification</label>
                    <input class="form-control" type="text" name="translations[success_notify][en]" required="true" aria-required="true" value="{{array_key_exists('success_notify', $translations)?$translations['success_notify']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="failure_notify_en" class="bmd-label-floating"> Failure notification</label>
                    <input class="form-control" type="text" name="translations[failure_notify][en]" required="true" aria-required="true" value="{{array_key_exists('failure_notify', $translations)?$translations['failure_notify']['en']:''}}">
                  </div>

                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <h5> Danish</h5>
                  </div>
                  <div class="form-group">
                    <label for="title_da" class="bmd-label-floating"> Title</label>
                    <input class="form-control" type="text" name="translations[title][da]" value="{{array_key_exists('title', $translations)?$translations['title']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_da" class="bmd-label-floating"> Name</label>
                    <input class="form-control" type="text" name="translations[name][da]" value="{{array_key_exists('name', $translations)?$translations['name']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_da" class="bmd-label-floating"> Email address</label>
                    <input class="form-control" type="text" name="translations[email_address][da]" value="{{array_key_exists('email_address', $translations)?$translations['email_address']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_da" class="bmd-label-floating"> Password</label>
                    <input class="form-control" type="text" name="translations[password][da]" value="{{array_key_exists('password', $translations)?$translations['password']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_da" class="bmd-label-floating"> Confirm password</label>
                    <input class="form-control" type="text" name="translations[confirm_password][da]" value="{{array_key_exists('confirm_password', $translations)?$translations['confirm_password']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_da" class="bmd-label-floating"> Update Profile</label>
                    <input class="form-control" type="text" name="translations[update_profile][da]" value="{{array_key_exists('update_profile', $translations)?$translations['update_profile']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="success_notify_da" class="bmd-label-floating"> Success notification</label>
                    <input class="form-control" type="text" name="translations[success_notify][da]" value="{{array_key_exists('success_notify', $translations)?$translations['success_notify']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="failure_notify_da" class="bmd-label-floating"> Failure notification</label>
                    <input class="form-control" type="text" name="translations[failure_notify][da]" value="{{array_key_exists('failure_notify', $translations)?$translations['failure_notify']['da']:''}}">
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
