$(document).ready(function() {

    $("#"+formid).validate({

        rules: {
            payoutDate: {
                required: true,
                checkMemberId:true,
            },
            
        }

    });

});






