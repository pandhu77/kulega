@extends('web.master')
@section('title','www.kulega.com')
@section('content')

@push('css')
<link rel="stylesheet" href="{{ asset('template/web/plugins/kartik-v-bootstrap-star-rating-ca43ee3/css/star-rating.css') }}">
<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">

<style type="text/css">
@import url('https://fonts.googleapis.com/css?family=Noto+Sans');

    h2 {
        font-weight: 600;
        font-size: 28px;
        color: #444444;
        text-align: center;
    }

    .image {
        position: relative;
    }

    .image .short-desc.over-leaderboard-media {
        position: absolute;
        bottom: 0;
        color: #fff;
        padding: 40px 10px 10px 10px;
        width: 100%;
        z-index: 1;
        left: 0;
        background: -moz-linear-gradient(top, rgba(0,0,0,0) 0, rgba(0,0,0,0) 0%, rgba(0,0,0,0.9) 100%);
        background: -webkit-linear-gradient(top, rgba(0,0,0,0) 0, rgba(0,0,0,0) 0%, rgba(0,0,0,0.9) 100%);
        background: linear-gradient(to bottom, rgba(0,0,0,0) 0, rgba(0,0,0,0) 0%, rgba(0,0,0,0.9) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00000000', endColorstr='#e6000000', GradientType=0);
        margin: 0px;
    }

    ul.nav li {
        background-color: transparent;
        padding: 15px 19px 12px;
    }

    ul.nav li.active {
        border-bottom: 2px solid #00c5b5;
    }

    ul.nav li.active a {
        background: none;
        border: 0;
        font-weight: bold;
    }

    ul.nav li a {
        font-size: 16px;
        color: #333;
    }

    ul.nav li a:hover {
        background: none;
        border: 0;
        color: #00c5b5;
    }

    ul.nav li a:focus {
        background: none;
        border: 0;
        color: #00c5b5;
    }

    ul.nav li.active a:hover {
        background: none;
        border: 0;
    }

    .kulega {
        background: #fff;
    }

    .description {
        padding: 20px 30px;
        font-size: 14px;
        color: #333;
        font-family: 'Noto Sans',sans-serif;
    }

    .description p {
        margin: 0px;
    }

    .main-actions {
        margin-bottom: 10px;
    }

    .content-right-section p.contribute-button {
        margin: 0 0 1.5px !important;
        font-size: 22px;
        color: #FFFFFF;
        letter-spacing: 0;
    }

    .content-right-section .btn-contribute {
        text-transform: uppercase;
        box-shadow: 0 2px 10px 0 #018c8b;
        -moz-box-shadow: 0 2px 10px 0 #018c8b;
        -webkit-box-shadow: 0 2px 10px 0 #018c8b;
        -ms-box-shadow: 0 2px 10px 0 #018c8b;
        border-radius: 5px;
        background: #0fd3cd !important;
        color: #ffffff !important;
        border: 0px;
    }

    .content-right-section .btn-contribute:hover {
        background-color: #018c8b !important;
    }

    .btn-floating .btn-contribute h3 {
        margin: 0px;
        color: #fff;
        padding: 10px;
        font-size: 14px;
    }

    .btn-floatingx .btn-contribute h3 {
        margin: 0px;
        color: #fff;
        padding: 10px;
        font-size: 14px;
    }

    .content-right-section .btn-floating .btn-contribute {
        text-transform: uppercase;
        box-shadow: 0 2px 10px 0 #018c8b;
        -moz-box-shadow: 0 2px 10px 0 #018c8b;
        -webkit-box-shadow: 0 2px 10px 0 #018c8b;
        -ms-box-shadow: 0 2px 10px 0 #018c8b;
        border-radius: 5px;
        background: #0098ff !important;
        color: #ffffff !important;
        border: 0px;
        padding: 0px;
        width: 100%;
    }

    .content-right-section .btn-floating .btn-contribute:hover {
        background-color: #01548c !important;
    }

    .content-right-section .btn-floatingx .btn-contribute {
        text-transform: uppercase;
        box-shadow: 0 2px 10px 0 #018c8b;
        -moz-box-shadow: 0 2px 10px 0 #018c8b;
        -webkit-box-shadow: 0 2px 10px 0 #018c8b;
        -ms-box-shadow: 0 2px 10px 0 #018c8b;
        border-radius: 5px;
        background: #0fd3cd !important;
        color: #ffffff !important;
        border: 0px;
        padding: 0px;
        width: 100%;
    }

    .content-right-section .btn-floatingx .btn-contribute:hover {
        background-color: #018c8b !important;
    }

    p.contribute-button h3 {
        margin: 0px;
        color: #fff;
        padding: 10px;
    }

    .amount-raised {
        margin-bottom: 15px;
        padding-right: 0;
    }

    .amount-raised h2 {
        font-size: 32px;
        margin-top: 0;
        margin-bottom: 5px;
        padding: 0;
        font-family: 'Source Sans Pro',sans-serif;
        text-align: left;
        font-weight: normal;
        height: 55px;
    }

    .amount-raised h2.kt-campaign-backers {
        font-size: 28px;
        display: inline-block;
        padding: 0;
        vertical-align: sub;
    }

    .amount-raised p.kt-campaign-backers {
        font-size: 16px;
        display: inline-block;
        padding: 0;
        margin: 0px;
        color: #777;
    }

    .backers {
        padding: 0;
    }

    .kt-campaign-details .btn-floating {
        position: fixed;
        width: 50%;
        z-index: 100;
        background: #FFF;
        bottom: 0;
        padding: 10px;
        left: 0;
        z-index: 115;
        margin-bottom: 0;
        border-top: 1px solid #eee; 
    }
    .kt-campaign-details .btn-floatingx {
        position: fixed;
        width: 50%;
        z-index: 100;
        background: #FFF;
        bottom: 0;
        padding: 10px;
        right: 0;
        z-index: 115;
        margin-bottom: 0;
        border-top: 1px solid #eee;
    }
</style>
@endpush

<section id="content" style="background: rgb(255,255,255);background: linear-gradient(180deg, rgba(255,255,255,1) 0%, rgba(238,238,238,1) 100%);">

    <div class="content-wrap" style="padding-top:0px;">

        <div class="container clearfix">

            <div style="padding:20px 0px;color:#a3a2a2;font-size:20px;">
                <h2>{{ $campaign->name }}</h2>
            </div>

            <div class="col-md-12 col-sm-12">
                
                <div class="col-md-8 col-sm-8 content-left-section">
                    
                        <div class="kulega">
                            <div class="image">
                                <img src="{{ url($campaign->image) }}" class="img-responsive">
                                <p class="short-desc over-leaderboard-media">
                                    {{ $campaign->name }}
                                </p>
                            </div>

                            <div class="menutab">
                                <ul class="nav nav-tabs">
                                  <li class="active"><a data-toggle="tab" href="#home" style="background: none; border: 0;"><i class="fa fa-globe" aria-hidden="true"></i> About</a></li>
                                  <li><a data-toggle="tab" href="#menu1" style="background: none; border: 0;"> <i class="fa fa-comments-o" aria-hidden="true"></i> Comments</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="kulega">
                            <div class="tab-content">
                                <div id="home" class="tab-pane fade in active">
                                    <div class="description">
                                        {!! $campaign->desc !!}
                                    </div>
                                </div>
                                <div id="menu1" class="tab-pane fade">
                                    <div class="description">
                                        <h3>Comment</h3>
                                        <p>Some content in menu 1.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="col-md-4 col-sm-4 content-right-section kt-campaign-details campaign-details-ab-uppersection main-actions clearfix">
                    <div class="top-donor-section">
                        <div class="clearfix main-actions">
                            <p class="hidden-xs contribute-button col-md-12" style="padding: 0;">
                                <button class="btn btn-lg btn-info text-center col-md-12 btn-contribute" id="donate" href="javascript:void(0);">
                                    <h3>
                                        <i class="fa fa-heart customHeart"></i> Donate Now
                                    </h3>
                                </button>
                            </p>
                            <p class="hidden-xs contribute-button col-md-12" style="padding: 0;margin-top: 15px !important;">
                                <button class="btn btn-lg btn-primary text-center col-md-12" onclick="location.href='{{ url('/products/') }}';" style="padding: 0px;">
                                    <h3 style="font-size: 22px;font-family: unset;">
                                        <i class="fa fa-shopping-cart customHeart"></i> Shop Now
                                    </h3>
                                </button>
                            </p>

                            <p class="col-md-12 btn-floating visible-xs">
                                <button class="btn btn-lg btn-info btn-contribute text-center" href="javascript:void(0);"  data-version="A" onclick="location.href='{{ url('/products/') }}';">
                                    <h3>
                                        <i class="fa fa-shopping-cart customHeart"></i> Shop Now
                                    </h3>
                                </button>
                            </p>
                            <p class="col-md-12 btn-floatingx visible-xs">
                                <button class="btn btn-lg btn-info btn-contribute text-center" href="javascript:void(0);" data-version="A">
                                    <h3>
                                        <i class="fa fa-heart customHeart"></i> Donate Now 
                                    </h3>
                                </button>
                            </p>
                        </div>
                    </div>
                    <div class="amount-raised-section">
                        <div class="amount-raised">
                            <h2><span style="font-size: 44px;font-weight: bold; color: #333;">Rp</span> <?php echo number_format($campaign->target,0,',','.'); ?></h2>
                            <p style="margin: 0px;">raised of <b>&nbsp;Rp. <?php echo number_format($campaign->target,0,',','.'); ?></b> goal</p>
                        </div>
                    </div>
                    <div class="progress ">
                        <div id="campaignProgressRaised" class="progress-bar" style="width:<?php echo round((0/$campaign->target)*100); ?>%"></div>
                    </div><!-- .progress -->
                    <div class="clearfix">
                        <div class="col-xs-6 amount-raised backers">
                            <h2 class="kt-campaign-backers">10</h2>
                            <p class="kt-campaign-backers">supporters</p>
                        </div>
                        <div class="col-xs-6 amount-raised ">
                            <h2 class="kt-campaign-backers">17</h2>
                            <p class="kt-campaign-backers">days left</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- <button type="button" class="btn btn-info btn-lg" onclick="openmodal()">Open Modal</button> -->

</section><!-- #content end -->


@push('js')
<script type="text/javascript">
jQuery(document).ready( function($){

    $('#donate').click(function(){
        swal("A wild Pikachu appeared! What do you want to do?")
        .then((value) => {
           swal('The returned value is: ${value}');
        });
    });

});
</script>
@endpush

@endsection
