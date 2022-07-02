$(document).ready(function() {
    $("#"+formid+'').validate({

        rules: {
            panNo: {
                required: true,
                pancard:true,
                validatePanCard:true,
            },
            proof:{
              required: true,
              extension: "jpg|png|jpeg",  
            }

        }
    });

jQuery.validator.addMethod("pancard", function(value, element) {
    return this.optional(element) || /^[A-Za-z]{5}\d{4}[A-Za-z]{1}$/.test(value);
}, "Enter Pancard Format Please");

});

$.validator.addMethod( "validatePanCard", function(value, element) {
   rtnstatus=true;
    if(value !=''){
         $.ajax({
            url:  member_url+"KYCUpload/validatePanCard",
            async: false,
            type: "POST",
            data: "pancard="+value,
            success: function(msg)
            {
                var response = $.parseJSON(msg);
                if(response.status) {
                    rtnstatus = true;
                }
                else{
                    rtnstatus = false;
                }
            }
        });

    }
       
    return rtnstatus;

}, "Pan Number Already Used.");




    



      