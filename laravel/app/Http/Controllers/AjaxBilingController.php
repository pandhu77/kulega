<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Input;
use Cart;
use DB;
class AjaxBilingController extends Controller
{
    public function bilingprovince(){

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
            echo "<select class='form-control input-flat' name='bilprovince' id='bilprovince' onchange=\"get_bilingcity();\">";
            echo "<option value='0'>Choose Province</option>";
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

    public function  bilingcity(){
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
                echo "<select class='form-control input-flat' name='bilcity' id='bilcity' onchange=\"get_bilingdistrict();\">";
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

    public function  bilingsubdistrict(){
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
                echo "<select class='form-control input-flat' name='bildistrict' id='bildistrict'>";
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

}
