$(document).ready(function() {
    $("#PinRequestForm").validate({
        rules: {
            amount:{
                digits: true,
                required: true,
                min:600,
                checkAmount:true,
            }
        }
    });
});

jQuery.validator.addMethod("checkAmount", function(value, element) {
    var LoadingClass=".card-body";
    var rtnstatus = true;

    var amount = $("#amount").val();
    if(parseInt(amount) > 0){
        var totalAmount = parseFloat(amount) + (parseFloat(amount) * parseFloat(extracharge) / 100);
        $("#totalAmount").val(totalAmount);
    }
    return rtnstatus;
}, "Some Error Occur");

var formbtnclick = false;

$("#submit").click(function(e){
    e.preventDefault();
    if($("#PinRequestForm").valid()){
       if(!formbtnclick) {
            if(confirmbox) {
                swal({
                    title: confirmtitle,
                    text: confirmtxt,
                    type: 'warning',
                    showCancelButton: confirmcnshow,
                    showConfirmButton: confirmokshow,
                    buttonsStyling: buttonsStyling,
                    confirmButtonClass: confirmokclass,
                    confirmButtonText: confirmoktxt,
                    cancelButtonText: confirmcntxt,
                    cancelButtonClass: confirmcnclass,
                }).then(function(){
                    submitfun();
                });
            }
            else {
                submitfun();
            }
        }
    }
});

function submitfun() {
    formbtnclick = true;
    var LoadingClass="#PinRequestForm";
    ShowLoading(LoadingClass);
    
    $.ajax({
        url: submiturl,
        async: false,
        type: "POST",
        data: $("#"+formid+'').serialize(),
        success: function(msg)
        {
            formbtnclick = false;
            var response = $.parseJSON(msg);
            rtnstatus = response.status;
            if(response.status) {
                $("#"+formid+'')[0].reset();
                HideLoading(LoadingClass);
                if(submitFlag==0){
                    $("#orderid").val(response.refid);
                    orderId = response.paymentOrderId;
                    var pay=Payment();
                }
                else{
                    swal({
                        title: submittitle,
                        text: submittxt,
                        type: 'success',
                        showCancelButton: submitcnshow,
                        showConfirmButton: submitokshow,
                        buttonsStyling: buttonsStyling,
                        confirmButtonClass: submitokclass,
                        confirmButtonText: submitoktxt,
                        cancelButtonClass: submitcnclass,
                        cancelButtonText: submitcntxt,
                    }).then(function(){
                        window.location.href = reporturl;
                    });
                }
            }
            else {
               HideLoading(LoadingClass);
               errorswal(response.msg, 'error', 'Error');
            }
        },
        error:function()
        {
            HideLoading(LoadingClass);
            errorswal('Some Error Occur.','error', 'Error');    
        }
    });
}

function Payment(event) {

    var paymentId='';
    console.log('Pay IN');
    var options = {
        "key": ApiKey, // Enter the Key ID generated from the Dashboard
        "amount": ActiveAmount, // Amount is in currency subunits. Default currency is INR. Hence, 29935 refers to 29935 paise or INR 299.35.
        "currency": "INR",
        "name": "MplWellness",
        "description": "MplWellness",
        "image": base_url+"assets/images/logo/logo.png",
        "order_id": orderId,//Order ID is generated as Orders API has been implemented. Refer the Checkout form table given below
        "handler": function (response) {
            //alert(response.razorpay_payment_id);
            paymentId=response.razorpay_payment_id;
            $("#paymentid").val(paymentId);
            submitFlag=1;
            submiturl = member_url+"FundRequest/WalletGeneratePaySubmit";
            submitfun();
        },
        "theme": {
            "color": "#F37254"
        }
    };
    var rzp1 = new Razorpay(options);
    rzp1.open();
}