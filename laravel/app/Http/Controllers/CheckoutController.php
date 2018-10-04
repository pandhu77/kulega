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
use Helper;
use HelperEmail;
use PHPMailer;


class CheckoutController extends Controller
{
    public function orderfinish($orderid){
      if(Session::get('memberid')){
          $memberid=Session::get('memberid');
          // $orderid=$request->get('order_id');
          $row=DB::table('sum_orders')
                        ->join('ms_members','ms_members.member_id','=','sum_orders.member_id')
                        ->where('sum_orders.member_id','=',$memberid)
                        ->where('sum_orders.order_id','=',$orderid)
                        ->first();
          $bank=DB::table('ms_bank')->where('bank_enable','=',1)->get();
          if(count($row) >0){
            $detail=DB::table('tmp_order_detail')
                    ->leftjoin('ms_products','ms_products.prod_id','=','tmp_order_detail.prod_id')
                    ->where('tmp_order_detail.order_id','=',$orderid)
                    ->get();
          return view('frontend.status.order-finish',[
              'row'=>$row,
              'detail'=>$detail,
              'bank'=>$bank
          ]);
        }else{
          return Redirect()->back();
        }
      }else {
        Session::flash('error_must_login','You must Login');
        return Redirect('user/login');
      }
    }
    /* START GET in Finish   */
    public function finish(Request $request){
      if(Session::get('memberid')){
          $memberid=Session::get('memberid');
          $orderid=$request->get('order_id');
          $row=DB::table('sum_orders')
                        ->join('ms_members','ms_members.member_id','=','sum_orders.member_id')
                        ->where('sum_orders.member_id','=',$memberid)
                        ->where('sum_orders.order_id','=',$orderid)
                        ->first();

          if(count($row) >0){
            $detail=DB::table('tmp_order_detail')
                    ->leftjoin('ms_products','ms_products.prod_id','=','tmp_order_detail.prod_id')
                    ->where('tmp_order_detail.order_id','=',$orderid)
                    ->get();

          return view('frontend.status.finish',[
              'row'=>$row,
              'detail'=>$detail
          ]);
        }else{
          return Redirect()->back();
        }
      }else {
        Session::flash('error_must_login','You must Login');
        return Redirect('user/login');
      }
    }
    /* START GET in unFinish   */
    public function unfinish(Request $request){
      if(Session::get('memberid')){
          $memberid=Session::get('memberid');
          $orderid=$request->get('order_id');
          $row=DB::table('sum_orders')
                        ->join('ms_members','ms_members.member_id','=','sum_orders.member_id')
                        ->where('sum_orders.member_id','=',$memberid)
                        ->where('sum_orders.order_id','=',$orderid)
                        ->first();

          if(count($row) >0){
            $detail=DB::table('tmp_order_detail')
                    ->leftjoin('ms_products','ms_products.prod_id','=','tmp_order_detail.prod_id')
                    ->where('tmp_order_detail.order_id','=',$orderid)
                    ->get();

          return view('frontend.status.unfinish',[
              'row'=>$row,
              'detail'=>$detail
          ]);
        }else{
          return Redirect()->back();
        }
      }else {
        Session::flash('error_must_login','You must Login');
        return Redirect('user/login');
      }
    }

    /* START GET in Finish   */
    public function error(Request $request){
      if(Session::get('memberid')){
          $memberid=Session::get('memberid');
          $orderid=$request->get('order_id');
          $row=DB::table('sum_orders')
                        ->join('ms_members','ms_members.member_id','=','sum_orders.member_id')
                        ->where('sum_orders.member_id','=',$memberid)
                        ->where('sum_orders.order_id','=',$orderid)
                        ->first();

          if(count($row) >0){
            $detail=DB::table('tmp_order_detail')
                    ->leftjoin('ms_products','ms_products.prod_id','=','tmp_order_detail.prod_id')
                    ->where('tmp_order_detail.order_id','=',$orderid)
                    ->get();

          return view('frontend.status.error',[
              'row'=>$row,
              'detail'=>$detail
          ]);
        }else{
          return Redirect()->back();
        }
      }else {
        Session::flash('error_must_login','You must Login');
        return Redirect('user/login');
      }
    }


    /* START GET in Finish   */
    public function makepayment($id){
      if(Session::get('memberid')){
          $memberid=Session::get('memberid');
          $row=DB::table('sum_orders')
                        ->join('ms_members','ms_members.member_id','=','sum_orders.member_id')
                        ->where('sum_orders.member_id','=',$memberid)
                        ->where('payment_service','=',2)
                        ->where('payment_status','!=',2)
                        ->where('sum_orders.order_id','=',$id)
                        ->first();

          if(count($row) >0){
            Session::set('orderid1',$row->order_id);
            return Redirect()->to('vtweb')->with('midtrans','midtrans');
          }else{
            return Redirect()->back();
          }
      }else {
        Session::flash('error_must_login','You must Login');
        return Redirect('user/login');
      }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCart()
    {
      // Session::forget("session_province");
      // Session::forget("session_city");
      // Session::forget("session_subdistrict");
      // Session::forget("session_bilcity");
      // Session::forget("session_bilprovince");
      // Session::forget("session_bildistrict");
      //
      // Session::forget("grandtotal1");
      // Session::forget("disclevel1");
      // Session::forget("disccart1");
      // Session::forget("disclevel");
      // Session::forget("levelname1");
      // Session::forget("subtotal1");
      // Session::forget("ongkir1");
      // Session::forget("shipping_service1");
      // Session::forget("kodevoc");
      // Session::forget("discvoc");


      $content=Cart::content();
      $resultstock=Helper::checkStock($content);
      if(count($resultstock) >0){
       return Redirect()->to('shopping-cart')->with('resultstock', $resultstock);
      }

      if(Session::get('memberid')){
          $memberid=Session::get('memberid');
          // Cart::destroy();
          $content=Cart::content();
          if(count($content) >0){
            /** BEGIN DISCOUNT CART */
            $valuesub= substr( Cart::subtotal(),0,-3);
            $subtotal= str_replace(",", "", $valuesub);
            $resultcart=Helper::check_dicount_total_cart($subtotal);
            $total_cart= $resultcart['total_cart'];
            $disc_cart= $resultcart['disc_cart'];
            $disc_reward= $resultcart['disc_reward'];
            $disc_percent= $resultcart['disc_percent'];

            /** END DISCOUNT CART */

            /** BEGIN DISCOUNT MEMBER */
            $resultlevel=Helper::check_dicount_member_level($total_cart,$memberid,$subtotal, $disc_cart);
            $gradtotal=  $resultlevel['total_level'];
            $level=  $resultlevel['levelname'] ;
            $disclevel=  $resultlevel['disc_level'];
            $discvalue=  $resultlevel['disc_value'] ;
            /** END DISCOUNT MEMBER */

            Session::set('subtotal1',$subtotal);
            Session::set('disccart1',$disc_cart);
            Session::set('disclevel1',$disclevel);
            // Session::set('grandtotal1',$gradtotal);
            Session::set('levelname1',$level);
            //generate Random Code
            $checkcode = $this->CodeRandom();
            Session::set('coderandom1',$checkcode);
            $getprod=DB::table('ms_products')->get();

            $getaddress = DB::table('address_book')
                         ->where('member_id', '=', $memberid)
                         ->get();
            $getpick=DB::table('ms_pickup')
                    ->where('enable', '=', 1)
                    ->get();
            $detailpick=DB::table('tmp_pickup')
                    ->where('detail_enable', '=', 1)
                    ->get();
           $myadd = DB::table('address_book')
                        ->where('member_id', '=', $memberid)
                        ->first();
           $urldomain= urldomain();
           $bank=DB::table('ms_bank')->where('bank_enable','=',1)->get();


            return view('frontend/checkout')
            ->with('urldomain',$urldomain)
            ->with('getpick',$getpick)
            ->with('detailpick',$detailpick)
            ->with('myadd',$myadd)
            ->with('address', $getaddress)
            ->with('content',$content)
            ->with('getprod',$getprod)
            ->with('bank',$bank);
          }else{
            return Redirect()->back();
          }

      }else{
        Session::flash('error_must_login','You must sign');
                return Redirect('user/login');
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
      if(Session::get('memberid')){
              $memberid=Session::get('memberid');
              $now=new Datetime();
              $delivery_method  =input::get('delivery_method');

              if(empty(Input::get('cebox'))){
                $bilstatus=0;
              }else{
                $bilstatus=1;
              }


           /* START SIPPING   */

              $titlebook  =input::get('titlebook');
              $reciptnamebook  =input::get('reciptnamebook');
              $phonebook  =input::get('phonebook');
              $emailbook  =input::get('emailbook');
              $addressbook  =input::get('addressbook');
              $postcodebook  =input::get('postcodebook');
              $province  =Session::get("session_province");
              $city  = Session::get("session_city");
              $subdistrict =Session::get("session_subdistrict");
              $shipping_courier = "JNE";
            /* END SIPPING */

            /* START PICKUP   */
              $delivery_date  =input::get('delivery_date');
              $pickpoint  =input::get('pickpoint');



             /* END PICKUP */

            /* START BILIING */
              $titlebil  =input::get('titlebil');
              $reciptnamebil  =input::get('reciptnamebil');
              $phonebil  =input::get('phonebil');
              $emailbil  =input::get('emailbil');
              $addressbil  =input::get('addressbil');
              $postcodebil  =input::get('postcodebil');
              $bilprovince =Session::get("session_bilprovince");
              $bilcity  =Session::get("session_bilcity");
              $bildistrict =Session::get("session_bildistrict");

            /* END BILIING */

            /* START TRANS */
            $payment_method=input::get('payment_method');
            $grandtotal=Session::get('grandtotal1');
            $subtotal=Session::get('subtotal1');
            $disccart= Session::get("disccart1");
            $disclevel=Session::get('disclevel1');
            $levelname=Session::get('levelname1');

            $ongkir=Session::get('ongkir1');
            $discvoc=Session::get('discvoc');
            $service=Session::get('shipping_service1');
            $kodevoc=Session::get('kodevoc');
            $reward=Session::get('bonusreward1');
            $unitcode=Session::get('coderandom1');
            $checkVocher=DB::table('ms_voucher')
                        ->where('voucher_code',$kodevoc)
                        ->where('voucher_limit_usage','>',0)
                        ->where('voucher_status','=',1)->first();


            /* END TRANS */


          // validate the info, create rules for the inputs
             $rules = [
                // 'delivery_method' => 'required',
                // 'grandtotal1' => 'required',
                // 'subtotal1' =>'required',
            ];

            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
                // dd($validator->errors()->all());

            } else {

            //Cek Stock Product
              $content=Cart::content();
              $resultstock=Helper::checkStock($content);
              if(count($resultstock) >0){
               return Redirect()->to('shopping-cart')->with('resultstock', $resultstock);
              }
              //Cek Vocheer
              if(count($checkVocher) >0){
                $usageMember=DB::table('tmp_voucher_usage')
                ->where('voucher_id','=',$kodevoc)
                ->where('member_id',$memberid)->first();
                if(count($usageMember) <=0){
                    DB::table('tmp_voucher_usage')->insert([
                      'voucher_id'=>$kodevoc,
                      'member_id'=>$memberid,
                      'usage'=>1,
                    ]);

                }else{
                  DB::table('tmp_voucher_usage')
                   ->where('voucher_id','=',$kodevoc)
                   ->where('member_id',$memberid)
                   ->where('usage','<',$checkVocher->voucher_limit_user)
                   ->update([
                    'voucher_id'=>$kodevoc,
                    'member_id'=>$memberid,
                    'usage'=>$usageMember->usage + 1,
                  ]);
                }

                DB::table('ms_voucher')
                            ->where('voucher_code',$kodevoc)
                            ->where('voucher_limit_usage','>',0)
                            ->where('voucher_status','=',1)->update([
                              'voucher_limit_usage'=>$checkVocher->voucher_limit_usage - 1,
                            ]);

              }

                //Check Exp order
                  $datenow= date('Y-m-d H:i:s');
                  $datetimenow = new DateTime($datenow);
                  $dateplus=strtotime($datenow."+1 day");
                  $dateexp=date("Y-m-d H:i:s",$dateplus);
                  if($delivery_method =='ship'){

                    $insert=DB::table('sum_orders')->insert([
                      'member_id'=>$memberid,
                      'order_date'=>$now,
                      'date_exp'=>$dateexp,
                      'order_total'=>$grandtotal,
                      'sub_total'=>$subtotal,
                      'disc_cart'=>$disccart,
                      'order_disc'=>$disclevel,
                      'order_discname'=>$levelname,
                      'voucher_code'=>$kodevoc,
                      'voucher_value'=>$discvoc,
                      'disc_reward'=>$reward,
                      'payment_service'=>$payment_method,
                      'service_cost'=>$service,
                      // 'order_disc'=>'',
                      'order_status'=>0,
                      'payment_status'=>0,
                      'order_delivery'=>0,
                      'customer_name'=>$reciptnamebook,
                      'customer_email'=>$emailbook,
                      'customer_address'=>$addressbook,
                      'customer_address'=>$addressbook,
                      'customer_phone'=>$phonebook,
                      'order_poscode'=>$postcodebook,
                      'order_province'=>$province,
                      'order_city'=>$city,
                      'order_district'=>$subdistrict,
                      'shipping_courier'=>$shipping_courier,
                      // 'shipping_weight'=>,

                      'shipping_cost'=>$ongkir,
                      'dilivery_method'=>$delivery_method,
                      'bil_status'=>$bilstatus,
                      'billing_name'=>$reciptnamebil,
                      'billing_email'=>$emailbil,
                      'billing_phone'=>$phonebil,
                      'billing_address'=>$addressbil,
                      'billing_poscode'=>$postcodebil,
                      'billing_province'=>$bilprovince,
                      'billing_city'=>$bilcity,
                      'billing_district'=>$bildistrict,
                      'order_created_at'=>$now,
                      'order_generate'=>$unitcode,

                    ]);



                  }elseif ($delivery_method=='pick') {
                    $insert=DB::table('sum_orders')->insert([
                      'member_id'=>$memberid,
                      'order_date'=>$now,
                      'date_exp'=>$dateexp,
                      'sub_total'=>$subtotal,
                      'disc_cart'=>$disccart,
                      'order_disc'=>$disclevel,
                      'order_discname'=>$levelname,
                      'order_total'=>$grandtotal,
                      'voucher_code'=>$kodevoc,
                      'voucher_value'=>$discvoc,
                      'disc_reward'=>$reward,
                      'payment_service'=>$payment_method,
                      'service_cost'=>$service,
                      'payment_status'=>0,
                      // 'order_disc'=>'',
                      'order_status'=>0,
                      'order_delivery'=>0,
                      'customer_name'=>$reciptnamebook,
                      'customer_email'=>$emailbook,
                      'customer_address'=>$addressbook,
                      'customer_phone'=>$phonebook,
                      'order_poscode'=>$postcodebook,
                      'order_province'=>$province,
                      'order_city'=>$city,
                      'order_district'=>$subdistrict,
                      'dilivery_method'=>$delivery_method,
                      'bil_status'=>$bilstatus,
                      'billing_name'=>$reciptnamebil,
                      'billing_email'=>$emailbil,
                      'billing_phone'=>$phonebil,
                      'billing_address'=>$addressbil,
                      'billing_poscode'=>$postcodebil,
                      'billing_province'=>$bilprovince,
                      'billing_city'=>$bilcity,
                      'billing_district'=>$bildistrict,
                      'pickup_date'=>$delivery_date,
                      'pickup_point'=>$pickpoint,
                      'order_created_at'=>$now,
                      'order_generate'=>$unitcode,
                    ]);

                  }else{
                    return Redirect()->back();
                  }
                  if($insert){
                      $order=DB::table('sum_orders')->where('member_id','=',$memberid)->orderby('order_id','=','desc')->first();
                      $content=Cart::content();
                      foreach ($content as $row) {
                          //insert product detail
                            $insert=DB::table('tmp_order_detail')->insert([
                                  'order_id'=>$order->order_id,
                                  'prod_id'=>$row->id,
                                  'prod_color'=>$row->options['color'],
                                  'prod_size'=>$row->options['size'],
                                  'price_item'=>$row->options['prodprice'],
                                  'detail_disc'=>$row->options['proddisc'],
                                  'detail_subtotal'=>$row->price,
                                  // 'detail_weight'=>
                                  'detail_qty'=>$row->qty,
                            ]);

                      }

                      //update stock product
                      $resultstock=Helper::updateStock($content);
                      // update point
                      if(Session::get('tmppoint1') !== null){
                          DB::table('ms_members')->where('member_id','=',$memberid)->update([
                            'member_points'=> Session::get('tmppoint1'),
                          ]);
                      }

                      $resultHtml=HelperEmail::emailOrder($order->order_id,$memberid);
                      $checkmember=DB::table('ms_members')
                      ->where('member_id','=',$memberid)->first();


                      //PHPMailer Object
                      $mail = new PHPMailer;
                      // whereas if using SMTP you would have
                      $mail->isSMTP();
                      //Set SMTP host name
                      $mail->Host = "	srv2.niagahoster.com";
                      //Set this to true if SMTP host requires authentication to send email
                      $mail->SMTPAuth = true;
                      //Provide username and password
                      $mail->Username = "sentra@chronosh.com";
                      $mail->Password = "123456";
                      //If SMTP requires TLS encryption then set it
                      $mail->SMTPSecure = "ssl";
                      //Set TCP port to connect to
                      $mail->Port = 465;

                      $mail->From = "sentra@chronosh.com";
                      $mail->FromName = "E-Commerce Djaring.id";
                      if($checkmember->member_email == $emailbook){
                        $mail->addAddress($checkmember->member_email);
                      }else{
                        $mail->addAddress($checkmember->member_email);
                        $mail->addAddress($emailbook);
                      }


                      $mail->isHTML(true);

                      $mail->Subject = "Order Verification";
                      $mail->Body = $resultHtml;
                      $mail->AltBody = "ini link anda plan";
                      if(!$mail->send())
                      {
                          if($order->payment_service==2){
                                Session::set('orderid1',$order->order_id);
                                $this->forgetSession();
                                return Redirect()->to('vtweb')->with('midtrans','midtrans');

                          }else{
                                $this->forgetSession();
                                return Redirect()->to('checkout/finish/'.$order->order_id.'')->with('error_get','Thank you, order success (Mail not send)');

                          }

                        // echo "Mailer Error: " . $mail->ErrorInfo;
                      }
                      {
                            if($order->payment_service==2){
                                  Session::set('orderid1',$order->order_id);
                                  $this->forgetSession();
                                  return Redirect()->to('vtweb')->with('midtrans','midtrans');


                            }else{
                                  $this->forgetSession();
                                  return redirect('checkout/finish/'.$order->order_id.'')->with('success','Thank you, order success !');
                            }
                      }



                        // return redirect()->to('user/profile')->with('success-order','Thank you, order success !');
                  }else{
                        return Redirect()->back()->with('error-order','Sorry something is error !');
                  }


            }
      }else{
        Session::flash('error_must_login','You must sign');
                return Redirect('user/login');
      }

    }
    private function forgetSession()
    {
      Session::forget("session_province");
      Session::forget("session_city");
      Session::forget("session_subdistrict");
      Session::forget("session_bilcity");
      Session::forget("session_bilprovince");
      Session::forget("session_bildistrict");
      Session::forget("grandtotal1");
      Session::forget("subtotal1");
      Session::forget("disccart1");
      Session::forget("disclevel1");
      Session::forget("levelname1");
      Session::forget("ongkir1");
      Session::forget("shipping_service1");
      Session::forget("kodevoc");
      Session::forget("discvoc");
      Session::forget("bonusreward1");
      Session::forget("tmppoint1");
      Session::forget("discvoc");
      Cart::destroy();
    }

    private function CodeRandom(){
      $code=rand(0,99);
      $total=Session::get('grandtotal1');

      if($code==0){
        $this->CheckCodeRandom();
      }else{
          $hitung=$total + $code;
          $check= DB::table('sum_orders')->where('order_status','=',0)->where('order_total','=',$hitung)->get();
          if(count($check)> 0){
            $this->CheckCodeRandom();

          }else{
          return $code;
          }
      }

    }

}
