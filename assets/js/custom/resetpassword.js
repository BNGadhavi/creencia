$(document).ready(function() {
    $("#"+formid+'').validate({
        rules: {
            userId: {
                required: true,
                checkUserId:true,
            },
           
        }

    });

$.validator.addMethod( "checkUserId", function(value, element) {
    rtnstatus = false;
   /* $("#sponsorName").text('');
    $("#sponsorDiv").css('display','none');
*/
    $.ajax({
        url: base_url+"register/ForgetPasswordValidateUserId",
        async: false,
        type: "POST",
        data: "memberid="+value,
        success: function(msg)
        {
            var response = $.parseJSON(msg);
            rtnstatus = response.status;
            
        }
    });
    return rtnstatus;
}, "Wrong Userid.");

});

