$(document).ready(function() {
    $("#activationForm").validate({
        rules: {
            memberid: {
                required: true,
                checkMemberid:true,
            },
            /*pinno: {
                required: true,
                checkPinno: true,
            },*/
            packageId: {
                required: true,
                checkwalletbalance:true,
            },
            activationMode:{
                required: true,
            }
            /*product:{
                required: true,
            },*/
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "packageId" )
                 error.insertAfter(".packageerror");
             else
                 error.insertAfter(element);   
                
            }
    });
});
var membererror="Memberid Is Invalid";
function packageamt(){
    var packageId = $("#packageId").val();
    var packageMrp = $("#packageId option:selected").attr('mrp');
    $("#packagemrp").html("<i aria-hidden='true' class='fa fa-usd'></i>  "+packageMrp);
}

var membermsg = function() {
   return membererror;
};

jQuery.validator.addMethod("checkMemberid", function(value, element) {
    var LoadingClass="#activationForm";
    var rtnstatus = false;
    $(".membername").css('display','none');
    if(value !=''){
        var packageId = $("#packageId").val();
        $.ajax({
            url:member_url+'Activation/MemberidValid',
            data:{'memberId':value,'packageId':packageId},
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
                    $(".membername").css('display','block');
                    $("#memberName").html(result.memberName);
                }
                else{
                    membererror=result.msg;
                }
                HideLoading(LoadingClass);
            }
        });  
    }
    else{
        rtnstatus = true;
    }    
    return rtnstatus;
    
}, membermsg);

jQuery.validator.addMethod("checkwalletbalance", function(value, element) {
    var LoadingClass="#activationForm";
    var rtnstatus = false;
    var packageMrp = $("#packageId option:selected").attr('mrp');
    if(parseFloat(packageMrp)>parseFloat(balance))
    {
        rtnstatus = false;
    }
    else
    {
        rtnstatus = true;
    }
    return rtnstatus;
}, "You Don't Have Enough Capital Wallet Balance.");