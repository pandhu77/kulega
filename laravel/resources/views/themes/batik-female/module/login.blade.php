<div class="accordion accordion-lg divcenter nobottommargin clearfix" style="max-width: 550px;">

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

    <div class="acctitle"><i class="acc-closed icon-lock3"></i><i class="acc-open icon-unlock"></i>Login to your Account</div>
    <div class="acc_content clearfix">
        <?php
        $redirect = "";
        if(isset($_GET['redirect'])){
            $redirect = $_GET['redirect'];
        }
        ?>
        <form id="login-form" name="login-form" class="nobottommargin" action="{{ url('user/login?redirect='.$redirect) }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col_full">
                <label for="login-form-username">Email</label>
                <input type="email" id="login-form-username" name="email" value="" class="form-control" required/>
            </div>

            <div class="col_full">
                <label for="login-form-password">Password</label>
                <input type="password" id="login-form-password" name="password" value="" class="form-control" required/>
            </div>

            <div class="col_full nobottommargin">
                <button type="button" class="button button-3d button-black nomargin btn-token" id="login-form-submit" name="login-form-submit" value="login" onclick="gettoken('login-form')">Login</button>
                <!-- <a href="#" class="fright">Forgot Password?</a> -->
            </div>
        </form>
    </div>

    <div class="acctitle"><i class="acc-closed icon-user4"></i><i class="acc-open icon-ok-sign"></i>New Signup? Register for an Account</div>
    <div class="acc_content clearfix">
        <form id="register-form" name="register-form" class="nobottommargin" action="{{ url('user/register') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col_full">
                <label for="register-form-name">Fullname</label>
                <input type="text" id="register-form-name" name="member_fullname" value="{{ old('member_fullname') }}" class="form-control" />
            </div>

            <div class="col_full">
                <label for="register-form-email">Email Address</label>
                <input type="email" id="register-form-email" name="member_email" value="{{ old('member_email') }}" class="form-control" />
            </div>

            <div class="col_full">
                <label for="register-form-email">Address</label>
                <textarea name="member_address" class="form-control" rows="4">{{ old('member_address') }}</textarea>
            </div>

            <div class="col_full">
                <label for="register-form-email">Phone</label>
                <input type="text" id="register-form-phone" name="member_phone" value="{{ old('member_phone') }}" class="form-control" />
            </div>

            <div class="col_full">
                <label for="register-form-password">Choose Password</label>
                <input type="password" id="register-form-password" name="member_password" value="" class="form-control" />
            </div>

            <div class="col_full">
                <label for="register-form-repassword">Re-enter Password</label>
                <input type="password" id="register-form-repassword" name="confpass" value="" class="form-control" />
            </div>

            <div class="col_full nobottommargin">
                <button type="button" class="button button-3d button-black nomargin" id="register-form-submit" name="register-form-submit" value="register" onclick="gettoken('register-form')">Register Now</button>
            </div>
        </form>
    </div>

</div>

<script type="text/javascript">
    function gettoken(id){
        $('[name=_token]').val('{{ csrf_token() }}');
        $('#'+id).submit();
    }
</script>
