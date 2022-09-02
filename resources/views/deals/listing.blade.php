@extends('layouts.app')

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">local_offer</i>
            </div>
            <h4 class="card-title">
              Won/Lost Deals
            </h4>
          </div>
          <div class="card-body">
            <a href="{{url('deals')}}" class="btn btn-info btn-sm pull-right"><span class="material-icons">add</span>Add Won/lost Deals</a>
            <a href="{{url('deals')}}" class="btn btn- light btn-sm pull-right">Active deals</a>
            <div class="clearfix"></div>
            <div class="material-datatables">
              <table id="dealsTable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>Created</th>
                    <th>Won</th>
                    <th>Lost</th>
                    <th>Headline</th>
                    <th>Account</th>
                    <th>Person</th>
                    <th>Telephone</th>
                    <th>Email</th>
                    <th>Comments</th>
                    <th>Source</th>
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
  const formsTable = jQuery('#dealsTable').DataTable({
       processing: true,
       serverSide: true,
       searching: false,
       ajax: "{{route('deals.listing')}}",
       columns: [
          { data: 'created_at' },
          { data: 'date_won' },
          { data: 'date_lost' },
          { data: 'name' },
          { data: 'account' },
          { data: 'person' },
          { data: 'telephone' },
          { data: 'email' },
          { data: 'comments' },
          { data: 'source' }
       ],
       columnDefs: [
          { orderable: false, targets: 8 },
          { orderable: false, targets: 9 }
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
      jQuery(document).on('click', '.delete-deal', function(){
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
            return fetch('/deals/'+id+'/delete', {
                method: 'GET',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
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
            window.location.href = result.value.url
          }

        })
      })

      jQuery(document).on('click', '.activate-deal', function(){
        let id = jQuery(this).data('id')
        jQuery.ajax({
            url: `{{url('/deals/update/status')}}`,
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify({id: id, status: 'new'}),
            dataType: 'json',
            context: this,
            success: function (res) {
              if (res.success) {
                window.location.href = res.url
              }
            }
        });
      })
    })

  </script>
@endsection
