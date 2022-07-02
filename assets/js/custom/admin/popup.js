$(document).ready(function() {
    $("#"+formid+'').validate({

        rules: {
            type: {
                required: true,
            },
            priority:{
                required: true,
                number:true,
             },
            status:{
                required: true,
            },
            proof:{
                required: imageFlag,
                extension: "jpg|png|jpeg",  
            }

        }
    });

});
