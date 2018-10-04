<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use DB;
use Datetime;

use App\Http\Controllers\Controller;
class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $now      = date('Y-m-d');
        $slider   = DB::table('cms_slider_home')->where('enable','=',1)->get();
        $categ    = DB::table('lk_product_category')->where('lk_product_category.kateg_parent','=','0')->where('kateg_enable','=',1)->get();
        $prod     = DB::table('ms_products')
                    ->join('tmp_product_image','tmp_product_image.prod_id','=','ms_products.prod_id')
                    ->where('ms_products.prod_enable','=',1)
                    ->where('ms_products.prod_enddate','>=',$now)
                    ->paginate(11);
        $brand    = DB::table('lk_brand')->where('brand_enable','=',1)->inRandomOrder()->paginate(2);
        $user     = DB::table('users')->get();
        $blog     = DB::table('cms_blog')->join('lk_blog_category','lk_blog_category.kateg_id','=','cms_blog.categ_id')->where('enable','=',1)->inRandomOrder()->paginate(3);
        $site     = DB::table('cms_config')->first();

        return view('home',[
            'slider'=> $slider,
            'categ' => $categ,
            'prod'  => $prod,
            'brand' => $brand,
            'blog'  => $blog,
            'user'  => $user,
            'site'  => $site,
        ]);
    }

    public function getBrand(){
        $brand= DB::table('lk_brand')->where('brand_enable','=',1)->get();

        return view('frontend.brands',[
          'brand'=>$brand,
        ]);
    }
    public function subscriberstore(){

        $checksubs = DB::table('cms_subscribers')->where('email',$_POST['email'])->count();
        if ($checksubs > 0) {
            return redirect()->back()->with('already-subs','Email Already Subscribe');
        }

        $insert = DB::table('cms_subscribers')->insert([
            'first_name'    => $_POST['first_name'],
            'last_name'     => $_POST['last_name'],
            'email'         => $_POST['email'],
        ]);

        if($insert){
            return redirect()->back()->with('success-subs','Successed Subscribe');
        }else{
            return redirect()->back()->with('fail-subs','Failed Subscribe');
        }

    }

}
