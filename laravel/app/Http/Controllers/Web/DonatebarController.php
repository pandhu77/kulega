<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use Validator;
use Redirect;
use DB;
use DateTime;
use Session;
use Auth;
use PHPMailer;
use File;
use HelperEmail;

class DonatebarController extends Controller{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        if(Session::get('memberid') == null){
            $getsetting = DB::table('t_theme_setting')->where('active',1)->first();
            return view('web.login');
        }
    }

    public function index(){
    	$getsetting = DB::table('t_theme_setting')->where('active',1)->first();
        $memberid   = Session::get('memberid');
        $user       = DB::table('ms_members')->where('member_id','=',$memberid)->first();
        $historys   = DB::table('lk_history_donate')->join('lk_donate', 'lk_donate.id', '=', 'lk_history_donate.donateid')->select('lk_history_donate.*', 'lk_donate.name')->where('memberid',$memberid)->orderBy('date','DESC')->get();
        $kateg      = \App\Donatecate::get();

        return view('web.members.donate',[
            'user'      => $user,
            'historys'    => $historys,
            'kateg'   => $kateg
        ]);
    }

    public function send(Request $request){
        # code...
        // validate the info, create rules for the inputs
        $rules = array(
            'name'          => 'required|unique:lk_donate|max:255|min:5',
            'parent'        => 'required',
            'desc'          => 'required|min:150',
            "image"         => "required|mimes:jpeg,jpg,png|max:10000"
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

            if($request->file('image')){
                $destination = base_path() . '\..\assets\img\donate';

                $file = $request->file('image');
                $ext = $file->getClientOriginalName();
                $filename = str_random(8).'.'.$ext;
                $parts = explode( '.' , $file->getClientOriginalName() );
                
                $file->move($destination,$filename);
            } else {
                return Redirect()->back()->with('error','File PDF is required.');
            }

            $donate             = new \App\Donate;
            $donate->name       = $request->get('name');
            $donate->status     = 0;
            $donate->parent     = $request->get('parent');
            $donate->image      = url('assets/img/donate/'.$filename);
            $donate->desc       = $request->get('desc');
            $donate->created_at = new DateTime();
            $insert             = $donate->save();
            if($insert){
                $inserth = DB::table('lk_history_donate')->insert([
                    'memberid'      => Session::get('memberid'),
                    'donateid'      => $donate->id,
                    'date'          => new DateTime(),
                    'desc'          => 'Telah menambahkan data baru dengan status <span style="color: #FFD700;">Review</span>',
                    'created_at'    => new DateTime(),
                ]);
                return redirect()->to('user/donatebarang/')->with('success','Data has been saved, Thank you.');
            }else{
                return Redirect()->back()->with('error','Sorry something is error !');
            }
        }
    }

}
?>