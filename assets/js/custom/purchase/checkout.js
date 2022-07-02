$(document).ready(function() {
    $("#bill_state").change();
    $("#"+formid+'').validate({
        rules: {
            name:{
                required: true,
            },
            phone:{
                required: true,
                mobileno:true,
                minlength:10,
                maxlength:10,
            },
            address:{
                required: true,
            },
            state:{
                required: true,
            },
            city:{
                required: true,
            },
            pincode:{
                required: true,
                 digits: true,
            },
            repwallet:{
               required: true,
               validateAmount:true, 
            }   
        },
        errorPlacement: function(error, element) {
            if(element.attr("name") == "repwallet")
                error.insertAfter(".payment-options");
            else
                error.insertAfter(element);
        },
    });
});

$("#bill_state").change(function(){
    var state=$("#bill_state").val();
    var LoadingClass=".row clearfix";
    if(state=='')
    {
    }  
    else
    {
        //ShowLoading(LoadingClass);
        $("#bill_city").html("<option value='' selected disabled>Select City</option>");
        $.ajax({
            url:base_url+'register/GetCity',
            data:{'state':state},
            type:'POST',
            success:function(result)
            {
                var response = $.parseJSON(result);
                if(response.status) {
                    $.each(response.city, function(i) {
                        var selected='';
                        if(city !='' && parseInt(city) > 0)
                        {
                            if(city == response.city[i].id)
                                selected="selected";

                        }     
                        $('#bill_city').append('<option '+selected+' value="' + response.city[i].id + '">' + response.city[i].name + '</option>');
                        });
                }
                //HideLoading(LoadingClass);
            }
        });
    }
});

jQuery.validator.addMethod("mobileno", function(value, element) {
    return this.optional(element) || /^[6-9]{1}[0-9]+$/.test(value);
}, "Enter Valid Mobile Number");


jQuery.validator.addMethod("validateAmount", function(value, element) {
    var walletBalance='<?php echo $Balance; ?>';
    var totalDp='<?php echo $totalamount; ?>';
    if(parseFloat(walletBalance) >= parseFloat(totalDp)){
        return true;
    } 
    else{
      return false;  
    }  
}, "You Don't Have Sufficient Balance");


$("#state").change(function(){
    var state=$("#state").val();
    if(state=='')
    {
    }  
    else
    {
        //ShowLoading(LoadingClass);
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
                        var selected='';
                        if(bill_city !='' && parseInt(city) > 0)
                        {
                            if(bill_city == response.city[i].id)
                                selected="selected";

                        }     
                        $('#city').append('<option '+selected+' value="' + response.city[i].id + '">' + response.city[i].name + '</option>');
                    });
                }
            }
        });
    }
});

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
                    cancelButtonClass: confirmcnclass
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
    $.ajax({
        url: submiturl,
        async: false,
        type: "POST",
        data: $("#"+formid+'').serialize(),
        success: function(msg)
        {
            formbtnclick = false;
            var response = $.parseJSON(msg);
            rtnstatus = response.status;
            if(response.status) {
                errorswal('', 'success', 'Success');
                window.location.href = PurchaseUrl+"OrderPlaceConfirmation/"+response.invoiceno;
            }
            else {
               errorswal(response.msg, 'error', 'Error');
            }
        },
        error:function()
        {
            errorswal('Some Error Occur.','error', 'Error');    
        }
    });
}