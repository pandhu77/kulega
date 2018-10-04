<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Datetime;
use Auth;
use Helper;
use Illuminate\Cookies\CookieServiceProvider;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Session;

class InventoryoutController extends Controller
{
    /**
    * Instantiate a new new controller instance.
    *
    * @return void
    */
    public function __construct(){
      $this->middleware('auth');
    }

    /* Bagin Ajax Sisa Stoct */
    public function getprodstock(){
      $prodid=input::get('prodid');
      $prodcolor=input::get('prodcolor');
      $prodsize=input::get('prodsize');

      $msprodstock = DB::table('tmp_inv_stock')
                   ->where('inv_stock_prodid',$prodid)
                   ->where('inv_stock_size',$prodsize)
                   ->where('inv_stock_color',$prodcolor)
                   ->first();
      if(count($msprodstock)>0){
          echo '<input name="prodstock" type="text" id="prodstock" value="'.$msprodstock->inv_stock_qty.'" readonly="readonly" class="form-control">';

      }else{
        echo '
          <div class="alert alert-warning alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              "Sorry, Product Stock Not Found"
          </div>
        ';
      }

    }
    /* Bagin Ajax Varian Size */
    public function getvariansize(){
      $prodid=input::get('prodid');
      $variansize=DB::table('ms_product_varian')
              ->where('ms_product_varian.prod_id','=',$prodid)
              ->groupBy('varian_size')
              ->get();

          echo '
              <select  class="form-control js-example-basic-single" name="prodsize"   onchange="getcolor()" id="prodsize">
                  <option value="" selected disabled> Choose</option>';
                  foreach($variansize as $size){
                      if($size->varian_size !== ''){
                          echo '  <option value="'.$size->varian_size.'">'.$size->varian_size.' </option>';
                      }else{
                          echo '  <option value="'.$size->varian_size.'">No Size</option>';
                      }
                  }
          echo ' </select>';

    }


        /* BEGIN AJAX GET VARIAN COLOR*/
        public function getvariancolor(){
          $prodid=input::get('prodid');
          $prodsize=input::get('prodsize');
          $variancolor=DB::table('ms_product_varian')
                  ->where('ms_product_varian.prod_id','=',$prodid)
                  ->where('ms_product_varian.varian_size','=',$prodsize)
                  ->groupBy('varian_color')
                  ->get();
          $response['htmlcolor'] ='
                  <select  class="form-control js-example-basic-single"  name="prodcolor"  onchange="getsisastock()" id="prodcolor">
                  <option value="" selected disabled> Choose</option>';
                  foreach($variancolor as $color){
                  $response['htmlcolor'] .=' <option value="'.$color->varian_color.'">'.$color->varian_color.' </option>';
                  }
          $response['htmlcolor'] .=' </select>';

          $msprodstock = DB::table('tmp_inv_stock')->where('inv_stock_prodid',$prodid)
                       ->where('inv_stock_size',$prodsize)
                       ->where('inv_stock_color','')
                       ->first();
         if(count($msprodstock)>0){
           $response['htmlstock'] = "<input name='prodstock' type='text' id='prodstock' value='".$msprodstock->inv_stock_qty."' readonly='readonly' class='form-control'>";
         }else{
           $response['htmlstock'] = "<input name='prodstock' type='text' id='prodstock' value='' readonly='readonly' class='form-control'>";
         }
         return json_encode($response);exit;

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
           $date= new Datetime();
           $now=$date->format('Y-m-d');
           $userid = auth::user()->id;
           $username = auth::user()->username;
           $userdata = base64_encode ($userid.'-'.$username );
           $cart = DB::table('cart_patch')->where('cartid', $userdata)->delete();
           $invetory=DB::table('ms_inventory_out')->where('inv_out_date','=',$now)->get();
           $from='';
           $end='';
           $code='';
           return view('backend.inventory.out.index',[
             'inventory'=>$invetory,
             'from'=>$from,
             'end'=>$end,
             'code'=>$code
           ]);
         }else{
       return Redirect::back()->withErrors(['Sorry, No Access']);
       }
     }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $auth = $this->CheckAuth();
      if($auth == true){

            $userid = auth::user()->id;
            $username = auth::user()->username;
            $userdata = base64_encode ($userid.'-'.$username );
            // $cart = DB::table('cart_patch')->where('cartid', $userdata)->delete();
            $month=date("m",time());
            $year=date("Y",time());
            $full=date("m/Y",time());
            $tmp=DB::table('ms_inventory_out')->where('inv_out_created_at','like', $year .'-'. $month .'-'. '%')->count();
             if($tmp !=0){
               $inv= DB::table('ms_inventory_out')->where('inv_out_created_at', 'like', $year .'-'. $month .'-'. '%')->max('inv_out_no');
               $getinv=$inv+1;
             }else{
               $getinv=1;
             }
             $prod=DB::table('ms_products')
                   ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
                   ->join('tmp_inv_stock','tmp_inv_stock.inv_stock_prodid','ms_products.prod_id')
                   ->groupBy('ms_products.prod_id')->get();

            return view('backend.inventory.out.create',[
              'prod'=>$prod,
              'full' => $full,
              'getinv'=>$getinv
            ]);
          }else{
        return Redirect::back()->withErrors(['Sorry, No Access']);
      }
    }

    /** CHECK product */

    public function newproduct(){

      $productqty="1";
      $myvariable=array();
      $prodid= Input::get('prodid');
      $getprod= DB::select(DB::raw("select * from ms_products
                          join lk_brand on lk_brand.brand_id=ms_products.prod_brand_id
                          where prod_id = '".$prodid."' order by prod_id asc"));

      $msprodstock = DB::table('tmp_inv_stock')
                   ->where('inv_stock_prodid',$prodid)
                   ->where('inv_stock_size','')
                   ->where('inv_stock_color','')
                   ->first();

      foreach ($getprod as  $value) {
        $myvariable['prod_name']=$value->prod_name;
        $myvariable['brand_name']=$value->brand_name;
        $myvariable['productqty'] = $productqty;
        if(count($msprodstock)>0){
          $myvariable['productstock'] = $msprodstock->inv_stock_qty;
        }else{
            $myvariable['productstock'] ='';
        }

      }

      return $myvariable;
    }

    public function addtocart(){
        $prodid = Input::get('prodid');
        $qty = Input::get('qty');
        $prodsize=Input::get('prodsize');
        $prodcolor=Input::get('prodcolor');
        $userid = auth::user()->id;
        $username = auth::user()->username;
        $userdata = base64_encode ($userid.'-'.$username );
        $getprd = DB::select(DB::raw("select * from ms_products join lk_brand on lk_brand.brand_id= ms_products.prod_brand_id where prod_id = '".$prodid."' order by prod_id asc"))[0];
        $cartdata = DB::table('cart_patch')->where('prodid', '=', $prodid)->where('prodsize', $prodsize)->where('prodcolor', $prodcolor)->where('cartid', '=', $userdata)->count();
        if($cartdata !== 0){
            $update = DB::table('cart_patch')->where('prodid', $prodid)->where('prodsize', $prodsize)->where('prodcolor', $prodcolor)->where('cartid', $userdata)->update([
              'qty' => $qty,
              'prodsize'=>$prodsize,
              'prodcolor'=>$prodcolor
            ]);
        } else {
            $cartdatas = DB::table('cart_patch')->where('cartid', '=', $userdata)->orderBy('order', 'desc')->first();
            if(empty($cartdatas)){
                $dtorder = 0;
            } else {
                $dtorder = $cartdatas->order + 1;
            }
            DB::table('cart_patch')->insert([
                'cartid' => $userdata,
                'prodid' => $prodid,
                'prodcode' => $getprd->prod_code,
                'prodname' => $getprd->prod_name,
                'prodbrand'=>$getprd->brand_name,
                'qty' => $qty,
                'prodsize'=>$prodsize,
                'prodcolor'=>$prodcolor,
                'order' => $dtorder
            ]);
        }

        $cart = DB::table('cart_patch')->where('cartid', $userdata)->orderBy('order', 'asc')->get();
        return $cart;
    }
    public function deletecart(){
       $prodid = Input::get('prodid');
       $userid = auth::user()->id;
       $username = auth::user()->username;
       $userdata = base64_encode ($userid.'-'.$username );
       $cartdata = DB::table('cart_patch')->where('id', '=', $prodid)->where('cartid', '=', $userdata)->delete();
       $cart = DB::table('cart_patch')->where('cartid', $userdata)->orderBy('order', 'asc')->get();
       return $cart;
   }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $auth = $this->CheckAuth();

      if($auth == true){
        # code...
        // validate the info, create rules for the inputs
        $rules = array(
          // 'image'        => 'required',
          // 'status'     => 'required',
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
          return redirect()->back()
          ->withErrors($validator) // send back all errors to the login form
          ->withInput(); // send back the input (not the password) so that we can repopulate the form
        } else {

          $code    =Input::get('code');
          $date    =Input::get('date');
          $notes   =Input::get('notes');
          $now     = new DateTime();
          $userid= auth::user()->id;

          $month=date("m",time());
          $year=date("Y",time());
          $full=date("m/Y",time());
          $tmp=DB::table('ms_inventory_out')->where('inv_out_created_at','like', $year .'-'. $month .'-'. '%')->count();
           if($tmp !=0){
             $inv= DB::table('ms_inventory_out')->where('inv_out_created_at', 'like', $year .'-'. $month .'-'. '%')->max('inv_out_no');
             $getinv=$inv+1;
           }else{
             $getinv=1;
           }

          $insert = DB::table('ms_inventory_out')->insert([
            'inv_out_code'=>$code,
            'inv_out_notes'=>$notes,
            'inv_out_date'  =>$date,
            'inv_out_no'    =>$getinv,
            'inv_out_created_at' =>$now,
            'inv_out_created_by'=>$userid
          ]);

          if($insert){
              $userid = auth::user()->id;
              $username = auth::user()->username;
              $userdata = base64_encode ($userid.'-'.$username );
              $invin = DB::table('ms_inventory_out')->where('inv_out_code', $code)->first();
              $cart = DB::table('cart_patch')->where('cartid', $userdata)->orderBy('order', 'asc')->get();

              foreach ($cart as $key => $value) {
                 DB::table('tmp_inv_out_detail')->insert([
                       'inv_out_id'=>$invin->inv_out_id,
                       'out_prod_id'=>$value->prodid,
                       'out_detail_qty'=>$value->qty,
                       'out_detail_size'=>$value->prodsize,
                       'out_detail_color'=>$value->prodcolor,
                 ]);

                 $msprodstock = DB::table('tmp_inv_stock')
                              ->where('inv_stock_prodid',$value->prodid)
                              ->where('inv_stock_size',$value->prodsize)
                              ->where('inv_stock_color',$value->prodcolor)
                              ->first();
                 if (count($msprodstock)!==0) {
                     DB::table('tmp_inv_stock')
                            ->where('inv_stock_prodid',$value->prodid)
                            ->where('inv_stock_size',$value->prodsize)
                            ->where('inv_stock_color',$value->prodcolor)
                            ->update([
                                 'inv_stock_qty' => $msprodstock->inv_stock_qty - $value->qty,
                                 'inv_stock_size' => $value->prodsize,
                                 'inv_stock_color' => $value->prodcolor,
                      ]);
                 } else {
                     DB::table('tmp_inv_stock')->insert([
                         'inv_stock_prodid' => $value->prodid,
                         'inv_stock_qty' => $value->qty,
                         'inv_stock_size' => $value->prodsize,
                         'inv_stock_color' => $value->prodcolor,
                     ]);
                 }
              }

             $cart = DB::table('cart_patch')->where('cartid', $userdata)->delete();
            return redirect()->to('backend/inventory/out')->with('success-create','Thank you for inventory out code '.$code.' success add!');

          }else{
            return Redirect()->back()->with('error','Sorry something is error !');
          }
        }
      }else{
        return Redirect::back()->withErrors(['Sorry, No Access']);
      }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
          $row=DB::table('ms_inventory_out')->where('inv_out_id','=',$id)->first();

          if(count($row)> 0){

            $prod=DB::table('ms_products')
                  ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
                  ->join('tmp_inv_stock','tmp_inv_stock.inv_stock_prodid','ms_products.prod_id')
                  ->groupBy('ms_products.prod_id')->get();

              $userid = auth::user()->id;
              $username = auth::user()->username;
              $userdata = base64_encode ($userid.'-'.$username );
              $cart = DB::table('cart_patch')->where('cartid', $userdata)->delete();
              $getdetail=DB::table('tmp_inv_out_detail')
                       ->join('ms_inventory_out','ms_inventory_out.inv_out_id','=','tmp_inv_out_detail.inv_out_id')
                       ->join('ms_products','ms_products.prod_id','=','out_prod_id')
                       ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')->where('tmp_inv_out_detail.inv_out_id','=',$id)->get();

                 $t=0;
                 foreach ($getdetail as $key => $detail) {
                   $t++;

                   $cartdatas = DB::table('cart_patch')
                              ->where('invid', '=', $id)
                              ->where('prodid', '=', $detail->out_prod_id)
                              ->where('prodsize', '=', $detail->out_detail_size)
                              ->where('prodcolor', '=', $detail->out_detail_color)
                              ->where('cartid', '=', $userdata)->orderBy('order', 'desc')->get();

                   if(count($cartdatas) > 0){
                       $update = DB::table('cart_patch')
                                ->where('invid', '=', $id)
                                ->where('prodid', '=', $detail->out_prod_id)
                                ->where('prodsize', '=', $detail->out_detail_size)
                                ->where('prodcolor', '=', $detail->out_detail_color)
                                ->where('cartid', '=', $userdata)
                                ->update([
                         'qty' => $detail->out_detail_qty,
                         'prodsize'=>$detail->out_detail_size,
                         'prodcolor'=>$detail->out_detail_color,
                       ]);
                   } else {
                     DB::table('cart_patch')->insert([
                         'cartid' => $userdata,
                         'invid' => $id,
                         'prodid' => $detail->out_prod_id,
                         'prodcode' => $detail->prod_code,
                         'prodname' =>$detail->prod_name,
                         'prodbrand'=>$detail->brand_name,
                         'qty' => $detail->out_detail_qty,
                         'prodsize'=>$detail->out_detail_size,
                         'prodcolor'=>$detail->out_detail_color,
                         'order' => $t
                     ]);
                   }

                 }

              $cart = DB::table('cart_patch')->where('invid', '=', $id)->where('cartid', '=', $userdata)->orderBy('order', 'asc')->get();

              return view('backend.inventory.out.edit',[
                'row'=>$row,
                'prod'=>$prod,
                'cart'=>$cart
              ]);
        }else{
           return Redirect::back();
        }
        }else{
        return Redirect::back()->withErrors(['Sorry, No Access']);
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $auth = $this->CheckAuth();

      if($auth == true){
             $id   =Input::get('invid');
             $code    =Input::get('code');
             $date    =Input::get('date');
             $notes   =Input::get('notes');
             $now     = new DateTime();
             $userid= auth::user()->id;
             $month=date("m",time());
             $year=date("Y",time());
             $full=date("m/Y",time());
             $update = DB::table('ms_inventory_out')->where('inv_out_id','=',$id)->update([
               'inv_out_notes'=>$notes,
               'inv_out_date'  =>$date,
               'inv_out_updated_at' =>$now,
               'inv_out_updated_by'=>$userid
             ]);

                 $userid = auth::user()->id;
                 $username = auth::user()->username;
                 $userdata = base64_encode ($userid.'-'.$username );
                 $invdetail = DB::table('tmp_inv_out_detail')->where('inv_out_id','=',$id)->get();
                 $cart = DB::table('cart_patch')->where('cartid', $userdata)->orderBy('order', 'asc')->get();

                   foreach ($invdetail as $key => $detail) {
                       $tmpstockmin = DB::table('tmp_inv_stock')
                                    ->where('inv_stock_prodid',$detail->out_prod_id)
                                    ->where('inv_stock_size',$detail->out_detail_size)
                                    ->where('inv_stock_color',$detail->out_detail_color)
                                    ->first();

                       $hitstock=$tmpstockmin->inv_stock_qty + $detail->out_detail_qty;
                       if($hitstock >=0){
                         DB::table('tmp_inv_stock')
                           ->where('inv_stock_prodid',$detail->out_prod_id)
                           ->where('inv_stock_size',$detail->out_detail_size)
                           ->where('inv_stock_color',$detail->out_detail_color)
                           ->update([
                             'inv_stock_qty' => $hitstock,
                         ]);
                       }else{
                         DB::table('tmp_inv_stock')
                            ->where('inv_stock_prodid',$detail->out_prod_id)
                            ->where('inv_stock_size',$detail->out_detail_size)
                            ->where('inv_stock_color',$detail->out_detail_color)
                            ->update([
                             'inv_stock_qty' => 0,
                         ]);
                       }
                   }

                 $delete= DB::table('tmp_inv_out_detail')->where('inv_out_id','=',$id)->delete();
                   foreach ($cart as $key => $value) {
                     $insertdetail= DB::table('tmp_inv_out_detail')->insert([
                                    'inv_out_id'=>$id,
                                    'out_prod_id'=>$value->prodid,
                                    'out_detail_qty'=>$value->qty,
                                    'out_detail_size'=>$value->prodsize,
                                    'out_detail_color'=>$value->prodcolor

                                  ]);

                      $msprodstock = DB::table('tmp_inv_stock')
                                   ->where('inv_stock_prodid',$value->prodid)
                                   ->where('inv_stock_size',$value->prodsize)
                                   ->where('inv_stock_color',$value->prodcolor)
                                   ->first();

                      if (count($msprodstock)!=0) {
                          DB::table('tmp_inv_stock')
                              ->where('inv_stock_prodid',$value->prodid)
                              ->where('inv_stock_size',$value->prodsize)
                              ->where('inv_stock_color',$value->prodcolor)
                              ->update([
                              'inv_stock_qty' => $msprodstock->inv_stock_qty - $value->qty,
                              'inv_stock_size' => $value->prodsize,
                              'inv_stock_color' => $value->prodcolor,
                          ]);
                      } else {
                          DB::table('tmp_inv_stock')->insert([
                              'inv_stock_prodid' => $value->prodid,
                              'inv_stock_qty' => $value->qty,
                              'inv_stock_size' => $value->prodsize,
                              'inv_stock_color' => $value->prodcolor,

                          ]);
                      }
                   }

                $cart = DB::table('cart_patch')->where('cartid', $userdata)->delete();
               return redirect()->to('backend/inventory/out')->with('success-create','Thank you for inventory out code '.$code.' success Update!');

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
          $getinv = DB::table('ms_inventory_out')->where('inv_out_id',$id)->first();
            if( count($getinv)>0 ){
              $getdetail= DB::table('tmp_inv_out_detail')->where('inv_out_id',$getinv->inv_out_id)->get();

                 foreach ($getdetail as $key => $detail) {
                   $tmpstockmin = DB::table('tmp_inv_stock')
                   ->where('inv_stock_prodid',$detail->out_prod_id)
                   ->where('inv_stock_size',$detail->out_detail_size)
                   ->where('inv_stock_color',$detail->out_detail_color)
                   ->first();
                   if(count($tmpstockmin)> 0){
                       $hitstock=$tmpstockmin->inv_stock_qty + $detail->out_detail_qty;
                       if($hitstock >= 0){
                         DB::table('tmp_inv_stock')->where('inv_stock_prodid',$detail->out_prod_id)
                         ->where('inv_stock_size',$detail->out_detail_size)
                         ->where('inv_stock_color',$detail->out_detail_color)
                         ->update([
                             'inv_stock_qty' =>$hitstock,
                         ]);
                       }else{
                         DB::table('tmp_inv_stock')->where('inv_stock_prodid',$detail->out_prod_id)
                         ->where('inv_stock_size',$detail->out_detail_size)
                         ->where('inv_stock_color',$detail->out_detail_color)
                         ->update([
                             'inv_stock_qty' =>0,
                         ]);
                       }
                     }
                  }

                  DB::table('tmp_inv_out_detail')->where('inv_out_id', '=', $getinv->inv_out_id)->delete();
                  DB::table('ms_inventory_out')->where('inv_out_id', '=', $id)->delete();
                return redirect()->back()->with('success-delete','inventory out delete success!');

            }else{
              return redirect()->back();
            }

           }else{
             return redirect()->back()->with('no-delete','Sorry, No Access to removed!');
           }
         }else{
           return Redirect::back()->withErrors(['Sorry, No Access']);
         }
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
