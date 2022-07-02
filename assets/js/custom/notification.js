/*
Notetype : error, default, info, warning, success
Noteposition : top right, center top, top left, bottom left, bottom right
Noteicon : All Fa Icon Valid
*/
function cust_notification(notetype, noteposition, noteicon, notemsg) {
	Lobibox.notify(notetype, {
    pauseDelayOnHover: true,
    continueDelayOnInactiveTab: false,
    position: noteposition,
    icon: noteicon,
    showClass: 'fadeInDown',
    hideClass: 'fadeOutDown',
    msg: notemsg
    });
}

function cust_msg_show(cust_pop_msg_show, notetype, noteposition, noteicon, notemsg) {
	if(cust_pop_msg_show) {
		errorswal(notemsg, notetype, notetype);
	}
	else {
		cust_notification(notetype, noteposition, noteicon, notemsg);
       
	}
}