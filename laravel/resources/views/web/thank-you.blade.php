@extends('web.master')
@section('title','Sonia')
@section('content')

@push('css')

@endpush

<section id="content">

    <div class="content-wrap" style="padding:85px 0;">

        <div class="container clearfix" style="border: 1px solid #eee;padding: 40px;background-color:#fff;">

            <div class="tabs divcenter nobottommargin clearfix" id="tab-login-register" style="max-width: 800px;text-align:center;">

                <h3 style="font-weight:400;">Thank you for your payment confirm for order <span style="font-weight:900;color:#1ABC9C;">#<?php echo $orderid; ?></span>.<br> We will check and process your order as soon as possible.</h3>

                <a href="{{ url('/') }}" class="btn btn-default" style="border-radius:0px;padding:10px 30px;background-color:#1ABC9C;border-color:#1ABC9C;">Shop More</a>

            </div>

        </div>

    </div>

</section><!-- #content end -->

@push('js')
<script type="text/javascript">
    function gettoken(id){
        $('[name=_token]').val('{{ csrf_token() }}');
        $('#'+id).submit();
    }
</script>
@endpush

@endsection
