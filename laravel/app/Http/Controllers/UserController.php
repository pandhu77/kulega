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
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function getShipping(){
       if(Session::get('memberid')){

           $memberid=Session::get('memberid');
           $ship=DB::table('address_book')->where('member_id', '=', $memberid)->get();
           return view('frontend.member.my-shipping',[
             'ship'    =>$ship,
           ]);
         }else{
           Session::flash('error_must_login','You must Login');
           return Redirect('user/login');
         }
     }

     public function deleteShipping($id){
       if(Session::get('memberid')){
           $memberid=Session::get('memberid');
           $delete=DB::table('address_book')->where('member_id', '=', $memberid)->where('adress_id',$id)->delete();
           if($delete){
             return Redirect()->back()->with('success-edit','Successfully shipping Remove!');
           }else{
             return Redirect()->back()->with('error_get','Sorry shipping Remove is error !');
           }
         }else{
           Session::flash('error_must_login','You must Login');
           return Redirect('user/login');
         }
     }

    public function getFormAddress(){
          if(Session::get('memberid')){
          $memberid=Session::get('memberid');
          $ship=DB::table('address_book')->where('member_id','=',$memberid)->first();

          return view('frontend/member/add-shipping',[
            'ship'=> $ship,
          ]);
        }else{
          Session::flash('error_must_login','You must Login');
          return Redirect('user/login');
        }
    }
    public function getaddress($id){
          if(Session::get('memberid')){

          $memberid=Session::get('memberid');
          $ship=DB::table('address_book')->where('adress_id','=',$id)->where('member_id','=',$memberid)->first();

          return view('frontend/member/edit-shipping',[
            'ship'=> $ship,
          ]);
        }else{
          Session::flash('error_must_login','You must Login');
          return Redirect('user/login');
        }
    }

    public function login(){
      if(Session::get('memberid')==null)
      {
        return view('frontend.member.login');
      }else{
        return Redirect('member/profile');
      }
    }
    public function changepassword(){
      if(Session::get('memberid')){
        return view('frontend.member.change-password');
      }else{
      Session::flash('error_must_login','You must sign');
      return Redirect('member/login');
      }
    }
    public function dochangepassword(){
      if(Session::get('memberid')){

          $memberid=Session::get('memberid');
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

            $user = DB::table('ms_members')
              // ->select('member_email', 'member_password')
              ->where('member_id', $memberid)
              ->where('member_status', 1)
              ->first();

              if ($user && Hash::check(Input::get('currentpassword'), $user->member_password)) {
                if($password ==$confpass){
                  $update = DB::table('ms_members')
                    ->where('member_id', $memberid)
                    ->update([
                        'member_password'=> hash::make(Input::get('password')),
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
          return Redirect('member/login');
      }
    }

    public function doUpdateShipping(){
        if(Session::get('memberid'))
        {
          $memberid=Session::get('memberid');
        # code...
        // validate the info, create rules for the inputs
        $rules = array(

          'title'         => 'required',
          'recipname'     => 'required',
          'address'       => 'required',
          'province'      => 'required', // make sure the email is an actual email
          'city'          => 'required',
          'subdistrict'    => 'required',
          'phone'         => 'required',
          'email'         => 'required',
          'post_code'     => 'required',
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
          return redirect()->back()
          ->withErrors($validator) // send back all errors to the login form
          ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {
          $province2     = Input::get('province2');
          $city2         = Input::get('city2');
          $subdistrict2  = Input::get('subdistrict2');
          $phone        = Input::get('phone');
          $title        = Input::get('title');
          $recipname    = Input::get('recipname');
          $address      = Input::get('address');
          $post_code    = Input::get('post_code');
          $province     = Input::get('province');
          $city         = Input::get('city');
          $subdistrict  = Input::get('subdistrict');
          $phone        = Input::get('phone');
          $email        = Input::get('email');
          $id           = Input::get('addressid');
          $now          = new DateTime();

          $update = DB::table('address_book')
            ->where('member_id', $memberid)
            ->where('adress_id',$id)
            ->update([
              'title'             => $title,
              'recipentname'      => $recipname,
              'address'           => $address,
              'province'          => $province2,
              'city'              => $city2,
              'subdistrict'       => $subdistrict2,
              'post_code'         => $post_code,
              'phone_number'      => $phone,
              'email'             => $email,
              'updated_at'  => $now,


            ]);
            if($update){
              return Redirect('user/my-shipping')->with('success-edit','Successfully shipping address!');
            }else{
              return Redirect()->back()->with('error','Sorry something is error !');
            }
          }

        } else {
        Session::flash('error_must_login','You must sign');
        return Redirect('member/login');
        }
    }

    public function doAddShipping(){
        if(Session::get('memberid'))
        {
            $memberid=Session::get('memberid');
            # code...
            // validate the info, create rules for the inputs
            $rules = array(

                'title'         => 'required',
                'recipname'     => 'required',
                'address'       => 'required',
                'bilprovince'      => 'required', // make sure the email is an actual email
                'bilcity'          => 'required',
                'bildistrict'    => 'required',
                'email'    => 'required',
                'phone'         => 'required',
                'post_code'     => 'required',
            );
            // run the validation rules on the inputs from the form
            $validator = Validator::make(Input::all(), $rules);
            // if the validator fails, redirect back to the form
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator) // send back all errors to the login form
                    ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
            } else {
                $bilprovince     = Input::get('bilprovince');
                $bilcity         = Input::get('bilcity');
                $bilsubdistrict  = Input::get('bildistrict');
                $title        = Input::get('title');
                $recipname    = Input::get('recipname');
                $address      = Input::get('address');
                $post_code    = Input::get('post_code');
                $province     = Input::get('province');
                $city         = Input::get('city');
                $subdistrict  = Input::get('subdistrict');
                $phone        = Input::get('phone');
                $email        = Input::get('email');
                $now          = new DateTime();


                $update = DB::table('address_book')
                    ->insert([
                        'member_id'         => $memberid,
                        'title'             => $title,
                        'recipentname'      => $recipname,
                        'address'           => $address,
                        'province'          => $province,
                        'city'              => $city,
                        'subdistrict'       => $subdistrict,
                        'post_code'         => $post_code,
                        'phone_number'      => $phone,
                        'email'             => $email,
                        'updated_at'  => $now,

                    ]);
                if($update){
                    return Redirect('user/my-shipping')->with('success-add','Successfully add shipping address!');
                }else{
                    return Redirect()->back()->with('error','Sorry something is error !');
                }
            }

        } else {
            Session::flash('error_must_login','You must sign');
            return Redirect('member/login');
        }
    }

    public function doupdateprofile(Request $request)
    {
      if(Session::get('memberid')){
        $memberid=Session::get('memberid');
        # code...
        // validate the info, create rules for the inputs
        $rules = array(

          'fullname'    => 'required',
          'username'    => 'required',
          'phonenumber'    => 'required',
          'email'    => 'required|email', // make sure the email is an actual email
          'gender'    => 'required',

        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
          return redirect()->back()
          ->withErrors($validator) // send back all errors to the login form
          ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {

          $username     = Input::get('username');
          $name         = Input::get('fullname');
          $phone        = Input::get('phonenumber');
          $email        = Input::get('email');
          $gender       = Input::get('gender');

          $day = Input::get('day');
          $month = Input::get('month');
          $year = Input::get('year');
          $birthofdate  ="$year-$month-$day";

          $address      = Input::get('address');
          $now          = new DateTime();



          $check=DB::table('ms_members')->where('member_email','=',$email)->where('member_id','!=',$memberid)->count();
          if($check > 0){
            return Redirect()->back()->with('error_get','Sorry this User Name already registered !');
          }else{
            if (!is_dir("assets/img-member/$memberid")) {
              $newforder=mkdir("assets/img-member/$memberid");
            }
            $img=Input::get('member_image');
            $file = Input::file('imagetest');
            // Disini proses mendapatkan judul dan memindahkan letak gambar ke folder image
            if ($file !==null) {

              $path = public_path().'/assets/img-member/'.$memberid.'/';
              File::delete($path.$img);
              $fileName   = $file->getClientOriginalName();
              $file->move("assets/img-member/$memberid", $fileName);

            }else{
              $fileName='';
            }

            $update = DB::table('ms_members')
            ->where('member_id', $memberid)
            ->update([
              'member_username'    => $username,
              'member_fullname'    => $name,
              'member_email'       => $email,
              'member_phone'    => $phone,
              'member_gender'         => $gender,
              'member_dob'    => date('Y-m-d', strtotime($birthofdate)),
              'member_address'        =>$address,
              'member_update_at'     => $now,


            ]);
            if($fileName !==''){
              $updateimg = DB::table('ms_members')
              ->where('member_id', $memberid)
              ->update([
                'member_image'            => $fileName,
              ]);
            }
            if($update){
              return Redirect('user/profile')->with('success','Successfully Edit Profile!');
            }else{
              return Redirect()->back()->with('error','Sorry something is error !');
            }
          }
        }

      }else{
        Session::flash('error_must_login','You must sign');
        return Redirect('member/login');
      }
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
        $user = DB::table('ms_members')
          // ->select('member_email', 'member_password')
          ->where('member_email', $email)
          ->where('member_status', 1)
          ->first();

          if ($user && Hash::check(Input::get('password'), $user->member_password)) {
                // here you know data is valid
              Session::set('memberid',$user->member_id);
              Session::set('membername',$user->member_fullname);
              Session::set('membermail',$user->member_email);
              Session::set('memberphone',$user->member_phone);
              Session::set('memberaddress',$user->member_address);
              Session::set('memberimage',$user->member_image);
              Session::forget("bonusreward1");
              Session::forget("tmppoint1");
              Session::forget("discvoc");
              Session::flash('success','You have successfully logged in');
              return redirect('/');

          }else{
           return Redirect()->to('user/login')->with('error_get','Wrong username or password. Try again.!');
          }
      }
    }
    public function doregister(){

      $rules = array(

        'member_fullname'    => 'required',
        'member_email'    => 'required|email', // make sure the email is an actual email
        'member_password' => 'required|min:6',
        'confpass' => 'required|min:6', // password can only be alphanumeric and has to be greater than 6 characters

      );
      // run the validation rules on the inputs from the form
      $validator = Validator::make(Input::all(), $rules);
      // if the validator fails, redirect back to the form
      if ($validator->fails()) {
        return Redirect()->to('user/login#signup')
        ->withErrors($validator) // send back all errors to the login form
        ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
      } else {
          $fullname     = Input::get('member_fullname');
          $email        = Input::get('member_email');
          $password     = hash::make(Input::get('member_password'));
          $pass         = Input::get('member_password');
          $confpass    = Input::get('confpass');
          $now          = new DateTime();
          $check=DB::table('ms_members')->where('member_email','=',$email)->count();

            if($check > 0){
              return Redirect()->to('user/login#signup')->with('error_get','Sorry this email already registered!');

            }else{
                  if($pass==$confpass){
                      $activation_code = str_random(30).$email;
                      $insert = DB::table('ms_members')->insert([
                        'member_fullname'       => $fullname,
                        'member_email'          => $email,
                        'member_password'       => $password,
                        'activation_code'=> $activation_code,
                        'member_created_at'     => $now,
                      ]);
                      if($insert){
                        //   var_dump('insert');
                        //   exit();
                        $check2= DB::table('ms_members')->where('member_email','=',$email)->first();
                        if(count($check2) >0 ){

                        $returnhtml= HelperEmail::emailRegistration($email,$fullname,$activation_code);


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

                          $mail->addAddress($email, $fullname);

                          $mail->isHTML(true);

                          $mail->Subject = "Please Activate Your Account! -E-Commerce Djaring.id";
                          $mail->Body = $returnhtml;
                          $mail->AltBody = "ini link anda plan";
                          if(!$mail->send())
                          {
                              return Redirect()->to('user/login#signup')->with('error_get','Mailer Error:'.$mail->ErrorInfo.'');
                            // echo "Mailer Error: " . $mail->ErrorInfo;
                          }
                          {

                           return Redirect()->to('user/login#signup')->with('signupsuccess',' Success signup, Please check your email to confirm activation !');
                          }

                        }

                      }else{
                        return Redirect()->to('user/login#signup')->with('error','Sorry something is error !');
                      }
                  }else{
                        return Redirect()->to('user/login#signup')->with('error_get','Sorry, there is not the same password!');
                  }

          }
      }
    }
    public function activation($code){
      $cekmember=DB::table('ms_members')
      ->where('activation_code','=',$code)
      ->where('member_status','=',0)
      ->first();

      if(count($cekmember) > 0){
          $update = DB::table('ms_members')
          ->where('activation_code','=',$cekmember->activation_code)
          ->update(['member_status' => 1 ]);
          if($update){
            $returnhtml= HelperEmail::emailActivation($code);
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

            $mail->addAddress($cekmember->member_email, $cekmember->member_fullname);

            $mail->isHTML(true);

            $mail->Subject = "Welcome to E-Commerce Djaring.id";
            $mail->Body = $returnhtml;
            $mail->AltBody = "ini link anda plan";
            if(!$mail->send())
            {
                return Redirect()->to('user/login#signup')->with('error_get','Mailer Error:'.$mail->ErrorInfo.'');
              // echo "Mailer Error: " . $mail->ErrorInfo;
            }
            {
             return Redirect()->to('user/login')->with('signupsuccess','Thank you ! Your account has been activated. Please login to continue shopping.');
            }
          }else{
              return Redirect('/');
          }
      }else {
        return Redirect('/');
      }

    }
    public function profile(){
      if(Session::get('memberid')){

          $memberid=Session::get('memberid');
          $row=DB::table('ms_members')->where('member_id','=',$memberid)->first();
          if($row->member_dob ==null){
            $yearbirth='';
          }else{
            $yearbirth= date("Y",strtotime($row->member_dob));
          }

          return view('frontend.member.profile',[
            'row'    =>$row,
            'yearbirth'=>$yearbirth
          ]);
        }else{
          Session::flash('error_must_login','You must Login');
          return Redirect('user/login');
        }
    }

    public function dologout()
      {
        Session::forget('memberid');
        Session::forget('membername');
        Session::forget('membermail');
        Session::forget('memberphone');
        Session::forget('memberaddress');
        Session::forget('memberimage');
        Session::flash('message', "welcome");
        return Redirect('/');
      }
    public function forgotPassword(){
      $email=input::get('emailforgot');
      $code = str_random(30).$email;
      $check=DB::table('ms_members')->where('member_email','=',$email)->first();
      $datenow= date('Y-m-d H:i:s');
      $dateplus=strtotime($datenow."+1 hours");
      $dateexp=date("Y-m-d H:i:s",$dateplus);
      if(count($check) >0){
          $insert= DB::table('tmp_user_forgotpassword')->insert([
            'email'=>$email,
            'tokenforgot'=>$code,
            'exp'=>$dateexp
           ]);
           if($insert){
               $returnhtml= HelperEmail::emailForgotPassword($email,$code);
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

               $mail->addAddress($email);

               $mail->isHTML(true);

               $mail->Subject = "ForgotPassword";
               $mail->Body = $returnhtml;
               $mail->AltBody = "ini link anda plan";
               if(!$mail->send())
               {
                   return Redirect()->to('user/login#forgot')->with('error_get','Mailer Error:'.$mail->ErrorInfo.'');
                 // echo "Mailer Error: " . $mail->ErrorInfo;
               }
               {
                return Redirect()->to('user/login#forgot')->with('signupsuccess','Thank you ! Request forgot password success, Please check you email continue confirm reset password.');
               }


           }else{
               return Redirect()->to('user/login#forgot')->with('error_get','Sorry, the request did not succeed, try again !');
           }
      }else{
          return Redirect()->to('user/login#forgot')->with('error_get','Sorry, email is not registered as a member E-Commerce Djaring.id !');
      }
    }

      public function resetPassword($code){
            $check =DB::table('tmp_user_forgotpassword')->where('tokenforgot','=',$code)->where('status','=',0)->first();
            return view('frontend.member.reset-password',[
              'check'=>$check
            ]);
      }

      public function newPassword($code)
      {
      $rules = array(
        'member_password' => 'required|min:6', // password can only be alphanumeric and has to be greater than 3 characters

      );
      // run the validation rules on the inputs from the form
      $validator = Validator::make(Input::all(), $rules);
      // if the validator fails, redirect back to the form
      if ($validator->fails()) {
        return redirect()->back()
        ->withErrors($validator) // send back all errors to the login form
        ->withInput(Input::except('member_password')); // sen d back the input (not the password) so that we can repopulate the form
      } else {

        $passwordbaru    = Input::get('member_password');
        $retypepassword  = Input::get('retypepassword');
        $token= request()->segment(3);
        $checktoken =DB::table('tmp_user_forgotpassword')->where('tokenforgot','=',$token)->where('status','=',0)->first();
        if(count($checktoken) > 0 ){
          $checkemail =DB::table('ms_members')->where('member_email','=',$checktoken->email)->first();
         if(count($checkemail) > 0 ){
        // $checkid =DB::table('members')->where('email','=',$email)->first();
          if($retypepassword !==$passwordbaru){
            return Redirect()->back()->with('geterror','These passwords don t match. Try again?!');
          }else{

            $update = DB::table('ms_members')
            ->where('member_email', $checkemail->member_email)
            ->update([
                'member_password'       =>hash::make($passwordbaru),
            ]);
            if($update){
                $update = DB::table('tmp_user_forgotpassword')
                ->where('tokenforgot',$token)
                ->update([
                    'status'       =>1,
                ]);
                $returnhtml= HelperEmail::passActivation($checkemail->member_email);
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

                $mail->addAddress($checkemail->member_email);

                $mail->isHTML(true);

                $mail->Subject = "Request Password";
                $mail->Body = $returnhtml;
                $mail->AltBody = "ini link anda plan";
                if(!$mail->send())
                {
                 return Redirect()->to('user/login')->with('error_get','Mailer Error:'.$mail->ErrorInfo.'');
                  // echo "Mailer Error: " . $mail->ErrorInfo;
                }
                {
                  return Redirect()->to('user/login')->with('signupsuccess','Successfully change Password, please your login !');
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
