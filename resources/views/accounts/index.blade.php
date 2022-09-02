@extends('layouts.app')

@section('content')

<div class="content">
    <div class="">
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

      <div class="row">
          <div class="col-md-3">
            <div class="card-header">
            <form class="form-inline px-3" method="GET">
              <div class="form-group no-border">
                <input type="text" class="form-control" name="a" value="{{request()->get('a')}}"placeholder="Search Accounts">
              </div>
              <button type="submit" class="btn btn-just-icon btn-info btn-round">
                <i class="material-icons">search</i>
              </button>
              <!--div class="dropdown show ml-3">
                 <a class="dropdown-toggle badge badge-warning" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 </a>
                 <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                   <a class="dropdown-item add-account" href="javascript:;"><i class="material-icons">add</i>{{__('accounts.add_new_account')}}</a>
                 </div>
               </div-->
               <a class="btn btn-warning add-account btn-sm pull-right" href="javascript:;"><i class="material-icons">add</i>{{__('accounts.add_new_account')}}</a>
            </form>
          </div>
            @if(!$accounts->isEmpty())
            <div class="card-header pt-2">
              <ul class="nav nav-pills nav-pills-info nav-pills-icons flex-column">
                @foreach($accounts as $ak => $account)
                <li class="nav-item">
                  <a class="nav-link {!! ($ak == 0 )?'active':'' !!} text-left border border-light rounded-sm" href="#tab_{{$account->id}}" data-toggle="tab">
                    <div class="row">
                      <div class="col-md-3">
                        {!!($account->image)?'<img src="'.asset($account->image).'" class="rounded img-thumbnail crm-thumbnail-img"/>':'<img src="'.asset('img/faces/new_logo.png').'" class="rounded img-thumbnail crm-thumbnail-img"/>'!!}
                      </div>
                      <div class="col-md-9">
                        <span class="ml-1">{{$account->name}}</span>
                      </div>
                    </div>
                    <div class="clearfix">
                      <!--span class="text-secondary float-left">{{date('M j, Y', strtotime($account->created_at))}}</span-->
                      @if(\Auth::user()->isExtensionActivated('categories'))
                      @if($account->Category)
                      <span class="badge badge-default badge-pill float-right" style="background-color:{{$account->Category->color_code}}">{{($account->Category)?$account->Category->name:''}}</span>
                      @endif
                      @endif
                    </div>
                  </a>
                </li>
                @endforeach
              </ul>
            </div>
              @endif
          </div>
          <div class="col-md-9">
              <div class="tab-content">
                @if(!$accounts->isEmpty())
                @foreach($accounts as $ak => $account)
                  <div class="tab-pane {!! ($ak == 0 )?'active':'' !!}" id="tab_{{$account->id}}">
                    <div>
                      <div class="card-header">
                      <h4 class="card-title">
                        {{$account->name}}
                        @if(\Auth::user()->isExtensionActivated('categories'))
                          <span class="h5 ml-5">{{($account->Category)?$account->Category->name:''}}</span>
                        @endif
                        <div class="pull-right">
                          <button class="edit-account btn btn-success btn-sm" data-id="{{$account->id}}" data-name="{{$account->name}}" data-category-id="{{$account->category_id}}" data-image="{{($account->image)?asset($account->image):''}}"><i class="material-icons">edit</i>{{__('accounts.update_account_btn')}}</button>
                          <button class="delete-account btn btn-danger btn-sm" data-id="{{$account->id}}"><i class="material-icons">delete</i>{{__('accounts.delete_account_btn')}}</button>
                        </div>
                      </h4>
                    </div>
                      <div class="card-header mt-2">
                        <a href="javascript:;" class="btn btn-warning btn-sm pull-right add-contact" data-toggle="modal" data-target="#add-contact-Modal" data-uuid={{$account->uuid}}><span class="material-icons">add</span>{{__('accounts.add_contact_btn')}}</a>
                        <div class="clearfix"></div>
                        <div class="material-datatables">
                          <table id="contactsTable_{{$account->id}}" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
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
                  @endforeach
                  @endif
              </div>
          </div>
      </div>
      <div class="modal fade" id="add-contact-Modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Add Contact</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="addContact" name="addContact" method="POST"enctype="multipart/form-data">
              <div class="modal-body">
                @csrf
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="role" class="bmd-label-floating"> {{__('accounts.contact_role')}}</label>
                      <input type="text" class="form-control" name="role" value="{{ old('role')}}">
                    </div>
                    <div class="form-group">
                      <label for="first_name" class="bmd-label-floating"> {{__('accounts.contact_firstname')}}</label>
                      <input type="text" class="form-control" name="first_name" value="{{ old('first_name')}}">
                    </div>
                    <div class="form-group">
                      <label for="last_name" class="bmd-label-floating"> {{__('accounts.contact_lastname')}}</label>
                      <input type="text" class="form-control" name="last_name" value="{{ old('last_name')}}">
                    </div>
                    <div class="form-group">
                      <label for="email" class="bmd-label-floating"> {{__('accounts.contact_email')}}</label>
                      <input type="email" class="form-control" name="email" value="{{ old('email')}}">
                    </div>
                    <div class="form-group">
                      <label for="telephone" class="bmd-label-floating"> {{__('accounts.contact_telephone')}}</label>
                      <input type="text" class="form-control" name="telephone" value="{{ old('telephone')}}">
                    </div>
                    <div class="form-group">
                      <label for="website" class="bmd-label-floating"> {{__('accounts.contact_website')}}</label>
                      <input type="text" class="form-control" name="website" value="{{ old('website')}}">
                    </div>
                    <div class="form-group">
                      <label for="company" class="bmd-label-floating"> {{__('accounts.contact_company')}}</label>
                      <input type="text" class="form-control" name="company"  value="{{ old('company')}}">
                    </div>
                    <div class="form-group">
                      <label for="cvr_number" class="bmd-label-floating"> {{__('accounts.contact_company_cvr_no')}}</label>
                      <input type="text" class="form-control" name="cvr_number"  value="{{ old('cvr_number')}}">
                    </div>
                    <div class="form-group">
                      <label for="company_address" class="bmd-label-floating"> {{__('accounts.contact_address')}}</label>
                      <input type="text" class="form-control" name="address" value="{{ old('address')}}">
                    </div>
                    <div class="form-group">
                      <label for="company_telephone" class="bmd-label-floating"> {{__('accounts.contact_company_telephone')}}</label>
                      <input type="text" class="form-control" name="company_telephone" value="{{ old('company_telephone')}}">
                    </div>
                    <div class="form-group">
                      <label for="company_email" class="bmd-label-floating"> {{__('accounts.contact_company_email')}}</label>
                      <input type="email" class="form-control" name="company_email" value="{{ old('company_email')}}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div>
                      <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                         <div class="fileinput-new thumbnail img-raised">
                      	    <img src="{{asset('img/faces/new_logo.png')}}" rel="nofollow" alt="...">
                         </div>
                         <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                         <div>
                          	<span class="btn btn-raised btn-round btn-sm btn-info btn-file">
                          	   <span class="fileinput-new">{{__('accounts.contact_profile_img')}}</span>
                          	   <span class="fileinput-exists">{{__('accounts.contact_profile_img')}}</span>
                          	   <input type="file" name="profile" />
                          	</span>
                         </div>
                      </div>
                    </div>


                    <div>
                      <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                         <div class="fileinput-new thumbnail img-raised">
                      	    <img src="{{asset('img/faces/new_logo.png')}}" rel="nofollow" alt="...">
                         </div>
                         <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                         <div>
                          	<span class="btn btn-raised btn-round btn-sm btn-info btn-file">
                          	   <span class="fileinput-new">{{__('accounts.contact_logo_img')}}</span>
                          	   <span class="fileinput-exists">{{__('accounts.contact_logo_img')}}</span>
                          	   <input type="file" name="logo" />
                          	</span>
                         </div>
                      </div>
                    </div>
                    <div class="form-group text-center mt-5">
                      <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-info btn-sm">{{__('accounts.add_contact_btn')}}</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection

@section('scripts')
  <script src="{{ asset('js/plugins/jasny/jasny-bootstrap.js')}}" type="text/javascript"></script>
  <script>
    const swalWithMaterialButtons = Swal.mixin({
      confirmButtonClass: 'btn btn-success btn-sm',
      cancelButtonClass: 'btn btn-sm',
      buttonsStyling: false,
    })
    const swalSelectWithMaterialButtons = Swal.mixin({
      confirmButtonClass: 'btn btn-success btn-sm',
      cancelButtonClass: 'btn btn-danger btn-sm',
      inputClass:'form-control',
      buttonsStyling: false,
    })
    @if(!$accounts->isEmpty())
    @foreach($accounts as $account)
    const contactsTable_{{$account->id}} = jQuery('#contactsTable_{{$account->id}}').DataTable({
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
    @endforeach
    @endif

    jQuery(document).ready(function(){
      jQuery(document).on('click', '.add-account', function(){
        let categories = '';
        @if(\Auth::user()->isExtensionActivated('categories'))
        @if(!$categories->isEmpty())
          categories += '<select class="form-control" id="account_category_id" name="category_id">'
          categories += '<option value="">Category</option>'
          @foreach($categories as $category)
            categories += '<option value="{{$category->id}}">{{$category->name}}</option>'
          @endforeach
          categories += '</select>'
        @endif
        @endif
        swalWithMaterialButtons({
          title: `{{__('accounts.account_popup_title')}}`,
          text: ``,
          type: '',
          html:'<input name="account_name" class="form-control" placeholder="Account name"><input type="file" class="form-control" name="account_image">' + categories,
          showCancelButton: true,
          confirmButtonText: `{{__('accounts.account_popup_approve_btn')}}`,
          cancelButtonText: `{{__('account.alert_cancel_btn')}}`,
          showLoaderOnConfirm: true,
          preConfirm: (login) => {
            let name = jQuery('input[name="account_name"]').val()
            let category_id = (jQuery('#account_category_id').length)?jQuery('#account_category_id').val():''
            var file_data = jQuery('input[name="account_image"]').prop('files')[0];
            var formData = new FormData();
            formData.append('name', name);
            formData.append('category_id', category_id);
            formData.append('image', file_data);
            return fetch(`{{url('/accounts/add')}}`, {
                  method: 'POST',
                  headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                  },
                  body: formData,
                  contentType : false,
                  processData : false,
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
      jQuery(document).on('click', '.edit-account', function(){
        let accountName = jQuery(this).data('name')
        let accountId = jQuery(this).data('id')
        let categoryId = jQuery(this).data('category-id')
        let image = jQuery(this).data('image')
        let categories = '';
        @if(\Auth::user()->isExtensionActivated('categories'))
        @if(!$categories->isEmpty())
          categories += '<select class="form-control" id="account_category_id'+accountId+'">'
          categories += '<option value="">Category</option>'
          @foreach($categories as $category)
            categories += '<option value="{{$category->id}}" '+((categoryId == "{{$category->id}}")?"selected":"")+'>{{$category->name}}</option>'
          @endforeach
          categories += '</select>'
        @endif
        @endif
        if(image){
          image = '<img src = "'+image+'" class="rounded img-thumbnail float-left" height="70" width="70">'
        }
        swalWithMaterialButtons({
          title: `{{__('account.alert_heading')}}`,
          text: `{{__('accounts.edit_account_popup_text')}}`,
          type: '',
          type: '',
          html:'<input id="account_name'+accountId+'" class="form-control" value="'+accountName+'">'+image+'<input type="file" class="form-control" name="account_image'+accountId+'">'+ categories,
          showCancelButton: true,
          confirmButtonText: `Yes, Update`,
          cancelButtonText: `{{__('account.alert_cancel_btn')}}`,
          showLoaderOnConfirm: true,
          preConfirm: (login) => {
            let name = jQuery('#account_name'+accountId).val()
            let category_id = (jQuery('#account_category_id'+accountId).length)?jQuery('#account_category_id'+accountId).val():''
            var file_data = jQuery('input[name="account_image'+accountId+'"]').prop('files')[0];
            var formData = new FormData();
            formData.append('name', name);
            formData.append('category_id', category_id);
            formData.append('image', file_data);
            return fetch(`{{url('/update-account')}}/`+accountId, {
                method: 'POST',
                headers: {
                  'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                body: formData,
                contentType : false,
                processData : false,
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
        let accountId = jQuery(this).data('id')
        swalWithMaterialButtons({
          title: `{{__('account.alert_heading')}}`,
          text: `{!!__('account.alert_text')!!}`,
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: `{{__('account.alert_approve_btn')}}`,
          cancelButtonText: `{{__('account.alert_cancel_btn')}}`,
          showLoaderOnConfirm: true,
          preConfirm: (login) => {
            return fetch(`{{url('/delete-account')}}/`+accountId, {
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
        let uuid = jQuery(this).data('uuid')
        let account_id = jQuery(this).data('account-id')
        swalWithMaterialButtons({
          title: `{{__('account.alert_heading')}}`,
          text: `{!!__('account.alert_text')!!}`,
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: `{{__('account.alert_approve_btn')}}`,
          cancelButtonText: `{{__('account.alert_cancel_btn')}}`,
          showLoaderOnConfirm: true,
          preConfirm: (login) => {
            return fetch('/accounts/'+uuid+'/contact/delete', {
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
            let contactsTable = eval("contactsTable_" + account_id)
            contactsTable.ajax.reload()
          }

        })
      })
      jQuery(document).on('click', '.duplicate-contact', function(){
        let id = jQuery(this).data('id')
        let uuid = jQuery(this).data('uuid')
        let account_id = jQuery(this).data('account-id')
        swalWithMaterialButtons({
          title: `{{__('account.alert_heading')}}`,
          text: `{!!__('account.alert_text')!!}`,
          type: 'info',
          showCancelButton: true,
          confirmButtonText: `{{__('accounts.duplicate_contact_btn')}}`,
          cancelButtonText: `{{__('account.alert_cancel_btn')}}`,
          showLoaderOnConfirm: true,
          preConfirm: (login) => {
            return fetch('/accounts/'+uuid+'/contact/duplicate', {
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
            let contactsTable = eval("contactsTable_" + account_id)
            contactsTable.ajax.reload()
          }

        })
      })
      jQuery(document).on('click', '.move-contact', function(){
        let id = jQuery(this).data('id')
        let uuid = jQuery(this).data('uuid')
        let account_id = jQuery(this).data('account-id')
        var array = JSON.parse(`{!!$accountsArr!!}`)
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
            return fetch('/accounts/'+uuid+'/contact/move', {
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
            let contactsTable = eval("contactsTable_" + account_id)
            let movedcontactsTable = eval("contactsTable_" + result.value.new_account_id)
            contactsTable.ajax.reload()
            movedcontactsTable.ajax.reload()
          }

        })
      })
      jQuery(document).on('submit', 'form[name="addContact"]', function(e){
        e.preventDefault();
        jQuery(this).find('.error').html('')
        let uuid = jQuery(this).closest('.content').find('.tab-content .tab-pane.active a.add-contact').data('uuid')
        let dataArr = new FormData(this);
        jQuery.ajax({
            url: '/accounts/'+uuid+'/contact/add',
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            context: this,
            data:dataArr,
            processData: false,
            contentType: false,
            async: true,
            enctype: "multipart/form-data",
            dataType:'json',
            success: function (res) {
              if(res.success == true){
                jQuery('#add-contacts-Modal').modal('hide')
                jQuery(this)[0].reset();
                setInterval(function() {
                  location.reload();
                }, 1000);
              }else{
                jQuery(this).find('.error').html(res.message);
              }
            }
        });
      });

    })
  </script>
@endsection
