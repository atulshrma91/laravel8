@extends('layouts.form')

@section('content')

<div class="wrapper wrapper-full-page" >
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="font-weight-bold">{{$form->headline}}</h4>
            <div class="text-break">{{$form->introduction}}</div>
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
            <form method="POST" action="{{ url('form/'.$form->uuid) }}" id="formRecord" enctype="multipart/form-data">
              @csrf
              @if($form->is_displayed_role)
              <div class="form-group">
                <label for="role" class="bmd-label-floating">Role @if($form->is_required_role) * @endif</label>
                <input type="text" class="form-control" name="role" value="{{ old('role')}}" @if($form->is_required_role) required @endif>
              </div>
              @endif
              @if($form->is_displayed_first_name)
              <div class="form-group">
                <label for="first_name" class="bmd-label-floating">First Name @if($form->is_required_first_name) * @endif</label>
                <input type="text" class="form-control" name="first_name" value="{{ old('first_name')}}" @if($form->is_required_first_name) required @endif>
              </div>
              @endif
              @if($form->is_displayed_last_name)
              <div class="form-group">
                <label for="last_name" class="bmd-label-floating">Last Name @if($form->is_required_last_name) * @endif</label>
                <input type="text" class="form-control" name="last_name" value="{{ old('last_name')}}" @if($form->is_required_last_name) required @endif>
              </div>
              @endif
              @if($form->is_displayed_email)
              <div class="form-group">
                <label for="email" class="bmd-label-floating">Email @if($form->is_required_email) * @endif</label>
                <input type="email" class="form-control" name="email" value="{{ old('email')}}" @if($form->is_required_email) required @endif>
              </div>
              @endif
              @if($form->is_displayed_telephone)
              <div class="form-group">
                <label for="telephone" class="bmd-label-floating">Telephone @if($form->is_required_telephone) * @endif</label>
                <input type="text" class="form-control" name="telephone" value="{{ old('telephone')}}" @if($form->is_required_telephone) required @endif data-rule-number="true">
              </div>
              @endif
              @if($form->is_displayed_website)
              <div class="form-group">
                <label for="website" class="bmd-label-floating">Website @if($form->is_required_website) * @endif</label>
                <input type="text" class="form-control" name="website" value="{{ old('website')}}" @if($form->is_required_website) required @endif>
              </div>
              @endif
              @if($form->is_displayed_company)
              <div class="form-group">
                <label for="company" class="bmd-label-floating">Company @if($form->is_required_company) * @endif</label>
                <input type="text" class="form-control" name="company" value="{{ old('company')}}" @if($form->is_required_company) required @endif>
              </div>
              @endif
              @if($form->is_displayed_cvr_number)
              <div class="form-group">
                <label for="cvr_number" class="bmd-label-floating">CVR number @if($form->is_required_cvr_number) * @endif</label>
                <input type="text" class="form-control" name="cvr_number" value="{{ old('cvr_number')}}" @if($form->is_required_cvr_number) required @endif>
              </div>
              @endif
              @if($form->is_displayed_address)
              <div class="form-group">
                <label for="address" class="bmd-label-floating">Address @if($form->is_required_address) * @endif</label>
                <input type="text" class="form-control" name="address" value="{{ old('address')}}" @if($form->is_required_address) required @endif>
              </div>
              @endif
              @if($form->is_displayed_company_telephone)
              <div class="form-group">
                <label for="company_telephone" class="bmd-label-floating">Company telephone @if($form->is_required_company_telephone) * @endif</label>
                <input type="text" class="form-control" name="company_telephone" value="{{ old('company_telephone')}}" @if($form->is_required_company_telephone) required @endif data-rule-number="true">
              </div>
              @endif
              @if($form->is_displayed_company_email)
              <div class="form-group">
                <label for="company_email" class="bmd-label-floating">Company email @if($form->is_required_company_email) * @endif</label>
                <input type="text" class="form-control" name="company_email" value="{{ old('company_email')}}" @if($form->is_required_company_email) required @endif>
              </div>
              @endif
              @if($form->is_displayed_profile_image)
              <div>
                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                   <div class="fileinput-new thumbnail img-raised">
                      <img src="{{asset('img/faces/new_logo.png')}}" rel="nofollow" alt="...">
                   </div>
                   <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                   <div>
                      <span class="btn btn-raised btn-round btn-sm btn-info btn-file">
                         <span class="fileinput-new">Add Profile Image @if($form->is_required_profile_image) * @endif</span>
                         <span class="fileinput-exists">Add Profile Image @if($form->is_required_profile_image) * @endif</span>
                         <input type="file" name="profile"/>
                      </span>
                   </div>
                </div>
              </div>
              @endif
              @if($form->is_displayed_logo)
              <div>
                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                   <div class="fileinput-new thumbnail img-raised">
                      <img src="{{asset('img/faces/new_logo.png')}}" rel="nofollow" alt="...">
                   </div>
                   <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                   <div>
                      <span class="btn btn-raised btn-round btn-sm btn-info btn-file">
                         <span class="fileinput-new">Add Logo  @if($form->is_required_logo) * @endif</span>
                         <span class="fileinput-exists">Add Logo  @if($form->is_required_logo) * @endif</span>
                         <input type="file" name="logo"/>
                      </span>
                   </div>
                </div>
              </div>
              @endif
              @if(!$form->FormCustomizedFields->isEmpty())
                @foreach($form->FormCustomizedFields as $customizedField)
                  @if($customizedField->type == 'text')
                    @if($customizedField->is_displayed)
                    <div class="form-group">
                      <label for="{{lcfirst($customizedField->name)}}" class="bmd-label-floating">{{$customizedField->name}} @if($customizedField->is_required) * @endif</label>
                      <input type="{{$customizedField->type}}" class="form-control" name="customized_fields[{{lcfirst($customizedField->name)}}]" value="" @if($customizedField->is_required) required @endif>
                    </div>
                    @endif
                  @elseif($customizedField->type == 'number')
                    @if($customizedField->is_displayed)
                    <div class="form-group">
                      <label for="{{lcfirst($customizedField->name)}}" class="bmd-label-floating">{{$customizedField->name}} @if($customizedField->is_required) * @endif</label>
                      <input type="{{$customizedField->type}}" class="form-control" name="customized_fields[{{lcfirst($customizedField->name)}}]" value="" @if($customizedField->is_required) required @endif>
                    </div>
                    @endif
                  @elseif($customizedField->type == 'longtext')
                    @if($customizedField->is_displayed)
                    <div class="form-group">
                      <label for="{{lcfirst($customizedField->name)}}" class="bmd-label-floating">{{$customizedField->name}} @if($customizedField->is_required) * @endif</label>
                      <textarea class="form-control" name="customized_fields[{{lcfirst($customizedField->name)}}]"  @if($customizedField->is_required) required @endif></textarea>
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
                          <option value="{{$option}}">{{$option}}</option>
                        @endforeach
                      </select>
                    </div>
                    @endif
                  @elseif($customizedField->type == 'checkboxes')
                    @if($customizedField->is_displayed)
                    <div class="form-group mt-3">
                    <?php $optionArr = explode(',', $customizedField->option_name); ?>
                    <label for="{{lcfirst($customizedField->name)}}" class="bmd-label-floating">{{$customizedField->name}}</label>
                    <div class="col-sm-10 checkbox-radios">
                        @foreach($optionArr as $option)
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" name="customized_fields[{{lcfirst($customizedField->name)}}][]" type="checkbox" value="{{$option}}" required> {{$option}}
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
              <div class="form-group text-center mt-5">
                <button type="submit" class="btn btn-info">Send</button>
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
  <script src="{{ asset('js/plugins/jasny/jasny-bootstrap.js')}}" type="text/javascript"></script>
@endsection
