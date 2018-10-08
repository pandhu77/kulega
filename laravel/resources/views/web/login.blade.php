@extends('web.master')
@section('title','www.kulega.com')
@section('content')

@push('css')

@endpush

<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <div class="tabs divcenter nobottommargin clearfix" id="tab-login-register" style="max-width: 500px;">

                <ul class="tab-nav tab-nav2 center clearfix">
                    <li class="inline-block"><a href="#tab-login">Login</a></li>
                    <li class="inline-block"><a href="#tab-register">Register</a></li>
                </ul>

                <div class="tab-container">

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

                    <div class="tab-content clearfix" id="tab-login">
                        <div class="panel panel-default nobottommargin">
                            <div class="panel-body" style="padding: 40px;">

                                <?php
                                    $redirect = "";
                                    if(isset($_GET['redirect'])){
                                        $redirect = $_GET['redirect'];
                                    }
                                ?>

                                <form id="login-form" name="login-form" class="nobottommargin" action="{{ url('user/login?redirect='.$redirect) }}" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <h3>Login to your Account</h3>

                                    <div class="col_full">
                                        <label for="login-form-username">Email:</label>
                                        <input type="text" id="login-form-username" name="email" value="" class="form-control" required=""/>
                                    </div>

                                    <div class="col_full">
                                        <label for="login-form-password">Password:</label>
                                        <input type="password" id="login-form-password" name="password" value="" class="form-control" required=""/>
                                    </div>

                                    <div class="col_full nobottommargin" style="text-align:right;">
                                        <button class="button button-3d button-black nomargin" id="login-form-submit" name="login-form-submit" value="login">Login</button>
                                        <!-- <a href="#" class="fright">Forgot Password?</a> -->
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content clearfix" id="tab-register">
                        <div class="panel panel-default nobottommargin">
                            <div class="panel-body" style="padding: 40px;">
                                <h3>Register for an Account</h3>

                                <form id="register-form" name="register-form" class="nobottommargin" action="{{ url('user/register') }}" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="col_full">
                                        <label for="register-form-name">Fullname:</label>
                                        <input type="text" id="register-form-name" name="member_fullname" value="{{ old('member_fullname') }}" class="form-control" />
                                    </div>

                                    <div class="col_full">
                                        <label for="register-form-email">Email:</label>
                                        <input type="text" id="register-form-email" name="member_email" value="" class="form-control" />
                                    </div>

                                    <!-- <div class="col_full">
                                        <label for="register-form-username">Address:</label>
                                        <textarea name="member_address" class="form-control" rows="4">{{ old('member_address') }}</textarea>
                                    </div>

                                    <div class="col_full">
                                        <label for="register-form-phone">Phone:</label>
                                        <input type="text" id="register-form-phone" name="member_phone" value="{{ old('member_phone') }}" class="form-control" />
                                    </div> -->

                                    <div class="col_full">
                                        <label for="register-form-password">Choose Password:</label>
                                        <input type="password" id="register-form-password" name="member_password" value="" class="form-control" />
                                    </div>

                                    <div class="col_full">
                                        <label for="register-form-repassword">Re-enter Password:</label>
                                        <input type="password" id="register-form-repassword" name="confpass" value="" class="form-control" />
                                    </div>

                                    <div class="col_full nobottommargin" style="text-align:right;">
                                        <button class="button button-3d button-black nomargin" id="register-form-submit" name="register-form-submit" value="register">Register Now</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section><!-- #content end -->

@push('js')
<script type="text/javascript">
    function gettoken(id){
        $('[name=_token]').val('{{ csrf_token() }}');
        $('#'+id).submit();
    }
</script>
@endpush

@endsection
