<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;
use Validator;
use Redirect;
use DateTime;
use Helper;
use Auth;

class UserAccessController extends Controller
{
  /**
  * Instantiate a new new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('auth');
  }


  public function auth($id){
    return view('backend.user-access.auth',[
      'ace'=>$ace
    ]);
  }
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $auth = $this->CheckAuth();

      if($auth == true){
        $ace=DB::table('user_access')->get();
        return view('backend.user-access.index',[
          'ace'=>$ace
        ]);

    }else{
      return Redirect::back()->withErrors(['msg', 'No Access']);
    }
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
     $auth = $this->CheckAuth();
       if($auth == true){

        $ace=DB::table('user_access')->get();
        return view('backend.user-access.create',[
          'ace'=>$ace
        ]);

      }else{
        return Redirect::back()->withErrors(['msg', 'No Access']);
      }
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    $auth = $this->CheckAuth();

    if($auth == true){
      # code...
      // validate the info, create rules for the inputs
      $rules = array(

      );
      // run the validation rules on the inputs from the form
      $validator = Validator::make(Input::all(), $rules);
      // if the validator fails, redirect back to the form
      if ($validator->fails()) {
        return redirect()->back()
        ->withErrors($validator) // send back all errors to the login form
        ->withInput(); // send back the input (not the password) so that we can repopulate the form
      } else {

        $access       =Input::get('access');
        $now          = new DateTime();
        if(!empty($request['status'])){
          $enable=1;
        }else{
          $enable=0;
        }

        if(!empty($request['type'])){
          $type=1;
        }else{
          $type=0;
        }
        $status = $enable;


        $insert = DB::table('user_access')->insert([
          'access'=>$access,
          'status' =>$status,
          'type'   =>$type,
          'created_at'     => $now,
        ]);
        if($insert){
          //fungsi untuk sytem log
            // $logcontent ="Add new data access name($access), status($status) for User Access";
            // $logtype ="User Access";
            // $loguser =Auth::user()->id;
            // $logdateTime=new DateTime();
            // $log=  Helper::userlog($logtype,$logcontent,$loguser,$logdateTime);
          //end userlog

          return redirect()->to('backend/user-access')->with('success-create','Thank you for access add!');

        }else{
          return Redirect()->back()->with('error','Sorry something is error !');
        }
      }
    }else{
      return Redirect::back()->withErrors(['msg', 'No Access']);
    }
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    $auth = $this->CheckAuth();
    if($auth == true){

        $row=DB::table('user_access')->where('access_id','=',$id)->first();
        return view('backend.user-access.edit',[
          'row'=>$row
        ]);

    }else{
      return Redirect::back()->withErrors(['msg', 'No Access']);
    }
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {
    $auth = $this->CheckAuth();

    if($auth == true){

      $rules = array(
        // 'name'       => 'required',
        // 'email'      => 'required|email',
        // 'nerd_level' => 'required|numeric'
      );
      $validator = Validator::make(Input::all(), $rules);

      if ($validator->fails()) {
        return Redirect::to('nerds/' . $id . '/edit')
        ->withErrors($validator)
        ->withInput(Input::except('password'));
      } else {

        if(!empty($request['status'])){
          $enable=1;
        }else{
          $enable=0;
        }
        if(!empty($request['type'])){
          $type=1;
        }else{
          $type=0;
        }
        $status = $enable;
        $access       =Input::get('access');
        $now= new DateTime();

        $update = DB::table('user_access')
        ->where('access_id', $id)
        ->update([
          'access'=>$access,
          'updated_at'    => $now,
          'status'      =>$status,
          'type'   =>$type,
        ]);

        if($update){
          //fungsi untuk sytem log
            // $logcontent ="Update data to access name($access), status($status) for Access ID $id";
            // $logtype ="User Access";
            // $loguser =Auth::user()->id;
            // $logdateTime=new DateTime();
            // $log=  Helper::userlog($logtype,$logcontent,$loguser,$logdateTime);
          //end userlog
          return redirect()->to('backend/user-access')->with('success-create','Thank you for access Update!');
        }else{
          return Redirect()->back()->with('error','Sorry something is error !');
        }
      }
    }else{
      return Redirect::back()->withErrors(['msg', 'No Access']);
    }
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    $auth = $this->CheckAuth();
    if($auth == true){
      $checkuser=DB::table('user_access')->where('access_id','=',Auth::user()->access_id)->first();
      if($checkuser->type==1){
        $checkuser=DB::table('user_access')->where('access_id','=',Auth::user()->access_id)->first();
          $i = DB::table('user_access')->where('access_id','!=',1)->where('access_id',$id)->delete();
          if($i > 0)
          {
            //fungsi untuk sytem log
                      // $logcontent ="Delete data for Access ID $id ";
                      // $logtype ="User Access";
                      // $loguser =Auth::user()->id;
                      // $logdateTime=new DateTime();
                      // $log=  Helper::userlog($logtype,$logcontent,$loguser,$logdateTime);
           //end userlog
             return redirect()->back()->with('success-delete','Your menu file has been deleted!');
          }else{
             return redirect()->back()->with('no-delete','Can not be removed!');
          }
      }else{
           return redirect()->back()->with('no-delete','Sorry, No Access to removed!');
      }
    }else{
      return Redirect::back()->withErrors(['msg', 'No Access']);
    }
  }


  private function CheckAuth()
  {
    $url = request()->segment(1)."/".request()->segment(2);
    $menu=DB::table('menu_admin')->where('menu_admin.status_menu','=',1)->get();
    foreach ($menu as $menus)
    {
      if($menus->url== $url){
        $cek=  Helper::checkmenuchecklist(Auth::user()->access_id, $menus->menu_id);
        if ($cek ==1){
          return true;
        }else{
          return false;
        }

      }
    }
  }

}
