$(document).ready(function() {
	$("#"+formid).validate({
	  rules: {
	    achiver: {
	      required: true,
	    }
	  }
	});
});