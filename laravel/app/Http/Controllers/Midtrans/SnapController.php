<?php

namespace App\Http\Controllers\Midtrans;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use DB;
use App\Veritrans\Midtrans;

class SnapController extends Controller
{
    public function __construct()
    {
        $getserverkey   = DB::table('t_module_options')->where('module','midtrans')->where('code','serverKey')->first();
        $getproduct     = DB::table('t_module_options')->where('module','midtrans')->where('code','isProduction')->first();

        if (empty($getproduct->value)) {
            if ($getproduct->value == 'true') {
                $status = true;
            }else {
                $status = false;
            }
        }else {
            $status = false;
        }

        if (empty($getserverkey->value)) {
            $keymidtrans = $getserverkey->default_value;
        }else {
            $keymidtrans = $getserverkey->value;
        }

        Midtrans::$serverKey    = $keymidtrans;
        Midtrans::$isProduction = $status;
    }

    public function snap()
    {
        return view('snap_checkout');
    }

    public function token()
    {
        error_log('masuk ke snap token adri ajax');
        $midtrans   = new Midtrans;
        $orderid    = Session::get('orderid1');

        $row = DB::table('sum_orders')
                ->where('sum_orders.order_id','=',$orderid)
                ->first();

        $detail = DB::table('tmp_order_detail')
                ->leftjoin('ms_products','ms_products.prod_id','=','tmp_order_detail.prod_id')
                ->where('tmp_order_detail.order_id','=',$orderid)
                ->get();

        $transaction_details = array(
            'order_id'      => $row->order_id,
            'gross_amount'  => $row->order_total
        );

        foreach($detail as $value){
            $items[] = array(
                'prod_id'   => $value->prod_id,
                'price'     => $value->price_item,
                'quantity'  => $value->detail_qty,
                'name'      => $value->prod_name,
            );
        };

            $items[] = array(
                'prodid'    => 1,
                'price'     => $row->shipping_cost,
                'quantity'  => 1,
                'name'      => 'Shipping '.$row->shipping_courier,
            );

            $items[] = array(
                'prodid'    => 1,
                'price'     => $row->payment_code,
                'quantity'  => 1,
                'name'      => 'Payment Code',
            );

        if (!empty($row->voucher_code)) {
            // CHECK VOUCHER
            $voucher = DB::table('ms_voucher')->where('voucher_code',$row->voucher_code)->first();
            if ($voucher->voucher_type == 2) {
                $calculate= $row->sub_total * $row->voucher_value / 100;
                $gettotal = $row->sub_total + $row->shipping_cost - $calculate;

                $items[] = array(
                    'prodid'    => 1,
                    'price'     => '-'.$calculate,
                    'quantity'  => 1,
                    'name'      => 'Voucher - '.$row->voucher_code,
                );
            } else {
                $items[] = array(
                    'prodid'    => 1,
                    'price'     => '-'.$row->voucher_value,
                    'quantity'  => 1,
                    'name'      => 'Voucher - '.$row->voucher_code,
                );
            }
        }

        if ($row->payment_service == 2) {
          $items[] = array(
              'prodid'    => 1,
              'price'     => '+'.$row->disc_reward,
              'quantity'  => 1,
              'name'      => 'CC Charge(+3%)',
          );
        }

        // Populate customer's billing address
        $billing_address = array(
            'first_name'    => $row->billing_name,
            'address'       => $row->billing_address,
            'city'          => $row->billing_city,
            'postal_code'   => $row->billing_poscode,
            'phone'         => $row->billing_phone,
        );

        // Populate customer's shipping address
        $shipping_address = array(
            'first_name'    => $row->customer_name,
            'address'       => $row->customer_address,
            'city'          => $row->order_city,
            'postal_code'   => $row->order_poscode,
            'phone'         => $row->customer_phone,
        );

        // Populate customer's Info
        $customer_details = array(
            'first_name'        => $row->customer_name,
            'email'             => $row->customer_email,
            'phone'             => $row->customer_phone,
            'billing_address'   => $billing_address,
            'shipping_address'  => $shipping_address
        );

        $enable_pay[] = 'credit_card';

        $credit_card = array(
            'secure'        => true
        );

        // Data yang akan dikirim untuk request redirect_url.
        // Uncomment 'credit_card_3d_secure' => true jika transaksi ingin diproses dengan 3DSecure.
        $transaction_data = array(
            'transaction_details'   => $transaction_details,
            'item_details'          => $items,
            'customer_details'      => $customer_details,
            'enabled_payments'      => $enable_pay,
            'credit_card'           => $credit_card
        );

        try
        {
            $snap_token = $midtrans->getSnapToken($transaction_data);
            //return redirect($vtweb_url);
            echo $snap_token;
        }
        catch (Exception $e)
        {
            return $e->getMessage;
        }
    }

    public function finish(Request $request)
    {
        $result = $request->input('result_data');
        $result = json_decode($result);
        // echo $result->status_message. '<br>';
        // echo 'RESULT <br><pre>';
        // var_dump($result);
        // echo '</pre>' ;
        // exit;

        if (empty($result)) {
            return redirect('/');
        }

        $getmessage = explode(',',$result->status_message);
        // dd($getmessage);
        if ($getmessage[0] == 'Success') {
            DB::table('sum_orders')->where('order_id','=',$result->order_id)->update([
                'payment_status'    => 2,
                'order_status'      => 1
            ]);

            Session::forget('orderid1');
            if (Session::get('memberid')) {
                return redirect('thankyou/'.$result->order_id);
                // return redirect('user/profile');
            }else {
                return redirect('thankyou/'.$result->order_id);
                // return redirect('check/order')->with('success','Thank you for payment confirmation sent, your payment will be processed 1x24 hours!!');
            }

        } else {
            return redirect('checkout/finish/'.$result->order_id);
        }
    }

    public function notification()
    {
        $midtrans = new Midtrans;
        echo 'test notification handler';
        $json_result = file_get_contents('php://input');
        $result = json_decode($json_result);

        if($result){
            $notif = $midtrans->status($result->order_id);
        }

        error_log(print_r($result,TRUE));

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    DB::table('sum_orders')->where('order_id','=',$order_id)->update([
                        'payment_status' => 3,
                    ]);
                    echo "Transaction order_id: " . $order_id ." is challenged by FDS";
                } else {
                    // TODO set payment status in merchant's database to 'Success'
                    echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
                    DB::table('sum_orders')->where('order_id','=',$order_id)->update([
                        'payment_status' => 2,
                    ]);
                }
            }
        } else if ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
        } else if($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
        } else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
        }

    }
}
