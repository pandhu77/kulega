<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class JurnalController extends Controller
{
	private string $this->access_token;

	public function __construct(){
		$token = DB::table('t_module_options')->where('module','=','jurnal')->where('code','=','token')->first();
		$this->access_token = $token->default_value;
    }

	public function productAddData(Request $request){
		$data = $request->input('data');
		if(!empty($data)){
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.jurnal.id/partner/core/api/v1/products?access_token=".$this->access_token,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => json_encode($data),
			  CURLOPT_HTTPHEADER => array(
			    "access_token: ".$this->access_token,
			    "content-type: application/json"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  return "cURL Error #:" . $err;
			} else {
			  return $response;
			}
		}
	}

	public function productUpdData(Request $request){
		$data = $request->input('data');
		$id = $request->input('_id');
		if(!empty($data)){
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.jurnal.id/partner/core/api/v1/products/".$id."?access_token=".$this->access_token,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => json_encode($data),
			  CURLOPT_HTTPHEADER => array(
			    "access_token: ".$this->access_token,
			    "content-type: application/json"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  return "cURL Error #:" . $err;
			} else {
			  return $response;
			}
		}
	}


	public function productSearch(Request $request){
		$data = $request->input('data');
		$keysearch = $request->input('keysearch');
		$keyvalue = $request->input('keyvalue');
		$value = $request->input('value');
		if(!empty($data)){
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.jurnal.id/partner/core/api/v1/products?access_token=".$this->access_token,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_POSTFIELDS => "{}",
			  CURLOPT_HTTPHEADER => array(
			    "access_token: ".$this->access_token,
			    "content-type: application/json"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  return "cURL Error #:" . $err;
			} else {
			  $code = json_decode($response);
				foreach ($code as $value) {
				    if(!empty($value[$i]->$keysearch)){
				    	if($value[$i]->$keysearch == $keyvalue){
						    return $value[$i]->$value;
						}
				    }
				}
			}
		}
	}

	public function productAddDataMany(Request $request){
		$data = $request->input('data');
		if(!empty($data)){
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.jurnal.id/partner/core/api/v1/products/batch_create?access_token=".$this->access_token,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => json_encode($data),
			  CURLOPT_HTTPHEADER => array(
			    "access_token: ".$this->access_token,
			    "content-type: application/json"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  return "cURL Error #:" . $err;
			} else {
			  return $response;
			}
		}
	}

	public function categoriesAddData(Request $request){
		$data = $request->input('data');
		if(!empty($data)){
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.jurnal.id/partner/core/api/v1/product_categories?access_token=".$this->access_token,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => json_encode($data),
			  CURLOPT_HTTPHEADER => array(
			    "access_token: ".$this->access_token,
			    "content-type: application/json"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  return "cURL Error #:" . $err;
			} else {
			  return $response;
			}
		}
	}

	public function customerAddData(Request $request){
		$data = $request->input('data');
		if(!empty($data)){
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.jurnal.id/partner/core/api/v1/customers?access_token=".$this->access_token,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => json_encode($data),
			  CURLOPT_HTTPHEADER => array(
			    "access_token: ".$this->access_token,
			    "content-type: application/json"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  return "cURL Error #:" . $err;
			} else {
			  return $response;
			}
		}
	}

	public function salinvAddData(Request $request){
		$data = $request->input('data');
		if(!empty($data)){
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.jurnal.id/partner/core/api/v1/sales_invoices?access_token=".$this->access_token,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => json_encode($data),
			  CURLOPT_HTTPHEADER => array(
			    "access_token: ".$this->access_token,
			    "content-type: application/json"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  return "cURL Error #:" . $err;
			} else {
			  return $response;
			}
		}
	}
}