<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Models\Account;
use \App\Models\Contact;
use \App\Models\Category;
use \App\Models\FormSubmission;
use Uuid;

class AccountController extends Controller{

  public function __construct(){
      $this->middleware(['auth','verified']);
  }

  public function index(Request $request){
    $categories = Category::where(['user_id' => \Auth::user()->id])->get();
    $accounts = Account::with(['Category'])->where('user_id', '=', \Auth::user()->id)
       ->where('name', 'LIKE', '%'.$request->query('a').'%')
       ->get();
     $accountsArr = [];
     if(!$accounts->isEmpty()){
       foreach($accounts as $acc){
         $accountsArr[$acc->id] =  $acc->name;
       }
     }
    return view('accounts.index', [
      'categories' => $categories,
      'accounts' => $accounts,
      'accountsArr' => json_encode($accountsArr)
    ]);
  }

  public function getAccounts(Request $request){
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

    $totalRecords = Account::with(['Category'])->where('user_id', '=', \Auth::user()->id)->count();

    $totalRecordswithFilter  = Account::with(['Category'])->where('user_id', '=', \Auth::user()->id)->where('uuid', 'LIKE', '%'.$searchValue.'%')->count();

    $records = Account::orderBy($columnName,$columnSortOrder)->with(['Category'])->where('user_id', '=', \Auth::user()->id)
       ->where('uuid', 'LIKE', '%'.$searchValue.'%')->skip($start)
       ->take($rowperpage)
       ->get();

    $data_arr = [];
    if($records){
      foreach($records as $record){
        $arr = array(
           "name" => $record->name,
           "created_at" => date('F j, Y', strtotime($record->created_at)),
           "actions" => '<div class="pull-right"><a href="'.url("/accounts/".$record->uuid).'"  class="btn btn-link btn-info btn-just-icon"><i class="material-icons">visibility</i></a></div>',
         );
         if(\Auth::user()->isExtensionActivated('categories')){
           $arr['category'] = ($record->Category)?$record->Category->name:'';
         }
         $data_arr[] = $arr;
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

  public function addAccount(Request $request){


      $v = Validator::make($request->all(), [
        'name' => 'required|regex:/^[a-zA-Z0-9\s-]+$/|unique:accounts',
      ]);
      if ($v->fails()){
        return response()->json([
          'success' => false,
          'error' => $v->errors(),
          'message' => $v->errors()->first()
        ], 400);
      }else{
        $accountData = [
          'user_id'=>\Auth::user()->id,
          //'uuid' => str_replace(" ","-",strtolower($request->input('name'))),
          'uuid' => Uuid::generate(4)->string,
          'name' => $request->input('name')
        ];
        if($request->input('category_id')){
          $accountData['category_id'] = $request->input('category_id');
        }
        if($request->file('image')) {
            $fileName = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/accounts/image'), $fileName);
            $accountData['image'] = 'uploads/accounts/image/'.$fileName;
        }
        $contact = Account::create($accountData);
        return response()->json([
          'success' => true,
          'url' => url('/accounts')
        ]);
      }

  }

  public function viewAccount(Request $request, $uuid){
    $account = Account::with(['Category'])->where(['uuid' => $uuid, 'user_id' => \Auth::user()->id])->first();
    $accounts = Account::select('id', 'name')->where('uuid', '!=', $uuid)->where('user_id', '=', \Auth::user()->id)->get();
    $categories = Category::where(['user_id' => \Auth::user()->id])->get();
    $accountsArr = [];
    if(!$accounts->isEmpty()){
      foreach($accounts as $acc){
        $accountsArr[$acc->id] =  $acc->name;
      }
    }
    if($account){
      return view('accounts.view',[
        'account' => $account,
        'accounts' => json_encode($accountsArr),
        'categories' => $categories
      ]);
    }else{
      abort(404);
    }
  }

  public function updateAccount(Request $request, $id){
      $v = Validator::make($request->all(), [
        'name' => 'required|regex:/^[a-zA-Z0-9\s-]+$/|unique:accounts,name,'. $id,
      ]);
      if ($v->fails()){
        return response()->json([
          'success' => false,
          'error' => $v->errors(),
          'message' => $v->errors()->first()
        ], 400);
      }else{
        $accountData = [
          'name' => $request->input('name'),
          'category_id' => ($request->input('category_id'))?$request->input('category_id'):NULL,
        ];
        if($request->file('image')) {
            $fileName = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/accounts/image'), $fileName);
            $accountData['image'] = 'uploads/accounts/image/'.$fileName;
        }
        Account::find($id)->update($accountData);
        return response()->json([
          'success' => true,
          'url' => url('/accounts')
        ]);
      }
  }

  public function deleteAccount(Request $request, $id){
    if($request->isJson()){
      Account::find($id)->delete();
      return response()->json([
        'success' => true,
        'url' => url('/accounts')
      ]);
    }
  }

  public function createContact(Request $request, $uuid){
    $v = Validator::make($request->all(), [
      'email' => 'nullable|email',
      'telephone' => 'nullable|numeric',
      'website' => 'nullable|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
      'company_telephone' => 'nullable|numeric',
      'company_email' => 'nullable|email',
    ]);
    if ($v->fails()){
      return response()->json([
        'success' => false,
        'error' => $v->errors(),
        'message' => $v->errors()->first()
      ], 200);
    }else{
      $account = Account::where(['uuid' => $uuid])->first();
      $contactData = [
        'uuid' => Uuid::generate(4)->string,
        'user_id' => \Auth::user()->id,
        'account_id' => $account->id,
        'role' => $request->input('role'),
        'email' => $request->input('email'),
        'first_name' => $request->input('first_name'),
        'last_name' => $request->input('last_name'),
        'telephone' => $request->input('telephone'),
        'website' => $request->input('website'),
        'company' => $request->input('company'),
        'cvr_number' => $request->input('cvr_number'),
        'address' => $request->input('address'),
        'company_telephone' => $request->input('company_telephone'),
        'company_email' => $request->input('company_email'),
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
      return response()->json([
        'success' => true,
        'deal_id' => $contact->id,
        'status' => 'Contact created successfully'
      ]);
    }
  }

  public function getAccountContacts(Request $request, $id){
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

    $totalRecords = Contact::with(['Account'])->where(['account_id' => $id, 'user_id' => \Auth::user()->id])->count();

    $totalRecordswithFilter  = Contact::with(['Account'])->where(['account_id' => $id,  'user_id' => \Auth::user()->id])
    ->when(!empty($searchValue) , function ($query) use($searchValue){
     $query->where('email', 'LIKE', '%'.$searchValue.'%');
    })

     ->count();

    $records = Contact::orderBy($columnName,$columnSortOrder)->with(['Account'])
       ->where(['account_id' => $id,  'user_id' => \Auth::user()->id])
       ->when(!empty($searchValue) , function ($query) use($searchValue){
        $query->where('email', 'LIKE', '%'.$searchValue.'%');
       })
       ->skip($start)
       ->take($rowperpage)
       ->get();
    $data_arr = [];
    if(!$records->isEmpty()){
      foreach($records as $record){

         $edit_link = url('/accounts/'.$record->Account->uuid.'/contact/edit/'.$record->id);
         $data_arr[] = array(
           'profile' => ($record->profile_image)?'<img src="'.asset($record->profile_image).'" class="rounded thumbnail" />':'',
           'role' => $record->role,
           'email' => $record->email,
           'first_name' =>$record->first_name.' '.$record->last_name,
           'telephone' => $record->telephone,
           'website' => $record->website,
           'company' => $record->company,
           'address' => $record->address,
           'company_telephone' => $record->company_telephone,
           'company_email' => $record->company_email,
           "actions" => '<div class="dropdown show">
                          <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="material-icons">design_services</span>
                          </a>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="'.$edit_link.'"><i class="material-icons">edit</i>'.__('accounts.edit_contact_btn').'</a>
                            <a class="dropdown-item delete-contact" href="javascript:;" data-id="'.$record->id.'" data-uuid="'.$record->Account->uuid.'" data-account-id="'.$record->Account->id.'"><i class="material-icons">delete</i>'.__('accounts.delete_contact_btn').'</a>
                            <a class="dropdown-item duplicate-contact" href="javascript:;" data-id="'.$record->id.'" data-uuid="'.$record->Account->uuid.'" data-account-id="'.$record->Account->id.'"><i class="material-icons">content_copy</i>'.__('accounts.duplicate_contact_btn').'</a>
                            <a class="dropdown-item move-contact" href="javascript:;" data-id="'.$record->id.'" data-uuid="'.$record->Account->uuid.'" data-account-id="'.$record->Account->id.'"><i class="material-icons">repeat</i>Move contact</a>
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

  public function deleteContact(Request $request, $uuid){
    if($request->isJson()){
      Contact::find($request->input('id'))->delete();
      $account = Account::where(['uuid' => $uuid])->first();
      return response()->json([
        'success' => true,
        'url' => url('/accounts/'.$account->uuid)
      ]);
    }
  }

  public function editContact(Request $request, $uuid, $id){
    $account = Account::where(['uuid' => $uuid])->first();
    $contact = Contact::with(['FormSubmission', 'FormSubmission.Form.FormCustomizedFields'])->find($id);
    return view('accounts.contact.edit',[
      'account' => $account,
      'contact' => $contact
    ]);
  }

  public function updateContact(Request $request, $uuid, $id){
    $v = Validator::make($request->all(), [
      'email' => 'nullable|email',
      'telephone' => 'nullable|numeric',
      'website' => 'nullable|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
      'company_telephone' => 'nullable|numeric',
      'company_email' => 'nullable|email',
    ]);
    if ($v->fails()){
      return redirect()->back()->withErrors($v->errors())->withInput();
    }else{
      $contactData = [
        'role' => $request->input('role'),
        'email' => $request->input('email'),
        'first_name' => $request->input('first_name'),
        'last_name' => $request->input('last_name'),
        'telephone' => $request->input('telephone'),
        'website' => $request->input('website'),
        'company' => $request->input('company'),
        'cvr_number' => $request->input('cvr_number'),
        'address' => $request->input('address'),
        'company_telephone' => $request->input('company_telephone'),
        'company_email' => $request->input('company_email'),
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
      $customized_fieldsArr =  [];
      if($request->input('customized_fields')){
        foreach ($request->input('customized_fields') as $ck => $c_field) {
          if(is_array($c_field)){
            $customized_fieldsArr[$ck] = implode(',', $c_field);
          }else{
            $customized_fieldsArr[$ck] = $c_field;
          }
        }
      }
      $contact = Contact::with(['FormSubmission'])->find($id);
      $formSubmission_id = ($contact->FormSubmission)?$contact->FormSubmission->id:false;
      if($formSubmission_id){
        FormSubmission::find($formSubmission_id)->update(['customized_fields_data' => json_encode($customized_fieldsArr)]);
      }
      $contact->update($contactData);
      return redirect('/accounts')->with(['status' => 'Contact updated successfully']);
    }
  }

  public function duplicateContact(Request $request, $uuid){
    if($request->isJson()){
      $contact = Contact::find($request->input('id'));
      $contactData = [
        'uuid' => Uuid::generate(4)->string,
        'user_id' => \Auth::user()->id,
        'account_id' => $contact->account_id,
        'role' => $contact->role,
        'email' => $contact->email,
        'first_name' => $contact->first_name,
        'last_name' => $contact->last_name,
        'telephone' => $contact->telephone,
        'website' => $contact->website,
        'company' => $contact->company,
        'cvr_number' => $contact->cvr_number,
        'address' => $contact->address,
        'company_telephone' => $contact->company_telephone,
        'company_email' => $contact->company_email,
        'profile_image' => $contact->profile_image,
        'logo' => $contact->logo,
      ];
      $contact = Contact::create($contactData);
      $account = Account::find($contact->account_id);
      return response()->json([
        'success' => true,
        'url' => url('/accounts/'.$account->uuid)
      ]);
    }
  }

  public function moveContact(Request $request, $uuid){
    if($request->isJson()){
      $contact = Contact::find($request->input('id'));
      $account = Account::find($contact->account_id);
      $contactData = [
        'account_id' => $request->input('account_id')
      ];
      $contact = Contact::find($contact->id)->update($contactData);
      return response()->json([
        'success' => true,
        'url' => url('/accounts/'.$account->uuid),
        'new_account_id' => $request->input('account_id')
      ]);
    }
  }

}
