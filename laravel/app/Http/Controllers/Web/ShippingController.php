<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Cart;
use Session;

class ShippingController extends Controller{

    public function shippingcountry(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/v2/internationalDestination",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 28d8b48767f82fa8b0c7e847ebadb8e4"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $data = json_decode($response);
            $country = $data->rajaongkir->results;

            echo '<option selected value="0" country="Indonesia">Indonesia</option>';
            foreach ($country as $count) {
                echo    '<option value="'.$count->country_id.'" country="'.$count->country_name.'">'.$count->country_name.'</option>';
            }
        }
    }

    public function shippingprovince(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 28d8b48767f82fa8b0c7e847ebadb8e4"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $data = json_decode($response);
            $province = $data->rajaongkir->results;

            echo '<option disabled selected>Select Province</option>';
            foreach ($province as $prov) {
                echo    '<option value="'.$prov->province_id.'" province="'.$prov->province.'"';
                        if (Session::get('province')) {
                            if(Session::get('province') == $prov->province){
                                echo "selected";
                            }elseif (Session::get('origin_province') == $prov->province_id) {
                                echo "selected";
                            }
                        }
                echo    '>'.$prov->province.'</option>';
            }
        }
    }

    public function shippingcity(){
        $province   = Input::get('province');
        $trigger    = Input::get('trigger');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/city?province=".$province,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 28d8b48767f82fa8b0c7e847ebadb8e4"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $data = json_decode($response);
            $city = $data->rajaongkir->results;

            echo '<option disabled selected>Select City</option>';
            foreach ($city as $cit) {
                echo    '<option value="'.$cit->city_id.'" city="'.$cit->city_name.'" postalcode="'.$cit->postal_code.'"';
                        if ($trigger == 2) {
                            if(Session::get('city') == $cit->city_name){
                                echo "selected";
                            } elseif (Session::get('origin_city') == $cit->city_id) {
                                echo "selected";
                            }
                        }
                echo    '>'.$cit->type.' '.$cit->city_name.'</option>';
            }
        }
    }

    public function shippingdistrict(){
        $city       = Input::get('city');
        $trigger    = Input::get('trigger');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/subdistrict?city=".$city,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 28d8b48767f82fa8b0c7e847ebadb8e4"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $data = json_decode($response);
            $district = $data->rajaongkir->results;

            echo '<option disabled selected>Select District</option>';
            foreach ($district as $dis) {
                echo    '<option value="'.$dis->subdistrict_id.'" district="'.$dis->subdistrict_name.'"';
                        if ($trigger == 2) {
                            if(Session::get('district') == $dis->subdistrict_name){
                                echo "selected";
                            }
                        }
                echo    '>'.$dis->subdistrict_name.'</option>';
            }
        }
    }

    public function shippingcourier(){
        $couriers   = DB::table('lk_couriers')->where('enable',1)->orderBy('order_row','ASC')->get();
        $trigger    = Input::get('trigger');

        echo '<option disabled selected>Select Courier</option>';
        foreach ($couriers as $cour) {
            echo    '<option value="'.$cour->code.'"';
                    if ($trigger == 2) {
                        if(Session::get('courier') == $cour->code){
                            echo "selected";
                        }
                    }
            echo    '>'.$cour->name.'</option>';
        }
    }

    public function shippingcost(){
        $config     = DB::table('cms_config')->first();
        $addrid     = $_POST['addressid'];
        $getaddr    = DB::table('tmp_member_address')->where('id',$addrid)->first();
        // $district   = Input::get('district');
        // $courier    = Input::get('courier');
        $district   = $getaddr->district_id;
        $courier    = 'sicepat';
        $trigger    = Input::get('trigger');



        if ($getaddr->country_id == 0) {

            // NATIONAL
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "origin=".$config->origin."&originType=city&destination=".$district."&destinationType=subdistrict&weight=1&courier=".$courier,
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded",
                    "key: 28d8b48767f82fa8b0c7e847ebadb8e4"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $data = json_decode($response);
                // dd($data);
                $cost = $data->rajaongkir->results[0]->costs;

                if (empty($cost)) {
                  echo 'There`s no shipping.';
                } else {

                  if(Session::get('voucher_type') == 3){
                      echo '  <li>
                                <input type="radio" name="cost" value="'.$cost[0]->cost[0]->value.'" services="'.$cost[0]->service.'" id="radio0" onclick="shippingcalculate()" checked>
                                <label for="radio0" style="font-size:12px;">
                                  ['.$courier.'] '.$cost[0]->service.' - '.number_format($cost[0]->cost[0]->value,0,',','.').'
                                </label>
                              </li>';
                  } else {
                      foreach ($cost as $key => $co) {
                          if ($co->service == 'Priority') {

                          }else{
                              echo '  <li>
                                        <input type="radio" name="cost" value="'.$co->cost[0]->value.'" services="'.$co->service.'" id="radio'.$key.'" onclick="shippingcalculate()">
                                        <label for="radio'.$key.'" style="font-size:12px;">
                                          ['.$courier.'] '.$co->service.' - '.number_format($co->cost[0]->value,0,',','.').'
                                        </label>
                                      </li>';
                          }
                        // echo '  <li>
                        //           <input type="radio" name="cost" value="0" services="'.$co->service.'" id="radio'.$key.'" onclick="shippingcalculate()">
                        //           <label for="radio'.$key.'" style="font-size:12px;">
                        //             ['.$courier.'] '.$co->service.' - 0
                        //           </label>
                        //         </li>';
                      }
                  }
                }
            }

        } else {

            // INTERNATIONAL
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://pro.rajaongkir.com/api/v2/internationalCost",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "origin=".$config->origin."&destination=".$getaddr->country_id."&weight=1&courier=pos",
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded",
                    "key: 28d8b48767f82fa8b0c7e847ebadb8e4"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $data = json_decode($response);
                // dd($data);
                $cost = $data->rajaongkir->results[0]->costs;

                if (empty($cost)) {
                  echo 'There`s no shipping.';
                }else {
                    if(Session::get('voucher_type') == 3){
                        echo '  <li>
                                  Voucher Free Shipping Not Available For International Shipping.<br>
                                  Please Re-Input Different Voucher or <a href="javascript:;" onclick="removevoc()">Unactive Voucher</a>.
                                </li>';
                    } else {
                      foreach ($cost as $key => $co) {
                        echo '  <li>
                                  <input type="radio" name="cost" value="'.$co->cost.'" services="'.$co->service.'" id="radio'.$key.'" onclick="shippingcalculate()">
                                  <label for="radio'.$key.'" style="font-size:12px;">
                                    [POS] '.$co->service.' - '.number_format($co->cost,0,',','.').'
                                  </label>
                                </li>';
                      }
                  }
                }
            }

        }

    }

}
