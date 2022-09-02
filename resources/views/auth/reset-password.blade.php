@extends('layouts.guest')

@section('content')
<div class="auth-header" >
  <div class="row">
    <div class="col-md-6 col-sm-12">
      <div class="auth-card">
        <form class="form" method="POST" action="{{ route('password.update') }}" id="resetPassValidation">
          @csrf
            <div class="card-body">
              <h2 class="text-center mb-2 crm-blue">Reset Password</h2>
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
                <label for="password" class="bmd-label-floating"> {{__('register.password')}} *</label>
                <input type="password" class="form-control" id="examplePassword" required="true" name="password" value="{{ old('password')}}">
              </div>
              <div class="form-group">
                <label for="password_confirmation" class="bmd-label-floating"> {{__('register.confirm_password')}} *</label>
                <input type="password" class="form-control" required="true" equalTo="#examplePassword" name="password_confirmation" value="{{ old('password_confirmation')}}">
              </div>
              <input type="hidden" name="email" value="{{ request()->query('email')}}">
              <input type="hidden" name="token" value="{{Route::input('token')}}">
              <div>
                <button type="submit" class="btn crm-btn-green">Update</button>
              </div>
            </div>

        </form>
      </div>
    </div>
    <div class="col-md-6 col-sm-12 crm-blue-background">
      <div class="auth-card">
        <div class="card-body">

        </div>
      </div>
      @include('layouts.partials.footer')
    </div>
  </div>
</div>

@endsection
