<div class="col_full nobottommargin">
    <h4>Related Products</h4>
    <div id="oc-product" class="owl-carousel product-carousel carousel-widget" data-margin="30" data-pagi="false" data-autoplay="5000" data-items-xs="1" data-items-sm="2" data-items-md="3" data-items-lg="4">

        <?php $websetting = DB::table('cms_config')->first(); ?>

        @foreach($allprod as $all)
            <div class="oc-item">
                <div class="product iproduct clearfix">
                    <div class="product-image">
                        <a href="{{ url('products/'.$all->prod_url) }}"><img src="{{ asset($all->front_image) }}" alt="{{ $all->prod_name }}"></a>
                        <div class="product-overlay">
                            <!-- <a href="#" class="add-to-cart" style="width:100%;"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a> -->
                            <!-- <a href="include/ajax/shop-item.html" class="item-quick-view" data-lightbox="ajax"><i class="icon-zoom-in2"></i><span> Quick View</span></a> -->
                        </div>
                    </div>
                    <div class="product-desc center">
                        <div class="product-title"><h3><a href="{{ url('products/'.$all->prod_url) }}">{{ $all->prod_name }}</a></h3></div>
                        @if($websetting->type == 'ecommerce')
                            <div class="product-price">IDR <?= number_format($all->prod_price,0,',','.'); ?></div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
