/*jQuery.validator.addMethod("alphanumeric", function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
}, "Letters, numbers, and underscores only please");*/

jQuery.validator.addMethod("alphanumeric", function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9_]+$/.test(value);
}, "Letters, numbers, and underscores only please");


jQuery.validator.addMethod("alphanumericwithspace", function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9_ ]+$/.test(value);
}, "Letters, numbers,space and underscores only please");

jQuery.validator.addMethod("alphanumericnounderscore", function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
}, "Letters And numbers only please");

jQuery.validator.addMethod("mobileno", function(value, element) {
    return this.optional(element) || /^[6-9]{1}[0-9]+$/.test(value);
}, "Enter Valid Mobile Number");


jQuery.validator.addMethod("pancard", function(value, element) {
    return this.optional(element) || /^[A-Za-z]{5}\d{4}[A-Za-z]{1}$/.test(value);
}, "Enter Pancard Format Please");



$(document).ready(function() {

    $("#EditProfileForm").validate({

        rules: {
            FullName: {
                required: true,
            },
            Email: {
                required: true,
                email: true,
            },
            Mobile: {
                    required: true,
                    mobileno:true,
                },
            Pancard: {
                required: true,
                pancard:true,
            },
            Address: {
                required: true,
            },
            country: {
                required: false,
            },
            State: {
                required: true,
            },
            City: {
                required: true,
            },
            pincode: {
                required: true,
                digits:true,
            },
            NomineeName: {
                required: false,
            },
            NomineeRel: {
                required: false,
            },
            BankAccName: {
                required: false,
                alphanumericwithspace: true,
            },
            BankName: {
                required: false,
            },
            BankBranch: {
                required: false,
            },
            bankifsc: {
                required: false,
                alphanumericnounderscore: true,
            },
            BankAccNo: {
                required: false,
                alphanumeric: true,
            }
        }

    });

});


$("#State").change(function(){
    var state=$("#State").val();
    if(state=='')
    {
    }  
    else
    {
        $("#City").html("");   
       var LoadingClass=".card-body";
       ShowLoading(LoadingClass);
     
        $.ajax({
            url:member_url+'MemberProfile/GetCityStateWise',
            data:{'state':state},
            type:'POST',
            dataType:"json",
            success:function(result)
            {
                

                if(result.status)
                {
                   
                   
                    $.each(result.result, function(i) {
                        var selected='';
                        if(city !='' && parseInt(city) > 0)
                        {
                            if(city == result.result[i].id)
                                selected="selected";

                        }     
                        $("#City").append('<option '+selected+' value="' + result.result[i].id + '">' + result.result[i].name + '</option>') 

                    });

                    if(adminFlag == false){
                        if(city!=0){
                            $("#City [value!='"+city+"']").remove();      
                        } 
                    }
                    HideLoading(LoadingClass);
                    
                }
                else
                {
                    HideLoading(LoadingClass);
                 
                }
            }
        });
    }
});

function otherbank()
{
    var bankname=$("#BankName").val();
    if(bankname=='Other')
    {
      $(".otherbankdiv").css("display","flex");
    }
    else
    {
      $(".otherbankdiv").css("display","none");
    }
}
