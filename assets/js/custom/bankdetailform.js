/*jQuery.validator.addMethod("alphanumeric", function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
}, "Letters, numbers, and underscores only please");*/

jQuery.validator.addMethod("alphanumeric", function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9_]+$/.test(value);
}, "Letters, numbers, and underscores only please");


jQuery.validator.addMethod("alphanumericwithspace", function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9_ ]+$/.test(value);
}, "Letters, numbers,space and underscores only please");

jQuery.validator.addMethod("alphanumericnounderscore", function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
}, "Letters And numbers only please");

$(document).ready(function() {

    $("#"+formid+'').validate({

        rules: {
            BankAccName: {
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
            },
            proof:{
              required: true,
              extension: "jpg|png|jpeg",  
            }
        }

    });

});




function otherbank()
{
    var bankname=$("#BankName").val();
    if(bankname=='Other')
    {
      $(".otherbankdiv").css("display","flex");
    }
    else
    {
      $(".otherbankdiv").css("display","none");
    }
}
