@extends('app')
@section('content')

<link rel="stylesheet" href="{{asset('template/frontend/product-detail.css')}}" type="text/css" />
<title>{{$prod->prod_title}} | {{web_name()}}</title>
<div class="container">

    <div class="col-md-12" style="padding-left:0px;padding-right:0px;">
      <div class="col-sm-12 col-md-12 col-xs-12" style="padding-right: 0px;padding-left: 0px;" id="alertval">
        <!-- @if(Session::has('success-addcart'))
        <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          {{ Session::get('success-addcart') }}
        </div>
        @endif
        @if(Session::has('error-addcart'))
        <div class="alert alert-danger">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          {{ Session::get('error-addcart') }}
        </div>
        @endif
        @if(Session::has('success-postwish'))
        <div class="alert alert-warning">{{ Session::get('success-postwish') }}</div>
        @endif -->
      </div>

       <div class="col-md-4 hidden-sm hidden-xs" >
         <div class="col-md-12 col-xs-12 hidden-sm hidden-xs">
           <img class="img-responsive" id="img_012" src="{{asset($prod->image_small)}}" alt="{{$prod->prod_title}}" data-zoom-image="{{asset($prod->image_large)}}" style="height:auto;"/>
         </div>
         <div class="col-md-12 col-xs-12">
             <div id="gal1">
               @foreach($prodimage as $image)
                 <a href="#" class="" data-image="{{asset($image->image_small)}}" data-zoom-image="{{asset($image->image_large)}}">
                      <img id="img_01" onclick="" alt="{{$prod->prod_title}}" src="{{asset($image->image_thumb)}}" style="width:100px;margin-top: 50px;" />
                 </a>
               @endforeach
             </div>
         </div>
       </div>

         <div class="col-xs-12 hidden-md hidden-lg " style="margin-bottom:20px;padding-left:0px;padding-right:0px;">
           <div id="" class="owl-carousel owl-theme">
                   @foreach($prodimage as $image)
                     <img class="img-responsive" alt="{{$prod->prod_title}}" src="{{asset($image->image_small)}}" alt="1" style="padding: 0px 10px; margin:0px auto;">
                   @endforeach
          </div>
        </div>

        <div class="col-md-5 detail-product" style="padding-left:0px;padding-right:0px;" >
            <div class="col-md-12">
                {{$prod->brand_name}}
              <h3 style="margin-top: 4px;margin-bottom:4px;">  {{$prod->prod_title}}</h3>
            </div>
            <div class="col-md-12">
              @foreach($categall as $categs)
              <?php
              if(in_array($categs->kateg_id,explode(',',$prod->prod_category))){
                  $result=Helper::check_dicount_catalog($prod->prod_id,$categs->kateg_id,$prod->prod_brand_id,$prod->prod_price);
                  $totalitem= $result['total'];
                  $disc= $result['disc'];
                  if( $disc > 0){
                    $total = $totalitem;
                  }else{
                    $total =$prod->prod_price;
                  }
                  if( $totalitem > 0 and $disc > 0 ){
                    break;
                  }
             }
            ?>
             @endforeach
              <h4><span class="price_format" style="font-weight:bold; color: #B2203D;">{{$total}}</span></h4>
                <p>
                    <?php echo nl2br($prod->prod_desc);?>
                </p>
            </div>

            <div class="col-md-12 title-product">
                PRODUCT & SIZE INFO
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    Size & fit
                    <br>
                    Model Measurement :
                    <br>
                    <ul style="">
                      <li>
                          Height : {{$prod->prod_height}}

                      </li>
                      <li>
                          Lenght : {{$prod->prod_lenght}}
                      </li>
                      <li>
                          Width : {{$prod->prod_width}}
                      </li>
                      <li>
                          Weight : {{$prod->prod_weight}}
                      </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    Detail & Care
                    <br>
                    <ul>
                        <?php echo nl2br($prod->prod_detail);?>

                    </ul>
                </div>
            </div>
            <div class="col-md-12">
                Sizing Measurement:
                <ul>
                    <?php echo nl2br($prod->prod_spek);?>
                </ul>

            </div>
        </div>

        <div class="col-md-3">

            <div class="" style="font-weight:600;">  VARIATION & CART</div>
            <form action="{{url('postcartprod')}}" method="post" id="validpost">
            <input type="hidden" value="<?php echo csrf_token();?>" name="_token">
            <input type="hidden" value="{{$prod->prod_id}}" name="prod_id">
            @if($variansize ==! null)
              <div class="detail-order">
                  Size :
                  <select name="size" id="varian_size" onchange="getvariancolor()" required>
                      <option value="" selected disabled>Choose</option>
                    @foreach($variansize as $size)
                      <option value="{{$size->varian_size}}">{{$size->varian_size}} </option>
                    @endforeach
                  </select>
              </div>
            @endif

            <div id="loadcolor"  style="display:none;text-align: -webkit-center; width:100%;">
              <img src="{{asset('assets/icon/load2.gif')}}" style="">
            </div>

            <div id="tampilcolor" style="display:none;">
           </div>

            <div class="detail-order">
                Quantity:
                <!-- <label class="control-label">Quantity :</label> -->
                <input name="qty" id="prodqty" min="1"  class="form-control" type="number" value="1" min="1" max="10" readonly />
            </div>

            <div id="loadprice"  style="display:none;text-align: -webkit-center; width:100%;">
              <img src="{{asset('assets/icon/load2.gif')}}" style="">
            </div>
            <div id="prodsumtotal" style="font-weight:bold;">
                Total <span class="pull-right price_format" style="font-weight:bold;">{{$total}}</span>
            </div>
            <hr>
            <div class="col-sm-12 col-md-12 col-xs-12" style="padding-right: 0px;padding-left: 0px;" id="alertval">
                  @if(Session::has('success-addcart'))
                      <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ Session::get('success-addcart') }}
                      </div>
                  @endif
                  @if(Session::has('error-addcart'))
                      <div class="alert alert-danger">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ Session::get('error-addcart') }}
                      </div>
                  @endif
                  @if(Session::has('success-postwish'))
                      <div class="alert alert-warning">{{ Session::get('success-postwish') }}</div>
                  @endif
              </div>
            <input type="hidden" id="colorval">
            <input type="hidden" id="sizeval">
            <button type="submit" class="add-cart col-xs-12" onclick="postval()" href="#">ADD TO CART</button>

        </div>
      </form>


        <script>
          function sumtotalprodplus(){
            var qty=document.getElementById("prodqty").value;
            x=parseInt(qty) ;
            var qtyplus= x + 1;
            var tot="{{$total}}";
            var sumtotal=tot * qtyplus;

            $('#loadprice').css('display','block');
            $('#prodsumtotal').css('display','none');

            $('#loadprice').css('display','none');
            $('#prodsumtotal').css('display','block');

            $("#prodsumtotal").html('  Total <span class="pull-right price_format">'+sumtotal+'</span>');
            $(".price_format").priceFormat();

          }
        </script>
        <script>
          function sumtotalprodminus(){
            var qty=document.getElementById("prodqty").value;
              x=parseInt(qty) ;
            var qtyplus= x - 1;
              if(qtyplus > 0){
                var intqty=qtyplus;
              }else{
                var intqty=1;
              }
            var tot="{{$total}}";
            var sumtotal=tot * intqty;
            $("#prodsumtotal").html('  Total <span class="pull-right price_format">'+sumtotal+'</span>');
            $(".price_format").priceFormat();
          }
        </script>

    </div>
    <div class="col-md-12 " style="margin-top:50px; margin-bottom: 20px;padding-left:0px;padding-right:0px;">
        <div class="col-md-4">
            <div class="title-product">RELATED PRODUCT</div>
        </div>
    </div>
    <div class="col-md-12" style="padding-left:0px;padding-right:0px;">
      <?php $i =0;?>
    @foreach($relatedprod as $product)
      @foreach($categall as $categs)
      <?php if(in_array($categs->kateg_id,explode(',',$product->prod_category))){
            if( $i++ < 4){?>

             <form action="{{url('postcart')}}" method="post">
              <input type="hidden" name="_token" id="tokenprod{{$product->prod_id}}" value="<?php echo csrf_token(); ?>">
               <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
               <input type="hidden" name="prod_id" value="{{$product->prod_id}}">
              <div class="col-md-3 col-xs-6">
                  <div class="card">
                      <div class="hovereffect1" style="overflow:hidden;">
                          <div class="hover-produk1" style="">
                              <div class="judul-kat1">
                                <a href="#"  class="info1"  data-toggle="modal" data-target="#quickModal{{ $product->prod_id }}" onclick="ajaxmodal('<?php echo $product->prod_id;?>')">ADD TO CART</a>
                                <a class="info1" href="{{url('wishlist/'.$product->prod_id)}}">ADD TO WISHLIST</a>
                                <a class="info1" href="{{url('product-detail/'.$product->prod_url)}}">VIEW DETAIL</a>
                              </div>
                          </div>
                          <img class="img-responsive" src="{{asset($product->front_image)}}" alt="" style=" width: 100%;">
                      </div>
                      <div class="isi-card" style="">
                          {{$product->brand_name}}<br>
                          <p style="font-weight:bold;">{{$product->prod_name}}</p>

                          <?php $result=Helper::check_dicount_catalog($product->prod_id,$categs->kateg_id,$product->prod_brand_id,$product->prod_price);

                               $total= $result['total'];
                               $disc= $result['disc'];
                               $prodid= $result['prodid'];
                               $type= $result['disc_reward'];
                               if($type=='nominal'){
                                 if($disc >= 1000) {
                                       $nominal= $disc / 1000 .'k';
                                   }
                                   else {
                                       $nominal= $disc;
                                }
                              }
                           ?>
                         @if( $disc > 0 )
                            <p><del><span class="price_format">{{$product->prod_price}}</span></del> <b> <span class="price_format" style="font-weight: bold; color: #B2203D;">{{$total}}</span></b></p>
                         @else
                             <p><span class="price_format" style="font-weight: bold; color: #B2203D;">{{$product->prod_price}}</span></p>
                         @endif
                         </div>
                         @if($disc > 0)
                           <div class="diskon">
                              <span style="position: relative; top: -30px; right: -5px; font-size: 12px;"><b>
                               @if($type =='nominal') {{$nominal}}
                               @else  {{$disc}}%
                               @endif
                              </b><br>OFF</span>
                           </div>
                         @endif
                  </div>
              </div>
            </form>
        <?php } break;} ?>
        @endforeach
      @endforeach
    </div>
</div>


<!-- Begin Modal !-->
@foreach($relatedprod as $modalproduct)
    @foreach($categall as $categs)
      <?php if(in_array($categs->kateg_id,explode(',',$modalproduct->prod_category))){ ?>
      <div class="modal fade"  id="quickModal{{$modalproduct->prod_id}}" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title">CART</h3>
              </div>
              <div class="modal-body">
                <div class="col-md-12"> <h3 class="text-left">{{$modalproduct->prod_name}}</h3></div>
                <div class="col-md-5">

                  <img src="{{asset($modalproduct->front_image)}}" class="img-responsive" />
                </div>
                <div class="col-md-7">
                  <div class="" style="font-weight:600;">  VARIATION & CART</div>
                  <form action="{{url('postcartprod')}}" method="post">

                    <input type="hidden" name="_token" id="token{{$modalproduct->prod_id}}" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" value="{{$modalproduct->prod_id}}" id="modalprodid" name="prod_id">


                    <?php $result=Helper::check_dicount_catalog($modalproduct->prod_id,$categs->kateg_id,$modalproduct->prod_brand_id,$modalproduct->prod_price);
                         $total= $result['total'];
                         $disc= $result['disc'];
                         if($disc > 0 ){
                           $totalitem = $total;
                         }else{
                           $totalitem =$modalproduct->prod_price;
                         }
                    ?>
                    <?php
                      $variansize=DB::table('ms_product_varian')
                      ->where('ms_product_varian.prod_id','=',$modalproduct->prod_id)
                      ->groupBy('varian_size')
                      ->get();
                    ?>
                    @if(count($variansize) >0 )
                    <div class="detail-order">
                      Size :
                      <select name="size" id="varian_sizemodal{{$modalproduct->prod_id}}" onchange="getvariancolormodal({{$modalproduct->prod_id}})" required>
                        <option value="" selected disabled>Choose</option>
                        @foreach($variansize as $size)
                          @if($size->varian_size !== '')
                          <option value="{{$size->varian_size}}">{{$size->varian_size}} </option>
                          @else
                          <option value="{{$size->varian_size}}">No Size</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                    @endif
                    <div id="loadcolormodal{{$modalproduct->prod_id}}"  style="display:none;text-align: -webkit-center; width:100%;">
                      <img src="{{asset('assets/icon/load2.gif')}}" style="">
                    </div>

                    <div id="tampilcolormodal{{$modalproduct->prod_id}}" style="display:none;">
                   </div>

                    <div class="detail-order">
                      Quantity:

                      <div class="input-group input-group-sm">
                          <span class="input-group-btn">
                              <a class="btn btn-default buttl flat" onclick="change_item_qty('{{ $modalproduct->prod_id }}', 'minus');"style="border-color:#c66;background-color:#d9534f;color:#fff;"><i class="fa fa-minus"></i></a>
                          </span>
                          <input type="text" class="form-control text-center select-input number" name="qty" id="{{ $modalproduct->prod_id }}" value="1" onchange="check_qty('{{ $modalproduct->prod_id }}');" data-id="id product">


                          <span class="input-group-btn">
                              <a class="btn btn-default buttl flat" onclick="change_item_qty('{{ $modalproduct->prod_id }}', 'plus');"style="border-color:#c66;background-color:#d9534f;color:#fff;"><i class="fa fa-plus"></i></a>
                          </span>
                      </div>
                    </div>

                    <div id="loadpricemodal{{$modalproduct->prod_id}}"  style="display:none;text-align: -webkit-center; width:100%;">
                      <img src="{{asset('assets/icon/load2.gif')}}" style="">
                    </div>

                    <div id="prodsumtotal{{ $modalproduct->prod_id}}"style="font-weight:bold;">
                      Total <span class="pull-right price_format">{{$totalitem}}</span>
                    </div>
                    <hr>

                    <input type="hidden" id="colorval">
                    <input type="hidden" id="sizeval">
                    <button type="submit" class="add-cart col-xs-12" onclick="postval()" href="#">ADD TO CART</button>
                  </div>
                  <div class="form-group">  <div class="clearfix"></div></div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save Changes</button> -->
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        </form>
    <?php break;} ?>
    @endforeach
@endforeach


<script type="text/javascript">
function ajaxmodal(prodid) {
//var prodid = $('.modaljax').val();

$('.getmodal' + prodid).html('<img src="assets/img/loading.gif">');

var token = $('#tokenprod'+prodid).val();

var dataString = '_token=' + token + '&prodid=' + prodid;

$.ajax({
    type: "POST",
    url: "{{ url('ajax/ajaxgetmodal') }}",
    data: dataString,
    success: function (data) {
        $('.getmodal' + prodid).html(data);
    }
});
}
</script>
<!--BEGEN SCRIPT MODAL-->
<script>
   function getvariancolormodal(prodid){
    var token ="{{csrf_token()}}";
    var size =    $("#varian_sizemodal"+prodid).val();
    var dataString= '_token='+token+'&prodid='+prodid+'&size='+size;

    $.ajax({
      type:"GET",
      url:"{{url('ajax/getvariancolor')}}",
      data:dataString,

      beforeSend: function(){
    // Handle the beforeSend event
        $('#loadcolormodal'+prodid).css('display','block');
        $('#tampilcolormodal'+prodid).css('display','none');


      },
      success:function(data){
          setTimeout(function () {
            $('#loadcolormodal'+prodid).css('display','none');
            $('#tampilcolormodal'+prodid).css('display','block');
            $("#tampilcolormodal"+prodid).html(data);
         },500);
      }
    });

   }
</script>

<script>
function gettotal(id){

    var qty = $('#'+id).val();
    var token= $('#token'+id).val();
    var kategid='other';

    var dataString= '_token='+ token + '&qty=' + qty  + '&prodid=' +id +'&kategid='+kategid;
    $.ajax({
      type:"GET",
      //dataType:'json',
      url:"{{url('ajax/gettotal')}}",
      data:dataString,

      beforeSend: function(){
      // Handle the beforeSend event
          $('#loadpricemodal'+id).css('display','block');

          $('#prodsumtotal'+id).css('display','none');
      },
      success:function(data){
          setTimeout(function () {

            $('#loadpricemodal'+id).css('display','none');
            $('#prodsumtotal'+id).css('display','block');
            $("#prodsumtotal"+id).html(data);
            $('.price_format').priceFormat();
         },500);
      }


    });
}
</script>

<script>
    function change_item_qty(id,type){

        var qty = $('#' + id).val();
        if(type == "plus"){
            qty = parseInt(qty) + 1;
            $('#' + id).val(qty);
        }
        else{
            if(qty <= 1){
                $('#' + id).val(1);
            }
            else{
                qty = parseInt(qty) - 1;
                $('#' + id).val(qty);
            }
        }
        gettotal(id);
    }

    function check_qty(id){
        var qty = $('#' + id).val();
        if(qty <= 1){
            $('#' + id).val(1);
        }
        gettotal(id);
    }

</script>

<!--END SCRIPT MODAL-->

<script>
    //initiate the plugin and pass the id of the div containing gallery images
    $("#img_012").elevateZoom({gallery:'gal1', cursor: 'pointer', galleryActiveClass: 'active', imageCrossfade: true, loadingIcon: 'http://www.elevateweb.co.uk/spinner.gif'});

    //pass the images to Fancybox
    $("#img_01").bind("click", function(e) {
        var ez =   $('#img_01').data('elevateZoom');
        $.fancybox(ez.getGalleryList());
        return false;
    });
</script>
    <script>
        var tinggi = $('.detail-product').height();
            $('#img_012').css('max-height', tinggi);
    </script>

    <!-- <script type="text/javascript">
      function postval(){
          var color = $('#colorval').val();
          var size = $('#sizeval').val();

          if (color == '' || size == '') {
              $('#alertval').html('<div class="alert alert-danger>Please Select Color and Size !</div>')
          }else {
              $('#validpost').submit();
          }
      }
  </script> -->
  <script>
     function getvariancolor(){
      var token ="{{csrf_token()}}";
      var size =    $("#varian_size").val();
      var prodid="{{$prod->prod_id}}";
      var dataString= '_token='+token+'&prodid='+prodid+'&size='+size;
      $.ajax({
        type:"GET",
        url:"{{url('ajax/getvariancolor')}}",
        data:dataString,

        beforeSend: function(){
      // Handle the beforeSend event
          $('#loadcolor').css('display','block');
          $('#tampilcolor').css('display','none');


        },
        success:function(data){
            setTimeout(function () {
              $('#loadcolor').css('display','none');
              $('#tampilcolor').css('display','block');
              $("#tampilcolor").html(data);
           },500);
        }
      });

     }
  </script>
  <script>
  function checkvarian(id){
    var varid= id;
    var token= "{{csrf_token()}}";
    var dataString='_token='+token+'&varid='+varid;

    $.ajax({
      type:"GET",
      url:"{{url('ajax/getVarian')}}",
      data:dataString,
      success: function(data){
        $("#tampilvarian").html(data);
        $("#img_012").elevateZoom({gallery:'gal1', cursor: 'pointer', galleryActiveClass: 'active', imageCrossfade: true, loadingIcon: 'http://www.elevateweb.co.uk/spinner.gif'});
        //pass the images to Fancybox
        $("#img_01").bind("click", function(e) {
          var ez =   $('#img_01').data('elevateZoom');
          $.fancybox(ez.getGalleryList());
          return false;
        });
        $('.price_format').priceFormat();
      }
    });
  }
  </script>
  <script src="{{asset('assets/js/bootstrap-number-input.js') }}" ></script>
  <script>
  // Remember set you events before call bootstrapSwitch or they will fire after bootstrapSwitch's events
  $("[name='checkbox2']").change(function() {
      if(!confirm('Do you wanna cancel me!')) {
          this.checked = true;
      }
  });

  $('#after').bootstrapNumber();
  $('#prodqty').bootstrapNumber({
      upClass: 'danger',
      downClass: 'danger'

  });
  </script>

@endsection
