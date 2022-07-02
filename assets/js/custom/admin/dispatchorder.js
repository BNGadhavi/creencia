$(document).find(".submitonclick").click(function(){
	var autoid = $(this).attr('autoid');
	var kitcode=$("#kitcode"+autoid+"").val();
	var docateno=$("#docate"+autoid+"").val();
	var deletetr = $(this);
	if(parseInt(autoid)>0 && parseInt(kitcode)>0)
	{
		$("#kiterror"+autoid+"").text('');
		swal({
	        title: 'Are You Sure!!!',
	        text: 'You Want To Dispatch This Kit',
	        type: 'warning',
	        showCancelButton: true,
	        showConfirmButton: true,
	        buttonsStyling: buttonsStyling,
	        confirmButtonClass: confirmokclass,
	        confirmButtonText: confirmoktxt,
	        cancelButtonText: 'Cancel',
	        cancelButtonClass: confirmcnclass
	    }).then(function(){
		dispatchorder(docateno, kitcode,autoid,deletetr);
		});
	}
	else
	{
		$("#kiterror"+autoid+"").text('Please Select One Kit.');
	}
});

function dispatchorder(docateno, kitcode,autoid,deletetr) {
	var LoadingClass=".card-body";
    ShowLoading(LoadingClass);
    $.ajax({
        url: AdminUrl +"/PendingOrder/DispatchOrder",
        async: false,
        type: "POST",
        data:{'docateno':docateno,'kitcode':kitcode,'autoid':autoid},
        success: function(msg)
        {
            var response = $.parseJSON(msg);
            rtnstatus = response.actionstatus;
            if(response.actionstatus) {
               HideLoading(LoadingClass);
               deletetr.closest("tr").remove();
               console.log(deletetr.closest("tr"));
               cust_msg_show(0, 'success', 'top right','fa fa-check-circle', response.actionmsg);
            }
            else {
               HideLoading(LoadingClass);
               cust_msg_show(0, 'error', 'top right','fa fa-times-circle', response.actionmsg);
            }
        },
        error:function()
        {
            HideLoading(LoadingClass);
            cust_msg_show(0, 'error', 'top right','fa fa-times-circle', 'Some Error Occur.');
        }
    });
}