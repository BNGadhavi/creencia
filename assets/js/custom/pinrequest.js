$(document).ready(function() {
    $("#PinRequestForm").validate({

        rules: {
            packageId: {
                required: true,
            },
             noOfPin:{
                digits:true,
                required: true,
                checkAmount:true,
                min:1,
            },
            paymentMode:{
                required: true,
            },
            transactionId:{
                required: true,
            },
            proof:{
              required: true,
               extension: "jpg|png|jpeg",  
            }

        }
    });

});




jQuery.validator.addMethod("checkAmount", function(value, element) {
    var LoadingClass=".card-body";
    var rtnstatus = true;

    var noofpin=$("#noOfPin").val();
    var mrp = $("#packageId option:selected").attr('packagemrp');

    if(parseInt(noofpin) > 0 && parseInt(mrp) > 0){
        var totalAmount=parseInt(noofpin)*parseInt(mrp);
        $("#totalAmount").val(totalAmount);
    }
   
    return rtnstatus;
}, "You Have Not Enough Pin");


var formbtnclick = false;
function saveData()
{
        formbtnclick = true;
        LoadingClass=".container-fluid";
        ShowLoading(LoadingClass);
        
        var fd = new FormData();
        var files = $('#proof')[0].files[0];
        fd.append('proof',files);

        var form_data = $('#PinRequestForm').serializeArray();
        for (var i=0; i<form_data.length; i++) {
          fd.append(form_data[i].name, form_data[i].value);
        }


        $.ajax({
            url: submiturl, 
            type: "POST", 
            data: fd, 
            contentType: false,       
            cache: false,            
            processData:false,
            success: function(msg)
            {
                formbtnclick = false;
                var response = $.parseJSON(msg);
                rtnstatus = response.status;
            if(response.status) {
                $("#"+formid+'')[0].reset();
                HideLoading(LoadingClass);
                swal({
                    title: submittitle,
                    text: submittxt,
                    type: 'success',
                    showCancelButton: submitcnshow,
                    showConfirmButton: submitokshow,
                    buttonsStyling: buttonsStyling,
                    confirmButtonClass: submitokclass,
                    confirmButtonText: submitoktxt,
                    cancelButtonClass: submitcnclass,
                    cancelButtonText: submitcntxt,
                    background: 'rgba(0, 0, 0, 0.96)'
                }).then(function(){
                    window.location.href = reporturl;
                });
            }
            else {
               HideLoading(LoadingClass);
               errorswal(response.msg, 'error', 'Error');


                }
            }
        });
}

$("#submit").click(function(e){
    e.preventDefault();
    if($("#PinRequestForm").valid()){
       if(!formbtnclick) {
            if(confirmbox) {
                swal({
                    title: confirmtitle,
                    text: confirmtxt,
                    type: 'warning',
                    showCancelButton: confirmcnshow,
                    showConfirmButton: confirmokshow,
                    buttonsStyling: buttonsStyling,
                    confirmButtonClass: confirmokclass,
                    confirmButtonText: confirmoktxt,
                    cancelButtonText: confirmcntxt,
                    cancelButtonClass: confirmcnclass,
                }).then(function(){
                    saveData();
                });
            }
            else {
                saveData();
            }
        }
    }
});
    



       /*$("#PinRequestForm").on('submit',(function(e) {
        formbtnclick = true;
        e.preventDefault();
        
        var fd = new FormData();
        var files = $('#proof')[0].files[0];
        fd.append('proof',files);

        var form_data = $('#PinRequestForm').serializeArray();
        for (var i=0; i<form_data.length; i++) {
          fd.append(form_data[i].name, form_data[i].value);
        }


        $.ajax({
            url: submiturl, // Url to which the request is send
            type: "POST",             // Type of request to be send, called as method
            data: fd, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,
            success: function(msg)
            {
                formbtnclick = false;
                var response = $.parseJSON(msg);
                rtnstatus = response.status;
            if(response.status) {
                $("#"+formid+'')[0].reset();
                HideLoading(LoadingClass);
                swal({
                    title: submittitle,
                    text: submittxt,
                    type: 'success',
                    showCancelButton: submitcnshow,
                    showConfirmButton: submitokshow,
                    buttonsStyling: buttonsStyling,
                    confirmButtonClass: submitokclass,
                    confirmButtonText: submitoktxt,
                    cancelButtonClass: submitcnclass,
                    cancelButtonText: submitcntxt,
                    background: 'rgba(0, 0, 0, 0.96)'
                }).then(function(){
                    window.location.href = reporturl;
                });
            }
            else {
               HideLoading(LoadingClass);
               errorswal(response.msg, 'error', 'Error');


                }
            }
        });
    }));
*/