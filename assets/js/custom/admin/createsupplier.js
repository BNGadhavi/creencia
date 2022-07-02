$(document).ready(function() {
  $("#"+formid+'').validate({
    rules: {
      fname:{
        required: true,
      },
      stateid: {
        required: true,
      },
      city: {
        required: true,
      },
      mobile:{
        required: true,
        digits:true,
        mobileno:true,
      }
    },
    errorPlacement: function(error, element) {
      if (element.attr("name") == "city" )
      error.insertAfter(".cityerror");
      else if (element.attr("name") == "stateid" )
      error.insertBefore(".staterror");   
      else
      error.insertAfter(element);   
    }
  });
});
jQuery.validator.addMethod("mobileno", function(value, element) {
  return this.optional(element) || /^[6-9]{1}[0-9]+$/.test(value);
}, "Enter Valid Mobile Number");

$("#stateid").change(function(){
  var state=$("#stateid").val();
  var LoadingClass="#"+formid+"";
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
                if(city!=''){
                   $("#city").val(city).trigger('change');
                }
                  
                HideLoading(LoadingClass);
            }
        });
    }
});

