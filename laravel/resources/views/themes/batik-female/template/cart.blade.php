@extends('web.app')
@section('content')

<?php $website = DB::table('cms_config')->first(); ?>
<title>Cart | {{ $website->site_name }}</title>

<!-- Page Title
============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1>Cart</h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('shop') }}">Shop</a></li>
            <li class="active">Cart</li>
        </ol>
    </div>

</section><!-- #page-title end -->

<!-- Content
============================================= -->
<?php $getsetting = DB::table('t_theme_setting')->where('active',1)->first(); ?>
<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            @include('themes.'.$getsetting->name.'.module.cart-table')

            @include('themes.'.$getsetting->name.'.module.cart-shipping')

        </div>

    </div>

</section><!-- #content end -->

<script type="text/javascript">

    shippingprovince();

    function shippingprovince(){
        var datapost = {
            "_token" : "{{ csrf_token() }}"
        }

        $.ajax({
            type : "POST",
            url : "{{ url('shipping/province') }}",
            data : datapost,
            beforeSend : function(){
                $('[name=province]').html('<option value="">Loading</option>');
                $('[name=city]').html('<option value="">Loading</option>');
                $('[name=district]').html('<option value="">Loading</option>');
                $('[name=courier]').html('<option value="">Loading</option>');
                $('[name=cost]').html('<option value="0">Loading</option>');
            },
            success : function(data){
                $('[name=province]').html(data);
                $('[name=city]').html('<option value="">Select</option>');
                $('[name=district]').html('<option value="">Select</option>');
                $('[name=courier]').html('<option value="">Select</option>');
                $('[name=cost]').html('<option value="0">Select</option>');

                var total_cart      = $('.top-checkout-price').text();
                $('#cart-subtotal').html(total_cart);
                $('#cart-total').html(total_cart);

                shippingcalculate();

                if ("{{ Session::get('city') }}") {
                    shippingcity(2);
                }
            }
        })
    }

    function shippingcity(trigger){
        var province = $('[name=province]').val();
        var datapost = {
            "_token"    : "{{ csrf_token() }}",
            "province"  : province,
            "trigger"   : trigger
        }

        $.ajax({
            type : "POST",
            url : "{{ url('shipping/city') }}",
            data : datapost,
            beforeSend : function(){
                $('[name=city]').html('<option value="">Loading</option>');
                $('[name=district]').html('<option value="">Loading</option>');
                $('[name=courier]').html('<option value="">Loading</option>');
                $('[name=cost]').html('<option value="0">Loading</option>');
            },
            success : function(data){
                $('[name=city]').html(data);
                $('[name=district]').html('<option value="">Select District</option>');
                $('[name=courier]').html('<option value="false">Select Courier</option>');
                $('[name=cost]').html('<option value="0">Select Cost</option>');

                shippingcalculate();

                if (trigger == 2) {
                    shippingdistrict(2);
                }
            }
        })
    }

    function shippingdistrict(trigger){
        var city = $('[name=city]').val();
        var datapost = {
            "_token"    : "{{ csrf_token() }}",
            "city"      : city,
            "trigger"   : trigger
        }

        $.ajax({
            type : "POST",
            url : "{{ url('shipping/district') }}",
            data : datapost,
            beforeSend : function(){
                $('[name=district]').html('<option value="">Loading</option>');
                $('[name=courier]').html('<option value="">Loading</option>');
                $('[name=cost]').html('<option value="0">Loading</option>');
            },
            success : function(data){
                $('[name=district]').html(data);
                $('[name=courier]').html('<option value="false">Select Courier</option>');
                $('[name=cost]').html('<option value="0">Select Cost</option>');

                shippingcalculate();

                if (trigger == 2) {
                    shippingcourier(2);
                }
            }
        })
    }

    function shippingcourier(trigger){
        var datapost = {
            "_token"    : "{{ csrf_token() }}",
            "trigger"   : trigger
        }

        $.ajax({
            type : "POST",
            url : "{{ url('shipping/courier') }}",
            data : datapost,
            beforeSend : function(){
                $('[name=courier]').html('<option value="">Loading</option>');
                $('[name=cost]').html('<option value="0">Loading</option>');
            },
            success : function(data){
                $('[name=courier]').html(data);
                $('[name=cost]').html('<option value="0">Select Cost</option>');

                shippingcalculate();

                if (trigger == 2) {
                    shippingcost(2);
                }
            }
        })
    }

    function shippingcost(trigger){
        var district    = $('[name=district]').val();
        var courier     = $('[name=courier]').val();
        var datapost    = {
            "_token"    : "{{ csrf_token() }}",
            "district"  : district,
            "courier"   : courier,
            "trigger"   : trigger
        }

        $.ajax({
            type : "POST",
            url : "{{ url('shipping/cost') }}",
            data : datapost,
            beforeSend : function(){
                $('[name=cost]').html('<option value="0">Loading</option>');
            },
            success : function(data){
                $('[name=cost]').html(data);

                if (trigger == 2) {
                    shippingcalculate();
                }
            }
        })
    }

    function shippingcalculate(){
        var total_cart      = $('.top-checkout-price').text().replace(/[^a-z0-9\s]/gi, '');
        var shipping_cost   = $('[name=cost]').val();
        var calculate       = parseInt(total_cart) + parseInt(shipping_cost);
        $('#shipping-price').html(shipping_cost.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
        $('#cart-total').html(calculate.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
    }

    function getquantity(rowId,trigger){
        var qty = $('#'+rowId).find('[name=quantity]').val();
        if (trigger == 'minus') {
            if (qty == 1) {
                removerow(rowId);
            } else {
                var count = parseInt(qty) - 1;
                $('#'+rowId).find('[name=quantity]').val(count);
                updaterow(rowId,qty);
            }
        } else if(trigger == 'plus') {
            var count = parseInt(qty) + 1;
            $('#'+rowId).find('[name=quantity]').val(count);
            updaterow(rowId,qty);
        }
    }

    function removerow(rowId){
        if (confirm('Are you sure ?')) {
            var datapost = {
                "_token": "{{ csrf_token() }}",
                "rowId" : rowId
            }

            $.ajax({
                type    : "POST",
                url     : "{{ url('ajax/removerow') }}",
                data    : datapost,
                dataType: "json",
                beforeSend : function(){

                },
                success : function(data){
                    $('#cartbody').html(data[2]);
                    $('#top-cart-trigger').find('span').html(data[1]);
                    $(".top-cart-items").html(data[3]);
                    $(".top-cart-action").html(data[4]);
                    $('#cart-subtotal').html($('.top-checkout-price').text());
                    $('#cart-total').html($('.top-checkout-price').text());
                    shippingcalculate();
                }
            })
        }
    }

    function updaterow(rowId,qtystart){
        var qty = $('#'+rowId).find('[name=quantity]').val();
        var datapost = {
            "_token": "{{ csrf_token() }}",
            "rowId" : rowId,
            "qty"   : qty
        }

        $.ajax({
            type    : "POST",
            url     : "{{ url('ajax/updaterow') }}",
            data    : datapost,
            dataType: "json",
            beforeSend : function(){

            },
            success : function(data){
                if (data[0] == 0) {
                    swal("Error !", "Stock Not Available", "error");
                    $('#'+rowId).find('[name=quantity]').val(qtystart);
                }else {
                    $('#'+rowId).html(data[2]);
                    $('#top-cart-trigger').find('span').html(data[1]);
                    $(".top-cart-items").html(data[3]);
                    $(".top-cart-action").html(data[4]);
                    $('#cart-subtotal').html($('.top-checkout-price').text());
                    $('#cart-total').html($('.top-checkout-price').text());
                    shippingcalculate();
                }
            }
        })
    }

</script>

@stop
