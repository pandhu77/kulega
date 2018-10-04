<div id="posts" class="post-grid grid-container grid-2 clearfix" data-layout="fitRows">

    @foreach($blogcolumn2 as $blog)
    <div class="entry clearfix">
        <div class="entry-image">
            <a href="{{ url('blog/'.$blog->url) }}" data-lightbox="image"><img class="image_fade" src="{{ url($blog->image) }}" alt="{{ $blog->title }}"></a>
        </div>
        <div class="entry-title">
            <h2><a href="{{ url('blog/'.$blog->url) }}">{{ $blog->title }}</a></h2>
        </div>
        <div class="entry-content">
            <a href="{{ url('blog/'.$blog->url) }}" class="more-link">Read More</a>
        </div>
    </div>
    @endforeach

</div>
