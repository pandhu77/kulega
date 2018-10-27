<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use DB;
use Cart;
use Session;
use Datetime;
use Helper;
use HelperEmail;
use PHPMailer;


class CheckoutController extends Controller{

    public function index(){
        // if (Cart::count() == 0) {
        //     return redirect('/');
        // } else {
            if (Session::has('paybank')) {
                $bank   = DB::table('ms_bank')->where('id',Session::get('paybank'))->first();
            } else {
                $bank   = DB::table('ms_bank')->where('bank_enable',1)->first();
            }

            $getsetting = DB::table('t_theme_setting')->where('active',1)->first();
            $carts      = Cart::content();

            if (!Session::has('paycode')) {
              $paycode    = rand(100,500);
              Session::put('paycode',$paycode);
            } else {
              $paycode = Session::get('paycode');
            }


            if (Session::get('memberid')) {
                $member = DB::table('ms_members')->where('member_id',Session::get('memberid'))->first();
            }else {
                $member = DB::table('ms_members')->first();
            }

            return view('web.checkout',[
                'bank'  => $bank,
                'carts' => $carts,
                'member'=> $member,
                'paycode'=> $paycode
            ]);
        // }
    }

    private function generateorder($orderid){
        $cekorder = DB::table('sum_orders')->where('order_id',$orderid)->orderBy('order_id','DESC')->first();
        if (count($cekorder) == 1) {
            $increase = $orderid + 1;
            return $this->generateorder($increase);
        } else {
            return $orderid;
        }
    }

    public function store(Request $request){
        if (Session::get('memberid')) {
            $memberid   = Session::get('memberid');
        }else {
            $memberid   = 0;
        }

        $now        = new Datetime();

        $rules = [
            'billing_name'      => 'required',
            'billing_address'   => 'required',
            'billing_email'     => 'required|email',
            'billing_phone'     => 'required|numeric',
            'shipping_name'     => 'required',
            'shipping_address'  => 'required',
            'shipping_email'    => 'required|email',
            'shipping_phone'    => 'required|numeric',
            // 'payment_service'   => 'required'
        ];

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        } else {

            // return redirect()->back()->withInput()->with('validate','Complete');
            // exit;

            // if(Session::has('orderid1')) {
            //     if(Input::get('payment_service') == 1) {
            //         return redirect('user/order/payment-confirmation/'.Session::get('orderid1'));
            //     } else {
            //         return redirect()->back()->withInput()->with('validate','Complete');;
            //     }
            // }

            // CHECK VOUCHER
            if (Session::has('voucher_code')) {

                $getvoucher = DB::table('ms_voucher')->where('voucher_code',Session::get('voucher_code'))->first();
                if (count($getvoucher) == 0) {
                    return redirect()->back()->with('error_stock',Session::get('voucher_code'));
                } else {

                    // CHECK VALID VOUCHER
                    $getvalid = DB::table('ms_voucher')->where('voucher_code',Session::get('voucher_code'))->where('voucher_start_date','>=',$getvoucher->voucher_start_date)->where('voucher_end_date','<=',$getvoucher->voucher_end_date)->first();
                    if (count($getvalid) == 0) {
                        return redirect()->back()->with('error_stock',Session::get('voucher_code'));
                    }else {

                        // CHECK LIMIT VOUCHER
                        $getlimit = DB::table('tmp_voucher_usage')->where('voucher_id',$getvalid->voucher_id)->count();
                        if ($getlimit >= $getvalid->voucher_limit_usage) {
                            return redirect()->back()->with('error_stock',Session::get('voucher_code'));
                        }else {

                            // CHECK LOGIN MEMBER
                            if (Session::has('memberid')) {
                                $getlimituser = DB::table('tmp_voucher_usage')->where('voucher_id',$getvalid->voucher_id)->where('member_id',Session::get('memberid'))->count();
                                if ($getlimituser >= $getvalid->voucher_limit_user) {
                                    return redirect()->back()->with('error_stock',Session::get('voucher_code'));
                                }

                            } // CHECK LOGIN MEMBER

                        } // CHECK LIMIT VOUCHER

                    } // CHECK VALID VOUCHER

                } // CHECK VOUCHER VOUCHER

            }

            // CEK STOCK
            $cart = Cart::content();

            foreach ($cart as $key => $value1) {
                $getproduct1 = DB::table('ms_products')->where('prod_id',$value1->id)->first();
                $getvarian1  = DB::table('ms_product_varian')
                                ->where('prod_id',$value1->id)
                                ->where('varian_color',$value1->options['color'])
                                ->where('varian_size',$value1->options['size'])
                                ->first();
                if ($getvarian1->varian_stock < $value1->qty) {
                    return redirect()->back()->with('error_stock',$getproduct1->prod_title);
                }
            }

            foreach ($cart as $key => $value2) {
                $getproduct2    = DB::table('ms_products')->where('prod_id',$value2->id)->first();
                $getvarian2  = DB::table('ms_product_varian')
                                ->where('prod_id',$value2->id)
                                ->where('varian_color',$value2->options['color'])
                                ->where('varian_size',$value2->options['size'])
                                ->first();
                $calculate      = $getvarian2->varian_stock - $value2->qty;
                DB::table('ms_product_varian')
                ->where('prod_id',$value2->id)
                ->where('varian_color',$value2->options['color'])
                ->where('varian_size',$value2->options['size'])
                ->update([
                    'varian_stock' => $calculate
                ]);
            }


            $orderid = date('Ym').'0001';

            // CEK ORDER ID
            $getid = $this->generateorder($orderid);

            if(Session::get('voucher_type') == 3){
                $vouchers = Session::get('cost');
            }else {
                $vouchers = Session::get('voucher_value');
            }

            if (Session::has('charge')) {
              $charge = Session::get('charge');
            }else {
              $charge = 0;
            }

            $insert = DB::table('sum_orders')->insert([
                'order_id'          => $getid,
                'campaignid'        => Session::get('idcampaign');
                'member_id'         => $memberid,
                'order_date'        => $now,
                'order_total'       => Session::get('total')+Session::get('paycode'),
                'voucher_code'      => Session::get('voucher_code'),
                'voucher_value'     => Session::get('voucher_value'),
                'disc_reward'       => $charge,
                'sub_total'         => Session::get('subtotal'),
                'payment_code'      => Session::get('paycode'),
                'payment_service'   => Session::get('paymethod'),
                'payment_bank'      => Session::get('paybank'),
                'order_status'      => 0,
                'payment_status'    => 0,
                'order_delivery'    => 0,
                'customer_name'     => Session::get('shipping_name'),
                'customer_email'    => Session::get('shipping_email'),
                'customer_address'  => Session::get('shipping_address'),
                'customer_phone'    => Session::get('shipping_phone'),
                'order_poscode'     => Session::get('postalcode'),
                'order_province'    => Session::get('province'),
                'order_city'        => Session::get('city'),
                'order_district'    => Session::get('district'),
                'shipping_courier'  => Session::get('courier'),
                'shipping_cost'     => Session::get('cost'),
                'dilivery_method'   => 'ship',
                'billing_name'      => Session::get('billing_name'),
                'billing_email'     => Session::get('billing_email'),
                'billing_phone'     => Session::get('billing_phone'),
                'billing_address'   => Session::get('billing_address'),
                'billing_poscode'   => Session::get('postalcode'),
                'billing_province'  => Session::get('province'),
                'billing_city'      => Session::get('city'),
                'billing_district'  => Session::get('district'),
                'order_created_at'  => $now,
            ]);

            if($insert){

                $getvoucher = DB::table('ms_voucher')->where('voucher_code',Session::get('voucher_code'))->first();

                if (Session::has('voucher_code')) {
                    if (Session::has('memberid')) {
                        DB::table('tmp_voucher_usage')->insert([
                            'voucher_id'=> $getvoucher->voucher_id,
                            'member_id' => Session::get('memberid'),
                            'usage'     => 1
                        ]);

                        DB::table('tmp_voucher_log')->insert([
                            'member_id'     => Session::get('memberid'),
                            'member_name'   => Session::get('billing_name'),
                            'member_email'  => Session::get('billing_email'),
                            'voucher_id'  => $getvoucher->voucher_id,
                            'created_at'    => new DateTime()
                        ]);
                    } else {
                        DB::table('tmp_voucher_usage')->insert([
                            'voucher_id'=> $getvoucher->voucher_id,
                            'member_id' => 0,
                            'usage'     => 1
                        ]);

                        DB::table('tmp_voucher_log')->insert([
                            'member_id'     => 0,
                            'member_name'   => Session::get('billing_name'),
                            'member_email'  => Session::get('billing_email'),
                            'voucher_id'  => $getvoucher->voucher_id,
                            'created_at'    => new DateTime()
                        ]);
                    }
                }

                $order  = DB::table('sum_orders')->where('member_id','=',$memberid)->orderby('order_id','=','desc')->first();
                $content= Cart::content();
                foreach ($content as $row) {
                    $insert = DB::table('tmp_order_detail')->insert([
                        'order_id'          => $order->order_id,
                        'prod_id'           => $row->id,
                        'prod_color'        => $row->options['color'],
                        'prod_size'         => $row->options['size'],
                        'price_item'        => $row->price,
                        'detail_subtotal'   => $row->price*$row->qty,
                        'detail_qty'        => $row->qty,
                    ]);
                }

                $resultHtml=HelperEmail::emailOrder($order->order_id);
                $checkmember=DB::table('ms_members')->where('member_id','=',$memberid)->first();

                // GET MAIL
                $mailmodule = DB::table('t_module_options')->where('module','mail')->get();
                $websetting = DB::table('cms_config')->first();
                $array      = [];

                foreach ($mailmodule as $key => $mail) {
                    if (empty($mail->value)) {
                        $array[$mail->code] = $mail->default_value;
                    }else {
                        $array[$mail->code] = $mail->value;
                    }
                }

                //PHPMailer Object
                $mail               = new PHPMailer;
                $mail->isSMTP();
                $mail->Host         = $array['Host'];
                $mail->SMTPAuth     = true;
                $mail->Username     = $array['Username'];
                $mail->Password     = $array['Password'];
                $mail->SMTPSecure   = $array['SMTPsecure'];
                $mail->Port         = $array['Port'];

                $mail->From     = $websetting->email;
                $mail->FromName = $websetting->site_name;

                $mail->addAddress(Session::get('billing_email'));

                $mail->isHTML(true);

                $mail->Subject  = "Order Verification ".date('l, d F Y H:i',strtotime($order->order_created_at));
                $mail->Body     = $resultHtml;
                $mail->AltBody  = "ini link anda plan";
                if(!$mail->send()){
                    Session::set('orderid1',$order->order_id);
                    $this->forgetSession();

                    if ($order->payment_service == 2) {
                        return redirect()->back();
                    }else {
                        return redirect('confirm-payment/'.Session::get('orderid1'));
                    }

                    // return redirect()->back()->withInput()->with('validate','fail');
                    // if($order->payment_service == 2){
                    //     Session::set('orderid1',$order->order_id);
                    //     $this->forgetSession();
                    //     return Redirect()->to('vtweb')->with('midtrans','midtrans');
                    // }else{
                    //     Session::set('orderid1',$order->order_id);
                    //     $this->forgetSession();
                    //     // return Redirect()->to('checkout/finish/'.$order->order_id.'')->with('error_get','Thank you, order success (Mail not send)');
                    //     return redirect('confirm-payment/'.$order->order_id);
                    // }
                } else {
                    Session::set('orderid1',$order->order_id);
                    $this->forgetSession();

                    if ($order->payment_service == 2) {
                        return redirect()->back();
                    }else {
                        return redirect('confirm-payment/'.Session::get('orderid1'));
                    }

                    // return redirect()->back()->withInput()->with('validate','Complete');
                    // if($order->payment_service==2){
                    //     Session::set('orderid1',$order->order_id);
                    //     $this->forgetSession();
                    //     return Redirect()->to('vtweb')->with('midtrans','midtrans');
                    // } else {
                    //     Session::set('orderid1',$order->order_id);
                    //     $this->forgetSession();
                    //     // return redirect('checkout/finish/'.$order->order_id.'')->with('success','Thank you, order success !');
                    //     return redirect('confirm-payment/'.$order->order_id);
                    // }
                }
            }else{
                return Redirect()->back()->with('error-order','Sorry something is error !');
            }
        }
    }

    private function forgetSession()
    {
        Session::forget('province');
        Session::forget('city');
        Session::forget('postalcode');
        Session::forget('district');
        Session::forget('courier');
        Session::forget('cost');
        Session::forget('subtotal');
        Session::forget('total');
        Session::forget('voucher_code');
        Session::forget('voucher_type');
        Session::forget('voucher_value');

        Session::forget('billing_name');
        Session::forget('billing_address');
        Session::forget('billing_email');
        Session::forget('billing_phone');

        Session::forget('shipping_name');
        Session::forget('shipping_address');
        Session::forget('shipping_email');
        Session::forget('shipping_phone');

        Session::forget('paycode');

        Cart::destroy();
    }

    public function checkoutfinish($orderid){
        $getsetting = DB::table('t_theme_setting')->where('active',1)->first();
        $memberid = Session::get('memberid');
        $order = DB::table('sum_orders')
                ->join('ms_members','ms_members.member_id','=','sum_orders.member_id')
                ->where('sum_orders.member_id','=',$memberid)
                ->where('sum_orders.order_id','=',$orderid)
                ->first();

        return view('themes.'.$getsetting->name.'.template.checkout-success',[
            'order'     => $order,
            'orderid'   => $orderid
        ]);
    }

}
