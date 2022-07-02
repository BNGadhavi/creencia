$(document).ready(function() {

    $("#changepassword").validate({

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
        url: baseurl+"member/ChangePassword/CheckPassword",
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

/*var formbtnclick = false;
$.validator.setDefaults({
    submitHandler: function() {
        if(!formbtnclick){
            formbtnclick = true;    
            $.ajax({
                url:baseurl+"member/ChangePassword/UpdateChangePassword",
                async: false,
                type: "POST",
                data: $("#changepassword").serialize(),
                success: function(msg)
                {
                    formbtnclick = false;
                    var response = $.parseJSON(msg);
                    rtnstatus = response.status;
                    if(response.status)
                    {
                        window.location.href = "changepassword.php?change=" + 1 + "&msg=Password Change Successfully";
                    }
                    else
                    {
                        window.location.href = "changepassword.php?change=" + 2 + "&msg=" + rtnstatus;
                    }
                    
                }
            });
        }
    }
});*/


