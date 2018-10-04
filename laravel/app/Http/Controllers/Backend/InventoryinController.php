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


class InventoryinController extends Controller
{
    /**
    * Instantiate a new new controller instance.
    *
    * @return void
    */
    public function __construct(){
      $this->middleware('auth');
    }

    public function NewProductstore(Request $request)
    {
      $auth = $this->CheckAuth();

      if($auth == true){
        # code...

          if(empty(Input::get('prod_enable'))){
            $enable=0;
          }else{
            $enable=1;
          }
          $status=$enable;
          $nilai=strlen(url(''));
          $len=$nilai+1;
          $frontimage   =substr(Input::get('front_image'),$len);
          if(input::get('prod_category')!==null){
            $category     =implode(",",input::get('prod_category'));
          }else{
            $category='';
          }
          $prod_code        =Input::get('prod_code');
          $name             =Input::get('prod_name');
          $title            =Input::get('prod_title');
          $url              =Input::get('prod_url');
          $brand            =Input::get('prod_brand_id');
          $price            =Input::get('prod_price');
          $varstatus       =Input::get('prod_var_status');
          $now          = new DateTime();
          $userid= auth::user()->id;

          // validate the info, create rules for the inputs
             $rules = [
                'prod_code'    => 'required|unique:ms_products',
                'prod_brand_id' => 'required',
                'prod_category' => 'required',
                'prod_var_status' =>'required',
            ];

            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
                // dd($validator->errors()->all());

            } else {

          $insert = DB::table('ms_products')->insert([

            'prod_approval'=>'admin',
            'prod_code'=>$prod_code,
            'prod_brand_id'=>$brand,
            'prod_name'  =>$name,
            'prod_title'  =>$title,
            'prod_brand_id'=>$brand,
            'prod_category'=>$category,
            'prod_url'  =>$url,
            'prod_price'  =>$price,
            'prod_var_status'=>$varstatus,
            'prod_enable'  =>0,
            'prod_created_at' =>$now,
            'prod_created_by'=>$userid
          ]);
          if($insert){
                /** Begin master product */
                $checkprod=DB::table('ms_products')->where('prod_created_by','=',$userid)->orderby('prod_created_at','=','desc')->first();
                $size   =input::get('size');
                $color  =input::get('color');
                $colorhex   =input::get('color_hex');
                if(!empty($size)){
                  foreach ($size as $key => $sizes) {

                      DB::table('ms_product_varian')->insert([
                        'prod_id' => $checkprod->prod_id,
                        'varian_size'=>$sizes,
                        'varian_color'=>$color[$key],
                        'varian_color_hex'=>$colorhex[$key],
                      ]);
                  }
                  /** End input varian */
                }

            return redirect()->back()->with('success-create','Thank you for product add!');

          }else{
            return Redirect()->back()->with('error','Sorry something is error !');
          }
        }
      }else{
        return Redirect::back()->withErrors(['Sorry, No Access']);
      }
    }

    public function publicstock(){
      $id=input::get('id');
      $check=DB::table('cart_patch')->where('id','=',$id)->first();
      if($check->prodpublic==0){
        DB::table('cart_patch')->where('id','=',$id)->update([
          'prodpublic'=>1,
        ]);
      }else{
        DB::table('cart_patch')->where('id','=',$id)->update([
          'prodpublic'=>0,
        ]);
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
              <select  class="form-control js-example-basic-single"name="prodsize"  onchange="getcolor()" id="prodsize">
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


              echo '
                  <select  class="form-control js-example-basic-single"  name="prodcolor" id="prodcolor">
                      <option value="" selected disabled> Choose</option>';
                      foreach($variancolor as $color){
                          if($color->varian_color !== ''){
                          echo '  <option value="'.$color->varian_color.'">'.$color->varian_color.' </option>';
                        }else{
                          echo '  <option value="'.$color->varian_color.'">No Color</option>';
                        }
                      }
              echo ' </select>';

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
           $invetory=DB::table('ms_inventory_in')->where('inv_in_date','=',$now)->get();
           $from='';
           $end='';
           $code='';

           return view('backend.inventory.in.index',[
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

             $month=date("m",time());
             $year=date("Y",time());
             $full=date("m/Y",time());
             $tmp=DB::table('ms_inventory_in')->where('inv_in_created_at','like', $year .'-'. $month .'-'. '%')->count();
              if($tmp !=0){
                $inv= DB::table('ms_inventory_in')->where('inv_in_created_at', 'like', $year .'-'. $month .'-'. '%')->max('inv_in_no');
                $getinv=$inv+1;
              }else{
                $getinv=1;
              }

              $prod=DB::table('ms_products')
                    ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')->get();
              $brand=DB::table('lk_brand')->where('brand_enable','=',1)->get();
              $categparent=DB::table('lk_product_category')
                        ->where('kateg_enable','=',1)
                        ->where('kateg_parent','=',0)->get();
              $categparent1=DB::table('lk_product_category')
                        ->where('kateg_enable','=',1)->get();
              $categparent2=DB::table('lk_product_category')
                        ->where('kateg_enable','=',1)->get();
             return view('backend.inventory.in.create',[
               'prod'=>$prod,
               'full' => $full,
               'getinv'=>$getinv,
               'brand'=>$brand,
               'categparent'=>$categparent,
               'categparent1'=>$categparent1,
               'categparent2'=>$categparent2


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
       $getprod= DB::select(DB::raw("select * from ms_products join lk_brand on lk_brand.brand_id=ms_products.prod_brand_id where prod_id = '".$prodid."' order by prod_id asc"));

       foreach ($getprod as  $value) {
         $myvariable['prod_name']=$value->prod_name;
         $myvariable['brand_name']=$value->brand_name;
         $myvariable['productqty'] = $productqty;
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
             $update = DB::table('cart_patch')->where('prodid', $prodid)->where('cartid', $userdata)->where('prodsize', $prodsize)->where('prodcolor', $prodcolor)->update([
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
        $prodsize=Input::get('prodsize');
        $prodcolor=Input::get('prodcolor');
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
           $tmp=DB::table('ms_inventory_in')->where('inv_in_created_at','like', $year .'-'. $month .'-'. '%')->count();
            if($tmp !=0){
              $inv= DB::table('ms_inventory_in')->where('inv_in_created_at', 'like', $year .'-'. $month .'-'. '%')->max('inv_in_no');
              $getinv=$inv+1;
            }else{
              $getinv=1;
            }

           $insert = DB::table('ms_inventory_in')->insert([
             'inv_in_code'=>$code,
             'inv_in_notes'=>$notes,
             'inv_in_date'  =>$date,
             'inv_in_no'    =>$getinv,
             'inv_in_created_at' =>$now,
             'inv_in_created_by'=>$userid
           ]);

           if($insert){
               $userid = auth::user()->id;
               $username = auth::user()->username;
               $userdata = base64_encode ($userid.'-'.$username );
               $invin = DB::table('ms_inventory_in')->where('inv_in_code', $code)->first();
               $cart = DB::table('cart_patch')->where('cartid', $userdata)->orderBy('order', 'asc')->get();

               foreach ($cart as $key => $value) {
                  DB::table('tmp_inv_in_detail')->insert([
                        'inv_in_id'=>$invin->inv_in_id,
                        'in_prod_id'=>$value->prodid,
                        'in_detail_qty'=>$value->qty,
                        'in_detail_size'=>$value->prodsize,
                        'in_detail_color'=>$value->prodcolor,
                        'in_detail_public'=>$value->prodpublic,
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
                          'inv_stock_qty' => $msprodstock->inv_stock_qty + $value->qty,
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
               $cart2 = DB::table('cart_patch')->where('cartid', $userdata)->where('prodpublic','=',1)->orderBy('order', 'asc')->get();
               foreach ($cart2 as $key => $varvalue) {
                 $msvarstock = DB::table('ms_product_varian')
                               ->where('prod_id',$varvalue->prodid)
                               ->where('varian_size',$varvalue->prodsize)
                               ->where('varian_color',$varvalue->prodcolor)
                               ->first();

                  if(count($msvarstock)>0){
                    $updatevar= DB::table('ms_product_varian')
                               ->where('varian_id',$msvarstock->varian_id)
                               ->update([
                                   'varian_stock' => $msvarstock->varian_stock + $varvalue->qty,
                               ]);
                  }else{
                    $msprodstock = DB::table('ms_products')
                                  ->where('prod_var_status','0')
                                  ->where('prod_id',$varvalue->prodid)
                                  ->first();

                        if(count($msprodstock)>0){
                            $updateprod= DB::table('ms_products')
                                       ->where('prod_id',$msprodstock->prod_id)
                                       ->update([
                                           'prod_stock' => $msprodstock->prod_stock + $varvalue->qty,
                                       ]);
                      }
                  }

               }

              $cart = DB::table('cart_patch')->where('cartid', $userdata)->delete();
             return redirect()->to('backend/inventory/in')->with('success-create','Thank you for inventory in code '.$code.'success add!');

           }else{
             return Redirect()->back()->with('error','Sorry something is error !');
           }
         }
       }else{
         return Redirect::back()->withErrors(['Sorry, No Access']);
       }

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
           $row=DB::table('ms_inventory_in')->where('inv_in_id','=',$id)->first();

           if(count($row)> 0){

               $prod=DB::table('ms_products')
                     ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')->get();

               $userid = auth::user()->id;
               $username = auth::user()->username;
               $userdata = base64_encode ($userid.'-'.$username );
               $cart = DB::table('cart_patch')->where('cartid', $userdata)->delete();
               $getdetail=DB::table('tmp_inv_in_detail')
                        ->join('ms_inventory_in','ms_inventory_in.inv_in_id','=','tmp_inv_in_detail.inv_in_id')
                        ->join('ms_products','ms_products.prod_id','=','in_prod_id')
                        ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')->where('tmp_inv_in_detail.inv_in_id','=',$id)->get();

                  $t=0;
                  foreach ($getdetail as $key => $detail) {
                    $t++;

                    $cartdatas = DB::table('cart_patch')->where('invid', '=', $id)->where('prodid', '=', $detail->in_prod_id)->where('prodsize', '=', $detail->in_detail_size)->where('prodcolor', '=', $detail->in_detail_color)->where('cartid', '=', $userdata)->orderBy('order', 'desc')->get();

                    if(count($cartdatas) > 0){
                        $update = DB::table('cart_patch')->where('invid', '=', $id)->where('prodid', '=', $detail->in_prod_id)->where('prodsize', '=', $detail->in_detail_size)->where('prodcolor', '=', $detail->in_detail_color)->where('cartid', '=', $userdata)->update([
                          'qty' => $detail->in_detail_qty,
                          'prodsize'=>$detail->in_detail_size,
                          'prodcolor'=>$detail->in_detail_color,
                          'prodpublic'=>$detail->in_detail_public,
                          // 'prodsize'=>$detail->in_detail_size,
                        ]);
                    } else {
                      DB::table('cart_patch')->insert([
                          'cartid' => $userdata,
                          'invid' => $id,
                          'prodid' => $detail->in_prod_id,
                          'prodcode' =>$detail->prod_code,
                          'prodname' =>$detail->prod_name,
                          'prodbrand'=>$detail->brand_name,
                          'qty' => $detail->in_detail_qty,
                          'prodsize'=>$detail->in_detail_size,
                          'prodcolor'=>$detail->in_detail_color,
                          'prodpublic'=>$detail->in_detail_public,
                          'order' => $t
                      ]);
                    }

                  }

               $cart = DB::table('cart_patch')->where('invid', '=', $id)->where('cartid', '=', $userdata)->orderBy('order', 'asc')->get();

               return view('backend.inventory.in.edit',[
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


              $update = DB::table('ms_inventory_in')->where('inv_in_id','=',$id)->update([
                'inv_in_notes'=>$notes,
                'inv_in_date'  =>$date,
                'inv_in_updated_at' =>$now,
                'inv_in_updated_by'=>$userid
              ]);

                  $userid = auth::user()->id;
                  $username = auth::user()->username;
                  $userdata = base64_encode ($userid.'-'.$username );
                  $invdetail = DB::table('tmp_inv_in_detail')->where('inv_in_id','=',$id)->get();
                  $cart = DB::table('cart_patch')->where('cartid', $userdata)->orderBy('order', 'asc')->get();

                    foreach ($invdetail as $key => $detail) {
                        $tmpstockmin = DB::table('tmp_inv_stock')->where('inv_stock_prodid',$detail->in_prod_id)->where('inv_stock_size',$detail->in_detail_size)->where('inv_stock_color',$detail->in_detail_color)->first();

                        if($tmpstockmin !==null){
                          $hitstock = $tmpstockmin->inv_stock_qty - $detail->in_detail_qty;

                          if($hitstock >=0){
                            DB::table('tmp_inv_stock')->where('inv_stock_prodid',$detail->in_prod_id)->where('inv_stock_size',$detail->in_detail_size)->where('inv_stock_color',$detail->in_detail_color)->update([
                                'inv_stock_qty' => $hitstock,
                            ]);
                          }else{
                            DB::table('tmp_inv_stock')->where('inv_stock_prodid',$detail->in_prod_id)->where('inv_stock_size',$detail->in_detail_size)->where('inv_stock_color',$detail->in_detail_color)->update([
                                'inv_stock_qty' => 0,
                            ]);
                          }
                        }


                       if($detail->in_detail_public==1){
                        $msvarstock = DB::table('ms_product_varian')
                                      ->where('prod_id',$detail->in_prod_id)
                                      ->where('varian_size',$detail->in_detail_size)
                                      ->where('varian_color',$detail->in_detail_color)
                                      ->first();

                         if(count($msvarstock)>0){
                              $hitvarstock=  $msvarstock->varian_stock - $detail->in_detail_qty;
                              if($hitvarstock >=0){
                                 $updatevar= DB::table('ms_product_varian')
                                            ->where('varian_id',$msvarstock->varian_id)
                                            ->update([
                                                'varian_stock' =>$hitvarstock,
                                            ]);
                                }else{
                                  $updatevar= DB::table('ms_product_varian')
                                             ->where('varian_id',$msvarstock->varian_id)
                                             ->update([
                                                 'varian_stock' =>0,
                                             ]);
                                }
                         }else{
                             $msprodstock = DB::table('ms_products')
                                         ->where('prod_var_status','0')
                                         ->where('prod_id',$detail->in_prod_id)
                                         ->first();

                               if(count($msprodstock)>0){
                                    $hitprodstock= $msprodstock->prod_stock - $detail->in_detail_qty;
                                    if($hitprodstock >=0){
                                       $updateprod= DB::table('ms_products')
                                                  ->where('prod_id',$msprodstock->prod_id)
                                                  ->update([
                                                      'prod_stock' =>$hitprodstock,
                                                  ]);
                                    }else{
                                      $updateprod= DB::table('ms_products')
                                                 ->where('prod_id',$msprodstock->prod_id)
                                                 ->update([
                                                     'prod_stock' =>0,
                                                 ]);
                                    }
                             }
                         }
                       }
                    }

                    $delete= DB::table('tmp_inv_in_detail')->where('inv_in_id','=',$id)->delete();
                    foreach ($cart as $key => $value) {
                      $insertdetail= DB::table('tmp_inv_in_detail')->insert([
                                     'inv_in_id'=>$id,
                                     'in_prod_id'=>$value->prodid,
                                     'in_detail_qty'=>$value->qty,
                                     'in_detail_size'=>$value->prodsize,
                                     'in_detail_color'=>$value->prodcolor,
                                     'in_detail_public'=>$value->prodpublic
                                   ]);

                       $msprodstock = DB::table('tmp_inv_stock')->where('inv_stock_prodid',$value->prodid)->where('inv_stock_size',$value->prodsize)->where('inv_stock_color',$value->prodcolor)->first();

                       if (count($msprodstock)!=0) {
                           DB::table('tmp_inv_stock')->where('inv_stock_prodid',$value->prodid)->where('inv_stock_size',$value->prodsize)->where('inv_stock_color',$value->prodcolor)->update([
                               'inv_stock_qty' => $msprodstock->inv_stock_qty + $value->qty,
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


                    /** Start Update Stock Product  */
                    $cart2 = DB::table('cart_patch')->where('cartid', $userdata)->where('prodpublic','=',1)->orderBy('order', 'asc')->get();
                    foreach ($cart2 as $key => $varvalue) {

                        /**  Stock Product Varian */
                      $msvarstock2 = DB::table('ms_product_varian')
                                    ->where('prod_id',$varvalue->prodid)
                                    ->where('varian_size',$varvalue->prodsize)
                                    ->where('varian_color',$varvalue->prodcolor)
                                    ->first();

                       if(count($msvarstock2)>0){
                         $updatevar2= DB::table('ms_product_varian')
                                    ->where('varian_id',$msvarstock2->varian_id)
                                    ->update([
                                        'varian_stock' => $msvarstock2->varian_stock + $varvalue->qty,
                                    ]);
                       }else{
                           /** Stock Product  */
                         $msprodstock2 = DB::table('ms_products')
                                       ->where('prod_var_status','0')
                                       ->where('prod_id',$varvalue->prodid)
                                       ->first();

                             if(count($msprodstock2)>0){
                                 $updateprod2= DB::table('ms_products')
                                            ->where('prod_id',$msprodstock2->prod_id)
                                            ->update([
                                                'prod_stock' => $msprodstock2->prod_stock + $varvalue->qty,
                                            ]);
                           }
                       }


                    }

              /** End Update Stock Product  */

                 $cart = DB::table('cart_patch')->where('cartid', $userdata)->delete();
                return redirect()->to('backend/inventory/in')->with('success-create','Thank you for inventory in code '.$code.' success update!');


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
          $getinv = DB::table('ms_inventory_in')->where('inv_in_id',$id)->first();
            if( count($getinv)>0 ){
              $getdetail= DB::table('tmp_inv_in_detail')->where('inv_in_id',$getinv->inv_in_id)->get();

                 foreach ($getdetail as $key => $detail) {
                   $tmpstockmin = DB::table('tmp_inv_stock')
                   ->where('inv_stock_prodid',$detail->in_prod_id)
                   ->where('inv_stock_size',$detail->in_detail_size)
                   ->where('inv_stock_color',$detail->in_detail_color)
                   ->first();
                   if(count($tmpstockmin)> 0){
                       $hitstock=$tmpstockmin->inv_stock_qty - $detail->in_detail_qty;
                       if($hitstock >= 0){
                         DB::table('tmp_inv_stock')->where('inv_stock_prodid',$detail->in_prod_id)
                         ->where('inv_stock_size',$detail->in_detail_size)
                         ->where('inv_stock_color',$detail->in_detail_color)
                         ->update([
                             'inv_stock_qty' =>$hitstock,
                         ]);
                       }else{
                         DB::table('tmp_inv_stock')->where('inv_stock_prodid',$detail->in_prod_id)
                         ->where('inv_stock_size',$detail->in_detail_size)
                         ->where('inv_stock_color',$detail->in_detail_color)
                         ->update([
                             'inv_stock_qty' =>0,
                         ]);
                       }
                     }
                  }

                  DB::table('tmp_inv_in_detail')->where('inv_in_id', '=', $getinv->inv_in_id)->delete();
                  DB::table('ms_inventory_in')->where('inv_in_id', '=', $id)->delete();
                return redirect()->back()->with('success-delete','inventory delete success!');

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
