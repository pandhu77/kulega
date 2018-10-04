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
class BrandController extends Controller
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
          $brand=DB::table('lk_brand')->get();
          return view('backend.brand.index',[
            'brand'=>$brand,
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
            return view('backend.brand.create');
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

          if(!empty($request['enable'])){
            $enable=1;
          }else{
            $enable=0;
          }
          $status = $enable;
          $nilai=strlen(url(''));
          $len=$nilai+1;
          $image        =substr(Input::get('image'),$len);
          $banner        =substr(Input::get('brand_banner'),$len);
          $name         =Input::get('name');
          $url         =Input::get('brand_url');
          $now          = new DateTime();
          $userid= auth::user()->id;

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

              $insert = DB::table('lk_brand')->insert([
                'brand_name'=>$name,
                'brand_url'=>$url,
                'brand_logo'=>$image,
                'brand_banner'=>$banner,
                'brand_enable'  =>$status,
                'brand_created_at' =>$now,
                'brand_created_by'=>$userid
              ]);
              if($insert){
                return redirect()->to('backend/brand')->with('success-create','Thank you for brand add!');

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
          $row=DB::table('lk_brand')->where('brand_id','=',$id)->first();
          return view('backend.brand.edit',[
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
            $nilai=strlen(url(''));
            $len=$nilai+1;
            $image        =substr(Input::get('image'),$len);
            $banner        =substr(Input::get('brand_banner'),$len);
            $name         =Input::get('name');
            $url         =Input::get('brand_url');
            $now          = new DateTime();
            $userid= auth::user()->id;

            $update = DB::table('lk_brand')
            ->where('brand_id', $id)
            ->update([
                'brand_name'=>$name,
                'brand_url'=>$url,
                'brand_logo'=>$image,
                'brand_banner'=>$banner,
                'brand_enable'  =>$status,
                'brand_updated_at' =>$now,
                'brand_updated_by'=>$userid
            ]);

            if($update){
              return redirect()->to('backend/brand')->with('success-create','Thank you for brand Update!');
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

            $i = DB::table('lk_brand')->where('brand_id',$id)->delete();
            if($i > 0)
            {
               return redirect()->back()->with('success-delete','Your Brand file has been deleted!');
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
