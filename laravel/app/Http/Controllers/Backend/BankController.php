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

class BankController extends Controller
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
      $bank=DB::table('ms_bank')->get();

      return view('backend.bank.index',[
        'bank'=>$bank
      ]);

    }else{
      return Redirect::back()->withErrors(['msg', 'Sorry, Sorry, Sorry, No Access']);
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
      $bank=DB::table('ms_bank')->get();
      return view('backend.bank.create',[
        'bank'=>$bank
      ]);
    }else{
      return Redirect::back()->withErrors(['msg', 'Sorry, No Access']);
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
        // 'image'        => 'required',
        // 'status'     => 'required',
      );
      // run the validation rules on the inputs from the form
      $validator = Validator::make(Input::all(), $rules);
      // if the validator fails, redirect back to the form
      if ($validator->fails()) {
        return redirect()->back()
        ->withErrors($validator) // send back all errors to the login form
        ->withInput(); // send back the input (not the password) so that we can repopulate the form
      } else {
        if(!empty($request['status'])){
          $enable=1;
        }else{
          $enable=0;
        }

        $nilai=strlen(url(''));
        $len=$nilai+1;
        $image        =  substr(Input::get('image'),$len);
        $name         =Input::get('bank_name');
        $holder       =Input::get('bank_holder');
        $number       =Input::get('bank_noreg');
        $location     =Input::get('bank_desc');
        $now          = new DateTime();
        $userid= auth::user()->id;
        $insert = DB::table('ms_bank')->insert([
          'bank_name'=>$name,
          'bank_holder'=>$holder,
          'bank_noreg'=>$number,
          'bank_image'  => $image,
          'bank_desc' => $location,
          'bank_enable'=>$enable,
          'created_at'     => $now,
          'created_by'=>$userid
        ]);
        if($insert){

          //fungsi untuk sytem log
            // $logcontent ="Add new bank  $name - $holder - $number for bank management";
            // $logtype ="Bank";
            // $loguser =Auth::user()->id;
            // $logdateTime=new DateTime();
            // $log=  Helper::userlog($logtype,$logcontent,$loguser,$logdateTime);
          //end userlog
          return redirect()->to('backend/bank')->with('success-create','Thank you for bank add!');

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
  public function edit($id)
  {
    $auth = $this->CheckAuth();

    if($auth == true){
      $row=DB::table('ms_bank')->where('id','=',$id)->first();

      return view('backend.bank.edit',[

        'row'=>$row
      ]);
    }else{
      return Redirect::back()->withErrors(['msg', 'Sorry, No Access']);
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
        // 'bank_name'       => 'required',
        // 'email'      => 'required|email',
        // 'nerd_level' => 'required|numeric'
      );
      $validator = Validator::make(Input::all(), $rules);

      if ($validator->fails()) {
        return Redirect::to('nerds/' . $id . '/edit')
        ->withErrors($validator)
        ->withInput(Input::except('password'));
      } else {

        // $check = DB::table('ms_bank')->where('id', $id)->first();
        // $fileName = $check->bank_image;
        if(!empty($request['status'])){
          $enable=1;
        }else{
          $enable=0;
        }
        $name         =Input::get('bank_name');
        $holder       =Input::get('bank_holder');
        $number       =Input::get('bank_noreg');
        $location     =Input::get('bank_desc');
        $nilai=strlen(url(''));
        $len=$nilai+1;
        $now= new DateTime();
        $userid= auth::user()->id;
        $image=substr(Input::get('image'),$len);
        $update = DB::table('ms_bank')
        ->where('id', $id)
        ->update([
          'bank_image' => substr(Input::get('image'),$len),
          'bank_name'=>$name,
          'bank_holder'=>$holder,
          'bank_noreg'=>$number,
          'bank_desc'    => $location,
          'updated_at'     => $now,
          'updated_by'  =>$userid

        ]);

        if($update){

          //fungsi untuk sytem log

            // $logcontent ="Change bank data to $name - $holder -  $number - $location - $logo  for Bank ID $id";
            // $logtype ="Bank";
            // $loguser =Auth::user()->id;
            // $logdateTime=new DateTime();
            // $log=  Helper::userlog($logtype,$logcontent,$loguser,$logdateTime);
            //end userlog
          return redirect()->to('backend/bank')->with('success-create','Thank you for bank Update!');
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

        // $checklog=DB::table('ms_bank')->where('id', $id)->first();
        $i = DB::table('ms_bank')->where('id',$id)->delete();
        if($i > 0)
        {
          //fungsi untuk sytem log
                    // $logcontent ="Delete bank data for bank ID $id - $checklog->bank_name - $checklog->bank_holder ";
                    // $logtype ="Bank";
                    // $loguser =Auth::user()->id;
                    // $logdateTime=new DateTime();
                    // $log=  Helper::userlog($logtype,$logcontent,$loguser,$logdateTime);
         //end userlog
        return redirect()->back()->with('success-delete','Your Brand file has been deleted!');
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
