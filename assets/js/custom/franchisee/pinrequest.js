$(document).ready(function() {
    $("#"+formid+'').validate({

        rules: {
            packageId: {
                required: true,
            },
             noOfPin:{
                digits:true,
                required: true,
                checkAmount:true,
                min:1,
            },
            paymentMode:{
                required: true,
            },
            transactionId:{
                required: true,
            },
            proof:{
              required: true,
               extension: "jpg|png|jpeg",  
            }

        }
    });

});




jQuery.validator.addMethod("checkAmount", function(value, element) {
    var LoadingClass=".card-body";
    var rtnstatus = true;

    var noofpin=$("#noOfPin").val();
    var mrp = $("#packageId option:selected").attr('packagemrp');
    
    if(parseInt(noofpin) > 0 && parseInt(mrp) > 0){
        var totalAmount=parseInt(noofpin)*parseInt(mrp);
        $("#totalAmount").val(totalAmount);
    }
   
    return rtnstatus;
}, "You Have Not Enough Pin");


