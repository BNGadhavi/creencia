$("#profilepic").click(function(){
	$("#profile").click();
});
$("#profile").change(function(){
	//readURL(this,'profile');
	$("#profilesubmit").click();
});
function readURL(input,imageid) {
	if (input.files && input.files[0]) {
	    var reader = new FileReader();

	    reader.onload = function (e) {
	        $('#'+imageid).attr('src', e.target.result);
	    }
	    reader.readAsDataURL(input.files[0]);
	}
}

$('#termscond').change(function() {
if($(this).is(":checked")) {

	var rtnstatus=false;
    $.ajax({
        url: member_url+"dashboard/GenerateOTP",
        async: false,
        type: "POST",
        data: "",
        success: function(msg)
        {
            var response = $.parseJSON(msg);
            if(response.status)
            {
                rtnstatus = true;
            }
        }
    });

    if(rtnstatus){
    	$.confirm({
		    title: 'Enter OTP!',
		    content: '' +
		    '<form action="" class="formName">' +
		    '<div class="form-group">' +
		    '<label>OTP</label>' +
		    '<input type="text" placeholder="OTP" id="otp" class="name form-control" required />' +
		    '</div>' +
		    '</form>',
		    buttons: {
		        formSubmit: {
		            text: 'Submit',
		            btnClass: 'btn-blue',
		            action: function () {
		                var otp = this.$content.find('#otp').val();
		                if(!otp){
		                    $.alert('provide a OTP');
		                    return false;
		                }
		                else{
		                	 $.ajax({
						        url: member_url+"dashboard/SaveValidateOTP",
						        async: false,
						        type: "POST",
						        data: {"userotp":otp},
						        success: function(msg)
						        {
						            var response = $.parseJSON(msg);
						            if(response.status)
						            {
						                rtnstatus = true;
						                 $.confirm({
											    title: false,
											    content: 'Product Deliver Successfully',
											    buttons: {
											        OK: {
											            keys: ['o'],
											            action: function () {
											                window.location.reload();
											            }
											        },
											        
											    }
											});
						            }
						            else{
						            	 $.confirm({
											    title: false,
											    content: 'OTP Is Invalid',
											    buttons: {
											        OK: {
											            keys: ['o'],
											            action: function () {
											                window.location.reload();
											            }
											        },
											        
											    }
											});
						            }
						        }
						    });
		                }
		            }
		        },
		        cancel: function () {
		            //close
		        },
		    },
		    onContentReady: function () {
		        // bind to events
		        var jc = this;
		        this.$content.find('form').on('submit', function (e) {
		            // if the user submits the form by pressing enter in the field.
		            e.preventDefault();
		            jc.$$formSubmit.trigger('click'); // reference the button and click it
		        });
		    }
		});
    }
  	
}

});