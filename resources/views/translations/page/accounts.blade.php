@extends('layouts.app')

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <form method="POST" id="translationsAccounts" action="{{url('/translations/page/accounts')}}">
          @csrf
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">g_translate</i>
            </div>
            <h4 class="card-title">Accounts <a href="javascript:;" class="text-primary pull-right">{{url('/accounts')}}</a></h4>
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
                    <label for="add_new_account_en" class="bmd-label-floating"> Add new account Button</label>
                    <input class="form-control" type="text" name="translations[add_new_account][en]" required="true" aria-required="true" value="{{array_key_exists('add_new_account', $translations)?$translations['add_new_account']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="account_listing_table_search_en" class="bmd-label-floating"> Listing table search</label>
                    <input class="form-control" type="text" name="translations[account_listing_table_search][en]" required="true" aria-required="true" value="{{array_key_exists('account_listing_table_search', $translations)?$translations['account_listing_table_search']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="account_listing_table_col_1_en" class="bmd-label-floating"> Listing table Column 1</label>
                    <input class="form-control" type="text" name="translations[account_listing_table_col_1][en]" required="true" aria-required="true" value="{{array_key_exists('account_listing_table_col_1', $translations)?$translations['account_listing_table_col_1']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="account_listing_table_col_2_en" class="bmd-label-floating"> Listing table Column 2</label>
                    <input class="form-control" type="text" name="translations[account_listing_table_col_2][en]" required="true" aria-required="true" value="{{array_key_exists('account_listing_table_col_2', $translations)?$translations['account_listing_table_col_2']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="account_popup_title_en" class="bmd-label-floating"> Popup title</label>
                    <input class="form-control" type="text" name="translations[account_popup_title][en]" required="true" aria-required="true" value="{{array_key_exists('account_popup_title', $translations)?$translations['account_popup_title']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="account_popup_approve_btn_en" class="bmd-label-floating"> Popup approve button</label>
                    <input class="form-control" type="text" name="translations[account_popup_approve_btn][en]" required="true" aria-required="true" value="{{array_key_exists('account_popup_approve_btn', $translations)?$translations['account_popup_approve_btn']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="back_btn_en" class="bmd-label-floating"> Back button</label>
                    <input class="form-control" type="text" name="translations[back_btn][en]" required="true" aria-required="true" value="{{array_key_exists('back_btn', $translations)?$translations['back_btn']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="update_account_btn_en" class="bmd-label-floating"> Update account button</label>
                    <input class="form-control" type="text" name="translations[update_account_btn][en]" required="true" aria-required="true" value="{{array_key_exists('update_account_btn', $translations)?$translations['update_account_btn']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="delete_account_btn_en" class="bmd-label-floating"> Delete account button</label>
                    <input class="form-control" type="text" name="translations[delete_account_btn][en]" required="true" aria-required="true" value="{{array_key_exists('delete_account_btn', $translations)?$translations['delete_account_btn']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="edit_account_popup_text_en" class="bmd-label-floating"> Edit account Popup text</label>
                    <input class="form-control" type="text" name="translations[edit_account_popup_text][en]" required="true" aria-required="true" value="{{array_key_exists('edit_account_popup_text', $translations)?$translations['edit_account_popup_text']['en']:''}}">
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
                    <label for="add_new_account_da" class="bmd-label-floating"> Add new account Button</label>
                    <input class="form-control" type="text" name="translations[add_new_account][da]" value="{{array_key_exists('add_new_account', $translations)?$translations['add_new_account']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="account_listing_table_search_da" class="bmd-label-floating"> Listing table search</label>
                    <input class="form-control" type="text" name="translations[account_listing_table_search][da]" value="{{array_key_exists('account_listing_table_search', $translations)?$translations['account_listing_table_search']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="account_listing_table_col_1_da" class="bmd-label-floating"> Listing table Column 1</label>
                    <input class="form-control" type="text" name="translations[account_listing_table_col_1][da]" value="{{array_key_exists('account_listing_table_col_1', $translations)?$translations['account_listing_table_col_1']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="account_listing_table_col_2_da" class="bmd-label-floating"> Listing table Column 2</label>
                    <input class="form-control" type="text" name="translations[account_listing_table_col_2][da]" value="{{array_key_exists('account_listing_table_col_2', $translations)?$translations['account_listing_table_col_2']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="account_popup_title_da" class="bmd-label-floating"> Popup title</label>
                    <input class="form-control" type="text" name="translations[account_popup_title][da]" value="{{array_key_exists('account_popup_title', $translations)?$translations['account_popup_title']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="account_popup_approve_btn_da" class="bmd-label-floating"> Popup approve button</label>
                    <input class="form-control" type="text" name="translations[account_popup_approve_btn][da]" value="{{array_key_exists('account_popup_approve_btn', $translations)?$translations['account_popup_approve_btn']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="back_btn_da" class="bmd-label-floating"> Back button</label>
                    <input class="form-control" type="text" name="translations[back_btn][da]" value="{{array_key_exists('back_btn', $translations)?$translations['back_btn']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="update_account_btn_da" class="bmd-label-floating"> Update account button</label>
                    <input class="form-control" type="text" name="translations[update_account_btn][da]"  value="{{array_key_exists('update_account_btn', $translations)?$translations['update_account_btn']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="delete_account_btn_da" class="bmd-label-floating"> Delete account button</label>
                    <input class="form-control" type="text" name="translations[delete_account_btn][da]" value="{{array_key_exists('delete_account_btn', $translations)?$translations['delete_account_btn']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="edit_account_popup_text_da" class="bmd-label-floating"> Edit account Popup text</label>
                    <input class="form-control" type="text" name="translations[edit_account_popup_text][da]" value="{{array_key_exists('edit_account_popup_text', $translations)?$translations['edit_account_popup_text']['da']:''}}">
                  </div>

                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header card-header-info card-header-icon">
              <div class="card-icon">
                <i class="material-icons">g_translate</i>
              </div>
              <h4 class="card-title">Contact <a href="javascript:;" class="text-primary pull-right">{{url('/accounts/{uuid}/contact')}}</a></h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="contact_title_en" class="bmd-label-floating"> Contact title</label>
                    <input class="form-control" type="text" name="translations[contact_title][en]" required="true" aria-required="true" value="{{array_key_exists('contact_title', $translations)?$translations['contact_title']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="add_contact_btn_en" class="bmd-label-floating"> Add contact button</label>
                    <input class="form-control" type="text" name="translations[add_contact_btn][en]" required="true" aria-required="true" value="{{array_key_exists('add_contact_btn', $translations)?$translations['add_contact_btn']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="edit_contact_btn_en" class="bmd-label-floating"> Edit contact button</label>
                    <input class="form-control" type="text" name="translations[edit_contact_btn][en]" required="true" aria-required="true" value="{{array_key_exists('edit_contact_btn', $translations)?$translations['edit_contact_btn']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="delete_contact_btn_en" class="bmd-label-floating"> Delete contact button</label>
                    <input class="form-control" type="text" name="translations[delete_contact_btn][en]" required="true" aria-required="true" value="{{array_key_exists('delete_contact_btn', $translations)?$translations['delete_contact_btn']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="duplicate_contact_btn_en" class="bmd-label-floating"> Duplicate contact button</label>
                    <input class="form-control" type="text" name="translations[duplicate_contact_btn][en]" required="true" aria-required="true" value="{{array_key_exists('duplicate_contact_btn', $translations)?$translations['duplicate_contact_btn']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_role_en" class="bmd-label-floating"> Contact form role</label>
                    <input class="form-control" type="text" name="translations[contact_role][en]" required="true" aria-required="true" value="{{array_key_exists('contact_role', $translations)?$translations['contact_role']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_firstname_en" class="bmd-label-floating"> Contact form First Name</label>
                    <input class="form-control" type="text" name="translations[contact_firstname][en]" required="true" aria-required="true" value="{{array_key_exists('contact_firstname', $translations)?$translations['contact_firstname']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_lastname_en" class="bmd-label-floating"> Contact form Last Name</label>
                    <input class="form-control" type="text" name="translations[contact_lastname][en]" required="true" aria-required="true" value="{{array_key_exists('contact_lastname', $translations)?$translations['contact_lastname']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_email_en" class="bmd-label-floating"> Contact form Email</label>
                    <input class="form-control" type="text" name="translations[contact_email][en]" required="true" aria-required="true" value="{{array_key_exists('contact_email', $translations)?$translations['contact_email']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_telephone_en" class="bmd-label-floating"> Contact form Telephone</label>
                    <input class="form-control" type="text" name="translations[contact_telephone][en]" required="true" aria-required="true" value="{{array_key_exists('contact_telephone', $translations)?$translations['contact_telephone']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_website_en" class="bmd-label-floating"> Contact form Website</label>
                    <input class="form-control" type="text" name="translations[contact_website][en]" required="true" aria-required="true" value="{{array_key_exists('contact_website', $translations)?$translations['contact_website']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_company_en" class="bmd-label-floating"> Contact form Company</label>
                    <input class="form-control" type="text" name="translations[contact_company][en]" required="true" aria-required="true" value="{{array_key_exists('contact_company', $translations)?$translations['contact_company']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_company_cvr_no_en" class="bmd-label-floating"> Contact form Company CVR No</label>
                    <input class="form-control" type="text" name="translations[contact_company_cvr_no][en]" required="true" aria-required="true" value="{{array_key_exists('contact_company_cvr_no', $translations)?$translations['contact_company_cvr_no']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_address_en" class="bmd-label-floating"> Contact form Address</label>
                    <input class="form-control" type="text" name="translations[contact_address][en]" required="true" aria-required="true" value="{{array_key_exists('contact_address', $translations)?$translations['contact_address']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_company_telephone_en" class="bmd-label-floating"> Contact form Company Telephone</label>
                    <input class="form-control" type="text" name="translations[contact_company_telephone][en]" required="true" aria-required="true" value="{{array_key_exists('contact_company_telephone', $translations)?$translations['contact_company_telephone']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_company_email_en" class="bmd-label-floating"> Contact form Company Email</label>
                    <input class="form-control" type="text" name="translations[contact_company_email][en]" required="true" aria-required="true" value="{{array_key_exists('contact_company_email', $translations)?$translations['contact_company_email']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_profile_img_en" class="bmd-label-floating"> Contact form Profile Image</label>
                    <input class="form-control" type="text" name="translations[contact_profile_img][en]" required="true" aria-required="true" value="{{array_key_exists('contact_profile_img', $translations)?$translations['contact_profile_img']['en']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_logo_img_en" class="bmd-label-floating"> Contact form Logo Image</label>
                    <input class="form-control" type="text" name="translations[contact_logo_img][en]" required="true" aria-required="true" value="{{array_key_exists('contact_logo_img', $translations)?$translations['contact_logo_img']['en']:''}}">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="contact_title_da" class="bmd-label-floating"> Contact title</label>
                    <input class="form-control" type="text" name="translations[contact_title][da]" value="{{array_key_exists('contact_title', $translations)?$translations['contact_title']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="add_contact_btn_da" class="bmd-label-floating"> Add contact button</label>
                    <input class="form-control" type="text" name="translations[add_contact_btn][da]" value="{{array_key_exists('add_contact_btn', $translations)?$translations['add_contact_btn']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="edit_contact_btn_da" class="bmd-label-floating"> Edit contact button</label>
                    <input class="form-control" type="text" name="translations[edit_contact_btn][da]"  value="{{array_key_exists('edit_contact_btn', $translations)?$translations['edit_contact_btn']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="delete_contact_btn_da" class="bmd-label-floating"> Delete contact button</label>
                    <input class="form-control" type="text" name="translations[delete_contact_btn][da]"  value="{{array_key_exists('delete_contact_btn', $translations)?$translations['delete_contact_btn']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="duplicate_contact_btn_da" class="bmd-label-floating"> Duplicate contact button</label>
                    <input class="form-control" type="text" name="translations[duplicate_contact_btn][da]"  value="{{array_key_exists('duplicate_contact_btn', $translations)?$translations['duplicate_contact_btn']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_role_da" class="bmd-label-floating"> Contact form Role</label>
                    <input class="form-control" type="text" name="translations[contact_role][da]" value="{{array_key_exists('contact_role', $translations)?$translations['contact_role']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_firstname_da" class="bmd-label-floating"> Contact form First Name</label>
                    <input class="form-control" type="text" name="translations[contact_firstname][da]" value="{{array_key_exists('contact_firstname', $translations)?$translations['contact_firstname']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_lastname_da" class="bmd-label-floating"> Contact form Last Name</label>
                    <input class="form-control" type="text" name="translations[contact_lastname][da]" value="{{array_key_exists('contact_lastname', $translations)?$translations['contact_lastname']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_email_da" class="bmd-label-floating"> Contact form Email</label>
                    <input class="form-control" type="text" name="translations[contact_email][da]"  value="{{array_key_exists('contact_email', $translations)?$translations['contact_email']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_telephone_da" class="bmd-label-floating"> Contact form Telephone</label>
                    <input class="form-control" type="text" name="translations[contact_telephone][da]"  value="{{array_key_exists('contact_telephone', $translations)?$translations['contact_telephone']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_website_da" class="bmd-label-floating"> Contact form Website</label>
                    <input class="form-control" type="text" name="translations[contact_website][da]" value="{{array_key_exists('contact_website', $translations)?$translations['contact_website']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_company_da" class="bmd-label-floating"> Contact form Company</label>
                    <input class="form-control" type="text" name="translations[contact_company][da]" value="{{array_key_exists('contact_company', $translations)?$translations['contact_company']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_company_cvr_no_da" class="bmd-label-floating"> Contact form Company CVR No</label>
                    <input class="form-control" type="text" name="translations[contact_company_cvr_no][da]"  value="{{array_key_exists('contact_company_cvr_no', $translations)?$translations['contact_company_cvr_no']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_address_da" class="bmd-label-floating"> Contact form Address</label>
                    <input class="form-control" type="text" name="translations[contact_address][da]" value="{{array_key_exists('contact_address', $translations)?$translations['contact_address']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_company_telephone_da" class="bmd-label-floating"> Contact form Company Telephone</label>
                    <input class="form-control" type="text" name="translations[contact_company_telephone][da]"  value="{{array_key_exists('contact_company_telephone', $translations)?$translations['contact_company_telephone']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_company_email_da" class="bmd-label-floating"> Contact form Company Email</label>
                    <input class="form-control" type="text" name="translations[contact_company_email][da]" value="{{array_key_exists('contact_company_email', $translations)?$translations['contact_company_email']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_profile_img_da" class="bmd-label-floating"> Contact form Profile Image</label>
                    <input class="form-control" type="text" name="translations[contact_profile_img][da]" value="{{array_key_exists('contact_profile_img', $translations)?$translations['contact_profile_img']['da']:''}}">
                  </div>
                  <div class="form-group">
                    <label for="contact_logo_img_da" class="bmd-label-floating"> Contact form Logo Image</label>
                    <input class="form-control" type="text" name="translations[contact_logo_img][da]" value="{{array_key_exists('contact_logo_img', $translations)?$translations['contact_logo_img']['da']:''}}">
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
