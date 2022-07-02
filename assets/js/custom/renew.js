$(document).ready(function() {
    $("#"+formid+'').validate({
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
            },
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
    $("#packagemrp").html("<i aria-hidden='true' class='fa fa-inr'></i>  "+packageMrp);
}

function getPin(){
    $("#pinno").val('');
    var packageId = $("#packageId").val();
    var activationMode=$("#activationMode").val();
    var LoadingClass="#"+formid+'';
    if(packageId!=''){
        if(activationMode == 0){
            $.ajax({
                    url:member_url+'Activation/GetPinNo',
                    data:{'packageId':packageId},
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
                         $("#pinno").val(result.pinno);
                        }
                        HideLoading(LoadingClass);
                       
                    }
                });  
        }

    }
}

var membermsg = function() {
   return membererror;
};

jQuery.validator.addMethod("checkMemberid", function(value, element) {
    var LoadingClass="#"+formid+'';
    var rtnstatus = false;
    $(".membername").css('display','none');
    if(value !=''){
        var packageId = $("#packageId").val();
        $.ajax({
                url:member_url+'Renew/MemberidValid',
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
    var LoadingClass="#"+formid+'';
    var rtnstatus = false;
    var packageId = $("#packageId").val();
    var memberid=$("#memberid").val();
    
    if(packageId !=''){
        $.ajax({
                url:member_url+'Activation/ValidateBalance',
                data:{'packageId':packageId},
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
    }
    else{
        rtnstatus = true;
    }    
    return rtnstatus;
    
}, "You Don't Have Enough Balance");