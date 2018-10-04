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

class ProductController extends Controller
{
    public function index(){

        $search         = Input::get('search');
        $category       = Input::get('category');
        $view           = Input::get('view',20);
        $searchcategory = DB::table('lk_product_category')->where('kateg_url',$category)->first();
        $banners        = DB::table('cms_banner')->where('enable',1)->get();
        $allcategory    = DB::table('lk_product_category')->where('kateg_enable',1)->get();

        if (isset($search)) {
          $products = DB::table('ms_products')->where('prod_enable',1)->where('prod_name','LIKE','%'.$search.'%')->paginate($view);
          $countall = DB::table('ms_products')->where('prod_enable',1)->where('prod_name','LIKE','%'.$search.'%')->count();

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
        //         $products = DB::table('ms_products')->where('prod_enable',1)->where('prod_category','LIKE','%'.$searchcategory->kateg_id.'%')->Orderby('prod_order','ASC')->paginate(1000)->setPath('products?category='.$category);
        //     }else {
        //         $products = DB::table('ms_products')->where('prod_enable',1)->where('prod_category','LIKE','%'.$searchcategory->kateg_id.'%')->Orderby('prod_order','ASC')->paginate($view)->setPath('products?category='.$category);
        //     }
        //
        //     $countall     = DB::table('ms_products')->where('prod_enable',1)->where('prod_category','LIKE','%'.$searchcategory->kateg_id.'%')->count();
        // } else {
            if ($view == 'all') {
                $products = DB::table('ms_products')->where('prod_enable',1)->paginate(1000);
            }else {
                $products = DB::table('ms_products')->where('prod_enable',1)->paginate($view);
            }

            $countall     = DB::table('ms_products')->where('prod_enable',1)->count();

            if (!isset($category) || $category == 'all') {
              $category     = 'all';
            }

        // }

        return view('web.products',[
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

        $category       = Input::get('category');
        $banners        = DB::table('cms_banner')->where('enable',1)->get();
        $getsetting     = DB::table('t_theme_setting')->where('active',1)->first();

        $now        = date('Y-m-d');
        $products   = DB::table('ms_products')
                        ->where('prod_enable','=',1)
                        ->where('prod_url','=',$url)
                        ->first();

        if(count($products) >0){

            $images     = DB::table('tmp_product_image')->where('prod_id','=',$products->prod_id)->get();
            $varcolor   = DB::table('ms_product_varian')->where('prod_id',$products->prod_id)->groupBy('varian_color')->get();
            $varsize    = DB::table('ms_product_varian')->where('prod_id',$products->prod_id)->groupBy('varian_size')->get();
            $allprod    = DB::table('ms_products')
                            ->where('prod_enable','=',1)
                            ->get();

            return view('web.products-detail',[
                'banners'   => $banners,
                'category'  => $category,
                'products'  => $products,
                'images'    => $images,
                'allprod'   => $allprod,
                'varcolor'  => $varcolor,
                'varsize'   => $varsize
            ]);

        } else {
            return Redirect()->back()->with('error_get','Sorry, product is not available !');
        }
    }

    public function getproduct(){
        $idprod     = $_POST['idprod'];
        $products   = DB::table('ms_products')->where('prod_id',$idprod)->first();

        $html = '   <div class="row product" style="padding:0 15px;">
                        <input type="hidden" name="prod_id" value="'.$products->prod_id.'">
                        <input type="hidden" name="prod_name" value="'.$products->prod_name.'">
                        <input type="hidden" name="prod_price" value="'.$products->prod_price.'">
                        <input type="hidden" name="front_image" value="'.$products->front_image.'">
                        <input type="hidden" name="prod_url" value="'.$products->prod_url.'">
                        <div class="col_half">

                            <div class="product-image">
                                <div class="fslider" data-pagi="false" data-arrows="false" data-thumbs="true">
                                    <div class="flexslider">
                                        <div class="slider-wrap" data-lightbox="gallery">

                                                <a href="javascript::void(0)" title="Shading" data-lightbox="gallery-item">
                                                    <img src="'.url($products->front_image).'" alt="'.$products->prod_title.'">
                                                </a>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col_half col_last product-desc">

                            <div class="product-price" style="margin-bottom:10px;"><ins style="color:#d4a3a0;">'.$products->prod_code.'</ins> <i style="color:#000;">'.$products->prod_title.'</i></div>
                            <br>
                            <div class="clearfix"></div>
                            <div class="product-price" style="margin:10px 0px;"><ins>IDR '.number_format($products->prod_price,0,',','.').'</ins></div>

                            <div class="clear"></div>

                            <form class="cart nobottommargin clearfix" method="post" enctype="multipart/form-data">
                                <div class="col-md-6" style="padding-left:0px;">
                                    <div class="quantity clearfix">
                                        Quantity<br><br>
                                        <input type="button" value="-" class="minus" onclick="getquantity(\'minus\')">
                                        <input type="text" step="1" min="1"  name="quantity" value="1" title="Qty" class="qty" size="4" />
                                        <input type="button" value="+" class="plus" onclick="getquantity(\'plus\')">
                                    </div>
                                </div>
                                <div class="col-md-6" id="stock-notif">';
                                    if($products->prod_stock > 0){
                    // $html .= '          <div class="alert alert-success" style="margin-bottom:0px;padding:8px;text-align:right;background-color:transparent;border-color:transparent;">
                    //                         Stock : '.$products->prod_stock.'
                    //                     </div>';
                                    }else{
                    $html .= '          <div class="alert alert-danger" style="margin-bottom:0px;padding:8px;text-align:right;background-color:transparent;border-color:transparent;">
                                            Out Of Stock
                                        </div>';
                                    }
                    $html .= '  </div>
                                <br>
                                <button type="button" class="add-to-cart button nomargin" onclick="addtocart()" id="buttonadd">Add to cart</button>
                            </form>

                            <div class="clear"></div>
                            <div class="line" style="margin-bottom:0px; !important"></div>

                            <div class="clearfix"></div>
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                DETAILS
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse in" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body" style="border-top:none;padding-left:0px;padding-right:0px;">
                                            '.nl2br($products->prod_desc).'
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';

            return $html;
    }
}
