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
class MemberController extends Controller
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
    //   $auth = $this->CheckAuth();
    //   if($auth == true){
          $member=DB::table('ms_members')->get();

          return view('backend.customer-list.index',[
            'member'=>$member,
          ]);
    //     }else{
    //   return Redirect::back()->withErrors(['Sorry, No Access']);
    //   }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    //   $auth = $this->CheckAuth();
    //   if($auth == true){
          $member=DB::table('ms_members')->where('member_id','=',$id)->first();
          return view('backend.customer-list.show',[
            'member'=>$member,
          ]);
    //     }else{
    //   return Redirect::back()->withErrors(['Sorry, No Access']);
    //   }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    //   $auth = $this->CheckAuth();
    //   if($auth == true){
          $row=DB::table('ms_members')
            ->leftjoin('ms_disc_level','ms_disc_level.disc_level_id','=','ms_members.member_level')
          ->where('member_id','=',$id)->first();

          return view('backend.customer-list.edit',[
            'row'=>$row,
          ]);
    //     }else{
    //   return Redirect::back()->withErrors(['Sorry, No Access']);
    //   }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
    //   $auth = $this->CheckAuth();
      //
    //   if($auth == true){

          $rules = array(
            // 'end_date'       => 'required',
            // 'email'      => 'required|email',
            // 'nerd_level' => 'required|numeric'
          );
          $validator = Validator::make(Input::all(), $rules);

          if ($validator->fails()) {
            return Redirect::to('nerds/' . $id . '/edit')
            ->withErrors($validator)
            ->withInput(Input::except('password'));
          } else {

            if(!empty($request['enable'])){
              $enable=1;
            }else{
              $enable=0;
            }

            $status = $enable;
            $now          = new DateTime();
            $userid= auth::user()->id;
            $id=Input::get('member_id');


            if(!empty(Input::get('member_password'))){
                $password     = Hash::make(Input::get('member_password'));
                $update=    DB::table('ms_members')
                  ->where('member_id', $id)
                  ->update([
                      'member_password'=>$password,
                      'member_status'=>$enable,
                      'user_id'=>$userid,
                  ]);
            }else{
                $update = DB::table('ms_members')
                ->where('member_id', $id)
                ->update([
                    'member_status'=>$status,
                ]);
            }

            if($update){
              return redirect()->to('backend/customer-list')->with('success-create','Thank you for member Update!');
            }else{
              return Redirect()->back()->with('error','Sorry something is error !');
            }
          }
    //   }else{
    //     return Redirect::back()->withErrors(['Sorry, No Access']);
    //   }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    //   $auth = $this->CheckAuth();
    //     if($auth == true){
          $checkuser=DB::table('user_access')->where('access_id','=',Auth::user()->access_id)->first();
          if($checkuser->type==1){
            $i = DB::table('ms_members')->where('member_id',$id)->delete();
            if($i > 0)
            {
               return redirect()->back()->with('success-delete','Your  file has been deleted!');
             }else{
                return redirect()->back()->with('no-delete','Can not be removed!');
             }
           }else{
              return redirect()->back()->with('no-delete','Sorry, No Access to removed!');
           }
        // }else{
        //   return Redirect::back()->withErrors(['Sorry, No Access']);
        // }
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
