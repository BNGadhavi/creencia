$(document).ready(function() {

	  
	 /*jQuery.validator.addMethod("checkusername", function(value, element) {
        var rtn = false;
      $.ajax({

            url: baseurl+"superuser/login/checkusername", 
            data:{'username':value},
            type:"POST",
            async:false,
            success: function(result){
            	var response = $.parseJSON(result);
             	if(response.status){
             		rtn=true;
             	}
            }
      });

      return rtn;
    }, 'Wrong Username.');*/

	 $("#loginform").validate({
		rules: {
		    username: {
		        required: true,
                //checkusername: true,
            },
            password: {
                required: true,
            },
        }
    });

});