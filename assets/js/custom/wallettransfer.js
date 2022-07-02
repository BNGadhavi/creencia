$(document).ready(function() {
    $("#"+formid).validate({
        rules: {
            amount: {
                required: true,
                digits:true,
                min:1,
                checkamount:true,
            },
            memberId:{
                required: true,
                checkMemberid:true,
            },
            transactionPassword:{
                required: true,
                validatePassword:true,
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "memberId" )
                 error.insertAfter(".membererror");
            else
                 error.insertAfter(element);   
        }
    });
});

jQuery.validator.addMethod("checkMemberid", function(value, element) {
    var LoadingClass="#"+formid;
    var rtnstatus = false;
    var appendHtml="<i class='fa fa-user-o'></i> ";
    $("#memberName").html("<i class='fa fa-user-o'></i>  ");
    $.ajax({
            url:member_url+'CommonController/MemberidValid',
            data:{'memberId':value},
            type:'POST',
            dataType:"json",
            async: false,
            beforeSend: function() {
                ShowLoading(LoadingClass);
            },
            success:function(result)
            {
               rtnstatus = result.status;
               var activestatus = result.activestatus;
                if(rtnstatus)
                {
                    if(activestatus=='1')
                    {
                        $("#memberName").html(appendHtml+result.memberName);    
                    }
                    else
                    {
                        rtnstatus = false;
                    }
                }
                HideLoading(LoadingClass);
            }
        });  
    return rtnstatus;
}, "Memberid Is Invalid");

jQuery.validator.addMethod("checkamount", function(value, element) {
    var LoadingClass="#"+formid;
    var rtnstatus = false;

    if(parseFloat(Balance)>=parseFloat(value))
    {
        rtnstatus = true;
    }
    HideLoading(LoadingClass);
    return rtnstatus;
}, "Invalid Amount");

jQuery.validator.addMethod("validatePassword", function(value, element) {
    var LoadingClass="#"+formid;
    var rtnstatus=false;
    $.ajax({
            url:member_url+'ChangePassword/CheckTransactionPassword',
            data:{'password':value},
            type:'POST',
            dataType:"json",
            async: false,
            beforeSend: function() {
                ShowLoading(LoadingClass);
            },
            success:function(result){
               rtnstatus = result.status;
               HideLoading(LoadingClass);
            }
        });   
    return rtnstatus;
}, "Transaction Password Is Invalid");

