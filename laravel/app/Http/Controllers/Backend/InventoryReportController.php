<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;
use Session;
use Validator;
use Redirect;
use DateTime;
use File;
use Auth;
use Helper;
use Excel;
class InventoryReportController extends Controller
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

  public function inventoryin(Request $request)
  {
    $button=$request->get('button');
      if ($button == "search"){
          $date= new Datetime();
          $from= $request->get('fromdate');
          $end = $request->get('enddate');
          $code= $request->get('code');
          if(!empty($from) and !empty($end) and empty($code) ){
            $inventory = DB::table('ms_inventory_in')
                   ->where('inv_in_date','>=',$from)
                   ->where('inv_in_date','<=',$end)
                   ->get();
          }else if(!empty($code) and empty($from) and empty($end)){
            $inventory = DB::table('ms_inventory_in')
                   ->where('inv_in_code','=',$code)
                   ->get();
          }else{
            $inventory = DB::table('ms_inventory_in')
                   ->where('inv_in_date','>=',$from)
                   ->where('inv_in_date','<=',$end)
                   ->where('inv_in_code','=',$code)
                   ->get();
          }


          return view('backend.inventory.in.index',[
              'inventory'=>$inventory,
              'from'=>$from,
              'end'=>$end,
              'code'=>$code,

          ]);


      }elseif($button == "print"){
        $date= new Datetime();
        $from= $request->get('fromdate');
        $end = $request->get('enddate');
        $code= $request->get('code');


          Excel::create('Inventory In Reports '.$from.'', function($excel) {
            $excel->sheet('Excel sheet', function($sheet) {
              $sheet->cell('B2', function($cell) {
                    $site= DB::table('cms_config')->first();
                    $cell->setValue("".$site->company_name."");
                    $cell->setFontSize(40);
                      $cell->setAlignment('center');

                });


                $sheet->cell('B3', function($cell) {
                    $site= DB::table('cms_config')->first();
                    $cell->setValue("Address : ".$site->address." Telp : ".$site->telp." Email :".$site->email."");
                    $cell->setAlignment('center');

                    $cell->setFontSize(12);

                    $cell->setAlignment('center');
                     $cell->setValignment('center');

                });

                $sheet->cell('B4', function($cell) {
                    $cell->setValue("Inventory In Reports");
                    $cell->setFontSize(20);
                    $cell->setAlignment('center');

                });

                $sheet->cell('B6', function($cell) {
                    $from= input::get('fromdate');
                    $end = input::get('enddate');
                    $code= input::get('code');
                    if(!empty($from) and !empty($end) and empty($code) ){
                        $cell->setValue("Periode :".date("d F Y",strtotime($from))." - ".date("d F Y",strtotime($end))."");
                    }elseif (!empty($code) and empty($from) and empty($end)) {
                        $cell->setValue("Code :".$code."");
                    }else{
                            $cell->setValue("Periode :".date("d F Y",strtotime($from))." - ".date("d F Y",strtotime($end))." Code: ".$code."");
                    }

                    $cell->setFontSize(15);
                    $cell->setAlignment('center');

                });


                $sheet->row(8, array(
                         '','No.', 'inventory In Code', 'inventory In Date', 'Product ID','Product Name', 'Product Size','Product Color','Public Status','Product Qty'
                       ));
                 $from= input::get('fromdate');
                 $end = input::get('enddate');
                 $code= input::get('code');


                 if(!empty($from) and !empty($end) and empty($code) ){

                   $inventory = DB::select(DB::raw("
                   SELECT a.inv_in_id,inv_in_code, inv_in_date, in_prod_id, prod_name , in_detail_size, in_detail_color,in_detail_qty, in_detail_public
                   FROM ms_inventory_in a
                   JOIN tmp_inv_in_detail b ON a.inv_in_id= b.inv_in_id
                   JOIN ms_products c ON c.prod_id = b.in_prod_id
                   WHERE  inv_in_date >= '".$from."' AND inv_in_date <= '".$end."'
                   "));

                 }else if(!empty($code) and empty($from) and empty($end)){
                   $inventory = DB::select(DB::raw("
                   SELECT a.inv_in_id,inv_in_code, inv_in_date, in_prod_id, prod_name , in_detail_size, in_detail_color,in_detail_qty, in_detail_public
                   FROM ms_inventory_in a
                   JOIN tmp_inv_in_detail b ON a.inv_in_id= b.inv_in_id
                   JOIN ms_products c ON c.prod_id = b.in_prod_id
                   WHERE  inv_in_code = '".$code."'
                   "));
                 }else{
                   $inventory = DB::select(DB::raw("
                   SELECT a.inv_in_id,inv_in_code, inv_in_date, in_prod_id, prod_name , in_detail_size, in_detail_color,in_detail_qty, in_detail_public
                   FROM ms_inventory_in a
                   JOIN tmp_inv_in_detail b ON a.inv_in_id= b.inv_in_id
                   JOIN ms_products c ON c.prod_id = b.in_prod_id
                   WHERE  inv_in_date >= '".$from."' AND inv_in_date <= '".$end."' and  inv_in_code = '".$code."'

                   "));
                 }

                 $i=9;
                 $elven = 0;
                 $empty='';

                 foreach ($inventory as $in) {
                    if($in->in_detail_public ==1){
                      $status='Yes';
                    }else{
                      $status='No';
                    }
                    if(empty($in->in_detail_size)){
                      $size='-';
                    }else{
                      $size=$in->in_detail_size;
                    }
                    if(empty($in->in_detail_color)){
                      $color='-';
                    }else{
                      $color=$in->in_detail_color;
                    }

                    $sheet->cells('G'.$i, function($cells) {
                         $cells->setAlignment('center');
                    });
                    $sheet->cells('E'.$i, function($cells) {
                         $cells->setAlignment('left');
                    });
                    $sheet->cells('H'.$i, function($cells) {
                         $cells->setAlignment('center');
                    });
                    $sheet->cells('I'.$i, function($cells) {
                         $cells->setAlignment('center');
                    });
                    $sheet->cells('J'.$i, function($cells) {
                         $cells->setAlignment('center');
                    });




                    $elven++;
                     $sheet->row($i, array(
                          $empty,$elven,$in->inv_in_code,$in->inv_in_date,$in->in_prod_id,
                          $in->prod_name,$size,$color,$status,$in->in_detail_qty
                     ));
                  $i++;
                 }



                  $count = count($inventory)+9;
                  $sheet->cell('B'.$count, function($cell) {
                        $cell->setValue("Total Product Qty");
                  });

                  $sheet->cell('J'.$count, function($cell) {
                                   $from= input::get('fromdate');
                                   $end = input::get('enddate');
                                   $code= input::get('code');
                                   if(!empty($from) and !empty($end) and empty($code) ){

                                     $inventory = DB::select(DB::raw("
                                     SELECT in_detail_qty
                                     FROM ms_inventory_in a
                                     JOIN tmp_inv_in_detail b ON a.inv_in_id= b.inv_in_id
                                     JOIN ms_products c ON c.prod_id = b.in_prod_id
                                     WHERE  inv_in_date >= '".$from."' AND inv_in_date <= '".$end."'
                                     "));

                                   }else if(!empty($code) and empty($from) and empty($end)){
                                     $inventory = DB::select(DB::raw("
                                     SELECT in_detail_qty
                                     FROM ms_inventory_in a
                                     JOIN tmp_inv_in_detail b ON a.inv_in_id= b.inv_in_id
                                     JOIN ms_products c ON c.prod_id = b.in_prod_id
                                     WHERE  inv_in_code = '".$code."'
                                     "));
                                   }else{
                                     $inventory = DB::select(DB::raw("
                                     SELECT in_detail_qty
                                     FROM ms_inventory_in a
                                     JOIN tmp_inv_in_detail b ON a.inv_in_id= b.inv_in_id
                                     JOIN ms_products c ON c.prod_id = b.in_prod_id
                                     WHERE  inv_in_date >= '".$from."' AND inv_in_date <= '".$end."' and  inv_in_code = '".$code."'

                                     "));
                                   }
                                   foreach ($inventory as  $in) {
                                     $tot[]=$in->in_detail_qty;
                                   }
                                   if(count($inventory)>0){
                                     $total=array_sum($tot);
                                     // manipulate the cell
                                     $cell->setValue($total);
                                   }
                                   $cell->setAlignment('center');
                         });


                      // Sets all borders
                        $sheet->setBorder('B8:J'.$count, 'thin');
                        $sheet->mergeCells('B'.$count.':I'.$count);
                        $sheet->mergeCells('B2:J2');
                        $sheet->mergeCells('B4:J4');
                        $sheet->mergeCells('B6:J6');
                        $sheet->mergeCells('B3:J3');

                        $sheet->cells('B'.$count.':I'.$count, function($cells) {
                             $cells->setFont(array(

                                 'bold'       =>  True
                             ));
                             $cells->setAlignment('right');

                        });

                        $sheet->cells('B'.$count, function($cells) {
                             $cells->setFont(array(

                                 'bold'       =>  True
                             ));
                             $cells->setAlignment('right');

                        });



                        $sheet->cells('B2:I2', function($cells) {
                             $cells->setFont(array(
                                 'family'     => 'Calibri',
                                 'size'       => '40',
                                 'bold'       =>  true
                             ));
                             $cells->setAlignment('center');

                        });
                        $sheet->cells('B3:I3', function($cells) {
                             $cells->setFont(array(
                                 'family'     => 'Calibri',
                                 'size'       => '12',
                                 'bold'       =>  false
                             ));
                             $cells->setAlignment('center');

                        });
                        $sheet->cells('B4:I4', function($cells) {
                             $cells->setFont(array(
                                 'family'     => 'Calibri',
                                 'size'       => '15',
                                 'bold'       =>  true
                             ));
                             $cells->setAlignment('center');

                        });
                        $sheet->cells('B6:I6', function($cells) {
                             $cells->setFont(array(
                                 'family'     => 'Calibri',
                                 'size'       => '15',
                                 'bold'       =>  false
                             ));
                             $cells->setAlignment('center');

                        });


                        $sheet->cell('B8', function($cell) {
                            $cell->setFontSize(12);
                            // $cell->setAlignment('center');
                             $cell->setValignment('center');
                             $cell->setAlignment('center');
                        });
                        $sheet->cell('C8', function($cell) {
                            $cell->setFontSize(12);
                            // $cell->setAlignment('center');
                             $cell->setValignment('center');
                             $cell->setAlignment('center');
                        });
                        $sheet->cell('D8', function($cell) {
                            $cell->setFontSize(12);
                            // $cell->setAlignment('center');
                             $cell->setValignment('center');
                             $cell->setAlignment('center');
                        });
                        $sheet->cell('E8', function($cell) {
                            $cell->setFontSize(12);
                            // $cell->setAlignment('center');
                             $cell->setValignment('center');
                             $cell->setAlignment('center');
                        });
                        $sheet->cell('F8', function($cell) {
                            $cell->setFontSize(12);
                            // $cell->setAlignment('center');
                             $cell->setValignment('center');
                             $cell->setAlignment('center');
                        });
                        $sheet->cell('G8', function($cell) {
                            $cell->setFontSize(12);
                            // $cell->setAlignment('center');
                             $cell->setValignment('center');
                             $cell->setAlignment('center');
                        });
                        $sheet->cell('H8', function($cell) {
                            $cell->setFontSize(12);
                            // $cell->setAlignment('center');
                             $cell->setValignment('center');
                             $cell->setAlignment('center');
                        });

                        $sheet->cell('I8', function($cell) {
                            $cell->setFontSize(12);
                            // $cell->setAlignment('center');
                             $cell->setValignment('center');
                             $cell->setAlignment('center');
                        });
                        $sheet->cell('J8', function($cell) {
                            $cell->setFontSize(12);
                            // $cell->setAlignment('center');
                             $cell->setValignment('center');
                             $cell->setAlignment('center');
                        });

            });

          })->export('xls');

      }
  }

  public function inventoryout(Request $request)
  {
    $button=$request->get('button');
      if ($button == "search"){
          $date= new Datetime();
          $from= $request->get('fromdate');
          $end = $request->get('enddate');
          $code= $request->get('code');
          if(!empty($from) and !empty($end) and empty($code) ){
            $inventory = DB::table('ms_inventory_out')
                   ->where('inv_out_date','>=',$from)
                   ->where('inv_out_date','<=',$end)
                   ->get();
          }else if(!empty($code) and empty($from) and empty($end)){
            $inventory = DB::table('ms_inventory_out')
                   ->where('inv_out_code','=',$code)
                   ->get();
          }else{
            $inventory = DB::table('ms_inventory_out')
                   ->where('inv_out_date','>=',$from)
                   ->where('inv_out_date','<=',$end)
                   ->where('inv_out_code','=',$code)
                   ->get();
          }


          return view('backend.inventory.out.index',[
              'inventory'=>$inventory,
              'from'=>$from,
              'end'=>$end,
              'code'=>$code,

          ]);


      }elseif($button == "print"){
        $date= new Datetime();
        $from= $request->get('fromdate');
        $end = $request->get('enddate');
        $code= $request->get('code');


          Excel::create('inventory out Reports '.$from.'', function($excel) {
            $excel->sheet('Excel sheet', function($sheet) {
              $sheet->cell('B2', function($cell) {
                    $site= DB::table('cms_config')->first();
                    $cell->setValue("".$site->company_name."");
                    $cell->setFontSize(40);
                      $cell->setAlignment('center');

                });


                $sheet->cell('B3', function($cell) {
                    $site= DB::table('cms_config')->first();
                    $cell->setValue("Address : ".$site->address." Telp : ".$site->telp." Email :".$site->email."");
                    $cell->setAlignment('center');

                    $cell->setFontSize(12);

                    $cell->setAlignment('center');
                     $cell->setValignment('center');

                });

                $sheet->cell('B4', function($cell) {
                    $cell->setValue("Inventory Out Reports");
                    $cell->setFontSize(20);
                    $cell->setAlignment('center');

                });

                $sheet->cell('B6', function($cell) {
                    $from= input::get('fromdate');
                    $end = input::get('enddate');
                    $code= input::get('code');
                    if(!empty($from) and !empty($end) and empty($code) ){
                        $cell->setValue("Periode :".date("d F Y",strtotime($from))." - ".date("d F Y",strtotime($end))."");
                    }elseif (!empty($code) and empty($from) and empty($end)) {
                        $cell->setValue("Code :".$code."");
                    }else{
                            $cell->setValue("Periode :".date("d F Y",strtotime($from))." - ".date("d F Y",strtotime($end))." Code: ".$code."");
                    }

                    $cell->setFontSize(15);
                    $cell->setAlignment('center');

                });


                $sheet->row(8, array(
                         '','No.', 'inventory Out Code', 'inventory Out Date', 'Product ID','Product Name', 'Product Size','Product Color','Product Qty'
                       ));
                 $from= input::get('fromdate');
                 $end = input::get('enddate');
                 $code= input::get('code');


                 if(!empty($from) and !empty($end) and empty($code) ){

                   $inventory = DB::select(DB::raw("
                   SELECT a.inv_out_id,inv_out_code, inv_out_date,inv_out_notes, out_prod_id, prod_name , out_detail_size, out_detail_color,out_detail_qty, out_detail_public
                   FROM ms_inventory_out a
                   Join tmp_inv_out_detail b ON a.inv_out_id= b.inv_out_id
                   Join ms_products c ON c.prod_id = b.out_prod_id
                   WHERE  inv_out_date >= '".$from."' AND inv_out_date <= '".$end."'
                   "));

                 }else if(!empty($code) and empty($from) and empty($end)){
                   $inventory = DB::select(DB::raw("
                   SELECT a.inv_out_id,inv_out_code, inv_out_date ,inv_out_notes, out_prod_id, prod_name , out_detail_size, out_detail_color,out_detail_qty, out_detail_public
                   FROM ms_inventory_out a
                   Join tmp_inv_out_detail b ON a.inv_out_id= b.inv_out_id
                   Join ms_products c ON c.prod_id = b.out_prod_id
                   WHERE  inv_out_code = '".$code."'
                   "));
                 }else{
                   $inventory = DB::select(DB::raw("
                   SELECT a.inv_out_id,inv_out_code, inv_out_date,inv_out_notes, out_prod_id, prod_name , out_detail_size, out_detail_color,out_detail_qty, out_detail_public
                   FROM ms_inventory_out a
                   Join tmp_inv_out_detail b ON a.inv_out_id= b.inv_out_id
                   Join ms_products c ON c.prod_id = b.out_prod_id
                   WHERE  inv_out_date >= '".$from."' AND inv_out_date <= '".$end."' and  inv_out_code = '".$code."'

                   "));
                 }

                 $i=9;
                 $elven = 0;
                 $empty='';

                 foreach ($inventory as $out) {
                    if($out->out_detail_public ==1){
                      $status='Yes';
                    }else{
                      $status='No';
                    }
                    if(empty($out->out_detail_size)){
                      $size='-';
                    }else{
                      $size=$out->out_detail_size;
                    }
                    if(empty($out->out_detail_color)){
                      $color='-';
                    }else{
                      $color=$out->out_detail_color;
                    }

                    $sheet->cells('G'.$i, function($cells) {
                         $cells->setAlignment('center');
                    });
                    $sheet->cells('E'.$i, function($cells) {
                         $cells->setAlignment('left');
                    });
                    $sheet->cells('H'.$i, function($cells) {
                         $cells->setAlignment('center');
                    });
                    $sheet->cells('I'.$i, function($cells) {
                         $cells->setAlignment('center');
                    });




                    $elven++;
                     $sheet->row($i, array(
                          $empty,$elven,$out->inv_out_code, $out->inv_out_date,$out->out_prod_id,
                          $out->prod_name,$size,$color,$out->out_detail_qty
                     ));
                  $i++;
                 }

                  $count = count($inventory)+9;
                  $sheet->cell('B'.$count, function($cell) {
                        $cell->setValue("Total Product Qty");
                  });

                  $sheet->cell('I'.$count, function($cell) {
                                   $from= input::get('fromdate');
                                   $end = input::get('enddate');
                                   $code= input::get('code');
                                   if(!empty($from) and !empty($end) and empty($code) ){

                                     $inventory = DB::select(DB::raw("
                                     SELECT out_detail_qty
                                     FROM ms_inventory_out a
                                     Join tmp_inv_out_detail b ON a.inv_out_id= b.inv_out_id
                                     Join ms_products c ON c.prod_id = b.out_prod_id
                                     WHERE  inv_out_date >= '".$from."' AND inv_out_date <= '".$end."'
                                     "));

                                   }else if(!empty($code) and empty($from) and empty($end)){
                                     $inventory = DB::select(DB::raw("
                                     SELECT out_detail_qty
                                     FROM ms_inventory_out a
                                     Join tmp_inv_out_detail b ON a.inv_out_id= b.inv_out_id
                                     Join ms_products c ON c.prod_id = b.out_prod_id
                                     WHERE  inv_out_code = '".$code."'
                                     "));
                                   }else{
                                     $inventory = DB::select(DB::raw("
                                     SELECT out_detail_qty
                                     FROM ms_inventory_out a
                                     Join tmp_inv_out_detail b ON a.inv_out_id= b.inv_out_id
                                     Join ms_products c ON c.prod_id = b.out_prod_id
                                     WHERE  inv_out_date >= '".$from."' AND inv_out_date <= '".$end."' and  inv_out_code = '".$code."'

                                     "));
                                   }
                                   foreach ($inventory as  $out) {
                                     $tot[]=$out->out_detail_qty;
                                   }
                                   if(count($inventory)>0){
                                     $total=array_sum($tot);
                                     // manipulate the cell
                                     $cell->setValue($total);
                                   }
                                   $cell->setAlignment('center');
                         });


                         // Sets all borders
                           $sheet->setBorder('B8:I'.$count, 'thin');
                           $sheet->mergeCells('B'.$count.':H'.$count);
                           $sheet->mergeCells('B2:I2');
                           $sheet->mergeCells('B4:I4');
                           $sheet->mergeCells('B6:I6');
                           $sheet->mergeCells('B3:I3');

                           $sheet->cells('B'.$count.':H'.$count, function($cells) {
                                $cells->setFont(array(

                                    'bold'       =>  True
                                ));
                                $cells->setAlignment('right');

                           });

                           $sheet->cells('B'.$count, function($cells) {
                                $cells->setFont(array(

                                    'bold'       =>  True
                                ));
                                $cells->setAlignment('right');

                           });



                           $sheet->cells('B2:I2', function($cells) {
                                $cells->setFont(array(
                                    'family'     => 'Calibri',
                                    'size'       => '40',
                                    'bold'       =>  true
                                ));
                                $cells->setAlignment('center');

                           });
                           $sheet->cells('B3:I3', function($cells) {
                                $cells->setFont(array(
                                    'family'     => 'Calibri',
                                    'size'       => '12',
                                    'bold'       =>  false
                                ));
                                $cells->setAlignment('center');

                           });
                           $sheet->cells('B4:I4', function($cells) {
                                $cells->setFont(array(
                                    'family'     => 'Calibri',
                                    'size'       => '15',
                                    'bold'       =>  true
                                ));
                                $cells->setAlignment('center');

                           });
                           $sheet->cells('B6:I6', function($cells) {
                                $cells->setFont(array(
                                    'family'     => 'Calibri',
                                    'size'       => '15',
                                    'bold'       =>  false
                                ));
                                $cells->setAlignment('center');

                           });


                           $sheet->cell('B8', function($cell) {
                               $cell->setFontSize(12);
                               // $cell->setAlignment('center');
                                $cell->setValignment('center');
                                $cell->setAlignment('center');
                           });
                           $sheet->cell('C8', function($cell) {
                               $cell->setFontSize(12);
                               // $cell->setAlignment('center');
                                $cell->setValignment('center');
                                $cell->setAlignment('center');
                           });
                           $sheet->cell('D8', function($cell) {
                               $cell->setFontSize(12);
                               // $cell->setAlignment('center');
                                $cell->setValignment('center');
                                $cell->setAlignment('center');
                           });
                           $sheet->cell('E8', function($cell) {
                               $cell->setFontSize(12);
                               // $cell->setAlignment('center');
                                $cell->setValignment('center');
                                $cell->setAlignment('center');
                           });
                           $sheet->cell('F8', function($cell) {
                               $cell->setFontSize(12);
                               // $cell->setAlignment('center');
                                $cell->setValignment('center');
                                $cell->setAlignment('center');
                           });
                           $sheet->cell('G8', function($cell) {
                               $cell->setFontSize(12);
                               // $cell->setAlignment('center');
                                $cell->setValignment('center');
                                $cell->setAlignment('center');
                           });
                           $sheet->cell('H8', function($cell) {
                               $cell->setFontSize(12);
                               // $cell->setAlignment('center');
                                $cell->setValignment('center');
                                $cell->setAlignment('center');
                           });

                           $sheet->cell('I8', function($cell) {
                               $cell->setFontSize(12);
                               // $cell->setAlignment('center');
                                $cell->setValignment('center');
                                $cell->setAlignment('center');
                           });


            });

          })->export('xls');

      }
  }
}
