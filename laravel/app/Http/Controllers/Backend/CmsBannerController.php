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

class CmsBannerController extends  Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index(){
      $banner=DB::table('cms_banner')->orderBy('order_row','ASC')->get();

      return view('backend.banner.index',[
        'banner'=>$banner,
      ]);
  }
  public function create()
  {
      return view('backend.banner.create');
  }

  public function store(Request $request)
  {
    $rules = array(
      'image'       => 'required',
    );
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      return Redirect::to('nerds/' . $id . '/edit')
      ->withErrors($validator)
      ->withInput(Input::except('password'));
    } else {

      if(!empty($request['enable'])){
        $enable=1;
      }else{
        $enable=0;
      }
      $status   = $enable;
      $nilai    = strlen(url(''));
      $len      = $nilai+1;
      $image    = substr(Input::get('image'),$len);
      $title    = Input::get('title');
      $now      = new DateTime();
      $userid   = auth::user()->id;

      $store    = DB::table('cms_banner')->insert([
          'enable'      => $status,
          'title'       => $title,
          'image'       => $image,
          'created_at'  => $now,
      ]);

      if($store){
        return redirect()->to('backend/banner')->with('success-create','Thank you for banner Add!');
      }else{
        return Redirect()->back()->with('error','Sorry something is error !');
      }
    }
  }


  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id){
      $row = DB::table('cms_banner')->where('id','=',$id)->first();
      return view('backend.banner.edit',[
        'row' => $row,
      ]);
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
    $rules = array(
      'image'    =>'required',
    );
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      return Redirect::to('nerds/' . $id . '/edit')
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

      $update   = DB::table('cms_banner')->where('id', $id)->update([
          'enable'      => $status,
          'title'       => $title,
          'image'       => $image,
          'updated_at'  => $now,
      ]);

      if($update){
        return redirect()->to('backend/banner')->with('success-update','Thank you for '.$title.' Update!');
      }else{
        return Redirect()->back()->with('error','Sorry something is error !');
      }
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
      $i = DB::table('cms_banner')->where('id',$id)->delete();
      if($i > 0)
      {
         return redirect()->to('backend/banner')->with('success-delete','Your slider file has been deleted!');
       }else{
          return redirect()->back()->with('no-delete','Can not be removed!');
       }
  }

}
