
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
    <link href="{{ asset('css/material-dashboard.css')}}" rel="stylesheet" />

</head>

<body class="off-canvas-sidebar">

  <div class="wrapper wrapper-full-page">
    <div class="page-header error-page header-filter">
      <!--   you can change the color of the filter page using: data-color="blue | green | orange | red | purple" -->
      <div class="content-center">
        <div class="row">
          <div class="col-md-12">
            <h1>Access Denied</h1>
            <h2>Access for extension is not enabled.</h2>
            <h4>Ooooups! Looks like you got lost.</h4>
            <a class="btn btn-info" href="{{url()->previous()}}">
                    <span class="btn-label">
                      <i class="material-icons">keyboard_arrow_left</i>
                    </span>
                    Go Back
                  <div class="ripple-container"></div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('js/material-dashboard.js')}}" type="text/javascript"></script>
 </body>
</html>
