<?php
  use Illuminate\Support\Str;
  class Helper{

    public static function callApi($data,$access_token,$url)
    {
        $curl = curl_init();
        //save invoice = "https://api.jurnal.id/partner/core/api/v1/sales_invoices?access_token=#######"
        //save customers = "https://api.jurnal.id/partner/core/api/v1/customers?access_token=#######"
        //save product_categories = "https://api.jurnal.id/partner/core/api/v1/product_categories?access_token=#######"
        //save many product = "https://api.jurnal.id/partner/core/api/v1/products/batch_create?access_token=#######"
        //update product = "https://api.jurnal.id/partner/core/api/v1/products/{id}?access_token=#######"
        //save one product = "https://api.jurnal.id/partner/core/api/v1/products?access_token=#######"
        $baseUrl = "https://api.jurnal.id/partner/core/api/v1/";
        $hasil = array();
        if(!empty($data)){
          curl_setopt_array($curl, array(
            CURLOPT_URL => $baseUrl.$url."?access_token=".$access_token,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
              "access_token: ".$access_token,
              "content-type: application/json"
            ),
          ));

          $response = curl_exec($curl);
          $err = curl_error($curl);

          curl_close($curl);

          if ($err) {
            $hasil['message'] = $err;
            $hasil['response'] = false;
            return $hasil;
          } else {
            $hasil['message'] = $response;
            $hasil['response'] = true;
            return $hasil;
          }
        }
    }

    public static function getApi($data,$access_token,$keysearch,$keyvalue,$value)
    {
        $curl = curl_init();
        $baseUrl = "https://api.jurnal.id/partner/core/api/v1/";
        $hasil = array();
        if(!empty($data)){
          curl_setopt_array($curl, array(
            CURLOPT_URL => $baseUrl."products?access_token=".$access_token,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{}",
            CURLOPT_HTTPHEADER => array(
              "access_token: ".$access_token,
              "content-type: application/json"
            ),
          ));

          $response = curl_exec($curl);
          $err = curl_error($curl);

          curl_close($curl);

          if ($err) {
            $hasil['data'] = '';
            $hasil['message'] = $err;
            $hasil['response'] = false;
            return $hasil;
          } else {
            $code = json_decode($response);
            foreach ($code as $value) {
                if(!empty($value[$i]->$keysearch)){
                  if($value[$i]->$keysearch == $keyvalue){
                    $hasil['data'] = $value[$i]->$value;
                  }
                }
            }

            $hasil['message'] = $response;
            $hasil['response'] = true;
            return $hasil;
          }
        }
    }

      static function checkmenuchecklist($accessid, $menuid)
      {
        $ace = DB::table('user_auth')->where('access_id','=',$accessid)->where('menu_id','=',$menuid)->first();
        if(count($ace) == 0){
          return '0';
        }  else {
          return '1';
        }
      }
      static function admin_stock_product_min($checkorder){
        if(count($checkorder) >0){

              $product= DB::table('tmp_order_detail')->where('order_id','=',$checkorder->order_id)->get();
              foreach ($product as $key => $value) {
                if($value->prod_color=='' and $value->prod_size==''){
                  //produ non varian
                  $listprod= DB::table('ms_products')
                      ->where('prod_id','=',$value->prod_id)
                      ->first();
                    if(count($listprod) >0){
                      $sum=$listprod->prod_stock - $value->detail_qty;
                      if($sum >= 0){
                        $newstock=$sum;
                      }else{
                        $newstock=0;
                      }
                      DB::table('ms_products')
                          ->where('prod_id','=',$value->prod_id)->update([
                            'prod_stock'=>$newstock,
                          ]);
                     }
                }else{
                  //varian
                  $listvarian= DB::table('ms_product_varian')
                      ->where('prod_id','=',$value->prod_id)
                      ->where('varian_color','=',$value->prod_color)
                      ->where('varian_size','=',$value->prod_size)
                      ->first();
                  if(count($listvarian) >0){
                    $sum=$listvarian->varian_stock - $value->detail_qty;
                    if($sum >= 0){
                      $newstock=$sum;
                    }else{
                      $newstock=0;
                    }
                    DB::table('ms_product_varian')
                         ->where('prod_id','=',$value->prod_id)
                         ->where('varian_color','=',$value->prod_color)
                         ->where('varian_size','=',$value->prod_size)
                         ->update([
                           'varian_stock'=>$listvarian->varian_stock - $value->detail_qty,
                         ]);
                  }
                }
              }
        }
      }
      static function admin_stock_product_plus($checkorder){
        if(count($checkorder) >0){
            $product= DB::table('tmp_order_detail')->where('order_id','=',$checkorder->order_id)->get();

            foreach ($product as $key => $value) {
              if($value->prod_color=='' and $value->prod_size==''){
                //produ non varian
                $listprod= DB::table('ms_products')
                    ->where('prod_id','=',$value->prod_id)
                    ->first();
                  if(count($listvarian) >0){
                    DB::table('ms_products')
                        ->where('prod_id','=',$value->prod_id)->update([
                          'prod_stock'=>$listprod->prod_stock + $value->detail_qty,
                        ]);
                   }
              }else{
                //varian
                $listvarian= DB::table('ms_product_varian')
                    ->where('prod_id','=',$value->prod_id)
                    ->where('varian_color','=',$value->prod_color)
                    ->where('varian_size','=',$value->prod_size)
                    ->first();
                if(count($listvarian) >0){
                  DB::table('ms_product_varian')
                       ->where('prod_id','=',$value->prod_id)
                       ->where('varian_color','=',$value->prod_color)
                       ->where('varian_size','=',$value->prod_size)
                       ->update([
                         'varian_stock'=>$listvarian->varian_stock + $value->detail_qty,
                       ]);
                }
              }
            }

        }
      }
      static function updateStock($content){
          foreach ($content as $row) {
                $checkprod=DB::table('ms_products')->where('prod_id','=',$row->id)->first();
                if($checkprod->prod_var_status==1){
                    $checkvarian=DB::table('ms_product_varian')
                              ->where('prod_id','=',$row->id)
                              ->where('varian_color','=',$row->options['color'])
                              ->where('varian_size','=',$row->options['size'])->first();
                    if(count($checkvarian)>0){
                        $checkstock = $checkvarian->varian_stock - $row->qty;
                        if($checkstock >= 0){
                          $updatevarian=DB::table('ms_product_varian')
                                    ->where('prod_id','=',$row->id)
                                    ->where('varian_color','=',$row->options['color'])
                                    ->where('varian_size','=',$row->options['size'])
                                    ->update([
                                      'varian_stock'=>$checkstock,
                                    ]);
                        }else{
                          $updatevarian=DB::table('ms_product_varian')
                                    ->where('prod_id','=',$row->id)
                                    ->where('varian_color','=',$row->options['color'])
                                    ->where('varian_size','=',$row->options['size'])
                                    ->update([
                                      'varian_stock'=>0,
                                    ]);
                        }
                    }
                }else{
                    $prod=DB::table('ms_products')->where('prod_var_status','!=',1)->where('prod_id','=',$row->id)->first();
                    if(count($prod)>0){
                        $checkstockprod= $prod->prod_stock - $row->qty;

                        if($checkstockprod >= 0){
                          $updateprod=DB::table('ms_products')
                                    ->where('prod_id','=',$prod->prod_id)
                                    ->update([
                                      'prod_stock'=>$checkstockprod,
                                    ]);
                        }else{
                          $updateprod=DB::table('ms_products')
                                    ->where('prod_id','=',$prod->prod_id)
                                    ->update([
                                      'prod_stock'=>0,
                                    ]);
                        }
                    }
                }
          }

      }
      static function checkStock($content){
            $resultstock=[];
            foreach ($content as $row) {
                  $checkprod=DB::table('ms_products')->where('prod_id','=',$row->id)->first();
                  if($checkprod->prod_var_status==1){
                      $checkvarian=DB::table('ms_product_varian')
                                ->where('prod_id','=',$row->id)
                                ->where('varian_color','=',$row->options['color'])
                                ->where('varian_size','=',$row->options['size'])->first();
                      if(count($checkvarian)>0){
                          $checkstock = $checkvarian->varian_stock - $row->qty;
                          if($checkstock < 0 ){
                            array_push($resultstock,[
                              "stock_prodid"  => $checkvarian->prod_id,
                              "stock_color"   => $checkvarian->varian_color,
                              "stock_size"    => $checkvarian->varian_size,
                              "stock_max"    => $checkvarian->varian_stock,
                              "stock_status"  => 'no']);
                          }

                      }
                  }else{

                      $prod=DB::table('ms_products')->where('prod_var_status','!=',1)->where('prod_id','=',$row->id)->first();

                      if(count($prod)>0){
                          $checkstockprod= $prod->prod_stock - $row->qty;
                          if($checkstockprod < 0 ){
                                  array_push($resultstock,[
                                  "stock_prodid"=>$prod->prod_id,
                                  "stock_color"=>'',
                                  "stock_size"=>'',
                                  "stock_max"    =>$prod->prod_stock,
                                  "stock_status"=>'no'
                                ]);
                          }
                      }

                  }
        }

        return $resultstock;
      }
      static function check_dicount_member_level($total_cart,$memberid,$subtotal,$disc_cart){
          $check_lev_member=DB::table('ms_members')->where('member_id','=',$memberid)->first();
        if(count($check_lev_member) >0){
               /** Check Discount birth day */
              $checkdob = $check_lev_member->member_dob;
              $now=date('Y-m-d');
              if($checkdob !==null and $checkdob !== '0000-00-00' ){

                $year=date('Y');
                $dob= date('m-d',strtotime($checkdob));
                $strgdob= $year.'-'.$dob;
                $todob = strtotime($strgdob);
                $dobday= date('Y-m-d',$todob);
                $dateplus=strtotime($dobday."+1 day");
                $returndate=date("Y-m-d",$dateplus);

              }else {
                $dobday=null;
                $returndate=null;
              }
          }else {
            $dobday=null;
            $returndate=null;
          }

          /** END Discount birth day */


          if(count($check_lev_member) >0){

              $check_level=DB::table('ms_disc_level')
                                ->where('disc_level_id','=',$check_lev_member->member_level)
                                ->first();
              $check_disc=DB::table('ms_disc_level')
                                ->where('min_value','<=',$total_cart)
                                ->where('maxs_value','>=',$total_cart)
                                ->orderby('maxs_value','=','desc')
                                ->get();

                if(count($check_level) >0){

                  if($check_level->level_name=='Gold'){
                      foreach ($check_disc as $key => $disc) {
                            if($disc->disc_value <=100){
                              /** Check value Discount birth day */
                              if( $dobday <= $now and $returndate >= $now  ){
                                 $dislevel=$disc->disc_value_uth/100;
                                 $resultlevel['disc_value'] = $disc->disc_value_uth;
                              }else {
                                  $dislevel=$disc->disc_value/100;
                                  $resultlevel['disc_value'] = $disc->disc_value;
                              }
                              /** END Discount birth day */

                                $totlevel=$total_cart * $dislevel;
                                $total=$total_cart -$totlevel;
                                $resultlevel['total_level'] = $total;
                                $resultlevel['levelname']  = $disc->level_name;
                                $resultlevel['disc_level'] = $totlevel;
                                $resultlevel['sub_total'] = $subtotal;
                                $resultlevel['disc_cart'] = $disc_cart;
                                return $resultlevel;
                            }

                      }
                  }elseif($check_level->level_name=='Silver'){
                    foreach ($check_disc as $key => $disc) {
                          if($disc->disc_value <=100 and $disc->level_name =='Silver' ){
                            /** Check value Discount birth day */
                            if( $dobday <= $now and $returndate >= $now  ){
                               $dislevel=$disc->disc_value_uth/100;
                               $resultlevel['disc_value'] = $disc->disc_value_uth;
                            }else {
                                $dislevel=$disc->disc_value/100;
                                $resultlevel['disc_value'] = $disc->disc_value;
                            }
                            /** END Discount birth day */
                              $dislevel=$disc->disc_value/100;
                              $totlevel=$total_cart * $dislevel;
                              $total=$total_cart -$totlevel;

                              $resultlevel['total_level'] = $total;
                              $resultlevel['levelname']  = $disc->level_name;
                              $resultlevel['disc_level'] = $totlevel;


                              $resultlevel['sub_total'] = $subtotal;
                              $resultlevel['disc_cart'] = $disc_cart;
                              return $resultlevel;

                          }
                    }
                  }

                  $resultlevel['total_level'] = $total_cart;
                  $resultlevel['levelname']='';
                  $resultlevel['disc_level'] = '0';
                  $resultlevel['disc_value']='0';
                  $resultlevel['sub_total'] = $subtotal;
                  $resultlevel['disc_cart'] = $disc_cart;

                  return $resultlevel;

                }else{
                  $resultlevel['total_level'] = $total_cart;
                  $resultlevel['levelname']='';
                  $resultlevel['disc_level'] = '0';
                  $resultlevel['disc_value']='0';
                  $resultlevel['sub_total'] = $subtotal;
                  $resultlevel['disc_cart'] = $disc_cart;
                  return $resultlevel;
                }
            }else{
                $resultlevel['total_level'] = $total_cart;
                $resultlevel['levelname']='';
                $resultlevel['disc_level'] = '0';
                $resultlevel['disc_value']='0';
                $resultlevel['sub_total'] = $subtotal;
                $resultlevel['disc_cart'] = $disc_cart;
                return $resultlevel;
            }
      }



      static function check_dicount_total_cart($subtotal){
        $now = date('Y-m-d');
        $checkdisc=DB::table('ms_discount')
        ->where('disc_enable','=',1)
        ->where('disc_type','=','cart')
        ->where('disc_start_date','<=',$now)
        ->where('disc_end_date','>=',$now)
        ->where('disc_min','<=',$subtotal)
        ->where('disc_max','>=',$subtotal)
        ->orderby('disc_created_at','=','desc')
        ->get();

        $totno=0;
        $totper=0;
        foreach($checkdisc as $disc){
          // echo $disc->disc_min;
               if($disc->disc_stacked =='itselfother'){
                       if($disc->disc_reward=='percent'){
                          $totper=$totper + $disc->disc_reward_value;
                       }else{
                          $totno= $totno + $disc->disc_reward_value;
                       }

               }else{
                   if($disc->disc_reward=='percent'){
                     $checkdisc= $disc->disc_reward_value / 100;
                     $totdisc= $subtotal * $checkdisc;
                     $total= $subtotal- $totdisc;
                     $valuedisc=$disc->disc_reward_value;
                     $resultcart['disc_cart']= $totdisc;
                     $resultcart['disc_percent']= $disc->disc_reward_value;
                   }else if($disc->disc_reward=='nominal'){
                     $total= $subtotal - $disc->disc_reward_value;
                     $valuedisc=$disc->disc_reward_value;
                     $resultcart['disc_cart']= $valuedisc;
                   }
                     $resultcart['total_cart']  = $total;
                     $resultcart['sub_total']  = $subtotal;
                     $resultcart['disc_reward']  = $disc->disc_reward;
                     return $resultcart;
               }

        }

        $discother=DB::table('ms_discount')
        ->where('disc_enable','=',1)
        ->where('disc_type','=','cart')
        ->where('disc_start_date','<=',$now)
        ->where('disc_end_date','>=',$now)
        ->where('disc_min','<=',$subtotal)
        ->where('disc_max','>=',$subtotal)
        ->where('disc_stacked','=','itselfother')
        ->orderby('disc_created_at','=','desc')
        ->get();

       if(count($discother) > 0  ){
           if($totper > 0){
             $checkdiscother= $totper / 100;
             $totdiscother= $subtotal * $checkdiscother;
             $totalother= $subtotal - $totdiscother;
             $resultcart['disc_cart']= $totdiscother;
             $resultcart['disc_percent']= $totper;
             $resultcart['disc_reward']  = 'percent';

           }elseif($totno >0){
             $totalother= $subtotal - $totno;
             $resultcart['disc_cart']= $totno;
             $resultcart['disc_reward']  = 'nominal';
           }
           $resultcart['sub_total']  = $subtotal;
           $resultcart['total_cart']  = $totalother;
           return $resultcart;

       }else{
           $resultcart['disc_cart']= 0;
           $resultcart['disc_percent']= 0;
           $resultcart['sub_total']  = $subtotal;
           $resultcart['total_cart']  = $subtotal;
           $resultcart['disc_reward']  = '';
           return $resultcart;
       }
    }
    static function check_dicount_catalog($prodid,$kategid,$brandid,$price){

      $now = date('Y-m-d');
      $checkdisc=DB::table('ms_discount')
      ->where('disc_enable','=',1)
      ->where('disc_type','=','catalog')
      ->where('disc_start_date','<=',$now)
      ->where('disc_end_date','>=',$now)
      ->orderby('disc_created_at','=','desc')
      ->get();
        foreach ($checkdisc as $proddisc ) {
          //check kategory
          if(in_array($kategid,explode(',',$proddisc->disc_kateg_id))){

            $diskateg2=DB::table('ms_discount')
            ->where('disc_enable','=',1)
            ->where('disc_type','=','catalog')
            ->where('disc_start_date','<=',$now)
            ->where('disc_end_date','>=',$now)
            ->where('disc_stacked','=','itselfother')
            ->orderby('disc_created_at','=','desc')
            ->get();

            if($proddisc->disc_stacked =='itselfother'){
                    $totno=0;
                    $totper=0;
                    foreach ($diskateg2 as $key => $diskateg) {
                        if(in_array($kategid,explode(',',$diskateg->disc_kateg_id))){
                                if($diskateg->disc_reward=='percent'){

                                   $totper=$totper + $diskateg->disc_reward_value;
                                }else{
                                   $totno=$totno + $diskateg->disc_reward_value;
                                }
                         }
                    }

                    if($proddisc->disc_reward=='percent'){
                      $disc= $totper / 100;
                      $totdisc= $price * $disc;
                      $total3= $price- $totdisc;
                      $valuedisc=$proddisc->disc_reward_value;
                      $result['disc']  = $totper;

                    }else if($proddisc->disc_reward=='nominal'){
                      $total3= $price - $totno;
                      $valuedisc=$proddisc->disc_reward_value;
                      $result['disc']  = $totno;
                    }
                    $result['total']  = $total3;
                    $result['prodid']  = $prodid;
                    $result['disc_reward']  = $proddisc->disc_reward;


                    return $result;

            }else{
                  if($proddisc->disc_reward=='percent'){

                    $disc= $proddisc->disc_reward_value / 100;
                    $totdisc= $price * $disc;
                    $total3= $price- $totdisc;
                    $valuedisc=$proddisc->disc_reward_value;

                  }else if($proddisc->disc_reward=='nominal'){
                    $total3= $price - $proddisc->disc_reward_value;
                    $valuedisc=$proddisc->disc_reward_value;
                  }

                  $result['total']  = $total3;
                  $result['disc']  = $proddisc->disc_reward_value;
                  $result['prodid']  = $prodid;
                  $result['disc_reward']  = $proddisc->disc_reward;

                  return $result;
            }

        //check brand
      }else if(in_array($brandid,explode(',',$proddisc->disc_brand_id))){

            $disbrand2=DB::table('ms_discount')
            ->where('disc_enable','=',1)
            ->where('disc_type','=','catalog')
            ->where('disc_start_date','<=',$now)
            ->where('disc_end_date','>=',$now)
            ->where('disc_stacked','=','itselfother')
            // ->where('disc_id','!=', $proddisc->disc_id)
            ->orderby('disc_created_at','=','desc')
            ->get();

            if($proddisc->disc_stacked =='itselfother'){
                    $totno=0;
                    $totper=0;
                    foreach ($disbrand2 as $key => $disbrand) {

                        if(in_array($brandid,explode(',',$disbrand->disc_brand_id))){

                                if($disbrand->disc_reward=='percent'){

                                   $totper=$totper + $disbrand->disc_reward_value;
                                }else{
                                   $totno=$totno + $disbrand->disc_reward_value;
                                }
                         }
                    }

                    if($proddisc->disc_reward=='percent'){
                      $disc= $totper / 100;
                      $totdisc= $price * $disc;
                      $total3= $price- $totdisc;
                      $valuedisc=$proddisc->disc_reward_value;
                      $result['disc']  = $totper;

                    }else if($proddisc->disc_reward=='nominal'){
                      $total3= $price - $totno;
                      $valuedisc=$proddisc->disc_reward_value;
                      $result['disc']  = $totno;
                    }


                    $result['total']  = $total3;

                    $result['prodid']  = $prodid;
                    $result['disc_reward']  = $proddisc->disc_reward;
                    return $result;


            }else{
                  if($proddisc->disc_reward=='percent'){

                    $disc= $proddisc->disc_reward_value / 100;
                    $totdisc= $price * $disc;
                    $total3= $price- $totdisc;
                    $valuedisc=$proddisc->disc_reward_value;

                  }else if($proddisc->disc_reward=='nominal'){
                    $total3= $price - $proddisc->disc_reward_value;
                    $valuedisc=$proddisc->disc_reward_value;
                  }

                  $result['total']  = $total3;
                  $result['disc']  = $proddisc->disc_reward_value;
                  $result['prodid']  = $prodid;
                  $result['disc_reward']  = $proddisc->disc_reward;
                  return $result;
            }
          //check product
          }else if(in_array($prodid,explode(',',$proddisc->disc_prod_id))){

                $checkdisc2=DB::table('ms_discount')
                ->where('disc_enable','=',1)
                ->where('disc_type','=','catalog')
                ->where('disc_start_date','<=',$now)
                ->where('disc_end_date','>=',$now)
                ->where('disc_stacked','=','itselfother')
                // ->where('disc_id','!=', $proddisc->disc_id)
                ->orderby('disc_created_at','=','desc')
                ->get();

                if($proddisc->disc_stacked =='itselfother'){

                        $totno=0;
                        $totper=0;
                        foreach ($checkdisc2 as $key => $checkdisc2s) {
                            if(in_array($prodid,explode(',',$checkdisc2s->disc_prod_id))){
                                    if($checkdisc2s->disc_reward=='percent'){

                                       $totper=$totper + $checkdisc2s->disc_reward_value;
                                    }else{
                                       $totno=$totno + $checkdisc2s->disc_reward_value;
                                    }
                             }
                        }

                        if($proddisc->disc_reward=='percent'){
                          $disc= $totper / 100;
                          $totdisc= $price * $disc;
                          $total3= $price- $totdisc;
                          $valuedisc=$proddisc->disc_reward_value;
                          $result['disc']  = $totper;

                        }else if($proddisc->disc_reward=='nominal'){
                          $total3= $price - $totno;
                          $valuedisc=$proddisc->disc_reward_value;
                          $result['disc']  = $totno;
                        }

                        $result['total']  = $total3;

                        $result['prodid']  = $prodid;
                        $result['disc_reward']  = $proddisc->disc_reward;
                        return $result;

                }else{
                      if($proddisc->disc_reward=='percent'){

                        $disc= $proddisc->disc_reward_value / 100;
                        $totdisc= $price * $disc;
                        $total3= $price- $totdisc;
                        $valuedisc=$proddisc->disc_reward_value;

                      }else if($proddisc->disc_reward=='nominal'){
                        $total3= $price - $proddisc->disc_reward_value;
                        $valuedisc=$proddisc->disc_reward_value;
                      }

                      $result['total']  = $total3;
                      $result['disc']  = $proddisc->disc_reward_value;
                      $result['prodid']  = $prodid;
                      $result['disc_reward']  = $proddisc->disc_reward;
                      return $result;
                }
           }


        }


    }
  }

  function logo(){
      $site=DB::table('cms_config')->first();
      $html='<img src="'.url($site->logo).'" class="logo">';
      return $html;

  }
  function web_name(){
      $site=DB::table('cms_config')->first();
      $html=''.$site->site_name.'';
      return $html;
  }
  function web_meta(){
      $site = DB::table('cms_config')->first();
      $html=''.$site->meta.'';
      return $html;
  }
  function urldomain(){
      $html=''.url('').'';
      return $html;
  }

  function menucategory(){
    $kateg=DB::table('lk_product_category')
              ->where('kateg_parent','=','0')
              ->where('kateg_enable','=',1)->get();
    $kategparent=DB::table('lk_product_category')
              ->where('kateg_enable','=',1)->get();

    $kategparent2=DB::table('lk_product_category')
              ->where('kateg_enable','=',1)->get();

    $html ='';
      foreach ($kateg as  $kategs) {
        $html.='';
        $html.='<li class="dropdown mega-dropdown">';
        $html.='<a href="'.url("product/".$kategs->kateg_url).'" class="dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false">'.$kategs->kateg_name.'</a>';
        foreach ($kategparent as $parent) {
          if($kategs->kateg_id==$parent->kateg_parent){
        $html.='<ul class="dropdown-menu mega-dropdown-menu col-md-offset-8" style="background-color: rgb(235, 235, 235);border-radius:0px;border-width:0px">';
        $html.='<li>';

        $html.='<ul class="nav navbar-nav" style="padding-left: 30%; width: 100%; background-color: rgb(235, 235, 235);border-radius:0px;border-width:0px">';

          foreach ($kategparent as $parent) {
            if($kategs->kateg_id==$parent->kateg_parent){
              $html.='<li class="menu-bawah" ><a class="categ-parent" style="color: #777!important;" href="'.url("product/".$parent->kateg_url).'">'.$parent->kateg_name.'</a></li>';
            }

          }
        $html.='</ul>';
        $html.='</li>';
        $html.='</ul>';
        break;
          }
        }
        $html.='</li>';

      }
      return $html;
  }

  function menucategorymobile(){
    $kateg=DB::table('lk_product_category')
              ->where('kateg_parent','=','0')
              ->where('kateg_enable','=',1)->get();
    $kategparent=DB::table('lk_product_category')
              ->where('kateg_enable','=',1)->get();
    $kategparent2=DB::table('lk_product_category')
              ->where('kateg_enable','=',1)->get();

    $html ='';
      foreach ($kateg as  $kategs) {
        $html.='';
        $html.='  <li class="menu-toggle" >';
        $html.='    <div class="menu-toggle-btns" style="">';
        $html.='        <a href="'.url("product/".$kategs->kateg_url).'" class="menu-link">'.$kategs->kateg_name.'</a>';
        foreach ($kategparent as $parent) {
          if($kategs->kateg_id==$parent->kateg_parent){
        $html.='        <a href="#" class="menu-btn"><div class="pluslevel"><i class="fa fa-sort-desc" aria-hidden="true"></i></div></a>';
        break;
          }

        }
        $html.='    </div>';

        $html.='    <ul class="menu-level2 submenu no-style">';
        foreach ($kategparent as $parent) {
          if($kategs->kateg_id==$parent->kateg_parent){
                $html.='        <li class="menu-toggle">';
                $html.='            <div class="menu-toggle-btns">';
                $html.='                <a href="'.url("product/".$parent->kateg_url).'" class="menu-link">'.$parent->kateg_name.'</a>';
                foreach ($kategparent2 as $parent2) {
                  if($parent->kateg_id==$parent2->kateg_parent){
                    $html.='              <a href="#" class="menu-btn"><div  class="pluslevel"><i class="fa fa-sort-desc" aria-hidden="true"></i></div></a>';
                    break;
                  }
                }
                $html.='            </div>';
                $html.='            <ul class="menu-level3 submenu no-style">';
                foreach ($kategparent2 as $parent2) {
                  if($parent->kateg_id==$parent2->kateg_parent){
                    $html.='                <li><a href="'.url("product/".$parent2->kateg_url).'" class="menu-link">'.$parent2->kateg_name.'</a></li>';
                  }
                }
                $html.='            </ul>';
                $html.='        </li>';
            }

          }
        $html.='    </ul>';

        $html.='  </li>';


      }
      return $html;
  }
  function storesentra(){

    $store=DB::table('cms_menu')->where('status_menu','=',1)->get();
    $urlapp= url('');
    $html ='';
    foreach($store as $stores){
        if($stores->group=='store'){
            $html.'';
            $html.='<li><a href="'.$urlapp.'/'.$stores->url.'">'.$stores->menu.'</a></li>';
        }
    }
    return $html;
  }

  function infosentra(){

    $store=DB::table('cms_menu')->where('status_menu','=',1)->get();
    $urlapp= url('');
    $html ='';
    foreach($store as $stores){
        if($stores->group=='info'){
            $html.'';
            $html.='<li><a href="'.$urlapp.'/'.$stores->url.'">'.$stores->menu.'</a></li>';
        }
    }
    return $html;
  }
  function address(){

    $site=DB::table('cms_config')
            ->first();

    $html ='';
    $html.'';
    $html.='  <li class="address">';
    $html.='      <div class="col-xs-2 col-logo"><i class="fa fa-home" aria-hidden="true"></i></div>';
    $html.='      <div class="col-xs-10 col-desc">'.$site->address.'</div>';
    $html.='  </li>';
    $html.='  <li class="csemail">';
    $html.='      <div class="col-xs-2 col-logo"><i class="fa fa-phone" aria-hidden="true"></i></div>';
    $html.='      <div class="col-xs-10 col-desc">'.$site->telp.'</div>';
    $html.='  </li>';
    $html.='  <li class="csemail">';
    $html.='      <div class="col-xs-2 col-logo"><i class="fa fa-envelope-o" aria-hidden="true"></i></div>';
    $html.='      <div class="col-xs-10 col-desc">'.$site->email.'</div>';
    $html.='  </li>';

    return $html;

  }
  function socialmedia(){
      $socal=DB::table('cms_socialmedia')->where('enable','=',1)->get();
      $url=url('');
     $html='';
      foreach ($socal as  $socials) {
          $html.='<a href="'.$socials->url.'"><img src="'.$url.'/'.$socials->icon.'" width="30" alt=""></a>';
      }

      return $html;
  }
  function customer_care(){
    $url=url('');
    $care=DB::table('cms_customer_care')
            ->first();
    if(count($care)> 0 ){
        $html ='';
        $html.'';
        $html.='<label class="footer-title">CUSTOMER CARE</label>';
        $html.=' <ul class="footer-item-list-2">';
        $html.=' <li>'.$care->care_note.'</li>';
        $html.=' <li class="csphone">';
        $html.='<i class="fa fa-phone" aria-hidden="true"></i>&nbsp;&nbsp;';
        $html.=' '.$care->care_phone.'';
        $html.='</li>';
        $html.='<li class="csmail">';
        $html.=' <i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp;&nbsp;';
        $html.='   '.$care->care_email.'';
        $html.=' </li>';
        $html.='  </ul>';
        $html.=' <br>';
        $html.=' <a class="load-red btn btn-danger" style="border-radius: 0px;margin-bottom:20px;" href="'.$url.'/page/customer-care">I NEED HELP ?</a>';
        $html.=' <br>';
        return $html;
    }

  }

  function access_menu_backend(){
    $access_id=auth::user()->access_id;

    $mainmain=DB::table('menu_admin')->where('menu_admin.group','=',0)->where('menu_admin.status_menu','=',1)->get();

    $html = '';
    if(count($mainmain)>0){
      foreach ($mainmain as $key => $all) {

          $userauth=DB::table('user_auth')->where('access_id','=',$access_id)->where('menu_id','=',$all->menu_id)->first();
          if($userauth !==null){
            $sub=DB::table('menu_admin')->where('menu_admin.group','=',$all->menu_id)->where('menu_admin.status_menu','=',1)->get();
            if(count($sub) ==0){
              $html.='
                   <li><a href="'.url($all->url).'"><i class="fa fa-home"></i>'.$all->menu.'</a>
                   </li>
               ';
            }else {
              $html.='
                     <li><a><i class="'.$all->icon.'"></i> '.$all->menu.' <span class="fa fa-chevron-down"></span></a>
                     <ul class="nav child_menu">';
              foreach ($sub as $key => $value) {
                    $html.='<li><a href="'.url($value->url).'">'.$value->menu.'</a></li>';

              }
              $html.='</ul> </li>';
          }

          }
      }
    }

  return $html;
  }
