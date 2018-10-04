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
class BonusController extends Controller
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

    public function settingbonus()
    {
      $auth = $this->CheckAuth();
      if($auth == true){
          $row=DB::table('lk_setting_bonus')->first();

          return view('backend.bonus.setting',[
            'row'=>$row,
          ]);
        }else{
      return Redirect::back()->withErrors(['msg', 'Sorry, No Access']);
      }
    }
    public function settingpost(){
      $auth = $this->CheckAuth();
      if($auth == true){
          $set_value=input::get('set_value');
          // $req_min=input::get('req_min');
          $now          = new DateTime();
          $userid= auth::user()->id;
          $update=DB::table('lk_setting_bonus')->update([
              'set_value'=>$set_value,
              'req_min'=>$req_min,
              'updated_at'=>$now,
              'updated_by'=>$userid

          ]);
          if($update){
            return redirect()->back()->with('success-create','Thank you for setting bonus update!');

          }else{
            return Redirect()->back()->with('error','Sorry something is error !');
          }
        }else{
      return Redirect::back()->withErrors(['msg', 'Sorry, No Access']);
      }
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
          $bonus=DB::table('ms_bonus')->get();

          return view('backend.bonus.index',[
            'bonus'=>$bonus,
          ]);
        }else{
      return Redirect::back()->withErrors(['msg', 'Sorry, No Access']);
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
            return view('backend.bonus.create');
          }else{
        return Redirect::back()->withErrors(['msg', 'Sorry, No Access']);
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
        # code...
        // validate the info, create rules for the inputs
          //  $code=rand(11111,99999);
           $bonus_reward=Input::get('bonus_reward'); //cart disc=2, catalog disc=1
           $bonus_name=Input::get('bonus_name');
           $bonus_value=Input::get('bonus_value');
           $bonus_poin=Input::get('bonus_poin');

          //  $bonus_limit_user=Input::get('bonus_limit_user');

           $now          = new DateTime();
           $userid= auth::user()->id;

          $rules = array(
            // 'bonus_code'       => 'required|unique:ms_bonus',

            'bonus_reward'      => 'required',
            'bonus_value' => 'required|numeric',
            'bonus_poin' => 'required',

          );
          // run the validation rules on the inputs from the form
          $validator = Validator::make(Input::all(), $rules);
          // if the validator fails, redirect back to the form
          if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator) // send back all errors to the login form
            ->withInput(); // send back the input (not the password) so that we can repopulate the form
          } else {

              $insert = DB::table('ms_bonus')->insert([

                 'bonus_reward' => $bonus_reward,
                 'bonus_name' => $bonus_name,
                 'bonus_value' => $bonus_value,
                 'bonus_poin' => $bonus_poin,
                 'bonus_created_at'=>$now,
                 'bonus_created_by'=>$userid,
              ]);
              if($insert){
                return redirect()->to('backend/bonus')->with('success-create','Thank you for bonus add!');

              }else{
                return Redirect()->back()->with('error','Sorry something is error !');
              }
        }
      }else{
        return Redirect::back()->withErrors(['msg', 'Sorry, No Access']);
      }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $auth = $this->CheckAuth();

      if($auth == true){
      $row=DB::table('ms_bonus')->where('bonus_id','=',$id)->first();

      return view('backend.bonus.edit',[
        'row'=>$row,
      ]);
        }else{
        return Redirect::back()->withErrors(['msg', 'Sorry, No Access']);
      }
    }

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

        if(!empty($request['enable'])){
          $enable=1;
        }else{
          $enable=0;
        }
        $status = $enable;
        //  $code=rand(11111,99999);

         $bonus_reward=Input::get('bonus_reward'); //cart disc=2, catalog disc=1
         $bonus_name=Input::get('bonus_name');
         $bonus_value=Input::get('bonus_value');
         $bonus_poin=Input::get('bonus_poin');
         $now          = new DateTime();
         $userid= auth::user()->id;
         $rules = array(
           // 'bonus_code'       => 'required|unique:ms_bonus',
           'bonus_reward'      => 'required',
           'bonus_value' => 'required|numeric',
           'bonus_poin' => 'required',
         );
         $validator = Validator::make(Input::all(), $rules);

         if ($validator->fails()) {
          return Redirect::to('nerds/' . $id . '/edit')
          ->withErrors($validator)
          ->withInput(Input::except('password'));
         } else {

          $update = DB::table('ms_bonus')
          ->where('bonus_id', $id)
          ->update([

            'bonus_reward' => $bonus_reward,
            'bonus_name' => $bonus_name,
            'bonus_value' => $bonus_value,
            'bonus_poin' => $bonus_poin,
            'bonus_created_at'=>$now,
            'bonus_created_by'=>$userid,
          ]);

          if($update){
            return redirect()->to('backend/bonus')->with('success-create','Thank you for bonus Update!');
          }else{
            return Redirect()->back()->with('error','Sorry something is error !');
          }
        }
    }else{
      return Redirect::back()->withErrors(['msg', 'Sorry, No Access']);
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
            $i = DB::table('ms_bonus')->where('bonus_id',$id)->delete();
            if($i > 0)
            {
               return redirect()->back()->with('success-delete','Your bonus file has been deleted!');
             }else{
                return redirect()->back()->with('no-delete','Can not be removed!');
             }
          }else{
             return redirect()->back()->with('no-delete','Sorry, No Access to removed!');
          }
        }else{
          return Redirect::back()->withErrors(['msg', 'Sorry, No Access']);
        }
    }

    private function CheckAuth()
    {

      $url = request()->segment(1)."/".request()->segment(2)."/".request()->segment(3);
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
