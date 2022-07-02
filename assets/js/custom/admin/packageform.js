$(document).ready(function() {
  $("#"+formid).validate({
    rules: {
      packageName:{
        required: true,
      },
      amount: {
        number:true,
        required: true,
      },
      packagePV:{
        number:true,
        required: true,
      },
      tax:{
        number:true,
        required: true,
      },
      roiAmt:{
        number:true,
        required: true,
      },
      roiDays:{
        number:true,
        required: true,
      },
      capping:{
        number:true,
        required: true,
      },
      directPer:{
        number:true,
        required: true,
      },
    }
    
  });
});