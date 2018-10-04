<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Form;
use Auth;
use Session;
use Validator;
use Redirect;
use DB;
use Hash;
use Response;
use DateTime;
use Helper;
use HelperEmail;
use PHPMailer;

class CmsContactController extends  Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index(){
      $data = DB::table('ms_contact')->get();
      return view('backend.contact.index',[
        'data'  => $data,
      ]);
  }
  public function create()
  {
      return view('backend.banner.create');
  }

  public function store(Request $request)
  {
    $rules = array(
      'image'       => 'required',
    );
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      return Redirect::to('nerds/' . $id . '/edit')
      ->withErrors($validator)
      ->withInput(Input::except('password'));
    } else {

      if(!empty($request['enable'])){
        $enable=1;
      }else{
        $enable=0;
      }
      $status   = $enable;
      $nilai    = strlen(url(''));
      $len      = $nilai+1;
      $image    = substr(Input::get('image'),$len);
      $title    = Input::get('title');
      $now      = new DateTime();
      $userid   = auth::user()->id;

      $store    = DB::table('cms_banner')->insert([
          'enable'      => $status,
          'title'       => $title,
          'image'       => $image,
          'created_at'  => $now,
      ]);

      if($store){
        return redirect()->to('backend/banner')->with('success-create','Thank you for banner Add!');
      }else{
        return Redirect()->back()->with('error','Sorry something is error !');
      }
    }
  }


  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id){
      $row = DB::table('ms_contact')->where('id','=',$id)->first();

      if ($row->status == 0) {
          DB::table('ms_contact')->where('id','=',$id)->update([
             'status'       => 1,
             'updated_at'   => new DateTime(),
             'updated_by'   => Auth::user()->id,
          ]);
      }

      return view('backend.contact.edit',[
        'row' => $row,
      ]);
  }


  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {
    $rules = array(
      'subject' => 'required',
      'message' => 'required',
    );
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      return Redirect::to('nerds/' . $id . '/edit')
      ->withErrors($validator)
      ->withInput(Input::except('password'));
    } else {

        $detail = DB::table('ms_contact')->where('id',$id)->first();
        $resultHtml=HelperEmail::emailcontact($_POST['message']);

        // GET MAIL
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

        //PHPMailer Object
        $mail               = new PHPMailer;
        $mail->isSMTP();
        $mail->Host         = $array['Host'];
        $mail->SMTPAuth     = true;
        $mail->Username     = $array['Username'];
        $mail->Password     = $array['Password'];
        $mail->SMTPSecure   = $array['SMTPsecure'];
        $mail->Port         = $array['Port'];

        $mail->From     = $websetting->email;
        $mail->FromName = $websetting->site_name;

        $mail->addAddress($detail->email);

        $mail->isHTML(true);

        $mail->Subject  = $_POST['subject'];
        $mail->Body     = $resultHtml;
        $mail->AltBody  = "ini link anda plan";
        if(!$mail->send()){
            return Redirect()->back()->with('error','Sorry something is error !');
        } else {
            $update  = DB::table('ms_contact')->where('id', $id)->update([
                'status'        => 2,
                'updated_at'    => new DateTime(),
                'updated_by'    => Auth::user()->id
            ]);

            return redirect()->to('backend/contact')->with('success-update','Message Replied!');
        }
    }
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
      $i = DB::table('cms_banner')->where('id',$id)->delete();
      if($i > 0)
      {
         return redirect()->to('backend/banner')->with('success-delete','Your slider file has been deleted!');
       }else{
          return redirect()->back()->with('no-delete','Can not be removed!');
       }
  }

}
