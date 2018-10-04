<!-- Contact Form
============================================= -->
<div class="col-md-offset-2 col-md-8">

    <div class="fancy-title title-dotted-border">
        <h3>Send us an Email</h3>
    </div>

    <div class="">

        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissable col-sm-12" style="text-align:center;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('success') }}
            </div>
        @endif
        @if(Session::get('fail'))
            <div class="alert alert-dange col-md-12 col-sm-12" style="text-align:center;">
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                {{ Session::get('fail') }}
            </div>
        @endif

        <form action="{{ url('contact') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="col_one_third">
                <label for="template-contactform-name">Name <small>*</small></label>
                <input type="text" id="template-contactform-name" name="name" value="{{ old('name') }}" class="sm-form-control required" />
                @if($errors->has('name'))
                    <label class="control-label" for="inputError" style="color:red;">
                        <i class="fa fa-times-circle-o"></i>
                        {{ $errors->first('name') }}
                    </label>
                @endif
            </div>

            <div class="col_one_third">
                <label for="template-contactform-email">Email <small>*</small></label>
                <input type="email" id="template-contactform-email" name="email" value="{{ old('email') }}" class="required email sm-form-control" />
                @if($errors->has('email'))
                    <label class="control-label" for="inputError" style="color:red;">
                        <i class="fa fa-times-circle-o"></i>
                        {{ $errors->first('email') }}
                    </label>
                @endif
            </div>

            <div class="col_one_third col_last">
                <label for="template-contactform-phone">Phone</label>
                <input type="text" id="template-contactform-phone" name="phone" value="{{ old('phone') }}" class="sm-form-control" />
            </div>

            <div class="clear"></div>

            <div class="col_full">
                <label for="template-contactform-subject">Subject <small>*</small></label>
                <input type="text" id="template-contactform-subject" name="subject" value="{{ old('subject') }}" class="sm-form-control" />
            </div>

            <div class="clear"></div>

            <div class="col_full">
                <label for="template-contactform-message">Message <small>*</small></label>
                <textarea class="sm-form-control" id="template-contactform-message" name="message" rows="6" cols="30">{{ old('message') }}</textarea>
            </div>

            <div class="col_full">
                <button name="submit" type="submit" tabindex="5" value="Submit" class="button nomargin">Submit Comment</button>
            </div>

        </form>
    </div>

</div><!-- Contact Form End -->

<div class="clear"></div>
