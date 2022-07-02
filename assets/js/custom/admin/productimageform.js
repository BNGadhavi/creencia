$(document).ready(function() {
  $("#"+formid).validate({
    rules: {
      "mimage[]": {
          required : true,
          extension: "jpg|jpeg|png",
        }
    }
  });
});