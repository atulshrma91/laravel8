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
            <div class="card-header card-header-icon card-header-info">
              <div class="card-icon">
                <i class="material-icons">content_paste</i>
              </div>
              <h4 class="card-title">Form
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
              <form method="POST" id="addform" action="{{url('/forms/'.$form->uuid.'/edit')}}" enctype="multipart/form-data">
                @csrf

                  <div class="form-group w-25">
                    <label for="name" class="bmd-label-floating">Name</label>
                    <input type="text" class="form-control" name="name" value="{{ $form->name}}" required>
                  </div>
                  <div class="form-group w-50">
                    <label for="headline" class="bmd-label-floating"> Headline</label>
                    <input type="text" class="form-control" name="headline" value="{{ $form->headline}}">
                  </div>
                  <div class="form-group w-50">
                    <label for="introduction" class="bmd-label-floating"> Introduction</label>
                    <textarea name="introduction" class="form-control input-lg">{{ $form->introduction}}</textarea>
                  </div>
                  <div class="form-group">
                    <h4 class="font-weight-normal">Contact information</h4>
                    <div class="row">
                      <div class="col-md-2">

                      </div>
                      <div class="col-md-1">
                        <h5 class="font-weight-normal">Show in form?</h5>
                      </div>
                      <div class="col-md-9">
                        <h5 class="font-weight-normal">Required?</h5>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <small class="h5 align-middle text-dark font-weight-light">Role</small>
                      </div>
                      <div class="col-md-1">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_displayed_role" {{($form->is_displayed_role)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-9">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_required_role" {{($form->is_required_role)?'checked="checked"':''}}>
                            <span class="toggle"> {{ old('is_required_role')}}</span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <small class="h5 align-middle text-dark font-weight-light">First Name</small>
                      </div>
                      <div class="col-md-1">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_displayed_first_name" {{($form->is_displayed_first_name)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-9">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_required_first_name" {{($form->is_required_first_name)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <small class="h5 align-middle text-dark font-weight-light">Last Name</small>
                      </div>
                      <div class="col-md-1">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_displayed_last_name" {{($form->is_displayed_last_name)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-9">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_required_last_name" {{($form->is_required_last_name)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <small class="h5 align-middle text-dark font-weight-light">Email</small>
                      </div>
                      <div class="col-md-1">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_displayed_email" {{($form->is_displayed_email)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-9">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_required_email" {{($form->is_required_email)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <small class="h5 align-middle text-dark font-weight-light">Telephone</small>
                      </div>
                      <div class="col-md-1">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_displayed_telephone" {{($form->is_displayed_telephone)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-9">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_required_telephone" {{($form->is_required_telephone)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <small class="h5 align-middle text-dark font-weight-light">Profile Image</small>
                      </div>
                      <div class="col-md-1">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_displayed_profile_image" {{($form->is_displayed_profile_image)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-9">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_required_profile_image" {{($form->is_required_profile_image)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <h4 class="font-weight-normal">Company information</h4>
                    <div class="row">
                      <div class="col-md-2">

                      </div>
                      <div class="col-md-1">
                        <h5 class="font-weight-normal">Show in form?</h5>
                      </div>
                      <div class="col-md-9">
                        <h5 class="font-weight-normal">Required?</h5>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-2">
                        <small class="h5 align-middle text-dark font-weight-light">Website</small>
                      </div>
                      <div class="col-md-1">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_displayed_website" {{($form->is_displayed_website)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-9">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_required_website" {{($form->is_required_website)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <small class="h5 align-middle text-dark font-weight-light">Company</small>
                      </div>
                      <div class="col-md-1">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_displayed_company" {{($form->is_displayed_company)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-9">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_required_company" {{($form->is_required_company)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <small class="h5 align-middle text-dark font-weight-light">CVR Number</small>
                      </div>
                      <div class="col-md-1">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_displayed_cvr_number" {{($form->is_displayed_cvr_number)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-9">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_required_cvr_number" {{($form->is_required_cvr_number)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <small class="h5 align-middle text-dark font-weight-light">Address</small>
                      </div>
                      <div class="col-md-1">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_displayed_address" {{($form->is_displayed_address)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-9">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_required_address" {{($form->is_required_address)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <small class="h5 align-middle text-dark font-weight-light">Company Telephone</small>
                      </div>
                      <div class="col-md-1">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_displayed_company_telephone" {{($form->is_displayed_company_telephone)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-9">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_required_company_telephone" {{($form->is_required_company_telephone)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <small class="h5 align-middle text-dark font-weight-light">Company Email</small>
                      </div>
                      <div class="col-md-1">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_displayed_company_email" {{($form->is_displayed_company_email)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-9">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_required_company_email" {{($form->is_required_company_email)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <small class="h5 align-middle text-dark font-weight-light">Logo</small>
                      </div>
                      <div class="col-md-1">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_displayed_logo" {{($form->is_displayed_logo)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-9">
                        <div class="togglebutton">
                          <label>
                            <input type="checkbox" value="1" name="is_required_logo" {{($form->is_required_logo)?'checked="checked"':''}}>
                            <span class="toggle"></span>
                          </label>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="form-group">
                    <h4 for="name" class="font-weight-normal">Customized fields</h4>
                    <div id="customized_fields_sec">
                    @if(!$form->FormCustomizedFields->isEmpty())
                      @foreach($form->FormCustomizedFields as $customizedField)
                        <div class="row">
                          <div class="col-md-2">
                            <small class="h5 align-middle text-dark font-weight-light">{{$customizedField->name}}</small>
                          </div>
                          <div class="col-md-1">
                            <span>{{$customizedField->type}}</span>
                          </div>
                          <div class="col-md-1">
                            <a href="javascript:;" class="btn btn-info btn-sm customized-field-edit" data-id="{{$customizedField->id}}"><span class="material-icons">edit</span>Edit</a>
                          </div>
                          <div class="col-md-8">
                            <a href="javascript:;" class="btn btn-danger btn-sm customized-field-delete" data-id="{{$customizedField->id}}"><span class="material-icons">delete</span>Delete</a>
                          </div>
                        </div>
                      @endforeach
                    @endif
                    </div>
                    <div class="row">
                      <div class="col-md-5">
                        <a href="javascript:;" class="btn btn-link btn-sm pull-right btn-outline-info" data-toggle="modal" data-target="#customized-fields-Modal"><span class="material-icons">add</span>Add customized fields</a>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="form-group">
                    <h4 for="name" class="font-weight-normal">Deals</h4>
                    <div class="togglebutton">
                      <label>
                        <small class="h5 align-middle text-dark font-weight-light">Add new contact to deals</small>
                        <input type="checkbox" value="1" name="add_to_deals" {{$form->add_to_deals?'checked="checked"':''}}>
                        <span class="toggle"></span>
                      </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2">
                      @if(\Auth::user()->isExtensionActivated('categories'))
                      @if(!$categories->isEmpty())
                      <label for="category" class="bmd-label-floating">Category</label>
                        <select class="form-control" name="category_id">
                        <option value="">Category</option>
                        @foreach($categories as $category)
                          <option value="{{$category->id}}" {{($form->category_id == $category->id)?"selected":''}}>{{$category->name}}</option>
                        @endforeach
                        </select>
                      @endif
                      @endif
                    </div>
                  </div>
                  <div class="form-group text-center mt-5">
                    <a href="{{url('form/'.$form->uuid)}}" class="btn btn-warning btn-sm" target="_blank">Preview</a>
                    <a href="javascript:;" class="btn btn-danger btn-sm delete-form" data-id="{{$form->id}}">Delete</a>
                    <a href="{{url('/forms')}}" class="btn btn-default btn-sm">Cancel</a>
                    <button type="submit" class="btn btn-info btn-sm">Update</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
        <div class="modal fade" id="customized-fields-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Add Customized field</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form name="customized-fields-form" id="customizedFieldsForm">
                <div class="modal-body">
                  @csrf
                  <div class="form-group">
                    <label for="name" class="bmd-label-floating">Name</label>
                    <input type="text" class="form-control" name="name" required>
                  </div>
                  <div class="form-group">
                    <label for="type" class="bmd-label-floating"></label>
                    <select class="form-control" name="type">
                      <option value="text">Text</option>
                      <option value="longtext">Long Text</option>
                      <option value="number">Number</option>
                      <option value="dropdown">Dropdown</option>
                      <option value="checkboxes">Checkboxes</option>
                    </select>
                  </div>
                  <div class="type-custom-fields">

                  </div>
                  <div class="form-group">
                    <div class="togglebutton">
                      <label>
                        <input type="checkbox" value="1" name="is_required">
                        <span class="toggle"></span>
                        Is required?
                      </label>
                    </div>
                  </div>
                  <div class="options_selection d-none">
                    <label for="name" class="bmd-label-floating">Number of choices respondents must answer:</label>
                    <div class="form-row">
                      <div class="col">
                        <select class="form-control" name="options_selection">
                          <option value="atleast">Atleast</option>
                          <option value="atmost">Atmost</option>
                          <option value="exactly">Exactly</option>
                          <option value="range">Range</option>
                        </select>
                      </div>
                      <div class="col" id="other_option_selection">
                        <input type="number" class="form-control" name="options_selection_choice" value="0" placeholder="Number">
                      </div>
                      <div class="col d-none" id="range_option_selection">
                        <span class="mr-2 align-middle">from</span>
                        <div class="form-group d-inline-block w-25">
                          <input type="number" class="form-control w-50" name="options_selection_range_choice[]" value="0" placeholder="Number">
                        </div>
                        <span class="mr-2 align-middle">to</span>
                        <div class="form-group d-inline-block w-25">
                          <input type="number" class="form-control w-50" name="options_selection_range_choice[]" value="1" placeholder="Number">
                        </div>
                      </div>
                    </div>
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
        <div id="customized-field-edit-modal">

        </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
  <script src="{{ asset('js/plugins/selectize/selectize.js')}}" type="text/javascript"></script>
  <script>
  const swalWithMaterialButtons = Swal.mixin({
    confirmButtonClass: 'btn btn-success btn-sm',
    cancelButtonClass: 'btn btn-danger btn-sm',
    buttonsStyling: false,
  })
  jQuery(document).ready(function(){
    jQuery('select[name="category_id"]').selectize({
       placeholder : `Category`,
    });
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
          window.location.href = result.value.url
        }

      })
    })
    jQuery(document).on('change', '#customized-fields-Modal select[name="type"]', function(){
       jQuery('#customized-fields-Modal .type-custom-fields').html('')
       if(!jQuery('#customized-fields-Modal .options_selection').hasClass('d-none')){
         jQuery('#customized-fields-Modal .options_selection').addClass('d-none')
       }
       if(jQuery('#customized-fields-Modal').find('input[name="is_required"]').closest('.form-group').hasClass('d-none')){
         jQuery('#customized-fields-Modal').find('input[name="is_required"]').closest('.form-group').removeClass('d-none')
       }
       let type = jQuery(this).val();
       if(type == 'dropdown'){
         jQuery('#customized-fields-Modal .type-custom-fields').append('<div class="form-group w-75"><input type="text" class="form-control d-inline w-75" name="option_name[]" placeholder="Option Name"><span class="material-icons align-middle remove-customized-field-option" role="crmbutton">delete_outline</span></div>')
         jQuery('#customized-fields-Modal .type-custom-fields').append('<div class="form-group w-75"><a href="javascript:;" class="btn btn-default btn-sm type_add_options"><span class="material-icons">add</span>Add options</a></div>')
       }else if(type == 'checkboxes'){
         jQuery('#customized-fields-Modal .type-custom-fields').append('<div class="form-group w-75"><input type="text" class="form-control d-inline w-75" name="option_name[]" placeholder="Option Name"><span class="material-icons align-middle remove-customized-field-option" role="crmbutton">delete_outline</span></div>')
         jQuery('#customized-fields-Modal .type-custom-fields').append('<div class="form-group w-75"><a href="javascript:;" class="btn btn-default btn-sm type_add_options"><span class="material-icons">add</span>Add options</a></div>')
         jQuery('#customized-fields-Modal .options_selection').removeClass('d-none')
         jQuery('#customized-fields-Modal').find('input[name="is_required"]').closest('.form-group').addClass('d-none')
       }
    });
    jQuery(document).on('click', '#customized-fields-Modal .type_add_options', function(){
      var form_group = jQuery(this).closest('.form-group');
      jQuery('<div class="form-group w-75"><input type="text" class="form-control d-inline w-75" name="option_name[]" placeholder="Option Name"><span class="material-icons align-middle remove-customized-field-option" role="crmbutton">delete_outline</span></div>').insertBefore(form_group);
    });
    jQuery(document).on('click', '.remove-customized-field-option', function(){
      jQuery(this).parent().remove()
    });
    jQuery(document).on('submit', 'form[name="customized-fields-form"]', function(e){
      e.preventDefault();
      let dataArr = jQuery(this).serialize()
      jQuery.ajax({
          url: '/forms/{{$form->id}}/add-customized-fields',
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
          },
          context: this,
          data:dataArr,
          success: function (res) {
            if(res.success == true){
              jQuery('#customized-fields-Modal').modal('hide')
              jQuery('#customized-fields-Modal .type-custom-fields').html('')
              if(!jQuery('#customized-fields-Modal .options_selection').hasClass('d-none')){
                jQuery('#customized-fields-Modal .options_selection').addClass('d-none')
              }
              if(jQuery('#customized-fields-Modal').find('input[name="is_required"]').closest('.form-group').hasClass('d-none')){
                jQuery('#customized-fields-Modal').find('input[name="is_required"]').closest('.form-group').removeClass('d-none')
              }
              jQuery('#customized_fields_sec').append(res.output)
              jQuery(this)[0].reset();
            }
          }
      });
    });
    jQuery(document).on('click', '.customized-field-delete', function(){
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
          return fetch('/forms/'+id+'/delete-customized-fields', {
              method: 'GET',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
              },
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
          jQuery(this).closest('.row').remove();
        }

      })
    })
    jQuery(document).on('click', '.customized-field-edit', function(){
      jQuery('#customized-field-edit-modal').html('')
      let id = jQuery(this).data('id')
      jQuery.ajax({
          url: '/forms/'+id+'/update-customized-fields',
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
          },
          context: this,
          success: function (res) {
            if(res.success == true){
              jQuery('#customized-field-edit-modal').html(res.output)
              jQuery('#edit-customized-fields-Modal').modal('show')
            }
          }
      });
    })
    jQuery(document).on('change', '#edit-customized-fields-Modal select[name="type"]', function(){
       jQuery('#edit-customized-fields-Modal .type-custom-fields').html('')
       if(!jQuery('#edit-customized-fields-Modal .options_selection').hasClass('d-none')){
         jQuery('#edit-customized-fields-Modal .options_selection').addClass('d-none')
       }
       if(jQuery('#edit-customized-fields-Modal').find('input[name="is_required"]').closest('.form-group').hasClass('d-none')){
         jQuery('#edit-customized-fields-Modal').find('input[name="is_required"]').closest('.form-group').removeClass('d-none')
       }
       let type = jQuery(this).val();
       if(type == 'dropdown'){
         jQuery('#edit-customized-fields-Modal .type-custom-fields').append('<div class="form-group w-75"><input type="text" class="form-control d-inline w-75" name="option_name[]" placeholder="Option Name"><span class="material-icons align-middle remove-customized-field-option" role="crmbutton">delete_outline</span></div>')
         jQuery('#edit-customized-fields-Modal .type-custom-fields').append('<div class="form-group w-75"><a href="javascript:;" class="btn btn-default btn-sm type_add_options"><span class="material-icons">add</span>Add options</a></div>')
       }else if(type == 'checkboxes'){
         jQuery('#edit-customized-fields-Modal .type-custom-fields').append('<div class="form-group w-75"><input type="text" class="form-control d-inline w-75" name="option_name[]" placeholder="Option Name"><span class="material-icons align-middle remove-customized-field-option" role="crmbutton">delete_outline</span></div>')
         jQuery('#edit-customized-fields-Modal .type-custom-fields').append('<div class="form-group w-75"><a href="javascript:;" class="btn btn-default btn-sm type_add_options"><span class="material-icons">add</span>Add options</a></div>')
         jQuery('#edit-customized-fields-Modal .options_selection').removeClass('d-none')
         jQuery('#edit-customized-fields-Modal').find('input[name="is_required"]').closest('.form-group').addClass('d-none')
       }
    });
    jQuery(document).on('click', '#edit-customized-fields-Modal .type_add_options', function(){
      var form_group = jQuery(this).closest('.form-group');
      jQuery('<div class="form-group w-75"><input type="text" class="form-control d-inline w-75" name="option_name[]" placeholder="Option Name"><span class="material-icons align-middle remove-customized-field-option" role="crmbutton">delete_outline</span></div>').insertBefore(form_group);
    });
    jQuery(document).on('submit', 'form[name="customized-fields-edit-form"]', function(e){
      e.preventDefault();
      let id = jQuery(this).data('id')
      let dataArr = jQuery(this).serializeArray()
      jQuery.ajax({
          url: '/forms/'+id+'/update-customized-fields',
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
          },
          context: this,
          data:dataArr,
          dataType:'json',
          success: function (res) {
            if(res.success == true){
              jQuery('#edit-customized-fields-Modal').modal('hide')
              let edit_btn = jQuery("a.customized-field-edit[data-id='" + id + "']")
              jQuery(edit_btn).closest('.row').find('div:nth-child(1)').html('<small class="h5 align-middle text-dark font-weight-light">'+res.customized_fields.name+'</small>')
              jQuery(edit_btn).closest('.row').find('div:eq(1)').html('<span>'+res.customized_fields.type+'</span>')
              jQuery(this)[0].reset();
            }
          }
      });
    });
    jQuery(document).on('change', '.options_selection select[name="options_selection"]', function(){
      let val = jQuery(this).val()
      if(val == 'range'){
        jQuery('.options_selection #range_option_selection').removeClass('d-none')
        jQuery('.options_selection #other_option_selection').addClass('d-none')
      }else{
        jQuery('.options_selection #range_option_selection').addClass('d-none')
        jQuery('.options_selection #other_option_selection').removeClass('d-none')
      }
    })
  })
  </script>
@endsection
