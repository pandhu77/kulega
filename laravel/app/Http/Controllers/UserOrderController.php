<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use DB;
use Cart;
use Session;
use Datetime;
use HelperEmail;
use Helper;
use PHPMailer;

class UserOrderController extends Controller
{

    public function getorder()
    {
        if(Session::get('memberid')){
            $memberid=Session::get('memberid');
            $orderprogress=DB::table('sum_orders')->where('sum_orders.order_status','<',4)->where('sum_orders.member_id','=',$memberid)->orderby('order_date','=','desc')->paginate(3);
            $orderhistory=DB::table('sum_orders')->where('sum_orders.order_status','=',4)->where('sum_orders.member_id','=',$memberid)->orderby('order_date','=','desc')->paginate(3);
            $ordercancel=DB::table('sum_orders')->where('sum_orders.order_status','=',5)->where('sum_orders.member_id','=',$memberid)->orderby('order_date','=','desc')->paginate(3);
            $detail=DB::table('tmp_order_detail')
                    ->leftjoin('ms_products','ms_products.prod_id','=','tmp_order_detail.prod_id')
                    ->get();
            return view('frontend.member.order',[
              'orderprogress'=>$orderprogress,
              'orderhistory'=>$orderhistory,
              'ordercancel'=>$ordercancel,
              'detail'=>$detail,
            ]);

        }else{
          Session::flash('error_must_login','You must Login');
          return Redirect('user/login');
        }
    }

    /* END GET in progress   */

    /* START GET  history   */

    public function orderdetail($id)
    {
      if(Session::get('memberid')){
          $memberid=Session::get('memberid');
          $row=DB::table('sum_orders')->where('sum_orders.member_id','=',$memberid)->where('sum_orders.order_id','=',$id)->first();
          if(count($row)>0){
            $detail=DB::table('tmp_order_detail')
                    ->leftjoin('ms_products','ms_products.prod_id','=','tmp_order_detail.prod_id')
                    ->get();
            $pickup=DB::table('sum_orders')
                    ->leftjoin('tmp_pickup','sum_orders.pickup_point','=','tmp_pickup.id')
                    ->join('ms_pickup','ms_pickup.pick_id','=','tmp_pickup.pick_id')
                    ->where('sum_orders.order_id','=',$id)
                    ->first();
            $bank=DB::table('ms_bank')->where('bank_enable','=',1)->get();

            return view('frontend.member.order-detail',[
              'row'=>$row,
              'detail'=>$detail,
              'pickup'=>$pickup,
              'bank'=>$bank
            ]);
          }else{
            return Redirect()->back();
          }
      }else{
        Session::flash('error_must_login','You must Login');
        return Redirect('user/login');
      }
    }

    /* END GET history   */

    /* START PAYMENT CONFIRMATION   */

    public function paymentconfir($id)
    {
      if(Session::get('memberid')){
          $getsetting = DB::table('t_theme_setting')->where('active',1)->first();
          $memberid=Session::get('memberid');
        //   $row=DB::table('sum_orders')->where('sum_orders.member_id','=',$memberid)->where('sum_orders.order_id','=',$id)->where('sum_orders.payment_status','=',0)->first();
          $row=DB::table('sum_orders')->where('sum_orders.member_id','=',$memberid)
                ->where('sum_orders.payment_service',1)
                ->where('sum_orders.payment_status','=',0)
                ->get();
        //   if(count($row)>0){

              $bank = DB::table('ms_bank')->where('bank_enable',1)->get();

            $detail=DB::table('tmp_order_detail')
                    ->leftjoin('ms_products','ms_products.prod_id','=','tmp_order_detail.prod_id')
                    ->get();

            return view('web.payment-confirm',[
              'row'=>$row,
              'detail'=>$detail,
              'bank'=>$bank,
              'parameter'=>$id
            ]);
        //   }else{
        //     return Redirect()->back();
        //   }
      }else{
          $getsetting = DB::table('t_theme_setting')->where('active',1)->first();
          $row=DB::table('sum_orders')->where('sum_orders.payment_service','=',1)->where('sum_orders.order_id','=',$id)->where('sum_orders.payment_status','=',0)->first();
        //   if(count($row)>0){

              $bank = DB::table('ms_bank')->where('bank_enable',1)->get();

            $detail=DB::table('tmp_order_detail')
                    ->leftjoin('ms_products','ms_products.prod_id','=','tmp_order_detail.prod_id')
                    ->get();

            return view('web.payment-confirm',[
              'row'=>$row,
              'detail'=>$detail,
              'bank'=>$bank,
              'parameter'=>$id
            ]);
        //   }else{
        //     return Redirect()->back();
        //   }
      }
    }

    /* END PAYMENT CONFIRMATION  */
    /* START POST PAYMENT CONFIRMATION   */
    // public function postpaymentconfir(Request $request,$id)
    public function postpaymentconfir(Request $request)
    {
        // dd('woi');
      if(Session::has('memberid')){
          $memberid=Session::get('memberid');
          $order_id  =input::get('order_id');
          $payment_bank  =input::get('payment_bank');
          $account_name  =input::get('account_name');
        //   $account_number =input::get('account_number');
          $transfer_date =input::get('transfer_date');
          $payment_email  =input::get('payment_email');
          $transfer_ammount  =input::get('transfer_ammount');
          // $payment_image=input::get('payment_image');
          $payment_notes =input::get('payment_notes');

          $getsetting = DB::table('t_theme_setting')->where('active',1)->first();

          if (!is_dir("assets/img-transfer/$order_id")) {
              $newforder=mkdir("assets/img-transfer/$order_id");
          }
          $file = $request->file('payment_image');
           // Disini proses mendapatkan judul dan memindahkan letak gambar ke folder image
           if ($file !==null) {
             $fileName   = $file->getClientOriginalName();
             $file->move("assets/img-transfer/$order_id", $fileName);

           }else{
             $fileName='';
           }

          $now=new Datetime();

          // validate the info, create rules for the inputs
             $rules = [
                // 'prod_code'    => 'required|unique:ms_products',
                'payment_bank' => 'required',
                'account_name' => 'required',
                'order_id'=>'required',
                'transfer_date' =>'required',
                // 'account_number' =>'required',
                'payment_email' => 'required',
                'transfer_ammount' => 'required',
                'sender_bank' => 'required'
                // 'payment_image' =>'required',
            ];

            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
                // dd($validator->errors()->all());


            } else {

                $check = DB::table('sum_orders')->where('order_id',$order_id)->where('payment_status',0)->first();

                if (count($check) == 0) {
                    return redirect()->back()->with('error_get','Order ID not valid');
                }

              $insert=DB::table('sum_payment')->insert([
                'order_id'=>$order_id,
                'payment_bank'=>$payment_bank,
                'account_name'=>$account_name,
                // 'account_number'=>$account_number,
                'transfer_date'=>$transfer_date,
                'sender_bank'=> $_POST['sender_bank'],
                'payment_email'=>$payment_email,
                'transfer_ammount'=>$transfer_ammount,
                'payment_image'=>$fileName,
                'payment_email'=>$payment_email,
                'payment_notes'=>$payment_notes,
                'payment_status'=>0,
                'created_at'=>$now,
              ]);

                if($insert){
                  DB::table('sum_orders')->where('order_id','=',$order_id)->update([
                    'payment_status'=>1,
                  ]);

                //   EMAIL
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

                // maill
                $resultHtml=HelperEmail::paymentnotif($order_id,$memberid);
                //PHPMailer Object
                $mail = new PHPMailer;
                $mail->isSMTP();
                $mail->Host          = $array['Host'];
                $mail->SMTPAuth      = true;
                $mail->Username      = $array['Username'];
                $mail->Password      = $array['Password'];
                $mail->SMTPSecure    = $array['SMTPsecure'];
                $mail->Port          = $array['Port'];

                $mail->From      = $websetting->email;
                $mail->FromName  = $websetting->site_name;

                $mail->addAddress($payment_email);

                $mail->isHTML(true);
                $mail->Subject = "Order #".$order_id." - Payment Confirm";
                $mail->Body = $resultHtml;
                $mail->AltBody = "ini link anda plan";

                if(!$mail->send())
                {
                    // return Redirect()->back()->with('error_get','Thank you for Order ID: '.$ordermember->order_id.'  Update (Mailer Error:'.$mail->ErrorInfo.')');
                  echo "Mailer Error: " . $mail->ErrorInfo;
                }
                {
                    // return redirect()->back()->with('success-create','Thank you for Order ID: '.$ordermember->order_id.' Update to '.$statusname.'!');
                    return redirect('thankyou/'.$order_id);
                }

                //   if (Session::has('memberid')) {
                //     //  return redirect('user/profile')->with('success','Thank you for payment confirmation sent, your payment will be processed 1x24 hours!!');
                //      return redirect('thankyou/'.$order_id);
                //  }else {
                //      return redirect('check/order')->with('success','Thank you for payment confirmation sent, your payment will be processed 1x24 hours!!');
                //  }

                }else{
                      return Redirect('user/profile')->with('error','Sorry something is error !');
                }
            }

      }else{

          $order_id  =input::get('order_id');
          $payment_bank  =input::get('payment_bank');
          $account_name  =input::get('account_name');
        //   $account_number =input::get('account_number');
        //   $transfer_date =input::get('transfer_date');
          $payment_email  =input::get('payment_email');
          $transfer_ammount  =input::get('transfer_ammount');
          // $payment_image=input::get('payment_image');
          $payment_notes =input::get('payment_notes');

          $getsetting = DB::table('t_theme_setting')->where('active',1)->first();

          if (!is_dir("assets/img-transfer/$order_id")) {
              $newforder=mkdir("assets/img-transfer/$order_id");
          }
          $file = $request->file('payment_image');
           // Disini proses mendapatkan judul dan memindahkan letak gambar ke folder image
           if ($file !==null) {
             $fileName   = $file->getClientOriginalName();
             $file->move("assets/img-transfer/$order_id", $fileName);

           }else{
             $fileName='';
           }

          $now=new Datetime();

          // validate the info, create rules for the inputs
             $rules = [
                // 'prod_code'    => 'required|unique:ms_products',
                'payment_bank' => 'required',
                'account_name' => 'required',
                // 'transfer_date' =>'required',
                // 'account_number' =>'required',
                'payment_email' => 'required',
                'transfer_ammount' => 'required',
                // 'payment_image' =>'required',
            ];

            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
                // dd($validator->errors()->all());


            } else {

                $check = DB::table('sum_orders')->where('order_id',$order_id)->where('payment_status',0)->first();

                if (count($check) == 0) {
                    return redirect()->back()->with('error_get','Order ID not valid');
                }

              $insert=DB::table('sum_payment')->insert([
                'order_id'=>$order_id,
                'payment_bank'=>$payment_bank,
                'account_name'=>$account_name,
                // 'account_number'=>$account_number,
                // 'transfer_date'=>$transfer_date,
                'payment_email'=>$payment_email,
                'transfer_ammount'=>$transfer_ammount,
                'payment_image'=>$fileName,
                'payment_email'=>$payment_email,
                'payment_notes'=>$payment_notes,
                'payment_status'=>0,
                'created_at'=>$now,
              ]);

                if($insert){
                  DB::table('sum_orders')->where('order_id','=',$order_id)->update([
                    'payment_status'=>1,
                  ]);
                 return redirect('check/order')->with('success','Thank you for payment confirmation sent, your payment will be processed 1x24 hours!!');

                }else{
                      return Redirect('check/order')->with('error','Sorry something is error !');
                }
            }

      }
    }
      /* END PAYMENT CONFIRMATION  */


}
