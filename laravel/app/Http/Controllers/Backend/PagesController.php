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

class PagesController extends Controller{

    public function index(){
        $pages = DB::table('t_pages')->get();
        return view('backend.themes-pages.index',[
            'pages' => $pages
        ]);
    }

    public function create(){
        $module     = DB::table('t_module')->get();
        return view('backend.themes-pages.create',[
            'module'    => $module
        ]);
    }

    public function addmodule($rowid){
        $module = DB::table('t_module')->get();
        echo '  <div class="mod-row'.$rowid.'">
                    <div class="form-group">
                        <i class="fa fa-arrows"></i>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Module Name</label>
                        <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                            <select class="form-control" name="module[]" onchange="submod('.$rowid.')" id="module'.$rowid.'" required>
                                <option value="" selected="" disabled="">Select</option>';
                                foreach($module as $mod){
        echo '                      <option value="'.$mod->id.'">'.$mod->name.'</option>';
                                }
        echo '              </select>
                        </div>
                        <div class="col-sm-1" style="padding-left:0px;padding-right:0px;">
                            <button type="button" class="btn btn-danger" onclick="delrowmod('.$rowid.')">Remove</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Sub Module</label>
                        <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                            <select class="form-control" name="submodule[]" id="submodule'.$rowid.'" required>
                                <option value="" selected="" disabled="">Select</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <hr>
                </div>';
    }

    public function getsubmod(){
        $module_id = Input::get('module_id');
        $submodule = DB::table('t_module_detail')->where('module_id',$module_id)->get();

        echo '<option value="" selected="" disabled="">Select</option>';
        foreach ($submodule as $sub) {
            echo '<option value="'.$sub->id.'">'.$sub->name.'</option>';
        }
    }

    public function store(){
        $rules = array(
            'name'          => 'required',
            'module.*'      => 'required',
            'submodule.*'   => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {

            $array = [];

            foreach (Input::get('module') as $key => $value) {
                $tampung = [];
                array_push($tampung,$value);
                array_push($tampung,Input::get('submodule')[$key]);
                array_push($array,$tampung);
            }

            DB::table('t_pages')->insert([
                'name'      => Input::get('name'),
                'module'    => json_encode($array),
                'created_at'=> new DateTime()
            ]);

            return redirect('backend/themes-pages')->with('success-create','Success create pages');
        }
    }

    public function edit($id){
        $pages      = DB::table('t_pages')->where('id',$id)->first();
        $module     = DB::table('t_module')->get();
        $pagesmod   = json_decode($pages->module);

        return view('backend.themes-pages.edit',[
            'pages'     => $pages,
            'module'    => $module,
            'pagesmod'  => $pagesmod
        ]);
    }

    public function update($id){
        $rules = array(
            'name'          => 'required',
            'module.*'      => 'required',
            'submodule.*'   => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        } else {
            $array = [];

            foreach (Input::get('module') as $key => $value) {
                $tampung = [];
                array_push($tampung,$value);
                array_push($tampung,Input::get('submodule')[$key]);
                array_push($array,$tampung);
            }

            DB::table('t_pages')->where('id',$id)->update([
                'name'      => Input::get('name'),
                'module'    => json_encode($array),
                'updated_at'=> new DateTime()
            ]);

            return redirect('backend/page')->with('success-create-fix','Success edit pages');
        }
    }

    public function destroy($id){
        $i = DB::table('t_pages')->where('id',$id)->delete();
        return redirect()->back()->with('success-delete','Your Pages has been deleted!');
    }

}
