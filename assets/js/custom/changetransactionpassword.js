$(document).ready(function() {

    $("#changepassword").validate({

        rules: {
            oldpassword: {
                required: true,
                checkpass:true,
            },
            newpassword: {
                required: true,
            },
            reenetrpassword: {
                required: true,
                equalTo: "#newpass"
            }
        }

    });

});

$(document).ready(function() {
  $("#"+formid+'').validate({
    rules: {
      pmode:{
        required: true,
      }
    }
  });
});

$(".btv").click(function(){
	st = $(this).attr('st');
	if(st=='0')
	{
		
		var status=$("#changepassword").valid();
		if(status){
			confirmoktxt = 'Yes!';
    		confirmtxt = 'You Want To Update Password!';
    		submittxt = 'Password Updated Successfully.';
    		submiturl = member_url+"ChangePassword/UpdateTransactionPassword";
    		$("#submit").click();

		}
		
    	
	}
	else if(st=='1')
	{
		confirmoktxt = 'Yes!';
		confirmtxt = 'You Want To Send Password On Register Mobile Number!';
		submittxt = 'Password Send On Register Mobile Number Successfully.';	
		$("#changepassword").validate().resetForm();
    	$('#submit').attr('formnovalidate','');
    	submiturl = member_url+"ChangePassword/ForgetTransactionPassword";
		$("#submit").click();
		
		
	}
	else
	{
		alert();
	}
});

$.validator.addMethod("checkpass", function(value, element) {
    rtnstatus = false;

    $.ajax({
        url: member_url+"ChangePassword/CheckTransactionPassword",
        async: false,
        type: "POST",
        data: "password="+value,
        success: function(msg)
        {
            var response = $.parseJSON(msg);
            if(response.status)
            {
                rtnstatus = true;
            }
        }
    });
    return rtnstatus;
}, "Old Password Is Wrong");

