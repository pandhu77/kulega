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

class JurnalController extends  Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function intro(){
      return view('backend.jurnal.intro');
  }

  public function access(){
      $data = DB::table('t_module_options')->skip(11)->first();
      return view('backend.jurnal.access_token',[
          'data' => $data
      ]);
  }

  public function updatetoken(Request $request)
  {
    $rules = array(
        'jurnal' => 'required'
    );
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      return redirect()->back()
      ->withErrors($validator)
      ->withInput(Input::except('password'));
    } else {

        $store = DB::table('t_module_options')->where('id',12)->update([
            'value'         => $_POST['jurnal'],
            'default_value' => $_POST['jurnal']
        ]);

        return redirect()->back()->with('success','Success Update Token');

    }
  }

}
