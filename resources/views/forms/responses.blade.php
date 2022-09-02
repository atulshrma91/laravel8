@extends('layouts.app')

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <a href="{{url('/forms')}}" class="btn btn-sm pull-right">Back</a>
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">send</i>
            </div>
            <h4 class="card-title">
              Form Responses
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
            <div class="material-datatables">
              <table id="formResponsesTable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>Created</th>
                    <th>Form Name</th>
                    @if($form->is_displayed_role)
                      <th>Role</th>
                    @endif
                    @if($form->is_displayed_profile_image)
                      <th>Portrait</th>
                    @endif
                    @if($form->is_displayed_first_name)
                      <th>First name</th>
                    @endif
                    @if($form->is_displayed_last_name)
                      <th>Last name</th>
                    @endif
                    @if($form->is_displayed_email)
                      <th>Email</th>
                    @endif
                    @if($form->is_displayed_telephone)
                      <th>Telephone</th>
                    @endif
                    @if($form->is_displayed_website)
                      <th>Website</th>
                    @endif
                    @if($form->is_displayed_company)
                      <th>Company</th>
                    @endif
                    @if($form->is_displayed_cvr_number)
                      <th>CVR number</th>
                    @endif
                    @if($form->is_displayed_address)
                      <th>Address</th>
                    @endif
                    @if($form->is_displayed_company_telephone)
                      <th>Company Telephone</th>
                    @endif
                    @if($form->is_displayed_company_email)
                      <th>Company email</th>
                    @endif
                    @if($form->is_displayed_logo)
                      <th>Logo</th>
                    @endif
                    <th>Customized Data</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @if($totalSubmissions)
                    @if(!$totalSubmissions->FormSubmissions->isEmpty())
                      @foreach($totalSubmissions->FormSubmissions as $record)
                        <tr>
                          <td>{{date('F j, Y', strtotime($record->created_at))}}</td>
                          <td>{{$totalSubmissions->name}}</td>
                          @if($form->is_displayed_role)
                            <td>{{$record->Contact->role}}</td>
                          @endif
                          @if($form->is_displayed_profile_image)
                            <td>{!! ($record->Contact->profile_image)?'<img src="'.asset($record->Contact->profile_image).'" class=""/>':'' !!}</td>
                          @endif
                          @if($form->is_displayed_first_name)
                            <td>{{$record->Contact->first_name}}</td>
                          @endif
                          @if($form->is_displayed_last_name)
                            <td>{{$record->Contact->last_name}}</td>
                          @endif
                          @if($form->is_displayed_email)
                            <td>{{$record->Contact->email}}</td>
                          @endif
                          @if($form->is_displayed_telephone)
                            <td>{{$record->Contact->telephone}}</td>
                          @endif
                          @if($form->is_displayed_website)
                            <td>{{$record->Contact->website}}</td>
                          @endif
                          @if($form->is_displayed_company)
                            <td>{{$record->Contact->company}}</td>
                          @endif
                          @if($form->is_displayed_cvr_number)
                            <td>{{$record->Contact->cvr_number}}</td>
                          @endif
                          @if($form->is_displayed_address)
                            <td>{{$record->Contact->address}}</td>
                          @endif
                          @if($form->is_displayed_company_telephone)
                            <td>{{$record->Contact->company_telephone}}</td>
                          @endif
                          @if($form->is_displayed_company_email)
                            <td>{{$record->Contact->company_email}}</td>
                          @endif
                          @if($form->is_displayed_logo)
                            <td>{!! ($record->Contact->logo)?'<img src="'.asset($record->Contact->logo).'" class="rounded thumbnail"/>':'' !!}</td>
                          @endif
                          <td>
                            <?php $customized_fields_data = ($record->customized_fields_data)?json_decode($record->customized_fields_data):'';?>
                            @if($customized_fields_data)
                              @foreach($customized_fields_data as $fk => $field_data)
                              <div><label>{{ucfirst($fk)}} : </label>  {{$field_data}}</div>
                              @endforeach
                            @endif
                          </td>
                          <td>
                            <div class="dropdown show">
                             <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               <span class="material-icons">design_services</span>
                             </a>
                             <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                               <a class="dropdown-item" href="{{url('/accounts/'.$record->Contact->Account->uuid.'/contact/edit/'.$record->Contact->id)}}"><i class="material-icons">edit</i>Edit</a>
                               <a class="dropdown-item delete-form-submission" href="javascript:;" data-id={{$record->id}}><i class="material-icons">delete</i>Delete</a>
                             </div>
                           </div>
                          </td>
                        </tr>
                      @endforeach
                    @endif
                  @endif
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
    const swalWithMaterialButtons = Swal.mixin({
      confirmButtonClass: 'btn btn-success btn-sm',
      cancelButtonClass: 'btn btn-danger btn-sm',
      buttonsStyling: false,
    })
    jQuery(document).ready(function(){
      $(document).ready(function() {
        $('#formResponsesTable').DataTable({
             responsive: true,
             searching: false,
             ordering: true,
             columnDefs: [
                 { orderable: false, targets: -1 }
            ]
          });
          jQuery(document).on('click', '.delete-form-submission', function(){
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
                return fetch('/forms/'+id+'/submission/delete', {
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
      });
    })
  </script>
@endsection
