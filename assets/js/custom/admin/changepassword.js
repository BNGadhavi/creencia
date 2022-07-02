$(document).ready(function() {

    $("#"+formid).validate({

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
        },
        /*invalidHandler: function(form, validator) {
        var errors = validator.numberOfInvalids();
            if (errors) {
               // alert(validator.errorList[0].message);  //Only show first invalid rule message!!!
                cust_notification('error', 'top right', 'fa fa-times', validator.errorList[0].message);
                validator.errorList[0].element.focus(); //Set Focus
            }
        }*/

    });

});

$.validator.addMethod("checkpass", function(value, element) {
    rtnstatus = false;
    $.ajax({
        url: AdminUrl+"Utility/CheckPassword",
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




