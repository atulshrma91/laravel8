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
    function setFormValidation(id) {
      $(id).validate({
        highlight: function(element) {
          $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
          $(element).closest('.form-check').find('.form-check-label .form-check-sign .check').css('border-color', 'red')
        },
        success: function(label, element) {
          $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
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
      setFormValidation('#formRecord');
    });
  </script>
  @yield('scripts')
 </body>
</html>
