$(document).ready(function() {
    $("#"+formid+'').validate({

        rules: {
            oldpassword: {
                required: true,
                checkpass:true,
            },
            newpassword: {
                required: true,
            },
            reenetrpassword: {
                required: true,
                equalTo: "#newpass"
            }
        }

    });

});

$.validator.addMethod("checkpass", function(value, element) {
    rtnstatus = false;

    $.ajax({
        url: Franchisee_url+"ChangePassword/CheckPassword",
        async: false,
        type: "POST",
        data: "oldpass="+value,
        success: function(msg)
        {
            var response = $.parseJSON(msg);
            if(response.status)
            {
                rtnstatus = true;
            }
        }
    });
    return rtnstatus;
}, "Old Password Is Wrong");

