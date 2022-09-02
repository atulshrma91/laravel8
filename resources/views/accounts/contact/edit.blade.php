@extends('layouts.app')

@section('styles')

@endsection

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-icon card-header-info">
              <div class="card-icon">
                <i class="material-icons">corporate_fare</i>
              </div>
              <h4 class="card-title">{{__('accounts.contact_title')}}
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
              <form method="POST" id="editContact" action="{{url('/accounts/'.$account->uuid.'/contact/edit/'.$contact->id)}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="role" class="bmd-label-floating"> {{__('accounts.contact_role')}}</label>
                      <input type="text" class="form-control" name="role" value="{{$contact->role}}">
                    </div>
                    <div class="form-group">
                      <label for="first_name" class="bmd-label-floating"> {{__('accounts.contact_firstname')}}</label>
                      <input type="text" class="form-control" name="first_name" value="{{$contact->first_name}}">
                    </div>
                    <div class="form-group">
                      <label for="last_name" class="bmd-label-floating"> {{__('accounts.contact_lastname')}}</label>
                      <input type="text" class="form-control" name="last_name" value="{{$contact->last_name}}">
                    </div>
                    <div class="form-group">
                      <label for="email" class="bmd-label-floating"> {{__('accounts.contact_email')}}</label>
                      <input type="email" class="form-control" name="email"  value="{{$contact->email}}">
                    </div>
                    <div class="form-group">
                      <label for="telephone" class="bmd-label-floating"> {{__('accounts.contact_telephone')}}</label>
                      <input type="text" class="form-control" name="telephone" value="{{$contact->telephone}}">
                    </div>
                    <div class="form-group">
                      <label for="website" class="bmd-label-floating"> {{__('accounts.contact_website')}}</label>
                      <input type="text" class="form-control" name="website" value="{{$contact->website}}">
                    </div>
                    <div class="form-group">
                      <label for="company" class="bmd-label-floating"> {{__('accounts.contact_company')}}</label>
                      <input type="text" class="form-control" name="company"  value="{{$contact->company}}">
                    </div>
                    <div class="form-group">
                      <label for="cvr_number" class="bmd-label-floating"> {{__('accounts.contact_company_cvr_no')}}</label>
                      <input type="text" class="form-control" name="cvr_number"  value="{{$contact->cvr_number}}">
                    </div>
                    <div class="form-group">
                      <label for="company_address" class="bmd-label-floating"> {{__('accounts.contact_address')}}</label>
                      <input type="text" class="form-control" name="address" value="{{$contact->address}}">
                    </div>
                    <div class="form-group">
                      <label for="company_telephone" class="bmd-label-floating"> {{__('accounts.contact_company_telephone')}}</label>
                      <input type="text" class="form-control" name="company_telephone" value="{{$contact->company_telephone}}">
                    </div>
                    <div class="form-group">
                      <label for="company_email" class="bmd-label-floating"> {{__('accounts.contact_company_email')}}</label>
                      <input type="email" class="form-control" name="company_email" value="{{$contact->company_email}}">
                    </div>
                    @if($contact->FormSubmission)
                    @if(!$contact->FormSubmission->Form->FormCustomizedFields->isEmpty())
                    <?php $customized_fields_data = ($contact->FormSubmission->customized_fields_data)?(array)json_decode($contact->FormSubmission->customized_fields_data):'';?>
                      @foreach($contact->FormSubmission->Form->FormCustomizedFields as $customizedField)
                        @if($customizedField->type == 'text')
                          @if($customizedField->is_displayed)
                          <div class="form-group">
                            <label for="{{lcfirst($customizedField->name)}}" class="bmd-label-floating">{{$customizedField->name}} @if($customizedField->is_required) * @endif</label>
                            <input type="{{$customizedField->type}}" class="form-control" name="customized_fields[{{lcfirst($customizedField->name)}}]" value="{{(array_key_exists(lcfirst($customizedField->name), $customized_fields_data))?$customized_fields_data[lcfirst($customizedField->name)]:''}}" @if($customizedField->is_required) required @endif>
                          </div>
                          @endif
                        @elseif($customizedField->type == 'number')
                          @if($customizedField->is_displayed)
                          <div class="form-group">
                            <label for="{{lcfirst($customizedField->name)}}" class="bmd-label-floating">{{$customizedField->name}} @if($customizedField->is_required) * @endif</label>
                            <input type="{{$customizedField->type}}" class="form-control" name="customized_fields[{{lcfirst($customizedField->name)}}]" value="{{(array_key_exists(lcfirst($customizedField->name), $customized_fields_data))?$customized_fields_data[lcfirst($customizedField->name)]:''}}" @if($customizedField->is_required) required @endif>
                          </div>
                          @endif
                        @elseif($customizedField->type == 'longtext')
                          @if($customizedField->is_displayed)
                          <div class="form-group">
                            <label for="{{lcfirst($customizedField->name)}}" class="bmd-label-floating">{{$customizedField->name}} @if($customizedField->is_required) * @endif</label>
                            <textarea class="form-control" name="customized_fields[{{lcfirst($customizedField->name)}}]"  @if($customizedField->is_required) required @endif>{{(array_key_exists(lcfirst($customizedField->name), $customized_fields_data))?$customized_fields_data[lcfirst($customizedField->name)]:''}}</textarea>
                          </div>
                          @endif
                        @elseif($customizedField->type == 'dropdown')
                          @if($customizedField->is_displayed)
                          <div class="form-group">
                            <label for="type" class="bmd-label-floating">{{$customizedField->name}}</label>
                            <select class="form-control mt-3" name="customized_fields[{{lcfirst($customizedField->name)}}]" @if($customizedField->is_required) required @endif>
                              <?php $optionArr = explode(',', $customizedField->option_name); ?>
                              <option value="">Please select</option>
                              @foreach($optionArr as $option)
                                <option value="{{$option}}" @if(array_key_exists(lcfirst($customizedField->name), $customized_fields_data)) {{($customized_fields_data[lcfirst($customizedField->name)] == $option)?'selected':''}} @endif>{{$option}}</option>
                              @endforeach
                            </select>
                          </div>
                          @endif
                        @elseif($customizedField->type == 'checkboxes')
                          @if($customizedField->is_displayed)
                          <div class="form-group mt-3">
                          <?php $optionArr = explode(',', $customizedField->option_name);
                                $selectedOptionArr = (array_key_exists(lcfirst($customizedField->name), $customized_fields_data))?explode(',',$customized_fields_data[lcfirst($customizedField->name)]):[];?>
                          <label for="{{lcfirst($customizedField->name)}}" class="bmd-label-floating">{{$customizedField->name}}</label>
                          <div class="col-sm-10 checkbox-radios">
                              @foreach($optionArr as $option)
                              <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                  <input class="form-check-input" name="customized_fields[{{lcfirst($customizedField->name)}}][]" type="checkbox" value="{{$option}}" @if(in_array($option, $selectedOptionArr)) checked  @endif> {{$option}}
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                              </div>
                              @endforeach
                            </div>
                            </div>
                          @endif
                        @endif
                      @endforeach
                    @endif
                    @endif
                  </div>
                  <div class="col-md-6">
                    <div>
                      <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                         <div class="fileinput-new thumbnail img-raised">
                      	    <img src="{{($contact->profile_image)?asset($contact->profile_image):asset('img/faces/new_logo.png')}}" rel="nofollow" alt="...">
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
                      	    <img src="{{($contact->logo)?asset($contact->logo):asset('img/faces/new_logo.png')}}" rel="nofollow" alt="...">
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
                      <a href="javascript:;" class="btn btn-danger btn-sm delete-contact" data-id="{{$contact->id}}">{{__('accounts.delete_account_btn')}}</a>
                      <a href="{{url('/accounts')}}" class="btn btn-default btn-sm">{{__('accounts.back_btn')}}</a>
                      <button type="submit" class="btn btn-info btn-sm">{{__('accounts.update_account_btn')}}</button>
                    </div>
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
  <script src="{{ asset('js/plugins/jasny/jasny-bootstrap.js')}}" type="text/javascript"></script>

  <script type="text/javascript">
    const swalWithMaterialButtons = Swal.mixin({
      confirmButtonClass: 'btn btn-success btn-sm',
      cancelButtonClass: 'btn btn-danger btn-sm',
      buttonsStyling: false,
    })
    jQuery(document).ready(function(){
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
@endsection
