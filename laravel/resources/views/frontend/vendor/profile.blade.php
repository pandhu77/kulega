@extends('frontend/vendor/menu')
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
@media (min-width:768px){
	.group-imgprofile{
		width: 250px;
	}
	.group-username{
		width: 300px;
	}
	.group-email{
		width: 500px;
	}
	.group-name{
		width: 500px;
	}
	.group-phone{
		width: 400px;
	}
}
.select2-container--default .select2-selection--single {
    height: 40px!important;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    padding-top: 5px!important;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    padding-top: 5px!important;
}

</style>
<title>E-Commerce Djaring.id | Vendor Profile</title>
<div class="col-md-9">
    @if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <!-- <h4>  <i class="icon fa fa-check"></i> Alert!</h4> -->
        {{ Session::get('success') }}
    </div>
    @endif
     @if(Session::get('error_get'))
       <div class="alert alert-dange col-md-12 col-sm-12">
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
		 @if($errors->all())
			<div class="alert alert-danger col-md-12 col-sm-12">
				 <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					@foreach($errors->all() as $error)
							<?php echo $error."</br>";?>
					@endforeach
			</div>
		@endif
	<div class="panel panel-default panel-contact" >
    <div class="panel-heading panel-heading-custom2"><span style="color:#333">Vendor</span>  Information</div>
    <div class="panel-body">
    	Name : <?php echo $row->vendor_fullname; ?> <br>
    	Email : <?php echo $row->vendor_email; ?> <br>
    </div>
  </div>
  <div class="panel panel-default panel-contact" >
    <div class="panel-heading panel-heading-custom2"><span style="color:#333">Edit </span> Vendor</div>
    <div class="panel-body">
			<form action="{{ url('vendor/updateprofile')}}" method="post" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
				<input type="hidden" class="form-control" placeholder="User Name" name="vendor_id" value="<?php echo Session::get('vendorid');?>">
				<div class="row no-print"style=";padding-top:5px;padding-bottom:5px;">
					<div class="col-md-12">
						<div class="form-group group-email">
							<label for="email">Email *</label>
							<input type="text" class="form-control input-md" id="email" name="email" required="" value="<?php echo $row->vendor_email;?>">
						</div>
						<div class="form-group group-name">
							<label for="email">Full Name *</label>
							<input type="text" class="form-control input-md" id="fullname" name="fullname" required="" value="<?php echo $row->vendor_fullname;?>">
						</div>
						<div class="form-group group-phone">
							<label for="email">Phone Number *</label>
							<input type="text" class="form-control input-md" id="phonenumber" name="phonenumber" required="" value="<?php echo $row->vendor_phone;?>">
						</div>
						<div class="form-group group-address">
							<label for="email">Address</label>
							<textarea class="form-control input-md" id="address" name="address" required="" value=""><?php echo $row->vendor_address;?></textarea>
						</div>
					</div>
				</div>
				<div class="col-xs-12" style="padding-top:5px;padding-bottom:5px;margin-top:20px;text-align:right; ">
					<div class="btn-group">
								<a href="{{url('vendor/profile')}}" class="btn  btn-default" type="button"  data-placement="top" data-toggle="tooltip" data-original-title="Back"><i class="fa fa-share"></i> Back</a>
								<button class="btn pull-right" style="background-color: #B2203D; color: white;" type="submit" data-original-title=""><i class="fa fa-save"></i> Save</button>
					</div>
				</div>
		 </form>
     </div>
  </div>
</div>

<script>


function readURL(input) {
	 if (input.files && input.files[0]) {
			 var reader = new FileReader();

			 reader.onload = function (e) {
					 $('#viewimg').attr('src', e.target.result);
			 }

			 reader.readAsDataURL(input.files[0]);
	 }
}
</script>
@endsection
