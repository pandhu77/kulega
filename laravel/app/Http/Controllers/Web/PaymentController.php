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


class PaymentController extends Controller{

    public function index($id){

        Session::set('orderid1',$id);
        $getsetting     = DB::table('t_theme_setting')->where('active',1)->first();
        $getorder       = DB::table('sum_orders')->where('order_id',$id)->first();
        $orderdetails   = DB::table('tmp_order_detail')
                            ->leftJoin('ms_products','ms_products.prod_id','=','tmp_order_detail.prod_id')
                            ->where('tmp_order_detail.order_id',$id)
                            ->get();

        if (empty($getorder->payment_bank)) {
            $bank = DB::table('ms_bank')->where('bank_enable',1)->first();
        } else {
            $bank = DB::table('ms_bank')->where('id',$getorder->payment_bank)->first();
        }

        return view('web.payment-confirmation',[
            'order'         => $getorder,
            'orderdetail'   => $orderdetails,
            'bank'          => $bank
        ]);
    }

}
