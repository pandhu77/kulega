<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use DB;
use Datetime;

use App\Http\Controllers\Controller;

class GalleryController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $getimage   = DB::table('cms_gallery')->where('enable',1)->get();

        return view('web.gallery',[
            'getimage' => $getimage
        ]);
    }

}
