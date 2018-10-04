<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use DB;
use Datetime;
use Session;
use Vinkla\Instagram\Facades\Instagram;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        // $base_url = $_SERVER['SERVER_NAME'];
        // if (stristr($base_url, 'beta') == false) {
        //     return view('web.coming-soon');
        // }

        Session::put('validate','validate');
        Session::set('validate','validate');

        // echo Session::get('validate');
        // exit;

        $getslider  = DB::table('cms_slider_home')->where('enable',1)->get();
        $getproducts= DB::table('ms_products')->where('prod_enable',1)->orderBy('prod_created_at','DESC')->take(8)->get();
        $getbanner  = DB::table('cms_banner')->where('enable',1)->get();
        $getinsta   = DB::table('t_module_options')->where('module','instagram')->first();
        $getcate    = DB::table('lk_product_category')->where('kateg_enable',1)->where('kateg_show',1)->get();

        if (empty($getinsta->value)) {
            $instausername = $getinsta->default_value;
        }else {
            $instausername = $getinsta->value;
        }

        // $test   = @file_get_contents('https://www.instagram.com/'.$instausername.'/?__a=1');
        //
        // if ($test == false) {
        //     $items  = 'gagal bray';
        // }else {
        //     $decode = json_decode($test);
        //     $items  = $decode->graphql->user;
        // }

        $response   = Instagram::users()->getMedia('self');
        $instagrams = json_encode($response->get());
        $items      = json_decode($instagrams);

        // dd($items);

        return view('web.home',[
            'slider'    => $getslider,
            'products'  => $getproducts,
            'banners'   => $getbanner,
            'instagram' => $items,
            'category'  => $getcate
        ]);
    }

    public function test(){
        $getpages   = DB::table('t_pages')->where('name','Home')->first();
        $getsetting = DB::table('t_theme_setting')->where('active',1)->first();
        $getsubmod  = json_decode($getpages->module);

        $arrayreturn    = array('websetting' => $getsetting->name);
        $arrayhtml      = array();
        $i              = 0;

        foreach ($getsubmod as $submod) {
            $mod        = DB::table('t_module')->where('id',$submod[0])->first();
            $submodule  = DB::table('t_module_detail')->where('id',$submod[1])->first();

            if (!empty($mod->m_function)) {
                // ADD FUNCTION
                ${"var".$i} = DB::select(DB::raw($mod->m_function));
                $returndata = array($submodule->det_return => ${"var".$i});
                $arrayreturn= array_merge($arrayreturn, $returndata);
            }

            // ADD HTML
            array_push($arrayhtml,$submodule->det_html);
            $i++;
        }

        $htmlreturn     = array('html' => $arrayhtml);
        $arrayreturn    = array_merge($arrayreturn, $htmlreturn);

        // dd($arrayreturn);

        return view('themes.'.$getsetting->name.'.template.test',$arrayreturn);

    }

    public function thankyou($id){
        return view('web.thank-you',[
            'orderid' => $id
        ]);
    }

    public function getBrand(){
        $brand= DB::table('lk_brand')->where('brand_enable','=',1)->get();

        return view('frontend.brands',[
          'brand'=>$brand,
        ]);
    }
    public function subscriberstore(){
        $email=input::get('msg_email');
        $insert=DB::table('cms_subscribers')->insert([
            'email'=>$email,
        ]);
        if($insert){
            return redirect()->back()->with('success-send','Thank you, email send!');
        }else{
            return redirect()->back()->with('errol-send','Sorry, email not send!');
        }

    }

}
