@extends('web.master')
@section('title','Sonia')
@section('content')

@push('css')
<link rel="stylesheet" href="{{ asset('template/web/plugins/kartik-v-bootstrap-star-rating-ca43ee3/css/star-rating.css') }}">
<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">

<style media="screen">
.banner{
    width: 100%;
    display: table;
    text-align: center;
    background-position:bottom 0px left 0px !important;
}

@media(max-width:767px){
    .banner{
        background-position:bottom 0px left -250px !important;
    }
}

.wrap-outer{
    display: table-cell;
    vertical-align: middle;
}

.wrap-outer h1{
    /* font-family: 'Pacifico', cursive; */
    color: #1ABC9C;
    font-style: italic;
    font-size: 70px;
}

.wrap-outer span{
    color: #727172;
    font-style: italic;
    font-size: 25px;
    letter-spacing: 2px;
}

.product-price ins {
    color: #000;
}

.add-to-cart{
    width:100%;
    margin-top:20px !important;
    background-color:#000;
    border-radius:5px;
}

.panel-default{
    border-radius: 0px !important;
    border: transparent !important;
    -webkit-box-shadow: 0 0px 0px rgba(0,0,0,0) !important;
    box-shadow: 0 0px 0px rgba(0,0,0,0) !important;
    border-bottom: 1px solid #dedfde !important;
    padding: 10px 0px !important;
}

.panel-default>.panel-heading {
    color: #333;
    background-color: #fff;
    border-color: #e4e5e7;
    padding: 0;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

.panel-default>.panel-heading a {
    display: block;
    padding: 10px 0px;
}

.panel-default>.panel-heading a:after {
    content: "";
    position: relative;
    top: 1px;
    display: inline-block;
    font-family: 'Glyphicons Halflings';
    font-style: normal;
    font-weight: 400;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    float: right;
    transition: transform .25s linear;
    -webkit-transition: -webkit-transform .25s linear;
}

.panel-default>.panel-heading a[aria-expanded="true"] {
    background-color: #fff;
}

.panel-default>.panel-heading a[aria-expanded="true"]:after {
    content: "\2212";
    -webkit-transform: rotate(180deg);
    transform: rotate(180deg);
}

.panel-default>.panel-heading a[aria-expanded="false"]:after {
    content: "\002b";
    -webkit-transform: rotate(90deg);
    transform: rotate(90deg);
}

.accordion-option {
    width: 100%;
    float: left;
    clear: both;
    margin: 15px 0;
}

.accordion-option .title {
    font-size: 20px;
    font-weight: bold;
    float: left;
    padding: 0;
    margin: 0;
}

.accordion-option .toggle-accordion {
    float: right;
    font-size: 16px;
    color: #6a6c6f;
}

.accordion-option .toggle-accordion:before {
    content: "Expand All";
}

.accordion-option .toggle-accordion.active:before {
    content: "Collapse All";
}

#stock-notif{
    margin-top:42px;
    padding-left:0px;
    padding-right:0px;
    text-align: center;
}

.alert-danger{
    padding-top:8px;
    padding-bottom: 8px;
    border-radius: 0;
}

@media(max-width:991px){
    #stock-notif{
        margin-top: 85px;
    }

    .add-to-cart{
        margin-top: 0px !important;
    }
}

</style>
@endpush

@foreach($banners as $banner)
<section class="banner" style="background:url('{{ asset($banner->image) }}'); min-height:300px;">
    <div class="wrap-outer">
        <h1>
          @if(!isset($category))
            <?= ucwords(str_replace('-',' ','all')); ?>
          @else
            <?= ucwords(str_replace('-',' ',$category)); ?>
          @endif
        </h1>
        <!-- <span>#iamaddicted{{ $category }}</span> -->
    </div>
</section>
@endforeach

<section id="content">

    <div class="content-wrap" style="padding-top:0px;">

        <div class="container clearfix">

            <div style="padding:40px 0px;color:#a3a2a2;font-size:20px;">
                <a href="{{ url('/') }}" style="color:#a3a2a2">Home</a> >
                <a href="{{ url('products?category='.$category) }}" style="color:#a3a2a2">
                  @if(!isset($category))
                    <?= ucwords(str_replace('-',' ','all')); ?>
                  @else
                    <?= ucwords(str_replace('-',' ',$category)); ?>
                  @endif
                </a> >
                <a href="javascript::void(0)" style="color:#a3a2a2">{{ $products->prod_title }}</a>
            </div>

            <div class="single-product">

                <div class="product">

                    <div class="col_two_fifth">

                        <!-- Product Single - Gallery
                        ============================================= -->
                        <div class="product-image">
                            <div class="fslider" data-pagi="false" data-arrows="false" data-thumbs="true">
                                <div class="flexslider">
                                    <div class="slider-wrap" data-lightbox="gallery">

                                        @foreach($images as $image)
                                        <div class="slide" data-thumb="{{ asset($image->image_thumb) }}">
                                            <a href="javascript::void(0)" title="Shading" data-lightbox="gallery-item">
                                                <img src="{{ asset($image->image_large) }}" alt="{{ $products->prod_title }}">
                                            </a>
                                        </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            <!-- <div class="sale-flash">Sale!</div> -->
                        </div><!-- Product Single - Gallery End -->

                    </div>

                    <div class="col_two_fifth product-desc">

                        <!-- Product Single - Price
                        ============================================= -->
                        <div class="product-price" style="margin-bottom:10px;"><ins style="color:#1ABC9C;">{{ $products->prod_code }}</ins> <span style="color:#000;">{{ $products->prod_title }}</span></div>
                        <br>
                        <div class="clearfix"></div>
                        <!-- <input name="input-name" type="number" class="rating" min=1 max=10 step=2 data-size="xs" disabled="disabled" value="5"> -->

                        <!-- Product Single - Price
                        ============================================= -->
                        <div class="product-price" style="margin:10px 0px;"><ins>IDR <?= number_format($products->prod_price,0,',','.') ?></ins></div><!-- Product Single - Price End -->

                        <!-- Product Single - Rating
                        ============================================= -->
                        <!-- <div class="product-rating">
                            <i class="icon-star3"></i>
                            <i class="icon-star3"></i>
                            <i class="icon-star3"></i>
                            <i class="icon-star-half-full"></i>
                            <i class="icon-star-empty"></i>
                        </div> -->
                        <!-- Product Single - Rating End -->

                        <div class="clear"></div>

                        <!-- Product Single - Quantity & Cart Button
                        ============================================= -->
                        <form class="cart nobottommargin clearfix" method="post" enctype='multipart/form-data'>
                            <div class="col-md-6" style="padding-left:0px;margin-bottom:10px;">
                                <div class="quantity clearfix" style="width:100%;margin-left:0px;">
                                    Color
                                    <select class="sm-form-control" name="varcolor">
                                      <option value="" selected>Select</option>
                                      @foreach($varcolor as $color)
                                        <option value="{{ $color->varian_color }}"><?= strtoupper($color->varian_color) ?></option>
                                      @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" style="padding-left:0px;margin-bottom:10px;">
                                <div class="quantity clearfix" style="width:100%;margin-left:0px;">
                                    Size
                                    <select class="sm-form-control" name="varsize">
                                      <option value="" selected>Select</option>
                                      @foreach($varsize as $size)
                                        <option value="{{ $color->varian_size }}"><?= strtoupper($size->varian_size) ?></option>
                                      @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" style="padding-left:0px;">
                                <div class="quantity clearfix">
                                    Quantity<br><br>
                                    <input type="button" value="-" class="minus" onclick="getquantity('minus')">
                                    <input type="text" step="1" min="1"  name="quantity" value="1" title="Qty" class="qty" size="4" />
                                    <input type="button" value="+" class="plus" onclick="getquantity('plus')">
                                </div>
                            </div>
                            <div class="col-md-6" id="stock-notif" style="display:none;">
                                <?php if($products->prod_stock > 0){ ?>
                                    <!-- <div class="alert alert-success" style="margin-bottom:0px;padding:8px;text-align:right;background-color:transparent;border-color:transparent;">
                                        Stock : {{ $products->prod_stock }}
                                    </div> -->
                                <?php }else{ ?>
                                    <div class="alert alert-danger" style="margin-bottom:0px;padding:8px;text-align:right;background-color:transparent;border-color:transparent;">
                                        Out Of Stock
                                    </div>
                                <?php } ?>
                            </div>
                            <br>
                            <button type="button" class="add-to-cart button nomargin" onclick="addtocart()" style="background-color:#1ABC9C;">Add to cart</button>
                        </form><!-- Product Single - Quantity & Cart Button End -->

                        <div class="clear"></div>
                        <div class="line" style="margin-bottom:0px; !important"></div>

                        <div class="clearfix"></div>
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            DETAILS
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse in" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body" style="border-top:none;padding-left:0px;padding-right:0px;">
                                        <?= nl2br($products->prod_desc) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                            SHIPPING INFO
                                        </a>
                                    </h4>
                                </div>

                                <?php $shippinginfo = DB::table('t_module_options')->where('module','shipping')->first(); ?>

                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body" style="border-top:none;padding-left:0px;padding-right:0px;">
                                        <?= nl2br($shippinginfo->value) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                            RETURN & REFUND POLICY
                                        </a>
                                    </h4>
                                </div>

                                <?php $returninfo = DB::table('t_module_options')->where('module','returnpolicy')->first(); ?>

                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                    <div class="panel-body" style="border-top:none;padding-left:0px;padding-right:0px;">
                                        <?= nl2br($returninfo->value) ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Single - Share
                        ============================================= -->
                        <!-- <div class="si-share noborder clearfix">
                            <span>Share:</span>
                            <div>
                                <a href="#" class="social-icon si-borderless si-facebook">
                                    <i class="icon-facebook"></i>
                                    <i class="icon-facebook"></i>
                                </a>
                                <a href="#" class="social-icon si-borderless si-twitter">
                                    <i class="icon-twitter"></i>
                                    <i class="icon-twitter"></i>
                                </a>
                                <a href="#" class="social-icon si-borderless si-pinterest">
                                    <i class="icon-pinterest"></i>
                                    <i class="icon-pinterest"></i>
                                </a>
                                <a href="#" class="social-icon si-borderless si-gplus">
                                    <i class="icon-gplus"></i>
                                    <i class="icon-gplus"></i>
                                </a>
                                <a href="#" class="social-icon si-borderless si-rss">
                                    <i class="icon-rss"></i>
                                    <i class="icon-rss"></i>
                                </a>
                                <a href="#" class="social-icon si-borderless si-email3">
                                    <i class="icon-email3"></i>
                                    <i class="icon-email3"></i>
                                </a>
                            </div>
                        </div> -->

                    </div>

                    <!-- <div class="col_full nobottommargin">

                        <div class="tabs clearfix nobottommargin" id="tab-1">

                            <ul class="tab-nav clearfix">
                                <li><a href="#tabs-1"><i class="icon-align-justify2"></i><span class="hidden-xs"> Description</span></a></li>
                                <li><a href="#tabs-2"><i class="icon-info-sign"></i><span class="hidden-xs"> Additional Information</span></a></li>
                            </ul>

                            <div class="tab-container">

                                <div class="tab-content clearfix" id="tabs-1">
                                    <p>Pink printed dress,  woven, round neck with a keyhole and buttoned closure at the back, sleeveless, concealed zip up at left side seam, belt loops along waist with slight gathers beneath, brand appliqu?? above left front hem, has an attached lining.</p>
                                    Comes with a white, slim synthetic belt that has a tang clasp.
                                </div>
                                <div class="tab-content clearfix" id="tabs-2">

                                    <table class="table table-striped table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>Size</td>
                                                <td>Small, Medium &amp; Large</td>
                                            </tr>
                                            <tr>
                                                <td>Color</td>
                                                <td>Pink &amp; White</td>
                                            </tr>
                                            <tr>
                                                <td>Waist</td>
                                                <td>26 cm</td>
                                            </tr>
                                            <tr>
                                                <td>Length</td>
                                                <td>40 cm</td>
                                            </tr>
                                            <tr>
                                                <td>Chest</td>
                                                <td>33 inches</td>
                                            </tr>
                                            <tr>
                                                <td>Fabric</td>
                                                <td>Cotton, Silk &amp; Synthetic</td>
                                            </tr>
                                            <tr>
                                                <td>Warranty</td>
                                                <td>3 Months</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>

                            </div>

                        </div>

                    </div> -->

                </div>

            </div>

            <div class="clear"></div><div class="line"></div>

            <!-- <div class="col_full nobottommargin">

                <h4>Related Products</h4>

                <div id="oc-product" class="owl-carousel product-carousel carousel-widget" data-margin="30" data-pagi="false" data-autoplay="5000" data-items-xxs="1" data-items-sm="2" data-items-md="3" data-items-lg="4">

                    <?php for ($i=1; $i < 7; $i++) { ?>
                        <div class="oc-item">
                            <div class="product iproduct clearfix">
                                <div class="product-image">
                                    <a href="{{ url('/product-detail/shading') }}">
                                        <img src="{{ asset('assets/source/images/products/'.$i.'.png') }}" alt="Shading">
                                    </a>
                                    <div class="product-overlay">
                                        <a href="{{ url('/product-detail/shading') }}" class="add-to-cart" style="width:100%;"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a>
                                    </div>
                                </div>
                                <div class="product-desc center">
                                    <div class="product-title"><h3><a href="{{ url('/product-detail/shading') }}">F204 <i>Shading</i></a></h3></div>
                                    <div class="product-price"><ins>IDR 150.00{{ $i }}</ins></div>
                                    <div class="product-rating">
                                        <i class="icon-star3"></i>
                                        <i class="icon-star3"></i>
                                        <i class="icon-star3"></i>
                                        <i class="icon-star3"></i>
                                        <i class="icon-star-half-full"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>

            </div> -->

        </div>

    </div>

    <!-- <button type="button" class="btn btn-info btn-lg" onclick="openmodal()">Open Modal</button> -->

</section><!-- #content end -->

<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog" style="z-index:99999999999;">
    <div class="modal-dialog" style="background-color:#fff;">

      <!-- Modal content-->
      <div class="modal-content" style="border-radius:0px;">
        <div class="modal-header" style="border-bottom:none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">
              <img src="{{ asset('assets/cart-success.png') }}" alt="Success Add Cart" class="img-responsive" style="margin:auto;height:100px;">
          </h4>
        </div>
        <div class="modal-body" style="padding:15px 50px;">

        </div>
        <div class="modal-footer" style="border-top:none;text-align:center;">
            <a href="{{ url('products/') }}<?php if(isset($_GET['category'])){echo '?category='.$_GET['category'];} ?>&view=20" class="btn btn-default" style="border-radius:5px;padding:10px 30px;background-color:#000;border-color:#000;">Shop More</a>
            @if(Session::has('memberid'))
                <a href="{{ url('cart') }}" class="btn btn-default" style="border-radius:5px;padding:10px 30px;background-color:#1ABC9C;border-color:#1ABC9C;">Checkout</a>
            @else
                <a href="{{ url('user/login') }}?redirect={{ url('/cart') }}" class="btn btn-default" style="border-radius:5px;padding:10px 30px;background-color:#1ABC9C;border-color:#1ABC9C;">Checkout</a>
            @endif
        </div>
      </div>

    </div>
  </div>

@push('js')
<script type="text/javascript" src="{{ asset('template/web/plugins/kartik-v-bootstrap-star-rating-ca43ee3/js/star-rating.js') }}"></script>
<!-- <script type="text/javascript" src="{{ asset('templates/web/plugins/kartik-v-bootstrap-star-rating-ca43ee3/themes/krajee-svg/theme.min.js') }}"></script> -->
<script type="text/javascript">
$(".rating").rating().unbind();
</script>

<script type="text/javascript">
    function openmodal(){
        $('#myModal').modal('show');
    }
</script>

<script type="text/javascript">
    localStorage.removeItem('jsvouchervalue');
    localStorage.removeItem('jsvouchertype');
</script>

<script type="text/javascript">
$(document).ready(function() {

    $(".toggle-accordion").on("click", function() {
        var accordionId = $(this).attr("accordion-id"),
        numPanelOpen = $(accordionId + ' .collapse.in').length;

        $(this).toggleClass("active");

        if (numPanelOpen == 0) {
            openAllPanels(accordionId);
        } else {
            closeAllPanels(accordionId);
        }
    })

    openAllPanels = function(aId) {
        console.log("setAllPanelOpen");
        $(aId + ' .panel-collapse:not(".in")').collapse('show');
    }
    closeAllPanels = function(aId) {
        console.log("setAllPanelclose");
        $(aId + ' .panel-collapse.in').collapse('hide');
    }

});
</script>

<script type="text/javascript">
    function getquantity(trigger){
        var val_now = $('[name=quantity]').val();
        if (trigger == 'minus') {
            if (val_now == 1) { }else{
                var count = parseInt(val_now) - 1;
                $('[name=quantity]').val(count);
            }
        }else {
            var count = parseInt(val_now) + 1;
            $('[name=quantity]').val(count);
        }
    }
</script>

<script type="text/javascript">
    function addtocart(){
        var prodid      = '{{ $products->prod_id }}';
        var prodname    = '{{ $products->prod_name }}';
        var color       = $('[name=varcolor]').val();
        var size        = $('[name=varsize]').val();
        var qty         = $('[name=quantity]').val();
        var price       = '{{ $products->prod_price }}';
        var image       = '{{ $products->front_image }}';
        var url         = '{{ $products->prod_url }}';

        var datapost = {
            "_token"    : '{{ csrf_token() }}',
            "prodid"    : prodid,
            "prodname"  : prodname,
            "color"     : color,
            "size"      : size,
            "qty"       : qty,
            "price"     : price,
            "image"     : image,
            "url"       : url
        }

        if (color == '' || size == '') {
          swal("Error !", "Please select size and color !", "error");
        }else {
          $.ajax({
              type    : "POST",
              url     : "{{ url('ajax/addcart') }}",
              data    : datapost,
              dataType: "json",
              beforeSend : function(){
                  $('.add-to-cart').attr('onclick','false');
                  $('.add-to-cart').html('Loading');
              },
              success : function(data){
                  if (data[1] == 1) {
                      // alert('Add To Cart Successed');
                      // swal("Success !", "Success Add To Cart", "success");
                      $('.modal-body').html(data[5]);
                      $('#myModal').modal('show');

                      $('.cart-count').html(data[2]);
                      $(".top-cart-items").html(data[3]);
                      $(".top-cart-action").html(data[4]);
                  } else if(data[1] == 2) {
                      // alert('Add To Cart Failed');
                      swal("Error !", "Stock Not Available", "error");
                      // $('#stock-notif').html( '<div class="alert alert-danger" style="margin-bottom:0px;">'+
                      //                             '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
                      //                             'Out Of Stock'+
                      //                         '</div>');
                  } else {
                      // alert('Add To Cart Failed');
                      swal("Error !", "Error Add To Cart", "error");
                  }

                  $('.add-to-cart').attr('onclick','addtocart()');
                  $('.add-to-cart').html('Add to cart');
              }
          })
        }

    }
</script>

<script type="text/javascript">
    localStorage.removeItem('jsvouchervalue');
    localStorage.removeItem('jsvouchertype');
</script>

@endpush

@endsection
