<!-- Post Content
============================================= -->
<div class="postcontent nobottommargin col_last">

    <!-- Shop
    ============================================= -->
    <div id="shop" class="shop product-3 grid-container clearfix">

        @foreach($productslist as $prod)
        <?php $prod_category = explode(",",$prod->prod_category); ?>
            <div class="product <?php foreach($prod_category as $prodcate){echo 'filter-'.$prodcate.' ';} ?>clearfix">
                <div class="product-image">
                    <div class="slide">
                        <a href="{{ url('products/'.$prod->prod_url) }}">
                            <img src="{{ asset($prod->front_image) }}" alt="{{ $prod->prod_name }}" style="object-fit:scale-down;width:100%;">
                        </a>
                    </div>
                    <div class="product-overlay">
                        <!-- <a href="#" class="add-to-cart" style="width:100%;"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a> -->
                        <!-- <a href="include/ajax/shop-item.html" class="item-quick-view" data-lightbox="ajax"><i class="icon-zoom-in2"></i><span> Quick View</span></a> -->
                    </div>
                </div>
                <div class="product-desc center">
                    <div class="product-title"><h3><a href="{{ url('products/'.$prod->prod_url) }}">{{ $prod->prod_name }}</a></h3></div>
                    <div class="product-price">IDR <?= number_format($prod->prod_price,0,',','.'); ?></div>
                </div>
            </div>
        @endforeach

    </div><!-- #shop end -->

</div><!-- .postcontent end -->

<!-- Sidebar
============================================= -->
<div class="sidebar nobottommargin">
    <div class="sidebar-widgets-wrap">

        <div class="widget widget-filter-links clearfix">
            <?php
                $category = DB::table('lk_product_category')
                            ->where('kateg_parent','=',0)
                            ->where('kateg_enable','=',1)
                            ->get();
            ?>

            <h4>Select Category</h4>
            <ul class="custom-filter" data-container="#shop" data-active-class="active-filter">
                <li class="widget-filter-reset active-filter"><a href="#" data-filter="*">Clear</a></li>
                @foreach($category as $cate)
                    <li><a href="#" data-filter=".filter-{{ $cate->kateg_id }}">{{ $cate->kateg_name }}</a></li>
                @endforeach
            </ul>

        </div>

        <div class="widget widget-filter-links clearfix">

            <h4>Sort By</h4>
            <ul class="shop-sorting">
                <li class="widget-filter-reset active-filter"><a href="#" data-sort-by="original-order">Clear</a></li>
                <li><a href="#" data-sort-by="name">Name</a></li>
                <li><a href="#" data-sort-by="price_lh">Price: Low to High</a></li>
                <li><a href="#" data-sort-by="price_hl">Price: High to Low</a></li>
            </ul>

        </div>

    </div>
</div><!-- .sidebar end -->

<script>
    jQuery(document).ready( function($){
        $('#shop').isotope({
            transitionDuration: '0.65s',
            getSortData: {
                name: '.product-title',
                price_lh: function( itemElem ) {
                    if( $(itemElem).find('.product-price').find('ins').length > 0 ) {
                        var price = $(itemElem).find('.product-price ins').text();
                    } else {
                        var price = $(itemElem).find('.product-price').text();
                    }

                    priceNum = price.split("IDR ");

                    return parseFloat( priceNum[1] );
                },
                price_hl: function( itemElem ) {
                    if( $(itemElem).find('.product-price').find('ins').length > 0 ) {
                        var price = $(itemElem).find('.product-price ins').text();
                    } else {
                        var price = $(itemElem).find('.product-price').text();
                    }

                    priceNum = price.split("IDR ");

                    return parseFloat( priceNum[1] );
                }
            },
            sortAscending: {
                name: true,
                price_lh: true,
                price_hl: false
            }
        });

        $('.custom-filter:not(.no-count)').children('li:not(.widget-filter-reset)').each( function(){
            var element = $(this),
                elementFilter = element.children('a').attr('data-filter'),
                elementFilterContainer = element.parents('.custom-filter').attr('data-container');

            elementFilterCount = Number( jQuery(elementFilterContainer).find( elementFilter ).length );

            element.append('<span>'+ elementFilterCount +'</span>');

        });

        $('.shop-sorting li').click( function() {
            $('.shop-sorting').find('li').removeClass( 'active-filter' );
            $(this).addClass( 'active-filter' );
            var sortByValue = $(this).find('a').attr('data-sort-by');
            $('#shop').isotope({ sortBy: sortByValue });
            return false;
        });
    });
</script>

@push('js')
<script type="text/javascript">
    var slide_w = $('.slide').width();
    $('.slide').find('img').height(slide_w);
</script>
@endpush
