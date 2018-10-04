@if($instagramcolumn3 == 'gagal bray')

@else

<div class="container" style="margin-top:5%;margin-bottom:5%;">
    <h3 style="text-align:center;">Instagram Feed</h3>

    @foreach($instagramcolumn3->media->nodes as $key => $insta)
        @if($key < 3 )
            <div class="col-md-4" style="padding-left:5px;padding-right:5px;">
                <a href="https://www.instagram.com/p/{{ $insta->code }}/?taken-by={{ $instagramcolumn3->username }}" target="_blank">
                    <div class="insta-bg" style="width:100%;background:url({{ $insta->display_src }});background-size:cover;background-position:center center;background-repeat:no-repeat;" >
                    </div>
                </a>
            </div>
        @endif
    @endforeach

    <div class="clearfix"></div>
    <div class="col-md-12" style="text-align:center;margin-top:20px;">
        <a href="http://instagram.com/{{ $instagramcolumn3->username }}" target="_blank" class="button button-black t300 button-dark ls2">
            <?php echo "Follow @".$instagramcolumn3->username; ?>
        </a>
    </div>
</div>

<script type="text/javascript">
    var width = $('.insta-bg').width();
    $('.insta-bg').height(width);
</script>

@endif
