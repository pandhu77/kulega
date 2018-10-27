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

class CampaignbuyController extends Controller{
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

    public function campaignbuy(){
    	$getsetting = DB::table('t_theme_setting')->where('active',1)->first();
        $memberid   = Session::get('memberid');
        $user       = DB::table('ms_members')->where('member_id','=',$memberid)->first();
        $orders     = DB::table('sum_orders')->where('member_id',$memberid)->orderBy('order_date','DESC')->get();
        $address    = DB::table('tmp_member_address')->where('member_id',$memberid)->get();

        return view('web.members.campaignbuy',[
            'user'      => $user,
            'orders'    => $orders,
            'address'   => $address
        ]);
    }

    public function postcampaignbuy(Request $request){
    	# code...
        // validate the info, create rules for the inputs
        $rules = array(
        	'name' 		=> 'required|unique:lk_campaign_buyyer|max:255|min:5',
        	'target' 		=> 'required|min:5|numeric',
        	'myPdf' 		=> 'required',
        	'desc' 			=> 'required|min:150',
        	"myPdf" 		=> "required|mimes:pdf|max:10000"
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
            $campaignbuy->memberid   = Session::get('memberid');
            $campaignbuy->pdf        = $filename;
            $campaignbuy->desc       = $request->get('desc');
            $campaignbuy->created_at = new DateTime();
            $insert = $campaignbuy->save();
            if($insert){
                return redirect()->to('user/campaignbuy/')->with('success','Campaign has been saved, Thank you.');
            }else{
                return Redirect()->back()->with('error','Sorry something is error !');
            }
        }
    }

}
?>