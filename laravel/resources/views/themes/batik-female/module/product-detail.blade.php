<div class="single-product">
    <div class="product">
        <div class="col_two_fifth">

            <!-- Product Single - Gallery
            ============================================= -->
            <div class="product-image">
                <div class="fslider" data-pagi="false" data-arrows="false" data-thumbs="true">
                    <div class="flexslider">
                        <div class="slider-wrap" data-lightbox="gallery">
                            @foreach($image as $img)
                            <div class="slide" data-thumb="{{ asset($img->image_small) }}"><a href="{{ asset($img->image_thumb) }}" title="{{ $products->prod_name }} - Front View" data-lightbox="gallery-item"><img src="{{ asset($img->image_thumb) }}" alt="{{ $products->prod_name }}"></a></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div><!-- Product Single - Gallery End -->

        </div>

        <div class="col_two_fifth product-desc">

            <?php $websetting = DB::table('cms_config')->first(); ?>

            <!-- Product Single - Price
            ============================================= -->
            @if($websetting->type == 'ecommerce')
                <div class="product-price"><ins>IDR <?= number_format($products->prod_price,0,',','.'); ?></ins></div><!-- Product Single - Price End -->

            <div class="clear"></div>
            <div class="line"></div>

            <!-- Product Single - Quantity & Cart Button
            ============================================= -->
            <form class="cart nobottommargin clearfix" method="post" enctype='multipart/form-data'>
                <div class="quantity clearfix">
                    <input type="button" value="-" class="minus" onclick="getquantity('minus')">
                    <input type="text" step="1" min="1"  name="quantity" value="1" title="Qty" class="qty" size="4" />
                    <input type="button" value="+" class="plus" onclick="getquantity('plus')">
                </div>
                <button type="button" class="add-to-cart button nomargin" onclick="addtocart()">Add to cart</button>
            </form><!-- Product Single - Quantity & Cart Button End -->

            <div class="clear"></div>
            <div class="line"></div>
            @endif

            <!-- Product Single - Short Description
            ============================================= -->
            <?= nl2br($products->prod_desc); ?>
            </ul><!-- Product Single - Short Description End -->

            <!-- Product Single - Meta
            ============================================= -->
            <div class="panel panel-default product-meta">
                <div class="panel-body">
                    <!-- <span itemprop="productID" class="sku_wrapper">SKU : <span class="sku">{{ $products->prod_code }}</span></span> -->
                    <span class="posted_in">Category:
                        <?php
                            $prod_category = explode(',',$products->prod_category);
                            $limit = count($prod_category);

                            $i = 1;
                            $category = '';
                            foreach ($prod_category as $cate) {
                                $getprodcate = DB::table('lk_product_category')->where('kateg_id',$cate)->first();
                                if (count($getprodcate) != 0) {
                                    if ($i == $limit) {
                                        echo '<a href="'.url('products').'" rel="tag">'.$getprodcate->kateg_name.'</a>.';
                                    } else {
                                        echo '<a href="'.url('products').'" rel="tag">'.$getprodcate->kateg_name.'</a>,';
                                    }
                                }

                                $i++;
                            }
                        ?>
                    </span>
                </div>
            </div><!-- Product Single - Meta End -->

        </div>

        <!-- <div class="col_one_fifth col_last">
            <a href="javascript:void(0)" title="Brand Logo" class="hidden-xs">
                <img class="image_fade" src="{{ url($websetting->logo) }}" alt="{{ $websetting->company_name }}">
            </a>
            <div class="divider divider-center"><i class="icon-circle-blank"></i></div>

            <div class="feature-box fbox-plain fbox-dark fbox-small">
                <div class="fbox-icon">
                    <i class="icon-email"></i>
                </div>
                <h3>Email</h3>
                <p class="notopmargin">{{ $websetting->email }}</p>
            </div>

            <div class="feature-box fbox-plain fbox-dark fbox-small">
                <div class="fbox-icon">
                    <i class="icon-phone"></i>
                </div>
                <h3>Phone</h3>
                <p class="notopmargin">{{ $websetting->telp }}</p>
            </div>

            <div class="feature-box fbox-plain fbox-dark fbox-small">
                <div class="fbox-icon">
                    <i class="icon-thumbs-up2"></i>
                </div>
                <h3>Address</h3>
                <p class="notopmargin">{{ $websetting->address }}</p>
            </div>

        </div> -->

    </div>
</div>

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
        var qty         = $('[name=quantity]').val();
        var price       = '{{ $products->prod_price }}';
        var image       = '{{ $products->front_image }}';
        var url         = '{{ $products->prod_url }}';

        var datapost = {
            "_token"    : '{{ csrf_token() }}',
            "prodid"    : prodid,
            "prodname"  : prodname,
            "qty"       : qty,
            "price"     : price,
            "image"     : image,
            "url"       : url
        }

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
                    swal("Success !", "Success Add To Cart", "success");

                    $('#top-cart-trigger').find('span').html(data[2]);
                    $(".top-cart-items").html(data[3]);
                    $(".top-cart-action").html(data[4]);
                } else if(data[1] == 2) {
                    // alert('Add To Cart Failed');
                    swal("Error !", "Stock Not Available", "error");
                } else {
                    // alert('Add To Cart Failed');
                    swal("Error !", "Error Add To Cart", "error");
                }

                $('.add-to-cart').attr('onclick','addtocart()');
                $('.add-to-cart').html('Add to cart');
            }
        })
    }
</script>
