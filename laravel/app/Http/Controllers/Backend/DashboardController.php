<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
class DashboardController extends Controller
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
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

   public function index(){
     // Order
      $newcount = DB::table('sum_orders')->where('order_status','=',0)->count();
      $procescount = DB::table('sum_orders')->where('order_status','=',1)->count();
      $sendcount = DB::table('sum_orders')->where('order_status','=',2)->count();
      $deliverycount = DB::table('sum_orders')->where('order_status','=',3)->count();
      $completcount = DB::table('sum_orders')->where('order_status','=',4)->count();
      $cancelcount = DB::table('sum_orders')->where('order_status','=',5)->count();

     // Payment
      $waiting = DB::table('sum_orders')->where('payment_status','!=',1)->where('payment_status','!=',2)->where('payment_status','!=',3)->where('order_status','=',0)->count();
      $confir = DB::table('sum_orders')->where('payment_status','=',1)->where('order_status','=',0)->count();
      $acp = DB::table('sum_orders')->where('payment_status','=',2)->count();
      $failed = DB::table('sum_orders')->where('payment_status','=',3)->count();

     return view('backend.dashboard',[
       'newcount'=>$newcount,
       'procescount'=>$procescount,
       'sendcount'=>$sendcount,
       'deliverycount'=>$deliverycount,
       'completcount'=>$completcount,
       'cancelcount'=>$cancelcount,
       'waiting'=>$waiting,
       'confir'=>$confir,
       'acp'=>$acp,
       'failed'=>$failed

     ]);

   }
}
