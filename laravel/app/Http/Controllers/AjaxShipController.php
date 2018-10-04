<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Cart;


class AjaxShipController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function checkPickup(){
     $point=input::get('pointid');

     $tmp=DB::table('tmp_pickup')->join('ms_pickup','tmp_pickup.pick_id','=','ms_pickup.pick_id')->where('id','=',$point)->first();
     echo ''.$tmp->city.'';
   }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function pickchange(){
       $id = Input::get('idadd');
      $getadd = DB::table('address_book')
                   ->where('adress_id', '=', $id)
                   ->first();
      $urldomain=urldomain();

       echo 	'
            <input type="hidden" name="idadd" id="" value="'.$getadd->adress_id.'">
            <div class="form-group valid hidden">
              <label for="email">Title *</label>

              <input type="text" class="form-control" id="titlebook" placeholder="Title" name="titlebook" required="gettitlebook_sm()" value="'.$getadd->title.'">
            </div>
            <div class="form-group valid">
                <label for="email">Recipient Name *</label>
                <input type="text" class="form-control" id="fullnamebook" name="reciptnamebook" onkeyup="getnamebook_sm()" required="" value="'.$getadd->recipentname.'">
            </div>
            <div class="form-group valid">
                <label for="pwd">Phone Number *</label>
                <input type="text" class="form-control" id="phonebook" name="phonebook" required="" onkeyup="getphonebook_sm()"  value="'.$getadd->phone_number.'">
            </div>
            <div class="form-group valid">
                <label for="pwd">Email *</label>
                <input type="email" class="form-control" id="emailbook" name="emailbook" required="" onkeyup="getemailbook_sm()"  value="'.$getadd->email.'">
            </div>
            <div class="form-group valid">
                <label for="pwd">Address *</label>
                <textarea name="addressbook" id="addressbook" class="form-control input-flat" placeholder="Address" onkeyup="getaddressbook_sm()"  style="resize: vertical;" required="" value="">'.$getadd->address.'</textarea>
            </div>
            <div class="form-group valid">
                <label for="pwd">Postal Code *</label>
                <input type="text" class="form-control" id="postcodebook" name="postcodebook" onkeyup="getpostbook_sm()" required value="'.$getadd->post_code.'">
            </div>
            <div class="form-group valid">

              <div id="shippingprovince">
                  <div class="row" id="loadingprov" >
                      <div class="col-md-12 text-center">
                      <img src="'.$urldomain.'/assets/img/web/small_loading.gif" alt="loading">
                        <input type="hidden" class="form-control"  placeholder=""name="province"  required="" value="">
                      </div>
                  </div>
              </div>
            </div>

          <div class="form-group valid">
            <div class="row" id="loadingcitimg" style="display: none;">
                <div class="col-md-12 text-center">
                <img src="'.$urldomain.'/assets/img/web/small_loading.gif" alt="loading">
                </div>
            </div>
              <div id="shippingcity">
                  <div class="row" id="loadingcit" style="display: none;">
                      <div class="col-md-12 text-center">
                        <img src="'.$urldomain.'/assets/img/web/small_loading.gif" alt="loading">
                          <input type="hidden" class="form-control"  placeholder=""name="city"  required="" value="">
                      </div>
                  </div>
              </div>
          </div>
          <div class="form-group valid">
              <div class="row" id="loadingsubimg" style="display: none;">
                  <div class="col-md-12 text-center">
                    <img src="'.$urldomain.'/assets/img/web/small_loading.gif" alt="loading">
                  </div>
              </div>

              <div id="shippingsubdistrict">
                  <div class="row" id="loadingsub" style="display: none;">
                      <div class="col-md-12 text-center">
                        <img src="'.$urldomain.'/assets/img/web/small_loading.gif" alt="loading">
                          <input type="hidden" class="form-control"  placeholder=""name="subdistrict"  required="" value="">
                      </div>
                  </div>
              </div>
          </div>

           ';
     }
     public function shipchange(){
   		$id = Input::get('idadd');
      $getadd = DB::table('address_book')
                   ->where('adress_id', '=', $id)
                   ->first();
      $urldomain=urldomain();

   		echo 	'
            <input type="hidden" name="idadd" id="" value="'.$getadd->adress_id.'">
            <div class="form-group valid hidden">
              <label for="email">Title *</label>

              <input type="text" class="form-control" id="titlebook" placeholder="Title" name="titlebook" required="gettitlebook_sm()" value="'.$getadd->title.'">
            </div>
            <div class="form-group valid">
                <label for="email">Recipient Name *</label>
                <input type="text" class="form-control" id="fullnamebook" name="reciptnamebook" onkeyup="getnamebook_sm()" required="" value="'.$getadd->recipentname.'">
            </div>
            <div class="form-group valid">
                <label for="pwd">Phone Number *</label>
                <input type="text" class="form-control" id="phonebook" name="phonebook" required="" onkeyup="getphonebook_sm()"  value="'.$getadd->phone_number.'">
            </div>
            <div class="form-group valid">
                <label for="pwd">Email *</label>
                <input type="email" class="form-control" id="emailbook" name="emailbook" required="" onkeyup="getemailbook_sm()"  value="'.$getadd->email.'">
            </div>
            <div class="form-group valid">
                <label for="pwd">Address *</label>
                <textarea name="addressbook" id="addressbook" class="form-control input-flat" placeholder="Address" onkeyup="getaddressbook_sm()"  style="resize: vertical;" required="" value="">'.$getadd->address.'</textarea>
            </div>
            <div class="form-group valid">
                <label for="pwd">Postal Code *</label>
                <input type="text" class="form-control" id="postcodebook" name="postcodebook" onkeyup="getpostbook_sm()" required value="'.$getadd->post_code.'">
            </div>
            <div class="form-group valid">
              <div class="row" id="loadingprovimg" style="display: none;">
                  <div class="col-md-12 text-center">
                  <img src="'.$urldomain.'/assets/img/web/small_loading.gif" alt="loading">
                  </div>
              </div>
              <div id="shippingprovince">
                  <div class="row" id="loadingprov" >
                      <div class="col-md-12 text-center">
                      <img src="'.$urldomain.'/assets/img/web/small_loading.gif" alt="loading">
                        <input type="hidden" class="form-control"  placeholder=""name="province"  required="" value="">
                      </div>
                  </div>
              </div>
            </div>

          <div class="form-group valid">
            <div class="row" id="loadingcitimg" style="display: none;">
                <div class="col-md-12 text-center">
                <img src="'.$urldomain.'/assets/img/web/small_loading.gif" alt="loading">
                </div>
            </div>
              <div id="shippingcity">
                  <div class="row" id="loadingcit" style="display: none;">
                      <div class="col-md-12 text-center">
                        <img src="'.$urldomain.'/assets/img/web/small_loading.gif" alt="loading">
                          <input type="hidden" class="form-control"  placeholder=""name="city"  required="" value="">
                      </div>
                  </div>
              </div>
          </div>
          <div class="form-group valid">
            <div class="row" id="loadingsubimg" style="display: none;">
                <div class="col-md-12 text-center">
                <img src="'.$urldomain.'/assets/img/web/small_loading.gif" alt="loading">
                </div>
            </div>
              <div id="shippingsubdistrict">
                  <div class="row" id="loadingsub" style="display: none;">
                      <div class="col-md-12 text-center">
                        <img src="'.$urldomain.'/assets/img/web/small_loading.gif" alt="loading">
                          <input type="hidden" class="form-control"  placeholder=""name="subdistrict"  required="" value="">
                      </div>
                  </div>
              </div>
          </div>
          <div class="form-group valid" id="valid">
            <div class="row" id="loadingcostimg" style="display: none;">
                <div class="col-md-12 text-center">
                <img src="'.$urldomain.'/assets/img/web/small_loading.gif" alt="loading">
                </div>
            </div>
              <div id="shippingcost">
                  <div class="row" id="loadingcost" style="display: none;">
                      <div class="col-md-12 text-center">
                        <img src="'.$urldomain.'/assets/img/web/small_loading.gif" alt="loading">
                          <input type="hidden" class="form-control"  placeholder=""name="ongkir"  required="" value="">
                      </div>
                  </div>
              </div><br><br>
          </div>
   				';
   	}

        //SHIPPING OPTION!!!
    public function shippingprovince($id){
      $address = DB::table('address_book')->where('adress_id','=', $id)->first();
      $key = '7bf1b24ce0fce9fb5644fc9a8f785902';
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => "http://api.rajaongkir.com/starter/province",
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
          // exit();
          $i = 0;
          // echo "<div class='row'>";
          //     echo "<div class='col-xs-4'>";
          //     echo "<h6 class='text-right'>Domestic</h6>";
          //     echo "</div>";
          //     echo "<div class='col-xs-8' style='margin-bottom:10px;'>";
                  echo "<select class='form-control input-flat trig-sprovinces soflowinfo' name='province'required id='province' onchange=\"get_city();\">";
                    echo "<option value='0' selected>Coose Province</option>";
                    foreach($data['rajaongkir']['results'] as $row){
                      $selected = "";

                      if($address->province == $row['province']){
                      $selected = "selected";
                      //    echo "<option class=\"province_option\" data-name='" . $address->province . "'  value='" . $row['province_id'] . "'" . $selected . ">" . $row['province'] . "</option>";
                      }
                      // if(isset($_SESSION['data']['province']) && $_SESSION['data']['province'] == $row['province_id']){
                      //  $selected = "selected";
                      // }
                      //// if($row['province_id'] == 2){
                      ////   $checked = "selected";
                      //// }
                       echo "<option class=\"province_option\" data-name='" . $row['province'] . "'  value='" . $row['province_id'] . "'" . $selected . ">" . $row['province'] . "</option>";
                      // $i++;
                    }
                  echo "</select>";
          //     echo "</div>";
          // echo "</div>";
          }
      }


      public function shippingcity($id){
          $address = DB::table('address_book')->where('adress_id','=', $id)->first();
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
                  echo "<select class='form-control input-flat' name='city' id='city' required onchange=\"getSubDistrict();\">";
                  echo "<option value='0'".$check.">Choose City</option>";
                  foreach($data['rajaongkir']['results'] as $row){
                      $selected = "";

                            if($address->city == $row['type'] ." ". $row['city_name']){
                              $selected = "selected";
                            }
                      // if(isset($_SESSION['data']['city']) && $_SESSION['data']['city'] == $row['city_id']){
                      //     $selected = "selected";
                      // }

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

      public function shippingsubdistrict($id){
         $address = DB::table('address_book')->where('adress_id','=', $id)->first();
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
                  echo "<select class='form-control input-flat' name='subdistrict' id='subdistrict' required onchange=\"get_cost();\">";
                  echo "<option value='0'".$check.">Choose Sub District</option>";
                  foreach($data['rajaongkir']['results'] as $row){
                      $selected = "";

                      if($address->subdistrict == $row['subdistrict_name']){
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
