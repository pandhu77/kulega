<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Form;
use Auth;
use Session;
use Validator;
use Redirect;
use DB;
use Hash;
use Response;
use DateTime;
use Helper;

class ModuleOptionController extends  Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index($module){
      $getmodule = DB::table('t_module_options')->where('module',$module)->get();

      return view('backend.modules-options.edit',[
        'module_all'    => $getmodule,
        'module_name'   => $module
      ]);
  }

  public function update($module){
    //   dd($_POST);
      foreach($_POST as $key => $row){
          $data['value'] = $_POST[$key];
          $cekvalidation = DB::table('t_module_options')
                            ->where("code", "=", $key)
                            ->where("module", "=", $module)
                            ->first();

          if (empty($cekvalidation->validation_value)) {
              DB::table('t_module_options')
                    ->where("code", "=", $key)
                    ->where("module", "=", $module)
                    ->update($data);
          } else {
              $dovalid = DB::table('t_module_options')
                            ->where("code", "=", $key)
                            ->where("module", "=", $module)
                            ->where("validation_value","LIKE","!%".$_POST[$key]."%!")
                            ->first();

                if (count($dovalid) == 1) {
                    DB::table('t_module_options')
                          ->where("code", "=", $key)
                          ->where("module", "=", $module)
                          ->update($data);
                }
          }

      }

      return redirect('backend/module-opt/' . $module);
  }

}
