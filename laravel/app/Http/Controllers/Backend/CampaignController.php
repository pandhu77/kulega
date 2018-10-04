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
class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
      $auth = $this->CheckAuth();
      if($auth == true){
          $kateg=DB::table('lk_campaign')->get();
          return view('backend.campaign.index',[
            'kateg'=>$kateg,
          ]);
      }else{
        return Redirect::back()->withErrors(['Sorry, No Access']);
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $auth = $this->CheckAuth();
      if($auth == true){
          $kateg=DB::table('lk_campaign_category')->get();
          return view('backend.campaign.create',[
            'kateg'=>$kateg
          ]);
      }else{
        return Redirect::back()->withErrors(['Sorry, No Access']);
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       $auth = $this->CheckAuth();
       if($auth == true){
            # code...
            // validate the info, create rules for the inputs
            $rules = array(

            );
            // run the validation rules on the inputs from the form
            $validator = Validator::make(Input::all(), $rules);
            // if the validator fails, redirect back to the form
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator) // send back all errors to the login form
                    ->withInput(); // send back the input (not the password) so that we can repopulate the form
            } else {
                  if(!empty($request['enable'])){
                    $enable=1;
                  }else{
                    $enable=0;
                  }
                  $status = $enable;
                  $nilai=strlen(url(''));
                  $len=$nilai+1;
                  $image        =substr(Input::get('image'),$len);
                  $name         =Input::get('name');
                  $parent       =Input::get('parent');
                  $target       =Input::get('target');
                  $desc         =Input::get('desc');
                  $url          =Input::get('url');
                  $now          = new DateTime();
                  $userid= auth::user()->id;

                $insert = DB::table('lk_campaign')->insert([
                    'name'       => $name,
                    'url'        => $url,
                    'show'       => Input::get('show'),
                    'enable'     => $status,
                    'target'     => $target,
                    'parent'     => $parent,
                    'desc'       => $desc,
                    'image'      => $image,
                    'created_at' => $now,
                    'created_by' =>$userid,
                ]);
                if($insert){
                    return redirect()->to('backend/campaign')->with('success-create','Thank you for campaign add!');
                }else{
                    return Redirect()->back()->with('error','Sorry something is error !');
                }
            }
       }else{
           return Redirect::back()->withErrors(['Sorry, No Access']);
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $auth = $this->CheckAuth();
      if($auth == true){
          $kateg=DB::table('lk_campaign_category')->get();
          $row=DB::table('lk_campaign')->where('id','=',$id)->first();
          if(count($row)>0){
            return view('backend.campaign.edit',[
              'row' =>$row,
              'kateg' =>$kateg
            ]);
          }else{
            return Redirect::back()->withErrors(['Sorry, Data not found!']);
          }
      }else{
          return Redirect::back()->withErrors(['Sorry, No Access']);
      }

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

         $auth = $this->CheckAuth();
         if($auth == true){
              # code...
              // validate the info, create rules for the inputs
              $rules = array(

              );
              // run the validation rules on the inputs from the form
              $validator = Validator::make(Input::all(), $rules);
              // if the validator fails, redirect back to the form
              if ($validator->fails()) {
                  return redirect()->back()
                      ->withErrors($validator) // send back all errors to the login form
                      ->withInput(); // send back the input (not the password) so that we can repopulate the form
              } else {
                    if(!empty($request['enable'])){
                      $enable=1;
                    }else{
                      $enable=0;
                    }
                    $status = $enable;
                    $nilai=strlen(url(''));
                    $len=$nilai+1;
                    $image        =substr(Input::get('image'),$len);
                    $name         =Input::get('name');
                    $parent       =Input::get('parent');
                    $target       =Input::get('target');
                    $desc         =Input::get('desc');
                    $url          =Input::get('url');
                    $now          = new DateTime();
                    $userid= auth::user()->id;

                  $insert = DB::table('lk_campaign')->where('id','=',$id)->update([
                      'name'       => $name,
                      'url'        => $url,
                      'show'       => Input::get('show'),
                      'enable'     => $status,
                      'target'     => $target,
                      'parent'     => $parent,
                      'desc'       => $desc,
                      'image'      => $image,
                      'updated_at'  => $now,
                      'updated_by'  =>$userid,
                  ]);
                  if($insert){
                      return redirect()->to('backend/campaign')->with('success-create','Thank you for campaign update!');
                  }else{
                      return Redirect()->back()->with('error','Sorry something is error !');
                  }
              }
         }else{
             return Redirect::back()->withErrors(['Sorry, No Access']);
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

        $auth = $this->CheckAuth();
          if($auth == true){
            $checkuser=DB::table('user_access')->where('access_id','=',Auth::user()->access_id)->first();
            if($checkuser->type==1){
              $i = DB::table('lk_campaign')->where('id',$id)->delete();
              if($i > 0)
              {
                 return redirect()->back()->with('success-delete','Your Campaign file has been deleted!');
              }else{
                  return redirect()->back()->with('no-delete','Can not be removed!');
              }
            }else{
               return redirect()->back()->with('no-delete','Sorry, No Access to removed!');
            }
          }else{
            return Redirect::back()->withErrors(['Sorry, No Access']);
          }
    }

    private function CheckAuth()
    {
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
