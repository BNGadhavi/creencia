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

    $("#"+formid+'').validate({

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
            Address: {
                required: false,
            },
            country: {
                required: false,
            },
            State: {
                required: false,
            },
            City: {
                required: false,
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
            url:Franchisee_url+'Profile/GetCityStateWise',
            data:{'state':state},
            type:'POST',
            dataType:"json",
            success:function(result)
            {
                

                if(result.status)
                {
                   
                   
                    $.each(result.data, function(i) {
                        var selected='';
                        if(city !='' && parseInt(city) > 0)
                        {
                            if(city == result.data[i].id)
                                selected="selected";

                        }     
                        $("#City").append('<option '+selected+' value="' + result.data[i].id + '">' + result.data[i].name + '</option>') 

                    });

                    if(adminFlag == false){
                        $("#City [value!='"+city+"']").remove();  
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

