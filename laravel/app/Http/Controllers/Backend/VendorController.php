<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Validator;
use Redirect;
use DateTime;
use App\User;
use Illuminate\Support\Facades\Input;
use Helper;
use Auth;
use Hash;

class VendorController extends Controller
{

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
      //Data List
      $vendors=DB::table('ms_vendors')->get();
      return view('backend.vendor.index',[
        'vendors' => $vendors
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
      $vendors=DB::table('ms_vendors')->get();
      return view('backend.vendor.create',[
        'vendors' => $vendors,
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
        'vendor_email'    => 'required|email', // make sure the email is an actual email
        'vendor_password' => 'required|min:6', // password can only be alphanumeric and has to be greater than 3 characters
      );
      // run the validation rules on the inputs from the form
      $validator = Validator::make(Input::all(), $rules);
      // if the validator fails, redirect back to the form
      if ($validator->fails()) {
        return redirect()->back()
        ->withErrors($validator) // send back all errors to the login form
        ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
      } else {

          if(!empty($request['status'])){
            $enable=1;
          }else{
            $enable=0;
          }
          $password = Input::get('vendor_password');
          $token=Input::get('_token');
          $passwordConf = Input::get('password_confirmation');
          if($password ==$passwordConf){
            $fullname=$request['vendor_fullname'];
            $email=$request['vendor_email'];
            $phone=$request['vendor_phone'];
            $address=$request['vendor_address'];
            $remember_token=$token;
            $now   = new DateTime();
            $userid= auth::user()->id;
            $vendor_password = hash::make(Input::get('vendor_password'));
            $check = DB::table('ms_vendors')
              ->where('vendor_email', $email)
              ->first();
            if(count($check) > 0){
                  return redirect()->back()->with('errors-data','Sorry, the email is already registered!');
            }else{
              $insert=DB::table('ms_vendors')->insert([
              'vendor_fullname'=>$fullname,
              'vendor_email'=>$email,
              'vendor_phone'=>$phone,
              'vendor_address'=>$address,
              'vendor_password'=>$vendor_password,
              'vendor_token'=>$remember_token,
              'vendor_status'=>$enable,
              'vendor_created_at'=>$now,
              'vendor_created_by'=>$userid,
              ]);
            }

            if($insert){
                return redirect()->to('backend/vendor')->with('success-create','Thank you for vendor add!');
            }else{
                return redirect()->back()->with('errors-data','Sorry, you data not add!');
            }

          }else{
            return redirect()->back()->with('errors-data','Check input is correct!');
          }
        }
    }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
    }

  }

  public function edit($id)
  {
    $auth = $this->CheckAuth();

    if($auth == true){
        $row= DB::table('ms_vendors')->where('vendor_id','=',$id)->first();
        return  view('backend.vendor.edit',[
        'row'=>$row,
        ]);
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
          'vendor_email'    => 'required|email', // make sure the email is an actual email
          'password' => 'min:6', // password can only be alphanumeric and has to be greater than 3 characters
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
          return redirect()->back()
          ->withErrors($validator) // send back all errors to the login form
          ->withInput(Input::except('vendor_password')); // send back the input (not the password) so that we can repopulate the form
        } else {
          $password = Input::get('vendor_password');
          $passwordConf = Input::get('password_confirmation');
          if(!empty($request['status'])){
            $enable=1;
          }else{
            $enable=0;
          }

          $now   = new DateTime();
          $userid= auth::user()->id;

          if($password == $passwordConf){
            $check=DB::table('ms_vendors')->where('vendor_email','=',Input::get('vendor_email'))->where('vendor_id','!=',$id)->count();
            if($check > 0){
              return Redirect()->back()->with('errors-data','Sorry this User Name already registered !');
            }else{
                if($password ==''){
                  $update = DB::table('ms_vendors')
                  ->where('vendor_id', $id)
                  ->update([
                    'vendor_fullname'=>Input::get('vendor_fullname'),
                    'vendor_email' =>Input::get('vendor_email'),
                    'vendor_phone' =>Input::get('vendor_phone'),
                    'vendor_address'=>Input::get('vendor_address'),
                    'vendor_status'=>$enable,
                    'vendor_updated_at'=>$now,
                    'vendor_updated_by'=>$userid,
                  ]);
                }
                if($password !==''){
                  $update = DB::table('ms_vendors')
                  ->where('vendor_id', $id)
                  ->update([
                    'vendor_fullname'=>Input::get('vendor_fullname'),
                    'vendor_email' =>Input::get('vendor_email'),
                    'vendor_phone' =>Input::get('vendor_phone'),
                    'vendor_password'=>hash::make(Input::get('vendor_password')),
                    'vendor_address'=>Input::get('vendor_address'),
                    'vendor_status'=>$enable,
                    'vendor_updated_at'=>$now,
                    'vendor_updated_by'=>$userid,
                  ]);
                }
            }


            if($update){
              return redirect()->to('backend/vendor')->with('success-create','Thank you for user Update!');

            }else{
              return Redirect()->back()->with('error','Sorry something is error !');
            }
          }else{
            return redirect()->back()->with('errors-data','Check input is correct!');
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
        $i = DB::table('ms_vendors')->where('vendor_id',$id)->delete();
        if($i)
        {
          //fungsi untuk sytem log
                    // $logcontent ="Delete data for User ID $id ";
                    // $logtype ="User ";
                    // $loguser =Auth::user()->id;
                    // $logdateTime=new DateTime();
                    // $log=  Helper::userlog($logtype,$logcontent,$loguser,$logdateTime);
         //end userlog
              return redirect()->back()->with('success-delete','Thank you for vendor delete!');
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
