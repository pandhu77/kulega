@extends('frontend/member/menu')
@section('isi')
<style>

</style>
<title>{{web_name()}} || Profil</title>

  <div class="col-md-9 box-right">
    <h1>Update<span style="color:#B2203D"> Shipping</span> </h1>
    <hr>
    <form action="{{ url('user/updateshipping')}}" method="post" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
      <input type="hidden" class="form-control" placeholder="User Name" name="member_id" value="<?php echo Session::get('memberid');?>">
      <input type="hidden" class="form-control" id="province2" name="province2" value="{{$ship->province}}">
      <input type="hidden" class="form-control" id="city2" name="city2"value="{{$ship->city}}">
      <input type="hidden" class="form-control" id="subdistrict2" name="subdistrict2"value="{{$ship->subdistrict}}">
      <input type="hidden" class="form-control" name="addressid"value="{{$ship->adress_id}}">

    <div class="form-group">
      <label for="email">Set This Address As</label>
      <input type="text" class="form-control" id="title" name="title" required="" value="<?php echo $ship->title;?>">
    </div>
    <div class="form-group">
      <label for="email">Recipient Name *</label>
      <input type="text" class="form-control" id="recipname" name="recipname" required="" value="<?php echo $ship->recipentname;?>">
    </div>
    <div class="form-group">
      <label for="email">Address</label>
      <textarea class="form-control" id="address" name="address" required="" value=""><?php echo $ship->address;?></textarea>
    </div>
    <div class="form-group">
      <label for="email">Phone Number *</label>
      <input type="text" class="form-control" name="phone" required="" value="<?php echo $ship->phone_number;?>">
    </div>
    <div class="form-group">
      <label for="email">Email Address *</label>
      <input type="text" class="form-control" name="email" required="" value="<?php echo $ship->email;?>">
    </div>
    <div class="form-group">
      <label for="email">Postal Code *</label>
      <input type="text" class="form-control" id="post_code" name="post_code" required="" value="<?php echo $ship->post_code;?>">
    </div>
    <div class="form-group valid">
        <div id="shippingprovince">
            <div class="row" id="loadingprov" >
                <div class="col-md-12 text-center">
                    <img src="{{ asset('assets/img/web/small_loading.gif') }}" alt="loading">
                    <input type="hidden" class="form-control"  placeholder="Postal Code"name="province"  required="" value="">
                </div>
            </div>
        </div>
    </div>
    <div class="form-group valid">
        <div id="shippingcity">
            <div class="row" id="loadingcit" style="display: none;">
                <div class="col-md-12 text-center">
                    <img src="{{ asset('assets/img/web/small_loading.gif') }}" alt="loading">
                    <input type="hidden" class="form-control"  placeholder="Postal Code"name="city"  required="" value="">
                </div>
            </div>
        </div>
    </div>
    <div class="form-group valid">
        <div id="shippingsubdistrict">
            <div class="row" id="loadingsub" style="display: none;">
                <div class="col-md-12 text-center">
                    <img src="{{ asset('assets/img/web/small_loading.gif') }}" alt="loading">
                    <input type="hidden" class="form-control"  placeholder="Postal Code"name="subdistrict"  required="" value="">
                </div>
            </div>
        </div>
   </div>

    <div class="col-md-12"style="padding-left:0px;padding-right:0px;text-align:right">
      <div class="btn-group">
        <a href="{{url('user/my-shipping')}}" class="btn  btn-default" type="button"  data-placement="top" data-toggle="tooltip" data-original-title="Back"><i class="fa fa-share"></i> Back</a>
        <button class="btn pull-right" style="background-color: #B2203D; color: white;" onclick="getshipping()" type="submit" data-original-title=""><i class="fa fa-save"></i> Save</button>
      </div>
    </div>


  </div>
</form>

<script>
function getshipping(){
  var province=$('#province option:selected').text();
  var city=$('#city option:selected').text();
  var subdistrict=$('#subdistrict option:selected').text();
  $('#province2').val(province);
  $('#city2').val(city);
  $('#subdistrict2').val(subdistrict);

}
</script>

<script>
$(document).ready(function() {
    //Fungsi untuk Shipping
        getprovince2();


});
</script>
<script>
function getprovince(){
  //Fungsi untuk Shipping
  var token = "{{ csrf_token() }}";
  var dataString = '_token=' + token;
  //var dataString = '_token='+token +' &k_tujuan=' + k_tujuan;
  $.ajax({
      type: "POST",
      url: "{{ url('ajax/shippingprovince') }}",
      data: dataString,

      success: function(data) {
          $('#shippingprovince').html(data);
          get_city();
      }
  });
  //settimeout();
}
//Ajax untuk nampilkan kota
function get_city() {

    $('#loadingcit').fadeIn();
    //Fungsi untuk Shipping
    var token = "{{ csrf_token() }}";
    var province = $('#province').val();
    var provincename = $("#province").find('option:selected').attr("data-name");

    var dataString = '_token=' + token + '&province=' + province + '&provincename=' + provincename;
    // var dataString = '_token='+ token +' &province=' + province;
    $.ajax({
        type: "POST",
        url: "{{ url('ajax/shippingcity') }}",
        data: dataString,
        success: function(data) {
            $('#shippingcity').html(data);
            getSubDistrict();
        }
    });
}
//Ajax untuk mempilkan harga


//Ajax untuk mempilkan city
function getSubDistrict() {
    $('#loadingsub').fadeIn();
    var token ="{{ csrf_token() }}";
    var city = $('#city').val();
    var cityname = $("#city").find('option:selected').attr("data-name");

    var dataString = '_token=' + token + '&city=' + city + '&cityname=' + cityname;
    $.ajax({
        type: "POST",
        url: "{{ url('ajax/shippingsubdistrict') }}",
        data: dataString,
        success: function(data) {
            $('#shippingsubdistrict').html(data);
            // alert(data);
            get_cost();
        }
    });
}
function getprovince2(){


  //Fungsi untuk Shipping
  var token = "{{ csrf_token() }}";
  var addid ="{{$ship->adress_id}}";

  var dataString = '_token=' + token;
  //var dataString = '_token='+token +' &k_tujuan=' + k_tujuan;
  $.ajax({
      type: "POST",
      url: "{{ url('ajax/shippingprovince2') }}"+"/"+addid,
      data: dataString,

      success: function(data) {
          $('#shippingprovince').html(data);
          get_city2();
      }
  });
  //settimeout();
}
function get_city2() {

    $('#loadingcit').fadeIn();
    //Fungsi untuk Shipping
    var token = "{{ csrf_token() }}";
    var province = $('#province').val();

    var provincename = $("#province").find('option:selected').attr("data-name");
    var dataString = '_token=' + token + '&province=' + province + '&provincename=' + provincename;
    var addid ="{{$ship->adress_id}}";
    // var dataString = '_token='+ token +' &province=' + province;
    $.ajax({
        type: "POST",
        url: "{{ url('ajax/shippingcity2') }}"+"/"+addid,
        data: dataString,
        success: function(data) {
            $('#shippingcity').html(data);
            getSubDistrict2();
        }
    });
}


//Ajax untuk mempilkan city
function getSubDistrict2() {
    $('#loadingsub').fadeIn();
    var token ="{{ csrf_token() }}";
    var city = $('#city').val();
    var cityname = $("#city").find('option:selected').attr("data-name");

    var dataString = '_token=' + token + '&city=' + city + '&cityname=' + cityname;
    var addid ="{{$ship->adress_id}}";

    $.ajax({
        type: "POST",
        url: "{{ url('ajax/shippingsubdistrict2') }}"+"/"+addid,
        data: dataString,
        success: function(data) {
            $('#shippingsubdistrict').html(data);

        }
    });
}
</script>

@endsection
