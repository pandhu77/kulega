<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facedes\Redirect;
use Helper;
use DB;
use Datetime;
class ProductController extends Controller
{

      public function searchProduct(Request $request){
        $date= new Datetime();
        $now=$date->format('Y-m-d');
        $prod=input::get('q');
        $categ=DB::table('lk_product_category')
                  ->where('kateg_parent','=',0)
                  ->where('kateg_enable','=',1)
                  ->get();
        $categall=DB::table('lk_product_category')
                  // ->where('kateg_parent','=',0)
                  ->where('kateg_enable','=',1)
                  ->get();

        $categparent=DB::table('lk_product_category')
                  // ->where('kateg_parent','=',$categ->kateg_id)
                  ->where('kateg_enable','=',1)->get();
        $categparent2=DB::table('lk_product_category')
                  ->where('kateg_enable','=',1)->get();

        $prod=DB::table('ms_products')
                ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
                ->where('ms_products.prod_enable','=',1)
                 ->where('ms_products.prod_enddate','>=',$now)
                ->where('ms_products.prod_name','like','%'.$prod.'%')
                ->orWhere('ms_products.prod_title','like','%'.$prod.'%')
                ->where('ms_products.prod_enable','=',1)
                ->where('ms_products.prod_enddate','>=',$now)
                ->get();
        $prodmodal=DB::table('ms_products')
                ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
                ->where('ms_products.prod_enable','=',1)
                ->where('ms_products.prod_name','like','%'.$prod.'%')
                ->orWhere('ms_products.prod_title','like','%'.$prod.'%')
                ->where('ms_products.prod_enddate','>=',$now)
                ->where('ms_products.prod_enddate','>=',$now)
               ->where('ms_products.prod_name','like','%'.$prod.'%')
                ->where('ms_products.prod_enable','=',1)
                ->get();


              // var_dump($prod->prod_id);
        $brand=DB::table('lk_brand')->get();
          return view('frontend.all-product',[
            'prodmodal'=>$prodmodal,
            'categ'=>$categ,
            'categall'=>$categall,
            'prod'=>$prod,
            'categparent'=>$categparent,
            'categparent2'=>$categparent2,
            'brand'=>$brand,
          ]);
      }
    public function getproductall(){
      $date= new Datetime();
      $now=$date->format('Y-m-d');
      $categ=DB::table('lk_product_category')
                ->where('kateg_parent','=',0)
                ->where('kateg_enable','=',1)

                ->get();
      $categall=DB::table('lk_product_category')
                // ->where('kateg_parent','=',0)
                ->where('kateg_enable','=',1)
                ->get();

      $categparent=DB::table('lk_product_category')
                // ->where('kateg_parent','=',$categ->kateg_id)
                ->where('kateg_enable','=',1)->get();
      $categparent2=DB::table('lk_product_category')
                ->where('kateg_enable','=',1)->get();

      $prod=DB::table('ms_products')
              ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
              ->where('ms_products.prod_enable','=',1)
              ->where('ms_products.prod_enddate','>=',$now)

              ->get();
      $prodmodal=DB::table('ms_products')
              ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
              ->where('ms_products.prod_enable','=',1)
               ->where('ms_products.prod_enddate','>=',$now)
              ->get();


            // var_dump($prod->prod_id);
      $brand=DB::table('lk_brand')->get();
        return view('frontend.all-product',[
          'prodmodal'=>$prodmodal,
          'categ'=>$categ,
          'categall'=>$categall,
          'prod'=>$prod,
          'categparent'=>$categparent,
          'categparent2'=>$categparent2,
          'brand'=>$brand,
        ]);
    }

    /* BEGIN GET AJAX TOTOAL */

    public function ajaxgettotal(){
      $date= new Datetime();
      $now=$date->format('Y-m-d');
      $prodid=input::get('prodid');
      $qty=input::get('qty');
      $kategid=input::get('kategid');
      $prod=DB::table('ms_products')->where('ms_products.prod_enable','=',1) ->where('ms_products.prod_enddate','>=',$now)->where('prod_id','=',$prodid)->first();
      if($kategid =='other'){
        $categall=DB::table('lk_product_category')
                  ->where('kateg_enable','=',1)
                  ->get();
          foreach ($categall as  $categs) {
            if(in_array($categs->kateg_id,explode(',',$prod->prod_category))){
                $result=Helper::check_dicount_catalog($prod->prod_id,$categs->kateg_id,$prod->prod_brand_id,$prod->prod_price);
                $total= $result['total'];
                $disc= $result['disc'];
                if( $disc > 0){
                  $totalitem = $total * $qty;
                }else{
                  $totalitem =$prod->prod_price * $qty;
                }
                if( $total > 0 and $disc > 0 ){
                  break;
                }
           }
          }
      }else{
            $result=Helper::check_dicount_catalog($prod->prod_id,$kategid,$prod->prod_brand_id,$prod->prod_price);
            $total= $result['total'];
            $disc= $result['disc'];

            if( $disc > 0){
                $totals = $total;
            }else{
                $totals =$prod->prod_price;
            }
                $totalitem= $totals * $qty;
      }

        echo " Total <span class='pull-right price_format'>".$totalitem."</span>";
    }

    /* BEGIN GET PRODUCT WHERE CATEGORY */
    public function getproductcateg($url){
      $date= new Datetime();
      $now=$date->format('Y-m-d');
      $categ=DB::table('lk_product_category')
                ->where('kateg_url','=',$url)
                ->where('kateg_enable','=',1)
                ->first();
      $categparent=DB::table('lk_product_category')
                // ->where('kateg_parent','=',$categ->kateg_id)
                ->where('kateg_enable','=',1)->get();
      $categparent2=DB::table('lk_product_category')
                ->where('kateg_enable','=',1)->get();

      $prod=DB::table('ms_products')
              ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
               ->where('ms_products.prod_enddate','>=',$now)
              ->where('ms_products.prod_enable','=',1)
              ->get();
      $prodmodal=DB::table('ms_products')
              ->where('ms_products.prod_enable','=',1)
               ->where('ms_products.prod_enddate','>=',$now)
              ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
              ->get();
      $brand=DB::table('lk_brand')->get();
        return view('frontend.product',[
          'prodmodal'=>$prodmodal,
          'categ'=>$categ,
          'prod'=>$prod,
          'categparent'=>$categparent,
          'categparent2'=>$categparent2,
          'brand'=>$brand,
          'categurl'=>$url,
        ]);
    }
    /*END */

    public function getproductbrand($url){
      $date= new Datetime();
      $now=$date->format('Y-m-d');
      $categ=DB::table('lk_product_category')
                ->where('kateg_parent','=',0)
                ->where('kateg_enable','=',1)
                ->get();
      $categall=DB::table('lk_product_category')
                // ->where('kateg_parent','=',0)
                ->where('kateg_enable','=',1)
                ->get();

      $categparent=DB::table('lk_product_category')
                // ->where('kateg_parent','=',$categ->kateg_id)
                ->where('kateg_enable','=',1)->get();
      $categparent2=DB::table('lk_product_category')
                ->where('kateg_enable','=',1)->get();

      $prod=DB::table('ms_products')
              ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
              ->where('ms_products.prod_enable','=',1)
             ->where('ms_products.prod_enddate','>=',$now)
              ->where('lk_brand.brand_url','=',$url)
              ->get();
      $prodmodal=DB::table('ms_products')
              ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
              ->where('ms_products.prod_enddate','>=',$now)
              ->where('ms_products.prod_enable','=',1)
              ->get();


            // var_dump($prod->prod_id);
      $brand=DB::table('lk_brand')->where('brand_url','=',$url)->get();
      $brandname=DB::table('lk_brand')->where('brand_url','=',$url)->first();
        return view('frontend.brand-product',[
          'prodmodal'=>$prodmodal,
          'categ'=>$categ,
          'brandurl'=>$url,
          'categall'=>$categall,
          'prod'=>$prod,
          'categparent'=>$categparent,
          'categparent2'=>$categparent2,
          'brand'=>$brand,
          'brandname'=>$brandname,
          'urlbrand'=>$url,
        ]);
    }

    public function getproductbrandcateg($url,$categurl){
      $date= new Datetime();
      $now=$date->format('Y-m-d');
      $categ=DB::table('lk_product_category')
                ->where('kateg_url','=',$categurl)
                ->where('kateg_enable','=',1)
                ->first();
      $categparent=DB::table('lk_product_category')
                // ->where('kateg_parent','=',$categ->kateg_id)
                ->where('kateg_enable','=',1)->get();
      $categparent2=DB::table('lk_product_category')
                ->where('kateg_enable','=',1)->get();

      $prod=DB::table('ms_products')
              ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
              ->where('ms_products.prod_enable','=',1)
              ->where('ms_products.prod_enddate','>=',$now)
              ->where('lk_brand.brand_url','=',$url)
              ->get();
      $prodmodal=DB::table('ms_products')
              ->where('ms_products.prod_enable','=',1)
              ->where('ms_products.prod_enddate','>=',$now)
              ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
              ->get();
      $brand=DB::table('lk_brand')->where('brand_url','=',$url)->get();
      $brandname=DB::table('lk_brand')->where('brand_url','=',$url)->first();
        return view('frontend.brand-prod-categ',[
          'prodmodal'=>$prodmodal,
          'categurl'=>$categurl,
          'categ'=>$categ,
          'prod'=>$prod,
          'categparent'=>$categparent,
          'categparent2'=>$categparent2,
          'brand'=>$brand,
          'brandname'=>$brandname,
          'categurl'=>$categurl,
        ]);
    }

    /* BEGIN PRODUCT DETAIL */
    public function getproductdetail($url){
      $date= new Datetime();
      $now=$date->format('Y-m-d');
      $chekprod=DB::table('ms_products')
              ->join('tmp_product_image','tmp_product_image.prod_id','=','ms_products.prod_id')
              ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
              ->where('ms_products.prod_enable','=',1)
              ->where('ms_products.prod_enddate','>=',$now)
              // ->where('ms_products.prod_stock','>',0)
              ->where('ms_products.prod_url','=',$url)->first();

        if(count($chekprod) >0){

          /* Product Varian */
          if($chekprod->prod_var_status ==1){
            $prod=DB::table('ms_products')
                    ->join('tmp_product_image','tmp_product_image.prod_id','=','ms_products.prod_id')
                    ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
                    ->where('ms_products.prod_enable','=',1)
                    ->where('ms_products.prod_enddate','>=',$now)
                    ->where('ms_products.prod_id','=',$chekprod->prod_id)
                    ->first();

            $variansize=DB::table('ms_product_varian')
                    ->where('ms_product_varian.prod_id','=',$chekprod->prod_id)

                    ->groupBy('varian_size')
                    ->get();
            $variancolor=DB::table('ms_product_varian')
                    ->where('ms_product_varian.prod_id','=',$chekprod->prod_id)
                    ->groupBy('varian_color')
                    ->get();
            $varianstock=DB::table('ms_product_varian')
                    ->where('ms_product_varian.prod_id','=',$chekprod->prod_id)
                    ->groupBy('varian_stock')
                    ->get();

            $prodimage= DB::table('tmp_product_image')
                       ->where('prod_id','=',$prod->prod_id)->get();
          /* End Product Varian */
          /* Product no Varian */
          }else{

            $prod=DB::table('ms_products')
                    ->join('tmp_product_image','tmp_product_image.prod_id','=','ms_products.prod_id')
                    ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
                    ->where('ms_products.prod_enable','=',1)
                    ->where('ms_products.prod_enddate','>=',$now)
                    // ->where('ms_products.prod_stock','>',0)
                    ->where('ms_products.prod_url','=',$url)->first();
            $prodimage= DB::table('tmp_product_image')
                       ->where('prod_id','=',$prod->prod_id)->get();
            $variansize=null;
            $variancolor=null;
            $varianstock=null;
          }

          if(count($prod) >0){
            $relatedprod=DB::table('ms_products')
                    ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
                    ->where('ms_products.prod_enddate','>=',$now)
                    // ->where('ms_products.prod_id','!=',$prod->prod_id)
                    ->where('ms_products.prod_enable','=',1)
                    ->get();
          }else{
            $relatedprod==null;
          }
          $categall=DB::table('lk_product_category')
                    ->where('kateg_enable','=',1)
                    ->get();

          /* End Product no Varian */
          return view('frontend.product-detail',[
              'prod'=>$prod,
              'variansize'=>$variansize,
              'variancolor'=>$variancolor,
              'varianstock'=>$varianstock,
              'prodimage'=>$prodimage,
              'relatedprod'=>$relatedprod,
              'categall'=>$categall,

          ]);
        }else {
          return Redirect()->back()->with('error_get','Sorry, product is not available !');
        }

   }
    /* END*/
}
