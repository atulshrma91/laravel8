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
  <!-- CSS Files -->
  @yield('styles')
  <link href="{{ asset('js/plugins/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" />
  <link href="{{ asset('css/material-dashboard.css')}}" rel="stylesheet" />
  <link href="{{ asset('css/crm.css')}}" rel="stylesheet" />

  @yield('header-scripts')

  @role('member')
  <style>
    .sidebar{background-color: #ffffff;}
    @media (max-width: 991px){
      .sidebar::before, .off-canvas-sidebar nav .navbar-collapse::before{
        background-color: #ffffff;
      }
    }
  </style>
  @endrole
</head>

<body class="sidebar-mini">
  <div class="wrapper ">
    @include('layouts.partials.sidebar')

    <div class="main-panel">
      <!-- Navbar -->
        @include('layouts.partials.header')
      <!-- End Navbar -->

      @yield('content')

    </div>
  </div>

  <!--   Core JS Files   -->
  <script src="{{ asset('js/core/jquery.min.js')}}" type="text/javascript"></script>
  <script src="{{ asset('js/core/popper.min.js')}}" type="text/javascript"></script>
  <script src="{{ asset('js/core/bootstrap-material-design.min.js')}}" type="text/javascript"></script>
  <script src="{{ asset('js/plugins/jquery.validate.min.js')}}" type="text/javascript"></script>
  <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.js')}}" type="text/javascript"></script>
  <script src="{{ asset('js/plugins/jquery.dataTables.min.js')}}" type="text/javascript"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('js/material-dashboard.js')}}" type="text/javascript"></script>
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
      setFormValidation('#updateProfile');
      setFormValidation('#updateAccount');
      setFormValidation('#translationsLogin');
      setFormValidation('#translationsRegister');
      setFormValidation('#translationsForgotPassword');
      setFormValidation('#translationsVerifyEmail');
      setFormValidation('#translationsForgotPasswordEmail');
      setFormValidation('#translationsTermsConditions');
      setFormValidation('#translationsMenuItems');
      setFormValidation('#translationsAccount');
      setFormValidation('#translationsUser');
      setFormValidation('#translationsDashboard');
      setFormValidation('#addContact');
      setFormValidation('#editContact');
      setFormValidation('#roleExtSettings');
      setFormValidation('#addDeal');
      setFormValidation('#editDeal');
      setFormValidation('#translationsAccounts');
      setFormValidation('#translationsDeals');
      setFormValidation('#customizedFieldsForm');
      setFormValidation('#categoriesExtSettings');
      setFormValidation('#updateCategoriesExtSettings');
      setFormValidation('#deal-setting-0');
      setFormValidation('#deal-setting-1');
      setFormValidation('#deal-setting-2');
    });
    jQuery(document).ready(function(){
      jQuery(document).on('click','.mark-notifications-read', function(event){
        event.stopPropagation()
        event.preventDefault()
        jQuery.ajax({
            url: `{{url('/notifications/mark-all-read')}}`,
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify({}),
            dataType: 'json',
            context: this,
            success: function (res) {
              if(res.success == true){
                jQuery(this).closest('.dropdown-menu').find('.c-body').html('<div class="dropdown-item justify-content-center"><h6>No new notifications</h6></div>');
                jQuery(this).closest('.nav-item').find('a.nav-link .notification').html('0');
              }
            }
        });
      })
      jQuery(document).on('click','.form-check-radio', function(event){
        event.stopPropagation()
        event.preventDefault()
        let id = jQuery(this).find('input').val()
        jQuery.ajax({
            url: `{{url('/notifications/mark-read')}}`,
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify({id: id}),
            dataType: 'json',
            context: this,
            success: function (res) {
              if(res.success == true){
                jQuery(this).closest('.nav-item').find('a.nav-link .notification').html((res.count)?res.count:0);
                if(res.count == 0){
                  jQuery(this).closest('.dropdown-menu').find('.c-body').html('<div class="dropdown-item justify-content-center"><h6>No new notifications</h6></div>');
                }
                jQuery(this).remove();
              }
            }
        });
      })
    })
  </script>
  @yield('scripts')
</body>

</html>
