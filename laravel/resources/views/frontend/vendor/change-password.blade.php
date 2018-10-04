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
input, textarea {
  font-size: 22px;
  display: block;
  width: 100%;
  height: 100%;
  padding: 5px 10px;
  background: none;
  background-image: none;
  border: 1px solid #666;
  color: #000;
  border-radius: 0;
  -webkit-transition: border-color .25s ease, box-shadow .25s ease;
  transition: border-color .25s ease, box-shadow .25s ease;
}
input:focus, textarea:focus {
  outline: 0;
  border-color: #000;
}

textarea {
  border: 2px solid #666;
  resize: vertical;
}

.field-wrap {
  position: relative;
  margin-bottom: 40px;
}

.top-row:after {
  content: "";
  display: table;
  clear: both;
}
@media(min-width: 768px){
	.top-row > div {
	  float: left;
	  width: 60%;
	  margin-right: 4%;
	}
}
@media (max-width: 765px){
	.main-content .container {
	    padding-top: 0px;
	   padding-left: 15px;
	   padding-right:15px;
	}
}


.top-row > div:last-child {
  margin: 0;
}

.button {
  border: 0;
  outline: none;
  border-radius: 0;
  padding: 15px 0;
  /*font-size: 2rem;*/
  /*font-weight: 600;*/
  text-transform: uppercase;
  letter-spacing: .1em;
  background: #B2203D;
  color: #ffffff;
  -webkit-transition: all 0.5s ease;
  transition: all 0.5s ease;
  -webkit-appearance: none;
}
.button:hover, .button:focus {
	background: #fff;
	text-decoration: none;
	border:1px solid #B2203D;
	color: #B2203D;
}

.button-block {
  display: block;
  width: 100%;
}
</style>
<title>E-Commerce Djaring.id | Change Password</title>
<div class="col-md-9 box-right">


  <div class="panel panel-default panel-contact" >
    <div class="panel-heading panel-heading-custom2"><span style="color:#333">Change</span> Password</div>
    <div class="panel-body">
      @if(Session::has('success'))
      <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <!-- <h4>  <i class="icon fa fa-check"></i> Alert!</h4> -->
          {{ Session::get('success') }}
      </div>
      @endif
       @if(Session::get('error_get'))
         <div class="alert alert-danger col-md-12 col-sm-12">
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
       <div class="alert alert-danger">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
         @foreach($errors->all() as $error)
         <?php echo $error."</br>";?>
         @endforeach
       </div>
       @endif
      <form action="{{url('vendor/change-password')}}" method="post" id="accountData">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="top-row">
          <div class="field-wrap">
            <label>
              Current Password<span class="req">*</span>
            </label>
            <input type="password"  class="pw" required autocomplete="off" name="currentpassword"/>
          </div>
         <div class="field-wrap">
           <label>
            New Password<span class="req">*</span>
           </label>
           <input type="password"  class="pw" required autocomplete="off" id="password" name="password"/>
         </div>
         <div class="field-wrap">
           <label>
            New Confirm Password<span class="req">*</span>
           </label>
           <input type="password"  class="pw" required autocomplete="off" name="confirpassword"/>
         </div>
           <div class="field-wrap"style="text-align:right;">
             <div class="btn-group">
               <a href="{{url('user/profile')}}" class="btn  btn-default" type="button"  data-placement="top" data-toggle="tooltip" data-original-title="Back"><i class="fa fa-share"></i> Back</a>
               <button class="btn pull-right" disable style="background-color: #B2203D; color: white;" type="submit" data-original-title=""><i class="fa fa-save"></i> Save</button>
           </div>
         </div>
      </div>
      </form>

  </div>
</div>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {

$('#accountData').validate({ // initialize the plugin
  rules: {
      currentpassword: {
          //checkPassword: true, // comment out for demo
          skip_or_fill_minimum: [3, ".pw"]
      },
      password: {
          //validChars: true, // comment out for demo
          //noSpace: true, // comment out for demo
          nowhitespace: true, // part of additional-methods file
          minlength: 5,
          skip_or_fill_minimum: [3, ".pw"]
      },
      confirpassword: {
          equalTo: "#password",
          skip_or_fill_minimum: [3, ".pw"]
      }
  },
  groups: {
      justaname: "passwordOrig password passwordSecond"
  },
  submitHandler: function (form) { // for demo
      alert('valid form submitted'); // for demo
      return false; // for demo
  }
});

});
</script>
@endsection
