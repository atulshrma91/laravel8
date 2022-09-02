@extends('layouts.app')

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">supervised_user_circle</i>
            </div>
            <h4 class="card-title">Owners</h4>
          </div>
          <div class="card-body">
            <div class="toolbar">

            </div>
            <div class="material-datatables">
              <table id="accountTable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>Last login</th>
                    <th>Account</th>
                    <th>Owner</th>
                    <th>Email</th>
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
  <script type="text/javascript">
    jQuery(document).ready(function() {
      const swalWithMaterialButtons = Swal.mixin({
        confirmButtonClass: 'btn btn-danger',
        cancelButtonClass: 'btn btn-success',
        buttonsStyling: false,
      })
      const accountTable = jQuery('#accountTable').DataTable({
           processing: true,
           serverSide: true,
           ajax: "{{route('super_admin.users')}}",
           columns: [
              { data: 'last_login' },
              { data: 'username' },
              { data: 'name' },
              { data: 'email' },
              { data: 'actions' },
           ],
           columnDefs: [
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
             searchPlaceholder: "Search records",
             infoFiltered: ""
           }
        });

        jQuery(document).on('click', '.delete-user', function(){
          let id = jQuery(this).data('id')
          swalWithMaterialButtons({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            showLoaderOnConfirm: true,
            preConfirm: (login) => {
              return fetch(`{{url('/delete-user')}}`, {
                  method: 'post',
                  headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                  },
                  body: JSON.stringify({id: id})
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
            if (result.value.success == true) {
              setTimeout(function() {
                  accountTable.ajax.reload( null, false );
              }, 2000);
            }
          })
        })
    });
  </script>
@endsection
