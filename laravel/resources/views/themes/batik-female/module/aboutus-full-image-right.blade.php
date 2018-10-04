<style media="screen">
    #aboutus-full-right{
        margin-top: 5%;
        margin-bottom: 5%;
    }

    #aboutus-full-right #image{
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        height: 400px;
    }

    #aboutus-full-right #desc{
        margin-top: 20px;
    }

    #aboutus-full-right #desc p{
        font-size: 16px;
        text-align: justify;
    }
</style>


<div class="col-md-offset-3 col-md-6" id="aboutus-full-right">
    <div class="col-md-6" style="float: right;">
        <img src="{{ url($aboutusfullimageleft[1]->value) }}" class="img-responsive">
    </div>
    <div class="col-md-6" id="desc">
        <h3>{{ $aboutusfullimageright[2]->value }}</h3>
        <p>
            {{ $aboutusfullimageright[0]->value }}
        </p>
    </div>
</div>

<script type="text/javascript">
    var image_h = $('#image').height();
    $('#desc').height(image_h);
</script>
