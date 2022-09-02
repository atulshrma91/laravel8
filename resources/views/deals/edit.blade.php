@extends('layouts.app')

@section('styles')
  <link href="{{ asset('js/plugins/selectize/selectize.css')}}" rel="stylesheet" />
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endsection

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-icon card-header-info">
              <div class="card-icon">
                <i class="material-icons">follow_the_signs</i>
              </div>
              <h4 class="card-title">{{__('deals.title')}}
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
              <form method="POST" id="editDeal" action="{{url('/deals/'.$deal->id.'/edit')}}">
                @csrf
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="role" class="bmd-label-floating"> {{__('deals.deal_name')}}</label>
                      <input type="text" class="form-control" name="name" required value="{{ $deal->name}}">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <select name="deal_account">
                        @if(!$accounts->isEmpty())
                          <option></option>
                          @foreach($accounts as $accounts)
                            <option value="{{$accounts->id}}" {{($accounts->id == $deal->account_id)?'selected="selected"':''}}>{{$accounts->name}}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <select name="deal_contact">
                        @if(!$contacts->isEmpty())
                          <option>Contacts</option>
                          @foreach($contacts as $contact)
                            <option value="{{$contact->id}}" {{($contact->id == $deal->contact_id)?'selected="selected"':''}}>{{$contact->first_name.' '.$contact->last_name}}</option>
                          @endforeach
                        @else
                        <option>{{__('deals.no_contacts_text')}}</option>
                        @endif
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group text-center mt-5 pull-right">
                  <a href="javascript:;" class="btn btn-danger btn-sm delete-deal" data-id="{{$deal->id}}">{{__('deals.delete_deal_btn')}}</a>
                  <a href="{{url('/deals')}}" class="btn btn-default btn-sm">{{__('deals.back_btn')}}</a>
                  <button type="submit" class="btn btn-info btn-sm">{{__('deals.update_deal_btn')}}</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <h4 class="card-title">
              <a href="{{url('extensions/deals/settings')}}" class="btn btn-info btn-sm pull-right"><span class="material-icons">settings</span></a>
              <a href="javascript:;" class="btn btn-warning btn-sm pull-right add-deal" data-toggle="modal" data-target="#add-deals-comments-Modal"><span class="material-icons">add</span>New Comment</a>
            </h4>
          </div>
          <div class="card-body">
            <section>
              <div class="material-datatables">
                <table id="dealCommentsTable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Category</th>
                      <th>Comment</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </section>
          </div>
        </div>
      </div>
      <div class="modal fade" id="add-deals-comments-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Add Comment</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form name="addDealComment" method="POST" id="addDealComment">
              <div class="modal-body">
                @csrf
                <input type="hidden" name="deal_id" value="{{$deal->id}}">
                <div class="form-group">
                  <input type="text" id="datepicker" placeholder="Date" name="date">
                </div>
                <div class="form-group">
                  <select name="deal_category">
                    @if(!$dealCategories->isEmpty())
                      <option></option>
                      @foreach($dealCategories as $dealCategory)
                        <option value="{{$dealCategory->id}}">{{$dealCategory->name}}</option>
                      @endforeach
                    @endif
                  </select>
                </div>
                <div class="form-group">
                  <textarea name="comment" class="form-control" placeholder="Comment"></textarea>
                </div>
                <span class="error text-danger"></span>
              </div>

              <div class="modal-footer">
                <div class="form-group">
                  <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal fade" id="edit-deals-comments-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Comment</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form name="editDealComment" method="POST" id="editDealComment">
              <div class="modal-body">
                @csrf
                <input type="hidden" name="id" value="">
                <div class="form-group">
                  <input type="text" id="edit-datepicker" placeholder="Date" name="date">
                </div>
                <div class="form-group">
                  <select name="deal_category">
                    @if(!$dealCategories->isEmpty())
                      <option></option>
                      @foreach($dealCategories as $dealCategory)
                        <option value="{{$dealCategory->id}}">{{$dealCategory->name}}</option>
                      @endforeach
                    @endif
                  </select>
                </div>
                <div class="form-group">
                  <textarea name="comment" class="form-control" placeholder="Comment"></textarea>
                </div>
                <span class="error text-danger"></span>
              </div>

              <div class="modal-footer">
                <div class="form-group">
                  <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                </div>
              </div>
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
  <script src="{{ asset('js/plugins/selectize/selectize.js')}}" type="text/javascript"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script>
  jQuery( "#datepicker" ).datepicker({ dateFormat: 'dd-mm-yy' });
    const swalWithMaterialButtons = Swal.mixin({
      confirmButtonClass: 'btn btn-success btn-sm',
      cancelButtonClass: 'btn btn-danger btn-sm',
      buttonsStyling: false,
    })
    jQuery(document).ready(function(){
      jQuery('select[name="deal_account"]').selectize({
         placeholder : `{{__('accounts.title')}}`,
      });
      let deal_contact = jQuery('select[name="deal_contact"]').selectize({
         placeholder : `{{__('accounts.contact_title')}}`,
      });
      let deal_category =  jQuery('select[name="deal_category"]').selectize({
         placeholder : `Category`,
      });

      jQuery(document).on('change', 'select[name="deal_account"]', function(){
        let id = jQuery(this).val()
        jQuery.ajax({
            url: `{{url('/deals/account/contacts')}}`,
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify({id: id}),
            dataType: 'json',
            context: this,
            success: function (res) {
              if(res.contacts.length > 0){
                deal_contact[0].selectize.settings.placeholder = `{{__('accounts.contact_title')}}`;
                deal_contact[0].selectize.updatePlaceholder();
                deal_contact[0].selectize.clear();
                deal_contact[0].selectize.clearOptions();
                res.contacts.forEach(function (contact) {
                    deal_contact[0].selectize.addOption({value:contact.id,text:contact.first_name+' '+contact.last_name});
                });
              }else{
                deal_contact[0].selectize.settings.placeholder = `{{__('deals.no_contacts_text')}}`;
                deal_contact[0].selectize.updatePlaceholder();
                deal_contact[0].selectize.clear();
                deal_contact[0].selectize.clearOptions();
              }
            }
        });
      })
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

      jQuery(document).on('submit', 'form[name="addDealComment"]', function(e){
        e.preventDefault();
        jQuery(this).find('.error').html('')
        let dataArr = jQuery(this).serializeArray()
        jQuery.ajax({
            url: '/deals/{{$deal->id}}/comments/add',
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            context: this,
            data:dataArr,
            dataType:'json',
            success: function (res) {
              if(res.success == true){
                jQuery('#add-deals-comments-Modal').modal('hide')
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
      jQuery(document).on('click', '.delete-comment', function(){
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
            return fetch('/deals/comment/'+id+'/delete', {
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

      jQuery(document).on('click', '.edit-comment', function(e){
        e.preventDefault();
        jQuery(this).find('.error').html('')
        let id = jQuery(this).data('id')
        jQuery.ajax({
            url: '/deals/'+id+'/comment/get',
            method: 'GET',
            headers: {
              'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            context: this,
            dataType:'json',
            success: function (res) {
              let form = jQuery('#edit-deals-comments-Modal').find('form')
              form[0].reset();
              if(res.success == true){
                jQuery( "#edit-datepicker" ).datepicker({ dateFormat: 'dd-mm-yy' });
                jQuery('#edit-deals-comments-Modal').modal('show')
                form.find('input[name="date"]').val(res.data.date);
                form.find('input[name="id"]').val(res.data.id);
                form.find('textarea[name="comment"]').val(res.data.comment);
              }else{
                jQuery(this).find('.error').html(res.message);
              }
            }
        });
      });

      jQuery(document).on('submit', 'form[name="editDealComment"]', function(e){
        e.preventDefault();
        jQuery(this).find('.error').html('')
        let id = jQuery(this).closest('form').find('input[name="id"]').val();
        let dataArr = jQuery(this).serializeArray()
        jQuery.ajax({
            url: '/deals/'+id+'/comment/update',
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            context: this,
            data:dataArr,
            dataType:'json',
            success: function (res) {
              if(res.success == true){
                jQuery('#edit-deals-comments-Modal').modal('hide')
                let form = jQuery('#edit-deals-comments-Modal').find('form')
                form[0].reset();
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

    const commentsTable = jQuery('#dealCommentsTable').DataTable({
       processing: true,
       serverSide: true,
       ajax: {
          "url": "{{route('deal.comments', ['id' => $deal->id])}}",
          "data": function ( d ) {
              d.deal_id = "{{$deal->id}}";
          }
        },
       columns: [
          { data: 'date' },
          { data: 'deal_category_id' },
          { data: 'comment' },
          { data: 'actions' }
       ],
       columnDefs: [
          { orderable: false, targets: 3 }
       ],
       pagingType: "full_numbers",
       lengthMenu: [
         [5, 25, 50],
         [5, 25, 50]
       ],
       responsive: true,
       language: {
         search: "_INPUT_",
         searchPlaceholder: `Search Comments`,
         infoFiltered: ""
       },
       order: [[ 0, "desc" ]]
    });
  </script>
@endsection
