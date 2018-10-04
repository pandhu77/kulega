<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Input;
use Validator;
use File;
use Redirect;
use DateTime;
use Auth;
use Helper;
class DiscountController extends Controller
{
    /**
    * Instantiate a new new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
      $this->middleware('auth');
    }


    /** START GET PRODUCT */
    public function getproddiscount(){
      $id=input::get('id');
      $brand=input::get('brandid');
      $kategid=input::get('kategid');
      $prod=DB::table('ms_products')->where('prod_brand_id','=',$brand)->where('prod_category','like','%'.$kategid.'%')->get();

      echo '
          <select  class="form-control js-example-basic-single"name="prod_id[]" id="proddisc'.$id.'">
              <option value="" selected disabled> Choose</option>';
              foreach($prod as $prods){
                  echo '  <option value="'.$prods->prod_id.'">'.$prods->prod_name.' </option>';
              }
      echo ' </select>';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $auth = $this->CheckAuth();
      if($auth == true){
          $discount=DB::table('ms_discount')->get();

          return view('backend.discount.index',[
            'discount'=>$discount,
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
            $brand=DB::table('lk_brand')->where('brand_enable','=',1)->get();
            $kateg=DB::table('lk_product_category')->where('kateg_enable','=',1)->get();
            $prod=DB::table('ms_products')->where('prod_enable','=',1)->get();
            return view('backend.discount.create',[
              'brand'=>$brand,
              'kateg'=>$kateg,
              'prod'=>$prod,
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

          if(!empty($request['enable'])){
            $enable=1;
          }else{
            $enable=0;
          }
          $status = $enable;

           $code=rand(11111,99999);
           $type=Input::get('type'); //cart disc=2, catalog disc=1
           $name=Input::get('name');
           if($type=="cart")
           {
           $requirement=Input::get('requirement');
           $minValue=Input::get('rfValue');
           $maxValue=Input::get('ruValue');
           }
           else
           {
           $requirement="-";
           $minValue="";
           $maxValue="";
           }
           $reward=Input::get('reward');
           $rValue=Input::get('rValue');
           $fromDate=Input::get('fromDate');
           $untilDate=Input::get('untilDate');

           if(empty(Input::get('pro'))){
              $product_id=null;
           }else{
              $product_id=implode(", ",Input::get('pro'));
           }
           if(empty(Input::get('cat'))){
              $category_id=null;
           }else{
               $category_id=implode(", ",Input::get('cat'));
           }
           if(empty(Input::get('bra'))){
              $brand_id=null;
           }else{
               $brand_id=implode(", ",Input::get('bra'));
           }

           $stacki=Input::get('stacki');
           $stacko=Input::get('stacko');
           $stack=$stacki . $stacko;
           $now          = new DateTime();
           $userid= auth::user()->id;

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

              $insert = DB::table('ms_discount')->insert([
                 'disc_enable'=>$status,
                 'disc_code' => $code,
                 'disc_type' => $type,
                 'disc_name' => $name,
                 'disc_req' => $requirement,
                 'disc_min' => $minValue,
                 'disc_max' => $maxValue,
                 'disc_reward' => $reward,
                 'disc_reward_value' => $rValue,
                 'disc_start_date' => $fromDate,
                 'disc_end_date' => $untilDate,
                 'disc_prod_id' => $product_id,
                 'disc_kateg_id' => $category_id,
                 'disc_brand_id' => $brand_id,
                 'disc_stacked' => $stack,
                 'disc_created_at'=>$now,
                 'disc_created_by'=>$userid,
              ]);
              if($insert){
                return redirect()->to('backend/discount')->with('success-create','Thank you for discount add!');

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
      $brand=DB::table('lk_brand')->where('brand_enable','=',1)->get();
      $kateg=DB::table('lk_product_category')->where('kateg_enable','=',1)->get();
      $prod=DB::table('ms_products')->where('prod_enable','=',1)->get();
      $row=DB::table('ms_discount')->where('disc_id','=',$id)->first();

      return view('backend.discount.edit',[
        'brand'=>$brand,
        'kateg'=>$kateg,
        'prod'=>$prod,
        'row'=>$row,
      ]);
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

        if(!empty($request['enable'])){
          $enable=1;
        }else{
          $enable=0;
        }
        $status = $enable;

         $code=rand(11111,99999);
         $type=Input::get('type'); //cart disc=2, catalog disc=1
         $name=Input::get('name');
         if($type=="cart")
         {
         $requirement=Input::get('requirement');
         $minValue=Input::get('rfValue');
         $maxValue=Input::get('ruValue');
         }
         else
         {
         $requirement="-";
         $minValue="";
         $maxValue="";
         }
         $reward=Input::get('reward');
         $rValue=Input::get('rValue');
         $fromDate=Input::get('fromDate');
         $untilDate=Input::get('untilDate');

         if(empty(Input::get('pro'))){
            $product_id=null;
         }else{
            $product_id=implode(", ",Input::get('pro'));
         }

         if(empty(Input::get('cat'))){
            $category_id=null;
         }else{
           $category_id=implode(", ",Input::get('cat'));
         }

         if(empty(Input::get('bra'))){
            $brand_id=null;
         }else{
            $brand_id=implode(", ",Input::get('bra'));
         }


         $stacki=Input::get('stacki');
         $stacko=Input::get('stacko');
         $stack=$stacki . $stacko;
         $now          = new DateTime();
         $userid= auth::user()->id;
         $rules = array(
          // 'end_date'       => 'required',
          // 'email'      => 'required|email',
          // 'nerd_level' => 'required|numeric'
         );
         $validator = Validator::make(Input::all(), $rules);

         if ($validator->fails()) {
          return Redirect::to('nerds/' . $id . '/edit')
          ->withErrors($validator)
          ->withInput(Input::except('password'));
         } else {

          $update = DB::table('ms_discount')
          ->where('disc_id', $id)
          ->update([
            'disc_enable'=>$status,
            // 'disc_code' => $code,
            'disc_type' => $type,
            'disc_name' => $name,
            'disc_req' => $requirement,
            'disc_min' => $minValue,
            'disc_max' => $maxValue,
            'disc_reward' => $reward,
            'disc_reward_value' => $rValue,
            'disc_start_date' => $fromDate,
            'disc_end_date' => $untilDate,
            'disc_prod_id' => $product_id,
            'disc_kateg_id' => $category_id,
            'disc_brand_id' => $brand_id,
            'disc_stacked' => $stack,
            'disc_updated_at'=>$now,
            'disc_updated_by'=>$userid,
          ]);

          if($update){
            return redirect()->to('backend/discount')->with('success-create','Thank you for discount Update!');
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
            $i = DB::table('ms_discount')->where('disc_id',$id)->delete();
            if($i > 0)
            {
               return redirect()->back()->with('success-delete','Your discount file has been deleted!');
             }else{
                return redirect()->back()->with('no-delete','Can not be removed!');
             }
          }else{
             return redirect()->back()->with('no-delete','Sorry, No Access to removed!');
          }
        }else{
          return Redirect::back()->withErrors(['msg', 'Sorry, No Access']);
        }
    }

    private function CheckAuth()
    {
      $url = request()->segment(1)."/".request()->segment(2);
      $menu=DB::table('menu_admin')->where('menu_admin.status_menu','=',1)->get();
      foreach ($menu as $menus)
      {
        if($menus->url== $url){
          $cek=  Helper::checkmenuchecklist(Auth::user()->access_id, $menus->menu_id);
          if ($cek ==1){
            return true;
          }else{
            return false;
          }

        }
      }
    }
}
