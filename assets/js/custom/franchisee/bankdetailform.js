jQuery.validator.addMethod("alphanumeric", function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
}, "Letters, numbers, and underscores only please");

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
    $("#BankDetailForm").validate({
        rules: {
            BankAccName: {
                required: true,
                alphanumericwithspace: true,
            },
            BankName: {
                required: false,
            },
            BankBranch: {
                required: false,
            },
            bankifsc: {
                required: false,
            },
            BankAccNo: {
                required: false,
                alphanumeric: true,
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
