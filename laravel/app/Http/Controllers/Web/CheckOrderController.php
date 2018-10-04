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


class CheckOrderController extends Controller{

    public function index(){
        $getsetting     = DB::table('t_theme_setting')->where('active',1)->first();

        return view('web.order-check');
    }

    public function getorder(){
        $orderid        = Input::get('orderid');
        $bank           = DB::table('ms_bank')->where('bank_enable',1)->get();
        $order          = DB::table('sum_orders')->where('order_id',$orderid)->first();
        $orderdetail    = DB::table('tmp_order_detail')
                            ->leftJoin('ms_products','ms_products.prod_id','=','tmp_order_detail.prod_id')
                            ->where('tmp_order_detail.order_id',$orderid)
                            ->get();

        $html = '';

        if (count($order) == 0) {

            $checklist = DB::table('sum_orders')->where('member_id',0)->where('billing_email',$orderid)->get();

            if (count($checklist) == 0) {
                return 0;
            } else {
                $html .= '  <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Order Date</th>
                                        <th>Status Payment</th>
                                        <th>Total</th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>';
                                    foreach($checklist as $list){
                $html .= '          <tr>
                                        <td>#'.$list->order_id.'</td>
                                        <td>'.date('d M Y',strtotime($list->order_date)).'</td>
                                        <td>';
                                                if ($list->payment_status == 0) {
                                                    $html .= '<span class="label label-primary">Waiting</span>';
                                                } elseif($list->payment_status == 1) {
                                                    $html .= '<span class="label label-warning">Waiting Confirm</span>';
                                                } elseif($list->payment_status == 2) {
                                                    $html .= '<span class="label label-success">Completed</span>';
                                                } elseif($list->payment_status == 3) {
                                                    $html .= '<span class="label label-danger">Cancelled</span>';
                                                }
                $html .= '              </td>
                                        <td>'.number_format($list->order_total,0,',','.').'</td>
                                        <td>';
                                            if($list->payment_status == 0){
                $html .= '                      <a href="'.url("confirm-payment/".$list->order_id).'" class="btn btn-info">Payment</a>';
                                            }
                $html .= '              </td>
                                    </tr>';
                                    }
                $html .= '      </tbody>
                            </table>';
            }

        } else {

            Session::set('orderid1',$orderid);

            $html .= '  <div class="col-md-4">
                            <h4>BILLING ADDRESS</h4>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td style="width:90px;">Name</td>
                                        <td>:</td>
                                        <td>'.$order->billing_name.'</td>
                                    </tr>
                                    <tr>
                                        <td style="width:90px;">Email</td>
                                        <td>:</td>
                                        <td>'.$order->billing_email.'</td>
                                    </tr>
                                    <tr>
                                        <td style="width:90px;">Phone</td>
                                        <td>:</td>
                                        <td>'.$order->billing_phone.'</td>
                                    </tr>
                                    <tr>
                                        <td style="width:90px;">Address</td>
                                        <td>:</td>
                                        <td>'.$order->billing_address.'</td>
                                    </tr>
                                    <tr>
                                        <td style="width:90px;">Poscode</td>
                                        <td>:</td>
                                        <td>'.$order->billing_poscode.'</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-4">
                            <h4>SHIPPING ADDRESS</h4>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td style="width:90px;">Name</td>
                                        <td>:</td>
                                        <td>'.$order->customer_name.'</td>
                                    </tr>
                                    <tr>
                                        <td style="width:90px;">Email</td>
                                        <td>:</td>
                                        <td>'.$order->customer_email.'</td>
                                    </tr>
                                    <tr>
                                        <td style="width:90px;">Phone</td>
                                        <td>:</td>
                                        <td>'.$order->customer_phone.'</td>
                                    </tr>
                                    <tr>
                                        <td style="width:90px;">Address</td>
                                        <td>:</td>
                                        <td>'.$order->customer_address.'</td>
                                    </tr>
                                    <tr>
                                        <td style="width:90px;">Poscode</td>
                                        <td>:</td>
                                        <td>'.$order->order_poscode.'</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-4">
                            <h4>ORDER</h4>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td style="width:120px;">Order Status</td>
                                        <td>:</td>
                                        <td>';
                                                if ($order->payment_status == 0) {
                                                    $html .= '<span class="label label-primary">Waiting</span>';
                                                } elseif($order->payment_status == 1) {
                                                    $html .= '<span class="label label-warning">Waiting Confirm</span>';
                                                } elseif($order->payment_status == 2) {
                                                    $html .= '<span class="label label-success">Completed</span>';
                                                } elseif($order->payment_status == 3) {
                                                    $html .= '<span class="label label-danger">Cancelled</span>';
                                                }
            $html .= '                   </td>
                                    </tr>
                                    <tr>
                                        <td style="width:120px;">Order Date</td>
                                        <td>:</td>
                                        <td>'.date("d/M/Y H:i:s",strtotime($order->order_date)).'</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-12" style="margin-top:20px;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th style="text-align:right;">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                    foreach($orderdetail as $details){
            $html .= '                  <tr>
                                            <td>'.$details->prod_name.'</td>
                                            <td>'.number_format($details->prod_price,0,',','.').'</td>
                                            <td>'.$details->detail_qty.'</td>
                                            <td style="text-align:right;">'.number_format($details->detail_subtotal,0,',','.').'</td>
                                        </tr>';
                                    }
            $html .= '              <tr>
                                        <td colspan="3" style="text-align:right;">Total</td>
                                        <td style="text-align:right;">'.number_format($order->sub_total,0,',','.').'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="text-align:right;">Shipping Cost</td>
                                        <td style="text-align:right;">'.number_format($order->shipping_cost,0,',','.').'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="text-align:right;"><strong>Grand Total</strong></td>
                                        <td style="text-align:right;"><strong>'.number_format($order->order_total,0,',','.').'</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>';

                        if($order->payment_status == 0){
            $html .= '  <div class="col-md-12" style="margin-top:70px;text-align:center;padding:0px;">
                            <h4 style="margin-bottom:0px;">MAKE A PAYMENT</h4>
                            <p style="width:100%;">Choose your payment method</p>
                            <div class="col-sm-offset-3 col-sm-3 col-xs-6 choosepay" id="banktrans" style="border-top:1px solid #eee;border:1px solid #eee;">
                                <a href="javascript:void(0)" onclick="getpayinfo()"><i class="fa fa-university fa-4x" aria-hidden="true"></i><br><br>Bank Transfer</a>
                            </div>
                            <div class="col-sm-3 col-xs-6 choosepay" style="border:1px solid #eee;" onclick="getsnap()">
                                <a href="javascript:void(0)"><i class="fa fa-cc fa-4x" aria-hidden="true"></i><br><br>Credit Card</a>
                            </div>
                        </div>';
                        }

            $html .= '  <div class="hidden" id="bankpay">
                            <div class="col-sm-offset-3 col-sm-6" style="margin-top:70px;text-align:center;border:1px solid #eee;padding-top:20px;padding-bottom:20px;">
                                <h3>Total<br>IDR '.number_format($order->order_total,0,',','.').'</h3>

                                <table class="table">';
                                    foreach($bank as $ba){
            $html .= '                  <tr>
                                            <td><img src="'.url($ba->bank_image).'" alt="'.$ba->bank_name.'" style="max-width:50px;max-height:50px;"></td>
                                            <td>'.$ba->bank_holder.'</td>
                                            <td>'.$ba->bank_noreg.'</td>
                                            <td>'.$ba->bank_desc.'</td>
                                        </tr>';
                                    }
            $html .= '           </table>
                            </div>

                            <div class="col-sm-offset-3 col-sm-6" style="margin-top:30px;text-align:center;">
                                <a href="'.url("user/order/payment-confirmation/".$order->order_id).'" class="btn btn-success" style="border-radius:0px;background-color:#000;border-color:#000;">Pay Now</a>
                            </div>
                        </div>';

        }

        return $html;
    }

}
