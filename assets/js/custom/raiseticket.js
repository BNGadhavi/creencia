$(document).ready(function() {
    $("#RaiseTicketForm").validate({
        rules: {
            ticketIssue: {
                required: true,
            },
            message: {
                required: true,
            },
           
        }

    });

});

