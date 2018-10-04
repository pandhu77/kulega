<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Input;
use Cart;
use DB;
class AjaxController extends Controller
{
    public function shippingprovince(){

        session_start();
        $key = '28d8b48767f82fa8b0c7e847ebadb8e4';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://pro.rajaongkir.com/api/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 1000,
            CURLOPT_TIMEOUT => 1000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: " . $key
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            # echo "cURL Error #:" . $err;
        } else {

            $data = json_decode($response, true);
            $i = 0;
            echo "<div class='row'>";
            echo "<div class='col-md-12'>";
            echo "<select class='form-control' name='province' id='province' required='' onchange=\"get_city();\">";
            echo "<option value=''  selected disable>Choose Province</option>";
            foreach($data['rajaongkir']['results'] as $row){
                $selected = "";
                if(isset($_SESSION['data']['province']) && $_SESSION['data']['province'] == $row['province_id']){
                    $selected = "selected";
                }
                // if($row['province_id'] == 2){
                //   $checked = "selected";
                // }
                echo "<option class=\"province_option\" data-name='" . $row['province'] . "'  value='" . $row['province_id'] . "'" . $selected . ">" . $row['province'] . "</option>";
                $i++;
            }
            echo "</select>";
            echo "</div>";
            echo "</div>";
        }
    }

    public function shippingcity(){
        session_start();
        $province = Input::get('province');
        $provincename = Input::get('provincename');
        //Membuat Sesi province
        Session::set('province',$province);
        Session::set('provincename',$provincename);

        //echo Session::get('province');
        $check = "";
        if(isset($province)){
            $province = $province;
            if(isset($_SESSION['data']['province']) && $_SESSION['data']['province'] != $province){
                $_SESSION['data']['city'] = "0";
                $check = "selected";
                if(isset($_SESSION['data']['ongkir'])){
                    $_SESSION['data']['ongkir'] = 0;
                }
            }
            $_SESSION['data']['province'] = $province;
        }
        else if(!isset($_GET['province']) && isset($_SESSION['data']['province'])){
            $province = $_SESSION['data']['province'];
        }

        if(isset($province)){
            $key = '28d8b48767f82fa8b0c7e847ebadb8e4';
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://pro.rajaongkir.com/api/city?province=" . $province,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 1000,
                CURLOPT_TIMEOUT => 1000,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "key: " . $key
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                # echo "cURL Error #:" . $err;
            } else {
                $data = json_decode($response, true);
                // var_dump($data);
                $i = 0;
                echo "<div class='row'>";
                echo "<div class='col-md-12'>";
                echo "<select class='form-control input-flat' name='city' id='city'required onchange=\"getSubDistrict();\">";
                echo "<option value='0'".$check.">Choose City</option>";
                foreach($data['rajaongkir']['results'] as $row){
                    $selected = "";
                    if(isset($_SESSION['data']['city']) && $_SESSION['data']['city'] == $row['city_id']){
                        $selected = "selected";
                    }

                    echo "<option data-name='" . $row['type'] . " " . $row['city_name'] .  "' value='". $row['city_id'] .  "' name='province'". $selected .">" . $row['type'] . " " . $row['city_name']  . "</option>";
                }
                echo "</select>";
                echo "</div>";
                echo "</div>";
            }
        }
        else{
            echo "<div class='row'>";
            echo "<div class='col-md-12'>";
            echo "<select class='form-control' name='city' id='city_input'>";
            echo "<option value='0'>Pilih Kota</option>";
            echo "</select>";
            echo "</div>";
            echo "</div>";
        }

    }

    public function shippingsubdistrict(){
        session_start();
        $getcity = Input::get('city');
        $cityname = Input::get('cityname');
        //Membuat Sesi province
        Session::set('city',$getcity);
        Session::set('cityname',$cityname);

        //echo $city;
        //exit();
        //echo Session::get('province');
        $check = "";
        if(isset($getcity)){
            $city = $getcity;
            if(isset($_SESSION['data']['city']) && $_SESSION['data']['city'] != $city){
                $_SESSION['data']['subdistrict'] = "0";
                $check = "selected";
                if(isset($_SESSION['data']['ongkir'])){
                    $_SESSION['data']['ongkir'] = 0;
                }
            }
            $_SESSION['data']['city'] = $city;
        }
        else if(!isset($_GET['city']) && isset($_SESSION['data']['city'])){
            $province = $_SESSION['data']['city'];
        }

        if(isset($getcity)){
            $key = '28d8b48767f82fa8b0c7e847ebadb8e4';
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://pro.rajaongkir.com/api/subdistrict?city=" . $getcity,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 1000,
                CURLOPT_TIMEOUT => 1000,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "key: " . $key
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                # echo "cURL Error #:" . $err;
            } else {
                $data = json_decode($response, true);
                //var_dump($data);
                //exit();
                $i = 0;
                echo "<div class='row'>";

                echo "<div class='col-md-12'>";
                echo "<select class='form-control input-flat' name='subdistrict' required id='subdistrict' onchange=\"get_cost();\">";
                echo "<option value='0'".$check.">Choose Sub District</option>";
                foreach($data['rajaongkir']['results'] as $row){
                    $selected = "";
                    if(Session::get('city') && Session::get('getsubdistrict') == $row['subdistrict_id']){
                        $selected = "selected";
                    }

                    echo "<option data-name='" . $row['subdistrict_name'] .  "' value='". $row['subdistrict_id'] .  "' name='getcity'". $selected .">" . $row['subdistrict_name']  . "</option>";
                }
                echo "</select>";
                echo "</div>";
                echo "</div>";
            }
        }else{
            echo "<div class='row'>";
            echo "<div class='col-sm-7 col-sm-offset-5'>";
            echo "<select class='form-control' name='subdistrict' id='subdistrict_input'>";
            echo "<option value='0'>Choose Subdistrict</option>";
            echo "</select>";
            echo "</div>";
            echo "</div>";
        }

    }

    public function shippingcost(){
        session_start();
        $getsubdistrict= Input::get('subdistrict');
        $subdistrictname= Input::get('subdistrictname');

        $city= Input::get('city');
        $cityname= Input::get('cityname');

        //Membuat Sesi kota
        Session::set('city',$city);
        Session::set('cityname',$cityname);
        Session::set('getsubdistrict',$getsubdistrict);
        Session::set('subdistrictname',$subdistrictname);

        $origin = 151;
        if(isset($getsubdistrict)){
            $destination = $getsubdistrict;
        }
        else if(isset($_SESSION['data']['getsubdistrict'])){
            $destination = $_SESSION['data']['getsubdistrict'];
        }

        // if($destination != $_SESSION['data']['city']){
        //   $_SESSION['data']['ongkir'] = 0;
        // }

        if(isset($destination)){
            // $weight = $_GET['weight'];
            $weight = 0;
            if(!isset($_SESSION['cart']['product_weight'])){
                $weight = Input::get('weight');
            }
            else{
                foreach($_SESSION['cart'] as $row){
                    $temp = $row['product_weight'] * $row['qty'];
                    $weight = $weight + $temp;
                }
            }

            $_SESSION['data']['getsubdistrict'] = $destination;
            if($destination != 0){
                $key = '28d8b48767f82fa8b0c7e847ebadb8e4';

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "http://pro.rajaongkir.com/api/cost",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 1000,
                    CURLOPT_TIMEOUT => 1000,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "origin=".$origin."&originType=city&destination=".$destination."&destinationType=subdistrict&weight=".$weight."&courier=jne",
                    CURLOPT_HTTPHEADER => array(
                        "content-type: application/x-www-form-urlencoded",
                        "key: " . $key
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    # echo "cURL Error #:" . $err;
                } else {

                    $data = json_decode($response, true);


                    #foreach($data['rajaongkir']['results'][0]['costs'] as $row){
                    if(isset($data['rajaongkir']['results'][0]['costs'])){
                        $row = $data['rajaongkir']['results'][0]['costs'];

                        $i = 0;
                        echo "<div class='row'>";
                        echo "<div class='col-sm-12'>";
                        while ($i < count($row) && $i < 3){
                            $check = "";
                            if(Session::get('ongkir') && Session::get('ongkir') == $row[$i]['cost'][0]['value']){
                                $check = "checked";
                            }
                            echo "<label><input id='ongkir1' type='radio' class='ongkir' name='ongkir' value='".$row[$i]['cost'][0]['value']."'
                            onchange=\"set_ongkir(" . $row[$i]['cost'][0]['value'] . ",'JNE ".$row[$i]['service']."')\" ". $check ."/> JNE " . $row[$i]['service'] . " - Rp <span class=\"money\">"  . $row[$i]['cost'][0]['value'] . "</span></label> <br/>";
                            $i++;
                        }

                        echo "</div>";
                        echo "</div>";
                        if($i == 0){
                            echo "<div class='row'>";
                            echo "<div class='col-sm-12'>";
                            echo "<div class=\"text-300 text-right\">Sorry there's no shipping method available.</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                        // echo "<div class='row'>";
                        // echo "<div class='col-sm-12'>";
                        // echo "<label><input id='ongkir' type='radio' class='ongkir' name='ongkir' onchange=\"set_ongkir('0,0')\" value='0'/><input id='byReq' type='text' placeholder='Others' style='height:30px; width:auto; margin-left:5px; padding-left:5px;' disabled>" . "</span></label> <br/>";
                        // echo "</div>";
                        // echo "</div>";
                    }
                    else{
                        echo "<div class='row'>";
                        echo "<div class='col-sm-5 col-sm-offset-7'>";
                        echo "<div class=\"text-300 text-right\">Sorry there's no shipping method available.</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                    // echo $weight;
                    #}
                }
            }
        }else{
            echo "<div class='row'>";
            echo "<div class='col-sm-5 col-sm-offset-7'>";
            echo "<div class=\"text-300 text-right\">Sorry there's no shipping method available.</div>";
            echo "</div>";
            echo "</div>";
        }
    }



    public function shippingongkir(){

        session_start();
        $carttotal          = Cart::total();
        $province           = Input::get('province');
        $city               = Input::get('city');
        $subdistrict        = Input::get('subdistrict');
        $package            = Input::get('package');
        $paket              = Input::get('paket');
        $kurir              = Input::get('kurir');
        Session::set('kurir',$kurir);
        $ongkir             = Input::get('ongkir');

          var_dump($province);

        //echo $carttotal;

        //Jika sudah ada kode Voucher
        if(Session::get('vouchercode')) {

            if(Session::get('vouchertype')==1){
                $count=Cart::total()/100*Session::get('vouchervalue');
                $hitung=Cart::total()-$count+$ongkir;

            }elseif(Session::get('vouchertype')==2){
                $hitung=Cart::total()-Session::get('vouchervalue')+$ongkir;
            }

            Session::set('ongkir',$ongkir);
            Session::set('shoppingpackage',$paket);
            Session::set('shoptotal',$hitung);
            //SET SESSION
            Session::set('province',$province);
            Session::set('city',$city);
            echo Session::get('shoptotal');

        }else{
            //Jika belum ada kode Voucher

            Session::set('package',$paket);
            Session::set('ongkir',$ongkir);

            $hitung = $carttotal + $ongkir;
            Session::set('shoptotal',$hitung);
            ////SET SESSION
            //Session::set('province',$province);
            //Session::set('city',$city);
            $to = Session::get('shoptotal');
            echo $to;
        }
    }
    public function getmodal(){
      $prod=DB::table('ms_products')
             ->where('prod_id', '=', Input::get('prod_id'))
             ->first();

      $prodimage= DB::table('tmp_product_image')
                ->where('prod_id','=',Input::get('prod_id'))->get();
    }

    public function shipchange(){
        $id = Input::get('idadd');
        $getaddress = DB::table('address_book')
                   ->where('member_id', '=', $id)
                   ->first();

        // echo    '   <div class="form-group">
        //                     <label for="email">Recipient Name *</label>
        //                     <input type="text" class="form-control" id="fullname" name="reciptname" required="" value=".'{{$address->recipentname}}'.">
        //                 </div>
        //                 <div class="form-group">
        //                     <label for="pwd">Phone Number *</label>
        //                     <input type="text" class="form-control" id="phone" name="phone" required="" value=".'{{$address->phone_number}}'.">
        //                 </div>
        //                 <div class="form-group">
        //                     <label for="pwd">Address *</label>
        //                     <textarea name="address" class="form-control input-flat" placeholder="Address" style="resize: vertical;" required="" value=".'{{$address->address}}'."></textarea>
        //                 </div>
        //                 <div class="form-group">
        //                     <label for="pwd">Postal Code *</label>
        //                     <input type="text" class="form-control" id="postcode" name="postcode" required="" value=".'{{$address->post_code}}'.">
        //                 </div>
        //                 <div class="form-group">
        //                 <div id="shippingprovince">
        //                     <div class="row" id="loadingprov" >
        //                         <div class="col-md-12 text-center">
        //                             <img src=".'{{ asset('assets/img/web/small_loading.gif') }}'." alt="loading">
        //                         </div>
        //                     </div>
        //                 </div>
        //             </div>

    }
}
