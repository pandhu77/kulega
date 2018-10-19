<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;
use Validator;
use Redirect;
use DateTime;
use Helper;
use Auth;
class DonatecateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
        $auth = $this->CheckAuth();
        if($auth == false){
	        return redirect()->to('backend/login')->with('error','Please relogin!');
	    }
    }

    public function index(){
    	return redirect()->to('backend/donatecate/show');
    }

    public function show()
    {
        $row = \App\Donatecate::get();
        return view('backend.donatecate.index',compact('row'));
    }

    public function create()
    {
        return view('backend.donatecate.create');
    }

    public function store(Request $request)
    {
        # code...
        // validate the info, create rules for the inputs
        $rules = array(
        	'name' => 'required|unique:lk_donate_cate|max:255',
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator) // send back all errors to the login form
                ->withInput(); // send back the input (not the password) so that we can repopulate the form
        } else {
            if(!empty($request->get('enable'))) {
                $enable=1;
            }else{
                $enable=0;
            }

            $donatecate = new \App\Donatecate;
            $donatecate->name = $request->get('name');
            $donatecate->enable = $enable;
            $donatecate->show = $request->get('show');
            $donatecate->created_at = new DateTime();
            $insert = $donatecate->save();
            if($insert){
                return redirect()->to('backend/donatecate/show/')->with('success-create','Category has been saved');
            }else{
                return Redirect()->back()->with('error','Sorry something is error !');
            }
        }
    }

    public function edit($id)
    {
        $row = \App\Donatecate::find($id);
        if(!$row){
        	return Redirect()->back()->with('error','Sorry something is error !');
        }
        return view('backend.donatecate.edit',compact('row','id'));
    }

    public function update(Request $request){
    	$validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator);
        }         

		$donatecate = \App\Donatecate::find($request->input('id'));

		if(!$donatecate){
			return redirect()->to('backend/donatecate');
		}

		if(!empty($request->get('enable'))) {
            $enable=1;
        }else{
            $enable=0;
        }

        $donatecate->name = $request->get('name');
        $donatecate->enable = $enable;
        $donatecate->show = $request->get('show');
        $donatecate->updated_at = new DateTime();
        $update = $donatecate->save();
        if($update){
            return redirect()->to('backend/donatecate/show/')->with('success-create','Category has been updated');
        }else{
            return Redirect()->back()->with('error','Sorry something is error !');
        }
    }

    public function destroy(Request $request)
    {
    	$dbdelete = \App\Donatecate::find($request->input('id'));
		if($dbdelete)
		{
			$dbdelete->delete();
			return [
				'Result'	=>	"OK",
				'Message'	=>	"Success"
			];
		}
		else
		{
			return [
				'Result'	=>	"ERROR",
				'Message'	=>	'User with id '.$request->input('id').' not found.'
			];
		}
    }

    private function CheckAuth(){
      $url = request()->segment(1)."/".request()->segment(2);
      $menu=DB::table('menu_admin')->where('menu_admin.status_menu','=',1)->where('url', '=', $url)->first();
        if(count($menu) > 0){
          $cek=  Helper::checkmenuchecklist(Auth::user()->access_id, $menu->menu_id);
          if ($cek ==1){
            return true;
          }else{
            return false;
          }
        } else {
          return false;
        }
    }
}