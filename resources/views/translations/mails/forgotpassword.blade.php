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
            <h4 class="card-title">
              ForgotPassword Email
              <a href="{{url('translations/email/preview/forgotpassword')}}" class="btn btn-info btn-sm pull-right" target="_blank">
                <span class="material-icons">preview</span> Preview
              </a>
            </h4>

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

            <form method="POST" id="translationsForgotPasswordEmail" action="{{url('/translations/email/forgotpassword')}}">
              @csrf
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <h5> English</h5>
                  </div>
                  <div class="form-group">
                    <label for="subject_en" class="bmd-label-floating"> Subject</label>
                    <input class="form-control" type="text" name="translations[subject][en]" required="true" aria-required="true" value="{{array_key_exists('subject', $translations)?$translations['subject']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="button_en" class="bmd-label-floating"> Action Button</label>
                    <input class="form-control" type="text" name="translations[button][en]" required="true" aria-required="true" value="{{array_key_exists('button', $translations)?$translations['button']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="greetings_en" class="bmd-label-floating"> Greetings</label>
                    <input class="form-control" type="text" name="translations[greetings][en]" required="true" aria-required="true" value="{{array_key_exists('greetings', $translations)?$translations['greetings']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="body_line_1_en" class="bmd-label-floating"> Body Line 1</label>
                    <input class="form-control" type="text" name="translations[body_line_1][en]" required="true" aria-required="true" value="{{array_key_exists('body_line_1', $translations)?$translations['body_line_1']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="body_line_2_en" class="bmd-label-floating"> Body Line 2</label>
                    <input class="form-control" type="text" name="translations[body_line_2][en]" required="true" aria-required="true" value="{{array_key_exists('body_line_2', $translations)?$translations['body_line_2']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="body_line_3_en" class="bmd-label-floating"> Body Line 3</label>
                    <input class="form-control" type="text" name="translations[body_line_3][en]" required="true" aria-required="true" value="{{array_key_exists('body_line_3', $translations)?$translations['body_line_3']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="salutation_en" class="bmd-label-floating"> Salutation</label>
                    <input class="form-control" type="text" name="translations[salutation][en]" required="true" aria-required="true" value="{{array_key_exists('salutation', $translations)?$translations['salutation']['en']:''}}">
                  </div>

                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <h5> Danish</h5>
                  </div>
                  <div class="form-group">
                    <label for="subject_da" class="bmd-label-floating"> Subject</label>
                    <input class="form-control" type="text" name="translations[subject][da]" value="{{array_key_exists('subject', $translations)?$translations['subject']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="button_da" class="bmd-label-floating"> Action Button</label>
                    <input class="form-control" type="text" name="translations[button][da]" value="{{array_key_exists('button', $translations)?$translations['button']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="greetings_da" class="bmd-label-floating"> Greetings</label>
                    <input class="form-control" type="text" name="translations[greetings][da]" value="{{array_key_exists('greetings', $translations)?$translations['greetings']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="body_line_1_da" class="bmd-label-floating"> Body Line 1</label>
                    <input class="form-control" type="text" name="translations[body_line_1][da]" value="{{array_key_exists('body_line_1', $translations)?$translations['body_line_1']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="body_line_2_da" class="bmd-label-floating"> Body Line 2</label>
                    <input class="form-control" type="text" name="translations[body_line_2][da]" value="{{array_key_exists('body_line_2', $translations)?$translations['body_line_2']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="body_line_3_da" class="bmd-label-floating"> Body Line 3</label>
                    <input class="form-control" type="text" name="translations[body_line_3][da]" value="{{array_key_exists('body_line_3', $translations)?$translations['body_line_3']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="salutation_da" class="bmd-label-floating"> Salutation</label>
                    <input class="form-control" type="text" name="translations[salutation][da]"  value="{{array_key_exists('salutation', $translations)?$translations['salutation']['da']:''}}">
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
