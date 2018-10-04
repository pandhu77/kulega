<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use DB;

use App\Http\Controllers\Controller;

class PagesController extends Controller{

    public function getpage($url){
        $page = DB::table('cms_pages')->where('url','=',$url)->first();
        $getsetting = DB::table('t_theme_setting')->where('active',1)->first();
        if($page != "" || $page != null){

            return view('web.pages',[
                'page' => $page,
            ]);
        }
        else{
            return redirect('/');

        }
    }

}
