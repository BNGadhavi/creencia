$.validator.addMethod( "checkmemberid", function(value, element) {
    rtnstatus = false;
    $("#sponsorName").text('');
    $("#sponsorDiv").css('display','none');

    $.ajax({
        url: base_url+"register/checkMemberid",
        async: false,
        type: "POST",
        data: "memberid="+value,
        success: function(msg)
        {
            var response = $.parseJSON(msg);
            rtnstatus = response.status;
            if(response.status){
                $("#sponsorName").html("Member Name : <span>"+response.membername+"</span>");
                $("#sponsorDiv").css('display','block');
            }
        }
    });
    return rtnstatus;
}, "Wrong Sponsorid.");

$.validator.addMethod( "checkusername", function(value, element) {
    rtnstatus = false;
    $.ajax({
        url: base_url+"register/checkUsername",
        async: false,
        type: "POST",
        data: "username="+value,
        success: function(msg)
        {
            var response = $.parseJSON(msg);
            if(!response.status) {
                rtnstatus = true;
            }
        }
    });
    return rtnstatus;
}, "Userid Already Taken.");

$.validator.addMethod( "validatePanCard", function(value, element) {
   rtnstatus=true;
    if(value !=''){
         $.ajax({
            url: base_url+"register/validatePanCard",
            async: false,
            type: "POST",
            data: "pancard="+value,
            success: function(msg)
            {
                var response = $.parseJSON(msg);
                if(response.status) {
                    rtnstatus = true;
                }
                else{
                    rtnstatus = false;
                }
            }
        });
    }
    return rtnstatus;
}, "Pan Number Already Used.");

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
$("#state").change(function(){
    var state=$("#state").val();
    var LoadingClass=".card-authentication2";
    if(state=='')
    {
    }  
    else
    {
        ShowLoading(LoadingClass);
        $("#city").html("<option value='' selected disabled>Select City</option>");
        $.ajax({
            url:base_url+'register/GetCity',
            data:{'state':state},
            type:'POST',
            success:function(result)
            {
                var response = $.parseJSON(result);
                if(response.status) {
                    $.each(response.city, function(i) {
                    $('#city').append('<option value="' + response.city[i].id + '">' + response.city[i].name + '</option>');
                    });
                }
                HideLoading(LoadingClass);
            }
        });
    }
});
function otherbank()
{
    var bankname=$("#bankName").val()
    if(bankname=='Other')
    {
      $(".otherbankdiv").css("display","block");
    }
    else
    {
      $(".otherbankdiv").css("display","none");
    }
}
$(document).ready(function() {

    $("#registerForm").validate({
        rules: {
            pinno: {
                required: true,
                checkpinno: true,
            },
            sponsorId: {
                required: true,
                checkmemberid: true,
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
            transactionPassword: {
                required: true,
            },
            transactionPassword2: {
                required: true,
                equalTo: "#transactionPassword"
            },
            mobile: {
                required: true,
                mobileno:true,
                minlength:10,
                maxlength:10,
            },
            email: {
                required: false,
                email: true,
            },
            pannumber: {
                required: false,
                pancard:true,
                validatePanCard:true,
            },
            address: {
                required: false,
            },
            state: {
                required: false,
            },
            city: {
                required: false,
            },
            country: {
                required: false,
            },
            pincode: {
                required: false,
                digits: true,
            },
            nomineeName: {
                required: false,
            },
            relNominee: {
                required: false,
            },
            accHolderName: {
                required: false,
                alphanumericwithspace: true,
            },
            bankName: {
                required: false,
            },
            bankBranchName: {
                required: false,
                alphanumericwithspace: true,
            },
            accNo: {
                required: false,
                alphanumeric: true,
            },
            accType: {
                required: false,
            },
            ifsccode: {
                required: false,
                alphanumericnounderscore: true,
            },
            termscond: {
                required: true,
            },
            userName: {
                required: true,
                alphanumeric: true,
                maxlength: 15,
                checkusername: true,
            }
        },
        messages: {
            password2: {
            equalTo: "Password Not Match."
            },
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "termscond" )
                error.insertAfter(".termscond-div");
            else if(element.attr("name") == "side")
                error.insertAfter(".side-div");
            else if(element.attr("name") == "accType")
                error.insertAfter(".accType-div");
            else
                error.insertAfter(element);
        }
    });

    if($("#sponsorId").val() != '') {
        $('#sponsorId').valid();
    }
});
var submiturl =base_url+"register/registerSubmit";
var confirmbox = true;
var reporturl = 'index.php';
var buttonsStyling = false;

var welcomeletter = true;

var confirmoktxt = 'YES';
var confirmtxt = 'You Want to Submit....!';

//var submittxt = 'Your User Id Is : '+response.userid+', Password Is : '+response.password;
var submitcntxt = 'New Registration';

var confirmokclass = 'btn btn-danger';
var confirmcnclass = 'btn btn-light';

var confirmcntxt = 'Cancel';
var confirmokshow = true;
var confirmcnshow = true;
var confirmtitle = 'Are You Sure?';


var submitokclass = 'btn btn-light';
var submitcnclass = 'btn btn-light';
var submitoktxt = 'Login';

var submitokshow = true;
var submitcnshow = true;
var submittitle = 'Registration is Successfully Done.';

var formbtnclick = false;
$.validator.setDefaults({
    submitHandler: function() {
        if(!formbtnclick) {
            
            if(confirmbox) {
                swal({
                    title: confirmtitle,
                    text: confirmtxt,
                    type: 'warning',
                    showCancelButton: confirmcnshow,
                    showConfirmButton: confirmokshow,
                    buttonsStyling: buttonsStyling,
                    confirmButtonClass: confirmokclass,
                    confirmButtonText: confirmoktxt,
                    cancelButtonText: confirmcntxt,
                    cancelButtonClass: confirmcnclass,
                }).then(function(){
                    submitfun();
                });
            }
            else {
                submitfun();
            }
        } 
    }
});

function submitfun() {
    formbtnclick = true;
   /* var LoadingClass="#registerForm";
    ShowLoading(LoadingClass);*/
    $.ajax({
        url: submiturl,
        async: false,
        type: "POST",
        data: $("#registerForm").serialize(),
        success: function(msg)
        {
            formbtnclick = false;
            var response = $.parseJSON(msg);
            rtnstatus = response.status;
            if(response.status)
            {
                //HideLoading(LoadingClass);
                errorswal(response.msg, 'success', 'Success');
                location.reload(true);
            }
            else
            {
                //HideLoading(LoadingClass);
                errorswal(response.msg, 'error', 'Error');
            }
        }
    });
}