@extends('web.master')
@section('title','www.kulega.com')
@section('content')

<?php $website = DB::table('cms_config')->first(); ?>
<title>Pages | {{ $website->site_name }}</title>

<style media="screen">
    #content{
        background-position: right;
        background-size: cover;
        background-repeat: no-repeat !important;
    }
</style>

<!-- Content
============================================= -->
<?php $getsetting = DB::table('t_theme_setting')->where('active',1)->first(); ?>

<section id="content" style="background:url({{ url($page->image) }})">

    <div class="content-wrap" style="padding-bottom:20px;">

        <div class="container clearfix">

            <div class="single-post nobottommargin">

                <!-- Single Post
                ============================================= -->
                <div class="entry clearfix">

                    <!-- Entry Title
                    ============================================= -->
                    <div class="entry-title">
                        <h2 style="text-align:center;">{{ $page->title }}</h2>
                    </div><!-- .entry-title end -->

                    <!-- Entry Meta
                    ============================================= -->
                    <ul class="entry-meta clearfix">
                        <li> </li>
                    </ul><!-- .entry-meta end -->

                    <!-- Entry Image
                    ============================================= -->
                    <!-- <div class="entry-image bottommargin">
                        <a href="#"><img src="images/blog/full/10.jpg" alt="Blog Single"></a>
                    </div> -->

                    <!-- Entry Content
                    ============================================= -->
                    <div class="entry-content notopmargin">

                        <?= nl2br($page->content) ?>
                        <!-- Post Single - Content End -->

                        <div class="clear"></div>

                        <!-- Post Single - Share
                        ============================================= -->
                        <!-- <div class="si-share noborder clearfix">
                            <span>Share this Post:</span>
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
                </div><!-- .entry end -->

            </div>


        </div>

    </div>

</section><!-- #content end -->

@stop
