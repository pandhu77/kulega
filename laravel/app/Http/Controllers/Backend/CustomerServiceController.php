<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Input;
use Validator;
use File;
use Redirect;
use DateTime;
use Auth;
use Helper;
use Illuminate\Support\Facades\Hash;

use PHPMailer;
class CustomerServiceController extends Controller
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
          DB::table('ms_members')->update([
          'member_service' => 0
          ]);
          DB::table('cms_subscribers')->update([
          'service' => 0
          ]);
          $member=DB::table('ms_members')->get();
          $sub=DB::table('cms_subscribers')->get();
          return view('backend.customer-service.index',[
            'member'=>$member,
            'sub'=>$sub,
          ]);
        }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
      }
    }


        //check subscriber all user member
    public function changeall(){
      $status = Input::get('status');

      $check = DB::table('ms_members')->get();

      if ($check->status == 1) {
        DB::table('ms_members')->update([
          'member_service' => 0
        ]);
        echo '0';
      }else {
        DB::table('ms_members')->update([
          'member_service' => 1
        ]);
        echo '1';
      }
    }
    public function changecheck(){
      $status = Input::get('status');
      $id = Input::get('id');

      $check = DB::table('ms_members')->where('member_id',$id)->first();

      if ($check->member_service == 1) {
        DB::table('ms_members')->where('member_id',$id)->update([
          'member_service' => 0
        ]);
        echo '0';
      }else {
        DB::table('ms_members')->where('member_id',$id)->update([
          'member_service' => 1
        ]);
        echo '1';
      }

    }

    //check subscriber all user default
    public function subchangeall(){
      $status = Input::get('substatus');
      $check = DB::table('cms_subscribers')->get();

      if ($check->status == 1) {
        DB::table('cms_subscribers')->update([
          'service' => 0
        ]);
        echo '0';
      }else {
        DB::table('cms_subscribers')->update([
          'service' => 1
        ]);
        echo '1';
      }
    }
    public function subchangecheck(){
      $status = Input::get('substatus');
      $id = Input::get('id');
      $check = DB::table('cms_subscribers')->where('id',$id)->first();

      if ($check->service == 1) {
        DB::table('cms_subscribers')->where('id',$id)->update([
          'member_service' => 0
        ]);
        echo '0';
      }else {
        DB::table('cms_subscribers')->where('id',$id)->update([
          'service' => 1
        ]);
        echo '1';
      }

    }

    public function store(Request $request)
    {
      $auth = $this->CheckAuth();
      if($auth == true){
        $member = DB::table('ms_members')->where('ms_members.member_service','=',1)->get();
        $sub = DB::table('cms_subscribers')->where('service','=',1)->get();
        $subject=Input::get('subject');
        $newemail=Input::get('newemail');
        $body=Input::get('content');

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host         = 'srv2.niagahoster.com';
        $mail->setFrom('sentra@chronosh.com', 'E-Commerce Djaring.id');
        $mail->SMTPAuth     = true;                               // Enable SMTP authentication
        $mail->Username     = 'sentra@chronosh.com';                 // SMTP username
        $mail->Password     = '123456';
        $mail->SMTPSecure   = 'ssl';
        $mail->Port         = 465;
        if(!empty($newemail)){
          $mail->addAddress($newemail, "");
        }
        //To address and members
        foreach($member as $members){
          $mail->addAddress($members->member_email, "");
        }
        //To email subscriber
        foreach($sub as $subs){
          $mail->addAddress($subs->email, "");
        }
        //$mail->addAddress($email, "");
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = "this the email content";


        if(!$mail->send()) {

          return redirect()->back()->with('errors-broadcast','Mailer Error:'.$mail->ErrorInfo.'');

        }else {


          return redirect()->to('backend/customer-service')->with('success-broadcast','Your message has been send');

        }
      }else{
        return Redirect::back()->withErrors(['Sorry, No Access']);
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
