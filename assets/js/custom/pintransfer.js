$(document).ready(function() {

    $("#PinTrnasferForm").validate({

        rules: {
            packageId: {
                required: true,
            },
            memberId:{
                required: true,
                checkMemberid:true,
            },
            noOfPin:{
                digits:true,
                required: true,
                checkNoOfPin:true,
                min:1,
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "memberId" )
                 error.insertAfter(".membererror");
            else if (element.attr("name") == "noOfPin")
                 error.insertAfter(".pinerror");
            else
                 error.insertAfter(element);   
                
            }
    });

});

$("#packageId").change(function(){
    var pincount = $("#packageId option:selected").attr('pincount');
    $("#displayPin").html("<i aria-hidden='true' class='fa fa-key'></i> "+pincount);

})

jQuery.validator.addMethod("checkMemberid", function(value, element) {
    var LoadingClass="#PinTrnasferForm";
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
}, "Memberid Is Invalid");

jQuery.validator.addMethod("checkNoOfPin", function(value, element) {
    var LoadingClass=".card-body";
    var rtnstatus = false;
    var pincount = $("#packageId option:selected").attr('pincount');
   
    if(parseInt(value)<=parseInt(pincount))
    {
        rtnstatus = true;
     
    }      
    
    return rtnstatus;
}, "You Have Not Enough Pin");
