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
class AjaxProductController extends Controller
{
    /* BEGIN AJAX GET PRODUCT SCROLLING*/
      // public function ScrollingProduct($key){
      //   $categ=input::get("categ");
      //
      //
      //   $date= new Datetime();
      //   $now=$date->format('Y-m-d');
      //   $categ=DB::table('lk_product_category')
      //             ->where('kateg_url','=',$categ)
      //             ->where('kateg_enable','=',1)
      //             ->first();
      //   $prod=DB::table('ms_products')
      //           ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
      //            ->where('ms_products.prod_enddate','>=',$now)
      //           ->where('ms_products.prod_enable','=',1)
      //           ->get();
      //
      // }
      /* BEGIN AJAX GET VARIAN COLOR*/
      public function getvariancolor(){
        $prodid=input::get('prodid');
        $size=input::get('size');
        $variancolor=DB::table('ms_product_varian')
                ->where('ms_product_varian.prod_id','=',$prodid)
                ->where('ms_product_varian.varian_size','=',$size)
                ->groupBy('varian_color')
                ->where('ms_product_varian.varian_color','!=','')
                ->get();
          if(count($variancolor)>0){
            echo '<div class="detail-order" required>
                Multicolor
                <select name="color" id="" required>
                    <option value="" selected disabled> Choose</option>';
                    foreach($variancolor as $color){
                      if($color ->varian_color !== ''){
                            echo '  <option value="'.$color->varian_color.'">'.$color->varian_color.' </option>';
                      }else{
                            echo '  <option value="'.$color->varian_color.'">No Color</option>';
                      }

                    }
              echo ' </select>
             </div>';
          }else{
            '<input type="text" name="color" value="">';
          }


      }
      /* AJAX GET SORT PRODUCT */
      public function sortProduct(){
        $token=csrf_token();
        $brand = explode(',', Input::get('allVals'));
        $kateg =input::get('kategid');
        $price = explode(';',Input::get('price'));
        $kateg =input::get('kategid');
        $minPrice = (int)$price[0];
        $maxPrice = (int)$price[1];
        $sort=input::get('sort');

        $appurl=urldomain();
        $categall=DB::table('lk_product_category')
                  ->where('kateg_enable','=',1)
                  ->get();
        $item=0;
          foreach ($brand as $brand1) {

              if ($sort=='lowest') {
                $produk = DB::table('ms_products')
                    // ->join('tmp_product_image','tmp_product_image.prod_id','=','ms_products.prod_id')
                    ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
                    ->where('prod_brand_id', $brand1)
                    ->where('ms_products.prod_enable','=',1)
                    ->orderBy('ms_products.prod_price','asc')
                    ->get();
              }elseif ($sort=='high') {
                $produk = DB::table('ms_products')
                    // ->join('tmp_product_image','tmp_product_image.prod_id','=','ms_products.prod_id')
                    ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
                    ->where('ms_products.prod_enable','=',1)
                    ->where('prod_brand_id', $brand1)
                    ->orderBy('ms_products.prod_price','desc')
                    ->get();

              }elseif ($sort=='newst') {
                $produk = DB::table('ms_products')
                    // ->join('tmp_product_image','tmp_product_image.prod_id','=','ms_products.prod_id')
                    ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
                    ->where('ms_products.prod_enable','=',1)
                    ->where('prod_brand_id', $brand1)
                    ->orderBy('ms_products.prod_created_at','desc')
                    ->get();

              }else{
                $produk = DB::table('ms_products')
                    // ->join('tmp_product_image','tmp_product_image.prod_id','=','ms_products.prod_id')
                    ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
                    ->where('ms_products.prod_enable','=',1)
                    ->where('prod_brand_id', $brand1)
                    ->get();
              }

              if($brand1==null ){
                if ($sort=='lowest') {
                  $produk = DB::table('ms_products')
                          // ->join('tmp_product_image','tmp_product_image.prod_id','=','ms_products.prod_id')
                          ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
                          ->where('ms_products.prod_enable','=',1)
                          ->orderBy('ms_products.prod_price','ASC')
                          ->get();
                }elseif ($sort=='high') {
                  $produk = DB::table('ms_products')
                          // ->join('tmp_product_image','tmp_product_image.prod_id','=','ms_products.prod_id')
                          ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
                          ->where('ms_products.prod_enable','=',1)
                          ->orderBy('ms_products.prod_price','DESC')
                          ->get();
                }elseif ($sort=='newst') {
                  $produk = DB::table('ms_products')
                          // ->join('tmp_product_image','tmp_product_image.prod_id','=','ms_products.prod_id')
                          ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
                          ->where('ms_products.prod_enable','=',1)
                          ->orderBy('ms_products.prod_created_at','DESC')
                          ->get();
                }else{
                  $produk = DB::table('ms_products')
                          // ->join('tmp_product_image','tmp_product_image.prod_id','=','ms_products.prod_id')
                          ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
                          ->where('ms_products.prod_enable','=',1)
                          ->get();
                }

              }

              if($kateg =='all'){

                      foreach ($produk as $product) {
                         foreach ($categall as  $categs) {

                          if(in_array($categs->kateg_id,explode(',',$product->prod_category))){
                            $result=Helper::check_dicount_catalog($product->prod_id,$categs->kateg_id,$product->prod_brand_id,$product->prod_price);
                                   $total= $result['total'];
                                   $disc= $result['disc'];
                                   $prodid= $result['prodid'];
                                   $type= $result['disc_reward'];
                                   if($type=='nominal'){
                                     if($disc >= 1000) {
                                           $nominal= $disc / 1000 .'k';
                                       }
                                       else {
                                           $nominal= $disc;
                                    }
                                  }

                                  if( $disc > 0){
                                    $totproduct=$total;
                                  }else{
                                    $totproduct=$product->prod_price;
                                  }
                              if($totproduct >= $minPrice && $totproduct <= $maxPrice){

                              echo '<form action="'.$appurl.'/postcart" method="post">';
                              echo '<input type="hidden" name="_token" id="tokenprod'.$product->prod_id.'" value="'.$token.'">';
                              echo '<input type="hidden" name="prod_id" value="'.$product->prod_id.'">';
                              echo '<div class="col-md-4 col-xs-6 product-loop">';
                              echo '<div class="card">';
                              echo '<div class="hovereffect1" style="height:250px; overflow:hidden;">';
                              echo '<div class="hover-produk1" style="">';
                              echo '<div class="judul-kat1">';
                              echo '<a href="#"  class="info1"  data-toggle="modal" data-target="#quickModal'.$product->prod_id.'" onclick="ajaxmodal('.$product->prod_id.')">ADD TO CART</a>';
                              echo '<!-- <a class="info1" href="#" data-toggle="modal" data-target="#'.$product->prod_id.'" >ADD TO CART</a> -->';
                              echo '<a class="info1" href="#">ADD TO WISHLIST</a>';
                              echo '<a class="info1" href="'.$appurl.'/product-detail/'.$product->prod_url.'">VIEW DETAIL</a>';
                              echo '</div>';
                              echo '</div>';
                              echo '<img class="img-responsive" src="'.asset($product->front_image).'" alt="" style=" width: 100%;">';
                              echo '</div>';
                              echo '<div class="isi-card" style="">';
                              echo ''.$product->brand_name.'<br>';
                              echo '<p style="font-weight:bold;">'.$product->prod_name.'</p>';

                              if($disc >0){
                              echo '<p><del><span class="price_format">'.$product->prod_price.'</span></del> <b> <span class="price_format" style="font-weight: bold; color: #B2203D;">'.$total.'</span></b></p>';
                              echo '<p></p>';
                              }else{
                              echo '<p><span class="price_format" style="font-weight: bold; color: #B2203D;">'.$product->prod_price.'</span></p>';
                              }
                              echo '</div>';
                              if($disc > 0){
                                echo '<div class="diskon">';
                                echo '<span style="position: relative; top: -30px; right: -5px; font-size: 12px;"><b>';
                                    if($type =='nominal'){
                                      echo ''.$nominal.'';
                                    }else{
                                      echo ''.$disc.'%';
                                    }
                                echo '</b><br>OFF</span>';
                                echo '</div>';
                              }
                              echo '</div>';
                              echo '</div>';
                              echo '</form>';
                       $item ++;    }
                      break;
                      }
                    }
                  }
              }else {

                    foreach ($produk as $product) {
                      if(in_array($kateg,explode(',',$product->prod_category))){

                        $result=Helper::check_dicount_catalog($product->prod_id,$kateg,$product->prod_brand_id,$product->prod_price);
                               $total= $result['total'];
                               $disc= $result['disc'];
                               $prodid= $result['prodid'];
                               $type= $result['disc_reward'];
                               if($type=='nominal'){
                                 if($disc >= 1000) {
                                       $nominal= $disc / 1000 .'k';
                                   }
                                   else {
                                       $nominal= $disc;
                                }
                              }

                              if( $disc > 0){
                                $totproduct=$total;
                              }else{
                                $totproduct=$product->prod_price;
                              }
                          if($totproduct >= $minPrice && $totproduct <= $maxPrice){
                          echo '<form action="'.$appurl.'/postcart" method="post">';
                          echo '<input type="hidden" name="_token" id="tokenprod'.$product->prod_id.'" value="'.$token.'">';
                          echo '<input type="hidden" name="prod_id" value="'.$product->prod_id.'">';
                          echo '<div class="col-md-4 col-xs-6 product-loop">';
                          echo '<div class="card">';
                          echo '<div class="hovereffect1" style="height:250px; overflow:hidden;">';
                          echo '<div class="hover-produk1" style="">';
                          echo '<div class="judul-kat1">';
                          echo '<a href="#"  class="info1"  data-toggle="modal" data-target="#quickModal'.$product->prod_id.'" onclick="ajaxmodal('.$product->prod_id.')">ADD TO CART</a>';
                          echo '<!-- <a class="info1" href="#" data-toggle="modal" data-target="#'.$product->prod_id.'" >ADD TO CART</a> -->';
                          echo '<a class="info1" href="#">ADD TO WISHLIST</a>';
                          echo '<a class="info1" href="'.$appurl.'/product-detail/'.$product->prod_url.'">VIEW DETAIL</a>';
                          echo '</div>';
                          echo '</div>';
                          echo '<img class="img-responsive" src="'.asset($product->front_image).'" alt="" style=" width: 100%;">';
                          echo '</div>';
                          echo '<div class="isi-card" style="">';
                          echo ''.$product->brand_name.'<br>';
                          echo '<p style="font-weight:bold;">'.$product->prod_name.'</p>';
                          if($disc >0){
                          echo '<p><del><span class="price_format">'.$product->prod_price.'</span></del> <b> <span class="price_format" style="font-weight: bold; color: #B2203D;">'.$total.'</span></b></p>';
                          echo '<p></p>';
                          }else{
                          echo '<p><span class="price_format" style="font-weight: bold; color: #B2203D;">'.$product->prod_price.'</span></p>';
                          }
                          echo '</div>';
                          if($disc > 0){
                            echo '<div class="diskon">';
                            echo '<span style="position: relative; top: -30px; right: -5px; font-size: 12px;"><b>';
                                if($type =='nominal'){
                                  echo ''.$nominal.'';
                                }else{
                                  echo ''.$disc.'%';
                                }
                            echo '</b><br>OFF</span>';
                            echo '</div>';
                          }
                          echo '</div>';
                          echo '</div>';
                          echo '</form>';

                       $item ++;
                      }
                    }

                  }

              }

        }
        echo'<div><input type="hidden" name="countItem" id="countItem" value="'.$item.'">';
      }
}
