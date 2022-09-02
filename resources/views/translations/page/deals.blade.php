@extends('layouts.app')

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <form method="POST" id="translationsDeals" action="{{url('/translations/page/deals')}}">
          @csrf
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">g_translate</i>
            </div>
            <h4 class="card-title">Deals <a href="javascript:;" class="text-primary pull-right">{{url('/deals')}}</a></h4>
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
                    <label for="add_new_deal_en" class="bmd-label-floating"> Add new deal Button</label>
                    <input class="form-control" type="text" name="translations[add_new_deal][en]" required="true" aria-required="true" value="{{array_key_exists('add_new_deal', $translations)?$translations['add_new_deal']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="edit_deal_btn_en" class="bmd-label-floating"> Edit deal button</label>
                    <input class="form-control" type="text" name="translations[edit_deal_btn][en]" required="true" aria-required="true" value="{{array_key_exists('edit_deal_btn', $translations)?$translations['edit_deal_btn']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="update_deal_btn_en" class="bmd-label-floating"> Update deal button</label>
                    <input class="form-control" type="text" name="translations[update_deal_btn][en]" required="true" aria-required="true" value="{{array_key_exists('update_deal_btn', $translations)?$translations['update_deal_btn']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="delete_deal_btn_en" class="bmd-label-floating"> Delete deal button</label>
                    <input class="form-control" type="text" name="translations[delete_deal_btn][en]" required="true" aria-required="true" value="{{array_key_exists('delete_deal_btn', $translations)?$translations['delete_deal_btn']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="duplicate_deal_btn_en" class="bmd-label-floating"> Duplicate deal button</label>
                    <input class="form-control" type="text" name="translations[duplicate_deal_btn][en]" required="true" aria-required="true" value="{{array_key_exists('duplicate_deal_btn', $translations)?$translations['duplicate_deal_btn']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="back_btn_en" class="bmd-label-floating"> Back button</label>
                    <input class="form-control" type="text" name="translations[back_btn][en]" required="true" aria-required="true" value="{{array_key_exists('back_btn', $translations)?$translations['back_btn']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="deal_name_en" class="bmd-label-floating"> Deal Name</label>
                    <input class="form-control" type="text" name="translations[deal_name][en]" required="true" aria-required="true" value="{{array_key_exists('deal_name', $translations)?$translations['deal_name']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="no_contacts_text_en" class="bmd-label-floating"> No contacts text</label>
                    <input class="form-control" type="text" name="translations[no_contacts_text][en]" required="true" aria-required="true" value="{{array_key_exists('no_contacts_text', $translations)?$translations['no_contacts_text']['en']:''}}">
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
                    <label for="add_new_deal_da" class="bmd-label-floating"> Add new deal Button</label>
                    <input class="form-control" type="text" name="translations[add_new_deal][da]" value="{{array_key_exists('add_new_deal', $translations)?$translations['add_new_deal']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="edit_deal_btn_da" class="bmd-label-floating"> Edit deal button</label>
                    <input class="form-control" type="text" name="translations[edit_deal_btn][da]"  value="{{array_key_exists('edit_deal_btn', $translations)?$translations['edit_deal_btn']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="update_deal_btn_da" class="bmd-label-floating"> Update deal button</label>
                    <input class="form-control" type="text" name="translations[update_deal_btn][da]"  value="{{array_key_exists('update_deal_btn', $translations)?$translations['update_deal_btn']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="delete_deal_btn_da" class="bmd-label-floating"> Delete deal button</label>
                    <input class="form-control" type="text" name="translations[delete_deal_btn][da]"  value="{{array_key_exists('delete_deal_btn', $translations)?$translations['delete_deal_btn']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="duplicate_deal_btn_da" class="bmd-label-floating"> Duplicate deal button</label>
                    <input class="form-control" type="text" name="translations[duplicate_deal_btn][da]"  value="{{array_key_exists('duplicate_deal_btn', $translations)?$translations['duplicate_deal_btn']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="back_btn_da" class="bmd-label-floating"> Back button</label>
                    <input class="form-control" type="text" name="translations[back_btn][da]"  value="{{array_key_exists('back_btn', $translations)?$translations['back_btn']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="deal_name_da" class="bmd-label-floating"> Deal Name</label>
                    <input class="form-control" type="text" name="translations[deal_name][da]"  value="{{array_key_exists('deal_name', $translations)?$translations['deal_name']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="no_contacts_text_da" class="bmd-label-floating"> No contacts text</label>
                    <input class="form-control" type="text" name="translations[no_contacts_text][da]"  value="{{array_key_exists('no_contacts_text', $translations)?$translations['no_contacts_text']['da']:''}}">
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-info pull-right">Save Translations</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')

@endsection
