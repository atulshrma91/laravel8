@extends('layouts.guest')

@section('content')

<div class="auth-header" >
  <div class="row">
    <div class="col-md-6 col-sm-12">
      <div class="auth-card">
        <form class="form" method="POST" action="{{ route('login') }}" id="LoginValidation">
          @csrf
            <div class="card-body">
              <h2 class="text-center mb-2 crm-blue">{{__('login.heading')}}</h2>
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

              <div class="form-group">
                <label for="exampleEmails" class="bmd-label-floating"> {{__('login.email_address')}} *</label>
                <input type="email" class="form-control" required="true" name="email" value="{{ old('email')}}">
              </div>
              <div class="form-group">
                <label for="examplePasswords" class="bmd-label-floating"> {{__('login.password')}} *</label>
                <input type="password" class="form-control" required="true" name="password" value="{{ old('password')}}">
              </div>
              <div class="form-group">
                <div class="form-check mr-auto">
                  <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" value="1" name="remember" {{ old('remember') ? 'checked="checked"' : '' }}> {{__('login.remember_me')}}
                    <span class="form-check-sign">
                      <span class="check"></span>
                    </span>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <button type="submit" class="btn crm-btn-green">{{__('login.button')}}</button>
                <a href="{{url('forgot-password')}}" class="forgot-pass-link">&nbsp;{{__('login.forgot_your_password')}}</a>
              </div>
            </div>
        </form>
      </div>
    </div>
    <div class="col-md-6 col-sm-12 crm-blue-background">
      <div class="auth-card">
        <div class="card-body">
          <h2 class="text-center mb-2">{{__('login.right_division_heading')}}</h2>
          <div class="dropdown-divider mb-3"></div>
          <div class="text-center">
            <h5>{{__('login.right_division_line_1')}}</h5>
            <h5>{{__('login.right_division_line_2')}}</h5>
            <h5>{{__('login.right_division_line_3')}}</h5>
          </div>
          <div class="text-center">
            <a href="{{url('/register')}}" class="btn crm-btn-green mt-4">
              {{__('register.heading')}}
            </a>
          </div>
        </div>
      </div>
      @include('layouts.partials.footer')
    </div>
  </div>
</div>

@endsection
