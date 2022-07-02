$(document).ready(function() {
  $("#"+formid).validate({
    rules: {
      link:{
        required: true,
        url:true,
      },
    
    }
    
  });
});