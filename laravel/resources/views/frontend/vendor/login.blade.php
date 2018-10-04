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

/*label {
  position: absolute;
  -webkit-transform: translateY(6px);
          transform: translateY(6px);
  left: 13px;
  color: #000;
  -webkit-transition: all 0.25s ease;
  transition: all 0.25s ease;
  -webkit-backface-visibility: hidden;
  pointer-events: none;
  font-size: 15px;
}
label .req {
  margin: 2px;
  color: #B2203D;
}

label.active {
  -webkit-transform: translateY(50px);
          transform: translateY(50px);
  left: 2px;
  font-size: 14px;
}
label.active .req {
  opacity: 0;
}

label.highlight {
  color: #000;
}*/

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

.social-login{
    height: 100%;
    padding-left: 15px;
    padding-right: 15px;
  }

  @media(max-width:768px){
    .social-login .social-btn{
      padding-top: 25px;
      padding-bottom: 25px;

    }
  }
  @media(min-width:768px){
    .social-login .social-btn{
      padding-top: 50px;
      padding-bottom: 50px;
    }
  }
	.btn-facebook, .btn-facebook:hover{
		background: #4286c1;
		color: #fff;
		margin-bottom: 15px;
	}
	.btn-google, .btn-google:hover{
		background: #f26039;
		color: #fff;
		margin-bottom: 15px;
	}

</style>
<title>E-Commerce Djaring.id | Login</title>
<div class="container">

	<div class="form">
<!--
      <ul class="tab-group">
        <li class="tab active" id="tablogin"><a href="#login">Log In</a></li>
        <li class="tab " id="tabsignup"><a href="#signup">Sign Up</a></li>
      </ul> -->

      <div class="tab-content">
				@if(Session::get('signupsuccess'))
			        <div class="alert alert-success">
			          <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			          {{ Session::get('signupsuccess') }}
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
				<div id="forgot" style="display:none;" >
					<h1>Forgot Password!</h1>

					<form action="{{url('vendor/forgot-password')}}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="field-wrap">
						<label>
							Email Address<span class="req">*</span>
						</label>
						<input type="email" name="emailforgot" required  autocomplete="off" />
					</div>
					<button type="submit" class="button button-block"/>Request a password</button>
					</form>

				</div>
        <div id="login">
          <h1>Vendors Login!</h1>

          <form action="{{url('vendor/login')}}" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input type="email"  name="email"  required  autocomplete="off"/>
          </div>

          <div class="field-wrap">
            <label>
              Password<span class="req">*</span>
            </label>
            <input type="password" name="password" required  autocomplete="off"/>
          </div>
					<!-- <div class="col-sm-10 col-sm-offset-1 social-login">
						<div class="social-btn">
							<a href="{{url('/redirect/facebook')}}" class="btn btn-default btn-facebook btn-block"><i class="fa fa-facebook"></i>&nbsp;&nbsp;Sign in with Facebook</a>
							<a href="{{url('/redirect/google')}}" class="btn btn-default btn-google btn-block"><i class="fa fa-google"></i> Sign in with Google</a>
						</div>
					</div> -->
          <p class="forgot"><a href="#forgot" onclick="getforgot()">Forgot Password?</a></p>

          <button type="submit" class="button button-block"/>Log In</button>

          </form>



        </div>
        <div id="signup">
					<!-- <h1>Sign Up for Free</h1>
          <form action="{{url('user/register')}}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

              <div class="field-wrap">
                <label>
                  Full Name<span class="req">*</span>
                </label>
                <input type="text" required  autocomplete="off" name="member_fullname" value="{{ old('member_fullname')}}" />
              </div>

            <div class="field-wrap">
              <label>
                Email Address<span class="req">*</span>
              </label>
              <input type="email" autocomplete="off" name="member_email" value="{{ old('member_email')}}"/>
            </div>
           <div class="top-row">
            <div class="field-wrap">
              <label>
                Set A Password<span class="req">*</span>
              </label>
              <input type="password" required autocomplete="off" name="member_password" value=""/>
            </div>
            <div class="field-wrap">
              <label>
                Confirm Password<span class="req">*</span>
              </label>
              <input type="password" required autocomplete="off" name="confpass"/>
            </div>
           </div>
					 <div class="col-sm-10 col-sm-offset-1 social-login">
						 <div class="social-btn">
							 <a href="{{url('/redirect/facebook')}}" class="btn btn-default btn-facebook btn-block"><i class="fa fa-facebook"></i>&nbsp;&nbsp;Sign in with Facebook</a>
							 <a href="{{url('/redirect/google')}}" class="btn btn-default btn-google btn-block"><i class="fa fa-google"></i> Sign in with Google</a>
						 </div>
					 </div>
            <button type="submit" class="button button-block"/>Get Started</button>
          </form> -->

        </div>


      </div><!-- tab-content -->

</div> <!-- /form -->
</div>
<script>

 function getforgot(){
	  $('#forgot').css('display','block');
		$('#tablogin').removeClass('active');//remove active class
		$('#login').css('display','none');

}
$(document).ready(function () {
    if (window.location.hash == '#forgot') {
			$('#forgot').css('display','block');
			$('#tablogin').removeClass('active');//remove active class
			$('#login').css('display','none');
    }
});
// $(document).ready(function () {
//     if (window.location.hash == '#signup') {
// 			$('#tablogin').removeClass('active');//remove active class
//       $('#login').css('display','none');
//       $('#tabsignup').addClass('active');
//       $('#signup').css('display','block');
//     }
// });


	$('.form').find('input, textarea').on('keyup blur focus', function (e) {

  var $this = $(this),
      label = $this.prev('label');

	  if (e.type === 'keyup') {
			if ($this.val() === '') {
          label.removeClass('active highlight');
        } else {
          label.addClass('active highlight');
        }
    } else if (e.type === 'blur') {
    	if( $this.val() === '' ) {
    		label.removeClass('active highlight');
			} else {
		    label.removeClass('highlight');
			}
    } else if (e.type === 'focus') {

      if( $this.val() === '' ) {
    		label.removeClass('highlight');
			}
      else if( $this.val() !== '' ) {
		    label.addClass('highlight');
			}
    }

});

$('.tab a').on('click', function (e) {

  e.preventDefault();

  $(this).parent().addClass('active');
  $(this).parent().siblings().removeClass('active');

  target = $(this).attr('href');

  $('.tab-content > div').not(target).hide();

  $(target).fadeIn(600);

});
</script>
@endsection
