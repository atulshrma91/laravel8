@extends('layouts.app')

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-9">
        <div class="card">
          <div class="card-header card-header-icon card-header-info">
            <div class="card-icon">
              <i class="material-icons">perm_identity</i>
            </div>
            <h4 class="card-title">{{__('user.title')}}
              <small class="category"></small>
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
            <form method="POST" id="updateProfile" action="{{url('/user')}}" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col-md-3">
                  <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                      <div class="fileinput-new thumbnail img-raised">
                  	     <img src="{{ (\Auth::user()->image)?asset(\Auth::user()->image):asset('img/faces/new_logo.png')}}" rel="nofollow" width="100" height="100">
                      </div>
                      <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                      <div>
                        <span class="btn btn-raised btn-round btn-info btn-file btn-sm">
                          <span class="fileinput-new">Add Photo</span>
                        	<span class="fileinput-exists">Change</span>
                        	<input type="file" name="image" />
                        </span>
                      </div>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="form-group">
                    <label for="name" class="bmd-label-floating"> {{__('user.name')}}</label>
                    <input type="text" class="form-control" name="name" required="true" value="{{ $user->name}}">
                  </div>
                  <div class="form-group">
                    <label for="email" class="bmd-label-floating"> {{__('user.email_address')}}</label>
                    <input type="email" class="form-control" name="email" required="true" value="{{ $user->email}}">
                  </div>
                  <div class="form-group">
                    <label for="password" class="bmd-label-floating"> {{__('user.password')}}</label>
                    <input type="password" class="form-control" id="examplePassword" name="password" value="{{ old('password')}}">
                  </div>
                  <div class="form-group">
                    <label for="password_confirmation" class="bmd-label-floating"> {{__('user.confirm_password')}}</label>
                    <input type="password" class="form-control" equalTo="#examplePassword" name="password_confirmation" value="{{ old('password_confirmation')}}">
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-info pull-right">{{__('user.update_profile')}}</button>
            </form>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>

@endsection
@section('scripts')
  <script src="{{ asset('js/plugins/jasny/jasny-bootstrap.js')}}" type="text/javascript"></script>
@endsection
