<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;
use Redirect;
use DateTime;
use App\User;
use Illuminate\Support\Facades\Input;
use Helper;
use Auth;


class UsersController extends Controller
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
  public function getprofile(){

    $userid=Auth::user()->id;
    $users=DB::table('users')->where('id','=',$userid)->first();
    return view('backend.users.profile',[
      'row' => $users,
    ]);

  }
  public function updateprofile(){

    $rules = array(
      'username'    => 'required',
      'name'    => 'required',
      'email'    => 'required|email', // make sure the email is an actual email
    );
    // run the validation rules on the inputs from the form
    $validator = Validator::make(Input::all(), $rules);
    // if the validator fails, redirect back to the form
    if ($validator->fails()) {
      return redirect()->back()
      ->withErrors($validator) // send back all errors to the login form
      ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
    } else {
      $now   = new DateTime();
      $userid=Auth::user()->id;
      $row = DB::table('users')->where('id', $userid)->first();
      $checkemail=DB::table('users')->where('email','=',Input::get('email'))->where('id','!=',$userid)->count();
      $checkusername=DB::table('users')->where('username','=',Input::get('username'))->where('id','!=',$userid)->count();
      if($checkemail > 0){
        return Redirect()->back()->with('errors-data','Sorry this User Name already registered !');
      }elseif($checkusername > 0){
        return Redirect()->back()->with('errors-data','Sorry this email already registered !');
      }
          $update = DB::table('users')
          ->where('id', $userid)
          ->update([
            'username'=> Input::get('username'),
            'user_fullname'=>Input::get('name'),
            'email' =>Input::get('email'),
            'user_phone' =>Input::get('phone'),
            'updated_at'=>$now
          ]);

        if($update){
          //fungsi untuk sytem log
            // $logcontent ="Update data  for User $userid - $row->name";
            // $logtype ="Profile User";
            // $loguser =Auth::user()->id;
            // $logdateTime=new DateTime();
            // $log=  Helper::userlog($logtype,$logcontent,$loguser,$logdateTime);
          //end userlog
          return Redirect()->back()->with('success','Thank you for Profile Update!');

        }else{
          return Redirect()->back()->with('error','Sorry something is error !');
        }
    }
  }
  public function changepassword(){
    // $auth = $this->CheckAuth();
    //
    // if($auth == true){
      $access=DB::table('user_access')->get();
      $userid=Auth::user()->id;
      $users=DB::table('users')->where('id','=',$userid)->first();
      return view('backend.users.change-password',[
        'users' => $users,
        'access'=>$access,
      ]);
    // }else{
    //   return Redirect::back()->withErrors(['msg', 'No Access']);
    // }

  }

  public function storechangepassword(){

    // $auth = $this->CheckAuth();
    //
    // if($auth == true){

        $rules = array(
          'password' => 'required|min:6', // password can only be alphanumeric and has to be greater than 3 characters
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
          return redirect()->back()
          ->withErrors($validator) // send back all errors to the login form
          ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {

          $password = Input::get('password');
          $passwordConf = Input::get('password_confirmation');
          $userid=Auth::user()->id;
          $row = DB::table('users')->where('id', $userid)->first();
          if (Hash::check(Input::get('current_password'), $row->password)) {

            if($password == $passwordConf){

              if($password !==''){
                $update = DB::table('users')
                ->where('id', $userid)
                ->update([
                  'password'=> bcrypt($password),
                ]);
              }

              if($update){
                //fungsi untuk sytem log
                  // $logcontent ="Change password  for User $row->username - $row->name";
                  // $logtype ="User";
                  // $loguser =Auth::user()->id;
                  // $logdateTime=new DateTime();
                  // $log=  Helper::userlog($logtype,$logcontent,$loguser,$logdateTime);
                //end userlog
              return Redirect()->back()->with('success','Thank you for Password Update!');

              }else{
                return Redirect()->back()->with('error','Sorry something is error !');
              }
            }else{
              return redirect()->back()->with('errors-data','Passwords did not match!');
            }
          }else{
              return redirect()->back()->with('errors-data','Wrong password!');
          }

        }
    // }else{
    //   return Redirect::back()->withErrors(['msg', 'No Access']);
    // }

  }
  public function index()
  {
    $auth = $this->CheckAuth();

      if($auth == true){
        //Data List
        $users=DB::table('users')->get();
        return view('backend.users.index',[
          'users' => $users
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

        $access=DB::table('user_access')->get();
        $users=DB::table('users')->get();
        return view('backend.users.create',[
          'users' => $users,
          'access'=>$access,
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
          $rules = array(
            'username'    => 'required',
            'name'    => 'required',
            'access'    => 'required',
            'email'    => 'required|email', // make sure the email is an actual email
            'password' => 'required|min:6', // password can only be alphanumeric and has to be greater than 3 characters
          );
          // run the validation rules on the inputs from the form
          $validator = Validator::make(Input::all(), $rules);
          // if the validator fails, redirect back to the form
          if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator) // send back all errors to the login form
            ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
          } else {
              $now   = new DateTime();
              $tambah= new User();
              $password = Input::get('password');
              $token=Input::get('_token');
              $passwordConf = Input::get('password_confirmation');
              if($password ==$passwordConf){
                $tambah->username=$request['username'];
                $tambah->user_fullname=$request['name'];
                $tambah->email=$request['email'];
                $tambah->user_phone=$request['phone'];
                $tambah->password=bcrypt($request['password']);
                $tambah->remember_token=$token;
                $tambah->access_id=$request['access'];
                $tambah->created_at=$now;
                $checkemail = DB::table('users')
                  ->where('email', $request['email'])
                  ->first();
                $checkusername = DB::table('users')
                  ->where('username', $request['username'])
                  ->first();
                if(count($checkemail) > 0){
                  return redirect()->back()->with('errors-data','Sorry, the email is already registered!');
                }elseif(count($checkusername) > 0){
                  return redirect()->back()->with('errors-data','Sorry, the username is already registered!');
                }else{
                    $tambah->save();
                }
                //fungsi untuk sytem log
                  // $logcontent ="Add new data  for User Management";
                  // $logtype ="User";
                  // $loguser =Auth::user()->id;
                  // $logdateTime=new DateTime();
                  // $log=  Helper::userlog($logtype,$logcontent,$loguser,$logdateTime);
                //end userlog

                return redirect()->to('backend/users')->with('success-create','Thank you for user add!');
              }else{
                return redirect()->back()->with('errors-data','Passwords did not match!');
              }
        }
    }else{
      return Redirect::back()->withErrors(['msg', 'No Access']);
    }

  }

  public function edit($id)
  {
    $auth = $this->CheckAuth();

    if($auth == true){
        $row= DB::table('users')->where('id','=',$id)->first();
        $access=DB::table('user_access')->get();
        return  view('backend.users.edit',[
          'row'=>$row,
          'access'=>$access

        ]);
    }else{
      return Redirect::back()->withErrors(['msg', 'No Access']);
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
  public function update($id)
  {
    $auth = $this->CheckAuth();

    if($auth == true){

        $rules = array(
          'username'    => 'required',
          'name'    => 'required',
          'access'    => 'required',
          'email'    => 'required|email', // make sure the email is an actual email
          'password' => 'min:6', // password can only be alphanumeric and has to be greater than 3 characters


        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
          return redirect()->back()
          ->withErrors($validator) // send back all errors to the login form
          ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {
          $password = Input::get('password');
          $passwordConf = Input::get('password_confirmation');
          // $cek =Input::get('access');
          $now   = new DateTime();


          if($password == $passwordConf){
            $checkemail=DB::table('users')->where('email','=',Input::get('email'))->where('id','!=',$id)->count();
            $checkusername=DB::table('users')->where('username','=',Input::get('username'))->where('id','!=',$id)->count();
            if($checkemail > 0){
              return Redirect()->back()->with('errors-data','Sorry this User Name already registered !');
            }elseif($checkusername > 0){
              return Redirect()->back()->with('errors-data','Sorry this email already registered !');
            }

            if($password ==''){
              $update = DB::table('users')
              ->where('id', $id)
              ->update([
                'username'=> Input::get('username'),
                'user_fullname'=>Input::get('name'),
                'email' =>Input::get('email'),
                'user_phone' =>Input::get('phone'),
                'access_id'=>Input::get('access'),
                'updated_at'=>$now,
              ]);
                if($update){
                  //fungsi untuk sytem log
                    // $logcontent ="Update data  for User ID $id";
                    // $logtype ="User";
                    // $loguser =Auth::user()->id;
                    // $logdateTime=new DateTime();
                    // $log=  Helper::userlog($logtype,$logcontent,$loguser,$logdateTime);
                  //end userlog
                }
            }
            if($password !==''){
              $update = DB::table('users')
              ->where('id', $id)
              ->update([
                'username'=> Input::get('username'),
                'user_fullname'=>Input::get('name'),
                'email' =>Input::get('email'),
                'access_id'=>Input::get('access'),
                'user_phone' =>Input::get('phone'),
                'password'=> bcrypt($password),
                'updated_at'=>$now,
              ]);

                if($update){
              //fungsi untuk sytem log
                // $logcontent ="Change password  for User ID $id";
                // $logtype ="User";
                // $loguser =Auth::user()->id;
                // $logdateTime=new DateTime();
                // $log=  Helper::userlog($logtype,$logcontent,$loguser,$logdateTime);
              //end userlog
                }
            }

            if($update){
              return redirect()->to('backend/users')->with('success-create','Thank you for user Update!');

            }else{
              return Redirect()->back()->with('error','Sorry something is error !');
            }


          }else{
            return redirect()->back()->with('errors-data','Passwords did not match!');
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
        $i = DB::table('users')->where('id',$id)->delete();
        if($i)
        {
          //fungsi untuk sytem log
                    // $logcontent ="Delete data for User ID $id ";
                    // $logtype ="User ";
                    // $loguser =Auth::user()->id;
                    // $logdateTime=new DateTime();
                    // $log=  Helper::userlog($logtype,$logcontent,$loguser,$logdateTime);
         //end userlog
          return redirect()->back()->with('success-delete','Thank you for user delete!');
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
