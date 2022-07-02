$(document).ready(function() {
  $("#"+formid).validate({
    rules: {
      parentCategory:{
        required: true,
      },
      Category:{
        required: true,
      }
    }
    
  });
});


