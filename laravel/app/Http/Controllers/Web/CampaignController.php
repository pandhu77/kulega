<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use DB;
use Datetime;
use Session;
use App\Http\Controllers\Controller;

class CampaignController extends Controller
{
    /*public function index(){

        // $base_url = $_SERVER['SERVER_NAME'];
        // if (stristr($base_url, 'beta') == false) {
        //     return view('web.coming-soon');
        // }

        $category       = Input::get('category');
        $view           = Input::get('view',20);
        $listcategory = DB::table('lk_campaign_category')->get();
        $searchcategory = DB::table('lk_campaign_category')->where('kateg_url',$category)->first();
        $banners        = DB::table('cms_banner')->where('enable',1)->get();

        if (count($searchcategory) == 1 || $searchcategory == 'all') {
            if ($view == 'all') {
                $products = DB::table('lk_campaign')->join('lk_campaign_category', 'lk_campaign_category.kateg_id', '=', 'lk_campaign.parent')->where('enable',1)->where('parent', $searchcategory->kateg_id)->Orderby('created_at','DESC')->paginate(1000)->setPath('campaign?category='.$category);
            }else {
                $products = DB::table('lk_campaign')->join('lk_campaign_category', 'lk_campaign_category.kateg_id', '=', 'lk_campaign.parent')->where('enable',1)->where('parent', $searchcategory->kateg_id)->Orderby('created_at','DESC')->paginate($view)->setPath('campaign?category='.$category);
            }

            $countall     = DB::table('lk_campaign')->join('lk_campaign_category', 'lk_campaign_category.kateg_id', '=', 'lk_campaign.parent')->where('enable',1)->where('parent', $searchcategory->kateg_id)->count();
        } else {
            if ($view == 'all') {
                $products = DB::table('lk_campaign')->join('lk_campaign_category', 'lk_campaign_category.kateg_id', '=', 'lk_campaign.parent')->where('enable',1)->paginate(1000);
            }else {
                $products = DB::table('lk_campaign')->join('lk_campaign_category', 'lk_campaign_category.kateg_id', '=', 'lk_campaign.parent')->where('enable',1)->paginate($view);
            }

            $countall     = DB::table('lk_campaign')->join('lk_campaign_category', 'lk_campaign_category.kateg_id', '=', 'lk_campaign.parent')->where('enable',1)->count();
            $category     = 'all';
        }

        return view('web.campaign',[
            'banners'   => $banners,
            'category'  => $category,
            'listcategory'  => $listcategory,
            'view'      => $view,
            'products'  => $products,
            'countall'  => $countall
        ]);
    }*/

    public function index(){

        $search         = Input::get('search');
        $category       = Input::get('category');
        $view           = Input::get('view',12);
        $searchcategory = DB::table('lk_campaign_category')->where('kateg_url',$category)->first();
        $banners        = DB::table('cms_banner')->where('enable',1)->get();
        $allcategory    = DB::table('lk_campaign_category')->where('kateg_enable',1)->get();

        if (isset($search)) {
          $products = DB::table('lk_campaign')->join('ms_members','ms_members.member_id','=','lk_campaign.memberid')->where('enable',1)->where('name','LIKE','%'.$search.'%')->paginate($view);
          $countall = DB::table('lk_campaign')->join('ms_members','ms_members.member_id','=','lk_campaign.memberid')->where('enable',1)->where('name','LIKE','%'.$search.'%')->count();

          return view('web.products',[
            'banners'   => $banners,
            'category'  => $category,
            'view'      => $view,
            'products'  => $products,
            'countall'  => $countall,
            'allcategory' => $allcategory
          ]);

        }

        // if (count($searchcategory) == 1 || $searchcategory == 'all') {
        //     if ($view == 'all') {
        //         $products = DB::table('ms_products')->where('enable',1)->where('category','LIKE','%'.$searchcategory->kateg_id.'%')->Orderby('order','ASC')->paginate(1000)->setPath('products?category='.$category);
        //     }else {
        //         $products = DB::table('ms_products')->where('enable',1)->where('category','LIKE','%'.$searchcategory->kateg_id.'%')->Orderby('order','ASC')->paginate($view)->setPath('products?category='.$category);
        //     }
        //
        //     $countall     = DB::table('ms_products')->where('enable',1)->where('category','LIKE','%'.$searchcategory->kateg_id.'%')->count();
        // } else {
        if ($view == 'all') {
            $products = DB::table('lk_campaign')->join('ms_members','ms_members.member_id','=','lk_campaign.memberid')->join('lk_campaign_category', 'lk_campaign_category.kateg_id', '=', 'lk_campaign.parent')->where('enable',1)->paginate(1000);
        }else {
            $products = DB::table('lk_campaign')->join('ms_members','ms_members.member_id','=','lk_campaign.memberid')->join('lk_campaign_category', 'lk_campaign_category.kateg_id', '=', 'lk_campaign.parent')->where('enable',1)->paginate($view);
        }

        $countall     = DB::table('lk_campaign')->join('ms_members','ms_members.member_id','=','lk_campaign.memberid')->join('lk_campaign_category', 'lk_campaign_category.kateg_id', '=', 'lk_campaign.parent')->where('enable',1)->count();

        if (!isset($category) || $category == 'all') {
          $category     = 'all';
        }

        // }

        return view('web.campaign',[
            'banners'   => $banners,
            'category'  => $category,
            'view'      => $view,
            'products'  => $products,
            'countall'  => $countall,
            'allcategory' => $allcategory
        ]);
    }

    public function detail($url){

        Session::forget('orderid1');
        Session::forget('voucher_code');
        Session::forget('voucher_type');
        Session::forget('voucher_value');
        Session::forget('idcampaign');

        $category       = Input::get('category');
        $banners        = DB::table('cms_banner')->where('enable',1)->get();
        $getsetting     = DB::table('t_theme_setting')->where('active',1)->first();

        $now        = date('Y-m-d');
        $products   = DB::table('lk_campaign')
                        ->join('lk_campaign_category', 'lk_campaign_category.kateg_id', '=', 'lk_campaign.parent')
                        ->where('enable','=',1)
                        ->where('url','=',$url)
                        ->first();

        if(count($products) > 0){
            Session::set('idcampaign',$products->id);

            /*$images     = DB::table('tmp_product_image')->where('id','=',$products->id)->get();
            $varcolor   = DB::table('ms_product_varian')->where('id',$products->id)->groupBy('varian_color')->get();
            $varsize    = DB::table('ms_product_varian')->where('id',$products->id)->groupBy('varian_size')->get();
            $allprod    = DB::table('lk_campaign')
                            ->join('lk_campaign_category', 'lk_campaign_category.kateg_id', '=', 'lk_campaign.parent')
                            ->where('enable','=',1)
                            ->get();*/

            return view('web.campaign-detail',[
                'banners'   => $banners,
                'category'  => $category,
                'campaign'  => $products,
                //'images'    => $images,
                //'campaign'   => $allprod
                //'varcolor'  => $varcolor,
                //'varsize'   => $varsize
            ]);

        } else {
            return Redirect()->back()->with('error_get','Sorry, product is not available !');
        }
    }
}
