<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use Validator;
use Redirect;
use DB;
use DateTime;
use Session;
use Auth;
use PHPMailer;
use File;
use HelperEmail;
class VendorController extends Controller
{
  public function login(){
    if(Session::get('vendorid')==null){
      return view('frontend.vendor.login');
    }else{
    return Redirect('vendor/profile');
    }
  }
  public function changepassword(){
    if(Session::get('vendorid')){
      return view('frontend.vendor.change-password');
    }else{
    Session::flash('error_must_login','You must sign');
    return Redirect('vendor/login');
    }
  }
  public function dochangepassword(){
    if(Session::get('vendorid')){

        $vendorid=Session::get('vendorid');
        # code...
        // validate the info, create rules for the inputs
        $rules = array(
          'currentpassword' => 'required|min:6',
          'password' => 'required|min:6',
          'confirpassword' => 'required|min:6' // password can only be alphanumeric and has to be greater than 3 characters
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
          return redirect()->back()
          ->withErrors($validator) // send back all errors to the login form
          ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {
          $current=Input::get('currentpassword');
          $password=Input::get('password');
          $confpass=Input::get('confirpassword');

          $user = DB::table('ms_vendors')
            // ->select('member_email', 'member_password')
            ->where('vendor_id', $vendorid)
            ->where('vendor_status', 1)
            ->first();

            if ($user && Hash::check(Input::get('currentpassword'), $user->vendor_password)) {
              if($password ==$confpass){
                $update = DB::table('ms_vendors')
                  ->where('vendor_id', $vendorid)
                  ->update([
                      'vendor_password'=> hash::make(Input::get('password')),
                  ]);
                  if($update){
                     return Redirect()->back()->with('success-edit','change password successfully, please log in');
                  }else{
                     return Redirect()->back()->with('error_get','Sorry something is error. Try again.!');
                  }

              }else{
                return redirect()->back()->with('errors-data','Passwords did not match!');
              }

            }else{
             return Redirect()->back()->with('error_get','Wrong password. Try again.!');
            }
        }
    }else{
        Session::flash('error_must_login','You must sign');
        return Redirect('vendor/login');
    }
  }

  public function profile(){
    if(Session::get('vendorid')){

        $vendorid=Session::get('vendorid');
        $row=DB::table('ms_vendors')->where('vendor_id','=',$vendorid)->first();


        return view('frontend.vendor.profile',[
          'row'    =>$row,
        ]);
      }else{
        Session::flash('error_must_login','You must Login');
        return Redirect('vendor/login');
      }
  }


  public function doupdateprofile(Request $request)
  {
      if(Session::get('vendorid')){
        $vendorid=Session::get('vendorid');
        # code...
        // validate the info, create rules for the inputs
        $rules = array(
          'fullname'    => 'required',
          // 'username'    => 'required',
          'phonenumber'    => 'required',
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
          // $username     = Input::get('username');
          $name         = Input::get('fullname');
          $phone        = Input::get('phonenumber');
          $email        = Input::get('email');
          $address      = Input::get('address');
          $now          = new DateTime();

          $check=DB::table('ms_vendors')->where('vendor_email','=',$email)->where('vendor_id','!=',$vendorid)->count();
          if($check > 0){
            return Redirect()->back()->with('error_get','Sorry this User Name already registered !');
          }else{


            $update = DB::table('ms_vendors')
            ->where('vendor_id', $vendorid)
            ->update([
              // 'vendor_username'    => $username,
              'vendor_fullname'    => $name,
              'vendor_email'       => $email,
              'vendor_phone'    => $phone,
              'vendor_address'        =>$address,
              'vendor_updated_at'     => $now,


            ]);
            if($update){
              return Redirect('vendor/profile')->with('success','Successfully Edit Profile!');
            }else{
              return Redirect()->back()->with('error','Sorry something is error !');
            }
          }
        }

      }else{
        Session::flash('error_must_login','You must sign');
        return Redirect('vendor/login');
      }
  }

  public function dologout()
    {
      Session::forget('vendorid');
      Session::forget('vendorname');
      Session::forget('vendormail');
      Session::forget('vendorphone');
      Session::forget('vendoraddress');
      Session::flash('message', "welcome");
      return Redirect('/');
    }


  public function dologin(){
    # code...
    // validate the info, create rules for the inputs
    $rules = array(
      'email'    => 'required|email', // make sure the email is an actual email
      'password' => 'required|min:6' // password can only be alphanumeric and has to be greater than 3 characters
    );
    // run the validation rules on the inputs from the form
    $validator = Validator::make(Input::all(), $rules);
    // if the validator fails, redirect back to the form
    if ($validator->fails()) {
      return redirect()->back()
      ->withErrors($validator) // send back all errors to the login form
      ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
    } else {
      $email=Input::get('email');
      $password=Input::get('password');
      $user = DB::table('ms_vendors')
        // ->select('vendor_email', 'vendor_password')
        ->where('vendor_email', $email)
        ->where('vendor_status', 1)
        ->first();

        if ($user && Hash::check(Input::get('password'), $user->vendor_password)) {
              // here you know data is valid
            Session::set('vendorid',$user->vendor_id);
            Session::set('vendorname',$user->vendor_fullname);
            Session::set('vendormail',$user->vendor_email);
            Session::set('vendorphone',$user->vendor_phone);
            Session::set('vendoraddress',$user->vendor_address);
            Session::forget("bonusreward1");
            Session::forget("tmppoint1");
            Session::forget("discvoc");
            Session::flash('success','You have successfully logged in');
            return redirect('/');

        }else{
         return Redirect()->to('vendor/login')->with('error_get','Wrong username or password. Try again.!');
        }
    }
  }

  public function forgotPassword(){
    $email=input::get('emailforgot');
    $code = str_random(30).$email;
    $check=DB::table('ms_vendors')->where('vendor_email','=',$email)->first();
    $datenow= date('Y-m-d H:i:s');
    $dateplus=strtotime($datenow."+1 hours");
    $dateexp=date("Y-m-d H:i:s",$dateplus);
    if(count($check) >0){
        $insert= DB::table('tmp_vendor_forgotpassword')->insert([
          'email'=>$email,
          'tokenforgot'=>$code,
          'status'=>0,
          'exp'=>$dateexp
         ]);
         if($insert){
             $returnhtml= HelperEmail::VendoremailForgotPassword($email,$code);
             //PHPMailer Object
             $mail = new PHPMailer;
             // whereas if using SMTP you would have
             $mail->isSMTP();
             //Set SMTP host name
             $mail->Host = "srv2.niagahoster.com";
             //Set this to true if SMTP host requires authentication to send email
             $mail->SMTPAuth = true;
             //Provide username and password
             $mail->Username = "sentra@chronosh.com";
             $mail->Password = "123456";
             //If SMTP requires TLS encryption then set it
             $mail->SMTPSecure = "ssl";
             //Set TCP port to connect to
             $mail->Port = 465;

             $mail->From = "sentra@chronosh.com";
             $mail->FromName = "E-Commerce Djaring.id";

             $mail->addAddress($email);

             $mail->isHTML(true);

             $mail->Subject = "Vendor Forgot Password";
             $mail->Body = $returnhtml;
             $mail->AltBody = "ini link anda plan";
             if(!$mail->send())
             {
                 return Redirect()->to('vendor/login#forgot')->with('error_get','Mailer Error:'.$mail->ErrorInfo.'');
               // echo "Mailer Error: " . $mail->ErrorInfo;
             }
             {
              return Redirect()->to('vendor/login#forgot')->with('signupsuccess','Thank you ! Request forgot password success, Please check you email continue confirm reset password.');
             }


         }else{
             return Redirect()->to('vendor/login#forgot')->with('error_get','Sorry, the request did not succeed, try again !');
         }
    }else{
        return Redirect()->to('vendor/login#forgot')->with('error_get','Sorry, email is not registered as a vendor E-Commerce Djaring.id !');
    }
  }

  public function resetPassword($code){
        $check =DB::table('tmp_vendor_forgotpassword')->where('tokenforgot','=',$code)->where('status','=',0)->first();
        return view('frontend.vendor.reset-password',[
          'check'=>$check
        ]);
  }

  public function newPassword($code)
  {
    $rules = array(
      'vendor_password' => 'required|min:6', // password can only be alphanumeric and has to be greater than 3 characters

    );
    // run the validation rules on the inputs from the form
    $validator = Validator::make(Input::all(), $rules);
    // if the validator fails, redirect back to the form
    if ($validator->fails()) {
      return redirect()->back()
      ->withErrors($validator) // send back all errors to the login form
      ->withInput(Input::except('vendor_password')); // sen d back the input (not the password) so that we can repopulate the form
    } else {

      $passwordbaru    = Input::get('vendor_password');
      $retypepassword  = Input::get('retypepassword');
      $token= request()->segment(3);
      $checktoken =DB::table('tmp_vendor_forgotpassword')->where('tokenforgot','=',$token)->where('status','=',0)->first();
      if(count($checktoken) > 0 ){
        $checkemail =DB::table('ms_vendors')->where('vendor_email','=',$checktoken->email)->first();
       if(count($checkemail) > 0 ){
      // $checkid =DB::table('vendors')->where('email','=',$email)->first();
        if($retypepassword !==$passwordbaru){
          return Redirect()->back()->with('geterror','These passwords don t match. Try again?!');
        }else{

          $update = DB::table('ms_vendors')
          ->where('vendor_email', $checkemail->vendor_email)
          ->update([
              'vendor_password'       =>hash::make($passwordbaru),
          ]);
          if($update){
              $update = DB::table('tmp_vendor_forgotpassword')
              ->where('tokenforgot',$token)
              ->update([
                  'status'       =>1,
              ]);
              $returnhtml= HelperEmail::VendorpassActivation($checkemail->vendor_email);
              //PHPMailer Object
              $mail = new PHPMailer;
              // whereas if using SMTP you would have
              $mail->isSMTP();
              //Set SMTP host name
              $mail->Host = "	srv2.niagahoster.com";
              //Set this to true if SMTP host requires authentication to send email
              $mail->SMTPAuth = true;
              //Provide username and password
              $mail->Username = "sentra@chronosh.com";
              $mail->Password = "123456";
              //If SMTP requires TLS encryption then set it
              $mail->SMTPSecure = "ssl";
              //Set TCP port to connect to
              $mail->Port = 465;

              $mail->From = "sentra@chronosh.com";
              $mail->FromName = "E-Commerce Djaring.id";

              $mail->addAddress($checkemail->vendor_email);

              $mail->isHTML(true);

              $mail->Subject = "Vendor Request Password";
              $mail->Body = $returnhtml;
              $mail->AltBody = "ini link anda plan";
              if(!$mail->send())
              {
               return Redirect()->to('vendor/login')->with('error_get','Mailer Error:'.$mail->ErrorInfo.'');
                // echo "Mailer Error: " . $mail->ErrorInfo;
              }
              {
                return Redirect()->to('vendor/login')->with('signupsuccess','Successfully change Password, please your login !');
              }


          }else{
            return Redirect()->back()->with('error','Sorry something is error !');
          }

        }
      }else{
           return Redirect()->back()->with('geterror','Sorry email is not valid !');
      }
      }else{
           return Redirect()->back()->with('geterror','Sorry token is not valid !');
      }

    }
  }
}
