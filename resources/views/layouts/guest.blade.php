<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png')}}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png')}}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- Styles -->
    @yield('styles')
    <link href="{{ asset('css/material-dashboard.css')}}" rel="stylesheet" />
    <link href="{{ asset('css/crm.css')}}" rel="stylesheet" />

</head>

<body class="off-canvas-sidebar">
  <!-- Navbar -->

  <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top text-white">
    <div class="container">
      <div class="navbar-wrapper ">

        @auth
        <a class="navbar-brand text-info logo-normal" href="{{url('/dashboard')}}"><img src="{{asset('img/logo.png')}}" width="110" height="50"/></a>
        @else
        <a class="navbar-brand text-info logo-normal" href="{{url('/login')}}"><img src="{{asset('img/logo.png')}}" width="110" height="50"/></a>
        @endif
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="sr-only">Toggle navigation</span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end">
        <ul class="navbar-nav">
          @auth
          @if (\Cookie::has('superAdminId'))
          <li class="nav-item">
            <a class="nav-link" href="{{url('/get-user-auth/'.\Crypt::encryptString(\Config::get('app.name')))}}">
              <i class="material-icons">refresh</i>
              Switch to admin
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('/manual/email/verify/'.\Crypt::encryptString(auth()->user()->id))}}">
              <i class="material-icons">mark_email_read</i>
              Verify email
            </a>
          </li>
          @endif
          <li class="nav-item">
            <a href="javascript:;" class="nav-link resend-email">
              <i class="material-icons">forward_to_inbox</i>
              Resend Email
            </a>
          </li>
          <li class="nav-item {{ Request::is('register') ? 'active' : '' }}">
            <a href="{{url('logout')}}" class="nav-link">
              <i class="material-icons">settings_power</i>
              Logout
            </a>
          </li>
          @else
          <li class="nav-item {{ Request::is('login') ? 'active' : '' }}">
            <a href="{{url('/login')}}" class="nav-link">
              <i class="material-icons">fingerprint</i>
              {{__('login.heading')}}
            </a>
          </li>
          <li class="nav-item {{ Request::is('register') ? 'active' : '' }}">
            <a href="{{url('/register')}}" class="nav-link">
              <i class="material-icons">person_add</i>
              {{__('register.heading')}}
            </a>
          </li>
          @endif
          <li class="nav-item dropdown">
            <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="material-icons">language</i>
                Language
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
              <a class="dropdown-item {{(app()->getLocale() == 'en')?'active':''}}" href="{{url('/locale/en')}}"> English</a>
              <a class="dropdown-item {{(app()->getLocale() == 'da')?'active':''}}" href="{{url('/locale/da')}}"> Dansk</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="wrapper wrapper-full-page">
      @yield('content')
  </div>
  <script src="{{ asset('js/core/jquery.min.js')}}" type="text/javascript"></script>
  <script src="{{ asset('js/core/popper.min.js')}}" type="text/javascript"></script>
  <script src="{{ asset('js/core/bootstrap-material-design.min.js')}}" type="text/javascript"></script>
  <script src="{{ asset('js/plugins/jquery.validate.min.js')}}" type="text/javascript"></script>
  <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.js')}}" type="text/javascript"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('js/material-dashboard.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      //md.checkFullPageBackgroundImage();
      setTimeout(function() {
        // after 1000 ms we add the class animated to the login/register card
        $('.card').removeClass('card-hidden');
      }, 700);
    });
  </script>
  <script type="text/javascript">
    function setFormValidation(id) {
      $(id).validate({
        highlight: function(element) {
          $(element).closest('.bmd-form-group').removeClass('has-success').addClass('has-danger');
          $(element).closest('.form-check').find('.form-check-label .form-check-sign .check').css('border-color', 'red')
        },
        success: function(label, element) {
          $(element).closest('.bmd-form-group').removeClass('has-danger').addClass('has-success');
          $(element).closest('.form-check').find('.form-check-label .form-check-sign .check').css('border-color', 'black')
        },
        errorPlacement: function(error, element) {
          if(element.attr('type') == 'checkbox'){
            //$(element).closest('.form-check').append(error);
          }
        },
      });
    }

    $(document).ready(function() {
      setFormValidation('#RegisterValidation');
      setFormValidation('#LoginValidation');
      setFormValidation('#forgotPassValidation');
      setFormValidation('#resetPassValidation');
    });
  </script>
  @auth
    <script type="text/javascript">
      jQuery(document).on('click', '.resend-email', function(){
        fetch(`{{url('/email/verification-notification')}}`, {
          method: "POST",
          body: JSON.stringify({
              _token: $('meta[name="csrf-token"]').attr('content')
          }),
          headers: {
              "Content-type": "application/json; charset=UTF-8"
          }
        })
        .then(response => response.json())
        .then(data => {
          if(data.status == 'success'){
            Swal.fire({
              type: 'success',
              text: 'Verification email sent successfully',
              showConfirmButton: false,
              timer: 1500
            })
          }
        })
        .catch(err => {

        })
      })
    </script>
  @endauth
  @yield('scripts')
 </body>
</html>
