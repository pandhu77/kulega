<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Input;
use Validator;
use File;
use Redirect;
use DateTime;
use Auth;
use Helper;

class ThemeController extends Controller{

    public function setting(){
        $setting = DB::table('t_theme_setting')->get();
        return view('backend.themes.setting',[
            'setting' => $setting
        ]);
    }

    public function active($id){
        $check          = DB::table('t_theme_setting')->where('active',1)->first();
        $activetheme    = DB::table('t_theme_setting')->where('id',$id)->first();

        if ($check == $activetheme) {
            DB::table('t_theme_setting')->where('id',$id)->update([
                'active' => 0
            ]);
        } else {
            DB::table('t_theme_setting')->update([
                'active' => 0
            ]);

            DB::table('t_theme_setting')->where('id',$id)->update([
                'active' => 1
            ]);
        }

        return redirect('backend/themes-setting')->with('success-create','Activated theme success');
    }

    public function uninstall($id){
        DB::table('t_theme_setting')->where('id',$id)->delete();
        return redirect('backend/themes-setting')->with('success-delete','Success delete theme');
    }

}
