<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Models\Form;
use \App\Models\Account;
use \App\Models\Contact;
use \App\Models\FormSubmission;
use \App\Models\Deal;
use \App\Models\Category;
use \App\Models\Notification;
use \App\Models\FormCustomizedFields;
use Uuid;

class FormController extends Controller{

  public function __construct(){
      $this->middleware(['auth','verified', 'extension:forms', 'extension.enabled:forms'], ['except' => ['viewForm', 'formRecord']]);
  }

  public function index(){
    return view('forms.index');
  }

  public function addForm(Request $request){
    $categories = Category::where(['user_id' => \Auth::user()->id])->get();
    return view('forms.add',[
      'categories' => $categories
    ]);
  }

  public function saveForm(Request $request){
    $v = Validator::make($request->all(), [
      'name' => 'required',
    ]);
    if ($v->fails()){
      return response()->json([
        'success' => false,
        'error' => $v->errors(),
        'message' => $v->errors()->first()
      ], 400);
    }else{
      $formData = [
        'name' => $request->input('name'),
        'user_id' => \Auth::user()->id,
        'uuid' => Uuid::generate(4)->string,
        'category_id' => ($request->input('category_id'))?$request->input('category_id'):NULL,
        'headline' => $request->input('headline'),
        'introduction' => $request->input('introduction'),
        'is_required_role' => ($request->input('is_required_role'))?true:false,
        'is_displayed_role' => ($request->input('is_displayed_role'))?true:false,
        'is_required_first_name' => ($request->input('is_required_first_name'))?true:false,
        'is_displayed_first_name' => ($request->input('is_displayed_first_name'))?true:false,
        'is_required_last_name' => ($request->input('is_required_last_name'))?true:false,
        'is_displayed_last_name' => ($request->input('is_displayed_last_name'))?true:false,
        'is_required_email' => ($request->input('is_required_email'))?true:false,
        'is_displayed_email' => ($request->input('is_displayed_email'))?true:false,
        'is_required_telephone' => ($request->input('is_required_telephone'))?true:false,
        'is_displayed_telephone' => ($request->input('is_displayed_telephone'))?true:false,
        'is_required_website' => ($request->input('is_required_website'))?true:false,
        'is_displayed_website' => ($request->input('is_displayed_website'))?true:false,
        'is_required_company' => ($request->input('is_required_company'))?true:false,
        'is_displayed_company' => ($request->input('is_displayed_company'))?true:false,
        'is_required_cvr_number' => ($request->input('is_required_cvr_number'))?true:false,
        'is_displayed_cvr_number' => ($request->input('is_displayed_cvr_number'))?true:false,
        'is_required_address' => ($request->input('is_required_address'))?true:false,
        'is_displayed_address' => ($request->input('is_displayed_address'))?true:false,
        'is_required_company_telephone' => ($request->input('is_required_company_telephone'))?true:false,
        'is_displayed_company_telephone' => ($request->input('is_displayed_company_telephone'))?true:false,
        'is_required_company_email' => ($request->input('is_required_company_email'))?true:false,
        'is_displayed_company_email' => ($request->input('is_displayed_company_email'))?true:false,
        'is_required_profile_image' => ($request->input('is_required_profile_image'))?true:false,
        'is_displayed_profile_image' => ($request->input('is_displayed_profile_image'))?true:false,
        'is_required_logo' => ($request->input('is_required_logo'))?true:false,
        'is_displayed_logo' => ($request->input('is_displayed_logo'))?true:false,
        'add_to_deals' => ($request->input('add_to_deals'))?true:false,
        'status' => true
      ];
      $form = Form::create($formData);
      return response()->json([
        'success' => true,
        'form_id' => $form->id,
        'status' => 'Form created successfully'
      ]);
    }
  }

  public function getforms(Request $request){
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length");
    $columnIndex_arr = $request->get('order');
    $columnName_arr = $request->get('columns');
    $order_arr = $request->get('order');
    $search_arr = $request->get('search');

    $columnIndex = $columnIndex_arr[0]['column'];
    $columnName = $columnName_arr[$columnIndex]['data'];
    $columnSortOrder = $order_arr[0]['dir'];
    $searchValue = $search_arr['value'];

    $totalRecords = Form::with(['FormSubmissions'])->where('user_id', '=', \Auth::user()->id)->count();

    $totalRecordswithFilter  = Form::with(['FormSubmissions'])->where('user_id', '=', \Auth::user()->id)
     ->when(!empty($searchValue) , function ($query) use($searchValue){
      $query->where('name', 'LIKE', '%'.$searchValue.'%')
          ->orWhere('uuid', 'LIKE', '%'.$searchValue.'%');
     })->count();

    $records = Form::orderBy($columnName,$columnSortOrder)->with(['FormSubmissions'])->where('user_id', '=', \Auth::user()->id)
      ->when(!empty($searchValue) , function ($query) use($searchValue){
        $query->where('name', 'LIKE', '%'.$searchValue.'%')
            ->orWhere('uuid', 'LIKE', '%'.$searchValue.'%');
       })->skip($start)
       ->take($rowperpage)
       ->get();

    $data_arr = [];
    if($records){
      foreach($records as $record){
         $edit_link = url('/forms/'.$record->uuid.'/edit');
         $data_arr[] = array(
           "created_at" => date('F j, Y', strtotime($record->created_at)),
           "name" => '<a href="'.$edit_link.'">'.$record->name.'</a>',
           "responses" => '<a href="'.url('forms/'.$record->uuid.'/responses').'">'.$record->FormSubmissions->count().'</a>',
           "link" => '<a href="'.url('form/'.$record->uuid).'" target="_blank">'.$record->uuid.'</a><span class="btn btn-sm btn-link copy-form-link ml-2">Copy</span>',
           "actions" => '<div class="dropdown show">
                          <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="material-icons">design_services</span>
                          </a>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="'.$edit_link.'"><i class="material-icons">edit</i>Edit</a>
                            <a class="dropdown-item delete-form" href="javascript:;" data-id="'.$record->id.'"><i class="material-icons">delete</i>Delete</a>
                            <a class="dropdown-item duplicate-form" href="javascript:;" data-id="'.$record->id.'"><i class="material-icons">content_copy</i>Duplicate</a>
                            <a class="dropdown-item" href="'.url('forms/'.$record->uuid.'/responses').'"><i class="material-icons">send</i>See responses</a>
                            <a class="dropdown-item" href="'.url('form/'.$record->uuid).'" target="_blank"><i class="material-icons">visibility</i>View</a>
                          </div>
                        </div>',
         );
      }
    }

    $response = array(
       "draw" => intval($draw),
       "iTotalRecords" => $totalRecords,
       "iTotalDisplayRecords" => $totalRecordswithFilter,
       "aaData" => $data_arr
    );
    die(json_encode($response));
  }

  public function editForm(Request $request, $uuid){
    $categories = Category::where(['user_id' => \Auth::user()->id])->get();
    $form = Form::with(['FormCustomizedFields'])->where(['uuid' => $uuid,  'user_id' => \Auth::user()->id])->first();
    return view('forms.edit', [
      'form' => $form,
      'categories' => $categories
    ]);
  }

  public function updateForm(Request $request, $uuid){
    $v = Validator::make($request->all(), [
      'name' => 'required'
    ]);
    if ($v->fails()){
      return redirect()->back()->withErrors($v->errors())->withInput();
    }else{
      $form = Form::where(['uuid' => $uuid,  'user_id' => \Auth::user()->id])->first();
      $formData = [
        'category_id' => ($request->input('category_id'))?$request->input('category_id'):NULL,
        'name' => $request->input('name'),
        'headline' => $request->input('headline'),
        'introduction' => $request->input('introduction'),
        'is_required_role' => ($request->input('is_required_role'))?true:false,
        'is_displayed_role' => ($request->input('is_displayed_role'))?true:false,
        'is_required_first_name' => ($request->input('is_required_first_name'))?true:false,
        'is_displayed_first_name' => ($request->input('is_displayed_first_name'))?true:false,
        'is_required_last_name' => ($request->input('is_required_last_name'))?true:false,
        'is_displayed_last_name' => ($request->input('is_displayed_last_name'))?true:false,
        'is_required_email' => ($request->input('is_required_email'))?true:false,
        'is_displayed_email' => ($request->input('is_displayed_email'))?true:false,
        'is_required_telephone' => ($request->input('is_required_telephone'))?true:false,
        'is_displayed_telephone' => ($request->input('is_displayed_telephone'))?true:false,
        'is_required_website' => ($request->input('is_required_website'))?true:false,
        'is_displayed_website' => ($request->input('is_displayed_website'))?true:false,
        'is_required_company' => ($request->input('is_required_company'))?true:false,
        'is_displayed_company' => ($request->input('is_displayed_company'))?true:false,
        'is_required_cvr_number' => ($request->input('is_required_cvr_number'))?true:false,
        'is_displayed_cvr_number' => ($request->input('is_displayed_cvr_number'))?true:false,
        'is_required_address' => ($request->input('is_required_address'))?true:false,
        'is_displayed_address' => ($request->input('is_displayed_address'))?true:false,
        'is_required_company_telephone' => ($request->input('is_required_company_telephone'))?true:false,
        'is_displayed_company_telephone' => ($request->input('is_displayed_company_telephone'))?true:false,
        'is_required_company_email' => ($request->input('is_required_company_email'))?true:false,
        'is_displayed_company_email' => ($request->input('is_displayed_company_email'))?true:false,
        'is_required_profile_image' => ($request->input('is_required_profile_image'))?true:false,
        'is_displayed_profile_image' => ($request->input('is_displayed_profile_image'))?true:false,
        'is_required_logo' => ($request->input('is_required_logo'))?true:false,
        'is_displayed_logo' => ($request->input('is_displayed_logo'))?true:false,
        'add_to_deals' => ($request->input('add_to_deals'))?true:false,
      ];
      Form::find($form->id)->update($formData);
      return redirect()->route('forms.view')->with(['status' => 'Form updated successfully']);
    }
  }

  public function deleteForm(Request $request, $id){
    if($request->isJson()){
      $deal = Form::find($id)->delete();
       return response()->json([
         'success' => true,
         'url' => url('/forms')
       ]);
    }
  }

  public function duplicateForm(Request $request, $id){
    if($request->isJson()){
      $form = Form::find($id);
      $formData = [
        'name' => $form->name,
        'user_id' => \Auth::user()->id,
        'uuid' => Uuid::generate(4)->string,
        'headline' => $form->headline,
        'introduction' => $form->introduction,
        'is_required_role' => ($form->is_required_role)?true:false,
        'is_displayed_role' => ($form->is_displayed_role)?true:false,
        'is_required_first_name' => ($form->is_required_first_name)?true:false,
        'is_displayed_first_name' => ($form->is_displayed_first_name)?true:false,
        'is_required_last_name' => ($form->is_required_last_name)?true:false,
        'is_displayed_last_name' => ($form->is_displayed_last_name)?true:false,
        'is_required_email' => ($form->is_required_email)?true:false,
        'is_displayed_email' => ($form->is_displayed_email)?true:false,
        'is_required_telephone' => ($form->is_required_telephone)?true:false,
        'is_displayed_telephone' => ($form->is_displayed_telephone)?true:false,
        'is_required_website' => ($form->is_required_website)?true:false,
        'is_displayed_website' => ($form->is_displayed_website)?true:false,
        'is_required_company' => ($form->is_required_company)?true:false,
        'is_displayed_company' => ($form->is_displayed_company)?true:false,
        'is_required_cvr_number' => ($form->is_required_cvr_number)?true:false,
        'is_displayed_cvr_number' => ($form->is_displayed_cvr_number)?true:false,
        'is_required_address' => ($form->is_required_address)?true:false,
        'is_displayed_address' => ($form->is_displayed_address)?true:false,
        'is_required_company_telephone' => ($form->is_required_company_telephone)?true:false,
        'is_displayed_company_telephone' => ($form->is_displayed_company_telephone)?true:false,
        'is_required_company_email' => ($form->is_required_company_email)?true:false,
        'is_displayed_company_email' => ($form->is_displayed_company_email)?true:false,
        'is_required_profile_image' => ($form->is_required_profile_image)?true:false,
        'is_displayed_profile_image' => ($form->is_displayed_profile_image)?true:false,
        'is_required_logo' => ($form->is_required_logo)?true:false,
        'is_displayed_logo' => ($form->is_displayed_logo)?true:false,
        'add_to_deals' => ($form->add_to_deals)?true:false,
        'status' => true
      ];
      $form = Form::create($formData);
      return response()->json([
        'success' => true,
        'url' => url('/forms')
      ]);
    }
  }

  public function viewForm(Request $request, $uuid){
    $form = Form::with(['FormCustomizedFields'])->where(['uuid' => $uuid])->first();
    if($form){
      return view('forms.view', [
        'form' => $form
      ]);
    }else{
      abort(404);
    }
  }

  public function formRecord(Request $request, $uuid){
    $form = Form::where(['uuid' => $uuid])->first();
    $customized_fieldsArr = $validationArr = $requestArr =  [];
    $requestArr = $request->all();
    if($request->input('customized_fields')){
      foreach ($request->input('customized_fields') as $ck => $c_field) {
        if(is_array($c_field)){
          $customized_fieldsArr[$ck] = implode(',', $c_field);
          $formCustomizedFields = FormCustomizedFields::where('form_id', $form->id)->where('name', 'like', '%'.$ck.'%')->first();
          if($formCustomizedFields->options_selection == 'atleast'){
            $validationArr[$ck] = 'required|array|min:'.$formCustomizedFields->options_selection_choice;
          }else if($formCustomizedFields->options_selection == 'atmost'){
            $validationArr[$ck] = 'required|array|min:0|max:'.$formCustomizedFields->options_selection_choice;
          }else if($formCustomizedFields->options_selection == 'exactly'){
            $validationArr[$ck] = 'required|array|min:'.$formCustomizedFields->options_selection_choice.'|max:'.$formCustomizedFields->options_selection_choice;
          }else if($formCustomizedFields->options_selection == 'range'){
            $rangeArr = explode(',', $formCustomizedFields->options_selection_choice);
            $validationArr[$ck] = 'required|array|min:'.$rangeArr[0].'|max:'.$rangeArr[1];
          }
          $requestArr[$ck] = $c_field;
        }else{
          $customized_fieldsArr[$ck] = $c_field;
        }
      }
    }
    if($form->is_required_profile_image){
      $validationArr['profile'] = 'required|image';
    }
    if($form->is_required_logo){
      $validationArr['logo'] = 'required|image';
    }
    $v = Validator::make($requestArr, $validationArr);
    if ($v->fails()){
      return redirect()->back()->withErrors($v->errors())->withInput();
    }else{
      $name = Uuid::generate(4)->string;
      $account = Account::create(['user_id'=> $form->user_id, 'uuid' => strtolower($name), 'name' => $name, 'category_id' => $form->category_id]);
      $contactData = [
        'uuid' => Uuid::generate(4)->string,
        'user_id' => $form->user_id,
        'account_id' => $account->id,
        'role' => $request->input('role')?$request->input('role'):'',
        'email' => $request->input('email')?$request->input('email'):'',
        'first_name' => $request->input('first_name')?$request->input('first_name'):'',
        'last_name' => $request->input('last_name')?$request->input('last_name'):'',
        'telephone' => $request->input('telephone')?$request->input('telephone'):'',
        'website' => $request->input('website')?$request->input('website'):'',
        'company' => $request->input('company')?$request->input('company'):'',
        'cvr_number' => $request->input('cvr_number')?$request->input('cvr_number'):'',
        'address' => $request->input('address')?$request->input('address'):'',
        'company_telephone' => $request->input('company_telephone')?$request->input('company_telephone'):'',
        'company_email' => $request->input('company_email')?$request->input('company_email'):'',
      ];
      if($request->file('profile')) {
          $fileName = time().'_'.$request->file('profile')->getClientOriginalName();
          $request->file('profile')->move(public_path('uploads/accounts/profile'), $fileName);
          $contactData['profile_image'] = 'uploads/accounts/profile/'.$fileName;
      }
      if($request->file('logo')) {
          $fileName = time().'_'.$request->file('logo')->getClientOriginalName();
          $request->file('logo')->move(public_path('uploads/accounts/logo'), $fileName);
          $contactData['logo'] = 'uploads/accounts/logo/'.$fileName;
      }
      $contact = Contact::create($contactData);
      if($form->add_to_deals){
        $dealData = [
          'user_id' => $form->user_id,
          'name' => Uuid::generate(4)->string,
          'account_id' => $account->id,
          'contact_id' => $contact->id,
          'status' => 'new'
        ];
        $deal = Deal::create($dealData);
      }
      $edit_link = url('/accounts/'.$account->uuid.'/contact/edit/'.$contact->id);
      Notification::create([
        'user_id' => $form->user_id,
        'type' => 'contact',
        'message' => 'A <a href="'.$edit_link.'">New Contact</a> has been added through '.$form->name.' form',
        'status' => 0
      ]);
      FormSubmission::create([
        'form_id' => $form->id,
        'contact_id' => $contact->id,
        'customized_fields_data' => json_encode($customized_fieldsArr),
        'status' => true
      ]);
      return redirect()->back()->with(['status' => 'Request sent successfully']);
    }
  }

  public function viewFormResponses(Request $request, $uuid){
    $form = Form::where(['uuid' => $uuid])->first();
    $totalSubmissions = Form::with(['FormSubmissions', 'FormSubmissions.Contact', 'FormSubmissions.Contact.Account'])->where('uuid', '=', $uuid)->first();
    return view('forms.responses', [
      'form' => $form,
      'totalSubmissions' => $totalSubmissions
    ]);
  }

  public function deleteFormSubmission(Request $request, $id){
    if($request->isJson()){
      $formSubmission = FormSubmission::find($id);
      $contact = Contact::find($formSubmission->contact_id);
      Account::find($contact->account_id)->delete();
      $contact->delete();
      $formSubmission->delete();
      return response()->json([
         'success' => true,
         'url' => url('/forms')
       ]);
    }
  }

  public function saveCustomizedFields(Request $request, $id){
    $v = Validator::make($request->all(), [
      'name' => 'required',
      'type' => 'required'
    ]);
    if ($v->fails()){
      return response()->json([
        'success' => false,
        'error' => $v->errors(),
        'message' => $v->errors()->first()
      ], 400);
    }else{
      $customizedFieldsData = [
        'form_id' => $id,
        'name' => $request->input('name'),
        'type' => $request->input('type'),
        'is_required' => ($request->input('is_required'))?true:false,
        'is_displayed' => true,
        'option_name' => ($request->input('option_name'))?implode(',', $request->input('option_name')):'',
        'options_selection' => $request->input('options_selection'),
        'options_selection_choice' => ($request->input('options_selection') == 'range')?implode('-', $request->input('options_selection_range_choice')):$request->input('options_selection_choice')
      ];
      $FormCustomizedFields = FormCustomizedFields::create($customizedFieldsData);
      $form = Form::find($id);
      ob_start();
      ?>
      <div class="row">
        <div class="col-md-2">
          <small class="h5 align-middle text-dark font-weight-light"><?php echo $FormCustomizedFields->name; ?></small>
        </div>
        <div class="col-md-1">
          <span><?php echo $FormCustomizedFields->type; ?></span>
        </div>
        <div class="col-md-1">
          <a href="javascript:;" class="btn btn-info btn-sm customized-field-edit" data-id="<?php echo $FormCustomizedFields->id; ?>"><span class="material-icons">edit</span>Edit</a>
        </div>
        <div class="col-md-8">
          <a href="javascript:;" class="btn btn-danger btn-sm customized-field-delete" data-id="<?php echo $FormCustomizedFields->id; ?>"><span class="material-icons">delete</span>Delete</a>
        </div>
      </div>
      <?php
      $output = ob_get_contents();
      ob_end_clean();
      return response()->json([
        'success' => true,
        'output' => $output,
        'url' => url('/forms/'.$form->uuid.'/edit')
      ]);
    }
  }

  public function deleteCustomizedFields(Request $request, $id){
    if($request->isJson()){
       FormCustomizedFields::find($id)->delete();
       return response()->json([
         'success' => true
       ]);
    }
  }

  public function editCustomizedFields(Request $request, $id){
    if($request->isJson()){
       $FormCustomizedFields = FormCustomizedFields::find($id);
       $options_selection_choiceArr = explode('-', $FormCustomizedFields->options_selection_choice);

       ob_start();
       ?>
       <div class="modal fade" id="edit-customized-fields-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
           <div class="modal-content">
             <div class="modal-header">
               <h5 class="modal-title">Edit Customized field</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
             <form name="customized-fields-edit-form" id="customizedFieldsEditForm" data-id="<?php echo $id; ?>">
               <div class="modal-body">
                 <div class="form-group">
                   <label for="name" class="bmd-label-floating">Name</label>
                   <input type="text" class="form-control" name="name" value="<?php echo $FormCustomizedFields->name; ?>" required>
                 </div>
                 <div class="form-group">
                   <label for="type" class="bmd-label-floating"></label>
                   <select class="form-control" name="type">
                     <option value="text" <?php echo ($FormCustomizedFields->type == 'text')?'selected="selected"':''; ?>>Text</option>
                     <option value="longtext" <?php echo ($FormCustomizedFields->type  == 'longtext')?'selected="selected"':''; ?>>Long Text</option>
                     <option value="number" <?php echo ($FormCustomizedFields->type  == 'number')?'selected="selected"':''; ?>>Number</option>
                     <option value="dropdown" <?php echo ($FormCustomizedFields->type  == 'dropdown')?'selected="selected"':''; ?>>Dropdown</option>
                     <option value="checkboxes" <?php echo ($FormCustomizedFields->type == 'checkboxes')?'selected="selected"':''; ?>>Checkboxes</option>
                   </select>
                 </div>
                 <div class="type-custom-fields">
                   <?php
                    if($FormCustomizedFields->option_name){
                      $option_nameArr = explode(',', $FormCustomizedFields->option_name);
                      foreach($option_nameArr as $option_name){
                        ?>
                        <div class="form-group w-75"><input type="text" class="form-control d-inline w-75" name="option_name[]" placeholder="Option Name" value="<?php echo $option_name;?> "><span class="material-icons align-middle remove-customized-field-option" role="crmbutton">delete_outline</span></div>
                        <?php
                      }
                      ?>
                      <div class="form-group w-75"><a href="javascript:;" class="btn btn-default btn-sm type_add_options"><span class="material-icons">add</span>Add options</a></div>
                      <?php
                    }
                    ?>

                 </div>
                 <div class="form-group <?php echo ($FormCustomizedFields->type == 'checkboxes')?'d-none':''; ?>">
                   <div class="togglebutton">
                     <label>
                       <input type="checkbox" value="1" name="is_required" <?php echo ($FormCustomizedFields->is_required == '1')?'checked="checked"':''; ?>>
                       <span class="toggle"></span>
                       Is required?
                     </label>
                   </div>
                 </div>
                 <div class="options_selection <?php echo ($FormCustomizedFields->type != 'checkboxes')?'d-none':''; ?>">
                   <label for="name" class="bmd-label-floating">Number of choices respondents must answer:</label>
                   <div class="form-row">
                     <div class="col">
                       <select class="form-control" name="options_selection">
                         <option value="atleast" <?php echo ($FormCustomizedFields->options_selection == 'atleast')?'selected="selected"':''; ?>>Atleast</option>
                         <option value="atmost" <?php echo ($FormCustomizedFields->options_selection == 'atmost')?'selected="selected"':''; ?>>Atmost</option>
                         <option value="exactly" <?php echo ($FormCustomizedFields->options_selection == 'exactly')?'selected="selected"':''; ?>>Exactly</option>
                         <option value="range" <?php echo ($FormCustomizedFields->options_selection == 'range')?'selected="selected"':''; ?>>Range</option>
                       </select>
                     </div>
                     <div class="col <?php echo ($FormCustomizedFields->options_selection == 'range')?'d-none':''; ?>" id="other_option_selection">
                       <input type="text" class="form-control" name="options_selection_choice" placeholder="Number" value="<?php echo (strpos($FormCustomizedFields->options_selection_choice, '-') !== FALSE)?0:$FormCustomizedFields->options_selection_choice; ?>">
                     </div>
                     <div class="col <?php echo ($FormCustomizedFields->options_selection == 'range')?'':'d-none'; ?>" id="range_option_selection">
                       <span class="mr-2 align-middle">from</span>
                       <div class="form-group d-inline-block w-25">
                         <input type="number" class="form-control w-50" name="options_selection_range_choice[]" value="<?php echo (strpos($FormCustomizedFields->options_selection_choice, '-') !== FALSE)?$options_selection_choiceArr[0]:0;?>" placeholder="Number">
                       </div>
                       <span class="mr-2 align-middle">to</span>
                       <div class="form-group d-inline-block w-25">
                         <input type="number" class="form-control w-50" name="options_selection_range_choice[]" value="<?php echo (strpos($FormCustomizedFields->options_selection_choice, '-') !== FALSE)?$options_selection_choiceArr[1]:1;?>" placeholder="Number">
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
       <?php
       $output = ob_get_contents();
       ob_end_clean();
       return response()->json([
         'success' => true,
         'output' => $output
       ]);
    }
  }

  public function updateCustomizedFields(Request $request, $id){
    $v = Validator::make($request->all(), [
      'name' => 'required',
      'type' => 'required'
    ]);
    if ($v->fails()){
      return response()->json([
        'success' => false,
        'error' => $v->errors(),
        'message' => $v->errors()->first()
      ], 400);
    }else{
      $customizedFieldsData = [
        'name' => $request->input('name'),
        'type' => $request->input('type'),
        'is_required' => ($request->input('is_required'))?true:false,
        'option_name' => ($request->input('option_name'))?implode(',', $request->input('option_name')):'',
        'options_selection' => $request->input('options_selection'),
        'options_selection_choice' => ($request->input('options_selection') == 'range')?implode('-', $request->input('options_selection_range_choice')):$request->input('options_selection_choice')
      ];
      FormCustomizedFields::find($id)->update($customizedFieldsData);
      $FormCustomizedFields = FormCustomizedFields::find($id);

      return response()->json([
        'success' => true,
        'customized_fields' => $FormCustomizedFields
      ]);
    }
  }

  public function createUpdateForm(Request $request){
    $formData = [
      'category_id' => ($request->input('category_id'))?$request->input('category_id'):NULL,
      'add_to_deals' => ($request->input('add_to_deals'))?true:false,
    ];
    $form = Form::find($request->input('form_id'))->update($formData);
    return response()->json([
      'success' => true,
      'url' => url('/forms')
    ]);
  }

}
