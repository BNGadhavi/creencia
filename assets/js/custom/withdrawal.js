jQuery.validator.addMethod("calculateAmount", function(value, element) {
    $("#ac").val(0);
    $("#netamount").val(0);

    var adminc=parseFloat(value) * 5 /100;
    var netamt=parseFloat(value) - parseFloat(adminc);
    if(parseFloat(value)>parseFloat(Balance))
    {
        return false;
    }
    else
    {
        adminc=adminc.toFixed(2);
        netamt=netamt.toFixed(2);
        $("#ac").val(adminc);
        $("#netamount").val(netamt); 
        return true; 
    }
}, "Please Enter Valid Amount");

jQuery.validator.addMethod("validatePassword", function(value, element) {
    var LoadingClass="#"+formid;
    var rtnstatus=false;
    $.ajax({
            url:member_url+'ChangePassword/CheckTransactionPassword',
            data:{'password':value},
            type:'POST',
            dataType:"json",
            async: false,
            beforeSend: function() {
                ShowLoading(LoadingClass);
            },
            success:function(result){
               rtnstatus = result.status;
               HideLoading(LoadingClass);
            }
        });   
    return rtnstatus;
}, "Transaction Password Is Invalid");
$(document).ready(function() {
    $("#"+formid+'').validate({
        rules: {
            amount:{
                required: true,
                digits: true,
                calculateAmount:true,
                min:parseFloat(MinAmount),
                max:parseFloat(MaxAmount),
            },
            paymentMode:{
                required: true,
            },
            transactionPassword:{
                required: true,
                validatePassword:true,
            }
        }
    });
});