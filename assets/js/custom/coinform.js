$(document).ready(function() {
    $("#"+formid+'').validate({

        rules: {
            usdt: {
                required: false,
            }
        }
    });
});