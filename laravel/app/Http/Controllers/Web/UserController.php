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

class UserController extends Controller{

    public function login(){

        // $base_url = $_SERVER['SERVER_NAME'];
        // if (stristr($base_url, 'beta') == false) {
        //     return view('web.coming-soon');
        // }

        if(Session::get('memberid') == null){
            $getsetting = DB::table('t_theme_setting')->where('active',1)->first();
            return view('web.login');
        }else{
            return redirect('user/profile');
        }
    }

    public function dologin(){
        $rules = array(
            'email'    => 'required|email',
            'password' => 'required|min:6'
        );
        $redirect = "";
        if(isset($_GET['redirect'])){
            $redirect = $_GET['redirect'];
        }

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput(Input::except('password'));
        } else {
            $email=Input::get('email');
            $password=Input::get('password');
            $user = DB::table('ms_members')
            ->where('member_email', $email)
            ->where('member_status', 1)
            ->first();

            if ($user && Hash::check(Input::get('password'), $user->member_password)) {
                Session::set('memberid',$user->member_id);
                Session::set('membername',$user->member_fullname);
                Session::set('membermail',$user->member_email);
                Session::set('memberphone',$user->member_phone);
                Session::set('memberaddress',$user->member_address);
                Session::set('memberimage',$user->member_image);
                Session::forget("bonusreward1");
                Session::forget("tmppoint1");
                Session::forget("discvoc");
                Session::flash('success','You have successfully logged in');

                if($redirect != ""){
                    return redirect($redirect);
                }
                else{
                    return redirect('user/profile');
                }
            }else{
                if($redirect != ""){
                    return Redirect()->to('user/login?redirect='.$redirect)->with('error_get','Wrong username or password. Try again.!');
                }
                else{
                    return Redirect()->to('user/login')->with('error_get','Wrong username or password. Try again.!');
                }

            }
        }
    }

    public function doregister(){
        $rules = array(
            'member_fullname'   => 'required',
            'member_email'      => 'required|email',
            // 'member_address'    => 'required',
            // 'member_phone'      => 'required|numeric',
            'member_password'   => 'required|min:6',
            'confpass'          => 'required|min:6|same:member_password',
        );

            $validator = Validator::make(Input::all(), $rules);
        if (/*($validator->fails()*/false) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput(Input::except('password'));
        } else {
            $fullname   = Input::get('member_fullname');
            $email      = Input::get('member_email');
            $password   = Hash::make(Input::get('member_password'));
            $pass       = Input::get('member_password');
            $confpass   = Input::get('confpass');
            $now        = new DateTime();
            $check      = DB::table('ms_members')->where('member_email','=',$email)->count();
            $activation_code = str_random(30).$email;

            if($check > 0){
                return Redirect()->to('user/login')->with('error_get','Sorry this email already registered!');
            }else{

                $mailmodule = DB::table('t_module_options')->where('module','mail')->get();
                $websetting = DB::table('cms_config')->first();
                $array      = [];

                foreach ($mailmodule as $key => $mail) {
                    if (empty($mail->value)) {
                        $array[$mail->code] = $mail->default_value;
                    }else {
                        $array[$mail->code] = $mail->value;
                    }
                }

                $returnhtml= HelperEmail::emailRegistration($email,$fullname,$activation_code,$pass);

                //PHPMailer Object
                $mail = new PHPMailer;
                // $mail->SMTPDebug = 1;
	              $mail->isSMTP();
                $mail->Host         = $array['Host'];
                $mail->SMTPAuth     = true;
                $mail->Username     = $array['Username'];
                $mail->Password     = $array['Password'];
                $mail->SMTPSecure   = $array['SMTPsecure'];
                $mail->Port         = $array['Port'];

                $mail->From     = $array['Username'];
                $mail->FromName = 'Sonia';

                $mail->addAddress($email, $fullname);

                $mail->isHTML(true);

                $mail->Subject = "Please Activate Your Account! -".$websetting->site_name." ".date('d M Y H:i:s');
                $mail->Body = $returnhtml;
                $mail->AltBody = "ini link anda plan";

                if(!$mail->send()){
                    return Redirect()->to('user/login')->with('error_get','Maaf terjadi kesalahan dalam pendaftaran. Silahkan coba mendaftar kembali.');
                } else {
                    $insert = DB::table('ms_members')->insert([
                        'member_fullname'   => $fullname,
                        'member_email'      => $email,
                        // 'member_address'    => $_POST['member_address'],
                        // 'member_phone'      => $_POST['member_phone'],
                        'member_password'   => $password,
                        'activation_code'   => $activation_code,
                        'member_created_at' => $now,
                    ]);
                    return Redirect()->to('user/login')->with('signupsuccess','Terima kasih telah mendaftar. Mohon cek e-mail anda di inbox / spam folder dan klik tombol aktifkan akun pada e-mail yang kami kirimkan untuk dapat login.');
                }
            }
        }
    }

    public function activation($code){
        $cekmember = DB::table('ms_members')
                        ->where('activation_code','=',$code)
                        ->where('member_status','=',0)
                        ->first();

        if(count($cekmember) > 0){
            $update = DB::table('ms_members')
                        ->where('activation_code','=',$cekmember->activation_code)
                        ->update(['member_status' => 1 ]);
            if($update){

                return Redirect()->to('user/login')->with('signupsuccess','Thank you ! Your account has been activated. Please login to continue shopping.');
                exit;

                $mailmodule = DB::table('t_module_options')->where('module','mail')->get();
                $websetting = DB::table('cms_config')->first();
                $array      = [];

                foreach ($mailmodule as $key => $mail) {
                    if (empty($mail->value)) {
                        $array[$mail->code] = $mail->default_value;
                    }else {
                        $array[$mail->code] = $mail->value;
                    }
                }

                $returnhtml= HelperEmail::emailActivation($code);

                //PHPMailer Object
                $mail = new PHPMailer;
                $mail->isSMTP();
                $mail->Host         = $array['Host'];
                $mail->SMTPAuth     = true;
                $mail->Username     = $array['Username'];
                $mail->Password     = $array['Password'];
                $mail->SMTPSecure   = $array['SMTPsecure'];
                $mail->Port         = $array['Port'];

                $mail->From     = $websetting->email;
                $mail->FromName = $websetting->site_name;

                $mail->addAddress($cekmember->member_email, $cekmember->member_fullname);

                $mail->isHTML(true);

                $mail->Subject = "Welcome to ".$websetting->site_name." ".date('d M Y H:i:s');
                $mail->Body = $returnhtml;
                $mail->AltBody = "ini link anda plan";
                if(!$mail->send()){
                    return Redirect()->to('user/login')->with('error_get','Mailer Error:'.$mail->ErrorInfo.'');
                } else {
                    return Redirect()->to('user/login')->with('signupsuccess','Thank you ! Your account has been activated. Please login to continue shopping.');
                }
            }else{
                return Redirect('/');
            }
        }else {
            return Redirect('/');
        }
    }

    public function profile(){
        $getsetting = DB::table('t_theme_setting')->where('active',1)->first();
        $memberid   = Session::get('memberid');
        $user       = DB::table('ms_members')->where('member_id','=',$memberid)->first();
        $orders     = DB::table('sum_orders')->where('member_id',$memberid)->orderBy('order_date','DESC')->get();
        $address    = DB::table('tmp_member_address')->where('member_id',$memberid)->get();

        return view('web.members.user-profile',[
            'user'      => $user,
            'orders'    => $orders,
            'address'   => $address
        ]);
    }

    public function insertaddress(){
        $title      = $_POST['title'];
        $first_name = $_POST['first_name'];
        $last_name  = $_POST['last_name'];
        $country_id = $_POST['country_id'];
        $country    = $_POST['country'];
        $address    = $_POST['address'];
        $province   = $_POST['province'];
        $city       = $_POST['city'];
        $district   = $_POST['district'];
        $district_id= $_POST['district_id'];
        $poscode    = $_POST['poscode'];
        $phone      = $_POST['phone'];

        DB::table('tmp_member_address')->insert([
            'member_id' => Session::get('memberid'),
            'title'     => $title,
            'first_name'=> $first_name,
            'last_name' => $last_name,
            'country_id'=> $country_id,
            'country'   => $country,
            'address'   => $address,
            'province'  => $province,
            'city'      => $city,
            'district'  => $district,
            'district_id'=> $district_id,
            'poscode'   => $poscode,
            'phone'     => $phone
        ]);

        $getaddress = DB::table('tmp_member_address')->where('member_id',Session::get('memberid'))->get();
        $html = '';

        if (count($getaddress) == 0) {
            $html .= '<tr><td>Empty</td></tr>';
        } else {
            foreach ($getaddress as $key => $addr) {
                $html .= '  <tr>
                                <td>'.$addr->country.'</td>
                                <td>'.$addr->title.'</td>
                                <td>'.$addr->first_name.'</td>
                                <td>'.$addr->last_name.'</td>
                                <td>'.$addr->address.'</td>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-danger" onclick="deladdr('.$addr->id.')">Delete</a>
                                </td>
                            </tr>';
            }
        }

        return $html;

    }

    public function deleteaddress(){
        $idaddr = $_POST['addrid'];

        $getaddr = DB::table('tmp_member_address')->where('id',$idaddr)->delete();

        $getaddress = DB::table('tmp_member_address')->where('member_id',Session::get('memberid'))->get();
        $html = '';

        if (count($getaddress) == 0) {
            $html .= '<tr><td>Empty</td></tr>';
        } else {
            foreach ($getaddress as $key => $addr) {
                $html .= '  <tr>
                                <td>'.$addr->country.'</td>
                                <td>'.$addr->title.'</td>
                                <td>'.$addr->first_name.'</td>
                                <td>'.$addr->last_name.'</td>
                                <td>'.$addr->address.'</td>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-danger" onclick="deladdr('.$addr->id.')">Delete</a>
                                </td>
                            </tr>';
            }
        }

        return $html;

    }

    public function profileupdate(){
        $memberid   = Session::get('memberid');
        $rules = array(
            'member_fullname'   => 'required',
            // 'member_email'      => 'required|email|unique:ms_members,member_email,'.$memberid,
            'member_phone'      => 'numeric|min:6',
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput(Input::except('password'));
        } else {
             DB::table('ms_members')->where('member_id',$memberid)->update([
                 'member_fullname'  => Input::get('member_fullname'),
                //  'member_email'     => Input::get('member_email'),
                 'member_phone'     => Input::get('member_phone'),
                 'member_address'   => Input::get('member_address'),
                 'member_update_at' => new DateTime()
             ]);

             return redirect()->back();
        }
    }

    public function passupdate(){
        $memberid   = Session::get('memberid');
        $rules = array(
            'password'          => 'required',
            'password_confirm'  => 'required|same:password',
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput(Input::except('password'));
        } else {
             DB::table('ms_members')->where('member_id',$memberid)->update([
                 'member_password'  => Hash::make(Input::get('password')),
                 'member_update_at' => new DateTime()
             ]);

             return redirect()->back();
        }
    }

    public function orderdetail(){
        $order_id       = Input::get('order_id');
        $order          = DB::table('sum_orders')->where('order_id',$order_id)->first();
        $orderdetails   = DB::table('tmp_order_detail')
                            ->leftJoin('ms_products','ms_products.prod_id','=','tmp_order_detail.prod_id')
                            ->where('tmp_order_detail.order_id',$order_id)->get();

        echo '  <div class="col-sm-6" style="margin-bottom:50px;">
                    Order Date : <strong>'.date("d/M/Y H:i:s",strtotime($order->order_date)).'</strong><br>
                    Billing Name : <strong>'.$order->billing_name.'</strong><br>
                    Billing Email : <strong>'.$order->billing_email.'</strong><br>
                    Billing Phone : <strong>'.$order->billing_phone.'</strong><br>
                    Billing Address : <strong>'.$order->billing_address.'</strong><br>
                    Billing Poscode : <strong>'.$order->billing_poscode.'</strong><br>
                    Shipping Courier : <strong>'.$order->shipping_courier.'</strong><br>
                    No Resi : <strong>'.$order->no_resi.'</strong>
                </div>

                <div class="col-sm-6" style="margin-bottom:50px;">
                    Order Status : ';
                    if ($order->payment_status == 0) {
                        echo '<span class="label label-primary">Waiting</span>';
                    } elseif($order->payment_status == 1) {
                        echo '<span class="label label-warning">Waiting Confirm</span>';
                    } elseif($order->payment_status == 2) {
                        echo '<span class="label label-success">Completed</span>';
                    } elseif($order->payment_status == 3) {
                        echo '<span class="label label-danger">Cancelled</span>';
                    }
        echo '  <br>
                    Shipping Name : <strong>'.$order->customer_name.'</strong><br>
                    Shipping Email : <strong>'.$order->customer_email.'</strong><br>
                    Shipping Phone : <strong>'.$order->customer_phone.'</strong><br>
                    Shipping Address : <strong>'.$order->customer_address.'</strong><br>
                    Shipping Poscode : <strong>'.$order->order_poscode.'</strong><br>
                    Payment Method : <strong>';
                    if ($order->payment_service == 1) {
                        echo 'Bank Transfer';
                    }else {
                        echo 'Credit Card';
                    }
        echo '      </strong>
                </div>';

        echo '  <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th style="text-align:right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($orderdetails as $details) {
        echo '          <tr>
                            <td>'.$details->prod_name.'</td>
                            <td>'.$details->prod_color.'</td>
                            <td>'.$details->prod_size.'</td>
                            <td>'.number_format($details->prod_price,0,',','.').'</td>
                            <td>'.$details->detail_qty.'</td>
                            <td style="text-align:right;">'.number_format($details->detail_subtotal,0,',','.').'</td>
                        </tr>';
        }
        echo '          <tr>
                            <td colspan="5" style="text-align:right;">Total</td>
                            <td style="text-align:right;">'.number_format($order->sub_total,0,',','.').'</td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align:right;">Shipping Cost</td>
                            <td style="text-align:right;">'.number_format($order->shipping_cost,0,',','.').'</td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align:right;">Voucher(-)</td>
                            <td style="text-align:right;">['.$order->voucher_code.'] '.number_format($order->voucher_value,0,',','.').'</td>
                        </tr>';
                        if($order->payment_service == 2){
        echo '          <tr>
                            <td colspan="5" style="text-align:right;">CC Charge(+3%)</td>
                            <td style="text-align:right;">'.number_format($order->disc_reward,0,',','.').'</td>
                        </tr>';
                        }
        echo '          <tr>
                            <td colspan="5" style="text-align:right;">Payment Code</td>
                            <td style="text-align:right;">'.number_format($order->payment_code,0,',','.').'</td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align:right;"><strong>Grand Total</strong></td>
                            <td style="text-align:right;"><strong>'.number_format($order->order_total,0,',','.').'</strong></td>
                        </tr>';

        echo '      </tbody>
                </table>';
    }

    public function ordercancel($order_id){
        $order      = DB::table('sum_orders')->where('order_id',$order_id)->first();
        $detailorder= DB::table('tmp_order_detail')->where('order_id',$order_id)->get();
        $memberid   = Session::get('memberid');

        foreach ($detailorder as $key => $value) {
            $getproduct = DB::table('ms_products')->where('prod_id',$value->prod_id)->first();
            $calculate  = $getproduct->prod_stock + $value->detail_qty;
            DB::table('ms_products')->where('prod_id',$value->prod_id)->update([
                'prod_stock' => $calculate
            ]);
        }

        if($order->member_id == $memberid){
            DB::table('sum_orders')->where('order_id',$order_id)->update([
                'order_status'  => 5,
                'payment_status'=> 3
            ]);

            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function orderpayment($order_id){
        $order = DB::table('sum_orders')->where('order_id',$order_id)->first();
        if ($order->order_status == 0) {
            $getsetting = DB::table('t_theme_setting')->where('active',1)->first();
            Session::set('orderid1',$order_id);
            return view('themes.'.$getsetting->name.'.module.checkout-payment');
        }else {
            return redirect()->back();
        }
    }

    public function dologout(){
        Session::forget('memberid');
        Session::forget('membername');
        Session::forget('membermail');
        Session::forget('memberphone');
        Session::forget('memberaddress');
        Session::forget('memberimage');
        Session::flash('message', "welcome");
        return redirect('/');
    }

}
