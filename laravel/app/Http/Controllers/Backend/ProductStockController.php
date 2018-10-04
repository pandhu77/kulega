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
class ProductStockController extends Controller
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
      * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function edit($id)
     {
       $auth = $this->CheckAuth();
       if($auth == true){
             $row=DB::table('ms_products')->where('prod_id','=',$id)->first();
             if(count($row) > 0)
             {
               $tmpvarian=DB::table('ms_product_varian')->where('prod_id','=',$id)->get();
               $tmpinv=DB::table('tmp_inv_stock')->where('inv_stock_prodid','=',$id)->get();
               return view('backend.product-stock.edit',[
                 'row'=>$row,
                 'tmpvarian'=>$tmpvarian,
                 'tmpinv'=>$tmpinv,
               ]);
             }else{
               return Redirect::back();
             }

      }else{
        return Redirect::back()->withErrors(['msg', 'No Access']);
       }
     }

     public function updatestockprod()
     {
       // $auth = $this->CheckAuth();
       // if($auth == true){
            $prodid=input::get('prod_id');
            $prodqty=input::get('prod_stock');
            $check= DB::table('ms_products')->where('prod_id','=',$prodid)->first();
            $checkstock= DB::table('tmp_inv_stock')
            ->where('inv_stock_prodid','=',$check->prod_id)
            ->first();

            if(count($checkstock) < 1){
                 return redirect()->back()->with('get-errol','Sorry, prodoct no inventory, please input product inventory');
            }else{
                $checkqty=$checkstock->inv_stock_qty+$check->prod_stock;
              if($prodqty > $checkqty ){
                 return redirect()->back()->with('get-errol','Sorry, stock inventory is insufficient');
              }elseif ($prodqty < 0 ) {
                 return redirect()->back()->with('get-errol','Sorry, the stock is invalid');
              }else{
                $valueqty= $checkstock->inv_stock_qty + $check->prod_stock;
                $intstock=$valueqty - $prodqty;
                if( $intstock >= 0 ){
                  $updateinv= DB::table('tmp_inv_stock')
                  ->where('inv_stock_prodid','=',$check->prod_id)
                  ->update([
                            'inv_stock_qty'=>$intstock,
                    ]);
                }else{
                  $updateinv= DB::table('tmp_inv_stock')
                  ->where('inv_stock_prodid','=',$check->prod_id)
                  ->update([
                            'inv_stock_qty'=>0,
                    ]);
                }

                  if($updateinv){

                    $produpdate= DB::table('ms_products')->where('prod_id','=',$prodid)->update([
                       'prod_stock'=>$prodqty
                     ]);
                     if($produpdate){
                       return redirect()->back()->with('success','  Success, stock successfully updated!');
                     }else{
                       return redirect()->back()->with('get-errol','Sorry, stock unsuccessful updated');
                     }

                  }else{
                      return redirect()->back()->with('get-errol','Sorry, stock unsuccessful updated');
                  }

              }

             }
          //   }else{
          // return Redirect::back()->withErrors(['msg', 'No Access']);
          // }
     }
     public function updatestockvarian()
     {
       // $auth = $this->CheckAuth();
       // if($auth == true){
        $qty=input::get('qty');
        $varid=input::get('varid');
        $check= DB::table('ms_product_varian')->where('varian_id','=',$varid)->first();
        $checkstock= DB::table('tmp_inv_stock')
        ->where('inv_stock_prodid','=',$check->prod_id)
        ->where('inv_stock_size','=',$check->varian_size)
        ->where('inv_stock_color','=',$check->varian_color)
        ->first();


        if(count($checkstock) < 1){
          echo"<div class='alert alert-danger' style='padding:0px;padding-right:3px;padding-left:3px;margin-top:3px;'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true' style='margin-top: -3px;'>&times;</button>
                Sorry, variation no inventory
                </div>";
        }else{

            $checkqty=$checkstock->inv_stock_qty+ $check->varian_stock;

          if($qty > $checkqty ){
            echo"max stock inventory($checkstock->inv_stock_qty)";
            echo"<div class='alert alert-warning' style='padding:0px;padding-right:3px;padding-left:3px;margin-top:3px;'>
                  <button type='button' class='close' data-dismiss='alert' aria-hidden='true' style='margin-top: -3px;'>&times;</button>
                  Sorry, stock inventory is insufficient
                  </div>";
          }elseif ($qty < 0 ) {
            echo"max stock inventory($checkstock->inv_stock_qty)";
            echo"<div class='alert alert-danger' style='padding:0px;padding-right:3px;padding-left:3px;margin-top:3px;'>
                  <button type='button' class='close' data-dismiss='alert' aria-hidden='true' style='margin-top: -3px;'>&times;</button>
                  Sorry, the stock is invalid
                  </div>";
          }else{
                // echo"max stock inventory($checkstock->inv_stock_qty)";


                  $valueqty= $checkstock->inv_stock_qty + $check->varian_stock;
                  $invstockvar=$valueqty - $qty;

                  if( $invstockvar >= 0 ){
                    $updateinv= DB::table('tmp_inv_stock')
                    ->where('inv_stock_prodid','=',$check->prod_id)
                    ->where('inv_stock_size','=',$check->varian_size)
                    ->where('inv_stock_color','=',$check->varian_color)
                    ->update([
                              'inv_stock_qty'=>$invstockvar,
                      ]);
                  }else{
                      $updateinv= DB::table('tmp_inv_stock')
                      ->where('inv_stock_prodid','=',$check->prod_id)
                      ->where('inv_stock_size','=',$check->varian_size)
                      ->where('inv_stock_color','=',$check->varian_color)
                      ->update([
                                'inv_stock_qty'=>0,
                        ]);
                  }

                  if($updateinv){
                    $updatevarian= DB::table('ms_product_varian')
                    ->where('varian_id','=',$varid)->update([
                            'varian_stock'=>$qty,
                    ]);
                    if($updatevarian){
                      $checkstock= DB::table('tmp_inv_stock')
                      ->where('inv_stock_prodid','=',$check->prod_id)
                      ->where('inv_stock_size','=',$check->varian_size)
                      ->where('inv_stock_color','=',$check->varian_color)
                      ->first();
                      echo"Stock inventory($checkstock->inv_stock_qty)";
                      echo"<div class='alert alert-success' style='padding:0px;padding-right:3px;padding-left:3px;margin-top:3px;'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true' style='margin-top: -3px;'>&times;</button>
                        Success, stock successfully updated
                        </div>";
                    }else{
                      echo"<div class='alert alert-danger' style='padding:0px;padding-right:3px;padding-left:3px;margin-top:3px;'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true' style='margin-top: -3px;'>&times;</button>
                            Sorry, stock unsuccessful updated
                            </div>";
                    }
                  }else{
                    echo"<div class='alert alert-danger' style='padding:0px;padding-right:3px;padding-left:3px;margin-top:3px;'>
                          <button type='button' class='close' data-dismiss='alert' aria-hidden='true' style='margin-top: -3px;'>&times;</button>
                          Sorry, stock unsuccessful updated
                          </div>";
                  }

          }
        }
       //   }else{
       // return Redirect::back()->withErrors(['msg', 'No Access']);
       // }

     }

     private function CheckAuth()
     {
       $url = request()->segment(1)."/".request()->segment(2);
       $menu=DB::table('menu_admin')->where('menu_admin.status_menu','=',1)->get();
       foreach ($menu as $menus)
       {
         if($menus->url== substr($url,0,-6)){
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
