<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\Http\Controllers\Controller;
class PageController extends Controller
{
    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */

    public function getpage($url)
    {


        $page=DB::table('cms_pages')->where('url','=',$url)->where('enable','=',1)->first();
        $menu=DB::table('cms_menu')->where('status_menu','=',1)->get();

        if(count($page)>0){
            $care=null;
            return view('frontend.page',[
                'page'=>$page,
                'care'=>$care,
                'menu'=>$menu
            ]);
        }else{
            if($url=='customer-care'){
                $care=DB::table('cms_customer_care')->get();
                $page=null;
                return view('frontend.page',[
                    'page'=>$page,
                    'care'=>$care,
                    'menu'=>$menu
                ]);
            }else{
                return Redirect()->back();
            }
        }
    }
}
