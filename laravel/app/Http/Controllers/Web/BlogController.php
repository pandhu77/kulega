<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use DB;
use Datetime;

use App\Http\Controllers\Controller;

class BlogController extends Controller{

    public function index(){
        $getsetting     = DB::table('t_theme_setting')->where('active',1)->first();
        $arrayreturn    = array('websetting' => $getsetting->name);

        $getpages   = DB::table('t_pages')->where('name','Blog')->first();
        $getsubmod  = json_decode($getpages->module);

        $arrayhtml      = array();
        $i              = 0;

        foreach ($getsubmod as $submod) {
            $mod        = DB::table('t_module')->where('id',$submod[0])->first();
            $submodule  = DB::table('t_module_detail')->where('id',$submod[1])->first();

            if (!empty($submodule->det_function)) {
                // ADD FUNCTION
                ${"var".$i} = DB::select(DB::raw($submodule->det_function));
                $returndata = array($submodule->det_return => ${"var".$i});
                $arrayreturn= array_merge($arrayreturn, $returndata);
            }

            // ADD HTML
            array_push($arrayhtml,$submodule->det_html);
            $i++;
        }

        $htmlreturn     = array('html' => $arrayhtml);
        $arrayreturn    = array_merge($arrayreturn, $htmlreturn);

        return view('themes.'.$getsetting->name.'.template.blog',$arrayreturn);
    }

    public function detail($url){
        $getsetting = DB::table('t_theme_setting')->where('active',1)->first();
        $getblog    = DB::table('cms_blog')->where('url',$url)->first();

        return view('themes.'.$getsetting->name.'.template.blog-detail',[
            'blog' => $getblog
        ]);
    }

}
