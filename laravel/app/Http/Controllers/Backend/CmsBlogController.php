<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Form;
use Auth;
use Session;
use Validator;
use Redirect;
use DB;
use Hash;
use Response;
use DateTime;
use Helper;

class CmsBlogController extends  Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index(){
    $auth = $this->CheckAuth();

    if($auth == true){
      $blog=DB::table('cms_blog')->orderBy('order_row','ASC')->get();
      $kateg=DB::table('lk_blog_category')->where('kateg_enable','=',1)->get();
      $user = DB::table('users')->get();
      return view('backend.blog.index',[
        'blog'=>$blog,
        'user'=>$user,
        'kateg'=>$kateg
      ]);
    }else{
      return Redirect::back()->withErrors(['msg', 'No Access']);
    }
  }
  public function create()
  {
    $auth = $this->CheckAuth();

    if($auth == true){
      $kateg=DB::table('lk_blog_category')->where('kateg_enable','=',1)->get();
      $blog = DB::table('cms_blog')->get();
      return view('backend.blog.create',[
        'blog'=>$blog,
        'kateg'=>$kateg
      ]);
    }else{
      return Redirect::back()->withErrors(['msg', 'No Access']);
    }
  }

  public function store(Request $request)
  {
    $auth = $this->CheckAuth();

    if($auth == true){

        $rules = array(
          'kateg'       => 'required',
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
            $enable=1;
          }else{
            $enable=0;
          }

          $status = $enable;
          $nilai=strlen(url(''));
          $len=$nilai+1;
          $image        =substr(Input::get('image'),$len);
          $id         =Input::get('pageid');
          $title         =Input::get('title');
          $url         =Input::get('url');
          $meta_desc         =Input::get('meta_desc');
          $kateg=Input::get('kateg');

          if(Input::get('meta_tag')!==null){
              $meta_tag       =implode(",",Input::get('meta_tag'));
          }else{
            $meta_tag=null;
          }

          $content         =Input::get('content');
          $now          = new DateTime();
          $userid= auth::user()->id;

          $store = DB::table('cms_blog')
          ->insert([
              'categ_id'=>$kateg,
              'enable'=>$status,
              'title'=>$title,
              'url'=>$url,
              'meta_desc'  =>$meta_desc,
              'tags'  =>$meta_tag,
              'content'  =>$content,
              'image'  =>$image,
              'created_at' =>$now,
              'post_date'=>$now,
              'created_by'=>$userid
          ]);

          if($store){
            return redirect()->to('backend/content')->with('success-create','Thank you for Content Add!');
          }else{
            return Redirect()->back()->with('error','Sorry something is error !');
          }
        }
    }else{
      return Redirect::back()->withErrors(['msg', 'Sorry, No Access']);
    }
  }


  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id){
    $auth = $this->CheckAuth();

    if($auth == true){
     $kateg=DB::table('lk_blog_category')->where('kateg_enable','=',1)->get();
      $row = DB::table('cms_blog')->where('blog_id','=',$id)->first();
      return view('backend.blog.edit',[
        'row' => $row,
        'kateg'=>$kateg
      ]);
    }else{
      return Redirect::back()->withErrors(['msg', 'No Access']);
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
          // 'id'       => 'required',
          'kateg'    =>'required',
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
            $enable=1;
          }else{
            $enable=0;
          }

          $status = $enable;
          $nilai=strlen(url(''));
          $len=$nilai+1;
          $image        =substr(Input::get('image'),$len);
          $title         =Input::get('title');
          $url         =Input::get('url');
          $meta_desc         =Input::get('meta_desc');
          $kateg=Input::get('kateg');


          if(Input::get('meta_tag')!==null){
              $meta_tag       =implode(",",Input::get('meta_tag'));
          }else{
            $meta_tag=null;
          }

          $content         =Input::get('content');
          $now          = new DateTime();
          $userid= auth::user()->id;
          $update = DB::table('cms_blog')
          ->where('blog_id', $id)
          ->update([
              'categ_id'=>$kateg,
              'enable'=>$status,
              'title'=>$title,
              'url'=>$url,
              'meta_desc'  =>$meta_desc,
              'tags'  =>$meta_tag,
              'content'  =>$content,
              'image'  =>$image,
              'updated_at' =>$now,
              'updated_by'=>$userid
          ]);

          if($update){
            return redirect()->to('backend/content')->with('success-update','Thank you for '.$title.' Update!');
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
          $i = DB::table('cms_blog')->where('blog_id',$id)->delete();
          if($i > 0)
          {
             return redirect()->to('backend/content')->with('success-delete','Your Page file has been deleted!');
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
