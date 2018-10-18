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
class GcampaignController extends Controller
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
    	return redirect()->to('backend/campaign')->with('error','Please select campaign!');
    }

    public function listgallery($campaignid){
    	$check=DB::table('lk_campaign')->where('id', $campaignid)->get();
    	if(count($check) > 0){
    		$tcam=DB::table('lk_campaign')->where('id', $campaignid)->first();
    		$row = \App\Gallerycampaign::where('campaignid', $campaignid)->get();
	    	return view('backend.gcampaign.index',['row'=>$row, 'campaignid'=>$campaignid, 'tcam'=>$tcam]);
	    } else {
	    	return redirect()->to('backend/campaign')->with('error','Please select campaign!');
	    }
    }

    public function create($campaignid)
    {
    	$check=DB::table('lk_campaign')->where('id', $campaignid)->get();
    	if(count($check) > 0){
    		$tcam=DB::table('lk_campaign')->where('id', $campaignid)->first();
        	return view('backend.gcampaign.create',compact('campaignid','tcam'));
        } else {
	    	return redirect()->to('backend/campaign')->with('error','Please select campaign!');
	    }
    }

    public function store(Request $request)
    {
        # code...
        // validate the info, create rules for the inputs
        $rules = array(
        	'name' => 'required|unique:lk_gallery_campaign|max:255',
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

            $nilai=strlen(url(''));
            $len=$nilai+1;
            $gcampaign = new \App\Gallerycampaign;
            $gcampaign->name = $request->get('name');
            $gcampaign->image = substr($request->get('image'),$len);
            $gcampaign->campaignid = $request->get('campaignid');
            $gcampaign->enable = $enable;
            $gcampaign->show = $request->get('show');
            $gcampaign->created_at = new DateTime();
            $insert = $gcampaign->save();
            if($insert){
                return redirect()->to('backend/gallerycampaign/show/'.$request->get('campaignid'))->with('success-create','Gallery has been saved');
            }else{
                return Redirect()->back()->with('error','Sorry something is error !');
            }
        }
    }

    public function show()
    {
        return redirect()->to('backend/campaign')->with('error','Please select campaign!');
    }

    public function edit($id)
    {
        $row = \App\Gallerycampaign::find($id);
        if(!$row){
        	return Redirect()->back()->with('error','Sorry something is error !');
        }
        $tcam=DB::table('lk_campaign')->where('id', $row->campaignid)->first();
        return view('backend.gcampaign.edit',compact('row','id','tcam'));
    }

    public function update(Request $request){
    	$validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator);
        }         

		$gcampaign = \App\Gallerycampaign::find($request->input('id'));

		if(!$gcampaign){
			return redirect()->to('backend/campaign')->with('error','Please select campaign!');
		}

		if(!empty($request->get('enable'))) {
            $enable=1;
        }else{
            $enable=0;
        }

		$nilai=strlen(url(''));
        $len=$nilai+1;

		$gcampaign = new \App\Gallerycampaign;
        $gcampaign->name = $request->get('name');
        $gcampaign->image = substr($request->get('image'),$len);
        $gcampaign->enable = $enable;
        $gcampaign->show = $request->get('show');
        $gcampaign->updated_at = new DateTime();
        $update = $gcampaign->save();
        if($update){
        	$get = \App\Gallerycampaign::find($request->input('id'));
            return redirect()->to('backend/gallerycampaign/show/'.$get->campaignid)->with('success-create','Gallery has been updated');
        }else{
            return Redirect()->back()->with('error','Sorry something is error !');
        }
    }

    public function destroy(Request $request)
    {
    	$gcampaign = \App\Gallerycampaign::find($request->input('id'));
		if($gcampaign)
		{
			$gcampaign->delete();
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