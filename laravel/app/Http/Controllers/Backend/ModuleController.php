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

class ModuleController extends Controller{

    public function index(){
        $module = DB::table('t_module')->get();
        return view('backend.themes-modules.index',[
            'module' => $module
        ]);
    }

    public function create(){
        return view('backend.themes-modules.create');
    }

    public function store(){
        $rules = array(
            'name'          => 'required',
            'sub_name.*'    => 'required',
            'det_html.*'    => 'required',
            'det_return.*'  => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $getid = DB::table('t_module')->insertGetId([
                'made_by'   => 'costume',
                'name'      => Input::get('name'),
                // 'm_function'=> Input::get('m_function'),
                'created_at'=> new DateTime()
            ]);

            foreach (Input::get('sub_name') as $key => $value) {
                DB::table('t_module_detail')->insert([
                    'module_id'     => $getid,
                    'name'          => $value,
                    'det_function'  => Input::get('det_function')[$key],
                    'det_html'      => Input::get('det_html')[$key],
                    'det_return'    => Input::get('det_return')[$key],
                    'created_at'    => new DateTime()
                ]);
            }

            return redirect('backend/themes-module')->with('success-create','Success create module');
        }
    }

    public function edit($id){
        $module     = DB::table('t_module')->where('id',$id)->first();
        $submodule  = DB::table('t_module_detail')->where('module_id',$id)->get();
        return view('backend.themes-modules.edit',[
            'module'    => $module,
            'submodule' => $submodule
        ]);
    }

    public function update($id){
        $rules = array(
            'name'          => 'required',
            'sub_name.*'    => 'required',
            'det_html.*'    => 'required',
            'det_return.*'  => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        } else {
            DB::table('t_module')->where('id',$id)->update([
                'name'      => Input::get('name'),
                // 'm_function'=> Input::get('m_function'),
                'updated_at'=> new DateTime()
            ]);

            DB::table('t_module_detail')->where('module_id',$id)->delete();
            foreach (Input::get('sub_name') as $key => $value) {
                DB::table('t_module_detail')->insert([
                    'module_id'     => $id,
                    'name'          => $value,
                    'det_function'  => Input::get('det_function')[$key],
                    'det_html'      => Input::get('det_html')[$key],
                    'det_return'    => Input::get('det_return')[$key],
                    'created_at'    => new DateTime()
                ]);
            }

            return redirect('backend/themes-module')->with('success-create','Success update module');
        }
    }

    public function destroy($id){
        DB::table('t_module')->where('id',$id)->delete();
        DB::table('t_module_detail')->where('module_id',$id)->delete();
        return redirect()->back()->with('success-delete','Your Module has been deleted!');
    }

}
