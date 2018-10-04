@extends('frontend/member/menu')
@section('isi')
<style>

	.panel-default > .panel-heading-custom2{
  background-image: none;
  background-color: #f4f5f4;
  color: #B2203D;
  border-radius: 0px;
  height: 50px;
  padding-top: 12px;
  font-weight: bold;
  font-size: 18px;
}
.btn.btn--tiny {
    padding: 6px;
    border: 1px solid;
    font-size: 10px;
}
.btn.btn--secondary {
    background-color: #fff;
    color: #000;
    border-color: #000;
}

.rfloat {
    float: right;
}
</style>
<title>{{web_name()}} | Rewards</title>
<div class="col-md-9 box-right">
    @if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <!-- <h4>  <i class="icon fa fa-check"></i> Alert!</h4> -->
        {{ Session::get('success') }}
    </div>
    @endif
     @if(Session::get('error_get'))
       <div class="alert alert-dange col-md-12 col-sm-12">
         <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
         {{ Session::get('error_get') }}</div>
     @endif


  <div class="panel panel-default panel-contact" >
    <div class="panel-heading panel-heading-custom2"><span style="color:#333">Points</span> Information </div>
    <div class="panel-body" style="text-align:center;">

    <h4 style="font-weight: bold;">Your Points</h4> <img src="{{asset('assets/icon/points.png')}}"style="width:80px;"> <h2><span style="color:#B2203D">{{$member->member_points}}</span> 	Points</h2>
    </div>
  </div>
	<div class="panel panel-default panel-contact" >
		<div class="panel-heading panel-heading-custom2"><span style="color:#333">Rewards</span> Information </div>
		<div class="panel-body" style="text-align:center;">

		@if(count($bonus) >0)
		<div class="col-xs-12 table">
			<table class="table table-striped table tableresponsive">
				<thead>
					<tr>
						<th style="text-align:center;" width="15%">Points</th>
						<th style="text-align:center;" width="70%">Rewards from <span style="color:#B2203D"> your points</span></th>
					</tr>
				</thead>
				<tbody>
					@foreach($bonus as $reward)

					<tr>
						<td data-label="">
							  {{$reward->bonus_poin}}
						</td>
						<td data-label="" style="text-align:center;">
								@if($reward->bonus_reward=='nominal')<span class="price_format">{{$reward->bonus_value}}</span> @elseif($reward->bonus_reward=='precent') {{$reward->bonus_value}} % <span style="color:#B2203D">  of total shopping </span> @endif
						</td>

					</tr>
				@endforeach

				</tbody>
			</table>
			<p style="text-align:right;">Note: Points can be exchanged at checkout.</p>

		</div>
		@else
					<p>Rewards not available</p>
		@endif

		</div>
	</div>
</div>
@endsection
