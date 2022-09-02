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
              <i class="material-icons">category</i>
            </div>
            <h4 class="card-title">Categories</h4>
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
            @if(!$categories->isEmpty())
            <form method="POST" id="updateCategoriesExtSettings" action="{{url('extensions/categories/settings/update')}}">
              @csrf
              @foreach($categories as $category)
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="text" class="form-control" name="categories[{{$category->id}}][name]" required="true" value="{{$category->name}}">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <select class="form-control" name="categories[{{$category->id}}][color_code]">
                      <option value="">Color Code</option>
                      <option value="#0291cd" @if($category->color_code == '#0291cd') selected  @endif>Pacific Blue</option>
                      <option value="#0247fe" @if($category->color_code == '#0247fe') selected  @endif>Blue Ribbon</option>
                      <option value="#3e01a4" @if($category->color_code == '#3e01a4') selected  @endif>Pigment Indigo</option>
                      <option value="#8601b0" @if($category->color_code == '#8601b0') selected  @endif>Purple</option>
                      <option value="#a7194b" @if($category->color_code == '#a7194b') selected  @endif>Maroon Flush</option>
                      <option value="#fe2712" @if($category->color_code == '#fe2712') selected  @endif>Scarlet</option>
                      <option value="#fd5308" @if($category->color_code == '#fd5308') selected  @endif>International Orange</option>
                      <option value="#fb9902" @if($category->color_code == '#fb9902') selected  @endif>California</option>
                      <option value="#f9bc02" @if($category->color_code == '#f9bc02') selected  @endif>Selective Yellow</option>
                      <option value="#fffe32" @if($category->color_code == '#fffe32') selected  @endif>Golden Fizz</option>
                      <option value="#d0e92b" @if($category->color_code == '#d0e92b') selected  @endif>Pear</option>
                      <option value="#66b132" @if($category->color_code == '#66b132') selected  @endif>Sushi</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-7">
                  <div class="form-group">
                    <button type="button" class="btn btn-sm btn-danger delete-category" data-id="{{$category->id}}">Delete</button>
                  </div>
                </div>
              </div>
              @endforeach
              <div class="form-group">
                <button type="submit" class="btn btn-sm crm-btn-green">Update</button>
              </div>
            </form>
            @endif
            <form method="POST" id="categoriesExtSettings" action="{{url('extensions/categories/settings')}}">
              @csrf
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="name" class="bmd-label-floating"> Category</label>
                    <input type="text" class="form-control" name="name" required="true" value="{{ old('name')}}">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <select class="form-control" name="color_code">
                      <option value="">Color Code</option>
                      <option value="#0291cd">Pacific Blue</option>
                      <option value="#0247fe">Blue Ribbon</option>
                      <option value="#3e01a4">Pigment Indigo</option>
                      <option value="#8601b0">Purple</option>
                      <option value="#a7194b">Maroon Flush</option>
                      <option value="#fe2712">Scarlet</option>
                      <option value="#fd5308">International Orange</option>
                      <option value="#fb9902">California</option>
                      <option value="#f9bc02">Selective Yellow</option>
                      <option value="#fffe32">Golden Fizz</option>
                      <option value="#d0e92b">Pear</option>
                      <option value="#66b132">Sushi</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-7">
                  <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-info">Add category</button>
                    <a href="{{url('/extensions')}}" class="btn btn-sm btn-default">Cancel</a>
                  </div>
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
<script src="{{ asset('js/plugins/selectize/selectize.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    const swalWithMaterialButtons = Swal.mixin({
      confirmButtonClass: 'btn btn-danger btn-sm',
      cancelButtonClass: 'btn btn-success btn-sm',
      buttonsStyling: false,
    })
    jQuery(document).ready(function(){
      jQuery('select').selectize({
  	    valueField: 'hex',
  	    labelField: 'name',
  	    searchField: 'name',
  	    onChange: function(){
  		    $.each($(".selectize-input .item"), function(key, value){
  				$(value).css('background-color', $(value).data('value'));
  			});
  	    },
  	    render: {
  		    option: function(data, escape) {
            if(data.hex == '#fffe32'){
              return '<div class="option color_code_item black" style="background-color:' + data.hex + ';">' + escape(data.name) + '</div>';
            }else{
              return '<div class="option color_code_item" style="background-color:' + data.hex + ';">' + escape(data.name) + '</div>';
            }

  		    },
  		    item : function(data, escape) {
            if(data.hex == '#fffe32'){
    			    return '<div class="item color_code_item black w-75 py-1 px-2" style="background-color:' + data.hex + ';">' + escape(data.name) + '</div>';
            }else{
    			    return '<div class="item color_code_item w-75 py-1 px-2" style="background-color:' + data.hex + ';">' + escape(data.name) + '</div>';
            }
  		    }
  	    }
	     });
      jQuery(document).on('submit', '#updateCategoriesExtSettings', function(e){
        e.preventDefault()
        jQuery(this).find('button[type="submit"]').html('Update<i class="fa fa-spinner fa-spin"></i>');
        let dataArr = jQuery(this).serializeArray()
          jQuery.ajax({
              url: '/extensions/categories/settings/update',
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
              },
              context: this,
              data:dataArr,
              dataType:'json',
              success: function (res) {
                jQuery(this).find('button[type="submit"]').html('Update')
                if(res.success == true){

                }
              }
          });
      })
      jQuery(document).on('click', '.delete-category', function(){
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
            return fetch('/extensions/categories/settings/'+id+'/delete', {
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
            setTimeout(function() {
                window.location.href = result.value.url
            }, 1000);
          }
        })
      })
    })
</script>
@endsection
