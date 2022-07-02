var formbtnclick = false;
$.validator.setDefaults({
    submitHandler: function() {
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
                    submitfun();
                });
            }
            else {
                submitfun();
            }
        } 
    }
});

function submitfun() {
    formbtnclick = true;

    var LoadingClass=".card-body";
    ShowLoading(LoadingClass);
    
    $.ajax({
        url: submiturl,
        async: false,
        type: "POST",
        data: $("#"+formid+'').serialize(),
        success: function(msg)
        {
            formbtnclick = false;
            var response = $.parseJSON(msg);
            rtnstatus = response.status;
            if(response.status) {
                $("#"+formid+'')[0].reset();
                HideLoading(LoadingClass);
                //window.location.href = "packagerpt.php";
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
                }).then(function(){
                    window.location.href = reporturl;
                });
            }
            else {
                HideLoading(LoadingClass);
                errorswal(response.msg, 'error', 'Error');

            }
        },
        error:function()
        {
            formbtnclick = false;
            HideLoading(LoadingClass);
            errorswal('Some Error Occur.','error', 'Error');    
        }
    });
}
