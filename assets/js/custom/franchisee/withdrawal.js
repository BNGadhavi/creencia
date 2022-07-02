$(document).ready(function() {
    $("#"+formid+'').validate({
        rules: {
            amount:{
                required: true,
                digits: true,
                calculateAmount:true,
                min:parseInt(MinAmount),
                max:parseInt(MaxAmount),
            },
            /*transactionPassword:{
                required: true,
                validatePassword:true,
            },*/
           /* BankAccName: {
                required: true,
                alphanumericwithspace: true,
            },
            BankName: {
                required: true,
            },
            BankBranch: {
                required: true,
            },
            bankifsc: {
                required: true,
                alphanumericnounderscore: true,
            },
            BankAccNo: {
                required: true,
                alphanumeric: true,
            }*/
        }
    });
});
jQuery.validator.addMethod("calculateAmount", function(value, element) {

    $("#tdsAmount").html("");
    $("#acAmount").html("");
    $("#netAmount").html(0);

    var amount=value;
    var TdsAmount=(amount*TDS)/100;
    var AdminChargeAmount=(amount*AdminCharge)/100;
    var netAmount=amount-(TdsAmount + AdminChargeAmount);
    TdsAmount=TdsAmount.toFixed(2);
    AdminChargeAmount=AdminChargeAmount.toFixed(2);
    netAmount=netAmount.toFixed(2);


    if(parseInt(value) > 0 && parseInt(value) >= parseInt(MinAmount) && parseInt(value) <= parseInt(MaxAmount)){
        $("#tdsAmount").html("( " +TdsAmount+ " <i aria-hidden='true' class='fa fa-inr'></i> ) || ");
        $("#acAmount").html("( " +AdminChargeAmount+ " <i aria-hidden='true' class='fa fa-inr'></i> ) || ");
        $("#netAmount").html(netAmount+" <i aria-hidden='true' class='fa fa-inr'></i>"); 
    }
   

   return true;
}, "Please Enter Valid Amount");

/*jQuery.validator.addMethod("validatePassword", function(value, element) {
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
   
}, "Transaction Password Is Invalid");*/

