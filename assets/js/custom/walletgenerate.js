$(document).ready(function() {

    $("#"+formid+'').validate({

        rules: {

            amount:{

                digits:true,

                required: true,

                min:600,

            },

        }

    });

});











       