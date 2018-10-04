shippingprovince();

function shippingprovince(){
    var datapost = {
        "_token" : "{{ csrf_token() }}"
    }

    $.ajax({
        type : "POST",
        url : "{{ url('shipping/province') }}",
        data : datapost,
        success : function(data){
            $('[name=province]').html(data);
            var total_cart      = $('.top-checkout-price').text();
            $('#cart-subtotal').html(total_cart);
            $('#cart-total').html(total_cart);
        }
    })
}

function shippingcity(){
    var province = $('[name=province]').val();
    var datapost = {
        "_token"    : "{{ csrf_token() }}",
        "province"  : province
    }

    $.ajax({
        type : "POST",
        url : "{{ url('shipping/city') }}",
        data : datapost,
        beforeSend : function(){
            $('[name=city]').html('<option value="">Loading</option>');
            $('[name=district]').html('<option value="">Loading</option>');
            $('[name=courier]').html('<option value="">Loading</option>');
            $('[name=cost]').html('<option value="">Loading</option>');
        },
        success : function(data){
            $('[name=city]').html(data);
            $('[name=district]').html('<option value="">Select District</option>');
            $('[name=courier]').html('<option value="">Select Courier</option>');
            $('[name=cost]').html('<option value="0">Select Cost</option>');
        }
    })
}

function shippingdistrict(){
    var city = $('[name=city]').val();
    var datapost = {
        "_token"    : "{{ csrf_token() }}",
        "city"      : city
    }

    $.ajax({
        type : "POST",
        url : "{{ url('shipping/district') }}",
        data : datapost,
        beforeSend : function(){
            $('[name=district]').html('<option value="">Loading</option>');
            $('[name=courier]').html('<option value="">Loading</option>');
            $('[name=cost]').html('<option value="">Loading</option>');
        },
        success : function(data){
            $('[name=district]').html(data);
            $('[name=courier]').html('<option value="">Select Courier</option>');
            $('[name=cost]').html('<option value="0">Select Cost</option>');
        }
    })
}

function shippingcourier(){
    var datapost = {
        "_token"    : "{{ csrf_token() }}"
    }

    $.ajax({
        type : "POST",
        url : "{{ url('shipping/courier') }}",
        data : datapost,
        beforeSend : function(){
            $('[name=courier]').html('<option value="">Loading</option>');
            $('[name=cost]').html('<option value="">Loading</option>');
        },
        success : function(data){
            $('[name=courier]').html(data);
            $('[name=cost]').html('<option value="0">Select Cost</option>');
        }
    })
}

function shippingcost(){
    var district    = $('[name=district]').val();
    var courier     = $('[name=courier]').val();
    var datapost    = {
        "_token"    : "{{ csrf_token() }}",
        "district"  : district,
        "courier"   : courier
    }

    $.ajax({
        type : "POST",
        url : "{{ url('shipping/cost') }}",
        data : datapost,
        beforeSend : function(){
            $('[name=cost]').html('<option value="">Loading</option>');
        },
        success : function(data){
            $('[name=cost]').html(data);
        }
    })
}

function shippingcalculate(){
    var total_cart      = $('.top-checkout-price').text().replace('.', '');
    var shipping_cost   = $('[name=cost]').val();
    var calculate       = parseInt(total_cart) + parseInt(shipping_cost);
    $('#shipping-price').html((shipping_cost/1000).toFixed(3));
    $('#cart-total').html((calculate/1000).toFixed(3));
}

function getquantity(rowId,trigger){
    var qty = $('#'+rowId).find('[name=quantity]').val();
    if (trigger == 'minus') {
        if (qty == 1) {
            removerow(rowId);
        } else {
            var count = parseInt(qty) - 1;
            $('#'+rowId).find('[name=quantity]').val(count);
            updaterow(rowId);
        }
    } else if(trigger == 'plus') {
        var count = parseInt(qty) + 1;
        $('#'+rowId).find('[name=quantity]').val(count);
        updaterow(rowId);
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

function updaterow(rowId){
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
            $('#'+rowId).html(data[2]);
            $('#top-cart-trigger').find('span').html(data[1]);
            $(".top-cart-items").html(data[3]);
            $(".top-cart-action").html(data[4]);
            $('#cart-subtotal').html($('.top-checkout-price').text());
            $('#cart-total').html($('.top-checkout-price').text());
            shippingcalculate();
        }
    })
}
