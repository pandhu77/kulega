<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Input;
use Validator;
use File;
use Redirect;
use DateTime;
use Auth;
use Helper;
class InventoryStockController extends Controller
{
    /**
    * Instantiate a new new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
      $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
       $auth = $this->CheckAuth();
       if($auth == true){
           $brand=DB::table('lk_brand')->where('brand_enable','=',1)->get();
           $kateg=DB::table('lk_product_category')->where('kateg_enable','=',1)->get();
           $stock=DB::table('tmp_inv_stock')
                  ->join('ms_products','tmp_inv_stock.inv_stock_prodid','=','ms_products.prod_id')
                  ->leftjoin('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
                  ->where('tmp_inv_stock.inv_stock_qty','>',0)
                  ->get();
            $stockkosong=DB::table('tmp_inv_stock')
                   ->join('ms_products','tmp_inv_stock.inv_stock_prodid','=','ms_products.prod_id')
                   ->leftjoin('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
                   ->where('tmp_inv_stock.inv_stock_qty','<=',0)
                   ->get();

          return view('backend.inventory.stock.index',[
             'stock'=>$stock,
             'stockkosong'=>$stockkosong

           ]);
         }else{
       return Redirect::back()->withErrors(['Sorry, No Access']);
       }
     }

     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy($id)
     {
       $auth = $this->CheckAuth();
         if($auth == true){
           $checkuser=DB::table('user_access')->where('access_id','=',Auth::user()->access_id)->first();
           if($checkuser->type==1){
             $i = DB::table('tmp_inv_stock')->where('inv_stock_id',$id)->delete();
             if($i > 0)
             {
                return redirect()->back()->with('success-delete','Your Inventory file has been deleted!');
              }else{
                 return redirect()->back()->with('no-delete','Can not be removed!');
              }
            }else{
               return redirect()->back()->with('no-delete','Sorry, No Access to removed!');
            }
         }else{
           return Redirect::back()->withErrors(['Sorry, No Access']);
         }
     }

     public function bestseller(){

         $products  = DB::table('ms_products')->get();
         $array     = [];

        //  CEK PRODUCT
         foreach ($products as $key => $prod) {
             $orders = DB::table('tmp_order_detail')->where('prod_id',$prod->prod_id)->get();

            //  CEK ORDERAN
             if (count($orders) > 0) {

                 $qty = 0;
                 foreach ($orders as $key => $order) {
                     $qty = $qty + $order->detail_qty;
                 }

                 $push = (object) array(
                     "prod_id"      => $prod->prod_id,
                     "front_image"  => $prod->front_image,
                     "prod_title"   => $prod->prod_title,
                     "prod_stock"   => $prod->prod_stock,
                     "prod_price"   => $prod->prod_price,
                     "prod_sold"    => $qty
                 );

                 array_push($array,$push);
             }

         }

         usort($array, function($a, $b){
            return strcmp($b->prod_sold, $a->prod_sold);
        });

         return view('backend.stock.best-seller',[
             'prod' => $array
         ]);
     }

     public function lowstock(){
         $product = DB::table('ms_products')->where('prod_stock','<=',$_GET['remaining'])->orderBy('prod_stock','DESC')->get();
         return view('backend.stock.low-stock',[
             'prod' => $product
         ]);
     }

     public function soldout(){
         $product = DB::table('ms_products')->where('prod_stock','=',0)->get();
         return view('backend.stock.sold-out',[
             'prod' => $product
         ]);
     }

     private function CheckAuth()
     {
       $url = request()->segment(1)."/".request()->segment(2)."/".request()->segment(3);
       $menu=DB::table('menu_admin')->where('menu_admin.status_menu','=',1)->get();
       foreach ($menu as $menus)
       {
         if($menus->url== $url){
           $cek=  Helper::checkmenuchecklist(Auth::user()->access_id, $menus->menu_id);
           if ($cek ==1){
             return true;
           }else{
             return false;
           }

         }
       }
     }
}
