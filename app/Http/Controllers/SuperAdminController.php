<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;
use \App\Models\User;
use Carbon\Carbon;

class SuperAdminController extends Controller{

  public function __construct(){
      $this->middleware(['auth','verified'])->except(['getUserAuth', 'manualEmailVerify']);
  }

  public function index(){
    return view('owners.index');
  }

  public function getOwners(Request $request){

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

     $totalRecords = User::select('count(*) as allcount')->count();
     $totalRecordswithFilter = User::select('count(*) as allcount')->where('id', '!=', Auth::id())->where(function($query) use ($searchValue) {
            $query->where('name', 'LIKE', '%'.$searchValue.'%')
                ->orWhere('email', 'LIKE', '%'.$searchValue.'%');
     })->count();

     $records = User::orderBy($columnName,$columnSortOrder)->where('id', '!=', Auth::id())->where(function($query) use ($searchValue) {
          $query->where('users.email', 'LIKE', '%'.$searchValue.'%')
                ->orWhere('users.name', 'LIKE', '%'.$searchValue.'%');
      })->select('users.*')
      ->skip($start)
      ->take($rowperpage)
      ->get();

     $data_arr = [];
     foreach($records as $record){
        if($record->email_verified_at){
          $email = $record->email.'<span class="material-icons" style="color:#00bcd4;">verified</span>';
        }else{
          $email = $record->email.'<span class="material-icons" style="color:##f44336;">unpublished</span>';
        }
        $data_arr[] = array(
          "last_login" => ($record->last_login)?Carbon::parse($record->last_login)->format('d/m-Y'):'',
          "username" => $record->username,
          "name" => $record->name,
          "email" => $email,
          "actions" => '<div class="pull-right"><a href="'.url("/get-user-auth/".\Crypt::encryptString($record->id)).'"  class="btn btn-link btn-info btn-just-icon"><i class="material-icons">visibility</i></a><button type="button" class="btn btn-link btn-danger btn-just-icon delete-user" data-id="'.$record->id.'"><i class="material-icons">delete_forever</i></button></div>',
        );
     }
     $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordswithFilter,
        "aaData" => $data_arr
     );
     die(json_encode($response));
  }

  public function deleteUser(Request $request){
    if($request->isJson()){
      $v = Validator::make($request->all(), [
        'id' => 'required'
      ]);
      if ($v->fails()){
        return response()->json([
          'success' => false,
        ]);
      }else{
        User::find($request->input('id'))->forceDelete();
        return response()->json([
          'success' => true,
        ]);
      }
    }
  }

  public function getUserAuth(Request $request, $token){
    try {
      if(Auth::user()->hasRole('super-admin')){
        \Cookie::queue(\Cookie::make('superAdminId', Auth::id(), 60));
        Auth::loginUsingId(\Crypt::decryptString($token), false);
      }else{
        if(\Cookie::get('superAdminId') && \Crypt::decryptString($token) == \Config::get('app.name')){
          Auth::loginUsingId(\Cookie::get('superAdminId'), false);
          \Cookie::queue(\Cookie::forget('superAdminId'));
        }
      }
      return redirect('/accounts');
    } catch (DecryptException $e) {
      return redirect('/owners');
    }
  }

  public function manualEmailVerify(Request $request, $token){
    try {
      User::where('id', \Crypt::decryptString($token))->update(['email_verified_at' => date('Y-m-d H:i:s')]);
      return redirect('/accounts');
    } catch (DecryptException $e) {
      return back();
    }
  }
}
