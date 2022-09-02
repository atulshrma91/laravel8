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
            <h4 class="card-title">Account <a href="javascript:;" class="text-primary pull-right">{{url('/account')}}</a></h4>
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

            <form method="POST" id="translationsAccount" action="{{url('/translations/page/account')}}">
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
                    <label for="title_en" class="bmd-label-floating"> Delete Button</label>
                    <input class="form-control" type="text" name="translations[delete_button][en]" required="true" aria-required="true" value="{{array_key_exists('delete_button', $translations)?$translations['delete_button']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_en" class="bmd-label-floating"> Update Button</label>
                    <input class="form-control" type="text" name="translations[update_button][en]" required="true" aria-required="true" value="{{array_key_exists('update_button', $translations)?$translations['update_button']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_en" class="bmd-label-floating"> Alert Heading</label>
                    <input class="form-control" type="text" name="translations[alert_heading][en]" required="true" aria-required="true" value="{{array_key_exists('alert_heading', $translations)?$translations['alert_heading']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_en" class="bmd-label-floating"> Alert Text</label>
                    <input class="form-control" type="text" name="translations[alert_text][en]" required="true" aria-required="true" value="{{array_key_exists('alert_text', $translations)?$translations['alert_text']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_en" class="bmd-label-floating"> Alert Approve Button</label>
                    <input class="form-control" type="text" name="translations[alert_approve_btn][en]" required="true" aria-required="true" value="{{array_key_exists('alert_approve_btn', $translations)?$translations['alert_approve_btn']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_en" class="bmd-label-floating"> Alert Cancel Button</label>
                    <input class="form-control" type="text" name="translations[alert_cancel_btn][en]" required="true" aria-required="true" value="{{array_key_exists('alert_cancel_btn', $translations)?$translations['alert_cancel_btn']['en']:''}}">
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
                    <label for="title_da" class="bmd-label-floating"> Delete Button</label>
                    <input class="form-control" type="text" name="translations[delete_button][da]" value="{{array_key_exists('delete_button', $translations)?$translations['delete_button']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_da" class="bmd-label-floating"> Update Button</label>
                    <input class="form-control" type="text" name="translations[update_button][da]" value="{{array_key_exists('update_button', $translations)?$translations['update_button']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_da" class="bmd-label-floating"> Alert Heading</label>
                    <input class="form-control" type="text" name="translations[alert_heading][da]" value="{{array_key_exists('alert_heading', $translations)?$translations['alert_heading']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_da" class="bmd-label-floating"> Alert Text</label>
                    <input class="form-control" type="text" name="translations[alert_text][da]" value="{{array_key_exists('alert_text', $translations)?$translations['alert_text']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_da" class="bmd-label-floating"> Alert Approve Button</label>
                    <input class="form-control" type="text" name="translations[alert_approve_btn][da]" value="{{array_key_exists('alert_approve_btn', $translations)?$translations['alert_approve_btn']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_da" class="bmd-label-floating"> Alert Cancel Button</label>
                    <input class="form-control" type="text" name="translations[alert_cancel_btn][da]" value="{{array_key_exists('alert_cancel_btn', $translations)?$translations['alert_cancel_btn']['da']:''}}">
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
