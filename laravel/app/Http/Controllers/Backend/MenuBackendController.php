<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;
use Auth;
use Validator;
use Redirect;
use DateTime;
use Helper;

class MenuBackendController extends Controller
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
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $auth = $this->CheckAuth();

    if($auth == true){

      $menu=DB::table('menu_admin')->get();
      return view('backend.menu.backend.index',[
        'menu'=>$menu
      ]);
    }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
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
      $menu=DB::table('menu_admin')->where('group','=',0)->where('parent','=',1)->get();

      return view('backend.menu.backend.create',[
        'menu'=>$menu
      ]);
    }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
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
        'group'       => 'required',
      );
      // run the validation rules on the inputs from the form
      $validator = Validator::make(Input::all(), $rules);
      // if the validator fails, redirect back to the form
      if ($validator->fails()) {
        return redirect()->back()
        ->withErrors($validator) // send back all errors to the login form
        ->withInput(); // send back the input (not the password) so that we can repopulate the form
      } else {


        $now          = new DateTime();
        if(!empty($request['status_menu'])){
          $enable=1;
        }else{
          $enable=0;
        }
        if(!empty($request['status_parent'])){
          $parent=1;
        }else{
          $parent=0;
        }
        $status_menu = $enable;
        $name      =Input::get('name');
        $checkurl       =Input::get('url');

        if($checkurl =='#'|| $checkurl==''){
          $url='backend/#';
        }else{
          $url="backend/".$checkurl;
        }

        $group    =Input::get('group');
        $icon     =Input::get('icon');
        $userid= auth::user()->id;

        $insert = DB::table('menu_admin')->insert([
          'menu'=>$name,
          'url'=>$url,
          'icon'    => $icon,
          'group' =>$group,
          'parent'    => $parent,
          'status_menu'      =>$status_menu,
          'created_at'     => $now,
          'created_by'=>$userid

        ]);
        if($insert){
        //   //fungsi untuk sytem log
        //     $logcontent ="Add new data  menu($name),url($url),parent($parent),group($group), status_menu($status_menu) for Backend Menu management";
        //     $logtype ="Backend Menu ";
        //     $loguser =Auth::user()->id;
        //     $logdateTime=new DateTime();
        //     $log=  Helper::userlog($logtype,$logcontent,$loguser,$logdateTime);
          //end userlog
          return redirect()->to('backend/backend-menu')->with('success-create','Thank you for menu add!');

        }else{
          return Redirect()->back()->with('error','Sorry something is error !');
        }
      }
    }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
    }
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
      $row=DB::table('menu_admin')->where('menu_id','=',$id)->first();
      $menu=DB::table('menu_admin')->where('group','=',0)->where('parent','=',1)->get();
      return view('backend.menu.backend.edit',[
        'row'=>$row,
        'menu'=>$menu,
      ]);
    }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
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
        'group'       => 'required',

      );
      $validator = Validator::make(Input::all(), $rules);

      if ($validator->fails()) {
        return Redirect::to('nerds/' . $id . '/edit')
        ->withErrors($validator)
        ->withInput(Input::except('password'));
      } else {

        if(!empty($request['status_menu'])){
          $enable=1;
        }else{
          $enable=0;
        }

        if(!empty($request['status_parent'])){
          $parent=1;
        }else{
          $parent=0;
        }
        $status_menu = $enable;
        $name         =Input::get('name');
        $checkurl       =Input::get('url');
        $group    =Input::get('group');
        $icon     =Input::get('icon');
        $now= new DateTime();
        $userid= auth::user()->id;

        if($checkurl =='#'|| $checkurl==''){
          $url='backend/#';
        }else{
          $url="backend/".$checkurl;
        }

        $update = DB::table('menu_admin')
        ->where('menu_id', $id)
        ->update([
          'parent' => $parent,
          'group' => $group,
          'menu'=>$name,
          'url'=>$url,
          'icon' => $icon,
          'updated_at'    => $now,
          'status_menu'      =>$status_menu,
          'updated_by'=>$userid

        ]);

        if($update){

          //fungsi untuk sytem log
            // $logcontent ="Update backend menu to menu($name),url($url),parent($parent),group($group), status_menu($status_menu) for Backend Menu ID $id";
            // $logtype ="Backend Menu ";
            // $loguser =Auth::user()->id;
            // $logdateTime=new DateTime();
            // $log=  Helper::userlog($logtype,$logcontent,$loguser,$logdateTime);
          //end userlog
          return redirect()->to('backend/backend-menu')->with('success-create','Thank you for menu Update!');
        }else{
          return Redirect()->back()->with('error','Sorry something is error !');
        }
      }
    }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
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
        // $datalog=DB::table('menu_admin')->where('menu_id', $id)->first();
        $i = DB::table('menu_admin')->where('menu_id',$id)->delete();
        if($i > 0)
        {
        //   //fungsi untuk sytem log
        //             $logcontent ="Delete data for backend menu ID $id - $datalog->menu ";
        //             $logtype ="Backend Menu";
        //             $loguser =Auth::user()->id;
        //             $logdateTime=new DateTime();
        //             $log=  Helper::userlog($logtype,$logcontent,$loguser,$logdateTime);
        //  //end userlog
             return redirect()->back()->with('success-delete','Your menu file has been deleted!');
        }else{
             return redirect()->back()->with('no-delete','Can not be removed!');
        }
      }else{
         return redirect()->back()->with('no-delete','Sorry, No Access to removed!');
      }
    }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
    }
  }

  private function CheckAuth()
  {
    $url = request()->segment(1)."/".request()->segment(2);
    $menu=DB::table('menu_admin')->get();
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
