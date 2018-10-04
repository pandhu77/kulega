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
class CustomerGroupController extends Controller
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
    /** Begin ajax  member level managament */
    public function ajaxmemberlevel(){
      $memberlevel=input::get('level');
      $memberid=input::get('memberid');
      $now=new datetime();
      $userid= auth::user()->id;

      $update =DB::table('ms_members')->where('member_id','=',$memberid)->update([
            'member_level'=>$memberlevel,
            'member_update_at'=>$now,
            'user_id'=>$userid,
      ]);

     return redirect()->to('backend/customer-group')->with('success-create','Thank you for member Update!');
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
          $level=DB::table('ms_disc_level')->get();
          $member=DB::table('ms_members')
                // ->join('ms_disc_level','ms_disc_level.disc_level_id','=','ms_members.member_level')
                ->get();
          return view('backend.customer-group.index',[
            'member'=>$member,
            'level'=>$level,
          ]);
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
