<style media="screen">
    #aboutus-full-left{
        margin-top: 5%;
        margin-bottom: 5%;
    }

    #aboutus-full-left #image{
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        height: 400px;
    }

    #aboutus-full-left #desc{
        margin-top: 20px;
        padding-left: 40px;
        padding-top: 50px;
    }

    #aboutus-full-left #desc p{
        font-size: 16px;
        text-align: justify;
    }
</style>


<div class="col-md-offset-2 col-md-8" id="aboutus-full-left">
    <div class="col-md-6">
        <img src="{{ url($aboutusfullimageleft[1]->value) }}" class="img-responsive">
    </div>
    <div class="col-md-6" id="desc">
        <h3>{{ $aboutusfullimageleft[2]->value }}</h3>
        <p>
            {{ $aboutusfullimageleft[0]->value }}
        </p>
    </div>
</div>

<script type="text/javascript">
    var image_h = $('#image').height();
    $('#desc').height(image_h);
</script>
