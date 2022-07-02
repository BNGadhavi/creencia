$(document).ready(function() {
  $("#"+formid).validate({
    rules: {
      hsnCode:{
        required: true,
       	alphanumericwithspace: true,
       	validateHsncode:true,
      },
      sgst:{
        required: true,
       	number: true,
       	calculateGst:true,
       	min:0,
      },
      cgst:{
        required: true,
       	number: true,
       	calculateGst:true,
       	min:0,
      },
      igst:{
        required: true,
       	number: true,
       	min:0,
      }
    }
    
  });
});

jQuery.validator.addMethod("alphanumericwithspace", function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9_ ]+$/.test(value);
}, "Letters, numbers,space and underscores only please");

jQuery.validator.addMethod("validateHsncode", function(value, element) {
  var LoadingClass="#"+formid;
  var rtn =true;
    if(value!=''){
    	rtn =false;
    	var editId=$("#editid").val();
      	ShowLoading(LoadingClass);
        $.ajax({
              url: AdminUrl+"/Gstmaster/validateHsncode", 
              data:{'hsncode':value,'editId':editId},
              type:"POST",
              async:false,
              success: function(result){
              var response = $.parseJSON(result);
                  if(response.status){
                    rtn=true;
                  }
              HideLoading(LoadingClass);
              }
            });
    }
  return rtn;
}, 'This Hsn Code Is Already Used');

jQuery.validator.addMethod("calculateGst", function(value, element) {
  var LoadingClass="#"+formid;
  var rtn =true;
  var sgst=$("#sgst").val();
  var cgst=$("#cgst").val();
  var igst=0;
  if(parseFloat(sgst) >= 0 && parseFloat(cgst) >= 0){
	ShowLoading(LoadingClass);
	igst=parseFloat(sgst)+parseFloat(cgst);
	$("#igst").val(igst);
	HideLoading(LoadingClass);
  }
   
  return rtn;
}, '');

