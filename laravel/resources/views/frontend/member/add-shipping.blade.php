@extends('frontend/member/menu')
@section('isi')
<style>

</style>
<title>{{web_name()}} || Profil</title>


<div class="col-md-9 box-right">
  <h1>Add<span style="color:#B2203D"> Shipping  </span> </h1>
  <hr>
  @if($errors->all())
  <div class="alert alert-danger">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    @foreach($errors->all() as $error)
    <?php echo $error."</br>";?>
    @endforeach
  </div>
  @endif
  <form action="{{ url('user/addshipping')}}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <input type="hidden" class="form-control" placeholder="User Name" name="member_id" value="">
      <input type="hidden" class="form-control" id="province" name="province" value="">
      <input type="hidden" class="form-control" id="city" name="city"value="">
      <input type="hidden" class="form-control" id="subdistrict" name="subdistrict"value="">
    <div class="form-group">
      <label for="email">Set This Address As</label>
      <input type="text" class="form-control" id="title" name="title" required="" value="">
    </div>
    <div class="form-group">
      <label for="email">Recipient Name *</label>
      <input type="text" class="form-control" id="recipname" name="recipname" required="" value="">
    </div>
    <div class="form-group">
      <label for="email">Address</label>
      <textarea class="form-control" id="address" name="address" required="" value=""></textarea>
    </div>
    <div class="form-group">
      <label for="email">Phone Number *</label>
      <input type="text" class="form-control" name="phone" required="" value="">
    </div>
    <div class="form-group">
      <label for="email">Email Address *</label>
      <input type="email" class="form-control" name="email" required="" value="">
    </div>
    <div class="form-group">
      <label for="email">Postal Code *</label>
      <input type="text" class="form-control" id="post_code" name="post_code" required="" value="">
    </div>

    <div class="form-group valid">
        <div id="bilingprovince">
            <div class="row" id="loadingprov" >
                <div class="col-md-12 text-center">
                    <img src="{{ asset('assets/img/web/small_loading.gif') }}" alt="loading">
                    <input type="hidden" class="form-control"  placeholder="Postal Code"name="bilprovince"  required="" value="">
                </div>
            </div>
        </div>
    </div>
    <div class="form-group valid">
        <div id="bilingcity">
            <div class="row" id="loadingcit" style="display: none;">
                <div class="col-md-12 text-center">
                    <img src="{{ asset('assets/img/web/small_loading.gif') }}" alt="loading">
                    <input type="hidden" class="form-control"  placeholder="Postal Code"name="bilcity"  required="" value="">
                </div>
            </div>
        </div>
    </div>
    <div class="form-group valid">
        <div id="bilingsubdistrict">
            <div class="row" id="loadingsub" style="display: none;">
                <div class="col-md-12 text-center">
                    <img src="{{ asset('assets/img/web/small_loading.gif') }}" alt="loading">
                    <input type="hidden" class="form-control"  placeholder="Postal Code"name="bildistrict"  required="" value="">
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
  var province=$('#bilprovince option:selected').text();
  var city=$('#bilcity option:selected').text();
  var subdistrict=$('#bildistrict option:selected').text();
  $('#province').val(province);
  $('#city').val(city);
  $('#subdistrict').val(subdistrict);

}
</script>
<script>
$(document).ready(function() {
    //Fungsi untuk Shipping
    var token = "{{ csrf_token() }}";
    var dataString = '_token=' + token;
    //var dataString = '_token='+token +' &k_tujuan=' + k_tujuan;
    $.ajax({
        type: "POST",
        url: "{{ url('ajax/bilingprovince') }}",
        data: dataString,

        success: function(data) {
            $('#bilingprovince').html(data);
            get_bilingcity();
            get_bilingdistrict();
        }
    });
    //settimeout();
});
</script>

<script>
function get_bilingprovince() {


  var token = "{{ csrf_token() }}";
  var dataString = '_token=' + token;
  //var dataString = '_token='+token +' &k_tujuan=' + k_tujuan;
  $.ajax({
      type: "POST",
      url: "{{ url('ajax/bilingprovince') }}",
      data: dataString,

      success: function(data) {
          $('#bilingprovince').html(data);
          get_bilingcity();
          get_bilingdistrict();
      }
  });
}

//Ajax untuk nampilkan kota
function get_bilingcity() {

    $('#loadingcit').fadeIn();
    //Fungsi untuk Shipping
    var token = "{{ csrf_token() }}";
    var province = $('#bilprovince').val();
    var provincename = $("#bilprovince").find('option:selected').attr("data-name");
    var dataString = '_token=' + token + '&province=' + province + '&provincename=' + provincename;


    // var dataString = '_token='+ token +' &province=' + province;
    $.ajax({
        type: "POST",
        url: "{{ url('ajax/bilingcity') }}",
        data: dataString,
        success: function(data) {
            $('#bilingcity').html(data);
            get_bilingdistrict();
        }
    });
}
//Ajax untuk mempilkan harga


//Ajax untuk mempilkan city
function get_bilingdistrict() {
    $('#loadingsub').fadeIn();
    var token ="{{ csrf_token() }}";
    var city = $('#bilcity').val();
    var cityname = $("#bilcity").find('option:selected').attr("data-name");
    var dataString = '_token=' + token + '&city=' + city + '&cityname=' + cityname;
    $.ajax({
        type: "POST",
        url: "{{ url('ajax/bilingsubdistrict') }}",
        data: dataString,
        success: function(data) {
            $('#bilingsubdistrict').html(data);
        }
    });
}
</script>
@endsection
