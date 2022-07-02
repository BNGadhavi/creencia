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

$(".memsub").click(function(){
    if( $("#"+formid).valid() ) {
        logintomember($(this).attr('data-rdrct'), 1, formid);
    }
})

function logintomember(redirectpage, mode, formid){
    if(mode == '1'){
        var frmaction = AdminUrl + "MemberDetail/MemberLogin/"+redirectpage;
        $("#"+formid+'').attr('action',frmaction);
        $("#submit").click();
    }
    else{
        url="memberlogin.php?pagename="+redirectpage+".php";
        window.open(url, '_blank');
    }
}