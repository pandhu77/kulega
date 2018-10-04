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
class CmsPageController extends Controller
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

    public function index(){
      $auth = $this->CheckAuth();

      if($auth == true){
        $page   = DB::table('cms_pages')->get();
        $pagefix= DB::table('t_pages')->get();
        return view('backend.cms-page.index',[
          'page'    => $page,
          'pagefix' => $pagefix
        ]);
      }else{
        return Redirect::back()->withErrors(['msg', 'No Access']);
      }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $auth = $this->CheckAuth();
      if($auth == true){
          return view('backend.cms-page.create',[]);
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
    public function store(Request $request)
    {
      $auth = $this->CheckAuth();

      if($auth == true){

          $rules = array(
            'url'   => 'required',
            'title' => 'required',
          );
          $validator = Validator::make(Input::all(), $rules);

          if ($validator->fails()) {
            return Redirect::to('nerds/' . $id . '/edit')
            ->withErrors($validator)
            ->withInput(Input::except('password'));
          } else {

            if(!empty($request['enable'])){
              $enable = 1;
            }else{
              $enable = 0;
            }

            $status     = $enable;
            $nilai      = strlen(url(''));
            $len        = $nilai+1;
            $image      = substr(Input::get('image'),$len);
            $id         = Input::get('pageid');
            $title      = Input::get('title');
            $url        = Input::get('url');
            $meta_desc  = Input::get('meta_desc');


            if(Input::get('meta_tag')!==null){
                $meta_tag = implode(",",Input::get('meta_tag'));
            }else{
                $meta_tag = null;
            }

            $content    = Input::get('content');
            $now        = new DateTime();
            $userid     = auth::user()->id;

            $store = DB::table('cms_pages')->insert([
                'enable'    => $status,
                'title'     => $title,
                'url'       => $url,
                'meta_desc' => $meta_desc,
                'meta_tag'  => $meta_tag,
                'content'   => $content,
                'image'     => $image,
                'created_at'=> $now,
                'created_by'=> $userid
            ]);

            return redirect()->to('backend/page')->with('success-create','Thank you for '.$title.' page create!');
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
    public function edit($id)
    {
      $auth = $this->CheckAuth();
      if($auth == true){
          $page=DB::table('cms_pages')->where('id','=',$id)
                ->first();
          return view('backend.cms-page.edit',[
            'page'=>$page,
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
    public function update(Request $request)
    {
        $auth = $this->CheckAuth();

        if($auth == true){

            $rules = array(
              'url'       => 'required',
              'title'      => 'required',
            );
            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
              return Redirect::to('nerds/' . $id . '/edit')
              ->withErrors($validator)
              ->withInput(Input::except('password'));
            } else {

              if(!empty($request['enable'])){
                $enable = 1;
              }else{
                $enable = 0;
              }

              $status   = $enable;
              $nilai    = strlen(url(''));
              $len      = $nilai+1;
              $image    = substr(Input::get('image'),$len);
              $id       = Input::get('pageid');
              $title    = Input::get('title');
              $url      = Input::get('url');
              $meta_desc= Input::get('meta_desc');

              if(Input::get('meta_tag')!==null){
                  $meta_tag = implode(",",Input::get('meta_tag'));
              }else{
                  $meta_tag = null;
              }

              $content  = Input::get('content');
              $now      = new DateTime();
              $userid   = auth::user()->id;

              $update = DB::table('cms_pages')->where('id',$id)->update([
                  'enable'      => $status,
                  'title'       => $title,
                  'url'         => $url,
                  'meta_desc'   => $meta_desc,
                  'meta_tag'    => $meta_tag,
                  'content'     => $content,
                  'image'       => $image,
                  'updated_at'  => $now,
                  'updated_by'  => $userid
              ]);

              return redirect()->to('backend/page')->with('success-update','Thank you for '.$title.' Update!');
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
              $i = DB::table('cms_pages')->where('id',$id)->delete();
              if($i > 0)
              {
                 $deletemenu = DB::table('cms_menu')->where('parent','=',$id)->delete();
                 return redirect()->back()->with('success-delete','Your Page file has been deleted!');
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
          if(substr($menus->url,0, 12)== $url){
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
