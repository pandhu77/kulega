@extends('backend/app')
@section('content')

<style media="screen">
h4{
    border-bottom: transparent !important;
}

h4 a{
    text-decoration: underline;
}

.panel-default{
    border-radius: 0px !important;
}
</style>

<title>Intro | Jurnal</title>
<div class="page-title">
  <div class="title_left">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h3>Introduction</h3>
  </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>HOW TO USE JURNAL</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">

          <!-- CONTENT MAIL -->
          <div class="col-sm-12 mail_view">
            <div class="inbox-body">
              <div class="mail_heading row">

                <div class="col-md-12">

                    <div class="col-md-6">
                        <h4>1. Signin and Login at <a href="https://my.jurnal.id/" target="_blank">MY.JURNAL.ID</a></h4>
                        <img src="{{ asset('template/jurnal/jurnal-step1.JPG') }}" alt="Step 1" class="img-responsive">
                    </div>
                    <div class="col-md-6">
                        <h4>2. Install <a href="https://my.jurnal.id/appstore/djaring" target="_blank">Addon Djaring</a></h4>
                        <img src="{{ asset('template/jurnal/jurnal-step2.JPG') }}" alt="Step 2" class="img-responsive">
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-6">
                        <h4>3. Allow the addon</h4>
                        <img src="{{ asset('template/jurnal/jurnal-step3.JPG') }}" alt="Step 3" class="img-responsive">
                    </div>
                    <div class="col-md-6">
                        <h4>4. Open <a href="https://my.jurnal.id/authorize_apps/new?client_id=4c58013405bb48ed8639adfa46d21e64" target="_blank">Djaring Authorize Apps</a> and allow</h4>
                        <img src="{{ asset('template/jurnal/jurnal-step4.JPG') }}" alt="Step 4" class="img-responsive">
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-6">
                        <h4>5. Copy your jurnal access token</h4>
                        <img src="{{ asset('template/jurnal/jurnal-step4.JPG') }}" alt="Step 5" class="img-responsive">
                    </div>
                    <div class="col-md-6">
                        <h4>6. Input the access token in your jurnal management</h4>
                        <img src="{{ asset('template/jurnal/jurnal-step6.JPG') }}" alt="Step 6" class="img-responsive">
                    </div>
                    <div class="clearfix"></div>

                </div>
              </div>
            </div>

          </div>
          <!-- /CONTENT MAIL -->
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
