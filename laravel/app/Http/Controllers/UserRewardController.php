<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use DB;
use Cart;
use Session;
use Datetime;

class UserRewardController extends Controller
{
  /* START GET in progress   */
  public function getrewards()
  {
      if(Session::get('memberid')){
          $memberid=Session::get('memberid');
          $member=DB::table('ms_members')->where('member_id','=',$memberid)->first();
          $bonus= DB::table('ms_bonus')->where('bonus_poin','<=', $member->member_points)->get();

          return view('frontend.member.rewards',[
              'member'=>$member,
              'bonus'=>$bonus,
          ]);

      }else{
        Session::flash('error_must_login','You must Login');
        return Redirect('user/login');
      }

    }
}
