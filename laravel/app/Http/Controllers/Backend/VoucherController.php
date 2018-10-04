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
class VoucherController extends Controller
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

    public function voucherlog(){
        if (!empty($_GET['datefrom']) || !empty($_GET['dateto'])) {
            $log = DB::table('tmp_voucher_log')->where('created_at','>=',$_GET['datefrom'])->where('created_at','<=',$_GET['dateto'])->get();
        }else {
            $log = '';
        }

        return view('backend.voucher.log',[
            'log' => $log
        ]);
    }

    public function index()
    {
    //   $auth = $this->CheckAuth();
    //   if($auth == true){
          $voucher=DB::table('ms_voucher')->get();

          return view('backend.voucher.index',[
            'voucher'=>$voucher,
          ]);
    //     }else{
    //   return Redirect::back()->withErrors(['Sorry, No Access']);
    //   }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    //   $auth = $this->CheckAuth();
    //   if($auth == true){
            return view('backend.voucher.create');
    //       }else{
    //     return Redirect::back()->withErrors(['Sorry, No Access']);
    //   }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //   $auth = $this->CheckAuth();
      //
    //   if($auth == true){
        # code...
        // validate the info, create rules for the inputs

          if(!empty($request['enable'])){
            $enable=1;
          }else{
            $enable=0;
          }
          $status = $enable;

          //  $code=rand(11111,99999);
           $voucher_code=Input::get('voucher_code');
           $voucher_type=Input::get('voucher_type'); //cart disc=2, catalog disc=1
           $voucher_name=Input::get('voucher_name');
           $voucher_value=Input::get('voucher_value');
           $voucher_limit_usage=Input::get('voucher_limit_usage');
           $voucher_start_date=Input::get('voucher_start_date');
           $voucher_end_date=Input::get('voucher_end_date');
           $voucher_min_value=Input::get('voucher_min_value');
           $voucher_max_value=Input::get('voucher_max_value');

           $voucher_limit_user=Input::get('voucher_limit_user');

           $now          = new DateTime();
           $userid= auth::user()->id;

          $rules = array(
            // 'voucher_code'       => 'required|unique:ms_voucher',
            'voucher_code'       => 'required',
            'voucher_type'      => 'required',
            'voucher_value' => 'required|numeric',
            'voucher_limit_usage' => 'required',
            'voucher_limit_user' => 'required',
            'voucher_start_date' => 'required',
            'voucher_end_date' => 'required',
            'voucher_min_value' => 'numeric',
            'voucher_max_value' => 'numeric',
          );
          // run the validation rules on the inputs from the form
          $validator = Validator::make(Input::all(), $rules);
          // if the validator fails, redirect back to the form
          if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator) // send back all errors to the login form
            ->withInput(); // send back the input (not the password) so that we can repopulate the form
          } else {

              $insert = DB::table('ms_voucher')->insert([
                 'voucher_status'=>$status,
                 'voucher_code' => $voucher_code,
                 'voucher_type' => $voucher_type,
                 'voucher_name' => $voucher_name,
                 'voucher_value' => $voucher_value,
                 'voucher_min_value' => $voucher_min_value,
                 'voucher_max_value' => $voucher_max_value,
                 'voucher_start_date' => $voucher_start_date,
                 'voucher_end_date' => $voucher_end_date,
                 'voucher_limit_user' => $voucher_limit_user,
                 'voucher_limit_usage' => $voucher_limit_usage,
                 'voucher_created_at'=>$now,
                 'voucher_created_by'=>$userid,
              ]);
              if($insert){
                return redirect()->to('backend/voucher')->with('success-create','Thank you for voucher add!');

              }else{
                return Redirect()->back()->with('error','Sorry something is error !');
              }
        }
    //   }else{
    //     return Redirect::back()->withErrors(['Sorry, No Access']);
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
    //   $auth = $this->CheckAuth();
      //
    //   if($auth == true){
          $row=DB::table('ms_voucher')->where('voucher_id','=',$id)->first();

          return view('backend.voucher.edit',[
            'row'=>$row,
          ]);
    //     }else{
    //     return Redirect::back()->withErrors(['Sorry, No Access']);
    //   }
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
    //   $auth = $this->CheckAuth();
      //
    //   if($auth == true){

        if(!empty($request['enable'])){
          $enable=1;
        }else{
          $enable=0;
        }
        $status = $enable;
        //  $code=rand(11111,99999);
         $voucher_code=Input::get('voucher_code');
         $voucher_type=Input::get('voucher_type'); //cart disc=2, catalog disc=1
         $voucher_name=Input::get('voucher_name');
         $voucher_value=Input::get('voucher_value');
         $voucher_limit_usage=Input::get('voucher_limit_usage');
         $voucher_start_date=Input::get('voucher_start_date');
         $voucher_end_date=Input::get('voucher_end_date');
         $voucher_min_value=Input::get('voucher_min_value');
         $voucher_max_value=Input::get('voucher_max_value');
         $voucher_limit_user=Input::get('voucher_limit_user');


         $now          = new DateTime();
         $userid= auth::user()->id;
         $rules = array(
           // 'voucher_code'       => 'required|unique:ms_voucher',
           'voucher_code'       => 'required',
           'voucher_type'      => 'required',
           'voucher_value' => 'required|numeric',
           'voucher_limit_usage' => 'required',
           'voucher_limit_user' => 'required',
           'voucher_start_date' => 'required',
           'voucher_min_value' => 'numeric',
           'voucher_max_value' => 'numeric',
         );
         $validator = Validator::make(Input::all(), $rules);

         if ($validator->fails()) {
          return Redirect::to('nerds/' . $id . '/edit')
          ->withErrors($validator)
          ->withInput(Input::except('password'));
         } else {

          $update = DB::table('ms_voucher')
          ->where('voucher_id', $id)
          ->update([
            'voucher_status'=>$status,
            'voucher_code' => $voucher_code,
            'voucher_type' => $voucher_type,
            'voucher_name' => $voucher_name,
            'voucher_value' => $voucher_value,
            'voucher_min_value' => $voucher_min_value,
            'voucher_max_value' => $voucher_max_value,
            'voucher_start_date' => $voucher_start_date,
            'voucher_end_date' => $voucher_end_date,
            'voucher_limit_user' => $voucher_limit_user,
            'voucher_limit_usage' => $voucher_limit_usage,
            'voucher_created_at'=>$now,
            'voucher_created_by'=>$userid,
          ]);

          if($update){
            return redirect()->to('backend/voucher')->with('success-create','Thank you for voucher Update!');
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
            $i = DB::table('ms_voucher')->where('voucher_id',$id)->delete();
            if($i > 0)
            {
               return redirect()->back()->with('success-delete','Your voucher file has been deleted!');
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
      $menu=DB::table('menu_admin')->get();
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
