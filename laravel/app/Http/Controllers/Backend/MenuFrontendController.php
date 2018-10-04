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

class MenuFrontendController extends Controller
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
          $websetting   = DB::table('cms_config')->first();
          $menumain     = DB::table('cms_menu')->where('type','Main')->orderBy('order_row','ASC')->get();
          $menufoot     = DB::table('cms_menu')->where('type','Footer')->orderBy('order_row','ASC')->get();
          return view('backend.menu.frontend.index',[
              'menumain'    => $menumain,
              'menufoot'    => $menufoot,
              'websetting'  => $websetting
          ]);
      }else{
          return Redirect::back()->withErrors(['Sorry, No Access']);
      }
  }

  public function updtrow(){
      $array = Input::get('arrayid');
      $table = Input::get('table');
      $explode = explode(',',$array);
      foreach ($explode as $key => $value) {
          if ($table == 'cms_menu') {
              DB::table($table)->where('menu_id',$value)->update([
                 'order_row' => $key + 1
              ]);
          }elseif($table == 'cms_slider_home'){
              DB::table($table)->where('slider_id',$value)->update([
                 'order_row' => $key + 1
              ]);
          }elseif($table == 'cms_blog'){
              DB::table($table)->where('blog_id',$value)->update([
                 'order_row' => $key + 1
              ]);
          }else {
              DB::table($table)->where('id',$value)->update([
                 'order_row' => $key + 1
              ]);
          }

      }

      return 1;
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
      $menu = DB::table('cms_menu')->get();
      $pages = DB::table('cms_pages')->get();

      return view('backend.menu.frontend.create',[
        'menu' => $menu,
        'pages'=> $pages
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

      $rules = array(
        'type'  => 'required',
        'parent'=> 'required',
        'menu'  => 'required|unique:cms_menu',
      );

      $validator = Validator::make(Input::all(), $rules);
      if ($validator->fails()) {
        return redirect()->back()
        ->withErrors($validator)
        ->withInput();
      } else {

        if(!empty($request['enable'])){
          $enable=1;
        }else{
          $enable=0;
        }

        $insert = DB::table('cms_menu')->insert([
            'enable'=> $enable,
            'type'  => Input::get('type'),
            'menu'  => Input::get('menu'),
            'url'   => Input::get('url'),
            'parent'=> Input::get('parent'),
            'created_at'    => new DateTime(),
            'created_by'    => Auth::user()->id
        ]);

        if($insert){
          return redirect()->to('backend/frontend-menu')->with('success-create','Thank you for menu add!');
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
      $row=DB::table('cms_menu')->where('menu_id','=',$id)->first();
      $menu=DB::table('cms_menu')->get();
      $pages = DB::table('cms_pages')->get();
      return view('backend.menu.frontend.edit',[
        'row'=>$row,
        'menu'=>$menu,
        'pages'=>$pages
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
          'type'  => 'required',
          'parent'=> 'required',
        //   'menu'  => 'required|unique:cms_menu,menu,'.$id,
          'menu'  => 'required',
      );
      $validator = Validator::make(Input::all(), $rules);

      if ($validator->fails()) {
        return Redirect::to('backend/frontend-menu/' . $id . '/edit')
        ->withErrors($validator)
        ->withInput(Input::except('password'));
      } else {

        if(!empty($request['enable'])){
          $enable=1;
        }else{
          $enable=0;
        }

        $update = DB::table('cms_menu')->where('menu_id', $id)->update([
            'enable'=> $enable,
            'type'  => Input::get('type'),
            'menu'  => Input::get('menu'),
            'url'   => Input::get('url'),
            'parent'=> Input::get('parent'),
            'updated_at'    => new DateTime(),
            'updated_by'    => Auth::user()->id
        ]);

        if($update){
          return redirect()->to('backend/frontend-menu')->with('success-create','Thank you for menu Update!');
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
        // $datalog=DB::table('cms_menu')->where('menu_id', $id)->first();
        $i = DB::table('cms_menu')->where('menu_id',$id)->delete();
        if($i > 0)
        {
        //   //fungsi untuk sytem log
        //             $logcontent ="Delete data for frontend menu ID $id - $datalog->menu ";
        //             $logtype ="frontend Menu";
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
