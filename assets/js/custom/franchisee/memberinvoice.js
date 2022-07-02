$(document).ready(function() {
    $(document).find("#adds").click();
      $("#"+formid+"").validate({
        ignore: [],
        rules: {
            productcount: {
                checkaddproduct: true,
            },
            memberid:{
                required: true,
                checkmemberid:true,
            },
            /*walletuse:{
                 required: false,
            },*/
            /*otp:{
                 required: true,
                 validateOtp:true,
            }*/
        },
        errorPlacement: function(error, element) {
            if(element.attr("name") == "productcount")
                error.insertAfter(".producterrormsg"); 
            else if (element.attr("name") == "memberid" )
                     error.insertAfter(".membererror");     
            /*else if (element.attr("name") == "walletuse" )
                     error.insertAfter(".walletuse-div"); */    
            else
                error.insertAfter(element);   
        },
        invalidHandler: function(form, validator) {
            if($(validator.errorList[0].element).attr("id") == 'productcount')
            {
                $(document).find("#adds").click();
            }
        }
      });

      $("#registerForm").validate({
        rules: {
            sponsorId: {
                required: true,
            },
            side: {
                required: true,
            },
            fullName: {
                required: true,
            },
            password: {
                required: true,
            },
            password2: {
                required: true,
                equalTo: "#password"
            },
            mobile: {
                required: true,
                minlength:10,
                maxlength:10,
            },
        },
        errorPlacement: function(error, element) {

            if(element.attr("name") == "side")
                error.insertAfter(".side-div");
            else
                error.insertAfter(element);
        },
        submitHandler: function (form) {
            submitfun();
        }
      });
});
$.validator.addMethod("checkaddproduct", function(value, element) {
    var rtnstatus = false;
    var productid=$("#productid").val();
    if($("#ajaxresult table tbody tr").length > 0) {
        if(productid!=''){
            rtnstatus = true;    
        }
    }
    return rtnstatus;
}, "Please Add Atleast one product");
var membermsg = function() {
   return membererror;
};

$.validator.addMethod("checkmemberid", function(value, element) {
    value=$("#memberid").val();
    var LoadingClass="#"+formid;
    var rtnstatus = false;
    var appendHtml="<i class='fa fa-user-o'></i> ";
    $("#memberName").html("<i class='fa fa-user-o'></i>  ");
   
    if(value!=''){
        $("#walletbalance").html(0);
        $("#cashamt").html(0);
        $("#paymentwallet").html(0);
        /*$("#walletuse").prop("checked", false);
        $("#walletuse").prop("disabled", true);*/
    }
    $.ajax({
            url:Franchisee_url+'CommonController/MemberidValid',
            data:{'memberId':value,'type':0},
            type:'POST',
            dataType:"json",
            async: false,
            beforeSend: function() {
                ShowLoading(LoadingClass);
            },
            success:function(result)
            {
               rtnstatus = result.status;
               var actstatus=result.activestatus;
               $("#memberstatus").val(actstatus);

                if(rtnstatus)
                {
                    if(result.activestatus=='1'){
                        $("#memberName").html(appendHtml+result.memberName);
                        $("#walletbalance").html(result.balance);
                        var memberwallet=result.balance;
                        if(parseInt(result.balance)<=0){
                            $("#walletuse").prop("disabled", true);
                        }
                        else{
                            $("#walletuse").prop("disabled", false);
                        }
                        var TotalPaidAmt=$("#finaldp").val();
                        var cashamt=TotalPaidAmt;
                        $('#cashamt').html(cashamt);
                    }
                    else{
                        $("#walletuse").prop("checked", false);
                        $("#walletuse").prop("disabled", true);
                        $('#cashamt').html(0);

                        $("#otpdiv").css('display','none');    
                        membererror="Member ID Is Inactive";
                        rtnstatus = false;
                    }
                }
                else{
                     $("#walletuse").prop("checked", false);
                     $("#walletuse").prop("disabled", true);
                     $('#cashamt').html(0);

                     $("#otpdiv").css('display','none');    
                     membererror=result.msg;
                }
                HideLoading(LoadingClass);
               
            }
        }); 
    return rtnstatus;
}, membermsg);


$.validator.addMethod("validateOtp", function(value, element) {
    var LoadingClass="#"+formid;
    var rtnstatus = false;

    var memberid=$("#memberid").val();
    var otp=$("#otp").val();
    
    $.ajax({
            url:Franchisee_url+'CommonController/ValidateOTP',
            data:{'memberid':memberid,'otp':otp},
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
},'Invalid OTP');

$('#walletuse').on('change', function() { 
    var LoadingClass="#"+formid;
    var rtnstatus = false;
    var memberid=$("#memberid").val();
    
    var TotalPaidAmtdp=$("#finaldp").val();
    var cashamt=TotalPaidAmt;
    var WalletAmt=$("#walletbalance").html();   
    var paymentwallet=0;
    var TotalPaidAmt=TotalPaidAmtdp;

    $("#cashamt").html(cashamt);
    $("#paymentwallet").html(0); 

    if(document.getElementById('walletuse').checked && memberid!='') { 
        $("#otpdiv").css('display','flex');
        
        if(parseInt(WalletAmt) >= parseInt(TotalPaidAmt)){
            paymentwallet=TotalPaidAmt;
            cashamt=0;
        }
        else{
            cashamt=TotalPaidAmt-WalletAmt;   
            paymentwallet=TotalPaidAmt-cashamt;
        }    
        
        $("#cashamt").html(cashamt);
        $("#paymentwallet").html(paymentwallet);

        $.ajax({
                url:Franchisee_url+'CommonController/Sendotp',
                data:{'memberId':memberid,type:1},
                type:'POST',
                dataType:"json",
                async: false,
                beforeSend: function() {
                    ShowLoading(LoadingClass);
                },
                success:function(result)
                {
                    HideLoading(LoadingClass);
                }
            }); 
    }
    else{
        $("#otpdiv").css('display','none');
        cashamt=TotalPaidAmt;
        $("#cashamt").html(cashamt);
        $("#paymentwallet").html(0);    
    }
});

$(document).find("#stockadd").click(function(){
   if($("#productid").val()!='') 
    {
         $("#pmode").css("display","block");
    }
    else
    {
         $("#pmode").css("display","none");
    }
});

$(document).find("#newmember").click(function(){
  $('#registarion').modal('toggle');
  $(".memberfield").css("display","none");
});

$(document).find("#existmember").click(function(){
  $(".memberfield").css("display","block");
});
