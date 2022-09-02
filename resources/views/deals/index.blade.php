@extends('layouts.app')

@section('styles')
  <link href="{{ asset('js/plugins/selectize/selectize.css')}}" rel="stylesheet" />
@endsection

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">business_center</i>
            </div>
            <h4 class="card-title">
              {{__('deals.title')}}
              <a href="{{url('extensions/deals/settings')}}" class="btn btn-info btn-sm pull-right"><span class="material-icons">settings</span></a>
              <a href="javascript:;" class="btn btn-warning btn-sm pull-right add-deal" data-toggle="modal" data-target="#add-deals-Modal"><span class="material-icons">add</span>{{__('deals.add_new_deal')}}</a>
              <a href="{{url('deals/status')}}" class="btn btn-light btn-sm pull-right">Won/lost</a>
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

            <section>
                <div class="row">
                    <div class="col-sm-4">
                        <a href="javascript:;" class="btn btn-link btm-sm pull-right p-2" data-toggle="modal" data-target="#deal-settings-headline-0-Modal"><i class="material-icons">edit</i></a>
                        <div class="deal-list-sortable-connected" data-status="new">
                            <div class="disabled text-center">
                                <h3 class="card-title deal-group-item"><small>@if($deal_source_headlines->count() > 0) {{($deal_source_headlines[0])?$deal_source_headlines[0]->name:'New'}} @else New @endif</small></h3>
                            </div>
                            @if(!$new_deals->isEmpty())
                              @foreach($new_deals as $deal)
                                <div class="card" data-id="{{$deal->id}}">
                                  <div class="card-body">
                                    <span class="h6">{{date('d/m-y' , strtotime($deal->created_at))}}</span>
                                    <div class="row">
                                      <h5 class="card-title deal-group-item col-sm-8">{{$deal->name}}</h5>
                                      <div class="dropdown show col-sm-4">
                                         <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                           <span class="material-icons">design_services</span>
                                         </a>
                                         <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                           <a class="dropdown-item" href="{{url('/deals/'.$deal->id.'/edit')}}"><i class="material-icons">edit</i>{{__('deals.edit_deal_btn')}}</a>
                                           <a class="dropdown-item delete-deal" href="javascript:;" data-id="{{$deal->id}}"><i class="material-icons">delete</i>{{__('deals.delete_deal_btn')}}</a>
                                           <a class="dropdown-item duplicate-deal" href="javascript:;" data-id="{{$deal->id}}"><i class="material-icons">content_copy</i>{{__('deals.duplicate_deal_btn')}}</a>
                                         </div>
                                       </div>
                                       <a href="javascript:;" class="category col-md-5 text-dark"><i class="material-icons align-bottom mr-2">web</i>{{$deal->Contact->first_name.' '.$deal->Contact->last_name}}</a>
                                       <a href="tel:{{$deal->Contact->telephone}}" class="category col-md-7 text-info"><i class="material-icons align-bottom mr-2">contact_phone</i>{{$deal->Contact->telephone}}</a>
                                       <a href="javascript:;" class="category col-md-5 text-dark"><i class="material-icons align-bottom mr-2">business</i>{{$deal->Contact->company}}</a>
                                       <a href="mailto:{{$deal->Contact->email}}" class="category col-md-7 text-info"><i class="material-icons align-bottom mr-2">contact_mail</i>{{$deal->Contact->email}}</a>
                                    </div>
                                  </div>
                                 </div>
                              @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                      <a href="javascript:;" class="btn btn-link btm-sm pull-right p-2" data-toggle="modal" data-target="#deal-settings-headline-1-Modal"><i class="material-icons">edit</i></a>
                      <div class="deal-list-sortable-connected" data-status="dialog">
                          <div class="disabled text-center">
                              <h3 class="card-title deal-group-item"><small>@if($deal_source_headlines->count() > 1) {{($deal_source_headlines[1])?$deal_source_headlines[1]->name:'Dialog'}} @else Dialog @endif</small></h3>
                          </div>
                          @if(!$dialog_deals->isEmpty())
                            @foreach($dialog_deals as $deal)
                            <div class="card" data-id="{{$deal->id}}">
                              <div class="card-body">
                                <span class="h6">{{date('d/m-y' , strtotime($deal->created_at))}}</span>
                                <div class="row">
                                  <h5 class="card-title deal-group-item col-sm-8">{{$deal->name}}</h5>
                                  <div class="dropdown show col-sm-4">
                                     <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                       <span class="material-icons">design_services</span>
                                     </a>
                                     <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                       <a class="dropdown-item" href="{{url('/deals/'.$deal->id.'/edit')}}"><i class="material-icons">edit</i>{{__('deals.edit_deal_btn')}}</a>
                                       <a class="dropdown-item delete-deal" href="javascript:;" data-id="{{$deal->id}}"><i class="material-icons">delete</i>{{__('deals.delete_deal_btn')}}</a>
                                       <a class="dropdown-item duplicate-deal" href="javascript:;" data-id="{{$deal->id}}"><i class="material-icons">content_copy</i>{{__('deals.duplicate_deal_btn')}}</a>
                                     </div>
                                   </div>
                                   <a href="javascript:;" class="category col-md-5 text-dark"><i class="material-icons align-bottom mr-2">web</i>{{$deal->Contact->first_name.' '.$deal->Contact->last_name}}</a>
                                   <a href="tel:{{$deal->Contact->telephone}}" class="category col-md-7 text-info"><i class="material-icons align-bottom mr-2">contact_phone</i>{{$deal->Contact->telephone}}</a>
                                   <a href="javascript:;" class="category col-md-5 text-dark"><i class="material-icons align-bottom mr-2">business</i>{{$deal->Contact->company}}</a>
                                   <a href="mailto:{{$deal->Contact->email}}" class="category col-md-7 text-info"><i class="material-icons align-bottom mr-2">contact_mail</i>{{$deal->Contact->email}}</a>
                                </div>
                              </div>
                             </div>
                            @endforeach
                          @endif
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <a href="javascript:;" class="btn btn-link btm-sm pull-right p-2" data-toggle="modal" data-target="#deal-settings-headline-2-Modal"><i class="material-icons">edit</i></a>
                      <div class="deal-list-sortable-connected" data-status="proposal">
                          <div class="disabled text-center">
                              <h3 class="card-title deal-group-item"><small>@if($deal_source_headlines->count() > 2) {{($deal_source_headlines[2])?$deal_source_headlines[2]->name:'Proposal'}} @else Proposal @endif</small></h3>
                          </div>
                          @if(!$proposal_deals->isEmpty())
                            @foreach($proposal_deals as $deal)
                            <div class="card" data-id="{{$deal->id}}">
                              <div class="card-body">
                                <span class="h6">{{date('d/m-y' , strtotime($deal->created_at))}}</span>
                                <div class="row">
                                  <h5 class="card-title deal-group-item col-sm-8">{{$deal->name}}</h5>
                                  <div class="dropdown show col-sm-4">
                                     <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                       <span class="material-icons">design_services</span>
                                     </a>
                                     <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                       <a class="dropdown-item" href="{{url('/deals/'.$deal->id.'/edit')}}"><i class="material-icons">edit</i>{{__('deals.edit_deal_btn')}}</a>
                                       <a class="dropdown-item delete-deal" href="javascript:;" data-id="{{$deal->id}}"><i class="material-icons">delete</i>{{__('deals.delete_deal_btn')}}</a>
                                       <a class="dropdown-item duplicate-deal" href="javascript:;" data-id="{{$deal->id}}"><i class="material-icons">content_copy</i>{{__('deals.duplicate_deal_btn')}}</a>
                                     </div>
                                   </div>
                                   <a href="javascript:;" class="category col-md-5 text-dark"><i class="material-icons align-bottom mr-2">web</i>{{$deal->Contact->first_name.' '.$deal->Contact->last_name}}</a>
                                   <a href="tel:{{$deal->Contact->telephone}}" class="category col-md-7 text-info"><i class="material-icons align-bottom mr-2">contact_phone</i>{{$deal->Contact->telephone}}</a>
                                   <a href="javascript:;" class="category col-md-5 text-dark"><i class="material-icons align-bottom mr-2">business</i>{{$deal->Contact->company}}</a>
                                   <a href="mailto:{{$deal->Contact->email}}" class="category col-md-7 text-info"><i class="material-icons align-bottom mr-2">contact_mail</i>{{$deal->Contact->email}}</a>
                                </div>
                              </div>
                             </div>
                            @endforeach
                          @endif
                      </div>
                    </div>
                </div>
            </section>
            <div class="navbar fixed-bottom mb-0 sticky-deals">
                <div class="col-sm-6">
                    <div class="deal-list-sortable-connected bg-info" data-status="won">
                        <div class="disabled text-center">
                            <h3 class="card-title deal-group-item"><small>Won</small></h3>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="deal-list-sortable-connected bg-danger" data-status="lost">
                        <div class="disabled text-center">
                            <h3 class="card-title deal-group-item"><small>Lost</small></h3>
                        </div>
                    </div>
                </div>
              </div>
          </div>

        </div>
      </div>
      <div class="modal fade" id="add-deals-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Add Deals</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form name="addDeal" method="POST" id="addDeal">
              <div class="modal-body">
                @csrf
                <div class="form-group">
                  <label for="role" class="bmd-label-floating"> {{__('deals.deal_name')}}</label>
                  <input type="text" class="form-control" name="name" required value="{{ old('name')}}">
                </div>
                <div class="form-group">
                  <select name="deal_account">
                    @if(!$accounts->isEmpty())
                      <option></option>
                      @foreach($accounts as $accounts)
                        <option value="{{$accounts->id}}">{{$accounts->name}}</option>
                      @endforeach
                    @endif
                  </select>
                </div>
                <div class="form-group">
                  <select name="deal_contact">
                    <option>{{__('deals.no_contacts_text')}}</option>
                  </select>
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
      <div class="modal fade" id="deal-settings-headline-0-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Add Headline</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="deal-setting-0" name="deal-setting-0" method="POST" class="deal-settings">
              <div class="modal-body">
                @csrf
                <div class="form-group">
                  <label for="name" class="bmd-label-floating"> Heading</label>
                  <input type="text" class="form-control" name="name" required="required" value="@if($deal_source_headlines->count() > 0) {{($deal_source_headlines[0])?$deal_source_headlines[0]->name:''}}@endif">
                  <input type="hidden" class="form-control" name="index" value="@if($deal_source_headlines->count() > 0) {{($deal_source_headlines[0])?$deal_source_headlines[0]->id:0}}@endif">
                </div>

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
      <div class="modal fade" id="deal-settings-headline-1-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Add Headline</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="deal-setting-1" name="deal-setting-1" method="POST" class="deal-settings">
              <div class="modal-body">
                @csrf
                <div class="form-group">
                  <label for="name" class="bmd-label-floating"> Heading</label>
                  <input type="text" class="form-control" name="name" required="true" value="@if($deal_source_headlines->count() > 1) {{($deal_source_headlines[1])?$deal_source_headlines[1]->name:''}}@endif">
                  <input type="hidden" class="form-control" name="index" value="@if($deal_source_headlines->count() > 1) {{($deal_source_headlines[1])?$deal_source_headlines[1]->id:0}}@endif">
                </div>
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
      <div class="modal fade" id="deal-settings-headline-2-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Add Headline</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="deal-setting-2" name="deal-setting-2" method="POST" class="deal-settings">
              <div class="modal-body">
                @csrf
                <div class="form-group">
                  <label for="name" class="bmd-label-floating"> Heading</label>
                  <input type="text" class="form-control" name="name" required="true" value="@if($deal_source_headlines->count() > 2) {{($deal_source_headlines[2])?$deal_source_headlines[2]->name:''}}@endif">
                  <input type="hidden" class="form-control" name="index" value="@if($deal_source_headlines->count() > 2) {{($deal_source_headlines[2])?$deal_source_headlines[2]->id:0}}@endif">
                </div>
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
    </div>
  </div>
</div>

@endsection

@section('scripts')
  <script src="{{ asset('js/plugins/jquery.sortable.min.js')}}" type="text/javascript"></script>
  <script>
      const swalWithMaterialButtons = Swal.mixin({
        confirmButtonClass: 'btn btn-success btn-sm',
        cancelButtonClass: 'btn btn-danger btn-sm',
        buttonsStyling: false,
      })
      jQuery(document).ready(function(){
        jQuery('.deal-list-sortable-connected').sortable({
            placeholderClass: 'deal-group-item',
            connectWith: '.connected',
            forcePlaceholderSize: true,
            items: ':not(.disabled)',
        })
        jQuery('.deal-list-sortable-connected').sortable().bind('sortconnect', function(e, ui) {
            let id = ui.item.data('id')
            let status = ui.item.closest('.deal-list-sortable-connected').data('status')
            jQuery.ajax({
                url: `{{url('/deals/update/status')}}`,
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify({id: id, status: status}),
                dataType: 'json',
                context: this,
                success: function (res) {

                }
            });
        });
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

        jQuery(document).on('click', '.duplicate-deal', function(){
          let id = jQuery(this).data('id')
          swalWithMaterialButtons({
            title: `{{__('account.alert_heading')}}`,
            text: `{!!__('account.alert_text')!!}`,
            type: 'info',
            showCancelButton: true,
            confirmButtonText: `YES, DUPLICATE IT`,
            cancelButtonText: `{{__('account.alert_cancel_btn')}}`,
            showLoaderOnConfirm: true,
            preConfirm: (login) => {
              return fetch('/deals/'+id+'/duplicate', {
                  method: 'GET',
                  headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                  },
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
      })
  </script>
  <script src="{{ asset('js/plugins/selectize/selectize.js')}}" type="text/javascript"></script>
  <script>
    jQuery(document).ready(function(){
      jQuery('select[name="deal_account"]').selectize({
         placeholder : `{{__('accounts.title')}}`,
      });
      let deal_contact = jQuery('select[name="deal_contact"]').selectize({
         placeholder : `{{__('accounts.contact_title')}}`,
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

      jQuery(document).on('submit', 'form[name="addDeal"]', function(e){
        e.preventDefault();
        jQuery(this).find('.error').html('')
        let dataArr = jQuery(this).serializeArray()
        jQuery.ajax({
            url: '/deals/add',
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            context: this,
            data:dataArr,
            dataType:'json',
            success: function (res) {
              if(res.success == true){
                jQuery('#add-deals-Modal').modal('hide')
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
      jQuery(document).on('submit', 'form.deal-settings', function(e){
        e.preventDefault();
        let dataArr = jQuery(this).serializeArray()
        jQuery.ajax({
            url: '/deals/settings',
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            context: this,
            data:dataArr,
            dataType:'json',
            success: function (res) {
              if(res.success == true){
                jQuery(this).closest('.modal').modal('hide')
                jQuery(this)[0].reset();
                setInterval(function() {
                  location.reload();
                }, 1000);
              }
            }
        });
      });
    })
  </script>
@endsection
