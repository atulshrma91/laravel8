@extends('layouts.app')

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">dynamic_form</i>
            </div>
            <h4 class="card-title">
              Forms
              <a href="{{url('forms/add')}}" class="btn btn-warning pull-right btn-sm add-account"><span class="material-icons">add</span>Add form</a>
            </h4>
          </div>
          <div class="card-body">
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
            <div class="material-datatables">
              <table id="formsTable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>Created</th>
                    <th>Name</th>
                    <th>Responses</th>
                    <th>Link</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
  <script>
  const formsTable = jQuery('#formsTable').DataTable({
       processing: true,
       serverSide: true,
       ajax: "{{route('user.forms')}}",
       columns: [
          { data: 'created_at' },
          { data: 'name' },
          { data: 'responses' },
          { data: 'link' },
          { data: 'actions' }
       ],
       columnDefs: [
          { orderable: false, targets: 3 },
          { orderable: false, targets: 4 }
       ],
       pagingType: "full_numbers",
       lengthMenu: [
         [5, 25, 50],
         [5, 25, 50]
       ],
       responsive: true,
       language: {
         search: "_INPUT_",
         searchPlaceholder: `Search Forms`,
         infoFiltered: ""
       },
       order: [[ 0, "desc" ]]
    });
    const swalWithMaterialButtons = Swal.mixin({
      confirmButtonClass: 'btn btn-success btn-sm',
      cancelButtonClass: 'btn btn-danger btn-sm',
      buttonsStyling: false,
    })
    jQuery(document).ready(function(){
      jQuery(document).on('click', '.delete-form', function(){
        let id = jQuery(this).data('id')
        swalWithMaterialButtons({
          title: `{{__('account.alert_heading')}}`,
          text: `{!!__('account.alert_text')!!}`,
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: `{{__('account.alert_approve_btn')}}`,
          cancelButtonText: `{{__('account.alert_cancel_btn')}}`,
          showLoaderOnConfirm: true,
          preConfirm: (login) => {
            return fetch('/forms/'+id+'/delete', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({})
              })
              .then(response => {
                if (!response.ok) {
                  throw new Error(response.statusText)
                }
                return response.json()
              })
              .catch(error => {

              })
          },
          allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
          if (result.value) {
            formsTable.ajax.reload()
          }

        })
      })
      jQuery(document).on('click', '.duplicate-form', function(){
        let id = jQuery(this).data('id')
        swalWithMaterialButtons({
          title: `{{__('account.alert_heading')}}`,
          text: `{!!__('account.alert_text')!!}`,
          type: 'info',
          showCancelButton: true,
          confirmButtonText: `Duplicate Form`,
          cancelButtonText: `{{__('account.alert_cancel_btn')}}`,
          showLoaderOnConfirm: true,
          preConfirm: (login) => {
            return fetch('/forms/'+id+'/duplicate', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({})
              })
              .then(response => {
                return response.json()
              })
              .then(function (res) {
                if (!res.success) {
                  throw new Error(res.message)
                }
                return res
              })
              .catch(error => {
                Swal.showValidationMessage(
                  `Request failed: ${error}`
                )
              })
          },
          allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
          if (result.value) {
            formsTable.ajax.reload()
          }

        })
      })
      jQuery(document).on('click', '.copy-form-link', function(){
        let link = jQuery(this).closest('td').find('a').attr('href')
        var $temp = jQuery("<input>");
        jQuery("body").append($temp);
        $temp.val(link).select();
        document.execCommand("copy");
        jQuery(this).html('Copied')
        $temp.remove();
      })
    })
  </script>
@endsection
