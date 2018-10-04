<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\Http\Controllers\Controller;
class BlogController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getblog()
    {
          $kateg=DB::table('lk_blog_category')->where('lk_blog_category.kateg_parent','=','0')->where('kateg_enable','=',1)->get();
          $user=DB::table('users')->get();
          $blog=DB::table('cms_blog')->where('enable','=',1)->get();
          return view('frontend.content.blog',[
              'kateg'=>$kateg,
              'blog'=>$blog,
              'user'=>$user
          ]);

    }
    public function getblogCategory($urlkateg)
    {

          $kateg=DB::table('lk_blog_category')->where('lk_blog_category.kateg_parent','=','0')->where('kateg_enable','=',1)->get();
          $user=DB::table('users')->get();
          $blog=DB::table('cms_blog')->join('lk_blog_category','lk_blog_category.kateg_id','=','cms_blog.categ_id')->where('enable','=',1)->where('kateg_url','=',$urlkateg)->get();
          return view('frontend.content.blog-category',[
              'kateg'=>$kateg,
              'blog'=>$blog,
              'user'=>$user,
              'urlkateg'=>$urlkateg
          ]);

    }
    public function getblogTags($urltag)
    {

          $kateg=DB::table('lk_blog_category')->where('lk_blog_category.kateg_parent','=','0')->where('kateg_enable','=',1)->get();
          $user=DB::table('users')->get();
          $blog=DB::table('cms_blog')->join('lk_blog_category','lk_blog_category.kateg_id','=','cms_blog.categ_id')->where('enable','=',1)->where('cms_blog.tags','like','%'.$urltag.'%')->get();
          return view('frontend.content.blog-tag',[
              'kateg'=>$kateg,
              'blog'=>$blog,
              'user'=>$user,
              'urltag'=>$urltag
          ]);

    }

    public function getblogdetail($kateg ,$url)
    {
          // $kateg=DB::table('lk_blog_category')->join('')->where('lk_blog_category.kateg_parent','=','0')->where('kateg_enable','=',1)->get();
          $user=DB::table('users')->get();
          $row=DB::table('cms_blog')->join('lk_blog_category','lk_blog_category.kateg_id','=','cms_blog.categ_id')->where('enable','=',1)->where('url','=',$url)->first();
          $blog=DB::table('cms_blog')->join('lk_blog_category','lk_blog_category.kateg_id','=','cms_blog.categ_id')->where('enable','=',1)->where('kateg_url','=',$kateg)->where('url','!=',$url)->get();
          $blogprevious=DB::table('cms_blog')->join('lk_blog_category','lk_blog_category.kateg_id','=','cms_blog.categ_id')->where('enable','=',1)->where('kateg_url','=',$kateg)->where('blog_id','<',$row->blog_id)->first();
          $blognext=DB::table('cms_blog')->join('lk_blog_category','lk_blog_category.kateg_id','=','cms_blog.categ_id')->where('enable','=',1)->where('kateg_url','=',$kateg)->where('blog_id','>',$row->blog_id)->first();

          DB::table('cms_blog')->where('url',$url)->update([
            'view'=>$row->view + 1,
          ]);
          return view('frontend.content.blog-detail',[
            'row'=>$row,
            'user'=>$user,
            'blog'=>$blog,
            'blognext'=>$blognext,
            'blogprevious'=>$blogprevious
          ]);

    }
}
