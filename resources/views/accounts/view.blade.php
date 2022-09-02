@extends('layouts.app')

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <a href="{{url('/accounts')}}" class="btn btn-sm pull-right">{{__('accounts.back_btn')}}</a>
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">business</i>
            </div>
            <h4 class="card-title">
              {{$account->name}}
              @if(\Auth::user()->isExtensionActivated('categories'))
                <span class="h5 ml-5">{{($account->Category)?$account->Category->name:''}}</span>
              @endif
              <div class="pull-right">
                <button class="edit-account btn btn-success btn-sm"><i class="material-icons">edit</i>{{__('accounts.update_account_btn')}}</button>
                <button class="delete-account btn btn-danger btn-sm"><i class="material-icons">delete</i>{{__('accounts.delete_account_btn')}}</button>
              </div>
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

          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <a href="{{url('/accounts/'.$account->uuid.'/contact/add')}}" class="btn btn-warning btn-sm pull-right"><span class="material-icons">add</span>{{__('accounts.add_contact_btn')}}</a>
            <div class="clearfix"></div>
            <div class="material-datatables">
              <table id="contactsTable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th></th>
                    <th>Role</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Telephone</th>
                    <th>Website</th>
                    <th>Company</th>
                    <th>Address</th>
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
    const swalWithMaterialButtons = Swal.mixin({
      confirmButtonClass: 'btn btn-success btn-sm',
      cancelButtonClass: 'btn btn-danger btn-sm',
      buttonsStyling: false,
    })
    const swalSelectWithMaterialButtons = Swal.mixin({
      confirmButtonClass: 'btn btn-success btn-sm',
      cancelButtonClass: 'btn btn-danger btn-sm',
      inputClass:'form-control',
      buttonsStyling: false,
    })
    const contactsTable = jQuery('#contactsTable').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{route('user.account.contacts',['id' => $account->id])}}",
         columns: [
            { data: 'profile' },
            { data: 'role' },
            { data: 'first_name' },
            { data: 'email' },
            { data: 'telephone' },
            { data: 'website' },
            { data: 'company' },
            { data: 'address' },
            { data: 'company_email' },
            { data: 'actions' },
         ],
         columnDefs: [
            { orderable: false, targets: 0 },
            { orderable: false, targets: 9}
         ],
         pagingType: "full_numbers",
         lengthMenu: [
           [5, 25, 50],
           [5, 25, 50]
         ],
         responsive: true,
         language: {
           search: "_INPUT_",
           searchPlaceholder: "{{__('accounts.account_listing_table_search')}}",
           infoFiltered: ""
         },
         order: [[ 1, "desc" ]]
      });
    jQuery(document).ready(function(){
      jQuery(document).on('click', '.edit-account', function(){
        let categories = '';
        @if(\Auth::user()->isExtensionActivated('categories'))
        @if(!$categories->isEmpty())
          categories += '<select class="form-control" id="account_category_id">'
          categories += '<option value="">Category</option>'
          @foreach($categories as $category)
            categories += '<option value="{{$category->id}}" {{($account->category_id == $category->id)?"selected":""}}>{{$category->name}}</option>'
          @endforeach
          categories += '</select>'
        @endif
        @endif
        swalWithMaterialButtons({
          title: `{{__('account.alert_heading')}}`,
          text: `{{__('accounts.edit_account_popup_text')}}`,
          type: '',
          type: '',
          html:'<input id="account_name" class="swal2-input" value="{{$account->name}}">' + categories,
          showCancelButton: true,
          confirmButtonText: `Yes, Update`,
          cancelButtonText: `{{__('account.alert_cancel_btn')}}`,
          showLoaderOnConfirm: true,
          preConfirm: (login) => {
            let name = jQuery('#account_name').val()
            let category_id = jQuery('#account_category_id').val()
            return fetch(`{{url('/update-account/'.$account->id)}}`, {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({name: name, category_id: category_id})
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
            window.location.href = result.value.url
          }

        })
      })
      jQuery(document).on('click', '.delete-account', function(){
        swalWithMaterialButtons({
          title: `{{__('account.alert_heading')}}`,
          text: `{!!__('account.alert_text')!!}`,
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: `{{__('account.alert_approve_btn')}}`,
          cancelButtonText: `{{__('account.alert_cancel_btn')}}`,
          showLoaderOnConfirm: true,
          preConfirm: (login) => {
            return fetch(`{{url('/delete-account/'.$account->id)}}`, {
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
            window.location.href = result.value.url
          }

        })
      })
      jQuery(document).on('click', '.delete-contact', function(){
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
            return fetch(`{{url('/accounts/'.$account->uuid).'/contact/delete'}}`, {
                method: 'POST',
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
          if (result.value) {
            contactsTable.ajax.reload()
          }

        })
      })
      jQuery(document).on('click', '.duplicate-contact', function(){
        let id = jQuery(this).data('id')
        swalWithMaterialButtons({
          title: `{{__('account.alert_heading')}}`,
          text: `{!!__('account.alert_text')!!}`,
          type: 'info',
          showCancelButton: true,
          confirmButtonText: `{{__('accounts.duplicate_contact_btn')}}`,
          cancelButtonText: `{{__('account.alert_cancel_btn')}}`,
          showLoaderOnConfirm: true,
          preConfirm: (login) => {
            return fetch(`{{url('/accounts/'.$account->uuid).'/contact/duplicate'}}`, {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({id: id})
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
            contactsTable.ajax.reload()
          }

        })
      })
      jQuery(document).on('click', '.move-contact', function(){
        let id = jQuery(this).data('id')
        var array = JSON.parse(`{!!$accounts!!}`)
        swalSelectWithMaterialButtons({
          title: `Move contact to`,
          text: ``,
          type: '',
          input: 'select',
          inputOptions: array,
          showCancelButton: true,
          confirmButtonText: `Save`,
          cancelButtonText: `Cancel`,
          showLoaderOnConfirm: true,
          preConfirm: (login) => {
            return fetch(`{{url('/accounts/'.$account->uuid).'/contact/move'}}`, {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({id: id, account_id: login})
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
            contactsTable.ajax.reload()
          }

        })
      })
    })
</script>
@endsection
