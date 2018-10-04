@extends('app')
@section('content')
<link rel="stylesheet" href="{{asset('template/frontend/brand.css')}}">
<title>{{web_name()}} | brand</title>
<div class="container">
  <!-- /.section-title -->
  <div class="section-intro">
    <div class="col-sm-12 list-outer-title">
      <label class="brand-title">Bands List</label>
    </div >
    <span class="sep"></span>
    <div class="col-sm-12 col-body">
      @foreach($brand as $brands)
      <a href="{{url('brand/'.$brands->brand_url)}}">
        <div class="col-xs-12 col-sm-4 service-item  text-center" style="background-image:url({{$brands->brand_logo}});overflow:hidden;">
          <div class="service-inner"  >

          </div>
        </div>
      </a>
      @endforeach
    </div>
    <div class="col-md-12 col-xs-12 col-sm-12 more-brand">
      <a href="#" id="loadMore" style="#337ab7!important;"><span class="load-more"></span></a>
      <p class="totop">
          <a href="#top" style="display:none;"><span class="load-top"></span></a>
      </p>
    </div>

  </div>
</div>
</div>
<script src="{{asset('assets/js/frontend/loadmoreicon.js') }}"></script>
<script src="{{asset('template/frontend/js/brand.js') }}"></script>


@endsection
