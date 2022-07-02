$(document).ready(function() {
  $("#"+formid).validate({
    rules: {
      ramraks:{
        required: true,
      },
      
    },
     /*errorPlacement: function(error, element) {
      if (element.attr("name") == "category" )
        error.insertBefore(".categoryerror"); 
      else if (element.attr("name") == "hsnCode" )
        error.insertBefore(".hsnerror");   
      else
        error.insertAfter(element);   
    }*/
  });
});




