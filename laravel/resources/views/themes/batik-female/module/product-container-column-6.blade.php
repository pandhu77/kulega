<?php if(count($productcontainercolumn6) > 0){ ?>

<div class="section clearfix"  style="padding: 80px 0;background-color:white;">
    <div class="container clearfix">

        <div class="heading-block nobottomborder center">
            <h3 class="t400" style="font-size: 16px;">Products</h3>
        </div>

        <div class="row clearfix">

            @foreach($productcontainercolumn6 as $key => $prod)
            <?php
                $websetting = DB::table('cms_config')->first();
                if($key < 6){
            ?>
                    <div class="col-md-2 col-sm-6">
                        <div class="iportfolio clearfix">
                            <div class="portfolio-image clearfix">
                                <div class="slide">
                                    <a href="{{ url('products/'.$prod->prod_url) }}">
                                        <img src="{{ asset($prod->front_image) }}" alt="{{ $prod->prod_name }}" style="object-fit:scale-down;width:100%;">
                                    </a>
                                </div>
                            </div>
                            <div class="product-desc center">
                                <div class="product-title"><h3><a href="{{ url('products/'.$prod->prod_url) }}">{{ $prod->prod_name }}</a></h3></div>
                                @if($websetting->type == 'ecommerce')
                                    <div class="product-price">IDR <?= number_format($prod->prod_price,0,',','.'); ?></div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="bottommargin visible-xs"></div>
            <?php
                }
            ?>
            @endforeach

        </div>

    </div>
</div>

<?php } ?>

@push('js')
<script type="text/javascript">
    var slide_w = $('.slide').width();
    $('.slide').find('img').height(slide_w);
</script>
@endpush
