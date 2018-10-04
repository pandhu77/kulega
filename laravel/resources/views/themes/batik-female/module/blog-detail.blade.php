<div class="postcontent nobottommargin clearfix">

    <div class="single-post nobottommargin">

        <!-- Single Post
        ============================================= -->
        <div class="entry clearfix">

            <!-- Entry Title
            ============================================= -->
            <div class="entry-title">
                <h2>{{ $blog->title }}</h2>
                <br>
            </div><!-- .entry-title end -->

            <!-- Entry Meta
            ============================================= -->

            <!-- Entry Image
            ============================================= -->
            <div class="entry-image">
                <a href="javascript:void(0)"><img src="{{ url($blog->image) }}" alt="{{ $blog->title }}"></a>
            </div><!-- .entry-image end -->

            <!-- Entry Content
            ============================================= -->
            <div class="entry-content notopmargin">
                <?= nl2br($blog->content) ?>
            </div>
        </div><!-- .entry end -->

    </div>

</div><!-- .postcontent end -->

<!-- Sidebar
============================================= -->
<div class="sidebar nobottommargin col_last clearfix">
    <div class="sidebar-widgets-wrap">

        <div class="widget clearfix">

            <div class="tabs nobottommargin clearfix" id="sidebar-tabs">

                <ul class="tab-nav clearfix">
                    <li><a href="#tabs-1">Recent</a></li>
                </ul>

                <div class="tab-container">

                    <div class="tab-content clearfix" id="tabs-1">
                        <div id="popular-post-list-sidebar">

                            <?php $allblog = DB::table('cms_blog')->where('url','!=',$blog->url)->get(); ?>

                            @foreach($allblog as $all)
                            <div class="spost clearfix">
                                <div class="entry-image">
                                    <a href="{{ url('blog/'.$all->url) }}" class="nobg"><img class="img-circle" src="{{ url($all->image) }}" alt="{{ $all->title }}"></a>
                                </div>
                                <div class="entry-c">
                                    <div class="entry-title">
                                        <h4><a href="{{ url('blog/'.$all->url) }}">{{ $all->title }}</a></h4>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div><!-- .sidebar end -->
