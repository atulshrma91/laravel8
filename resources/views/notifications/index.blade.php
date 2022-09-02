@extends('layouts.app')

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">notification_important</i>
            </div>
            <h4 class="card-title">
              Read Notifications
            </h4>
          </div>
          <div class="card-body">

            <div class="material-datatables">
              <table id="notificationsTable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>Time</th>
                    <th>Message</th>
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
  const notificationsTable = jQuery('#notificationsTable').DataTable({
       processing: true,
       serverSide: true,
       ajax: "{{route('notifications.seeRead')}}",
       columns: [
          { data: 'created_at' },
          { data: 'message' },
          { data: 'actions' }
       ],
       columnDefs: [
          { orderable: false, targets: 2 }
       ],
       pagingType: "full_numbers",
       lengthMenu: [
         [5, 25, 50],
         [5, 25, 50]
       ],
       responsive: true,
       language: {
         search: "_INPUT_",
         searchPlaceholder: `{{__('accounts.account_listing_table_search')}}`,
         infoFiltered: ""
       },
       order: [[ 0, "desc" ]]
    });
    jQuery(document).ready(function(){
      jQuery(document).on('click','.mark-unread', function(event){
        event.stopPropagation()
        event.preventDefault()
        let id = jQuery(this).data('id')
        jQuery.ajax({
            url: `{{url('/notifications/mark-unread')}}`,
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
                notificationsTable.ajax.reload()
                jQuery('.navbar').find('.nav-item a.nav-link .notification').html(res.count);
                if(res.count - 1 == 0){
                  jQuery('.navbar').find('.dropdown-menu .c-body').html(res.notification);
                }else{
                  jQuery('.navbar').find('.dropdown-menu .c-body').append(res.notification);
                }
              }
            }
        });
      })
    })
  </script>
@endsection
