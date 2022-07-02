$("#addopt").click(function() {
	var optlen = $(document).find('.optiondiv').length;
	if(parseInt(optlen) >= parseInt(maxoptionindex)) {
		var error_msg_max = "You Can't Add More than " + maxoptionindex + "  Option.";
		cust_msg_show(cust_pop_msg_show, 'error', 'top right', 'fa fa-times-circle', error_msg_max);
	}
	else {
		var datahtml = dataclon.replace(/indexvalue/gi, optionindex);
		$(".addotpdiv").before(datahtml);
		optionindex++;
	}
});

$('body').on('click', '.otpdelete', function() {
	var optlen = $(document).find('.optiondiv').length;
	if(parseInt(optlen) <= 1) {
		cust_msg_show(cust_pop_msg_show, 'error', 'top right', 'fa fa-times-circle', "Atlease one Option is Required.");
	}
	else {
		var deleteid = $(this).attr('optindex');
		$(document).find('#optindex'+deleteid+'').remove();
	}
});

$(document).ready(function() {
	$("#"+formid).validate({
		rules: {
			packagename : {
				required: true,
			},
			que : {
				required: true,
			},
			answer : {
				required : true,
			},
			'option[]' : { required : true, },
		},
		errorPlacement: function(error, element) {
			/*cust_msg_show(cust_pop_msg_show, 'error', 'top right', 'fa fa-times-circle', error.text());*/
            if (element.attr("errplace") == "optiontext" ){
            	var elemid = element.attr("id");
            	var errafter = $("#"+elemid).parent();
                error.insertAfter(errafter);
            }
            else
                error.insertAfter(element);
        }
	});
});