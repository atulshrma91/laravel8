@extends('layouts.app')

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-9">
        <div class="card">
          <div class="card-header card-header-icon card-header-info">
            <div class="card-icon">
              <i class="material-icons">sensor_door</i>
            </div>
            <h4 class="card-title">{{__('account.title')}}
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
            <form method="POST" id="updateAccount" action="{{url('/account')}}">
              @csrf
              <div class="form-group">

                <div class="row">
                  <div class="col-md-8">
                    <label for="name" class="bmd-label-floating"> {{__('account.title')}}</label>
                    <span class="font-weight-bold">{{url('/')}}/</span><input type="text" class="form-control" name="username" required="true" value="{{ $user->username}}">
                  </div>
                  <div class="col-md-4">
                    <button class="btn btn-link btn-youtube btn-sm user-del-account pull-right" type="button">
                        <i class="material-icons">delete_forever</i> {{__('account.delete_button')}}
                    </button>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-info pull-right">{{__('account.update_button')}}</button>
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

  <script type="text/javascript">
      const swalWithMaterialButtons = Swal.mixin({
        confirmButtonClass: 'btn btn-danger btn-sm',
        cancelButtonClass: 'btn btn-success btn-sm',
        buttonsStyling: false,
      })
      jQuery(document).ready(function(){
        jQuery(document).on('click', '.user-del-account', function(){
          swalWithMaterialButtons({
            title: `{{__('account.alert_heading')}}`,
            text: `{!!__('account.alert_text')!!}`,
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: `{{__('account.alert_approve_btn')}}`,
            cancelButtonText: `{{__('account.alert_cancel_btn')}}`,
            showLoaderOnConfirm: true,
            preConfirm: (login) => {
              return fetch(`{{url('/delete-account')}}`, {
                  method: 'GET',
                  headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                  }
                })
                .then(response => {
                  if (!response.ok) {
                    throw new Error(response.statusText)
                  }
                  return response.json()
                })
                .catch(error => {
                  console.log(error)
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
          }).then((result) => {
            if (result.value) {
              setTimeout(function() {
                  window.location.href = result.value.url
              }, 2000);
            }
          })
        })
      })
  </script>

@endsection
