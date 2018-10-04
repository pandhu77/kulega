@extends('app')
@section('content')
<style>
	a {
  text-decoration: none;
  color: #000;
  -webkit-transition: .5s ease;
  transition: .5s ease;
}
a:hover {
  color: #179b77;
}

.form {
  background: #fff;
  padding: 20px;
  max-width: 600px;
  margin: 40px auto;
  border-radius: 1px;
  box-shadow: 0 4px 10px 4px rgba(19, 35, 47, 0.3);
}

.tab-group {
  list-style: none;
  padding: 0;
  margin: 0 0 40px 0;
}
.tab-group:after {
  content: "";
  display: table;
  clear: both;
}
.tab-group li a {
  display: block;
  text-decoration: none;
  padding: 15px;
  background: rgba(160, 179, 176, 0.25);
  color: #a0b3b0;
  font-size: 20px;
  float: left;
  width: 50%;
  text-align: center;
  cursor: pointer;
  -webkit-transition: .5s ease;
  transition: .5s ease;
}
.tab-group li a:hover {
  background: #B2203D;
  color: #ffffff;
}
.tab-group .active a {
  background: #B2203D;
  color: #ffffff;
}

.tab-content > div:last-child {
  display: none;
}

h1 {
  text-align: center;
  color: #000;
  font-weight: 300;
  margin: 0 0 40px;
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
	  width: 48%;
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

.forgot {
  margin-top: -20px;
  text-align: right;
}

</style>
<title>{{web_name()}} | Reset Password</title>
<div class="container">

	<div class="form">
      <div class="tab-content">
				@if(Session::get('signupsuccess'))
			        <div class="alert alert-success">
			          <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			          {{ Session::get('signupsuccess') }}
			        </div>
			   @endif

				 @if(Session::get('successchangepass'))
					 <div class="alert alert-success">
						 <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
						 {{ Session::get('successchangepass') }}
					 </div>
				 @endif
				 @if(Session::get('geterror'))
					 <div class="alert alert-success">
						 <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
						 {{ Session::get('geterror') }}
					 </div>
				 @endif

				 @if(Session::get('error_get'))
				 <div class="alert alert-danger">
					 <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					 {{ Session::get('error_get') }}
				 </div>
				 @endif
				 @if($errors->all())
					<div class="alert alert-danger">
						<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
							@foreach($errors->all() as $error)
									<?php echo $error."</br>";?>
							@endforeach

					</div>
				@endif


          <h1>Reset Password !</h1>
          @if(count($check) > 0)
					 <?php $token= request()->segment(3);?>
          <form action="{{url('user/new-password/'.$token)}}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="field-wrap">
              <label>
                 New Password<span class="req">*</span>
              </label>
              <input type="password" required autocomplete="off" name="member_password" value=""/>
            </div>
            <div class="field-wrap">
              <label>
                Confirm New Password<span class="req">*</span>
              </label>
              <input type="password" required autocomplete="off" name="retypepassword"/>
            </div>

            <button type="submit" class="button button-block"/>Reset Password</button>
          </form>
          @else
            <p style="text-align:center">Link change you password has expired.</p>
            <p style="text-align:center">We are to repeat the procedure forgot password</p>
          @endif
      </div><!-- tab-content -->

</div> <!-- /form -->
</div>

@endsection
