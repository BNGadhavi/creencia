$(document).ready(function() {
    $("#"+formid+'').validate({
        rules: {
            amount:{
                digits:true,
                required: true,
                min:50,
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
$( "#paymentMode" ).change(function() {
    var value=$( this ).val();
    $(".ass").css("display", "flex");
    if(value=='1')
    {
        $(".usdt").css("display", "none");
        $(".nfc").css("display", "flex");
    }
    else if(value=='0')
    {
        $(".usdt").css("display", "flex");
        $(".nfc").css("display", "none");
    }
    else
    {
        $(".usdt").css("display", "none");
        $(".nfc").css("display", "flex");
    }
});




       