<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Cart;
use Session;
use Helper;
class AddcartController extends Controller{

  // public function postCartVarian(){
  //     $prod_id=input::get('prod_id');
  //
  //
  //     $varid=input::get('varid');
  //     $qty = input::get('qty');
  //     $idsize=input::get('size');
  //     if(!empty($idsize)){
  //           $checksize=DB::table('lk_size')->where('size_id','=',$idsize)->first();
  //     }
  //
  //
  //
  //     // $prod=DB::table('ms_products')
  //     //         ->join('lk_product_category','lk_product_category.kateg_id','=','ms_products.prod_kateg_id')
  //     //         ->join('tmp_product_image','tmp_product_image.prod_id','=','ms_products.prod_id')
  //     //         ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
  //     //         ->where('ms_products.prod_id','=',$prod_id)->first();
  //     $prodvarian=DB::table('ms_product_varian')
  //                 ->join('ms_products','ms_products.prod_id','=','ms_product_varian.prod_id')
  //                 ->join('tmp_varian_image','tmp_varian_image.varian_id','=','ms_product_varian.varian_id')
  //                 ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
  //                 ->where('ms_product_varian.varian_stock','>',0)
  //                 ->where('ms_product_varian.varian_id','=',$varid)->first();
  //
  //     $prodid=$prodvarian->prod_id;
  //     $prodname=$prodvarian->varian_name;
  //     $prod_title=$prodvarian->prod_title;
  //     $varian_id=$prodvarian->varian_id;
  //     $image_small=$prodvarian->image_small;
  //     $brand=$prodvarian->brand_name;
  //
  //     $variandisc= $prodvarian->prod_disc / 100;
  //     $variantotdisc= $prodvarian->varian_price * $variandisc;
  //     $price= $prodvarian->varian_price - $variantotdisc;
  //     $variantotal=$price * $qty;
  //     if($prodvarian->varian_stock > 0){
  //         if(!empty($idsize)){
  //           Cart::add(['id' => $prodid, 'name' => $prodname, 'qty' => $qty, 'price' =>$price, 'options' => ["prod_title"=>$prod_title, "varian_id"=>$varian_id, "image_small"=>$image_small, "brand"=>$brand, "total"=>$variantotal, "size"=>$checksize->size_name]]);
  //           return redirect()->back()->with('success-addcart', 'Success add this items to Cart');
  //         }else{
  //           Cart::add(['id' => $prodid, 'name' => $prodname, 'qty' => $qty, 'price' =>$price, 'options' => ["prod_title"=>$prod_title, "varian_id"=>$varian_id, "image_small"=>$image_small, "brand"=>$brand, "total"=>$variantotal, "size"=>'']]);
  //           return redirect()->back()->with('success-addcart', 'Success add this items to Cart');
  //         }
  //     }
  // }
  public function postCartProduct(){
      $prod_id=input::get('prod_id');

      $qty = input::get('qty');
      $checkprod=DB::table('ms_products')
              ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
              ->where('ms_products.prod_id','=',$prod_id)->first();
      $categall=DB::table('lk_product_category')->where('kateg_enable','=',1)->get();

      /* Begin Product Varian */
      if($checkprod->prod_var_status ==1){
              $size=input::get('size');
              $color=input::get('color');
              if($color ==null){
                $checkvarian=DB::table('ms_product_varian')
                            ->where('ms_product_varian.prod_id','=',$prod_id)
                            ->where('ms_product_varian.varian_size','=',$size)
                            // ->where('ms_product_varian.varian_color','=',$color)
                            ->first();
              }else{
                $checkvarian=DB::table('ms_product_varian')
                            ->where('ms_product_varian.prod_id','=',$prod_id)
                            ->where('ms_product_varian.varian_size','=',$size)
                            ->where('ms_product_varian.varian_color','=',$color)
                            ->first();
              }


            if(count($checkvarian) >0)  {
              $prod=DB::table('ms_products')
                      ->join('ms_product_varian','ms_product_varian.prod_id','=','ms_products.prod_id')
                      ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
                      ->where('ms_products.prod_id','=',$prod_id)
                      ->where('ms_product_varian.varian_id','=',$checkvarian->varian_id)
                      ->first();

                    if($prod->varian_stock > 0){

                        foreach ($categall as  $categs) {
                          if(in_array($categs->kateg_id,explode(',',$prod->prod_category))){
                              $result=Helper::check_dicount_catalog($prod->prod_id,$categs->kateg_id,$prod->prod_brand_id,$prod->prod_price);
                              $total= $result['total'];
                              $disc= $result['disc'];
                              if( $disc > 0){
                                $price=  $total;
                                $prodtotal = $total * $qty;

                              }else{
                                $price=  $prod->prod_price;
                                $prodtotal =$prod->prod_price * $qty;
                              }
                              if( $total > 0 and $disc > 0 ){
                                break;
                              }
                         }
                        }

                         $prodid=$prod->prod_id;
                         $prodname=$prod->prod_name;
                         $prod_title=$prod->prod_title;
                         $front_image=$prod->front_image;
                         $brand=$prod->brand_name;

                         if($qty < $prod->varian_stock ){
                            Cart::add( $prodid, $prodname, $qty,$price, ["prod_title"=>$prod_title, "image_small"=>$front_image, "brand"=>$brand, "total"=>$prodtotal,"prodprice"=>$prod->prod_price,"proddisc"=>$disc, "size"=>$size,"color"=>$color]);

                           return redirect()->back()->with('success-addcart', 'Success add this items to Cart');
                         }else{
                           return redirect()->back()->with('error-addcart', 'sorry, the stock is not sufficient');
                         }

                      }else{
                         return redirect()->back()->with('error-addcart', 'sorry, the stock is not available');
                      }
                }else {
                   return redirect()->back()->with('error-addcart', 'sorry, the varian is not available');
                }


        /* End Product Varian */

       /* Begin Product Not Varian */
        }else{
          $prod=DB::table('ms_products')
                  ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
                  ->where('ms_products.prod_id','=',$prod_id)
                  ->first();

            if($prod->prod_stock > 0){
                  foreach ($categall as  $categs) {
                    if(in_array($categs->kateg_id,explode(',',$prod->prod_category))){
                        $result=Helper::check_dicount_catalog($prod->prod_id,$categs->kateg_id,$prod->prod_brand_id,$prod->prod_price);
                        $total= $result['total'];
                        $disc= $result['disc'];
                        if( $disc > 0){
                          $price=  $total;
                          $prodtotal = $total * $qty;

                        }else{
                          $price=  $prod->prod_price;
                          $prodtotal =$prod->prod_price * $qty;
                        }
                        if( $total > 0 and $disc > 0 ){
                          break;
                        }
                   }
                  }
                 $prodid=$prod->prod_id;
                 $prodname=$prod->prod_name;
                 $prod_title=$prod->prod_title;
                 $front_image=$prod->front_image;
                 $brand=$prod->brand_name;

                   if($qty < $prod->prod_stock ){
                       Cart::add( $prodid, $prodname, $qty,$price, ["prod_title"=>$prod_title, "image_small"=>$front_image, "brand"=>$brand, "total"=>$prodtotal,"prodprice"=>$prod->prod_price,"proddisc"=>$disc, "size"=>'',"color"=>'']);
                       return redirect()->back()->with('success-addcart', 'Success add this items to Cart');
                   }else{
                     return redirect()->back()->with('error-addcart', 'sorry, the stock is not sufficient');
                   }
              }else{
                  return redirect()->back()->with('error-addcart', 'sorry, the stock is not available');
              }
        }
        /* End Product Not Varian */
  }

  public function getCart(){
      // Cart::destroy();

      $content=Cart::content();
      $getprod=DB::table('ms_products')->get();
      if(Session::get('memberid')){
          $memberid=Session::get('memberid');
          DB::table('cart_point')->where('member_id','=',$memberid)->delete();
          Session::forget("bonusreward1");
          Session::forget("tmppoint1");
          Session::forget("discvoc");


          $member=DB::table('ms_members')->where('member_id','=',$memberid)->first();
          $bonus= DB::table('ms_bonus')->where('bonus_poin','<=', $member->member_points)->get();
          DB::table('cart_point')->insert([
                'member_id'=>$memberid,
                'point'=>$member->member_points
          ]);
          $tmppoint= DB::table('cart_point')->where('member_id','=',$memberid)->first();
      // }else{
      //   $bonus= null;
      //   $tmppoint=null;
      //   $member=null;
      // }
        $content=Cart::content();
        $resultstock=Helper::checkStock($content);
        return view('frontend/shopping-cart')
        ->with('content',$content)
        ->with('tmppoint',$tmppoint)
        ->with('getprod',$getprod)
        ->with('bonus',$bonus)
        ->with('resultstock',$resultstock)
        ->with('member',$member);


      }else{
        Session::flash('error_must_login','You must sign');
                return Redirect('user/login');
      }
  }
  public function delcart($cartid){

      Cart::content();
      // $rowId = Cart::search(array('id' => $cartid));
      // Cart::remove($rowId[0]);
      Cart::remove($cartid);
      return Redirect()->back()->with('success-delete', 'Success deleting cart');

  }

  public function ajaxupdateqty(){
    $rowid = Input::get('id');
    $qty = Input::get('qty');
    // $content = Cart::content();
    // Cart::update($rowid,$qty);
    echo '1';
  }

  public function updtqty(){
      $id = Input::get('idcart');
      $qty = Input::get('qtycart');

      Cart::update($id,$qty);
      return redirect()->back();
  }


}
