<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Cart;
use Session;

class CartController extends Controller{

    public function index(){
        $carts  = Cart::content();
        $member = DB::table('ms_members')->where('member_id',Session::get('memberid'))->first();
        $getaddr= DB::table('tmp_member_address')->where('member_id',Session::get('memberid'))->get();
        $getbank= DB::table('ms_bank')->where('bank_enable',1)->get();
        $midtrans = DB::table('t_module_options')->where('code','serverKey')->first();

        Session::forget('orderid1');
        Session::forget('voucher_code');
        Session::forget('voucher_type');
        Session::forget('voucher_value');

        return view('web.cart',[
            'carts' => $carts,
            'member'=> $member,
            'addr'  => $getaddr,
            'banks' => $getbank,
            'midtrans' => $midtrans
        ]);
    }

    public function addcart(){
        $prodid     = Input::get('prodid');
        $prodname   = Input::get('prodname');
        $color      = Input::get('color');
        $size       = Input::get('size');
        $qty        = Input::get('qty');
        $price      = Input::get('price');
        $image      = Input::get('image');
        $url        = Input::get('url');

        // CHECK STOCK
        $getvariant = DB::table('ms_product_varian')
                      ->where('prod_id',$prodid)
                      ->where('varian_color','=',$color)
                      ->where('varian_size','=',$size)
                      ->first();

        if ($getvariant->varian_stock < $qty) {

            $array = [];
            $array[1] = 2;

            return json_encode($array);
            exit;
        }

        Cart::add($prodid,$prodname,$qty,$price,["size"=>$size,"color"=>$color,"image"=>$image,"url"=>$url]);

        $carts          = Cart::content();
        $cartitems      = '';
        $notifitems     = '';
        $totalcart      = 0;

        foreach ($carts as $cart) {
            $cartitems .= ' <div class="top-cart-item clearfix">
                                <div class="top-cart-item-image">
                                    <a href="'.url("products/".$cart->options["url"]).'"><img src="'.asset($cart->options["image"]).'" alt="'.$cart->name.'" /></a>
                                </div>
                                <div class="top-cart-item-desc">
                                    <a href="shop-detail.html" class="t400">'.$cart->name.'</a>
                                    <span class="top-cart-item-price">'.number_format($cart->price,0,",",".").'</span>
                                    <span class="top-cart-item-quantity">x '.$cart->qty.'</span>
                                </div>
                            </div>';
            $totalcart = $totalcart + ($cart->price*$cart->qty);
        }

        $cartaction = ' <span class="fleft top-checkout-price t600 font-secondary" style="color: #333;">'.number_format($totalcart,0,',','.').'</span>
                        <a href="'.url("cart").'" class="button button-dark button-circle button-small nomargin fright" style="font-size:12px !important;color:#fff !important;background-color:#D8AB6C !important;">View Cart</a>';

        // NOTIF ADD TO CART

        $notifitems .= '<table class="table">
                            <tbody>';
                            foreach ($carts as $cartnotif) {
        $notifitems .= '        <tr>
                                    <td style="font-weight:bold;">'.$cartnotif->qty.'</td>
                                    <td style="font-weight:bold;">'.$cartnotif->name.'</td>
                                    <td>'.$cart->options["color"].'</td>
                                    <td>'.$cart->options["size"].'</td>
                                    <td style="width:50px;">IDR</td>
                                    <td style="text-align:right;width:100px;">'.number_format($cartnotif->price*$cartnotif->qty,0,',','.').'</td>
                                </tr>';
                            }
        $notifitems .= '    </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" style="border-top:3px solid #1ABC9C;font-weight:bold;">TOTAL</td>
                                    <td style="border-top:3px solid #1ABC9C;width:50px;">IDR</td>
                                    <td style="border-top:3px solid #1ABC9C;text-align:right;font-weight:bold;width:100px;">'.number_format($totalcart,0,',','.').'</td>
                                </tr>
                            </tfoot>
                        </table>';

        $array = [];
        $array[1] = 1;
        $array[2] = Cart::count();
        $array[3] = $cartitems;
        $array[4] = $cartaction;
        $array[5] = $notifitems;

        return json_encode($array);
    }

    public function checkvoucher(){
        $code   = Input::get('voucher_code');
        $now    = date('Y-m-d');
        $array  = [];

        // CHECK VOUCHER
        $getvoucher = DB::table('ms_voucher')->where('voucher_code',$code)->first();
        if (count($getvoucher) == 0) {
            $array[0] = 0;
            return json_encode($array);
        }else {

            // CHECK VALID
            $getvalid = DB::table('ms_voucher')
                        ->where('voucher_status',1)
                        ->where('voucher_code',$code)
                        ->where('voucher_start_date','>=',$getvoucher->voucher_start_date)
                        ->where('voucher_end_date','<=',$getvoucher->voucher_end_date)
                        ->first();
            if (count($getvalid) == 0) {
                $array[0] = 1;
                return json_encode($array);
            } else {

                // CHECK LIMIT
                $getlimit = DB::table('tmp_voucher_usage')->where('voucher_id',$getvalid->voucher_id)->count();
                if ($getlimit >= $getvalid->voucher_limit_usage) {
                    $array[0] = 2;
                    return json_encode($array);
                }else {

                    // CHECK LOGIN MEMBER
                    if (Session::has('memberid')) {
                        $getlimituser = DB::table('tmp_voucher_usage')->where('voucher_id',$getvalid->voucher_id)->where('member_id',Session::get('memberid'))->count();
                        if ($getlimituser >= $getvalid->voucher_limit_user) {
                            $array[0] = 3;
                            return json_encode($array);
                        } else {
                            if($getvalid->voucher_type == 3){
                                $array[0] = 5;
                                return json_encode($array);
                            } else {
                                Session::set('voucher_code',$code);
                                Session::set('voucher_type',$getvalid->voucher_type);
                                Session::set('voucher_value',$getvalid->voucher_value);
                                $array[0] = 4;
                                if ($getvalid->voucher_type == 1) {
                                    $array[1] = '- '.number_format($getvalid->voucher_value,0,',','.');
                                } elseif($getvalid->voucher_type == 3) {
                                    $array[1] = 'Free Shipping';
                                } else {
                                    $array[1] = '- '.$getvalid->voucher_value.'%';
                                }

                                $array[2] = $getvalid->voucher_value;
                                $array[3] = $getvalid->voucher_type;
                                return json_encode($array);
                            }
                        }

                    } else {
                        Session::set('voucher_code',$code);
                        Session::set('voucher_type',$getvalid->voucher_type);
                        Session::set('voucher_value',$getvalid->voucher_value);
                        $array[0] = 4;
                        if ($getvalid->voucher_type == 1) {
                            $array[1] = number_format($getvalid->voucher_value,0,',','.');
                        } else {
                            $array[1] = $getvalid->voucher_value.'%';
                        }

                        $array[2] = $getvalid->voucher_value;
                        $array[3] = $getvalid->voucher_type;
                        return json_encode($array);

                    } // CHECK LOGIN MEMBER

                } // CHECK LIMIT

            } // CHECK VALID

        } // CHECK VOUCHER
    }

    public function removevoucher(){
        Session::forget('voucher_code');
        Session::forget('voucher_type');
        Session::forget('voucher_value');
        return 1;
    }

    public function updaterow(){
        $rowId  = Input::get('rowId');
        $qty    = Input::get('qty');

        $array = [];

        $cart = Cart::get($rowId);

        // CHECK STOCK
        $getproduct = DB::table('ms_products')->where('prod_id',$cart->id)->first();
        $getvariant = DB::table('ms_product_varian')
                      ->where('prod_id',$cart->id)
                      ->where('varian_color',$cart->options["color"])
                      ->where('varian_size',$cart->options["size"])
                      ->first();
        // $stock_tmp = $cart->qty + $getproduct->prod_stock;

        if ($getvariant->varian_stock < $qty) {
            $array[0] = 0;
        }else {
            Cart::update($rowId, $qty);
            // $stock_cal = $stock_tmp - $qty;

            // DB::table('ms_products')->where('prod_id',$cart->id)->update([
            //     'prod_stock' => $stock_cal
            // ]);

            $array[0] = 1;
        }

        $carts      = Cart::content();
        $selectrow  = Cart::get($rowId);

        $cartcontent    = ' <td class="cart-product-remove">
                                <a href="javascript:void(0)" class="remove" title="Remove this item" onclick="removerow(\''.$rowId.'\')"><i class="icon-trash2"></i></a>
                            </td>
                            <td class="cart-product-thumbnail">
                                <a href="'.url("products/".$selectrow->options["url"]).'">
                                    <img width="64" height="64" src="'.asset($selectrow->options["image"]).'" alt="'.$selectrow->name.'">
                                </a>
                            </td>
                            <td class="cart-product-name">
                                <a href="'.url("products/".$selectrow->options["url"]).'">'.$selectrow->name.'</a>
                            </td>
                            <td class="cart-product-color">
                                '.$selectrow->options["color"].'
                            </td>
                            <td class="cart-product-size">
                                '.$selectrow->options["size"].'
                            </td>
                            <td class="cart-product-price">
                                <span class="amount">'.number_format($selectrow->price,0,",",".").'</span>
                            </td>
                            <td class="cart-product-quantity">
                                <div class="quantity clearfix">
                                    <input type="button" value="-" class="minus" onclick="getquantity(\''.$rowId.'\',\'minus\')">
                                    <input type="text" name="quantity" class="qty" value="'.$selectrow->qty.'"/>
                                    <input type="button" value="+" class="plus" onclick="getquantity(\''.$rowId.'\',\'plus\')">
                                </div>
                            </td>
                            <td class="cart-product-subtotal">
                                <span class="amount">'.number_format($selectrow->qty*$selectrow->price,0,',','.').'</span>
                            </td>';


        $cartitems      = '';
        $totalcart      = 0;

        foreach ($carts as $cart) {
            $cartitems .= ' <div class="top-cart-item clearfix">
                                <div class="top-cart-item-image">
                                    <a href="'.url("products/".$cart->options["url"]).'"><img src="'.asset($cart->options["image"]).'" alt="'.$cart->name.'" /></a>
                                </div>
                                <div class="top-cart-item-desc">
                                    <a href="shop-detail.html" class="t400">'.$cart->name.'</a>
                                    <span class="top-cart-item-price">'.number_format($cart->price,0,",",".").'</span>
                                    <span class="top-cart-item-quantity">x '.$cart->qty.'</span>
                                </div>
                            </div>';
            $totalcart = $totalcart + ($cart->price*$cart->qty);
        }

        $cartaction = ' <span class="fleft top-checkout-price t600 font-secondary" style="color: #333;">'.number_format($totalcart,0,',','.').'</span>
                        <a href="'.url("cart").'" class="button button-dark button-circle button-small nomargin fright" style="font-size:12px !important;color:#fff !important;background-color:#D8AB6C !important;">View Cart</a>';

        $array[1] = Cart::count();
        $array[2] = $cartcontent;
        $array[3] = $cartitems;
        $array[4] = $cartaction;

        return json_encode($array);

    }

    public function removerow(){
        $rowId = Input::get('rowId');

        $cartrow = Cart::get($rowId);

        // STOCK UPDATE
        $getproduct = DB::table('ms_products')->where('prod_id',$cartrow->id)->first();
        // DB::table('ms_products')->where('prod_id',$cartrow->id)->update([
        //     'prod_stock' => $getproduct->prod_stock + $cartrow->qty
        // ]);

        Cart::remove($rowId);

        $carts = Cart::content();
        $cartcontent    = '';
        $cartitems      = '';
        $totalcart      = 0;
        $array          = [];

        if (Cart::count() == 0) {
            $cartaction = ' <span class="fleft top-checkout-price t600 font-secondary" style="color: #333;">0</span>
                            <a href="'.url("cart").'" class="button button-dark button-circle button-small nomargin fright" style="font-size:12px !important;color:#fff !important;background-color:#D8AB6C !important;">View Cart</a>';

            $array[1] = '0';
            $array[2] = $cartcontent;
            $array[3] = $cartitems;
            $array[4] = $cartaction;
        }else{
            foreach ($carts as $cart) {
                $cartcontent .= '   <tr class="cart_item" id="'.$cart->rowId.'">
                                        <td class="cart-product-remove">
                                            <a href="javascript:void(0)" class="remove" title="Remove this item" onclick="removerow(\''.$cart->rowId.'\')"><i class="icon-trash2"></i></a>
                                        </td>
                                        <td class="cart-product-thumbnail">
                                            <a href="'.url("products/".$cart->options["url"]).'">
                                                <img width="64" height="64" src="'.asset($cart->options["image"]).'" alt="'.$cart->name.'">
                                            </a>
                                        </td>
                                        <td class="cart-product-name">
                                            <a href="'.url("products/".$cart->options["url"]).'">'.$cart->name.'</a>
                                        </td>
                                        <td class="cart-product-color">
                                            '.$selectrow->options["color"].'
                                        </td>
                                        <td class="cart-product-size">
                                            '.$selectrow->options["size"].'
                                        </td>
                                        <td class="cart-product-price">
                                            <span class="amount">'.number_format($cart->price,0,",",".").'</span>
                                        </td>
                                        <td class="cart-product-quantity">
                                            <div class="quantity clearfix">
                                                <input type="button" value="-" class="minus" onclick="getquantity(\''.$cart->rowId.'\',\'minus\')">
                                                <input type="text" name="quantity" class="qty" value="'.$cart->qty.'"/>
                                                <input type="button" value="+" class="plus" onclick="getquantity(\''.$cart->rowId.'\',\'plus\')">
                                            </div>
                                        </td>
                                        <td class="cart-product-subtotal">
                                            <span class="amount">'.number_format($cart->qty*$cart->price,0,',','.').'</span>
                                        </td>
                                    </tr>';

                $cartitems .= ' <div class="top-cart-item clearfix">
                                    <div class="top-cart-item-image">
                                        <a href="'.url("products/".$cart->options["url"]).'"><img src="'.asset($cart->options["image"]).'" alt="'.$cart->name.'" /></a>
                                    </div>
                                    <div class="top-cart-item-desc">
                                        <a href="shop-detail.html" class="t400">'.$cart->name.'</a>
                                        <span class="top-cart-item-price">'.number_format($cart->price,0,",",".").'</span>
                                        <span class="top-cart-item-quantity">x '.$cart->qty.'</span>
                                    </div>
                                </div>';
                $totalcart = $totalcart + ($cart->price*$cart->qty);
            }

            $cartaction = ' <span class="fleft top-checkout-price t600 font-secondary" style="color: #333;">'.number_format($totalcart,0,',','.').'</span>
                            <a href="'.url("cart").'" class="button button-dark button-circle button-small nomargin fright" style="font-size:12px !important;color:#fff !important;background-color:#D8AB6C !important;">View Cart</a>';

            $array[1] = Cart::count();
            $array[2] = $cartcontent;
            $array[3] = $cartitems;
            $array[4] = $cartaction;
        }

        return json_encode($array);
    }

    public function getaddr(){
        $addrid     = $_POST['addrid'];
        $getaddr    = DB::table('tmp_member_address')->where('id',$addrid)->first();

        $html = '   '.$getaddr->first_name.'<br>
                    '.$getaddr->last_name.'<br>
                    '.$getaddr->address.'<br>
                    '.$getaddr->province.'<br>
                    '.$getaddr->city.'<br>
                    '.$getaddr->district.'<br>
                    '.$getaddr->poscode.'<br>
                    '.$getaddr->phone.'';

        return $html;
    }

    public function gotocheckout(){
        $getaddr = DB::table('tmp_member_address')->where('id',$_POST['addressid'])->first();
        $getmemb = DB::table('ms_members')->where('member_id',Session::get('memberid'))->first();
        $getvocvalid = DB::table('ms_voucher')->where('voucher_type',3)->where('voucher_status',1)->first();

        if(Session::has('voucher_code')){
            if(Session::get('voucher_type') == 3){
                if($getaddr->country_id > 0){
                    return 2;
                    exit;
                } else {
                    Session::set('total',Input::get('subtotal'));
                }
            } else {
                Session::set('voucher_code',Session::get('voucher_code'));
                Session::set('voucher_type',Session::get('voucher_type'));
                Session::set('voucher_value',Session::get('voucher_value'));
                Session::set('total',Input::get('total'));
            }
        } else {

            if (count($getvocvalid) > 0) {

                // CHECK VALID
                $getvalid = DB::table('ms_voucher')
                            ->where('voucher_status',1)
                            ->where('voucher_code',$getvocvalid->voucher_code)
                            ->where('voucher_start_date','>=',$getvocvalid->voucher_start_date)
                            ->where('voucher_end_date','<=',$getvocvalid->voucher_end_date)
                            ->first();
                if (count($getvalid) > 0) {

                    // CHECK LIMIT
                    $getlimit = DB::table('tmp_voucher_usage')->where('voucher_id',$getvalid->voucher_id)->count();
                    if ($getlimit < $getvalid->voucher_limit_usage) {

                        // CHECK LOGIN MEMBER
                        if (Session::has('memberid')) {
                            $getlimituser = DB::table('tmp_voucher_usage')->where('voucher_id',$getvalid->voucher_id)->where('member_id',Session::get('memberid'))->count();
                            if ($getlimituser < $getvalid->voucher_limit_user) {

                                if(Input::get('subtotal') >= $getvalid->voucher_min_value){
                                    if ($getvalid->voucher_value == 0) {
                                        Session::set('voucher_code',$getvocvalid->voucher_code);
                                        Session::set('voucher_type',$getvocvalid->voucher_type);
                                        Session::set('voucher_value',Input::get('cost'));
                                        Session::set('total',Input::get('subtotal')+Input::get('cost')-Session::get('voucher_value'));
                                    } else {
                                        if (Input::get('cost') <= $getvalid->voucher_value) {
                                            Session::set('voucher_code',$getvocvalid->voucher_code);
                                            Session::set('voucher_type',$getvocvalid->voucher_type);
                                            Session::set('voucher_value',Input::get('cost'));
                                            Session::set('total',Input::get('subtotal')+Input::get('cost')-Session::get('voucher_value'));
                                        }else {
                                            Session::set('voucher_code',$getvocvalid->voucher_code);
                                            Session::set('voucher_type',$getvocvalid->voucher_type);
                                            Session::set('voucher_value',$getvocvalid->voucher_value);
                                            Session::set('total',Input::get('subtotal')+Input::get('cost')-Session::get('voucher_value'));
                                        }
                                    }

                                }else {
                                    Session::set('total',Input::get('total'));
                                }

                            } else {
                                Session::set('total',Input::get('total'));
                            }

                        } // CHECK LOGIN MEMBER

                    } else {// CHECK LIMIT
                        Session::set('total',Input::get('total'));
                    }
                } else { // CHECK VALID
                    Session::set('total',Input::get('total'));
                }
            }else {
                Session::set('total',Input::get('total'));
            }
        }

        // Session::set('province',Input::get('province'));
        // Session::set('city',Input::get('city'));
        // Session::set('postalcode',Input::get('postalcode'));
        // Session::set('district',Input::get('district'));
        // Session::set('courier',Input::get('courier'));
        // Session::set('cost',Input::get('cost'));
        // Session::set('subtotal',Input::get('subtotal'));
        // Session::set('total',Input::get('total'));
        //
        // Session::set('billing_name',$_POST['billing_name']);
        // Session::set('billing_address',$_POST['billing_address']);
        // Session::set('billing_email',$_POST['billing_email']);
        // Session::set('billing_phone',$_POST['billing_phone']);
        //
        // Session::set('shipping_name',$_POST['shipping_name']);
        // Session::set('shipping_address',$_POST['shipping_address']);
        // Session::set('shipping_email',$_POST['shipping_email']);
        // Session::set('shipping_phone',$_POST['shipping_phone']);

        if (Input::get('paymethod') == 2) {
          $minus = Session::get('subtotal') * 3 / 100;
          $tot   = Session::get('total') + $minus;
          Session::set('charge',$minus);
          Session::set('total',$tot);
        }


        Session::set('province',$getaddr->province);
        Session::set('city',$getaddr->city);
        Session::set('postalcode',$getaddr->poscode);
        Session::set('district',$getaddr->district);

        if ($getaddr->country_id == 0) {
            Session::set('courier',Input::get('services'));
        } else {
            Session::set('courier',Input::get('services'));
        }

        Session::set('paymethod',Input::get('paymethod'));
        Session::set('paybank',Input::get('paybank'));
        Session::set('cost',Input::get('cost'));
        Session::set('subtotal',Input::get('subtotal'));

        Session::set('billing_name',$getaddr->first_name);
        Session::set('billing_address',$getaddr->address);
        Session::set('billing_email',$getmemb->member_email);
        Session::set('billing_phone',$getaddr->phone);

        Session::set('shipping_name',$getaddr->first_name);
        Session::set('shipping_address',$getaddr->address);
        Session::set('shipping_email',$getmemb->member_email);
        Session::set('shipping_phone',$getaddr->phone);

        return 1;
    }

}
