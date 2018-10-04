
@extends('backend/app')
@section('content')


<style>

@media (max-width: 768px){
   .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6{
      float: left;
  }
}



</style>
<title>System | Dashboard </title>

<?php $siteconfig = DB::table('cms_config')->first(); ?>

@if($siteconfig->type != 'ecommerce')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard_graph" style="background:transparent">

            <div class="row x_title">
                <div class="col-md-12">
                    <h4 style="text-align:center;"> WELCOME BACK </h4>
                </div>

            </div>
        </div>
    </div>
</div>

@else
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @if(Session::has('no-delete'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></h4>
            {{ Session::get('no-delete') }}
        </div>
        @endif
        @if($errors->all())
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></h4>
            @foreach($errors->all() as $error)
            <?php echo $error."</br>";?>
            @endforeach
        </div>
        @endif
        <div class="dashboard_graph" style="background:transparent">

            <div class="row x_title">
                <div class="col-md-12">
                    <h4>  <i class="fa fa-shopping-bag"></i> ORDER MANAGEMENT<small> Order status </small></h4>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="row tile_count">

    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-shopping-bag "></i> NEW ORDER</span>
        <div class="count" style="color:#f0ad4e;">{{$newcount}}</div>
        <span class="count_bottom"><a href="{{url('backend/recent-order/new')}}" style="color:#f0ad4e;">Show Now</a></span>
    </div>

    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-spinner"></i> PROCESSING</span>
        <div class="count blue">{{$procescount}}</div>
        <span class="count_bottom"><a href="{{url('backend/recent-order/processing')}}" class="green">Show Now</a></span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> READY TO SEND / PICKUP</span>
        <div class="count">{{$sendcount}}</div>
        <span class="count_bottom"><a href="{{url('backend/recent-order/ready')}}" class="">Show Now</a></span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-bus" aria-hidden="true"></i> IN DELIVERY</span>
        <div class="count " style="color:#DA70D6">{{$deliverycount}}</div>
        <span class="count_bottom"><a href="{{url('backend/recent-order/in-delivery')}}" style="color:#DA70D6">Show Now</a></span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-check-square-o" aria-hidden="true"></i> COMPLETED(SEND)</span>
        <div class="count green ">{{$completcount}}</div>
        <span class="count_bottom"><a href="{{url('backend/recent-order/completed')}}" class="green">Show Now</a></span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-times" aria-hidden="true"></i>  Canceled</span>
        <div class="count red">{{$cancelcount}}</div>
        <span class="count_bottom"><a href="{{url('backend/recent-order/canceled')}}" class="red">Show Now</a></span>
    </div>
</div>
<!-- /top tiles -->


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard_graph" style="background:transparent">

            <div class="row x_title">
                <div class="col-md-12">
                    <h4>  <i class="fa fa-money"></i> PAYMENT MANAGEMENT<small> Payment Status</small></h4>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="row tile_count">

    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-exchange" aria-hidden="true"></i> WAITING PAYMENT</span>
        <div class="count" style="color:#f0ad4e;">{{$waiting}}</div>
        <span class="count_bottom"><a href="{{url('backend/recent-order/waiting-payment')}}" style="color:#f0ad4e;">Show Now</a></span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-share" aria-hidden="true"></i> WAITING CONFIRMATION </span>
        <div class="count">{{$confir}}</div>
        <span class="count_bottom"><a href="{{url('backend/recent-order/confirm-payment')}}" class="">Show Now</a></span>
    </div>

    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-check-circle" aria-hidden="true"></i> ACCEPTED</span>
        <div class="count green">{{$acp}}</div>
        <span class="count_bottom"><a href="{{url('backend/recent-order/accepted-payment')}}" class="green">Show Now</a></span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>  FAILED</span>
        <div class="count red">{{$failed}}</div>
        <span class="count_bottom"><a href="{{url('backend/recent-order/failed-payment')}}" class="red">Show Now</a></span>
    </div>

</div>
@endif

@endsection
