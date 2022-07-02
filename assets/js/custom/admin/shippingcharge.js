$(document).ready(function() {
	$("#"+formid).validate({
	  rules: {
	    shipping: {
	      required: true,
	      digits:true,
	      min:0,
	    }
	  }
	});
});