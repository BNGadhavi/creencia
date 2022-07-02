$(document).ready(function() {
    $("#"+formid+'').validate({

        rules: {
            aadhaarNo: {
                required: true,
               /* digits:true,
                minlength:12,
                maxlength:12,*/
            },
            proof:{
              required: true,
              extension: "jpg|png|jpeg",  
            }

        }
    });
});






    



      