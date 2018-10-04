<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use Redirect;
use DB;
use Session;

class SocialAuthController extends Controller {

  public function redirect($service){
    return Socialite::driver($service)->redirect();
  }

  public function callback($service){

	  $user = Socialite::with ($service)->user();

    if($service=='google'){
      $email 	= $user->email;
			$name 	= $user->name;

      $check= DB::table('ms_members')->where('member_email','=',$email)->first();
        if(count($check) <= 0 ){
          DB::table('ms_members')->insert([
            'member_email' 		=> $email,
            'member_fullname' 	=> $name,
            'member_status' 		=> 1,
          ]);
        }else{
            Session::set('memberid',$check->member_id);
            Session::set('membername',$check->member_fullname);
        }
      $user= DB::table('ms_members')->where('member_email','=',$email)->first();
      Session::set('memberid',$user->member_id);
      Session::set('membername',$user->member_fullname);
      Session::forget("bonusreward1");
      Session::forget("tmppoint1");
      Session::forget("discvoc");
      Session::flash('success','You have successfully logged in');

    }elseif($service=='facebook'){

			$email 	= $user->user['email'];
			$name 	= $user->user['name'];

      $check= DB::table('ms_members')->where('member_email','=',$email)->first();
          if(count($check) <= 0 ){
            DB::table('ms_members')->insert([
              'member_email' 		=> $email,
              'member_fullname' 	=> $name,
              'member_status' 		=> 1,
            ]);
          }else{
              Session::set('memberid',$check->member_id);
              Session::set('membername',$check->member_fullname);
          }
      $user= DB::table('ms_members')->where('member_email','=',$email)->first();
      Session::set('memberid',$user->member_id);
      Session::set('membername',$user->member_fullname);
      Session::forget("bonusreward1");
      Session::forget("tmppoint1");
      Session::forget("discvoc");
      Session::flash('success','You have successfully logged in');
		}
    return redirect('/');
  }
}
