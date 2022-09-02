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
            <h4 class="card-title">Menu Items</h4>
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

            <form method="POST" id="translationsMenuItems" action="{{url('/translations/page/menu-items')}}">
              @csrf
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <h5> English</h5>
                  </div>
                  <div class="form-group">
                    <label for="settings_en" class="bmd-label-floating"> Settings</label>
                    <input class="form-control" type="text" name="translations[settings][en]" required="true" aria-required="true" value="{{array_key_exists('settings', $translations)?$translations['settings']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_en" class="bmd-label-floating"> Account</label>
                    <input class="form-control" type="text" name="translations[account][en]" required="true" aria-required="true" value="{{array_key_exists('account', $translations)?$translations['account']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_en" class="bmd-label-floating"> User</label>
                    <input class="form-control" type="text" name="translations[user][en]" required="true" aria-required="true" value="{{array_key_exists('user', $translations)?$translations['user']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="language_en" class="bmd-label-floating"> Language</label>
                    <input class="form-control" type="text" name="translations[language][en]" required="true" aria-required="true" value="{{array_key_exists('language', $translations)?$translations['language']['en']:''}}">
                  </div>

                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <h5> Danish</h5>
                  </div>
                  <div class="form-group">
                    <label for="settings_da" class="bmd-label-floating"> Settings</label>
                    <input class="form-control" type="text" name="translations[settings][da]" value="{{array_key_exists('settings', $translations)?$translations['settings']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_da" class="bmd-label-floating"> Account</label>
                    <input class="form-control" type="text" name="translations[account][da]" value="{{array_key_exists('account', $translations)?$translations['account']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="title_da" class="bmd-label-floating"> User</label>
                    <input class="form-control" type="text" name="translations[user][da]" value="{{array_key_exists('user', $translations)?$translations['user']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="language_da" class="bmd-label-floating"> Language</label>
                    <input class="form-control" type="text" name="translations[language][da]" value="{{array_key_exists('language', $translations)?$translations['language']['da']:''}}">
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
