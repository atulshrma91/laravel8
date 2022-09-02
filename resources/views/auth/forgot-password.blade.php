@extends('layouts.guest')

@section('content')
<div class="auth-header" >
  <div class="row">
    <div class="col-md-6 col-sm-12">
      <div class="auth-card">
        <form class="form" method="POST" action="{{ route('password.email') }}" id="forgotPassValidation">
          @csrf
            <div class="card-body">
              <h2 class="text-center mb-2 crm-blue">{{__('forgot_password.heading')}}</h2>
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
                <label for="email" class="bmd-label-floating"> {{__('forgot_password.email_address')}} *</label>
                <input type="email" class="form-control" required="true" name="email" value="{{ old('email')}}">
              </div>
              <div>
                <button type="submit" class="btn crm-btn-green mt-4">{{__('forgot_password.send_email')}}</button>
             </div>
            </div>
        </form>
      </div>
    </div>
    <div class="col-md-6 col-sm-12 crm-blue-background">
      <div class="auth-card">
        <div class="card-body">
          <h2 class="text-center mb-2">{{__('forgot_password.right_division_heading')}}</h2>
          <div class="dropdown-divider mb-3"></div>
          <h3 class="text-center">{{__('forgot_password.right_division_line_1')}}</h3>
          <div class="text-center">
            <a href="{{url('/register')}}" class="btn crm-btn-green mx-4 my-2">
              {{__('register.heading')}}
            </a>
          </div>
          <div class="text-center">{{__('forgot_password.right_division_line_2')}}</div>
          <div class="text-center">
            <a href="{{url('/login')}}" class="btn crm-btn-green mx-4 my-2">
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
