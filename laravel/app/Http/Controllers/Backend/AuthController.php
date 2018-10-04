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

class AuthController extends Controller
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


  public function auth($access_id){
    // $auth = $this->CheckAuth();
    //   if($auth == true){
          $ace=DB::table('user_access')->where('access_id','=',$access_id)->first();
          if(count($ace) > 0){
            //from
            $mainmenu=DB::table('menu_admin')
            ->where('menu_admin.group','=',0)
            // ->where('status_menu','=',1)
            ->orderby('menu_id','=','ASC')
            ->get();
            $submenu=DB::table('menu_admin')
            ->where('menu_admin.group','!=',0)
            // ->where('status_menu','=',1)
            ->orderby('menu_id','=','ASC')
            ->get();

            //to
            $authmainmenu=DB::table('user_auth')
                      ->join('menu_admin','menu_admin.menu_id','=','user_auth.menu_id')
                      ->where('access_id','=',$access_id)
                      ->where('menu_admin.group','=',0)
                      ->orderby('id','=','asc')
                      ->get();

            $authmaingroup=DB::table('user_auth')
                      ->join('menu_admin','menu_admin.menu_id','=','user_auth.menu_id')
                      ->where('access_id','=',$access_id)
                      ->where('menu_admin.group','!=',0)
                      ->groupby('menu_admin.group')
                      ->get();

            $authmain=DB::table('menu_admin')
            ->where('menu_admin.group','=',0)
            // ->where('status_menu','=',1)
            // ->orderby('menu_id','=','ASC')
            ->get();

            $authsubmenu=DB::table('user_auth')
                      ->join('menu_admin','menu_admin.menu_id','=','user_auth.menu_id')
                      ->where('access_id','=',$access_id)
                      ->where('menu_admin.group','!=',0)
                      ->orderby('id','=','asc')->get();
            return view('backend.user-access.auth',[
              'mainmenu'=>$mainmenu,
              'ace'=>$ace,
              'submenu'=>$submenu,
              'authmain'=>$authmain,
              'authmainmenu'=>$authmainmenu,
              'authmaingroup'=>$authmaingroup,
              'authsubmenu'=>$authsubmenu,
            ]);
          }else{
            return Redirect()->back();
          }
    //   }else{
    //     return Redirect::back()->withErrors(['Sorry, No Access']);
    //   }
  }
  public function authUpdate(){

    // $auth = $this->CheckAuth();
    //   if($auth == true){

        $access_id=input::get('access_id');
        $from=input::get('from');
        $to=input::get('to');
        $now= new DateTime();
        $userid= auth::user()->id;

        $delete =DB::table('user_auth')->where('access_id','=',$access_id)->delete();
            if($to !==null){
              foreach ($to as $key => $menuid) {
                $submenu=DB::table('menu_admin')->where('menu_id','=',$menuid)->first();
                if(count($submenu)>0){

                $mainmain=DB::table('menu_admin')->where('menu_admin.group','=',0)->where('menu_id','=',$submenu->group)->first();

                if($mainmain!==null){
                  $checkmenu= DB::table('user_auth')->where('menu_id','=',$mainmain->menu_id)->where('access_id','=',$access_id)->first();
                  if(count($checkmenu)< 1 ){
                    $updatemega = DB::table('user_auth')->insert([
                      'access_id'=>$access_id,
                      'menu_id'=>$mainmain->menu_id,
                      'updated_at'=> $now,
                      'updated_by'=>$userid,
                    ]);

                  }
                  }

                  $updatesub = DB::table('user_auth')->insert([
                    'access_id'=>$access_id,
                    'menu_id'=>$menuid,
                    'updated_at'=> $now,
                    'updated_by'=>$userid,
                  ]);
                }

              }

              return redirect()->back()->with('success','Thank you for access Update!');
            }else{
              return redirect()->back()->with('success','Thank you for access Update!');
            }

        // }else{
        //   return Redirect::back()->withErrors(['Sorry, No Access']);
        // }
  }

  // private function CheckAuth()
  // {
  //   $url = request()->segment(1)."/".request()->segment(2);
  //   $menu=DB::table('menu_admin')->get();
  //   foreach ($menu as $menus)
  //   {
  //     if($menus->url== $url){
  //       $cek=  Helper::checkmenuchecklist(Auth::user()->access_id, $menus->menu_id);
  //       if ($cek ==1){
  //         return true;
  //       }else{
  //         return false;
  //       }
  //
  //     }
  //   }
  // }
}
