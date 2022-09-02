@extends('layouts.guest')

@section('content')
<div class="auth-header" >
  <div class="row">
    <div class="col-md-6 col-sm-12">
      <div class="auth-card">
        <form class="form" method="POST" action="{{ route('register') }}" id="RegisterValidation">
          @csrf
          <div class="card-body ">
              <h2 class="text-center mb-2 crm-blue">{{__('register.heading')}}</h2>
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
            <div class="form-group">
              <label for="name" class="bmd-label-floating"> {{__('register.name')}} *</label>
              <input type="text" class="form-control" name="name" required="true" value="{{ old('name')}}">
            </div>
            <div class="form-group">
              <label for="email" class="bmd-label-floating"> {{__('register.email_address')}} *</label>
              <input type="email" class="form-control" name="email" required="true" value="{{ old('email')}}">
            </div>
            <div class="form-group">
              <label for="password" class="bmd-label-floating"> {{__('register.password')}} *</label>
              <input type="password" class="form-control" id="examplePassword" required="true" name="password" value="{{ old('password')}}">
            </div>
            <div class="form-group">
              <label for="password_confirmation" class="bmd-label-floating"> {{__('register.confirm_password')}} *</label>
              <input type="password" class="form-control" required="true" equalTo="#examplePassword" name="password_confirmation" value="{{ old('password_confirmation')}}">
            </div>
            <div class="form-check form-group">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="" name="terms" required="true">
                <span class="form-check-sign">
                  <span class="check"></span>
                </span>
                <a href="{{url('/terms-and-conditions')}}" class="term-condition-link" target="_blank">{{__('register.terms_and_conditions')}}</a>.
              </label>
            </div>
            <div>
              <button type="submit" class="btn crm-btn-green mt-4">{{__('register.get_started')}}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="col-md-6 col-sm-12 crm-blue-background">
      <div class="auth-card">
        <div class="card-body">
          <h2 class="text-center mb-2">{{__('register.right_division_heading')}}</h2>
          <div class="dropdown-divider mb-3"></div>
          <h3 class="text-center">{{__('register.right_division_line_1')}}</h3>
          <div class="text-center">
            <a href="{{url('/login')}}" class="btn crm-btn-green mt-4">
              {{__('login.heading')}}
            </a>
          </div>
        </div>
      </div>
      @include('layouts.partials.footer')
    </div>
  </div>
</div>

@endsection
