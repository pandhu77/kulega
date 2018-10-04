<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use DB;
use Datetime;
use HelperEmail;
use App\Http\Controllers\Controller;
use PHPMailer;

class ContactController extends Controller{

    public function contactform(){
        $getsetting = DB::table('t_theme_setting')->where('active',1)->first();
        return view('web.contact');
    }

    public function contactpost(){
        $rules = [
            'name'  => 'required',
            'email' => 'required'
        ];

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        } else {

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

            $returnhtml= HelperEmail::contactnotif($_POST['name'],$_POST['email'],$_POST['phone'],$_POST['subject'],$_POST['message']);

            //PHPMailer Object
            $mail = new PHPMailer;
            $mail->SMTPDebug = 1;
            $mail->isSMTP();
            $mail->Host         = $array['Host'];
            $mail->SMTPAuth     = true;
            $mail->Username     = $array['Username'];
            $mail->Password     = $array['Password'];
            $mail->SMTPSecure   = $array['SMTPsecure'];
            $mail->Port         = $array['Port'];

            $mail->From     = $array['Username'];
            $mail->FromName = 'iamaddicted.id';

            $mail->addAddress($array['Username'], $_POST['name']);

            $mail->isHTML(true);

            $mail->Subject = "Contact Us -".$websetting->site_name." ".date('d M Y H:i:s');
            $mail->Body = $returnhtml;
            $mail->AltBody = "ini link anda plan";
            $mailSend = $mail->send();

            if(!$mailSend){
                return redirect()->back()->with('fail','Fail Send Message');
            } else {
                $insert = DB::table('ms_contact')->insert([
                    'status'    => 0,
                    'name'      => $_POST['name'],
                    'email'     => $_POST['email'],
                    'phone'     => $_POST['phone'],
                    'subject'   => $_POST['subject'],
                    'message'   => $_POST['message'],
                    'created_at'=> new DateTime()
                ]);

                if($insert){
                    return redirect()->back()->with('success','Success Send Message');
                }else {
                    return redirect()->back()->with('fail','Fail Send Message');
                }
            }

        }
    }

}
