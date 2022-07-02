$(document).ready(function() {
  $("#"+formid+'').validate({
    rules: {
      pname:{
        required: true,
      },
      mrp: {
        required: true,
        number:true,
      },
      dis: {
        required: false,
      },
      proof:{
        required: false,
        extension: "jpg|png|jpeg",  
      }
    }
  });
});