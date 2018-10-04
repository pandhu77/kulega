<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<CLIENT-KEY>"></script>

<div id="section-home" class="heading-block title-center nobottomborder page-section">
    <h1>CONGRATULATION !</h1>
    <span>Your order has <span class="color">Completed</span></span>
</div>

<?php $gettransopt = DB::table('t_module_options')->where('module','midtrans')->get(); ?>

<div class="center bottommargin">
    <a href="{{ url('products') }}" class="button button-3d button-teal button-xlarge nobottommargin"><i class="icon-line2-handbag"></i> Shop More</a>
    - OR -
    <a href="{{ url('confirm-payment/'.$orderid) }}" class="button button-3d button-red button-xlarge nobottommargin">Order Confirm</a>
</div>

<form id="payment-form" method="post" action="{{ url('snapfinish') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="result_type" id="result-type" value=""></div>
    <input type="hidden" name="result_data" id="result-data" value=""></div>
</form>

<div class="clear"></div>

<script type="text/javascript">
    $('#pay-button').click(function (event) {
        event.preventDefault();
        $(this).attr("disabled", "disabled");

        $.ajax({
            url: "{{ url('snaptoken') }}",
            cache: false,
            success: function(data) {
                //location = data;
                console.log('token = '+data);

                var resultType = document.getElementById('result-type');
                var resultData = document.getElementById('result-data');
                function changeResult(type,data){
                    $("#result-type").val(type);
                    $("#result-data").val(JSON.stringify(data));
                    //resultType.innerHTML = type;
                    //resultData.innerHTML = JSON.stringify(data);
                }
                snap.pay(data, {

                    onSuccess: function(result){
                        changeResult('success', result);
                        console.log(result.status_message);
                        console.log(result);
                        $("#payment-form").submit();
                    },
                    onPending: function(result){
                        changeResult('pending', result);
                        console.log(result.status_message);
                        $("#payment-form").submit();
                    },
                    onError: function(result){
                        changeResult('error', result);
                        console.log(result.status_message);
                        $("#payment-form").submit();
                    }
                });
            }
        });
    });
</script>
