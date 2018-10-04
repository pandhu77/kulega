<div class="row clearfix">
    <div class="col-md-6 clearfix">
        <h4>Calculate Shipping</h4>
        <form>
            <div class="col_full">
                <select class="sm-form-control" name="province" onchange="shippingcity(1)">
                    <option value="">Select Province</option>
                </select>
            </div>
            <div class="col_full">
                <select class="sm-form-control" name="city" onchange="shippingdistrict(1)">
                    <option value="">Select City</option>
                </select>
            </div>
            <div class="col_full">
                <select class="sm-form-control" name="district" onchange="shippingcourier(1)">
                    <option value="">Select District</option>
                </select>
            </div>
            <div class="col_full">
                <select class="sm-form-control" name="courier" onchange="shippingcost(1)">
                    <option value="false">Select Courier</option>
                </select>
            </div>
            <div class="col_full">
                <select class="sm-form-control" name="cost" onchange="shippingcalculate()">
                    <option value="0">Select Cost</option>
                </select>
            </div>
        </form>
    </div>

    <div class="col-md-6 clearfix">
        <div class="table-responsive">
            <h4>Cart Totals</h4>
            <table class="table cart">
                <tbody>
                    <tr class="cart_item">
                        <td class="cart-product-name">
                            <strong>Cart Subtotal</strong>
                        </td>
                        <td class="cart-product-name">
                            <span class="amount" id="cart-subtotal"></span>
                        </td>
                    </tr>
                    <tr class="cart_item">
                        <td class="cart-product-name">
                            <strong>Shipping</strong>
                        </td>
                        <td class="cart-product-name">
                            <span class="amount" id="shipping-price">0</span>
                        </td>
                    </tr>
                    <tr class="cart_item">
                        <td class="cart-product-name">
                            <strong>Total</strong>
                        </td>
                        <td class="cart-product-name">
                            <span class="amount color lead"><strong id="cart-total"></strong></span>
                        </td>
                    </tr>
                    <tr class="cart_item">
                        <td colspan="2">
                            <div class="row clearfix">
                                <div class="col-md-12 col-xs-12 nopadding">
                                    <a href="javascript:void(0)" class="button button-3d notopmargin fright" onclick="gotocheckout()" id="btn-checkout">Proceed to Checkout</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    function gotocheckout(){

        var province    = $('[name=province]  option:selected').attr('province');
        var city        = $('[name=city]  option:selected').attr('city');
        var postalcode  = $('[name=city]  option:selected').attr('postalcode');
        var district    = $('[name=district]  option:selected').attr('district');
        var courier     = $('[name=courier]').val();
        var cost        = $('[name=cost]').val();
        var subtotal    = $('#cart-subtotal').text().replace(/[^a-z0-9\s]/gi, '');
        var total       = $('#cart-total').text().replace(/[^a-z0-9\s]/gi, '');
        var count       = '{{ Cart::count() }}';

        if (count == 0) {
            // alert('There`s no item in cart');
            swal("Warning !", "There`s no item in cart", "warning");
        } else {
            if (cost == "false" || cost == null || cost == "" || cost == 0) {
                // alert('Please select all shipping form');
                swal("Warning !", "Please select all shipping form", "warning");
            } else {

                var datapost = {
                    "_token"    : "{{ csrf_token() }}",
                    "province"  : province,
                    "city"      : city,
                    "postalcode": postalcode,
                    "district"  : district,
                    "courier"   : courier,
                    "cost"      : cost,
                    "subtotal"  : subtotal,
                    "total"     : total
                }

                $.ajax({
                    type    : "POST",
                    url     : "{{ url('shipping/gotocheckout') }}",
                    data    : datapost,
                    beforeSend: function(){
                        $('#btn-checkout').attr('onclick','false');
                    },
                    success: function(data){
                        if (data == 1) {
                            window.location.href = "{{ url('checkout') }}";
                        }else {
                            $('#btn-checkout').attr('onclick','gotocheckout()');
                        }
                    }
                })

            }
        }

    }
</script>
