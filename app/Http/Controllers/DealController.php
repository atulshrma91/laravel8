<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Models\Account;
use \App\Models\Contact;
use \App\Models\Deal;
use \App\Models\DealSource;
use \App\Models\DealCategories;
use \App\Models\DealComment;
use Uuid;

class DealController extends Controller{

  public function __construct(){
      $this->middleware(['auth','verified', 'extension:deals', 'extension.enabled:deals']);
  }

  public function index(){
    $new_deals = Deal::with(['Contact', 'Contact.Account'])->where(['user_id' => \Auth::user()->id, 'status' => 'new'])->orderBy('id', 'DESC')->get();
    $dialog_deals = Deal::with(['Contact', 'Contact.Account'])->where(['user_id' => \Auth::user()->id, 'status' => 'dialog'])->orderBy('id', 'DESC')->get();
    $proposal_deals = Deal::with(['Contact', 'Contact.Account'])->where(['user_id' => \Auth::user()->id, 'status' => 'proposal'])->orderBy('id', 'DESC')->get();
    $deal_source_headlines = DealSource::where(['user_id' => \Auth::user()->id])->get();
    $accounts = Account::select('id','name')->where('user_id', '=', \Auth::user()->id)->get();
    return view('deals.index', [
      'new_deals' => $new_deals,
      'dialog_deals' => $dialog_deals,
      'proposal_deals' => $proposal_deals,
      'deal_source_headlines' => $deal_source_headlines,
      'accounts' => $accounts
    ]);
  }

  public function getAccountContacts(Request $request){
    if($request->isJson()){
      $contacts = Contact::select('id','first_name', 'last_name')->where(['account_id' => $request->input('id'),  'user_id' => \Auth::user()->id])->whereNotNull('first_name')->whereNotNull('last_name')->get();
      if(!$contacts->isEmpty()){
        return response()->json([
          'success' => true,
          'contacts' => $contacts->toArray()
        ]);
      }else{
        return response()->json([
          'success' => true,
          'contacts' => []
        ]);
      }
    }
  }

  public function createDeal(Request $request){
    $v = Validator::make($request->all(), [
      'name' => 'required|unique:deals',
      'deal_account' => 'required|numeric',
      'deal_contact' => 'required|numeric',
    ]);
    if ($v->fails()){
      return response()->json([
        'success' => false,
        'error' => $v->errors(),
        'message' => $v->errors()->first()
      ], 200);
    }else{
      $dealData = [
        'user_id' => \Auth::user()->id,
        'name' => $request->input('name'),
        'account_id' => $request->input('deal_account'),
        'contact_id' => $request->input('deal_contact'),
        'status' => 'new'
      ];
      $deal = Deal::create($dealData);
      return response()->json([
        'success' => true,
        'deal_id' => $deal->id,
        'status' => 'Deal created successfully'
      ]);
    }
  }

  public function updateDealStatus(Request $request){
    if($request->isJson()){
      $dataArr = [];
      $dataArr['status'] =  $request->input('status');
      if($request->input('status') == 'won'){
        $dataArr['date_won'] = date('Y-m-d H:i:s');
        $dataArr['date_lost'] = NULL;
      }else if($request->input('status') == 'lost'){
        $dataArr['date_lost'] = date('Y-m-d H:i:s');
        $dataArr['date_won'] = NULL;
      }
      $deal = Deal::find($request->input('id'))->update($dataArr);
       return response()->json([
         'success' => true,
         'url' => url('/deals')
       ]);
    }
  }

  public function deleteDeal(Request $request, $id){
    if($request->isJson()){
      $deal = Deal::find($id)->delete();
       return response()->json([
         'success' => true,
         'url' => url('/deals')
       ]);
    }
  }

  public function duplicateDeal(Request $request, $id){
    if($request->isJson()){
      $deal = Deal::find($id);
      $dealData = [
        'user_id' => $deal->user_id,
        'name' => $deal->name,
        'account_id' => $deal->account_id,
        'contact_id' => $deal->contact_id,
        'status' => $deal->status,
      ];
      $deal = Deal::create($dealData);
       return response()->json([
         'success' => true,
         'url' => url('/deals')
       ]);
    }
  }

  public function editDeal(Request $request, $id){
    $accounts = Account::select('id','name')->where('user_id', '=', \Auth::user()->id)->get();
    $deal = Deal::find($id);
    $contacts = Contact::select('id','first_name', 'last_name')->where(['account_id' => $deal->account_id,  'user_id' => \Auth::user()->id])->whereNotNull('first_name')->whereNotNull('last_name')->get();
    $dealCategories = DealCategories::where('user_id', '=', \Auth::user()->id)->get();
    return view('deals.edit', [
      'accounts' => $accounts,
      'deal' => $deal,
      'contacts' => $contacts,
      'dealCategories' => $dealCategories
    ]);
  }

  public function updateDeal(Request $request, $id){
    $v = Validator::make($request->all(), [
      'name' => 'required|unique:deals,name,'. $id,
      'deal_account' => 'required|numeric',
      'deal_contact' => 'required|numeric',
    ]);
    if ($v->fails()){
      return redirect()->back()->withErrors($v->errors())->withInput();
    }else{
      $dealData = [
        'name' => $request->input('name'),
        'account_id' => $request->input('deal_account'),
        'contact_id' => $request->input('deal_contact'),
      ];
      Deal::find($id)->update($dealData);
      return redirect()->route('deals.view')->with(['status' => 'Deal updated successfully']);
    }
  }

  public function dealSettings(Request $request){
    $v = Validator::make($request->all(), [
      'name' => 'required|unique:deal_sources'
    ]);
    if ($v->fails()){
      return response()->json([
        'success' => false,
        'error' => $v->errors(),
        'message' => $v->errors()->first()
      ], 400);
    }else{
      if($request->input('index')){
        DealSource::where('id', $request->input('index'))->update(['name' => $request->input('name')]);
      }else{
        $dealSourceData = [
          'user_id' => \Auth::user()->id,
          'name' => $request->input('name')
        ];
        $dealSource = DealSource::create($dealSourceData);
      }
      return response()->json([
        'success' => true,
        'status' => 'Deal heading updated successfully'
      ]);
    }
  }

  public function dealsListing(Request $request){
    return view('deals.listing');
  }

  public function getWonLostDeals(Request $request){
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

    $totalRecords = Deal::with(['Contact', 'Contact.Account'])->where('user_id', '=', \Auth::user()->id)->whereIn('status', ['won', 'lost'])->count();

    $totalRecordswithFilter  = Deal::with(['Contact', 'Contact.Account'])->where('user_id', '=', \Auth::user()->id)->whereIn('status', ['won', 'lost'])->count();
    /*$records = Deal::orderBy($columnName,$columnSortOrder)->with(['Contact', 'Contact.Account'])->where('user_id', '=', \Auth::user()->id)->whereIn('status', ['won', 'lost'])
       ->skip($start)
       ->take($rowperpage)
       ->get();*/
      if($columnName === 'person'){
        $columnName = 'contacts.first_name';
      }else if ($columnName === 'account'){
        $columnName = 'accounts.name';
      }else if ($columnName === 'telephone'){
        $columnName = 'contacts.telephone';
      }else if ($columnName === 'email'){
        $columnName = 'contacts.email';
      }else if ($columnName === 'comments'){
        $columnName = 'deal_comments.comment';
      }
     $records = Deal::with('lastComment')->select('deals.*', 'accounts.name as account_name', 'contacts.first_name', 'contacts.telephone', 'contacts.email')
        ->join('contacts', 'contacts.id', '=', 'deals.contact_id')
        ->join('accounts', 'accounts.id', '=', 'deals.account_id')
        ->where('deals.user_id', '=', \Auth::user()->id)->whereIn('deals.status', ['won', 'lost'])
        ->orderBy($columnName,$columnSortOrder)
        ->skip($start)
        ->take($rowperpage)
        ->get();

    $data_arr = [];
    if($records){
      foreach($records as $record){
         $data_arr[] = array(
           "created_at" => date('F j, Y', strtotime($record->created_at)),
           "date_won" => ($record->date_won)?date('F j, Y', strtotime($record->date_won)):'',
           "date_lost" => ($record->date_lost)?date('F j, Y', strtotime($record->date_lost)):'',
           "name" => $record->name,
           "account" => ($record->account_name)?$record->account_name:'',
           "person" => $record->first_name.' '.$record->last_name,
           "telephone" => $record->telephone,
           "email" => $record->email,
           "comments" => ($record->lastComment)?$record->lastComment->comment:'',
           "source" => '<div class="dropdown show">
                          <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="material-icons">design_services</span>
                          </a>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="'.('/deals/'.$record->id.'/edit').'"><i class="material-icons">edit</i>'.__('deals.edit_deal_btn').'</a>
                            <a class="dropdown-item delete-deal" href="javascript:;" data-id="'.$record->id.'"><i class="material-icons">delete</i>Delete</a>
                            <a class="dropdown-item activate-deal" href="javascript:;" data-id="'.$record->id.'"><i class="material-icons">loop</i>Activate</a>
                          </div>
                        </div>'

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

  public function createDealComment(Request $request){
    $v = Validator::make($request->all(), [
      'date' => 'required',
      'deal_id' => 'required|numeric',
      'deal_category' => 'required|numeric',
      'comment' => 'required',
    ]);
    if ($v->fails()){
      return response()->json([
        'success' => false,
        'error' => $v->errors(),
        'message' => $v->errors()->first()
      ], 200);
    }else{


      $dealData = [
        'deal_id' => $request->input('deal_id'),
        'deal_category_id' => $request->input('deal_category'),
        'comment' => $request->input('comment'),
        'date' => date('Y-m-d', strtotime($request->input('date')))
      ];
      $deal = DealComment::create($dealData);
      return response()->json([
        'success' => true,
        'deal_id' => $deal->id,
        'status' => 'Comment created successfully'
      ]);
    }
  }

  public function getDealComments(Request $request, $id){
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

    $totalRecords = DealComment::with(['Deal', 'Category'])->where('deal_id', '=', $id)->count();
    $totalRecordswithFilter  = DealComment::with(['Deal', 'Category'])->where('deal_id', '=', $id)
     ->when(!empty($searchValue) , function ($query) use($searchValue){
      $query->where('comment', 'LIKE', '%'.$searchValue.'%');
     })->count();

    $records = DealComment::orderBy($columnName,$columnSortOrder)->with(['Deal', 'Category'])->where('deal_id', '=', $id)
      ->when(!empty($searchValue) , function ($query) use($searchValue){
        $query->where('comment', 'LIKE', '%'.$searchValue.'%');
       })->skip($start)
       ->take($rowperpage)
       ->get();

    $data_arr = [];
    if($records){
      foreach($records as $record){
         $data_arr[] = array(
           "date" => date('F j, Y', strtotime($record->date)),
           "deal_category_id" => $record->Category->name,
           "comment" => $record->comment,
           "actions" => '<div class="dropdown show">
                          <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="material-icons">design_services</span>
                          </a>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item edit-comment" href="javascript:;" data-id="'.$record->id.'"><i class="material-icons">edit</i>Edit</a>
                            <a class="dropdown-item delete-comment" href="javascript:;" data-id="'.$record->id.'"><i class="material-icons">delete</i>Delete</a>
                          </div>
                        </div>'
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

  public function deleteDealComment(Request $request, $id){
      $deal = DealComment::find($id)->delete();
       return response()->json([
         'success' => true,
         'url' => url('/deals/'.$id.'/edit')
       ]);
  }

  public function getDealComment(Request $request, $id){
      $dealComment = DealComment::find($id);
      $dealComment->date = date('d-m-Y', strtotime($dealComment->date));
       return response()->json([
         'success' => true,
         'data' => $dealComment
       ]);
  }

  public function updateDealComment(Request $request, $id){
    $v = Validator::make($request->all(), [
      'date' => 'required',
      'deal_category' => 'required|numeric',
      'comment' => 'required',
    ]);
    if ($v->fails()){
      return response()->json([
        'success' => false,
        'error' => $v->errors(),
        'message' => $v->errors()->first()
      ], 400);
    }else{
      $dealData = [
        'date' => date('Y-m-d', strtotime($request->input('date'))),
        'deal_category_id' => $request->input('deal_category'),
        'comment' => $request->input('comment'),
      ];
      DealComment::find($id)->update($dealData);
      return response()->json([
        'success' => true,
        'url' => url('/deals/'.$id.'/edit')
      ]);
    }

  }
}
