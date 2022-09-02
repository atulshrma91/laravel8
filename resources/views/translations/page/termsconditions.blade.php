@extends('layouts.app')

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">g_translate</i>
            </div>
            <h4 class="card-title">Terms & Conditions <a href="javascript:;" class="text-primary pull-right">{{url('/terms-and-conditions')}}</a></h4>
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

            <form method="POST" id="translationsTermsConditions" action="{{url('/translations/page/terms-conditions')}}">
              @csrf
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <h5> English</h5>
                  </div>
                  <div class="form-group">
                    <label for="title_en" class="bmd-label-floating"> Title</label>
                    <input class="form-control" type="text" name="translations[title][en]" required="true" aria-required="true" value="{{array_key_exists('title', $translations)?$translations['title']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="body_en" class="bmd-label-floating"> Body</label>
                    <textarea class="form-control" type="text" name="translations[body][en]" required="true" aria-required="true" rows="15" cols="50">{{array_key_exists('body', $translations)?$translations['body']['en']:''}}</textarea>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <h5> Danish</h5>
                  </div>
                  <div class="form-group">
                    <label for="title_da" class="bmd-label-floating"> Title</label>
                    <input class="form-control" type="text" name="translations[title][da]" value="{{array_key_exists('title', $translations)?$translations['title']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="body_da" class="bmd-label-floating"> Body</label>
                    <textarea class="form-control" type="text" name="translations[body][da]" rows="15" cols="50">{{array_key_exists('body', $translations)?$translations['body']['da']:''}}</textarea>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-info pull-right">Save Translations</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
  <script src="https://cdn.tiny.cloud/1/ri0kzgz8le5hpoxkslumt1sp95cqqcyilo8mf2h4o7bxn33b/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
      tinymce.init({
        selector: 'textarea',
        //plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
        branding: false
      });
  </script>
@endsection
