function getPaymentMethodeSession() {
    var token = $('#token').val();
    var paymentMethode = document.querySelector('input[name="paymentMethode"]:checked').value;
    var dataString = '_token=' + token + '&paymentMethode=' + paymentMethode;

    //if (paymentMethode == 'transfer') {
    //    alert("transfer");
    //} else if(paymentMethode == 'creditcard'){ 
    //    alert("creditcard");
    //}

    $.ajax({
        type: "POST",
        url: "ajax/paymentMethode",
        data: dataString
        //success: function (data) {
        //    alert(data);
        //}
    });
}