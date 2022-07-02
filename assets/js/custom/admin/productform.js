$(document).ready(function() {
   $("select").on("select2:close", function (e) {  
        $(this).valid(); 
    });

  $("#"+formid).validate({
    rules: {
      category:{
        required: true,
      },
      productName:{
        required: true,
        alphanumericwithspace: true,
      },
      productCode:{
        required: true,
        alphanumeric: true,
        validateProductCode:true,
      },
      hsnCode:{
        required: true,
        calculateGST:true, 
      },
      mrp:{
        required: true,
        digits:true,
        min:0,
        calculateGST:true,
      },
      dp:{
        required: true,
        digits:true,
        min:0,
        calculateGST:true,
      },
      netMrp:{
        required: true,
        min:0,
        digits:true,
      },
      netdp:{
        required: true,
        min:0,
        digits:true,
      },
      oc:{
        required: true,
        min:0,
        number:true,
      },
      description:{
        required: true,
      },
     image: {
        extension: "jpg|jpeg|png",
        required: imageFlag,
        filesize: 2033414,
      },
      "mimage[]": {
        extension: "jpg|jpeg|png",
      },
      deliverycharge:{
        required: false,
        min:0,
        digits:true,
      }
  
    },
     errorPlacement: function(error, element) {
      if (element.attr("name") == "category" )
        error.insertBefore(".categoryerror"); 
      else if (element.attr("name") == "hsnCode" )
        error.insertBefore(".hsnerror");   
      else
        error.insertAfter(element);   
    }
  });
});

$.validator.addMethod('filesize', function (value, element, arg) {
    var minsize=1000; // min 1kb
    if(imageFlag) {
      if(typeof  element.files[0] === "undefined") {

      }
      else {
        var fsize = element.files[0].size;
        if((fsize>minsize) &&(fsize<=arg)){
            return true;
        }else{
            return false;
        }   
      }
      
    }
    return true;
},"Please Upload Max 2 MB Image");

jQuery.validator.addMethod("alphanumericwithspace", function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9_ ]+$/.test(value);
}, "Letters, numbers,space and underscores only please");


jQuery.validator.addMethod("validateProductCode", function(value, element) {
  var LoadingClass="#"+formid;
  var rtn =false;
  var editId=$("#editid").val();
  if(value!=''){
    ShowLoading(LoadingClass);
    $.ajax({
            url: AdminUrl+"/Productmaster/validateProductCode", 
            data:{'productcode':value,'editId':editId},
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
}, 'This Product Code Is Already Used');


jQuery.validator.addMethod("calculateGST", function(value, element) {
  var LoadingClass="#"+formid;
  var rtn =true;
  var mrp=$("#mrp").val();
  var hsnCode=$("#hsnCode").val();
  var dp=$("#dp").val();
  mrp=parseFloat(mrp);

  $("#cgst").val(0);
  $("#sgst").val(0);
  $("#igst").val(0);

  $("#cgsta").val(0);
  $("#sgsta").val(0);
  $("#igsta").val(0);
 
  if(hsnCode > 0 && gstFlag==true && dp > 0){
    ShowLoading(LoadingClass);
    var editId=$("#editid").val();
    var cgst = $("#hsnCode option:selected").attr('cgst');
    var sgst = $("#hsnCode option:selected").attr('sgst');
    var igst = $("#hsnCode option:selected").attr('igst');

    $("#cgst").val(cgst);
    $("#sgst").val(sgst);
    $("#igst").val(igst);

    var cgstTax=100+parseInt(cgst);
    /*var cgstA=(cgst*dp)/(100+parseFloat(cgst));

    var sgstA=sgst*dp/(100+parseFloat(sgst));*/
    var igstA=igst*dp/(100+parseFloat(igst));
    var cgstA=igstA/2;
    var sgstA=igstA/2;

    /*console.log("tax"+cgstTax);
    console.log("amt"+cgstA);*/
    //console.log(cgstA);
   /* cgstA=Math.round(cgstA,2);
    igstA=Math.round(igstA,2);
    sgstA=Math.round(sgstA,2);*/
    
    cgstA=cgstA.toFixed(2); 
    sgstA=sgstA.toFixed(2); 
    igstA=igstA.toFixed(2); 

    $("#cgsta").val(cgstA);
    $("#sgsta").val(sgstA);
    $("#igsta").val(igstA);

    var netMrp=parseFloat(mrp)-(parseFloat(cgstA)+parseFloat(sgstA));
    //netMrp=Math.round(netMrp,2);
    $("#netMrp").val(netMrp);

    var netdp=0;
    if(parseFloat(dp) > 0){
      netdp=parseFloat(dp)-(parseFloat(cgstA)+parseFloat(sgstA));
      //netdp=Math.round(netdp,2);
    }
    $("#netdp").val(netdp);
    
    HideLoading(LoadingClass);
     
  }
  return rtn;
}, '');