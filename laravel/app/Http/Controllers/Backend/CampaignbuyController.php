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
class CampaignbuyController extends Controller
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
    	return redirect()->to('backend/campaignbuy/show');
    }

    public function show()
    {
        $row = \App\Campaignbuy::get();
        return view('backend.campaignbuy.index',compact('row'));
    }

    public function create()
    {
        $member = DB::table('ms_members')->get();
        return view('backend.campaignbuy.create',compact('member'));
    }

    public function store(Request $request)
    {
        # code...
        // validate the info, create rules for the inputs
        $rules = array(
        	'name' => 'required|unique:lk_campaign_buyyer|max:255',
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator) // send back all errors to the login form
                ->withInput(); // send back the input (not the password) so that we can repopulate the form
        } else {
            $nilai=strlen(url(''));
            $len=$nilai+1;
            $campaignbuy = new \App\Campaignbuy;

            if($request->file('myPdf')){
                $destination = base_path() . '\..\public\docs';

                $file = $request->file('myPdf');
                $ext = $file->getClientOriginalName();
                $filename = str_random(8).'.'.$ext;
                $parts = explode( '.' , $file->getClientOriginalName() );
                
                $file->move($destination,$filename);
            } else {
                return Redirect()->back()->with('error','File PDF is required.');
            }

            $campaignbuy->name       = $request->get('name');
            $campaignbuy->status     = 0;
            $campaignbuy->donation   = $request->get('target');
            $campaignbuy->memberid   = $request->get('member');
            $campaignbuy->pdf        = $filename;
            $campaignbuy->desc       = $request->get('desc');
            $campaignbuy->created_at      = new DateTime();
            $insert = $campaignbuy->save();
            if($insert){
                return redirect()->to('backend/campaignbuy/show/')->with('success-create','Category has been saved');
            }else{
                return Redirect()->back()->with('error','Sorry something is error !');
            }
        }
    }

    public function edit($id)
    {
        $row = \App\Campaignbuy::find($id);
        if(!$row){
        	return Redirect()->back()->with('error','Sorry something is error !');
        }
        $member = DB::table('ms_members')->get();
        return view('backend.campaignbuy.edit',compact('row','id','member'));
    }

    public function update(Request $request){
    	$validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator);
        }         

		$campaignbuy = \App\Campaignbuy::find($request->input('id'));

		if(!$campaignbuy){
			return redirect()->to('backend/campaignbuy/show/');
		}

        $nilai=strlen(url(''));
        $len=$nilai+1;

        if($request->file('myPdf')){
            $destination = base_path() . '\..\public\docs';

            $file = $request->file('myPdf');
            $ext = $file->getClientOriginalName();
            $filename = str_random(8).'.'.$ext;
            $parts = explode( '.' , $file->getClientOriginalName() );
            
            $file->move($destination,$filename);

            $campaignbuy->pdf = $filename;
        }

        $campaignbuy->name       = $request->get('name');
        $campaignbuy->donation   = $request->get('target');
        $campaignbuy->memberid   = $request->get('member');
        $campaignbuy->desc       = $request->get('desc');
        $campaignbuy->updated_at = new DateTime();
        $update = $campaignbuy->save();
        if($update){
            return redirect()->to('backend/campaignbuy/show/')->with('success-create','Category has been updated');
        }else{
            return Redirect()->back()->with('error','Sorry something is error !');
        }
    }

    public function confirmed(Request $request){
        $donate = \App\Campaignbuy::find($request->input('id'));
        if($donate)
        {
            $donate->status = 1;
            $update = $donate->save();
            return [
                'Result'    =>  "OK",
                'Message'   =>  "Success"
            ];
        }
        else
        {
            return [
                'Result'    =>  "ERROR",
                'Message'   =>  'User with id '.$request->input('id').' not found.'
            ];
        }
    }

    public function rejected(Request $request){
        $donate = \App\Campaignbuy::find($request->input('id'));
        if($donate)
        {
            $donate->status = 2;
            $update = $donate->save();
            return [
                'Result'    =>  "OK",
                'Message'   =>  "Success"
            ];
        }
        else
        {
            return [
                'Result'    =>  "ERROR",
                'Message'   =>  'User with id '.$request->input('id').' not found.'
            ];
        }
    }

    public function destroy(Request $request)
    {
    	$dbdelete = \App\Campaignbuy::find($request->input('id'));
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