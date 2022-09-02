<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Models\Notification;

class NotificationController extends Controller{

  public function __construct(){
      $this->middleware(['auth','verified']);
  }

  public function index(Request $request){
    return view('notifications.index');
  }

  public function seeRead(Request $request){
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

    $totalRecords = Notification::where('user_id', '=', \Auth::user()->id)->where('status', '=', 1)->count();

    $totalRecordswithFilter  = Notification::where('user_id', '=', \Auth::user()->id)->where('status', '=', 1)->where('message', 'LIKE', '%'.$searchValue.'%')->count();

    $records = Notification::orderBy($columnName,$columnSortOrder)->where('user_id', '=', \Auth::user()->id)->where('status', '=', 1)
       ->where('message', 'LIKE', '%'.$searchValue.'%')->skip($start)
       ->take($rowperpage)
       ->get();

    $data_arr = [];
    if($records){
      foreach($records as $record){
         $data_arr[] = array(
           "created_at" => date('d/m-y' , strtotime($record->created_at)).' at '.date('H:i' , strtotime($record->created_at)),
           "message" => $record->message,
           "actions" => '<div class="pull-right"><a href="javascript:;" class="btn btn-link btn-info btn-just-icon mark-unread" title="Mark unread" rel="tooltip" data-id="'.$record->id.'"><i class="material-icons">mark_as_unread</i></a></div>',
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

  public function markRead(Request $request){
    if($request->isJson()){
      $notifications = Notification::find($request->input('id'))->update(array('status' => 1));
      return response()->json([
        'success' => true,
        'count' =>  Notification::where(['user_id' => \Auth::user()->id, 'status' => 0])->count()
      ]);
    }
  }

  public function markAllRead(Request $request){
    if($request->isJson()){
      $notifications = Notification::where(['user_id' => \Auth::user()->id, 'status' => 0])->update(array('status' => 1));
      return response()->json([
        'success' => true
      ]);
    }
  }


  public function markUnread(Request $request){
    if($request->isJson()){
      $notifications = Notification::find($request->input('id'))->update(array('status' => 0));
      $notification = Notification::find($request->input('id'));
      return response()->json([
        'success' => true,
        'count' =>  Notification::where(['user_id' => \Auth::user()->id, 'status' => 0])->count(),
        'notification' => '<div class="form-check form-check-radio dropdown-item"><label class="form-check-label"><input class="form-check-input" type="checkbox" name="mark_read[]" value="'.$notification->id.'" >'.$notification->message.'<span class="circle"><span class="check"></span></span></label></div>'
      ]);
    }
  }

}
