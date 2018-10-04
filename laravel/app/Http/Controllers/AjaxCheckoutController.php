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


class AjaxCheckoutController extends Controller
{
    public function forgetdata(){
      Session::forget("shipping_service1");
    }

    public function getBonus(){
        $id=input::get('id');
        $status=input::get('status');

        if(Session::get('memberid')){
          $memberid=Session::get('memberid');
          $tmppoint= DB::table('cart_point')->where('member_id','=',$memberid)->first();
          $reward= DB::table('ms_bonus')->where('bonus_id','=',$id)->where('bonus_poin','<=', $tmppoint->point)->first();
          $grand=Session::get('subtotal1') - Session::get('disclevel1') - Session::get('disccart1') - Session::get('discvoc') - Session::get('bonusreward1');
          if(count($reward) > 0){
            if($status ==1){

              //set reward
              if($reward->bonus_reward=='nominal'){
                  $valuereward=$reward->bonus_value;
              }else{
                $disreward=$reward->bonus_value/100;
                $valuereward= $grand * $disreward;
              }

              // Session::set('valuereward1',Session::get('valuereward1') + $valuereward);
              if(Session::get('grandtotal1') >= $valuereward){
                  DB::table('cart_point')->where('member_id','=',$memberid)->update([
                      'point'=>$tmppoint->point - $reward->bonus_poin,
                  ]);
                  $member_reward=DB::table('cart_point')->where('member_id','=',$memberid)->first();

                  Session::set('bonusreward1', Session::get('bonusreward1') + $valuereward);
                  Session::set('grandtotal1', $grand - $valuereward);
                  Session::set('tmppoint1',$member_reward->point);

                  $response['htmlreward'] = '<span style="color:#333">IDR '. number_format(Session::get('bonusreward1'),0,",",".").'</span>';
                  $response['htmltotal'] = '<span  style="color:#333">IDR '. number_format(Session::get('grandtotal1'),0,",",".").'</span>';
                  $response['htmlpoint']='<span>'.Session::get('tmppoint1').'</span>';
                  $response['status'] = "1";
              }else{
                  $response['status'] = "0";
                  $response['html'] ="<div class='alert alert-danger' style='padding: 6px;'>
                                      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                      ' Sorry, Total shopping minimum above IDR ". number_format($valuereward,0,",",".")." '
                                      </div>";
              }


            }else{
              //delete reward
              if($reward->bonus_reward=='nominal'){
                  $valuereward=$reward->bonus_value;
                  $delreward=Session::get('valuereward1') -$valuereward;
              }else{
                $disreward=$reward->bonus_value/100;
                $valuereward=$grand * $disreward;

              }
                if(Session::get('grandtotal1') >= $valuereward){
                    DB::table('cart_point')->where('member_id','=',$memberid)->update([
                        'point'=>$tmppoint->point + $reward->bonus_poin,
                    ]);
                    $member_reward=DB::table('cart_point')->where('member_id','=',$memberid)->first();

                    Session::set('bonusreward1', Session::get('bonusreward1') - $valuereward);
                    Session::set('tmppoint1',$member_reward->point);
                    Session::set('grandtotal1',$grand + $valuereward);

                    $response['htmlreward'] = '<span class="price_format" style="color:#333">IDR '. number_format(Session::get('bonusreward1'),0,",",".").'</span>';
                    $response['htmltotal'] = '<span class="price_format" style="color:#333">IDR '. number_format(Session::get('grandtotal1'),0,",",".").'</span>';
                    $response['htmlpoint']='<span>'.Session::get('tmppoint1').'</span>';
                    $response['status'] = "1";
                  }
            }

          }else{
            $response['status'] = "0";
            $response['html'] ="<div class='alert alert-danger' style='padding: 6px;'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                ' Sorry, your point is insufficient'
                                </div>";

          }

           return json_encode($response);exit;

        }



    }
    /* BEGIN AJAX GET METHOD BANK */
    public function getmethodBank(){
          $grandtotal=Session::get('grandtotal1');
          $subtotal=Session::get('subtotal1');
          $ongkir=Session::get('ongkir1');
          $discvoc=Session::get('discvoc');
          $service=Session::get('shipping_service1');
          $disclevel=Session::get('disclevel1');
          $disc_cart=Session::get('disccart1');
          $hitdisc=$subtotal-$disclevel- $disc_cart - $discvoc - Session::get('bonusreward1');
          $grand=$hitdisc+ $ongkir ;
          $shipping_service=0;
          $grandtotalservice=$grand + $shipping_service + Session::get('coderandom1');
          Session::set('shipping_service1',$shipping_service);
          Session::set('grandtotal1',$grandtotalservice);
          // $response['htmlcart'] = "<div class='totals-value '>IDR ". number_format($shipping_service,0,",",".")."</div>";
          $response['htmltotal'] = "<div class='totals-value '>IDR " . number_format($grandtotalservice,0,",",".")."</div>";
          return json_encode($response);exit;

    }
    /* END AJAX GET TOTAL */
    /* BEGIN AJAX GET TOTAL */
    public function getmethodcart(){
          $grandtotal=Session::get('grandtotal1');
          $subtotal=Session::get('subtotal1');
          $disclevel=Session::get('disclevel1');
          $disc_cart=Session::get('disccart1');
          $ongkir=Session::get('ongkir1');
          $discvoc=Session::get('discvoc');

          $hitdisc=$subtotal-$disclevel - $disc_cart -  $discvoc - Session::get('bonusreward1');
          $grand=$hitdisc + $ongkir;
          $checkcart=DB::table('lk_credit_card')->first();
          // $service=$checkcart->service_cost / 100;
          // $shipping_service= $grand * $service;
          $shipping_service=0;
          $grandtotalservice=$grand + $shipping_service + Session::get('coderandom1');
          Session::set('shipping_service1',$shipping_service);
          Session::set('grandtotal1',$grandtotalservice);
          // var_dump($grand);
          // $response['htmlcart'] = "<div class='totals-value '>IDR ". number_format($shipping_service,0,",",".")."</div>";
          $response['htmltotal'] = "<div class='totals-value '>IDR " . number_format($grandtotalservice,0,",",".")."</div>";
          return json_encode($response);exit;

    }
    /* END AJAX GET TOTAL */
    /* BEGIN AJAX GET TOTAL */
    public function getVoucher(){
      if(Session::get('memberid')){
          $memberid=Session::get('memberid');
          $date= new Datetime();
          $nowdate=$date->format('Y-m-d');
          $kode=input::get('kode');
          $grand=Session::get('subtotal1') - Session::get('disclevel1') - Session::get('disccart1') - Session::get('bonusreward1');
          $voucher=DB::table('ms_voucher')
          ->where('voucher_status','=',1)
          ->where('voucher_code',$kode)->first();

          if($voucher !==null ) {
            $usageMember=DB::table('tmp_voucher_usage')
            ->where('voucher_id','=',$kode)
            ->where('member_id',$memberid)->where('usage','>=',$voucher->voucher_limit_user)->first();
             if($usageMember == null){
              $limitusage=DB::table('ms_voucher')
                    ->where('voucher_code',$kode)
                    ->where('voucher_status','=',1)
                    ->where('voucher_limit_usage','>',0)->first();
                  if($limitusage !==null){

                    $checkvalue=DB::table('ms_voucher')
                            ->where('voucher_code',$kode)
                            ->where('voucher_status','=',1)
                            ->where('voucher_min_value','<=',$grand)
                            ->where('voucher_max_value','>=',$grand)
                            ->first();
                    if($checkvalue !==null){
                      $checkdate=DB::table('ms_voucher')
                              ->where('voucher_code',$kode)
                              ->where('voucher_status','=',1)
                              ->where('voucher_start_date','<=',$nowdate)
                              ->where('voucher_end_date','>=',$nowdate)
                              ->first();

                        if($checkdate !== null){
                              if($checkdate->voucher_type==2){

                                  $disvoc=$checkdate->voucher_value/100;
                                  $totdiscvoc=$grand * $disvoc;
                                  $grandtotalvoc=$grand - $totdiscvoc;
                                  Session::set('kodevoc', $kode);
                                  Session::set('discvoc',$totdiscvoc);
                                  Session::set('grandtotal1',$grandtotalvoc);


                                  $response['htmlvoucher'] = "<span style='color:#333'>IDR ".number_format($totdiscvoc,0,",",".")."</span>";
                                  $response['htmltotal'] = "<spanstyle='color:#333'>IDR ".number_format($grandtotalvoc,0,",",".")."</span>";


                                  $response['status'] = "0";
                                  $response['alert'] ="<div class='alert alert-success' style='padding: 6px;'>
                                                      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                       Coupon valid!
                                                     </div>";

                              }else{
                                 $grandtotalvoc= $grand - $checkdate->voucher_value;

                                 Session::set('kodevoc', $kode);
                                 Session::set('discvoc',$checkdate->voucher_value);
                                 Session::set('grandtotal1',$grandtotalvoc);

                                 $response['htmlvoucher'] = " <span style='color:#333'>IDR ".number_format($checkdate->voucher_value,0,",",".")."</span>";
                                 $response['htmltotal'] = "
                                                          <span style='color:#333'>IDR ".number_format($grandtotalvoc,0,",",".")."</span>
                                                          ";

                                   $response['status'] = "0";
                                   $response['alert'] ="<div class='alert alert-success' style='padding: 6px;'>
                                                       <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                        Success, 'Coupon valid!'
                                                      </div>";

                              }

                        }else{
                              $response['html'] ="<div class='alert alert-danger' style='padding: 6px;'>
                                                  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                     Sorry, 'The date is not available!'
                                                 </div>";
                               $response['status'] = "2";
                              }


                  }else{
                     $response['html'] ="<div class='alert alert-danger' style='padding: 6px;'>
                                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                       Sorry, 'The total cart is not available!!'
                                   </div>";
                     $response['status'] = "5";
                  }

                  }else{
                    $response['html'] ="<div class='alert alert-danger' style='padding: 6px;'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        Sorry,  'The stock voucher t is not available!'
                                        </div>";

                    $response['status'] = "3";
                  }

            }else{
              $response['html'] ="<div class='alert alert-danger' style='padding: 6px;'>
                                  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                  Sorry, 'You have used a voucher code!'
                                  </div>";
              $response['status'] = "6";
            }
          }else{
                $response['html'] ="<div class='alert alert-danger' style='padding: 6px;'>
                                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                    Sorry, 'Voucher code do not match!'
                                    </div>";
                $response['status'] = "4";
              }
          return json_encode($response);exit;

      }else{
        Session::flash('error_must_login','You must sign');
        return Redirect('user/login');
      }
    }
    /* END AJAX GET TOTAL */
    /* BEGIN AJAX GET TOTAL */
    public function gettotal(){
        if(Session::get('memberid')){
          // Session::forget("grandtotal1");
          // Session::forget("subtotal1");
          // Session::forget("disclevel1");
          // Session::forget("levelname1");
          Session::forget("ongkir1");
          Session::forget("session_province");
          Session::forget("session_city");
          Session::forget("session_subdistrict");
          Session::forget("session_bilcity");
          Session::forget("session_bilprovince");
          Session::forget("session_bildistrict");
          $province=input::get('province');
          $city=input::get('city');
          $subdistrict=input::get('subdistrict');
          $bilprovince=input::get('bilprovince');
          $bilcity=input::get('bilcity');
          $bildistrict=input::get('bildistrict');
          Session::set('session_province',$province);
          Session::set('session_city',$city);
          Session::set('session_subdistrict',$subdistrict);

          Session::set('session_bilcity',$bilcity);
          Session::set('session_bilprovince',$bilprovince);
          Session::set('session_bildistrict',$bildistrict);


          $ongkir=input::get('ongkir');
          $service=Session::get('shipping_service1');
          $discvoc=Session::get('discvoc');
          $subtotal=Session::get('subtotal1');

          /* Begin Check Discont Cart  */
          $disc_cart=Session::get('disccart1');
          /** End Discount level */

          /* Begin Check Discont Cart  */
          $disclevel=Session::get('disclevel1');
          $levelname=Session::get('levelname1');


          $checkgrandtotal=$subtotal-$disc_cart-$disclevel - Session::get('bonusreward1') - $discvoc;
          /** End Discount level */

          $updategrandtotal=($checkgrandtotal + $ongkir + $service + Session::get('coderandom1'));
          Session::set('grandtotal1',$updategrandtotal);

          Session::set('ongkir1',$ongkir);
          if($disclevel >0){
            $response['htmllevelname'] = "<span>".$levelname."</span>";
          }else{
            $response['htmllevelname'] = "";
          }
          $response['htmldislevel'] = "<div class='totals-value '> IDR ".number_format($disclevel,0,",",".")."</div>";
          $response['htmltotal'] = "<div class='totals-value '>IDR ".number_format($updategrandtotal,0,",",".")."</div>";
          return json_encode($response);exit;
        }else{
          Session::flash('error_must_login','You must sign');
                  return Redirect('user/login');
        }
    }

    // private function total(){
    //   $test = DB::table('table')->get();
    //   return $test;
    // }


}
