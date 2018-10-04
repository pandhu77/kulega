<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Input;
use Validator;
use File;
use Redirect;
use DateTime;
use Session;
use Auth;



class VendorProductsController extends Controller
{

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
     if(Session::get('vendorid')){

         $vendorid=Session::get('vendorid');
         $brand=DB::table('lk_brand')->where('brand_enable','=',1)->get();
         $kateg=DB::table('lk_product_category')->where('kateg_enable','=',1)->get();
         $prod=DB::table('ms_products')
                 ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
                 ->where('prod_approval','=','vendor')
                 ->where('prod_approval_by','=',$vendorid)
                 ->get();



         return view('frontend.vendor.product.index',[
           'brand'=>$brand,
           'prod'=>$prod,
           'kateg'=>$kateg
         ]);
       }else{
         Session::flash('error_must_login','You must Login');
         return Redirect('vendor/login');
       }
   }


       /**
        * Show the form for creating a new resource.
        *
        * @return \Illuminate\Http\Response
        */
       public function create()
       {
           if(Session::get('vendorid')){
               $vendorid=Session::get('vendorid');
               $brand=DB::table('lk_brand')->where('brand_enable','=',1)->get();
               $categparent=DB::table('lk_product_category')
                         ->where('kateg_enable','=',1)
                         ->where('kateg_parent','=',0)->get();
               $categparent1=DB::table('lk_product_category')
                         ->where('kateg_enable','=',1)->get();
               $categparent2=DB::table('lk_product_category')
                         ->where('kateg_enable','=',1)->get();

               //CODE GENERATE
               return view('frontend.vendor.product.create',[
                 'brand'=>$brand,
                 'categparent'=>$categparent,
                 'categparent1'=>$categparent1,
                 'categparent2'=>$categparent2
               ]);
           }else{
             Session::flash('error_must_login','You must Login');
             return Redirect('vendor/login');
           }
       }

       public function store(Request $request){
         if(Session::get('vendorid')){
             $vendorid=Session::get('vendorid');
             if(!is_dir("assets/img/vendor")){
               $newvendor=mkdir("assets/img/vendor");
             }
             if (!is_dir("assets/img/vendor/$vendorid")) {
                 $newforder=mkdir("assets/img/vendor/$vendorid");
             }

              $file = $request->file('front_image');
              // Disini proses mendapatkan judul dan memindahkan letak gambar ke folder image
              if ($file !==null) {
                $fileName   = $file->getClientOriginalName();
                $file->move("assets/img/vendor/$vendorid", $fileName);

              }else{
                $fileName='';
              }
               $fileimage= "assets/img/vendor/$vendorid/$fileName";



             if(input::get('prod_category')!==null){
               $category     =implode(",",input::get('prod_category'));
             }else{
               $category='';
             }
            //  $prod_fromdate   =Input::get('fromDate');
            //  $prod_untildate   =Input::get('untilDate');
             $prod_code        =Input::get('prod_code');
             $name             =Input::get('prod_name');
             $title            =Input::get('prod_title');
             $url              =Input::get('prod_url');
             $brand            =Input::get('prod_brand_id');
             $weight           =Input::get('prod_weight');
             $length           =Input::get('prod_lenght');
             $width            =Input::get('prod_width');
             $height           =Input::get('prod_height');
             $volume           =Input::get('prod_volume');
             $price            =Input::get('prod_price');
             $desc             =Input::get('prod_desc');
             $proddetail       =Input::get('prod_detail');
             $spek             =Input::get('prod_spek');
             $varstatus       =Input::get('prod_var_status');
             $now          = new DateTime();

             // validate the info, create rules for the inputs
                $rules = [
                   'prod_code'    => 'required|unique:ms_products',
                   'prod_brand_id' => 'required',
                   'prod_category' => 'required',
                   'prod_var_status' =>'required',
                   'prod_price'    =>'required',
               ];

               $validator = Validator::make(Input::all(), $rules);

               if ($validator->fails()) {
                   return redirect()->back()
                       ->withErrors($validator)
                       ->withInput();
                   // dd($validator->errors()->all());
               } else {

             $insert = DB::table('ms_products')->insert([
              //  'prod_startdate'=>$prod_fromdate,
              //  'prod_enddate'=>$prod_untildate,
               'prod_approval'=>'vendor',
               'prod_approval_by'=>$vendorid,
               'prod_code'=>$prod_code,
               'prod_brand_id'=>$brand,
               'prod_name'  =>$name,
               'prod_title'  =>$title,
               'prod_brand_id'=>$brand,
               'prod_category'=>$category,
               'prod_url'  =>$url,
               'prod_desc'  =>$desc,
               'prod_detail'=>$proddetail,
               'prod_spek'=>$spek,
               'prod_price'  =>$price,
               'prod_weight'=>$weight,
               'prod_lenght'=>$length,
               'prod_width'  =>$width,
               'prod_height'  =>$height,
               'prod_volume'=>$volume,
               'prod_var_status'=>$varstatus,
               'prod_enable'  =>0,
               'front_image'=>$fileimage,
               'prod_created_at' =>$now,
             ]);
             if($insert){
                   /** Begin master product */
                   $checkprod=DB::table('ms_products')->where('prod_approval','=','vendor')->where('prod_approval_by','=',$vendorid)->orderby('prod_created_at','=','desc')->first();
                   /** End master product */

                   /** Begin input detail image */
                   $image = $request->file('image');
                   if(!empty($image)){
                     foreach ($image as $img) {
                       $imgfile   = $img->getClientOriginalName();
                       $img->move("assets/img/vendor/$vendorid", $imgfile);
                       $imgfilelocation="assets/img/vendor/$vendorid/$imgfile";

                         DB::table('tmp_product_image')->insert([
                           'prod_id' => $checkprod->prod_id,
                           'image_small'=>$imgfilelocation,
                           'image_thumb'=>$imgfilelocation,
                           'image_large'=>$imgfilelocation,
                         ]);
                     }
                   }

                   /** End input detail image */
                   /** Begin input varian  */
                   // $varianname   =input::get('varianname');
                   $size   =input::get('size');
                   $color  =input::get('color');
                   $colorhex   =input::get('color_hex');
                   // $qty   =input::get('qty');
                   if(!empty($size)){
                     foreach ($size as $key => $sizes) {
                         DB::table('ms_product_varian')->insert([
                           'prod_id' => $checkprod->prod_id,
                           // 'varian_name'=>$varian,
                           'varian_size'=>$sizes,
                           'varian_color'=>$color[$key],
                           'varian_color_hex'=>$colorhex[$key],
                           // 'varian_stock'=>$qty[$key],
                         ]);
                     }
                     /** End input varian */
                   }

                 return redirect()->to('vendor/product')->with('success-create','Thank you for product add!');

               }else{
                 return Redirect()->back()->with('error','Sorry something is error !');
               }
             }
           }else{
             Session::flash('error_must_login','You must Login');
             return Redirect('vendor/login');
           }
       }

       public function edit($id)
       {
         if(Session::get('vendorid')){
             $vendorid=Session::get('vendorid');
             $row=DB::table('ms_products')->where('prod_id','=',$id)->first();
             if(count($row) > 0)
             {
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

               return view('frontend.vendor.product.edit',[
                 'row'=>$row,
                 'tmpimage'=>$tmpimage,
                 'tmpvarian'=>$tmpvarian,
                 'brand'=>$brand,
                 'categparent'=>$categparent,
                 'categparent1'=>$categparent1,
                 'categparent2'=>$categparent2,
                 'expkateg'=>$expkateg,
               ]);
             }else{
               return Redirect::back();
             }
         }else{
           Session::flash('error_must_login','You must Login');
           return Redirect('vendor/login');
         }
       }


       public function update(Request $request, $id)
       {


          if(Session::get('vendorid')){
             $vendorid=Session::get('vendorid');
             if(!is_dir("assets/img/vendor")){
               $newvendor=mkdir("assets/img/vendor");
             }
             if (!is_dir("assets/img/vendor/$vendorid")) {
                 $newforder=mkdir("assets/img/vendor/$vendorid");
             }


              $file = $request->file('front_image');
              // Disini proses mendapatkan judul dan memindahkan letak gambar ke folder image
              if ($file !==null) {
                $fileName   = $file->getClientOriginalName();
                $file->move("assets/img/vendor/$vendorid", $fileName);
                $fileimage= "assets/img/vendor/$vendorid/$fileName";
              }else{
                $front_image2 =Input::get('front_image2');
                $fileimage=$front_image2;
              }


             if(input::get('prod_category')!==null){
               $category     =implode(",",input::get('prod_category'));
             }else{
               $category='';
             }
            //  $prod_fromdate   =Input::get('fromDate');
            //  $prod_untildate   =Input::get('untilDate');
             $prod_code       =Input::get('prod_code');
             $name         =Input::get('prod_name');
             $title        =Input::get('prod_title');
             $url          =Input::get('prod_url');
             $brand        =Input::get('prod_brand_id');
             $weight        =Input::get('prod_weight');
             $length       =Input::get('prod_lenght');
             $width        =Input::get('prod_width');
             $height        =Input::get('prod_height');
             $volume        =Input::get('prod_volume');
             $price        =Input::get('prod_price');
             $desc        =Input::get('prod_desc');
             $proddetail        =Input::get('prod_detail');
             $spek       =Input::get('prod_spek');
             // $prodstock       =Input::get('prod_stock');

             // $discount       =Input::get('prod_disc');
             $varstatus       =Input::get('prod_var_status');
             $now          = new DateTime();
             $userid= auth::user()->id;
             $rules = array(
               'prod_code'    => 'required',
               'prod_brand_id' => 'required',
               'prod_category' => 'required',
               'prod_var_status' =>'required',
               'prod_price'    =>'required',
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
                //  'prod_startdate'=>$prod_fromdate,
                //  'prod_enddate'=>$prod_untildate,
                 'prod_code'=>$prod_code,
                 'prod_brand_id'=>$brand,
                 'prod_name'  =>$name,
                 'prod_title'  =>$title,
                 'prod_brand_id'=>$brand,
                 'prod_category'=>$category,
                 'prod_url'  =>$url,
                 'prod_desc'  =>$desc,
                 'prod_detail'=>$proddetail,
                 'prod_spek'=>$spek,
                 'prod_price'  =>$price,
                 'prod_weight'=>$weight,
                 'prod_lenght'=>$length,
                 'prod_width'  =>$width,
                 'prod_height'  =>$height,
                 'prod_volume'=>$volume,
                 'prod_var_status'=>$varstatus,
                 'front_image'=>$fileimage,
                 'prod_updated_at'=>$now,
               ]);
                 /** Begin input detail image */

                 //fungsi insert new i
                 $image = $request->file('image');
                 if(!empty($image)){
                   foreach ($image as $img) {
                     $imgfile   = $img->getClientOriginalName();
                     $img->move("assets/img/vendor/$vendorid", $imgfile);
                     $imgfilelocation="assets/img/vendor/$vendorid/$imgfile";
                       DB::table('tmp_product_image')->insert([
                         'prod_id' => $id,
                         'image_small'=>$imgfilelocation,
                         'image_thumb'=>$imgfilelocation,
                         'image_large'=>$imgfilelocation,
                       ]);
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
                   // $qtyedit=input::get('qtyedit');

                   if(!empty($varianidedit)){
                     foreach ($varianidedit  as $key => $varid) {
                         DB::table('ms_product_varian')->where('varian_id','=',$varid)->update([
                           'prod_id' => $id,
                           'varian_color'=>$coloredit[$key],
                           'varian_color_hex'=>$color_hexedit[$key],
                           'varian_size'=>$sizeedit[$key],
                           // 'varian_stock'=>$qtyedit[$key],
                         ]);
                      }
                   }
                   /** End update varian  */

                   /** Begin input varian  */
                   // $varianname   =input::get('varianname');
                   $size   =input::get('size');

                   $color  =input::get('color');
                   $colorhex   =input::get('color_hex');
                   // $qty   =input::get('qty');
                   if(!empty($size)){
                     foreach ($size as $key => $sizes) {

                         DB::table('ms_product_varian')->insert([
                           'prod_id' => $id,
                           'varian_size'=>$sizes,
                           'varian_color'=>$color[$key],
                           'varian_color_hex'=>$colorhex[$key],
                           // 'varian_stock'=>$qty[$key],
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
               return redirect()->to('vendor/product')->with('success-create','Thank you for product update!');


             }

             }else{
               Session::flash('error_must_login','You must Login');
               return Redirect('vendor/login');
             }
       }
       public function deleteprodutvarian($varid){
         DB::table('ms_product_varian')
         ->where('varian_id',$varid)->delete();
         return redirect()->back()->with('success-delete','Your Varian file has been deleted!');
       }
       public function deleteprodutimage($imgid){

         if(Session::get('vendorid')){
            $vendorid=Session::get('vendorid');
            $tmp= DB::table('tmp_product_image')
               ->where('image_id',$imgid)->first();
            $filename=$tmp->image_small;
            $filelocation=public_path();
            $filesub=SUBSTR($filelocation,0, -15);
            $path = $filesub.'/assets/img/vendor/'.$vendorid.'/'.$filename;

          if (!File::delete($path))
            {

              DB::table('tmp_product_image')
              ->where('image_id',$imgid)->delete();
              // DB::table('trip_gallery')->where('id', $detailid)->delete();
              // return Redirect()->back()->with('delete-error','Sorry something is error!');
             return redirect()->back()->with('success-delete','Your imaginary file has been deleted!');
            }
          else
            {
              DB::table('tmp_product_image')
              ->where('image_id',$imgid)->delete();
               return redirect()->back()->with('success-delete','Your imaginary file has been deleted!');
            }

          }else{
            Session::flash('error_must_login','You must Login');
            return Redirect('vendor/login');
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
          // $auth = $this->CheckAuth();
          //   if($auth == true){
          //     $checkuser=Auth::user()->access_id;
          //     if($checkuser==1){

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
            //   }else{
            //     return Redirect::back()->withErrors(['msg', 'No Access']);
            //   }
            // }else{
            //   return Redirect::back()->withErrors(['msg', 'No Access']);
            // }
        }

}
