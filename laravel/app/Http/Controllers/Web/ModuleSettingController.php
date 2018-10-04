<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use DB;
use Datetime;

use App\Http\Controllers\Controller;

class ModuleSettingController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getgallery(){
        $id_image   = Input::get('id_image');
        $getgallery = DB::table('cms_gallery')->where('id',$id_image)->first();
        $url        = url('');

        $array = [];
        $array[0] = $getgallery->title;
        $array[1] = '<img src="'.$url.'/'.$getgallery->image.'" class="img-responsive" style="margin:auto;">';

        return json_encode($array);
    }

}
