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
class DonateController extends Controller
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
    	return redirect()->to('backend/donate/show');
    }

    public function show()
    {
        $row = \App\Donate::get();
        return view('backend.donate.index',compact('row'));
    }

    public function create()
    {
        $kateg = \App\Donatecate::get();
        return view('backend.donate.create',compact('kateg'));
    }

    public function store(Request $request)
    {
        # code...
        // validate the info, create rules for the inputs
        $rules = array(
        	'name' => 'required|unique:lk_donate|max:255',
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

            $donate             = new \App\Donate;
            $donate->name       = $request->get('name');
            $donate->status     = 0;
            $donate->parent     = $request->get('parent');
            $donate->image      = url().substr($request->get('image'),$len);
            $donate->desc       = $request->get('desc');
            $donate->created_at = new DateTime();
            $insert = $donate->save();
            if($insert){
                $inserth = DB::table('lk_history_donate')->insert([
                    'memberid'      => '0',
                    'donateid'      => $donate->id,
                    'date'          => new DateTime(),
                    'desc'          => 'Telah menambahkan data baru dengan status <span style="color: #FFD700;">Review</span>',
                    'created_at'    => new DateTime(),
                ]);
                return redirect()->to('backend/donate/show/')->with('success-create','Category has been saved');
            }else{
                return Redirect()->back()->with('error','Sorry something is error !');
            }
        }
    }

    public function edit($id)
    {
        $row = \App\Donate::find($id);
        if(!$row){
        	return Redirect()->back()->with('error','Sorry something is error !');
        }
        $kateg = \App\Donatecate::get();
        return view('backend.donate.edit',compact('row','id','kateg'));
    }

    public function update(Request $request){
    	$validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator);
        }         

		$donate = \App\Donate::find($request->input('id'));

		if(!$donate){
			return redirect()->to('backend/donate/show/');
		}

        $nilai=strlen(url(''));
        $len=$nilai+1;

        $donate->name = $request->get('name');
        $donate->parent     = $request->get('parent');
        $donate->image      = url().substr($request->get('image'),$len);
        $donate->desc       = $request->get('desc');
        $donate->updated_at = new DateTime();
        $update = $donate->save();
        if($update){
            return redirect()->to('backend/donate/show/')->with('success-create','Category has been updated');
        }else{
            return Redirect()->back()->with('error','Sorry something is error !');
        }
    }

    public function confirmed(Request $request){
        $donate = \App\Donate::find($request->input('id'));
        if($donate)
        {
            $donate->status = 1;
            $update = $donate->save();

            $history = DB::table('lk_history_donate')->where('donateid',$request->input('id'))->orderBy('date','DESC')->first();

            $inserth = DB::table('lk_history_donate')->insert([
                'memberid'      => $history->memberid,
                'donateid'      => $request->input('id'),
                'date'          => new DateTime(),
                'desc'          => 'Data telah berubah dengan status <span style="color: #FFD700;">Approve</span>',
                'created_at'    => new DateTime(),
            ]);
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
        $donate = \App\Donate::find($request->input('id'));
        if($donate)
        {
            $donate->status = 2;
            $update = $donate->save();

            $history = DB::table('lk_history_donate')->where('donateid',$request->input('id'))->orderBy('date','DESC')->first();

            $inserth = DB::table('lk_history_donate')->insert([
                'memberid'      => $history->memberid,
                'donateid'      => $request->input('id'),
                'date'          => new DateTime(),
                'desc'          => 'Data telah berubah dengan status <span style="color: #FF0000;">Reject</span>',
                'created_at'    => new DateTime(),
            ]);

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
    	$dbdelete = \App\Donate::find($request->input('id'));
		if($dbdelete)
		{
			$dbdelete->delete();

            $history = DB::table('lk_history_donate')->where('donateid',$request->input('id'))->delete();
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