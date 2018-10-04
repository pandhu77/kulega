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

class ShippingController extends  Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index(){
      $data = DB::table('lk_couriers')->orderBy('order_row','ASC')->get();

      return view('backend.shipping.index',[
        'data' => $data,
      ]);
  }
  public function create()
  {
      return view('backend.shipping.create');
  }

  public function store(Request $request)
  {
    $rules = array(
      'code'    => 'required',
      'name'    => 'required'
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

      $code    = Input::get('code');
      $name    = Input::get('name');
      $now      = new DateTime();
      $userid   = auth::user()->id;

      $store    = DB::table('lk_couriers')->insert([
          'enable'      => $status,
          'code'       => $code,
          'name'       => $name,
          'created_at'  => $now,
          'created_by'  => Auth::user()->id
      ]);

      if($store){
        return redirect()->to('backend/shipping')->with('success-create','Thank you for shipping Add!');
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
      $row = DB::table('lk_couriers')->where('id','=',$id)->first();
      return view('backend.shipping.edit',[
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
      'code'    => 'required',
      'name'    => 'required',
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
      $code     = Input::get('code');
      $name     = Input::get('name');
      $now      = new DateTime();
      $userid   = auth::user()->id;

      $update   = DB::table('lk_couriers')->where('id', $id)->update([
          'enable'      => $status,
          'code'        => $code,
          'name'        => $name,
          'updated_at'  => $now,
          'updated_by'  => Auth::user()->id
      ]);

      if($update){
        return redirect()->to('backend/shipping')->with('success-update','Thank you for '.$name.' Update!');
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
      $i = DB::table('lk_couriers')->where('id',$id)->delete();
      if($i > 0)
      {
         return redirect()->to('backend/shipping')->with('success-delete','Your slider file has been deleted!');
       }else{
          return redirect()->back()->with('no-delete','Can not be removed!');
       }
  }

}
