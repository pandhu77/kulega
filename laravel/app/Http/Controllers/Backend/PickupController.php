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

class PickupController extends Controller
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
      $pickup=DB::table('ms_pickup')->get();
      return view('backend.pickup-point.index',[
        'pickup'=>$pickup
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
      $pickup=DB::table('ms_pickup')->get();
      return view('backend.pickup-point.create',[
        'pickup'=>$pickup
      ]);
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
      $rules = array(

      );
      // run the validation rules on the inputs from the form
      $validator = Validator::make(Input::all(), $rules);
      // if the validator fails, redirect back to the form
      if ($validator->fails()) {
        return redirect()->back()
        ->withErrors($validator) // send back all errors to the login form
        ->withInput(); // send back the input (not the password) so that we can repopulate the form
      } else {

        $city       =Input::get('city');
        $now          = new DateTime();
        if(!empty($request['status'])){
          $enable=1;
        }else{
          $enable=0;
        }
        $status = $enable;
        $userid= auth::user()->id;


        $insert = DB::table('ms_pickup')->insert([
          'city'=>$city,
          'enable'      =>$status,
          'created_at'     => $now,
          'created_by'=>$userid,
        ]);
        if($insert){
          $check =DB::table('ms_pickup')->where('created_by','=',$userid)->orderby('pick_id','=','DESC')->first();
          $location  =input::get('location');
          $dtlocation =input::get('dtlocation');
          $phone   =input::get('phone');
          $stpoint  =input::get('stpoint');
          if(!empty($location)){
            foreach ($location as $key => $locations) {

                DB::table('tmp_pickup')->insert([
                  'pick_id' => $check->pick_id,
                  'location'=>$locations,
                  'detail_location'=>$dtlocation[$key],
                  'pick_phone'=>$phone[$key],
                  'detail_enable'=>1,
                ]);
            }
            /** End input varian */
          }

          //fungsi untuk sytem log
            // $logcontent ="Add new data access name($access), status($status) for User Access";
            // $logtype ="User Access";
            // $loguser =Auth::user()->id;
            // $logdateTime=new DateTime();
            // $log=  Helper::userlog($logtype,$logcontent,$loguser,$logdateTime);
          //end userlog

          return redirect()->to('backend/pickup-point')->with('success-create','Thank you for access add!');

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
      $row=DB::table('ms_pickup')->where('pick_id','=',$id)->first();
      $point=DB::table('tmp_pickup')->where('pick_id','=',$row->pick_id)->get();
      return view('backend.pickup-point.edit',[
        'row'=>$row,
        'point'=>$point
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

      $rules = array(
        // 'name'       => 'required',
        // 'email'      => 'required|email',
        // 'nerd_level' => 'required|numeric'
      );
      $validator = Validator::make(Input::all(), $rules);

      if ($validator->fails()) {
        return Redirect::to('nerds/' . $id . '/edit')
        ->withErrors($validator)
        ->withInput(Input::except('password'));
      } else {

        $city       =Input::get('city');
        $now          = new DateTime();
        if(!empty($request['status'])){
          $enable=1;
        }else{
          $enable=0;
        }
        $userid= auth::user()->id;

        $update = DB::table('ms_pickup')
        ->where('pick_id', $id)
        ->update([
          'city'=>$city,
          'enable'      =>$enable,
          'updated_at'    => $now,
          'update_by'      =>$userid,
        ]);

        if($update){



          //UDAPTE DETAIL
          $pointid  =input::get('pointid');
          $locationupdate  =input::get('location_update');
          $dtlocationupdate =input::get('dtlocation_update');
          $phoneupdate   =input::get('phone_update');

          if(!empty($pointid)){
            foreach ($pointid as $key => $pointids) {
                DB::table('tmp_pickup')->where('id','=',$pointids)->update([
                  'pick_id' =>$id,
                  'location'=>$locationupdate[$key],
                  'detail_location'=>$dtlocationupdate[$key],
                  'pick_phone'=>$phoneupdate[$key],
                  'detail_enable'=>1,
                ]);
            }
            /** End input varian */
          }

          //INSERT DETAIL
          $location  =input::get('location');
          $dtlocation =input::get('dtlocation');
          $phone   =input::get('phone');
          $stpoint  =input::get('stpoint');
          if(!empty($location)){
            foreach ($location as $key => $locations) {
                DB::table('tmp_pickup')->insert([
                  'pick_id' =>$id,
                  'location'=>$locations,
                  'detail_location'=>$dtlocation[$key],
                  'pick_phone'=>$phone[$key],
                  'detail_enable'=>1,

                ]);
            }
            /** End input varian */
          }
          //fungsi untuk sytem log
            // $logcontent ="Update data to access name($access), status($status) for Access ID $id";
            // $logtype ="User Access";
            // $loguser =Auth::user()->id;
            // $logdateTime=new DateTime();
            // $log=  Helper::userlog($logtype,$logcontent,$loguser,$logdateTime);
          //end userlog
          return redirect()->to('backend/pickup-point')->with('success-create','Thank you for Pickup Point Update!');
        }else{
          return Redirect()->back()->with('error','Sorry something is error !');
        }
      }
    }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
    }
  }


  public function deletePoint($id)
  {
    DB::table('tmp_pickup')
    ->where('id',$id)->delete();
    return redirect()->back()->with('success-delete','Your Point file has been deleted!');
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

        $i = DB::table('ms_pickup')->where('pick_id',$id)->delete();
        if($i > 0)
        {
          DB::table('tmp_pickup')->where('pick_id',$id)->delete();
          //fungsi untuk sytem log
                    // $logcontent ="Delete data for Access ID $id ";
                    // $logtype ="User Access";
                    // $loguser =Auth::user()->id;
                    // $logdateTime=new DateTime();
                    // $log=  Helper::userlog($logtype,$logcontent,$loguser,$logdateTime);
         //end userlog
           return redirect()->back()->with('success-delete','Your menu file has been deleted!');
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
