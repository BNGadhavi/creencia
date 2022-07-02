$(document).ready(function() {
	$("#"+formid+"").validate({
		rules: {
			remarks: {
				//required: true,
			},
		}
	});
});


$(".btv").click(function(){
	var st = $(this).attr('st');
	if(st=='0'){
		
		//var status=$("#"+formid+"").valid();
		//if(status){
			confirmoktxt = 'Yes!';
    		confirmtxt = 'You Want To Accept Order!';
    		submittxt = 'Order Accepted Successfully.';
    		submiturl = Franchisee_url+"Stockrequest/AcceptOrder";
    		$("#submit").click();

		//}
		
    	
	}
	else if(st=='1'){
		confirmoktxt = 'Yes!';
		confirmtxt = 'You Want To Reject Order!';
		submittxt = 'Order Rejected Successfully.';	
		submiturl = Franchisee_url+"Stockrequest/RejectOrder";
		$("#submit").click();
		
		
	}
	else{
		alert();
	}
});



/*$(".btv").click(function(){
	var st = $(this).attr('st');
	if(st=='0'){
			confirmoktxt = 'Yes!';
    		confirmtxt = 'You Want To Accept Order!';
    		submittxt = 'Order Accepted Successfully.';
    		submiturl = Franchisee_url+"Stockrequest/AcceptOrder";
    		$("#submit").click();
	}
	else if(st=='1'){
			
		confirmoktxt = 'Yes!';
		confirmtxt = 'You Want To Reject Order!';
		submittxt = 'Order Rejected Successfully.';	
    	submiturl = Franchisee_url+"Stockrequest/RejectOrder";
		$("#submit").click();
	}
	
});*/