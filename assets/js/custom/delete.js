$('body').on('click', '.deleteraw', function() {
	var deleteurl = $(this).attr('deleteurl');
	var deletetr = $(this);
	if(deleteconfirmbox) {
	    swal({
	        title: deleteconfirmtitle,
	        text: deleteconfirmtxt,
	        type: 'warning',
	        showCancelButton: true,
	        showConfirmButton: true,
	        buttonsStyling: deletebuttonsStyling,
	        confirmButtonClass: deleteconfirmokclass,
	        confirmButtonText: 'Delete',
	        cancelButtonText: 'Cancel',
	        cancelButtonClass: deleteconfirmcnclass
	    }).then(function(){
	        deleteReportRaw(deleteurl, deletetr);
	    });
	}
	else {
	    deleteReportRaw(deleteurl, deletetr);
	}
});

function deleteReportRaw(ajaxDeleteURL, deletetr) {
	var LoadingClass=".card-body";
    ShowLoading(LoadingClass);
    $.ajax({
        url: adminurl + ajaxDeleteURL,
        async: false,
        type: "POST",
        success: function(msg)
        {
            var response = $.parseJSON(msg);
            rtnstatus = response.actionstatus;
            if(response.actionstatus) {
               HideLoading(LoadingClass);
               deletetr.closest("tr").remove();
               console.log(deletetr.closest("tr"));
               cust_msg_show(cust_pop_delete_msg_show, 'success', 'top right', 'fa fa-check-circle', response.actionmsg);
            }
            else {
               HideLoading(LoadingClass);
               cust_msg_show(cust_pop_delete_msg_show, 'error', 'top right', 'fa fa-times-circle', response.actionmsg);
            }
        },
        error:function()
        {
            HideLoading(LoadingClass);
            cust_msg_show(cust_pop_delete_msg_show, 'error', 'top right', 'fa fa-times-circle', 'Some Error Occur.');
        }
    });
}
