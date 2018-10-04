@extends('web.app')
@section('content')

<?php $website = DB::table('web_setting')->first(); ?>
<title>Shop | {{ $website->name }}</title>

<!-- Page Title
============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1>Shop</h1>
        <ol class="breadcrumb">
            <li><a href="index.html">Home</a></li>
            <li class="active">Shop</li>
        </ol>
    </div>

</section><!-- #page-title end -->

<!-- Content
============================================= -->
<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <!-- Post Content
            ============================================= -->
            <div class="postcontent nobottommargin col_last">

                <!-- Shop
                ============================================= -->
                <div id="shop" class="shop product-3 grid-container clearfix">

                    <div class="product sf-dress clearfix">
                        <div class="product-image">
                            <a href="shop-detail.html"><img src="{{ asset('assets/images/shop/dress/1.jpg') }}" alt="Checked Short Dress"></a>
                            <a href="shop-detail.html"><img src="{{ asset('assets/images/shop/dress/1-1.jpg') }}" alt="Checked Short Dress"></a>
                            <div class="sale-flash">SALE!</div>
                            <div class="product-overlay">
                                <a href="#" class="add-to-cart"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a>
                                <a href="include/ajax/shop-item.html" class="item-quick-view" data-lightbox="ajax"><i class="icon-zoom-in2"></i><span> Quick View</span></a>
                            </div>
                        </div>
                        <div class="product-desc center">
                            <div class="product-title"><h3><a href="shop-detail.html">Checked Short Dress</a></h3></div>
                            <div class="product-price"><del>$24.99</del> <ins>$12.49</ins></div>
                            <div class="product-rating">
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star-half-full"></i>
                            </div>
                        </div>
                    </div>

                    <div class="product sf-pant clearfix">
                        <div class="product-image">
                            <a href="shop-detail.html"><img src="{{ asset('assets/images/shop/pants/1-1.jpg') }}" alt="Slim Fit Chinos"></a>
                            <a href="shop-detail.html"><img src="{{ asset('assets/images/shop/pants/1.jpg') }}" alt="Slim Fit Chinos"></a>
                            <div class="product-overlay">
                                <a href="#" class="add-to-cart"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a>
                                <a href="include/ajax/shop-item.html" class="item-quick-view" data-lightbox="ajax"><i class="icon-zoom-in2"></i><span> Quick View</span></a>
                            </div>
                        </div>
                        <div class="product-desc center">
                            <div class="product-title"><h3><a href="shop-detail.html">Slim Fit Chinos</a></h3></div>
                            <div class="product-price">$39.99</div>
                            <div class="product-rating">
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star-half-full"></i>
                                <i class="icon-star-empty"></i>
                            </div>
                        </div>
                    </div>

                    <div class="product sf-shoes clearfix">
                        <div class="product-image">
                            <div class="fslider" data-arrows="false">
                                <div class="flexslider">
                                    <div class="slider-wrap">
                                        <div class="slide"><a href="shop-detail.html"><img src="{{ asset('assets/images/shop/shoes/1.jpg') }}" alt="Dark Brown Boots"></a></div>
                                        <div class="slide"><a href="shop-detail.html"><img src="{{ asset('assets/images/shop/shoes/1-1.jpg') }}" alt="Dark Brown Boots"></a></div>
                                        <div class="slide"><a href="shop-detail.html"><img src="{{ asset('assets/images/shop/shoes/1-2.jpg') }}" alt="Dark Brown Boots"></a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-overlay">
                                <a href="#" class="add-to-cart"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a>
                                <a href="include/ajax/shop-item.html" class="item-quick-view" data-lightbox="ajax"><i class="icon-zoom-in2"></i><span> Quick View</span></a>
                            </div>
                        </div>
                        <div class="product-desc center">
                            <div class="product-title"><h3><a href="shop-detail.html">Dark Brown Boots</a></h3></div>
                            <div class="product-price">$49</div>
                            <div class="product-rating">
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star-empty"></i>
                                <i class="icon-star-empty"></i>
                            </div>
                        </div>
                    </div>

                    <div class="product sf-dress clearfix">
                        <div class="product-image">
                            <a href="shop-detail.html"><img src="{{ asset('assets/images/shop/dress/2.jpg') }}" alt="Light Blue Denim Dress"></a>
                            <a href="shop-detail.html"><img src="{{ asset('assets/images/shop/dress/2-2.jpg') }}" alt="Light Blue Denim Dress"></a>
                            <div class="product-overlay">
                                <a href="#" class="add-to-cart"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a>
                                <a href="include/ajax/shop-item.html" class="item-quick-view" data-lightbox="ajax"><i class="icon-zoom-in2"></i><span> Quick View</span></a>
                            </div>
                        </div>
                        <div class="product-desc center">
                            <div class="product-title"><h3><a href="shop-detail.html">Light Blue Denim Dress</a></h3></div>
                            <div class="product-price">$19.95</div>
                            <div class="product-rating">
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star-empty"></i>
                            </div>
                        </div>
                    </div>

                    <div class="product sf-sunglass clearfix">
                        <div class="product-image">
                            <a href="shop-detail.html"><img src="{{ asset('assets/images/shop/sunglasses/1.jpg') }}" alt="Unisex Sunglasses"></a>
                            <a href="shop-detail.html"><img src="{{ asset('assets/images/shop/sunglasses/1-1.jpg') }}" alt="Unisex Sunglasses"></a>
                            <div class="sale-flash">Sale!</div>
                            <div class="product-overlay">
                                <a href="#" class="add-to-cart"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a>
                                <a href="include/ajax/shop-item.html" class="item-quick-view" data-lightbox="ajax"><i class="icon-zoom-in2"></i><span> Quick View</span></a>
                            </div>
                        </div>
                        <div class="product-desc center">
                            <div class="product-title"><h3><a href="shop-detail.html">Unisex Sunglasses</a></h3></div>
                            <div class="product-price"><del>$19.99</del> <ins>$11.99</ins></div>
                            <div class="product-rating">
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star-empty"></i>
                                <i class="icon-star-empty"></i>
                            </div>
                        </div>
                    </div>

                    <div class="product sf-tshirt clearfix">
                        <div class="product-image">
                            <a href="shop-detail.html"><img src="{{ asset('assets/images/shop/tshirts/1.jpg') }}" alt="Blue Round-Neck Tshirt"></a>
                            <a href="shop-detail.html"><img src="{{ asset('assets/images/shop/tshirts/1-1.jpg') }}" alt="Blue Round-Neck Tshirt"></a>
                            <div class="product-overlay">
                                <a href="#" class="add-to-cart"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a>
                                <a href="include/ajax/shop-item.html" class="item-quick-view" data-lightbox="ajax"><i class="icon-zoom-in2"></i><span> Quick View</span></a>
                            </div>
                        </div>
                        <div class="product-desc center">
                            <div class="product-title"><h3><a href="shop-detail.html">Blue Round-Neck Tshirt</a></h3></div>
                            <div class="product-price">$9.99</div>
                            <div class="product-rating">
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star-half-full"></i>
                                <i class="icon-star-empty"></i>
                            </div>
                        </div>
                    </div>

                    <div class="product sf-watch clearfix">
                        <div class="product-image">
                            <a href="shop-detail.html"><img src="{{ asset('assets/images/shop/watches/1.jpg') }}" alt="Silver Chrome Watch"></a>
                            <a href="shop-detail.html"><img src="{{ asset('assets/images/shop/watches/1-1.jpg') }}" alt="Silver Chrome Watch"></a>
                            <div class="product-overlay">
                                <a href="#" class="add-to-cart"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a>
                                <a href="include/ajax/shop-item.html" class="item-quick-view" data-lightbox="ajax"><i class="icon-zoom-in2"></i><span> Quick View</span></a>
                            </div>
                        </div>
                        <div class="product-desc center">
                            <div class="product-title"><h3><a href="shop-detail.html">Silver Chrome Watch</a></h3></div>
                            <div class="product-price">$129.99</div>
                            <div class="product-rating">
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star-half-full"></i>
                            </div>
                        </div>
                    </div>

                    <div class="product sf-shoes clearfix">
                        <div class="product-image">
                            <a href="shop-detail.html"><img src="{{ asset('assets/images/shop/shoes/2.jpg') }}" alt="Men Grey Casual Shoes"></a>
                            <a href="shop-detail.html"><img src="{{ asset('assets/images/shop/shoes/2-1.jpg') }}" alt="Men Grey Casual Shoes"></a>
                            <div class="sale-flash">Sale!</div>
                            <div class="product-overlay">
                                <a href="#" class="add-to-cart"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a>
                                <a href="include/ajax/shop-item.html" class="item-quick-view" data-lightbox="ajax"><i class="icon-zoom-in2"></i><span> Quick View</span></a>
                            </div>
                        </div>
                        <div class="product-desc center">
                            <div class="product-title"><h3><a href="shop-detail.html">Men Grey Casual Shoes</a></h3></div>
                            <div class="product-price"><del>$45.99</del> <ins>$39.49</ins></div>
                            <div class="product-rating">
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star-half-full"></i>
                                <i class="icon-star-empty"></i>
                                <i class="icon-star-empty"></i>
                            </div>
                        </div>
                    </div>

                    <div class="product sf-dress clearfix">
                        <div class="product-image">
                            <div class="fslider" data-arrows="false">
                                <div class="flexslider">
                                    <div class="slider-wrap">
                                        <div class="slide"><a href="shop-detail.html"><img src="{{ asset('assets/images/shop/dress/3.jpg') }}" alt="Pink Printed Dress"></a></div>
                                        <div class="slide"><a href="shop-detail.html"><img src="{{ asset('assets/images/shop/dress/3-1.jpg') }}" alt="Pink Printed Dress"></a></div>
                                        <div class="slide"><a href="shop-detail.html"><img src="{{ asset('assets/images/shop/dress/3-2.jpg') }}" alt="Pink Printed Dress"></a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-overlay">
                                <a href="#" class="add-to-cart"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a>
                                <a href="include/ajax/shop-item.html" class="item-quick-view" data-lightbox="ajax"><i class="icon-zoom-in2"></i><span> Quick View</span></a>
                            </div>
                        </div>
                        <div class="product-desc center">
                            <div class="product-title"><h3><a href="shop-detail.html">Pink Printed Dress</a></h3></div>
                            <div class="product-price">$39.49</div>
                            <div class="product-rating">
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star-empty"></i>
                                <i class="icon-star-empty"></i>
                            </div>
                        </div>
                    </div>

                    <div class="product sf-pant clearfix">
                        <div class="product-image">
                            <a href="shop-detail.html"><img src="{{ asset('assets/images/shop/pants/5.jpg') }}" alt="Green Trousers"></a>
                            <a href="shop-detail.html"><img src="{{ asset('assets/images/shop/pants/5-1.jpg') }}" alt="Green Trousers"></a>
                            <div class="sale-flash">Sale!</div>
                            <div class="product-overlay">
                                <a href="#" class="add-to-cart"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a>
                                <a href="include/ajax/shop-item.html" class="item-quick-view" data-lightbox="ajax"><i class="icon-zoom-in2"></i><span> Quick View</span></a>
                            </div>
                        </div>
                        <div class="product-desc center">
                            <div class="product-title"><h3><a href="shop-detail.html">Green Trousers</a></h3></div>
                            <div class="product-price"><del>$24.99</del> <ins>$21.99</ins></div>
                            <div class="product-rating">
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star-half-full"></i>
                                <i class="icon-star-empty"></i>
                            </div>
                        </div>
                    </div>

                    <div class="product sf-sunglass clearfix">
                        <div class="product-image">
                            <a href="shop-detail.html"><img src="{{ asset('assets/images/shop/sunglasses/2.jpg') }}" alt="Men Aviator Sunglasses"></a>
                            <a href="shop-detail.html"><img src="{{ asset('assets/images/shop/sunglasses/2-1.jpg') }}" alt="Men Aviator Sunglasses"></a>
                            <div class="product-overlay">
                                <a href="#" class="add-to-cart"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a>
                                <a href="include/ajax/shop-item.html" class="item-quick-view" data-lightbox="ajax"><i class="icon-zoom-in2"></i><span> Quick View</span></a>
                            </div>
                        </div>
                        <div class="product-desc center">
                            <div class="product-title"><h3><a href="shop-detail.html">Men Aviator Sunglasses</a></h3></div>
                            <div class="product-price">$13.49</div>
                            <div class="product-rating">
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star-empty"></i>
                            </div>
                        </div>
                    </div>

                    <div class="product sf-tshirt clearfix">
                        <div class="product-image">
                            <a href="shop-detail.html"><img src="{{ asset('assets/images/shop/tshirts/4.jpg') }}" alt="Black Polo Tshirt"></a>
                            <a href="shop-detail.html"><img src="{{ asset('assets/images/shop/tshirts/4-1.jpg') }}" alt="Black Polo Tshirt"></a>
                            <div class="product-overlay">
                                <a href="#" class="add-to-cart"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a>
                                <a href="include/ajax/shop-item.html" class="item-quick-view" data-lightbox="ajax"><i class="icon-zoom-in2"></i><span> Quick View</span></a>
                            </div>
                        </div>
                        <div class="product-desc center">
                            <div class="product-title"><h3><a href="shop-detail.html">Black Polo Tshirt</a></h3></div>
                            <div class="product-price">$11.49</div>
                            <div class="product-rating">
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                            </div>
                        </div>
                    </div>

                </div><!-- #shop end -->

            </div><!-- .postcontent end -->

            <!-- Sidebar
            ============================================= -->
            <div class="sidebar nobottommargin">
                <div class="sidebar-widgets-wrap">

                    <div class="widget widget-filter-links clearfix">

                        <h4>Select Category</h4>
                        <ul class="custom-filter" data-container="#shop" data-active-class="active-filter">
                            <li class="widget-filter-reset active-filter"><a href="#" data-filter="*">Clear</a></li>
                            <li><a href="#" data-filter=".sf-dress">Dress</a></li>
                            <li><a href="#" data-filter=".sf-tshirt">Tshirts</a></li>
                            <li><a href="#" data-filter=".sf-pant">Pants</a></li>
                            <li><a href="#" data-filter=".sf-sunglass">Sunglasses</a></li>
                            <li><a href="#" data-filter=".sf-shoes">Shoes</a></li>
                            <li><a href="#" data-filter=".sf-watch">Watches</a></li>
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

        </div>

    </div>

</section><!-- #content end -->

@stop
