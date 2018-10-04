<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use DB;
use Datetime;

use App\Http\Controllers\Controller;

class AboutController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $getabout = DB::table('t_module_options')->where('module','aboutus')->get();

        return view('web.about',[
            'about' => $getabout
        ]);
    }

}
