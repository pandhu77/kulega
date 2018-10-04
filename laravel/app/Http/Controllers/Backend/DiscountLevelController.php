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
class DiscountLevelController extends Controller
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
          $level=DB::table('ms_disc_level')->get();

          return view('backend/discount/level.index',[
            'level'=>$level,
          ]);
        }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
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
            return view('backend/discount/level.create');
          }else{
        return Redirect::back()->withErrors(['Sorry, No Access']);
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
          if(!empty($request['enable'])){
            $enable=1;
          }else{
            $enable=0;
          }
           $status = $enable;
           $min_value=Input::get('min_value'); //cart disc=2, catalog disc=1
           $level_name=Input::get('level_name');
           $disc_value=Input::get('disc_value');
           $max_value=Input::get('max_value');
           $disc_value_uth=Input::get('disc_value_uth');
           $disc_limit_uth=Input::get('disc_limit_uth');

          //  $level_limit_user=Input::get('level_limit_user');

           $now          = new DateTime();
           $userid= auth::user()->id;

          $rules = array(
            // 'level_code'       => 'required|unique:ms_disc_level',

            'min_value'      => 'required',
            'disc_value' => 'required|numeric',
            'max_value' => 'required',
            'level_name' => 'required',
            'disc_value_uth'=>'required',
            'disc_limit_uth'=>'required',
          );
          // run the validation rules on the inputs from the form
          $validator = Validator::make(Input::all(), $rules);
          // if the validator fails, redirect back to the form
          if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator) // send back all errors to the login form
            ->withInput(); // send back the input (not the password) so that we can repopulate the form
          } else {

              $insert = DB::table('ms_disc_level')->insert([
                 'disc_status'=>$status,
                 'min_value' => $min_value,
                 'level_name' => $level_name,
                 'disc_value' => $disc_value,
                 'maxs_value' => $max_value,
                 'disc_value_uth' => $disc_value_uth,
                 'disc_limit_uth'=>$disc_limit_uth,
                 'created_at'=>$now,
                 'created_by'=>$userid,
              ]);
              if($insert){
                return redirect()->to('backend/discount-level')->with('success-create','Thank you for level add!');

              }else{
                return Redirect()->back()->with('error','Sorry something is error !');
              }
        }
      }else{
        return Redirect::back()->withErrors(['Sorry, No Access']);
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
      $row=DB::table('ms_disc_level')->where('disc_level_id','=',$id)->first();

      return view('backend/discount/level.edit',[
        'row'=>$row,
      ]);

        }else{
        return Redirect::back()->withErrors(['Sorry, No Access']);
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

        $min_value=Input::get('min_value'); //cart disc=2, catalog disc=1
        $level_name=Input::get('level_name');
        $disc_value=Input::get('disc_value');
        $max_value=Input::get('max_value');
        $disc_value_uth=Input::get('disc_value_uth');
        $disc_limit_uth=Input::get('disc_limit_uth');
        $now          = new DateTime();
        $userid= auth::user()->id;
        $rules = array(
           // 'level_code'       => 'required|unique:ms_disc_level',
           'min_value'      => 'required',
           'disc_value' => 'required|numeric',
           'max_value' => 'required',
           'level_name' => 'required',
           'disc_value_uth'=>'required',
           'disc_limit_uth'=>'required',
         );
         $validator = Validator::make(Input::all(), $rules);

         if ($validator->fails()) {
          return Redirect::to('nerds/' . $id . '/edit')
          ->withErrors($validator)
          ->withInput(Input::except('password'));
         } else {

          $update = DB::table('ms_disc_level')
          ->where('disc_level_id', $id)
          ->update([
            'disc_status'=>$status,
            'min_value' => $min_value,
            'level_name' => $level_name,
            'disc_value' => $disc_value,
            'maxs_value' => $max_value,
            'disc_limit_uth'=>$disc_limit_uth,
            'disc_value_uth'=>$disc_value_uth,
            'created_at'=>$now,
            'created_by'=>$userid,
          ]);

          if($update){
            return redirect()->to('backend/discount-level')->with('success-create','Thank you for level Update!');
          }else{
            return Redirect()->back()->with('error','Sorry something is error !');
          }
        }
    }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
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
            $i = DB::table('ms_disc_level')->where('disc_level_id',$id)->delete();
            if($i > 0)
            {
               return redirect()->back()->with('success-delete','Your level file has been deleted!');
             }else{
                return redirect()->back()->with('no-delete','Can not be removed!');
             }
          }else{
              return redirect()->back()->with('no-delete','Sorry, No Access to removed!');
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
