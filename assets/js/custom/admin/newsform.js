$(document).ready(function() {
	$("#"+formid).validate({
	  rules: {
	    news: {
	      required: true,
	    }
	  }
	});
});