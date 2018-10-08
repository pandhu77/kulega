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
        z-index: 1000;
        left: 0;
        background: -moz-linear-gradient(top, rgba(0,0,0,0) 0, rgba(0,0,0,0) 2%, rgba(0,0,0,0.9) 100%);
        background: -webkit-linear-gradient(top, rgba(0,0,0,0) 0, rgba(0,0,0,0) 2%, rgba(0,0,0,0.9) 100%);
        background: linear-gradient(to bottom, rgba(0,0,0,0) 0, rgba(0,0,0,0) 2%, rgba(0,0,0,0.9) 100%);
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
</style>
@endpush

<section id="content" style="background: #eee;">

    <div class="content-wrap" style="padding-top:0px;">

        <div class="container clearfix">

            <div style="padding:20px 0px;color:#a3a2a2;font-size:20px;">
                <h2>Help Sethu improve lives of Children with Autism</h2>
            </div>

            <div class="col-md-12 col-sm-12">
                
                <div class="col-md-8 col-sm-8 content-left-section">
                    
                    <div class="col-md-12 col-sm-12">
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
                    </div>

                    <div class="col-md-12 col-sm-12">
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
                </div>

                <div class="col-md-4 col-sm-4 content-right-section kt-campaign-details campaign-details-ab-uppersection main-actions clearfix">
                </div>

            </div>

        </div>

    </div>

    <!-- <button type="button" class="btn btn-info btn-lg" onclick="openmodal()">Open Modal</button> -->

</section><!-- #content end -->


@push('js')



@endpush

@endsection
