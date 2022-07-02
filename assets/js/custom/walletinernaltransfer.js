$(document).ready(function() {
    $("#"+formid).validate({
        rules: {
            amount: {
                required: true,
                digits:true,
                min:1,
                checkamount:true,
            }/*,
            otp:{
                digits:true,
                required: true,
                min:1,
                checkotp:true,
            }*/
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "amount" )
                error.insertAfter(element);
            else
                error.insertAfter(element);   
        }
    });
    /*$("#ResendOTP").validate({
        submitHandler: function (form) {
            ResendOTP();
        }
    });*/
});

/*jQuery.validator.addMethod("checkMemberid", function(value, element) {
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
                if(rtnstatus)
                {
                 $("#memberName").html(appendHtml+result.memberName);
                }
                HideLoading(LoadingClass);
            }
        });  
    return rtnstatus;
}, "Memberid Is Invalid");*/

/*function ResendOTP()
{
    swal({
        title: 'Processing!',
        text: "Please Wait...",
        type: 'warning',
        buttonsStyling: false,
        confirmButtonClass: 'btn btn-light',
        confirmButtonText: 'Close!',
    });
    $.ajax({
        url:member_url+'Wallet/Sendotp',
        async: false,
        type: "POST",
        data:{},
        success: function(msg)
        {
            var response = $.parseJSON(msg);
            rtnstatus = response.status;
            if(response.status)
            {
                var text = $("#resendotp").text();
                if(text=='Resend OTP')
                {
                    $("#resendotp").hide();  
                }
                else
                {
                    $("#resendotp").text("Resend OTP");    
                }
                errorswal('OTP Sent Successfully', 'success', 'Success');
            }
            else
            {
                errorswal(response.msg, 'error', 'Error');
            }
        }
    });
}*/

/*jQuery.validator.addMethod("checkotp", function(value, element) {
    var LoadingClass="#"+formid;
    var rtnstatus = false;
    $.ajax({
            url:member_url+'Wallet/Checkotp',
            data:{'otp':value},
            type:'POST',
            dataType:"json",
            async: false,
            beforeSend: function() {
                ShowLoading(LoadingClass);
            },
            success:function(result)
            {
                rtnstatus = result.status;
                HideLoading(LoadingClass);
            }
        });  
    return rtnstatus;
}, "Invalid OTP");*/

jQuery.validator.addMethod("checkamount", function(value, element) {
    var rtnstatus = false;

    var coins=parseFloat(value) / parseFloat(buyprice);
    $("#coins").val(coins);
    
    if(parseFloat(balance)>=parseFloat(value))
    {
        rtnstatus = true;
    }
    return rtnstatus;
}, "Invalid Amount");