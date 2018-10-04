<?php

namespace App\Http\Controllers\Midtrans;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use DB;
use App\Veritrans\Veritrans;

class VtwebController extends Controller
{
    public function __construct()
    {
        Veritrans::$serverKey = 'VT-server-rFAn9pKYfPtKWBKqtX_Pj8Dv';

        //set Veritrans::$isProduction  value to true for production mode
        Veritrans::$isProduction = false;
    }

    public function vtweb()
    {
        $vt     = new Veritrans;
        $orderid= Session::get('orderid1');


        $row = DB::table('sum_orders')
                ->join('ms_members','ms_members.member_id','=','sum_orders.member_id')
                ->where('sum_orders.order_id','=',$orderid)
                ->first();


        if(count($row) > 0){
            $detail = DB::table('tmp_order_detail')
                ->leftjoin('ms_products','ms_products.prod_id','=','tmp_order_detail.prod_id')
                ->where('tmp_order_detail.order_id','=',$orderid)
                ->get();
            // $pickup = DB::table('sum_orders')
            //     ->leftjoin('tmp_pickup','sum_orders.pickup_point','=','tmp_pickup.id')
            //     ->join('ms_pickup','ms_pickup.pick_id','=','tmp_pickup.pick_id')
            //     ->where('sum_orders.order_id','=',$orderid)
            //     ->first();
        }

        $transaction_details = array(
            'order_id'      => $row->order_id,
            'gross_amount'  => $row->order_total,
        );

        foreach($detail as $value){
            $items[] = array(
                    'prod_id'   => $value->prod_id,
                    'price'     => $value->detail_subtotal,
                    'quantity'  => $value->detail_qty,
                    'name'      => $value->prod_name,
            );
        };

        if($row->disc_cart ==! null){
          $items[] = array(
                          'prodid'   =>  1,
                          'price'         => "-".$row->disc_cart,
                          'quantity'      =>  1,
                          'name'          => "Discount Shop(-)",
                    );
        }
      if($row->order_disc ==! null){
        $items[] = array(
                        'prodid'   =>  1,
                        'price'         => "-".$row->order_disc,
                        'quantity'      =>  1,
                        'name'          => "Discount Members(-)",
                  );
        }

    if($row->voucher_value ==! null){
        $items[] = array(
                        'prodid'   =>  1,
                        'price'         => "-".$row->voucher_value,
                        'quantity'      =>  1,
                        'name'          => "Voucher(-)",
                      );
      }
      if($row->disc_reward ==! null){
          $items[] = array(
                          'prodid'   =>  1,
                          'price'         => "-".$row->disc_reward,
                          'quantity'      =>  1,
                          'name'          => "Reward(-)",
                        );
      }

      if($row->shipping_cost ==! null){
      $items[] = array(
                      'prodid'   =>  1,
                      'price'         => $row->shipping_cost,
                      'quantity'      =>  1,
                      'name'          => "Shipping(+)",
                    );
      }
      if($row->service_cost ==! null){
        $items[] = array(
                        'prodid'   =>  1,
                        'price'         => $row->service_cost,
                        'quantity'      =>  1,
                        'name'          => "Service Charge(+)",
                  );
      }
      if($row->order_generate ==! null){
        $items[] = array(
                        'prodid'   =>  1,
                        'price'         => $row->order_generate,
                        'quantity'      =>  1,
                        'name'          => "Unique Code(+)",
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

        // Data yang akan dikirim untuk request redirect_url.
        // Uncomment 'credit_card_3d_secure' => true jika transaksi ingin diproses dengan 3DSecure.
        $transaction_data = array(
            'payment_type'   => 'vtweb',
            'vtweb'          => array(
                'credit_card_3d_secure' => true
            ),
            'transaction_details'   => $transaction_details,
            'item_details'          => $items,
            'customer_details'      => $customer_details
        );

        try
        {
            $vtweb_url = $vt->vtweb_charge($transaction_data);
            return redirect($vtweb_url);
        }
        catch (Exception $e)
        {
            return $e->getMessage;
        }

    }

    public function notification()
    {
        $vt = new Veritrans;
        //echo 'test notification handler';
        $json_result = file_get_contents('php://input');
        $result = json_decode($json_result);

//         var_dump($result);
//
// exit();
        if($result){
        $notif = $vt->status($result->order_id);
        }

        error_log(print_r($result,TRUE));



        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        if ($transaction == 'capture') {
          // For credit card transaction, we need to check whether transaction is challenge by FDS or not
          if ($type == 'credit_card'){
            if($fraud == 'challenge'){
              DB::table('sum_orders')->where('order_id','=',$order_id)->update([
                  'payment_status' =>3,
              ]);
              // TODO set payment status in merchant's database to 'Challenge by FDS'
              // TODO merchant should decide whether this transaction is authorized or not in MAP
              echo "Transaction order_id: " . $order_id ." is challenged by FDS";

              }
              else {

              // TODO set payment status in merchant's database to 'Success'
              echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
              DB::table('sum_orders')->where('order_id','=',$order_id)->update([
                  'payment_status' =>2,
              ]);


              }
            }
          }
        else if ($transaction == 'settlement'){
          // TODO set payment status in merchant's database to 'Settlement'
          echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;



          }
          else if($transaction == 'pending'){
          // TODO set payment status in merchant's database to 'Pending'
          echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
          }
          else if ($transaction == 'deny') {
          // TODO set payment status in merchant's database to 'Denied'
          echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
        }

    }
}
