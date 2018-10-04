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
class ProductsController extends Controller
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
     * Generate Automatic Code .
     */
     public function generateCode(){
      $intcode=input::get('intcode');
      $len= strlen($intcode);
      $checkprod=DB::select(DB::raw("SELECT max(SUBSTR(prod_code, -4)) as codeproduct, prod_code  FROM ms_products where  SUBSTR(prod_code, 1, $len)='".$intcode."' limit 1"));
      if($checkprod==null){
          $code='0001';
      }else{
        foreach ($checkprod as $key => $check) {
           $fullcode=$intcode."-".$check->codeproduct;
           $checkvalid= DB::table('ms_products')->where('prod_code','=',$fullcode)->first();
           if(count($checkvalid) > 0){
               $hitung= intval($check->codeproduct) + 1;
               if(strlen($hitung)==1){
                 $code='000'.$hitung;
               }elseif(strlen($hitung)==2){
                 $code='00'.$hitung;
               }elseif(strlen($hitung)==3){
                 $code='0'.$hitung;
               }else{
                 $code= $hitung;
               }
           }else{
             $code='0001';
           }

        }

      }
      return $code;
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
           $prod=DB::table('ms_products')->get();

           return view('backend.product.index',[
             'brand'=>$brand,
             'prod'=>$prod,
             'kateg'=>$kateg
           ]);
         }else{
       return Redirect::back()->withErrors(['Sorry, No Access']);
       }
     }

     public function addcategory(){
         $kateg_name    = Input::get('kateg_name');
         $kateg_url     = Input::get('kateg_url');
         $array = [];

         $check = DB::table('lk_product_category')->where('kateg_url',$kateg_url)->first();
         if (count($check) == 1) {
            $array[0] = 1;
         } else {
             $input = DB::table('lk_product_category')->insert([
                'kateg_name'      => Input::get('kateg_name'),
                'kateg_url'       => Input::get('kateg_url'),
                'kateg_parent'    => 0,
                'kateg_enable'    => 1,
                'kateg_created_at'=> new DateTime(),
                'kateg_created_by'=> Auth::user()->id
             ]);

             $categparent = DB::table('lk_product_category')
                            ->where('kateg_enable','=',1)
                            ->where('kateg_parent','=',0)
                            ->get();
             $categparent1= DB::table('lk_product_category')
                            ->where('kateg_enable','=',1)
                            ->get();
             $categparent2= DB::table('lk_product_category')
                            ->where('kateg_enable','=',1)
                            ->get();

             $html = '';

             foreach($categparent as $parent){
             $html .= ' <div class="col-sm-12" style="padding-left:0%;">
                            <input type="checkbox" class="" name="prod_category[]" id="'.$parent->kateg_id.'" value="'.$parent->kateg_id.'">
                            <label class="control-label">'.$parent->kateg_name.'</label>
                        </div>';
                 foreach($categparent1 as $parent1){
                     if($parent->kateg_id == $parent1->kateg_parent){
             $html .= '  <div class="col-sm-12" style="padding-left:5%;">
                             <input type="checkbox" class="" name="prod_category[]" id="'.$parent1->kateg_id.'" value="'.$parent1->kateg_id.'">
                             <label class="control-label">'.$parent1->kateg_name.'</label>
                         </div>';
                         foreach($categparent2 as $parent2){
                             if($parent1->kateg_id == $parent2->kateg_parent){
             $html .= '          <div class="col-sm-12" style="padding-left:10%;">
                                     <input type="checkbox" class="" name="prod_category[]"="'.$parent1->kateg_id.'" value="'.$parent2->kateg_id.'">
                                     <label class="control-label">'.$parent2->kateg_name.'</label>
                                 </div>';
                             }
                         }
                     }
                 }
             }

            $array[0] = 2;
            $array[1] = $html;
         }

         return json_encode($array);
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
          $brand=DB::table('lk_brand')->where('brand_enable','=',1)->get();
          $categparent=DB::table('lk_product_category')
                    ->where('kateg_enable','=',1)
                    ->where('kateg_parent','=',0)->get();
          $categparent1=DB::table('lk_product_category')
                    ->where('kateg_enable','=',1)->get();
          $categparent2=DB::table('lk_product_category')
                    ->where('kateg_enable','=',1)->get();

          return view('backend.product.create',[
            'brand'=>$brand,
            'categparent'=>$categparent,
            'categparent1'=>$categparent1,
            'categparent2'=>$categparent2
          ]);
      }else{
        return Redirect::back()->withErrors(['Sorry, No Access']);
      }
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

          if(empty(Input::get('prod_enable'))){
            $enable=0;
          }else{
            $enable=1;
          }
          $status=$enable;
          $nilai=strlen(url(''));
          $len=$nilai+1;
        //   $frontimage   =substr(Input::get('front_image'),$len);
          if(input::get('prod_category')!==null){
            $category     =implode(",",input::get('prod_category'));
          }else{
            $category='';
          }
        //   $prod_fromdate   =Input::get('fromDate');
        //   $prod_untildate   =Input::get('untilDate');
          $prod_code        =Input::get('prod_code');
          $name             =Input::get('prod_name');
          $title            =Input::get('prod_title');
          $url              =Input::get('prod_url');
        //   $brand            =Input::get('prod_brand_id');
          $weight           =Input::get('prod_weight');
        //   $length           =Input::get('prod_lenght');
        //   $width            =Input::get('prod_width');
        //   $height           =Input::get('prod_height');
        //   $volume           =Input::get('prod_volume');
          $price            =Input::get('prod_price');
          $desc             =Input::get('prod_desc');
        //   $proddetail       =Input::get('prod_detail');
        //   $spek             =Input::get('prod_spek');
          // $prodstock       =Input::get('prod_stock');

          $discount       =Input::get('prod_disc');
          $varstatus       =Input::get('prod_var_status');
          $now          = new DateTime();
          $userid= auth::user()->id;

          // validate the info, create rules for the inputs
             $rules = [
                'prod_code'     => 'required',
                'prod_title'    => 'required',
                'prod_url'      => 'required|unique:ms_products',
                // 'prod_stock'    => 'required|numeric',
                'prod_weight'   => 'required|numeric',
                'prod_price'    => 'required|numeric',
                'image.*'       => 'required',
                'primary_image' => 'required'
            ];

            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
                // dd($validator->errors()->all());

            } else {

          $insert = DB::table('ms_products')->insertGetId([
            // 'prod_startdate'    => $prod_fromdate,
            // 'prod_enddate'      => $prod_untildate,
            // 'prod_approval'     => 'admin',
            'prod_order'         => $_POST['prod_order'],
            'prod_code'         => $prod_code,
            // 'prod_brand_id'     => $brand,
            'prod_name'         => $title,
            'prod_title'        => $title,
            // 'prod_brand_id'     => $brand,
            'prod_category'     => $category,
            'prod_url'          => $url,
            'prod_desc'         => $desc,
            // 'prod_detail'       => $proddetail,
            // 'prod_spek'         => $spek,
            // 'prod_stock'=>$prodstock,
            'prod_disc'  =>$discount,
            'prod_price'        => $price,
            'prod_weight'       => $weight,
            // 'prod_lenght'       => $length,
            // 'prod_width'        => $width,
            // 'prod_height'       => $height,
            // 'prod_volume'       => $volume,
            'prod_var_status'   => 1,
            'prod_enable'       => $status,
            // 'front_image'       => $frontimage,
            'prod_created_at'   => $now,
            'prod_created_by'   => $userid,
            // 'prod_stock'        => $_POST['prod_stock']
          ]);
          if($insert){
                /** Begin master product */
                $checkprod=DB::table('ms_products')->where('prod_created_by','=',$userid)->orderby('prod_created_at','=','desc')->first();
                /** End master product */

                /** Begin input detail image */
                $image   =input::get('image');
                if(!empty($image)){
                  foreach ($image as $key => $img) {
                      DB::table('tmp_product_image')->insert([
                        'prod_id' => $checkprod->prod_id,
                        'image_small'=>substr($img,$len),
                        'image_thumb'=>substr($img,$len),
                        'image_large'=>substr($img,$len),
                      ]);

                      if ($key == Input::get('primary_image')) {
                          DB::table('ms_products')->where('prod_id',$insert)->update([
                             'front_image' =>  substr($img,$len)
                          ]);
                      }
                  }
                }

                /** End input detail image */

                /** Begin input varian  */
                // $varianname   =input::get('varianname');
                $size     = Input::get('size');
                $color    = Input::get('color');
                $colorhex = Input::get('color_hex');
                $stock    = Input::get('stock');
                // $qty   =input::get('qty');
                if(!empty($size)){
                  foreach ($size as $key => $sizes) {

                      DB::table('ms_product_varian')->insert([
                        'prod_id'         => $checkprod->prod_id,
                        // 'varian_name'=>$varian,
                        'varian_size'     => strtoupper($sizes),
                        'varian_color'    => strtoupper($color[$key]),
                        'varian_color_hex'=> $colorhex[$key],
                        'varian_stock'    => $stock[$key],
                      ]);
                  }
                  /** End input varian */
                }

                // $token = DB::table('t_module_options')->where('module','=','jurnal')->where('code','=','token')->first();
                // if(count($token) > 0){
                //   $data = array(
                //     'product' => array(
                //       "name" => $title,
                //       "product_code" => "PI".str_pad($checkprod->prod_id, 4, '0', STR_PAD_LEFT),
                //       "description" => strip_tags($desc),
                //       "sell_price_per_unit" => $price,
                //       "buy_price_per_unit" => 0,
                //       "is_bought" => false,
                //       "is_sold" => true,
                //       "taxable_buy" => true,
                //       "taxable_sell" => true,
                //       "sell_account_name" => "Pendapatan",
                //       "sell_account_number" => "4-40000",
                //       "buy_account_name" => "Beban Pokok Pendapatan",
                //       "buy_account_number" => "5-50000",
                //       "buy_tax_id" => 18,
                //       "sell_tax_id" => 26,
                //       "track_inventory" => "true",
                //       "init_date" => "18-05-2016",
                //       "init_price" => 0,
                //       "init_quantity" => $_POST['prod_stock'],
                //       "source" => null,
                //       "inventory_asset_account" => "Inventory",
                //       "inventory_asset_account_number" => "1-1400",
                //       "unit_name" => "Pcs",
                //       "custom_id" => "idp".$checkprod->prod_id
                //     )
                //   );
                //
                //   $inserJurnal = Helper::callApi($data, $token->default_value, 'products');
                //
                //   if($inserJurnal['response'] == false){
                //       return redirect()->to('backend/product')->with('error',$inserJurnal['message']);
                //   }
                // }

            return redirect()->to('backend/product')->with('success-create','Thank you for product add!');

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
          $row=DB::table('ms_products')->where('prod_id','=',$id)->first();
          if(count($row) > 0)
          {
            $vendor=DB::table('ms_vendors')->where('vendor_id','=',$row->prod_approval_by)->first();
            $brand=DB::table('lk_brand')->where('brand_enable','=',1)->get();
            $categparent=DB::table('lk_product_category')
                      ->where('kateg_enable','=',1)
                      ->where('kateg_parent','=',0)->get();
            $categparent1=DB::table('lk_product_category')
                      ->where('kateg_enable','=',1)->get();
            $categparent2=DB::table('lk_product_category')
                      ->where('kateg_enable','=',1)->get();
            $expkateg=explode(",",$row->prod_category);
            $tmpimage=DB::table('tmp_product_image')->where('prod_id','=',$id)->get();
            $tmpvarian=DB::table('ms_product_varian')->where('prod_id','=',$id)->get();


            return view('backend.product.edit',[
              'row'=>$row,
              'tmpimage'=>$tmpimage,
              'tmpvarian'=>$tmpvarian,
              'brand'=>$brand,
              'categparent'=>$categparent,
              'categparent1'=>$categparent1,
              'categparent2'=>$categparent2,
              'expkateg'=>$expkateg,
              'vendor'=>$vendor
            ]);
          }else{
            return Redirect::back();
          }

      }else{
        return Redirect::back()->withErrors(['Sorry, No Access']);
      }
    }
    public function deleteprodutimage($imgid){
        DB::table('tmp_product_image')
        ->where('image_id',$imgid)->delete();
        return redirect()->back()->with('success-delete','Your imaginary file has been deleted!');
    }
    public function deleteprodutvarian($varid){
      DB::table('ms_product_varian')
      ->where('varian_id',$varid)->delete();
      return redirect()->back()->with('success-delete','Your Varian file has been deleted!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $auth = $this->CheckAuth();

      if($auth == true){
        # code...
        // validate the info, create rules for the inputs


        if(empty(Input::get('prod_enable'))){
          $enable=0;
        }else{
          $enable=1;
        }
        $status=$enable;
        $nilai=strlen(url(''));
        $len=$nilai+1;
        // $frontimage   =substr(Input::get('front_image'),$len);
        if(input::get('prod_category')!==null){
          $category     =implode(",",input::get('prod_category'));
        }else{
          $category='';
        }
        // $prod_fromdate   =Input::get('fromDate');
        // $prod_untildate   =Input::get('untilDate');
        $prod_code       =Input::get('prod_code');
        $name         =Input::get('prod_name');
        $title        =Input::get('prod_title');
        $url          =Input::get('prod_url');
        // $brand        =Input::get('prod_brand_id');
        $weight        =Input::get('prod_weight');
        // $length       =Input::get('prod_lenght');
        // $width        =Input::get('prod_width');
        // $height        =Input::get('prod_height');
        // $volume        =Input::get('prod_volume');
        $price        =Input::get('prod_price');
        $desc        =Input::get('prod_desc');
        // $proddetail        =Input::get('prod_detail');
        // $spek       =Input::get('prod_spek');
        // $prodstock       =Input::get('prod_stock');

        $discount       =Input::get('prod_disc');
        $varstatus       =1;
        $now          = new DateTime();
        $userid= auth::user()->id;
        $rules = array(
            'prod_title'    => 'required',
            'prod_url'      => 'required',
            // 'prod_stock'    => 'required|numeric',
            'prod_weight'   => 'required|numeric',
            'prod_price'    => 'required|numeric',
            'image.*'       => 'required',
            'primary_image' => 'required'
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
          return redirect()->back()
          ->withErrors($validator) // send back all errors to the login form
          ->withInput(); // send back the input (not the password) so that we can repopulate the form
        } else {


          $update = DB::table('ms_products')->where('prod_id','=',$id)->update([
            // 'prod_startdate'=>$prod_fromdate,
            // 'prod_enddate'=>$prod_untildate,
            // 'prod_approval'=>'admin',
            'prod_order'         => $_POST['prod_order'],
            'prod_code'=>$prod_code,
            // 'prod_brand_id'=>$brand,
            'prod_name'  =>$title,
            'prod_title'  =>$title,
            // 'prod_brand_id'=>$brand,
            'prod_category'=>$category,
            'prod_url'  =>$url,
            'prod_desc'  =>$desc,
            // 'prod_detail'=>$proddetail,
            // 'prod_spek'=>$spek,
            // 'prod_stock'=>$prodstock,
            'prod_disc'  =>$discount,
            'prod_price'  =>$price,
            'prod_weight'=>$weight,
            // 'prod_lenght'=>$length,
            // 'prod_width'  =>$width,
            // 'prod_height'  =>$height,
            // 'prod_volume'=>$volume,
            'prod_var_status'=>$varstatus,
            'prod_enable'  =>$status,
            // 'front_image'=>$frontimage,
            'prod_updated_at'=>$now,
            'prod_updated_by'=>$userid,
            // 'prod_stock'        => $_POST['prod_stock']
          ]);
            /** Begin input detail image */
            $imagedit=input::get('imageedit');
            $imageidedit=input::get('imageidedit');

            //fungsi update image
            if(!empty($imageidedit)){
              foreach ($imageidedit  as $key => $imgid) {
                  DB::table('tmp_product_image')->where('image_id','=',$imgid)->update([
                    'prod_id' => $id,
                    'image_small'=>substr($imagedit[$key],$len),
                    'image_thumb'=>substr($imagedit[$key],$len),
                    'image_large'=>substr($imagedit[$key],$len),
                  ]);

                  if ($imgid == Input::get('primary_image')) {
                      DB::table('ms_products')->where('prod_id',$id)->update([
                         'front_image' =>  substr($imagedit[$key],$len)
                      ]);
                  }
               }
            }
            //fungsi insert new i
            $image   =input::get('image');
            if(!empty($image)){
              foreach ($image as $key => $img) {

                  DB::table('tmp_product_image')->insert([
                    'prod_id' => $id,
                    'image_small'=>substr($img,$len),
                    'image_thumb'=>substr($img,$len),
                    'image_large'=>substr($img,$len),
                  ]);

                  if ($key == Input::get('primary_image')) {
                      DB::table('ms_products')->where('prod_id',$id)->update([
                         'front_image' =>  substr($img,$len)
                      ]);
                  }
              }
            }
            /** End input detail image */

          if($varstatus==1){

            /** Begin update varian  */
            $varianidedit=input::get('varianidedit');
            // $variannameedit=input::get('variannameedit');
            $sizeedit=input::get('sizeedit');
            $coloredit=input::get('coloredit');
            $color_hexedit=input::get('color_hexedit');
            $stockedit=input::get('stockedit');

            if(!empty($varianidedit)){
              foreach ($varianidedit  as $key => $varid) {
                  DB::table('ms_product_varian')->where('varian_id','=',$varid)->update([
                    'prod_id' => $id,
                    'varian_color'=>strtoupper($coloredit[$key]),
                    'varian_color_hex'=>$color_hexedit[$key],
                    'varian_size'=>strtoupper($sizeedit[$key]),
                    'varian_stock'=>$stockedit[$key],
                  ]);
               }
            }
            /** End update varian  */

            /** Begin input varian  */
            // $varianname   =input::get('varianname');
            $size   =input::get('size');

            $color  =input::get('color');
            $colorhex   =input::get('color_hex');
            $stock   =input::get('stock');
            if(!empty($size)){
              foreach ($size as $key => $sizes) {

                  DB::table('ms_product_varian')->insert([
                    'prod_id' => $id,
                    'varian_size'=>strtoupper($sizes),
                    'varian_color'=>strtoupper($color[$key]),
                    'varian_color_hex'=>$colorhex[$key],
                    'varian_stock'=>$stock[$key],
                  ]);
              }
            }
            $update = DB::table('ms_products')->where('prod_id','=',$id)->update([
              'prod_stock'=>'',
            ]);
              /** End input varian */
          }elseif($varstatus==0){
            DB::table('ms_product_varian')
            ->where('prod_id',$id)->delete();
          }

          return redirect()->to('backend/product')->with('success-create','Thank you for product update!');
        }
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

             $i = DB::table('ms_products')->where('prod_id',$id)->delete();
             if($i > 0)
             {
               DB::table('tmp_product_image')
               ->where('prod_id',$id)->delete();
               DB::table('ms_product_varian')
               ->where('prod_id',$id)->delete();
               return redirect()->back()->with('success-delete','Your Product file has been deleted!');
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

     private function CheckAuth()
     {
       $url = request()->segment(1)."/".request()->segment(2);
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
