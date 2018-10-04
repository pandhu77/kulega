@extends('app')
@section('content')
  <link rel="stylesheet" href="{{asset('template/frontend/product.css')}}" type="text/css" />
  <title>{{$categurl}} | {{web_name()}}</title>
    <div class="container">
        @if(!empty($categ->kateg_banner))
        <div class="col-md-12">
            <div class="header-product" style="background-image:url({{asset($categ->kateg_banner)}});overflow:hidden;">
            </div>
        </div>
        <br>
        @endif

        <div class="col-md-4 col-sm-12 hidden-xs" style="margin-top: 20px;">
          FILTER PRODUCTS
        </div>
        <div id="filter1" class="col-md-8 col-sm-12  hidden-xs" style="margin-top: 20px; text-align: right">
          <ul style="padding-left: 0;">
            <li style="display: inline-block">
              SORT BY :
            </li>
            <li style="display: inline-block">
              <select name="" class="sort" id="" style="border: none;" onchange="sortProduct()">
                <option value="popular">POPULARITY</option>
                <option value="lowest">LOWEST PRICE</option>
                <option value="high">HIGH PRICE</option>
                <option value="newst">NEWEST</option>
              </select>
            </li>
            <li style="display: inline-block">
              VIEW (<span id="tmpItem">@{{ itemprod }}</span>) ITEMS
            </li>
          </ul>
        </div>
        <div class="col-md-12 col-sm-12 hidden-xs">
          <hr size="10" style="color: black;">
        </div>
        <!-- DESKTOP FILTER --->
        <div class="col-md-3 hidden-xs ">
          <h5 class="judul-kat-pro">{{$categ->kateg_name}}</h5>
          <hr style="color: black;">
          <h5 class="judul-sub-pro">  <a href="{{url('product/'.$categ->kateg_url)}}" style="color:#000;">VIEW ALL {{$categ->kateg_name}}</a></h5>
          <ul class="topnav">
            <?php $i = 1; ?>
            <?php if(count($categparent) > 0){?>

              @foreach($categparent as $parent)
              @if($categ->kateg_id==$parent->kateg_parent)
              <li id="{{$i}}">
                <a href="{{url('product/'.$parent->kateg_url)}}" style="">{{$parent->kateg_name}}</a>
                @foreach($categparent2 as $parent2)
                @if($parent->kateg_id==$parent2->kateg_parent )
                <ul class="parent2" id="hoveran{{ $i }}">
                  @foreach($categparent2 as $parent2)
                  @if($parent->kateg_id==$parent2->kateg_parent )
                  <li><a href="{{url('product/'.$parent2->kateg_url)}}">{{$parent2->kateg_name}}</a></li>
                  @endif
                  @endforeach
                </ul>

                <?php break;?>

                @endif

                @endforeach

              </li>
              <?php $i++; ?>
              @endif
              @endforeach

              <?php } ?>
            </ul>

            <h5 class="judul-kat-pro">BRAND <span style="float: right;"></span></h5>
            <hr style="color: black;">

            <div id="filter">
              @foreach($brand as $brands)
              <div >
                <label class="form-checkbox">
                  <input type="checkbox" name="brand[]" value="{{$brands->brand_id}}"
                  <?php
                  foreach ($prod as $prodbrand) {
                    if(in_array($categ->kateg_id, explode(',',$prodbrand->prod_category))){
                      if($prodbrand->prod_brand_id==$brands->brand_id){
                        echo "checked";
                        break;
                      }
                    }
                  }
                  ?>
                  onclick="sortProduct()"/>
                  <span class="square">
                    <span class="inner-square"></span>
                  </span>
                  {{$brands->brand_name}}
                </label>
              </div>
              @endforeach
            </div>

            <h5 class="judul-kat-pro">PRICE <span style="float: right;"></span></h5>
            <hr style="color: black;">
            <div >
              <div>
                <input type="text" id="range" value="" name="range" onchange="sortProduct()"/>
              </div>
            </div>
        </div>
        <!--- END DESKTOP FILTER --->

        <!--- MOBILE FILTER --->

          <div class="col-sm-12 hidden-sm hidden-md hidden-lg padding-0">
              <div class="col-xs-6 hidden-sm hidden-md hidden-lg padding-0" style="z-index: 999; margin-bottom:20px;">
                  <!--MOBILE START-->
                  <div style="width:100%; text-align: center;background-color: #666;padding-top: 10px;padding-bottom: 10px; ">
                      <a  href="#" class="hidden-lg hidden-md collapsed"data-toggle="modal" data-target="#submenumodal" style="font-size: 12pt; text-decoration: none;text-align: center;color: #fff"><span> FILTER </span></a>
                  </div>
                  <!--MOBILE END-->
              </div>
              <div class="col-xs-6 hidden-sm  hidden-md hidden-lg padding-0" style="z-index: 999; margin-bottom:20px;">
                <!--MOBILE START-->
                  <div style="width:100%; text-align: center;background-color: #666;padding-top: 10px;padding-bottom: 10px;">
                      <a class="hidden-lg hidden-md   collapsed" data-toggle="collapse" data-target="#submenu1" style="font-size: 12pt; text-decoration: none;text-align: center;color: #fff"><span> SORT <i class="fa fa-caret-down" aria-hidden="true"></i></span></a>
                  </div>
                  <ul id="submenu1" class="collapse navbar-collapse collapse padding-0" style="padding-left: 0px; padding-right: 0px;">

                      <li class="hidden-lg hidden-md   collapsed text-uppercase" style="text-align: left; border: 1px solid #eee; background: #eee;list-style: none;padding-left: 10px;">
                        <a href="#" style="color: #000" onclick="sortpopular()">POPULARITY</a>
                      </li>
                      <li class="hidden-lg hidden-md  collapsed text-uppercase" style="text-align: left; border: 1px solid #eee; background: #eee;list-style: none;padding-left: 10px;">
                        <a href="#"  onclick="sortlowest()" style="color: #000">LOWEST PRICE</a>
                      </li>
                      <li class="hidden-lg hidden-md  collapsed text-uppercase" style="text-align: left; border: 1px solid #eee; background: #eee;list-style: none;padding-left: 10px;">
                        <a href="#" onclick="sorthigh()" style="color: #000">HIGH PRICE</a>
                      </li>
                      <li class="hidden-lg hidden-md    collapsed text-uppercase" style="text-align: left; border: 1px solid #eee; background: #eee;list-style: none;padding-left: 10px;">
                        <a href="#" onclick="sortnewst()" style="color: #000">NEWEST</a>
                      </li>
                  </ul>
                  <input type="hidden" id="sort2">
                <!--MOBILE END-->
              </div>
          </div>


        <!---  END MOBILE FILTER -->
      <div class="col-lg-9  col-content">
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
          <div class="loadprod" style="display:none;">
            <img src="{{ asset('assets/img/web/small_loading.gif') }}" alt="loading" style="padding-right:30px;">
          </div>
        <div class="row" id="tampilprod">

          <?php $item=0; ?>
          @foreach($prod as $product)
            <?php if(in_array($categ->kateg_id, explode(',',$product->prod_category))){?>

           <form action="{{url('postcart')}}" method="post">
             <input type="hidden" name="_token" id="tokenprod{{$product->prod_id}}" value="<?php echo csrf_token(); ?>">
             <input type="hidden" name="prod_id" value="{{$product->prod_id}}">
             <input type="hidden" id="flag" name="flag" value="0">

             <div class="col-md-4 col-xs-6 product-loop">
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
                     <?php $result=Helper::check_dicount_catalog($product->prod_id,$categ->kateg_id,$product->prod_brand_id,$product->prod_price);
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
                        <input type="hidden" name="totprice[]" class="" value="{{$total}}">
                       <p><del><span class="price_format">{{$product->prod_price}}</span></del> <b> <span class="price_format" style="font-weight: bold; color: #B2203D;">{{$total}}</span></b></p>
                    @else
                        <input type="hidden" name="totprice[]" class="" value="{{$product->prod_price}}">
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

          <?php $item ++; }?>

          @endforeach
        </div>
     </div>
   </div>
    <!-- Begin Modal !-->
    @foreach($prod as $modalproduct)
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
                <input type="hidden" value="<?php echo csrf_token();?>" name="_token">
                <input type="hidden" name="_token" id="token{{$modalproduct->prod_id}}" value="<?php echo csrf_token(); ?>">
                <input type="hidden" value="{{$modalproduct->prod_id}}" id="modalprodid" name="prod_id">
                <?php $result=Helper::check_dicount_catalog($modalproduct->prod_id,$categ->kateg_id,$modalproduct->prod_brand_id,$modalproduct->prod_price);
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
                @if(count($variansize) > 0 )
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
                      <input type="text" class="form-control text-center select-input number" name="qty" id="intqty{{ $modalproduct->prod_id }}" value="1" onchange="check_qty('{{ $modalproduct->prod_id }}');" data-id="id product">
                      <span class="input-group-btn">
                          <a class="btn btn-default buttl flat" onclick="change_item_qty('{{ $modalproduct->prod_id }}', 'plus');"style="border-color:#c66;background-color:#d9534f;color:#fff;"><i class="fa fa-plus"></i></a>
                      </span>
                  </div>
                </div>
                <div id="loadpricemodal{{$modalproduct->prod_id}}"  style="display:none;text-align: -webkit-center; width:100%;">
                  <img src="{{asset('assets/icon/load2.gif')}}" style="">
                </div>
                <div id="prodsumtotal{{ $modalproduct->prod_id}}" style="font-weight:bold;">
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
            <button type="button" class="btn btn-default btn-close " data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary">Save Changes</button> -->
          </div>
      </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    @endforeach

    <!-- Modal -->
    <div id="submenumodal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">FILTER PRODUCTS</h4>
          </div>
          <div class="modal-body">
            <div class="col-md-3 hidden-lg hidden-md">
              <h5 class="judul-kat-pro">{{$categ->kateg_name}}</h5>
              <hr style="color: black;">
              <h5 class="judul-sub-pro"> <a href="{{url('product/'.$categ->kateg_url)}}" style="color:#000;">VIEW ALL {{$categ->kateg_name}}<a></h5>
              <ul class="topnav">
                <?php if(count($categparent) > 0){?>
                <?php $par=1;?>
                  @foreach($categparent as $parent)
                      @if($categ->kateg_id==$parent->kateg_parent)
                          <li> <a href="#"  class="plus" style="position:absolute;right:15px;;"></a>
                            <a href="{{url('product/'.$parent->kateg_url)}}" id="parenturl{{$par}}" style="margin-right:20px;">{{$parent->kateg_name}}</a>
                            @foreach($categparent2 as $parent2)
                                @if($parent->kateg_id==$parent2->kateg_parent )
                                    <ul>
                                      @foreach($categparent2 as $parent2)
                                        @if($parent->kateg_id==$parent2->kateg_parent )
                                          <li><a href="{{url('product/'.$parent2->kateg_url)}}">{{$parent2->kateg_name}}</a></li>
                                        @endif
                                        @endforeach
                                    </ul>
                                <?php break;?>
                                @endif
                            @endforeach
                          </li>
                      <?php $par ++;?>
                      @endif
                  @endforeach

                  <?php } ?>
                </ul>
                <h5 class="judul-kat-pro"> BRAND <span style="float: right;"></span></h5>
                <hr style="color: black;">

                <div id="filter2">
                  @foreach($brand as $brands)
                  <div >
                    <label class="form-checkbox">
                      <input type="checkbox" name="brand2[]" value="{{$brands->brand_id}}"
                      <?php
                      foreach ($prod as $prodbrand) {
                        if(in_array($categ->kateg_id, explode(',',$prodbrand->prod_category))){
                          if($prodbrand->prod_brand_id==$brands->brand_id){
                            echo "checked";
                            break;
                          }
                        }
                      }
                      ?>
                      onclick="sortProduct2()"/>
                      <span class="square">
                        <span class="inner-square"></span>
                      </span>
                      {{$brands->brand_name}}
                    </label>
                  </div>
                  @endforeach
                </div>

                <h5 class="judul-kat-pro">PRICE <span style="float: right;"></span></h5>
                <hr style="color: black;">
                <div >
                  <div>
                    <input type="text" id="range2" value="" name="range2" onchange="sortProduct2()"/>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="add-cart" data-dismiss="modal">Oke</button>
            </div>
          </div>
        </div>
      </div>

    <script>
        $(document).ready(function(){
          var z = 1;
          hover();

          function hover(){
            $("li").hover(function(){
              // console.log($(this).attr('id'));
                $("#hoveran"+$(this).attr('id')).css('display','block');
                }, function(){
                $("#hoveran"+$(this).attr('id')).css('display','none');
            });
          }
        });
    </script>
    <script>
    var app = new Vue({
      el: '#tmpItem',
      data: {
        itemprod: '{{$item}}'
      }
    });
    </script>
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

        var qty = $('#intqty'+id).val();

        var token= $('#token'+id).val();
        var kategid="{{$categ->kateg_id}}";


        var dataString= '_token='+ token + '&qty=' + qty  + '&prodid=' + id +'&kategid=' + kategid;
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

            var qty = $('#intqty' + id).val();
            if(type == "plus"){
                qty = parseInt(qty) + 1;

                $('#intqty' + id).val(qty);
            }
            else{

                if(qty <= 1){
                    $('#intqty' + id).val(1);
                }
                else{
                    qty = parseInt(qty) - 1;
                    $('#intqty' + id).val(qty);
                }
            }

            gettotal(id);
        }

        function check_qty(id){
            var qty = $('#intqty' + id).val();
            if(qty <= 1){
                $('#intqty' + id).val(1);
            }else{
                $('#intqty' + id).val(qty);
            }
            gettotal(id);
        }

    </script>
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

    <script language="JavaScript">

        $(document).ready(function() {
            $(".topnav").accordion({
                accordion:false,
                speed: 500,
                closedSign: '+',
                openedSign: '-'
            });
        });

    </script>
    <script>

        $(function () {
              var totprice =[];
              $('input[name^="totprice"]').each(function() {
                totprice.push($(this).val());
              });
              min= Math.min.apply(null,totprice);
              max = Math.max.apply(null,totprice);

             $("#range").ionRangeSlider({
                hide_min_max: true,
                keyboard: true,
                min: min,
                max: max,
                from:min,
                to: max,
                type: 'double',
                step: 1,
                prefix: "Rp.",
                grid: true
            });

            $("#range2").ionRangeSlider({
               hide_min_max: true,
               keyboard: true,
               min: min,
               max: max,
               from:min,
               to: max,
               type: 'double',
               step: 1,
               prefix: "Rp.",
               grid: true
           });
        });
    </script>

    <script>
      function sortpopular(){
        $('#sort2').val('popular');
        sortProduct2()
      }
      function sortlowest(){
        $('#sort2').val('lowest');
        sortProduct2()
      }
      function sorthigh(){
        $('#sort2').val('high');
        sortProduct2()
      }
      function sortnewst(){
        $('#sort2').val('newst');
        sortProduct2()
      }
    </script>

    <script>
    function sortProduct2() {
     var allVals = [];
     $('#filter2 :checked').each(function() {
       allVals.push($(this).val());
     });
    var kategid="{{$categ->kateg_id}}";
    var sort =$('#sort2').val();
    var harga = $('#range2').val();
    var token = "{{csrf_token()}}";


    var dataString = '_token=' + token
    + '&allVals=' + allVals +'&kategid='+kategid +'&sort='+ sort + '&price=' + harga;

    $.ajax({
        type: "POST",
        url: "{{ url('ajax/sortProduct') }}",
        data: dataString,
        beforeSend:function(){
          $('.loadprod').css('display','block');
          $('#tampilprod').css('display','none');
        },
        success: function (data) {
          setTimeout(function(){
            $('.loadprod').css('display','none');
            $('#tampilprod').css('display','block');
            $('#tampilprod').html(data);
            $('.price_format').priceFormat();
            var item = $('#countItem').val();
            $('#tmpItem2').html(item);
            paginateproduct();

          },500);
        }

    });
     }
    </script>


    <script>
    function sortProduct() {

     var allVals = [];
     $('#filter :checked').each(function() {
       allVals.push($(this).val());
     });
    var kategid="{{$categ->kateg_id}}";
    var sort =$('.sort').val();
    var harga = $('#range').val();
    var token = "{{csrf_token()}}";
    var dataString = '_token=' + token
    + '&allVals=' + allVals +'&kategid='+kategid +'&sort='+ sort + '&price=' + harga;

    $.ajax({
        type: "POST",
        url: "{{ url('ajax/sortProduct') }}",
        data: dataString,
        beforeSend:function(){
          $('.loadprod').css('display','block');
          $('#tampilprod').css('display','none');
        },
        success: function (data) {
          setTimeout(function(){
            $('.loadprod').css('display','none');
            $('#tampilprod').css('display','block');
            $('#tampilprod').html(data);
            $('.price_format').priceFormat();
            var item = $('#countItem').val();
            $('#tmpItem').html(item);
            paginateproduct();
          },500);
        }

    });
     }
    </script>

    <script src="{{asset('assets/js/bootstrap-number-input2.js') }}" ></script>
    <script>
    // Remember set you events before call bootstrapSwitch or they will fire after bootstrapSwitch's events
    $("[name='checkbox2']").change(function() {
        if(!confirm('Do you wanna cancel me!')) {
            this.checked = true;
        }
    });

    $('#after').bootstrapNumber();
    $('.prodqty').bootstrapNumber({
        upClass: 'danger',
        downClass: 'danger'

    });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
      paginateproduct();
    });
    </script>
    <script type="text/javascript">

    function paginateproduct(){

    (function($){

      var paginate = {
        startPos: function(pageNumber, perPage) {
          // determine what array position to start from
          // based on current page and # per page
          return pageNumber * perPage;
        },

        getPage: function(items, startPos, perPage) {
          // declare an empty array to hold our page items
          var page = [];

          // only get items after the starting position
          items = items.slice(startPos, items.length);

          // loop remaining items until max per page
          for (var i=0; i < perPage; i++) {
            page.push(items[i]); }

            return page;
          },

          totalPages: function(items, perPage) {
            // determine total number of pages
            return Math.ceil(items.length / perPage);
          },

          createBtns: function(totalPages, currentPage) {
            // create buttons to manipulate current page
            var pagination = $('<div class="col-md-12 col-xs-12 pagination" />');

            // add a "first" button
            pagination.append('<span class="pagination-button">&laquo;</span>');

            // add pages inbetween
            for (var i=1; i <= totalPages; i++) {
              // truncate list when too large
              if (totalPages > 5 && currentPage !== i) {
                // if on first two pages
                if (currentPage === 1 || currentPage === 2) {
                  // show first 5 pages
                  if (i > 5) continue;
                  // if on last two pages
                } else if (currentPage === totalPages || currentPage === totalPages - 1) {
                  // show last 5 pages
                  if (i < totalPages - 4) continue;
                  // otherwise show 5 pages w/ current in middle
                } else {
                  if (i < currentPage - 2 || i > currentPage + 2) {
                    continue; }
                  }
                }

                // markup for page button
                var pageBtn = $('<span class="pagination-button page-num" />');

                // add active class for current page
                if (i == currentPage) {
                  pageBtn.addClass('active'); }

                  // set text to the page number
                  pageBtn.text(i);

                  // add button to the container
                  pagination.append(pageBtn);
                }

                // add a "last" button
                pagination.append($('<span class="pagination-button">&raquo;</span>'));

                return pagination;
              },

              createPage: function(items, currentPage, perPage) {
                // remove pagination from the page
                $('.pagination').remove();

                // set context for the items
                var container = items.parent(),
                // detach items from the page and cast as array
                items = items.detach().toArray(),
                // get start position and select items for page
                startPos = this.startPos(currentPage - 1, perPage),
                page = this.getPage(items, startPos, perPage);

                // loop items and readd to page
                $.each(page, function(){
                  // prevent empty items that return as Window
                  if (this.window === undefined) {
                    container.append($(this)); }
                  });

                  // prep pagination buttons and add to page
                  var totalPages = this.totalPages(items, perPage),
                  pageButtons = this.createBtns(totalPages, currentPage);

                  container.after(pageButtons);
                }
              };

              // stuff it all into a jQuery method!
              $.fn.paginate = function(perPage) {
                var items = $(this);

                // default perPage to 5
                if (isNaN(perPage) || perPage === undefined) {
                  perPage = 5; }

                  // don't fire if fewer items than perPage
                  if (items.length <= perPage) {
                    return true; }

                    // ensure items stay in the same DOM position
                    if (items.length !== items.parent()[0].children.length) {
                      items.wrapAll('<div class="pagination-items" />');
                    }

                    // paginate the items starting at page 1
                    paginate.createPage(items, 1, perPage);

                    // handle click events on the buttons
                    $(document).on('click', '.pagination-button', function(e) {
                      // get current page from active button
                      var currentPage = parseInt($('.pagination-button.active').text(), 10),
                      newPage = currentPage,
                      totalPages = paginate.totalPages(items, perPage),
                      target = $(e.target);

                      // get numbered page
                      newPage = parseInt(target.text(), 10);
                      if (target.text() == '«') newPage = 1;
                      if (target.text() == '»') newPage = totalPages;

                      // ensure newPage is in available range
                      if (newPage > 0 && newPage <= totalPages) {
                        paginate.createPage(items, newPage, perPage); }
                      });
                    };

                  })(jQuery);

                  /* This part is just for the demo,
                  not actually part of the plugin */
                  $('.product-loop').paginate(12);

            }
    </script>
@endsection
