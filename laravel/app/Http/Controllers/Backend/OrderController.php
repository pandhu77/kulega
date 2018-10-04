<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Input;
use Validator;
use File;
use Redirect;
use DateTime;
use Auth;
use Helper;
use PHPMailer;
use HelperEmail;
class OrderController extends Controller
{
    /**
    * Instantiate a new new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
      $this->middleware('auth');
    }


    /** Payment Confirmation */
    public function paymentconfir($id){
      // $auth = $this->CheckAuth();
      // if($auth == true){
          $now   = new DateTime();
          $userid= auth::user()->id;
          $confir=DB::table('sum_payment')->where('payment_id','=',$id)->update([
              'payment_status'=>1,
              'updated_at'=>$now,
              'updated_by'=>$userid,
          ]);
          if($confir){
            $payment=DB::table('sum_payment')->where('payment_id','=',$id)->first();
            $update=DB::table('sum_orders')->where('order_id','=',$payment->order_id)->update([
                'order_status'=>1,
                'payment_status'=>2,
                'order_updated_at'=>$now,
                'order_updated_by'=>$userid,
            ]);

            if($update){
              $row=DB::table('sum_payment')
              ->join('sum_orders','sum_payment.order_id','=','sum_orders.order_id')
            //   ->join('ms_members','ms_members.member_id','=','sum_orders.member_id')
              ->where('sum_payment.payment_id','=',$id)->first();

              if(count($row) >0){

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

            //    $resultHtml=HelperEmail::emailPaymentConfir($row);
            //    //PHPMailer Object
            //    $mail = new PHPMailer;
            //    $mail->isSMTP();
            //    $mail->Host          = $array['Host'];
            //    $mail->SMTPAuth      = true;
            //    $mail->Username      = $array['Username'];
            //    $mail->Password      = $array['Password'];
            //    $mail->SMTPSecure    = $array['SMTPsecure'];
            //    $mail->Port          = $array['Port'];
            //
            //    $mail->From      = $websetting->email;
            //    $mail->FromName  = $websetting->site_name;
            // //    if($row->member_email == $row->customer_email){
            //      $mail->addAddress($row->billing_email);
            // //    }else{
            // //      $mail->addAddress($row->member_email);
            // //      $mail->addAddress($row->customer_email);
            // //    }
            //
            //    $mail->isHTML(true);
            //    $mail->Subject = "Payment Confirmation - Invoice ".$payment->order_id."";
            //    $mail->Body = $resultHtml;
            //    $mail->AltBody = "ini link anda plan";
            //    if(!$mail->send())
            //    {
            //        return Redirect()->back()->with('error_get','Payment to Invoice '.$payment->order_id.'   has been confirmed (Mailer Error:'.$mail->ErrorInfo.')');
            //      // echo "Mailer Error: " . $mail->ErrorInfo;
            //    }
            //    {
                    return redirect()->back()->with('success-create','Thank you,  Payment to Invoice '.$payment->order_id.' has been confirmed!');
            //    }

             }else{
               return Redirect()->back()->with('error_get','Sorry, Payment to Invoice '.$payment->order_id.'   has been confirmed (Mailer Error: email is not found)');
             }
            }else{
              return Redirect()->back()->with('error_get','Sorry, failed to confirm ! Invoice '.$payment->order_id.'');
            }
          }else {
              return Redirect()->back()->with('error_get','Sorry, failed to confirm ! Invoice '.$payment->order_id.'');
          }

      //   }else{
      // return Redirect::back()->withErrors(['Sorry, No Access']);
      // }

    }
    /** Payment Confirmation */
    public function paymentcancel($id){
      // $auth = $this->CheckAuth();
      // if($auth == true){
          $now          = new DateTime();
          $userid= auth::user()->id;
          $confir=DB::table('sum_payment')->where('payment_id','=',$id)->update([
              'payment_status'=>0,
              'updated_at'=>$now,
              'updated_by'=>$userid,
          ]);
          if($confir){
            $payment=DB::table('sum_payment')->where('payment_id','=',$id)->first();
            $update=DB::table('sum_orders')->where('order_id','=',$payment->order_id)->update([
                'order_status'=>0,
                'payment_status'=>1,
                'order_updated_at'=>$now,
                'order_updated_by'=>$userid,
            ]);
          }
          if($update){
              return redirect()->back()->with('success-delete','Thank you for Payment has been canceled!');
          }else{
              return Redirect()->back()->with('error','Sorry something is error !');
          }
      //   }else{
      // return Redirect::back()->withErrors(['Sorry, No Access']);
      // }

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function report(){
         if (!isset($_GET['datefrom'])) {
             $datefrom = 0;
         } else {
             $datefrom = $_GET['datefrom'];
         }

         if (!isset($_GET['dateto'])) {
            $dateto = 0;
         } else {
            $dateto = $_GET['dateto'];
         }

         $order     = DB::table('sum_orders')
                        ->leftjoin('ms_members','ms_members.member_id','=','sum_orders.member_id')
                        ->where('sum_orders.order_status',4)
                        ->where('sum_orders.payment_status',2)
                        ->where('sum_orders.order_date','>=',$datefrom)
                        ->where('sum_orders.order_date','<=',$dateto)
                        ->get();

         return view('backend.order.report',[
           'order'=>$order
         ]);
     }

     public function reportprint(){
        $datefrom = $_POST['datefrom'];
        $dateto = $_POST['dateto'];

         $order     = DB::table('sum_orders')
                        ->leftjoin('ms_members','ms_members.member_id','=','sum_orders.member_id')
                        ->where('sum_orders.order_status',4)
                        ->where('sum_orders.payment_status',2)
                        ->where('sum_orders.order_date','>=',$datefrom)
                        ->where('sum_orders.order_date','<=',$dateto)
                        ->orderBy('sum_orders.order_date','ASC')
                        ->get();

         return view('backend.order.report-print',[
           'order'=>$order
         ]);
     }

    public function index()
    {

      $auth = $this->CheckAuth();
      if($auth == true){
          $order=DB::table('sum_orders')
                  ->leftjoin('ms_members','ms_members.member_id','=','sum_orders.member_id')
                  ->where('sum_orders.order_status','<',4)
                  ->orderby('order_id','=','desc')->get();
          $payment=DB::table('sum_payment')->get();
          return view('backend.order.index',[
            'order'=>$order,
            'payment'=>$payment,
          ]);
        }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
      }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getordernew()
    {
      $auth = $this->CheckAuth();
      if($auth == true){
          $order=DB::table('sum_orders')
                  ->leftjoin('ms_members','ms_members.member_id','=','sum_orders.member_id')
                  ->where('sum_orders.order_status','=',0)
                  ->orderby('sum_orders.order_id','=','desc')->get();
          $payment=DB::table('sum_payment')->get();
          return view('backend.order.index',[
            'order'=>$order,
            'payment'=>$payment,
          ]);
        }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
      }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getordercancel()
    {
      $auth = $this->CheckAuth();
      if($auth == true){
          $order=DB::table('sum_orders')
                  ->leftjoin('ms_members','ms_members.member_id','=','sum_orders.member_id')
                  ->where('sum_orders.order_status','=',5)
                  ->orderby('sum_orders.order_id','=','desc')->get();
          $payment=DB::table('sum_payment')->get();
          return view('backend.order.index',[
            'order'=>$order,
            'payment'=>$payment,
          ]);
        }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
      }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getorderprocessing()
    {
      $auth = $this->CheckAuth();
      if($auth == true){
          $order=DB::table('sum_orders')
                  ->leftjoin('ms_members','ms_members.member_id','=','sum_orders.member_id')
                  ->where('sum_orders.order_status','=',1)
                  ->orderby('sum_orders.order_id','=','desc')->get();
          $payment=DB::table('sum_payment')->get();
          return view('backend.order.index',[
            'order'=>$order,
            'payment'=>$payment,
          ]);
        }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
      }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getorderready()
    {
      $auth = $this->CheckAuth();
      if($auth == true){
          $order=DB::table('sum_orders')
                  ->leftjoin('ms_members','ms_members.member_id','=','sum_orders.member_id')
                  ->where('sum_orders.order_status','=',2)
                  ->orderby('sum_orders.order_id','=','desc')->get();
          $payment=DB::table('sum_payment')->get();
          return view('backend.order.index',[
            'order'=>$order,
            'payment'=>$payment,
          ]);
        }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
      }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getorderdelivery()
    {
      $auth = $this->CheckAuth();
      if($auth == true){
          $order=DB::table('sum_orders')
                  ->leftjoin('ms_members','ms_members.member_id','=','sum_orders.member_id')
                  ->where('sum_orders.order_status','=',3)
                  ->orderby('sum_orders.order_id','=','desc')->get();
          $payment=DB::table('sum_payment')->get();
          return view('backend.order.index',[
            'order'=>$order,
            'payment'=>$payment,
          ]);
        }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
      }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getordercompleted()
    {
      $auth = $this->CheckAuth();
      if($auth == true){
          $order=DB::table('sum_orders')
                  ->leftjoin('ms_members','ms_members.member_id','=','sum_orders.member_id')
                  ->where('sum_orders.order_status','=',4)
                  ->orderby('sum_orders.order_id','=','desc')->get();
          $payment=DB::table('sum_payment')->get();
          return view('backend.order.index',[
            'order'=>$order,
            'payment'=>$payment,
          ]);
        }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
      }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getwaiting()
    {
      $auth = $this->CheckAuth();
      if($auth == true){
          $order=DB::table('sum_orders')
                  ->leftjoin('ms_members','ms_members.member_id','=','sum_orders.member_id')
                  ->where('payment_status','!=',1)
                  ->where('payment_status','!=',2)->where('payment_status','!=',3)->where('order_status','=',0)
                  ->orderby('sum_orders.order_id','=','desc')->get();
          $payment=DB::table('sum_payment')->get();
          return view('backend.order.index',[
            'order'=>$order,
            'payment'=>$payment,
          ]);
        }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
      }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getconfirm()
    {
      $auth = $this->CheckAuth();
      if($auth == true){
          $order=DB::table('sum_orders')
                  ->leftjoin('ms_members','ms_members.member_id','=','sum_orders.member_id')
                  ->where('sum_orders.payment_status','=',1)
                  ->orderby('sum_orders.order_id','=','desc')->get();
          $payment=DB::table('sum_payment')->get();
          return view('backend.order.index',[
            'order'=>$order,
            'payment'=>$payment,
          ]);
        }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
      }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getaccepted()
    {
      $auth = $this->CheckAuth();
      if($auth == true){
          $order=DB::table('sum_orders')
                  ->leftjoin('ms_members','ms_members.member_id','=','sum_orders.member_id')
                  ->where('sum_orders.payment_status','=',2)
                  ->orderby('sum_orders.order_id','=','desc')->get();
          $payment=DB::table('sum_payment')->get();
          return view('backend.order.index',[
            'order'=>$order,
            'payment'=>$payment,
          ]);
        }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
      }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getfailed()
    {
      $auth = $this->CheckAuth();
      if($auth == true){
          $order=DB::table('sum_orders')
                  ->leftjoin('ms_members','ms_members.member_id','=','sum_orders.member_id')
                  ->where('sum_orders.payment_status','=',3)
                  ->orderby('sum_orders.order_id','=','desc')->get();
          $payment=DB::table('sum_payment')->get();
          return view('backend.order.index',[
            'order'=>$order,
            'payment'=>$payment,
          ]);
        }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
      }
    }
    public function history()
    {
      $auth = $this->CheckAuth();
      if($auth == true){
          $order=DB::table('sum_orders')
                  ->leftjoin('ms_members','ms_members.member_id','=','sum_orders.member_id')
                  ->where('sum_orders.order_status','>',3)
                  ->orderby('sum_orders.order_id','=','desc')->get();

          $payment=DB::table('sum_payment')->get();
          return view('backend.order.history',[
            'order'=>$order,
            'payment'=>$payment,
          ]);
        }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
      }
    }

    public function historydel($order_id)
    {
      $auth = $this->CheckAuth();
      if($auth == true){
          DB::table('tmp_order_detail')->where('order_id',$order_id)->delete();
          DB::table('sum_orders')->where('order_id',$order_id)->delete();
          return redirect()->back();
        }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $auth = $this->CheckAuth();
        if($auth == true){
          $order=DB::table('sum_orders')
                  ->leftjoin('ms_members','ms_members.member_id','=','sum_orders.member_id')
                  ->where('order_id','=',$id)
                  ->first();
          if(count($order)>0){
          $detail=DB::table('tmp_order_detail')
                  ->join('ms_products','tmp_order_detail.prod_id','=','ms_products.prod_id')
                  ->where('order_id','=',$id)->get();
          $pickup=DB::table('sum_orders')
                  ->leftjoin('tmp_pickup','sum_orders.pickup_point','=','tmp_pickup.id')
                  ->join('ms_pickup','ms_pickup.pick_id','=','tmp_pickup.pick_id')
                  ->where('sum_orders.order_id','=',$id)
                  ->first();
            return view('backend.order.show',[
              'order'=>$order,
              'detail'=>$detail,
              'pickup'=>$pickup,
            ]);
          }else{
             return redirect()->back();
          }
        }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
      }
    }

    public function historyshow($id)
    {
      $auth = $this->CheckAuth();
        if($auth == true){
          $order=DB::table('sum_orders')
                  ->leftjoin('ms_members','ms_members.member_id','=','sum_orders.member_id')
                  ->where('order_id','=',$id)
                  ->first();
          if(count($order)>0){
          $detail=DB::table('tmp_order_detail')
                  ->join('ms_products','tmp_order_detail.prod_id','=','ms_products.prod_id')
                  ->where('order_id','=',$id)->get();
            return view('backend.order.history-show',[
              'order'=>$order,
              'detail'=>$detail
            ]);
          }else{
             return redirect()->back();
          }
        }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
      }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $auth = $this->CheckAuth();

      if($auth == true){

          $rules = array(
            // 'end_date'       => 'required',
            // 'email'      => 'required|email',
            // 'nerd_level' => 'required|numeric'
          );
          $validator = Validator::make(Input::all(), $rules);

          if ($validator->fails()) {
            return Redirect::to('nerds/' . $id . '/edit')
            ->withErrors($validator)
            ->withInput(Input::except('password'));
          } else {

            $no_resi        =Input::get('no_resi');
            $delivery_date        =Input::get('delivery_date');
            $order_status       =Input::get('order_status');
            $lastorder = DB::table('sum_orders')->where('order_id', $id)->first();
            $status_payment=Input::get('manaul_status_payment');
            $now          = new DateTime();
            $userid= auth::user()->id;
            if($delivery_date ==null || $no_resi==null){
              $update = DB::table('sum_orders')
              ->where('order_id', $id)
              ->update([
                  'no_resi'=>null,
                  'delivery_date'=>null,
                  'order_delivery'=>0,
                  'order_status'  =>$order_status,
                  'payment_status'=>$status_payment,
                  'order_updated_at' =>$now,
                  'order_updated_by'=>$userid
              ]);


            }else{

              $update = DB::table('sum_orders')
              ->where('order_id', $id)
              ->update([
                  'no_resi'=>$no_resi,
                  'delivery_date'=>$delivery_date,
                  'order_status'  =>$order_status,
                  'payment_status'=>$status_payment,
                  'order_delivery'=>1,
                  'order_updated_at' =>$now,
                  'order_updated_by'=>$userid
              ]);
            }


            if($update){
              $ordermember = DB::table('sum_orders')->where('order_id', $id)->first();
              //stock management
              if($order_status==5 and $ordermember->order_status==5){
                $resultstock=Helper::admin_stock_product_plus($ordermember);
              }elseif($order_status !== 5 and $lastorder->order_status == 5){
                $resultstock=Helper::admin_stock_product_min($lastorder);
              }

              $checkmember = DB::table('ms_members')->where('member_id',$ordermember->member_id)->first();
              /** Member Point  */
              $checkpoint  = DB::table('lk_setting_bonus')->first();
              $checkdetailpoint= DB::table('tmp_member_point')->where('order_id', $ordermember->order_id)->first();

              $countpoint= $ordermember->order_total / $checkpoint->set_value;
              if($ordermember->order_id==4 and count($checkdetailpoint) <=0){
                $insertpoint=DB::table('tmp_member_point')->insert([
                            'order_id'=>$ordermember->order_id,
                            'member_id'=>$ordermember->member_id,
                            'point_detail'=>floor($countpoint),
                ]);
                if($insertpoint){
                  $updatemember = DB::table('ms_members')
                                ->where('member_id', $checkmember->member_id)
                                ->update([
                                    'member_points'=>$checkmember->member_points + floor($countpoint),
                                ]);
                }
              }

              if($order_status==1){
                $statusname='Processing';

              }elseif ($order_status==2) {
                if($ordermember->dilivery_method=='pick'){
                  $statusname='Ready to Pickup';
                }else{
                   $statusname='Ready to Send';
                }
              }elseif ($order_status==3) {
                if($ordermember->dilivery_method=='pick'){
                    $statusname='In Pickup';
                  }else{
                     $statusname='In Dilivery';
                  }
              }elseif ($order_status==4) {
                  $statusname='Completed(Send)';
              }elseif($order_status==5) {
                 $statusname='Canceled';
              }else{
                 $statusname='Pending';
              }

              if($order_status == 0){
                  return redirect()->back()->with('success-create','Thank you for Order  '.$ordermember->order_id.' Update to '.$statusname.'');
              }else{

                // asdfgh

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
                $resultHtml=HelperEmail::emailNotifikasi($ordermember,$checkmember->member_fullname,$order_status);
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
                if($checkmember->member_email == $ordermember->customer_email){
                  $mail->addAddress($checkmember->member_email);
                }else{
                  $mail->addAddress($checkmember->member_email);
                  $mail->addAddress($ordermember->customer_email);
                }

                $mail->isHTML(true);
                $mail->Subject = "Order ".$statusname." - Invoice ".$ordermember->order_id."";
                $mail->Body = $resultHtml;
                $mail->AltBody = "ini link anda plan";
                if(!$mail->send())
                {
                    return Redirect()->back()->with('error_get','Thank you for Order ID: '.$ordermember->order_id.'  Update (Mailer Error:'.$mail->ErrorInfo.')');
                  // echo "Mailer Error: " . $mail->ErrorInfo;
                }
                {
                    return redirect()->back()->with('success-create','Thank you for Order ID: '.$ordermember->order_id.' Update to '.$statusname.'!');
                }
              }

            }else{
              return Redirect()->back()->with('error','Sorry something is error !');
            }
          }
    }else{
      return Redirect::back()->withErrors(['Sorry, No Access']);
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
      $auth = $this->CheckAuth();
        if($auth == true){
          $checkuser=DB::table('user_access')->where('access_id','=',Auth::user()->access_id)->first();
          if($checkuser->type==1){
            $checkorder = DB::table('sum_orders')->where('order_id',$id)->first();
            //PRODUCT STOCK BACK
            if(count($checkorder) >0){
              if($checkorder->order_status==0){
                    $product= DB::table('tmp_order_detail')->where('order_id','=',$checkorder->order_id)->get();

                    foreach ($product as $key => $value) {
                      if($value->prod_color=='' and $value->prod_size==''){
                        //produ non varian
                        $listprod= DB::table('ms_products')
                            ->where('prod_id','=',$value->prod_id)
                            ->first();
                        //   if(count($listvarian) >0){
                            DB::table('ms_products')
                                ->where('prod_id','=',$value->prod_id)->update([
                                  'prod_stock'=>$listprod->prod_stock + $value->detail_qty,
                                ]);
                        //    }
                      }else{
                        //varian
                        // $listvarian= DB::table('ms_product_varian')
                        //     ->where('prod_id','=',$value->prod_id)
                        //     ->where('varian_color','=',$value->prod_color)
                        //     ->where('varian_size','=',$value->prod_size)
                        //     ->first();
                        // if(count($listvarian) >0){
                          DB::table('ms_product_varian')
                               ->where('prod_id','=',$value->prod_id)
                               ->where('varian_color','=',$value->prod_color)
                               ->where('varian_size','=',$value->prod_size)
                               ->update([
                                 'varian_stock'=>$listvarian->varian_stock + $value->detail_qty,
                               ]);
                        // }
                      }
                    }
              }
            }
            //Delete order
            $i = DB::table('sum_orders')->where('order_id',$id)->update([
                'order_status'  => 5,
                'payment_status'=> 3
            ]);
            if($i > 0)
            {
             //DELETE order detail
             DB::table('tmp_order_detail')->where('order_id','=',$checkorder->order_id)->get();
             return redirect()->back()->with('success-delete','Your Order file has been deleted!');
             }else{
                return redirect()->back()->with('no-delete','Can not be removed!');
             }
          }else{
           return redirect()->back()->with('no-delete','Sorry, No Access to removed!');
          }
        }else{
          return Redirect::back()->withErrors(['Sorry, No Access']);
        }
    }

    private function CheckAuth()
    {
      $url = request()->segment(1)."/".request()->segment(2);
      $menu=DB::table('menu_admin')->where('menu_admin.status_menu','=',1)->get();
      foreach ($menu as $menus)
      {
        if($menus->url== $url){
          $cek=  Helper::checkmenuchecklist(Auth::user()->access_id, $menus->menu_id);
          if ($cek ==1){
            return true;
          }else{
            return false;
          }

        }
      }
    }
}
