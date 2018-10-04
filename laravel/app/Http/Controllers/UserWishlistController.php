<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use DB;
use Cart;
use Session;
use Datetime;

class UserWishlistController extends Controller
{

      public function wishlist(){
        if(Session::get('memberid')){
            $memberid=Session::get('memberid');
            $wish=DB::table('tmp_wishlist')
                  ->join('ms_products','ms_products.prod_id','=','tmp_wishlist.prod_id')
                  ->join('lk_brand','lk_brand.brand_id','=','ms_products.prod_brand_id')
                  ->where('ms_products.prod_enable','=',1)              
                  ->where('tmp_wishlist.member_id','=',$memberid)->get();

           $categall=DB::table('lk_product_category')
                    ->where('kateg_enable','=',1)
                    ->get();

            return view('frontend.member.wishlist',[
                'wish'=>$wish,
                'categall'=>$categall,
            ]);
      }else{
        Session::flash('error_must_login','You must Login');
        return Redirect('user/login');
      }
    }

    public function storewishlist($prodid){
      if(Session::get('memberid')){
          $memberid=Session::get('memberid');
          $insert=DB::table('tmp_wishlist')->insert([
              'prod_id'=>$prodid,
              'member_id'=>$memberid,
          ]);
          if($insert){
              return Redirect()->to('user/wishlist')->with('success','Thank you wishlist success add! ');
          }else{
              return Redirect()->back()->with('error','Sorry something is error !');
          }
    }else{
      Session::flash('error_must_login','You must Login');
      return Redirect('user/login');
    }
  }
  public function destroy($id){
    if(Session::get('memberid')){
        $memberid=Session::get('memberid');
        $delete=DB::table('tmp_wishlist')->where('wish_id','=',$id)->where('member_id','=',$memberid)->delete();
        if($delete){
            return Redirect()->to('user/wishlist')->with('delete','Thank you wishlist success delete! ');
        }else{
            return Redirect()->back()->with('error','Sorry something is error !');
        }
  }else{
    Session::flash('error_must_login','You must Login');
    return Redirect('user/login');
  }
  }
}
