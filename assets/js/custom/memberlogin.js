$(document).ready(function() {

     $("#loginform").validate({
        rules: {
            username: {
                required: true,
            },
            password: {
                required: true,
            },
        }
    });

});