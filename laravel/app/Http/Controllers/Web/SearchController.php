<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use DB;
use Datetime;

use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function index(){
        $search         = Input::get('search');
        $getsetting     = DB::table('t_theme_setting')->where('active',1)->first();
        $arrayreturn    = array('websetting' => $getsetting->name);

        if (isset($search)) {
            $products   = DB::select(DB::raw('SELECT * FROM ms_products WHERE prod_enable = 1 AND prod_name LIKE "%'.$search.'%" ORDER BY prod_created_at DESC'));

            $returndata = array('productslist' => $products);
            $arrayreturn= array_merge($arrayreturn, $returndata);
            $arrayhtml  = array();

            array_push($arrayhtml,'product-list');
            $htmlreturn     = array('html' => $arrayhtml);
            $arrayreturn    = array_merge($arrayreturn, $htmlreturn);

            return view('themes.'.$getsetting->name.'.template.products',$arrayreturn);

        } else {

            $getpages   = DB::table('t_pages')->where('name','Products')->first();
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

            return view('themes.'.$getsetting->name.'.template.products',$arrayreturn);
        }
    }

    public function detail($url){
        $getsetting     = DB::table('t_theme_setting')->where('active',1)->first();

        $now        = date('Y-m-d');
        $products   = DB::table('ms_products')
                        ->where('prod_enable','=',1)
                        ->where('prod_enddate','>=',$now)
                        ->where('prod_url','=',$url)
                        ->first();

        if(count($products) >0){

            $image      = DB::table('tmp_product_image')->where('prod_id','=',$products->prod_id)->get();
            $allprod    = DB::table('ms_products')
                            ->where('prod_enable','=',1)
                            ->where('prod_enddate','>=',$now)
                            ->get();

            return view('themes.'.$getsetting->name.'.template.products-detail',[
                'products'  => $products,
                'image'     => $image,
                'allprod'   => $allprod
            ]);

        } else {
            return Redirect()->back()->with('error_get','Sorry, product is not available !');
        }
    }
}
