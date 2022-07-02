$(document).ready(function() {
  fetchfranchisee(0);
$("#"+formid).validate({
  rules: {
    type:{
      required: true,
    },
    franchisee: {
      required: true,
    },
    amount:{
      digits:true,
      required: true,
    },
  },
  errorPlacement: function(error, element) {
    if (element.attr("name") == "type" )
    error.insertAfter(".type-div");   
    else if (element.attr("name") == "franchisee" )
    error.insertAfter(".franchiseeerror");   
    else
    error.insertAfter(element);   
  }
});
});

function fetchfranchisee(value)
{
    $.ajax({
        url:AdminUrl+"/Franchiseestock/FranchiseeList",
        data:{'value':value},
        type:'POST',
        success:function(result)
        {
            var response = $.parseJSON(result);
            if(response.status) {
                $.each(response.data, function(i) {
                $('#franchisee').append('<option value="' + response.data[i].id + '">' + response.data[i].name + '</option>');
                });
            }
            
        }
    });
}
