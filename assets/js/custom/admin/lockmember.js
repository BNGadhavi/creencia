$(document).ready(function() {

    $("#"+formid).validate({

        rules: {
            memberId: {
                required: true,
                checkMemberId:true,
            },
            
        },
    errorPlacement: function(error, element) {
        if (element.attr("name") == "memberId" )
            error.insertAfter(".membererror");
        else
            error.insertAfter(element);   
    }

    });

});

var membererror="MemberId Is Invalid";
var membermsg = function() {
   return membererror;
};



$.validator.addMethod("checkMemberId", function(value, element) {
    rtnstatus = false;
    var appendHtml="<i class='fa fa-user-o'></i> ";
    $.ajax({
        url: AdminUrl+"Utility/ValidateLockMemberId",
        async: false,
        type: "POST",
        data: "memberId="+value,
        success: function(msg)
        {
            var response = $.parseJSON(msg);
            if(response.status)
            {
                rtnstatus = true;
                $("#memberName").html(appendHtml+response.Name);
            }
            else{
                membererror=response.msg;
            }
        }
    });
    return rtnstatus;
}, membermsg);




