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
use PHPMailer;
use Session;

class CmsConfigController extends Controller
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
    public function edit()
    {
      $auth = $this->CheckAuth();
      if($auth == true){

          $row=DB::table('cms_config')
                ->first();
          $care=DB::table('cms_customer_care')
                ->get();

            Session::set('origin_province',$row->origin_province);
            Session::set('origin_city',$row->origin);

          return view('backend.site-config',[
            'row'=>$row,
            'care'=>$care,
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
    public function updatecontact(Request $request)
    {
      $auth = $this->CheckAuth();

      if($auth == true){

          $rules = array(
            // 'id'       => 'required',
            'site_name'       => 'required',
            'domain'      => 'required',
            'email'      => 'required',
            'telp'      => 'required',
            'address'      => 'required',
          );
          $validator = Validator::make(Input::all(), $rules);

          if ($validator->fails()) {
            return Redirect::back()
            ->withErrors($validator)
            ->withInput(Input::except('password'));
          } else{
            $now          = new DateTime();
            $userid= auth::user()->id;



            $update = DB::table('cms_config')
            ->update([
                'site_name'=>Input::get('site_name'),
                'domain'=>Input::get('domain'),
                'email'  =>Input::get('email'),
                'telp'  =>Input::get('telp'),
                'pax'  =>Input::get('pax'),
                'address'  =>Input::get('address'),
                'updated_at' =>$now,
                'updated_by'=>$userid
            ]);

            /** End input detail cms_customer_care */

            /** Begin input cms_customer_care  */
            $emailcare   =input::get('emailcare');
            $phonecare  =input::get('phonecare');
            $addresscare  =input::get('addresscare');
            $notecare   =input::get('notecare');
            DB::table('cms_customer_care')->delete();
            if(!empty($emailcare)){
              foreach ($emailcare as $key => $email) {
                  DB::table('cms_customer_care')->insert([
                    'care_email'=>$email,
                    'care_phone'=>$phonecare[$key],
                    'care_address'=>$addresscare[$key],
                    'care_note'=>$notecare[$key],
                    'updated_at'=>$now,
                  ]);
              }
              /** End input varian */
            }

            if($update){
              return redirect()->to('backend/site-config#contact')->with('success','Thank you for config update!');
            }else{
              return Redirect()->to('backend/site-config#contact')->with('errors-data','Sorry something is error !');
            }
          }
      }else{
        return Redirect::back()->withErrors(['msg', 'Sorry, No Access']);
      }
    }
    public function updatesite(Request $request)
    {
      $auth = $this->CheckAuth();

      if($auth == true){

          $rules = array(
            // 'id'       => 'required',
            // 'image_header_home'       => 'required',
            // 'title_product'      => 'required',
            // 'title_brand'      => 'required',
            // 'title_blog'      => 'required',
            // 'image_header_product'      => 'required',
          );
          $validator = Validator::make(Input::all(), $rules);

          if ($validator->fails()) {
            return Redirect::back()
            ->withErrors($validator)
            ->withInput(Input::except('password'));
          } else{
            $now          = new DateTime();
            $userid= auth::user()->id;

            $nilai=strlen(url(''));
            $len=$nilai+1;
            $update = DB::table('cms_config')
            ->update([
                'origin_province'=>Input::get('province'),
                'origin'=>Input::get('city'),
                'logo'=>substr(Input::get('logo'),$len),
                'meta'=>Input::get('meta'),
                // 'image_header_home'=>substr(Input::get('image_header_home'),$len),
                'title_product'=>Input::get('title_product'),
                'title_brand'  =>Input::get('title_brand'),
                'title_blog'  =>Input::get('title_blog'),

                // 'image_header_product'  =>substr(Input::get('image_header_product'),$len),
                'last_update' =>$now,
                'updated_by'=>$userid
            ]);

            if($update){
              return redirect()->to('backend/site-config#site')->with('success2','Thank you for config update!');
            }else{
              return Redirect()->to('backend/site-config#site')->with('errors-data2','Sorry something is error !');
            }
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
