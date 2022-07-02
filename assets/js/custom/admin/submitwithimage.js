var formbtnclick = false;
var checkEditor = checkEditor || false;
function saveData()
{
        formbtnclick = true;
        LoadingClass=".container-fluid";
      
        if(checkEditor){
            for (instance in CKEDITOR.instances){   
            CKEDITOR.instances[instance].updateElement();
            }    
            console.log("12");
        }
        
        ShowLoading(LoadingClass);
        
        var fd = new FormData();
        var files = $('#proof')[0].files[0];
        fd.append('proof',files);

        var form_data = $("#"+formid+'').serializeArray();
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
                }).then(function(){
                    window.location.href = reporturl;
                });
            }
            else {
                formbtnclick = false;
               HideLoading(LoadingClass);
               errorswal(response.msg, 'error', 'Error');


                }
            }
        });
}

$("#submit").click(function(e){
    e.preventDefault();
    if($("#"+formid+'').valid()){
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