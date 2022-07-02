$(document).ready(function() {
    $("#"+formid+'').validate({
        rules: {
            subject: {
                required: true,
            },
            mobile:{
                digits:true,
                required: true,
            },
            name:{
                required: true,
            },
            msg:{
                required: true,
            }
        }
    });
});