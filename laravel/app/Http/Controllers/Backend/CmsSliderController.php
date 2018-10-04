<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Form;
use Auth;
use Session;
use Validator;
use Redirect;
use DB;
use Hash;
use Response;
use DateTime;
use Helper;

class CmsSliderController extends  Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index(){
    $auth = $this->CheckAuth();

    if($auth == true){
      $slider=DB::table('cms_slider_home')->orderBy('order_row','ASC')->get();

      return view('backend.slider.index',[
        'slider'=>$slider,
      ]);
    }else{
      return Redirect::back()->withErrors(['msg', 'No Access']);
    }
  }
  public function create()
  {
    $auth = $this->CheckAuth();

    if($auth == true){
      $slider = DB::table('cms_slider_home')->get();
      return view('backend.slider.create',[
        'slider'=>$slider,
      ]);
    }else{
      return Redirect::back()->withErrors(['msg', 'No Access']);
    }
  }

  public function store(Request $request)
  {
    $auth = $this->CheckAuth();

    if($auth == true){

        $rules = array(

        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
          return redirect()->back()
          ->withErrors($validator)
          ->withInput(Input::except('password'));
        } else {

          if(!empty($request['enable'])){
            $enable = 1;
          }else{
            $enable = 0;
          }

          $status   = $enable;
          $nilai    = strlen(url(''));
          $len      = $nilai+1;
          $image    = substr(Input::get('image'),$len);
          $title    = Input::get('title');
          $url      = Input::get('url');
          $now      = new DateTime();
          $userid   = auth::user()->id;
          $store    = DB::table('cms_slider_home')->insert([
              'type'    => Input::get('type'),
              'enable'  => $status,
              'title'   => $title,
              'url'     => $url,
              'image'   => $image,
              'created_at' => $now
          ]);

          if($store){
            return redirect()->to('backend/slider')->with('success-create','Thank you for slider Add!');
          }else{
            return Redirect()->back()->with('error','Sorry something is error !');
          }
        }
    }else{
      return Redirect::back()->withErrors(['msg', 'Sorry, No Access']);
    }
  }


  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id){
    $auth = $this->CheckAuth();

    if($auth == true){
      $row = DB::table('cms_slider_home')->where('slider_id','=',$id)->first();
      return view('backend.slider.edit',[
        'row' => $row,
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
          // 'id'       => 'required',
        //   'image'    =>'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
          return redirect()->back()
          ->withErrors($validator)
          ->withInput(Input::except('password'));
        } else {

          if(!empty($request['enable'])){
            $enable = 1;
          }else{
            $enable = 0;
          }

          $status   = $enable;
          $nilai    = strlen(url(''));
          $len      = $nilai+1;
          $image    = substr(Input::get('image'),$len);
          $title    = Input::get('title');
          $url      = Input::get('url');
          $now      = new DateTime();
          $userid   = auth::user()->id;
          $update   = DB::table('cms_slider_home')->where('slider_id', $id)->update([
              'type'        => Input::get('type'),
              'enable'      => $status,
              'title'       => $title,
              'url'         => $url,
              'image'       => $image,
              'updated_at'  => $now,
          ]);

          if($update){
            return redirect()->to('backend/slider')->with('success-update','Thank you for '.$title.' Update!');
          }else{
            return Redirect()->back()->with('error','Sorry something is error !');
          }
        }
      }else{
        return Redirect::back()->withErrors(['msg', 'Sorry, No Access']);
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
          $i = DB::table('cms_slider_home')->where('slider_id',$id)->delete();
          if($i > 0)
          {
             return redirect()->to('backend/slider')->with('success-delete','Your slider file has been deleted!');
           }else{
              return redirect()->back()->with('no-delete','Can not be removed!');
           }
        }else{
            return redirect()->back()->with('no-delete','Sorry, No Access to removed!');
        }
      }else{
        return Redirect::back()->withErrors(['msg', 'Sorry, No Access']);
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
