<!DOCTYPE html>

<!-- CANVAS LOGIN DESIGN -->
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="SemiColonWeb" />

	<!-- Stylesheets
	============================================= -->
	<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="{{ asset('laravel/resources/views/themes/batik-female/css/bootstrap.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('laravel/resources/views/themes/batik-female/css/style.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('laravel/resources/views/themes/batik-female/css/dark.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('laravel/resources/views/themes/batik-female/css/font-icons.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('laravel/resources/views/themes/batik-female/css/animate.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('laravel/resources/views/themes/batik-female/css/magnific-popup.css') }}" type="text/css" />

	<link rel="stylesheet" href="{{ asset('laravel/resources/views/themes/batik-female/css/responsive.css') }}" type="text/css" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<!-- Document Title
	============================================= -->
	<title>Backend Login | I Am Addicted</title>

</head>

<body class="stretched">

    <?php $site = DB::table('cms_config')->first(); ?>

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">

		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap nopadding">

				<div class="section nopadding nomargin" style="width: 100%; height: 100%; position: absolute; left: 0; top: 0; background: #444;"></div>

				<div class="section nobg full-screen nopadding nomargin">
					<div class="container vertical-middle divcenter clearfix">

						<div class="row center" style="margin-bottom:40px;">
							<a href="{{ url('/') }}">
                                <img src="{{ asset($site->logo) }}" alt="Canvas Logo">
                            </a>
						</div>

						<div class="panel panel-default divcenter noradius noborder" style="max-width: 400px;">
							<div class="panel-body" style="padding: 40px;">
								<form id="login-form" name="login-form" class="nobottommargin" action="{{ url('/login') }}" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
									<h3>Login to your Account</h3>

									<div class="col_full">
										<label for="login-form-username">Email:</label>
										<input type="text" id="login-form-username" name="email" value="" class="form-control not-dark" required/>
                                        @if ($errors->has('email'))
                                        <span class="help-block" style="color:red;">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
									</div>

									<div class="col_full">
										<label for="login-form-password">Password:</label>
										<input type="password" id="login-form-password" name="password" value="" class="form-control not-dark" required/>
                                        @if ($errors->has('password'))
                                        <span class="help-block" style="color:red;">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
									</div>

									<div class="col_full nobottommargin">
										<button class="button button-3d button-black nomargin" id="login-form-submit" name="login-form-submit" value="login">Login</button>
										<!-- <a href="#" class="fright">Forgot Password?</a> -->
									</div>
								</form>
							</div>
						</div>

						<!-- <div class="row center dark"><small>Copyrights &copy; All Rights Reserved by Canvas Inc.</small></div> -->

					</div>
				</div>

			</div>

		</section><!-- #content end -->

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>

	<!-- External JavaScripts
	============================================= -->
	<script type="text/javascript" src="{{ asset('assets/web/js/jquery.js') }}"></script>
	<script type="text/javascript" src="{{ asset('laravel/resources/views/themes/batik-female/js/plugins.js') }}"></script>

	<!-- Footer Scripts
	============================================= -->
	<script type="text/javascript" src="{{ asset('laravel/resources/views/themes/batik-female/js/functions.js') }}"></script>

</body>
</html>
