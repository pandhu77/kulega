@extends('frontend/member/menu')
@section('isi')
<style>
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
    <div class="panel-heading panel-heading-custom2"><span style="color:#333">Profile</span>  Information</div>
    <div class="panel-body">
    	Name : <?php echo $row->member_fullname; ?> <br>
    	Email : <?php echo $row->member_email; ?> <br>
      Birth Of Date : <?php if($row->member_dob !==null){echo date('d-M-Y', strtotime($row->member_dob));} else{echo '-';}  ?>
    </div>
  </div>
  <div class="panel panel-default panel-contact" >
    <div class="panel-heading panel-heading-custom2"><span style="color:#333">Edit </span> Profile</div>
    <div class="panel-body">
			<form action="{{ url('user/updateprofile')}}" method="post" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
				<input type="hidden" class="form-control" placeholder="User Name" name="member_id" value="<?php echo Session::get('memberid');?>">
				<div class="row no-print"style=";padding-top:5px;padding-bottom:5px;">
					<div class="col-md-12">
						<div class="form-group group-imgprofile" >
							 <label class="label-left">Change Profile</label>
								<input type="file" class="filestyle " name="imagetest" id="img" data-buttonName="btn-default">
								<input type="hidden" class="form-control" placeholder="" name="member_image" value="{{$row->member_image}}">
						</div>

						<div class="form-group group-username">
							<label for="email">Username *</label>
							<input type="text" class="form-control input-md" id="username" name="username" required="" value="<?php echo $row->member_username;?>">
						</div>
						<div class="form-group group-email">
							<label for="email">Email *</label>
							<input type="text" class="form-control input-md" id="email" name="email" required="" value="<?php echo $row->member_email;?>">
						</div>
						<div class="form-group group-name">
							<label for="email">Full Name *</label>
							<input type="text" class="form-control input-md" id="fullname" name="fullname" required="" value="<?php echo $row->member_fullname;?>">
						</div>
						<div class="form-group group-phone">
							<label for="email">Phone Number *</label>
							<input type="text" class="form-control input-md" id="phonenumber" name="phonenumber" required="" value="<?php echo $row->member_phone;?>">
						</div>
						<div class="form-group group-address">
							<label for="email">Address</label>
							<textarea class="form-control input-md" id="address" name="address" required="" value=""><?php echo $row->member_address;?></textarea>
						</div>
						<div class="form-group">
							<label for="email">Gender</label>
								<!-- <label class="radio-inline"> -->
									<input type="radio" name="gender" value="male" <?php if($row->member_gender== "male" ){ echo "checked";} ?> > Male
								<!-- <label class="radio-inline"> -->
									<input type="radio" name="gender" value="famale" <?php if($row->member_gender == "famale" ){ echo "checked";} ?>> Famale

						</div>

						<div class="form-group">
								<div class="col-xs-12"style="padding:0px;">
										<label class="label-left">Birth Of Date</label>
								</div>
								<div class="col-xs-4"style="padding:0px;width:100px;">
										<select  class="form-control input-md js-example-basic-single"data-live-search="true" name="day" required >
											<option value="" <?php if($row->member_dob == null and $row->member_dob == '0000-00-00'){echo 'selected="selected"';}?>  data-tokens="">--Day--</option>
											<?php
											$i=1;
											while ($i <= 31) {?>
														<option value="<?php echo $i ?>" <?php if(date("d",strtotime($row->member_dob)) == $i){echo 'selected="selected"';}?> data-tokens="<?php if($i < 10){echo "0$i";}else{echo $i;} ?>">
													  <?php if($i < 10){echo "0$i";}else{echo $i;} ?></option>
											<?php
											$i++; }
											?>
									 </select>
							 </div>
							 <div class="col-xs-4"style="padding:0px;width:100px;">
									 <select class="form-control js-example-basic-single"  data-live-search="true" name="month" required >
											<option value="" <?php if($row->member_dob == null and $row->member_dob == '0000-00-00'){echo 'selected="selected"';}?> data-tokens="">--Month--</option>
											<option value="1"<?php if(date("m",strtotime($row->member_dob)) == 1){echo 'selected="selected"';}?> data-tokens="January" >January</option>
											<option value="2"<?php if(date("m",strtotime($row->member_dob)) == 2){echo 'selected="selected"';}?> data-tokens="February">February</option>
											<option value="3" <?php if(date("m",strtotime($row->member_dob)) == 3){echo 'selected="selected"';}?>data-tokens="March">March</option>
											<option value="4" <?php if(date("m",strtotime($row->member_dob)) == 4){echo 'selected="selected"';}?>data-tokens="April">April</option>
											<option value="5" <?php if(date("m",strtotime($row->member_dob)) == 5){echo 'selected="selected"';}?>data-tokens="Mei">Mei</option>
											<option value="6"<?php if(date("m",strtotime($row->member_dob)) == 6){echo 'selected="selected"';}?> data-tokens="Juny">Juny</option>
											<option value="7"<?php if(date("m",strtotime($row->member_dob)) == 7){echo 'selected="selected"';}?> data-tokens="July">July</option>
											<option value="8"<?php if(date("m",strtotime($row->member_dob)) == 8){echo 'selected="selected"';}?>data-tokens="August">August</option>
											<option value="9" <?php if(date("m",strtotime($row->member_dob)) == 9){echo 'selected="selected"';}?>data-tokens="September">September</option>
											<option value="10"<?php if(date("m",strtotime($row->member_dob)) == 10){echo 'selected="selected"';}?> data-tokens="October">October</option>
											<option value="11" <?php if(date("m",strtotime($row->member_dob)) == 11){echo 'selected="selected"';}?>data-tokens="November">November</option>
											<option value="12"<?php if(date("m",strtotime($row->member_dob)) == 12){echo 'selected="selected"';}?> data-tokens="December">December</option>
										</select>
								</div>
									 <div class="col-xs-4"style="padding:0px;width:100px;">
										<select class="form-control js-example-basic-single"  data-live-search="true" id="selectyear" name="year" required >
												<option value="" data-tokens="">--Year--</option>
										 </select>
								 </div>
							</div>

					</div>

				</div>
				<div class="col-xs-12" style="padding-top:5px;padding-bottom:5px;margin-top:20px;text-align:right; ">
					<div class="btn-group">
								<a href="{{url('user/profile')}}" class="btn  btn-default" type="button"  data-placement="top" data-toggle="tooltip" data-original-title="Back"><i class="fa fa-share"></i> Back</a>
								<button class="btn pull-right" style="background-color: #B2203D; color: white;" onclick="getshipping()" type="submit" data-original-title=""><i class="fa fa-save"></i> Save</button>
					</div>
				</div>
		 </form>
     </div>
  </div>
</div>

<script>
$(document).ready(function(){
	var start = 1900;
	var dateyear='{{$yearbirth}}';

	var end = new Date().getFullYear();
	var options = "";
	options +="<option value='' data-tokens=''>--Year--</option>"
	for(var year = end ; year >=start; year--){
		if(dateyear==year){
			var selected="selected";
		}else{
				var selected="";
		}
	options += "<option value="+ year +" "+selected+">"+ year +"</option>";

	}
document.getElementById("selectyear").innerHTML = options;


});
</script>
<script>
$("#img").change(function(){
	 readURL(this);
});

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
