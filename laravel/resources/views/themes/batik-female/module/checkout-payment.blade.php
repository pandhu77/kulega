<script type="text/javascript" src="{{ asset('assets/web/js/jquery.js') }}"></script>
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<CLIENT-KEY>"></script>

<a id="pay-button" data-scrollto="#section-pricing" class="button button-3d button-red button-xlarge nobottommargin"><i class="icon-star3"></i> Pay Now</a>

<form id="payment-form" method="post" action="{{ url('snapfinish') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="result_type" id="result-type" value=""></div>
    <input type="hidden" name="result_data" id="result-data" value=""></div>
</form>

<script type="text/javascript">
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
</script>
