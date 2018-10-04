@extends('frontend/member/menu')
@section('isi')
<style>
	.panel-contact{
		border-radius: 0px;
	}
	.panel-default > .panel-heading-custom2{
	  background-image: none;
	  background-color: #f4f5f4;
	  color: #B2203D;
	  border-radius: 0px;
	  height: 50px;
	  padding-top: 12px;
	  font-weight: bold;
	  font-size: 18px;
	}
	.btn.btn--tiny {
	    padding: 6px;
	    border: 1px solid;
	    font-size: 10px;
	}
	.btn.btn--secondary {
	    background-color: #fff;
	    color: #000;
	    border-color: #000;
	}

	.rfloat {
	    float: right;
	}

</style>
<title>{{web_name()}} | Profile</title>
<div class="col-md-9 box-right">
    @if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <!-- <h4>  <i class="icon fa fa-check"></i> Alert!</h4> -->
        {{ Session::get('success') }}
    </div>
    @endif
     @if(Session::get('error_get'))
       <div class="alert alert-danger">
         <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
         {{ Session::get('error_get') }}</div>
     @endif
     @if(Session::has('success-edit'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <!-- <h4>  <i class="icon fa fa-check"></i> Alert!</h4> -->
        {{ Session::get('success-edit') }}
    </div>
    @endif
    @if(Session::has('success-add'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <!-- <h4>  <i class="icon fa fa-check"></i> Alert!</h4> -->
        {{ Session::get('success-add') }}
    </div>
    @endif
     @if(Session::get('error_get-edit'))
       <div class="alert alert-dange col-md-12 col-sm-12">
         <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
         {{ Session::get('error_get-edit') }}</div>
     @endif

  <div class="panel panel-default panel-contact" >
    <div class="panel-heading panel-heading-custom2"><span style="color:#333">Shipping</span> Information</div>
    <div class="panel-body">

    <h4 style="font-weight: bold;">Address</h4>
    @foreach($ship as $ships)
      {{ $ships->title}}  <br>
    	<p>{{$ships->recipentname}}, {{$ships->phone_number}}</p>

    	<p>{{$ships->address}}, {{$ships->subdistrict}}, {{$ships->city}}, {{$ships->province}}, {{$ships->post_code}}</p>
		<p>

			   <a href="#" onclick="if(confirm('Are you sure?')) location.href='{{ URL::to('user/my-shipping/delete/' . $ships->adress_id) }}'" style="margin-top:-10px;"title="View This Remove" data-toggle="tooltip" class="rfloat btn btn-sm btn-default remove-item " data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i> Remove </a> &nbsp;
			   <a href="{{url('user/editshipping/'.$ships->adress_id)}}"  style="margin-top:-10px;margin-right:5px;"title="View This Edit" data-toggle="tooltip" class="rfloat btn btn-sm btn-default back " data-toggle="tooltip"><i class="fa fa-pencil" aria-hidden="true"></i> Edit </a><br>
		</p>
      <hr>
    @endforeach
		<a href="{{url('user/addshipping')}}"style=" margin-left: 5px;" class="btn btn-warning btn-xs pull-left confirmation"><i class="fa fa-plus"></i> Add Address</a>
    </div>
  </div>
</div>
@endsection
