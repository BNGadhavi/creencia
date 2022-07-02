$(document).ready(function() {
  $("#"+formid+"").validate({
    rules: {
      productid:{
        required: true,
      },
      memberId: {
        required: true,
        checkUserId:true,
      },
      fid: {
        required: true,
        checkfidUserId:true,
      },
      qty:{
        digits:true,
        required: true,
        min:1,
        checkamount:true,
      },
      amount:{
        required: true,
      }
    },
    errorPlacement: function(error, element) {
      if (element.attr("name") == "memberId" )
      error.insertAfter(".membererror");
      else if (element.attr("name") == "fid" )
      error.insertAfter(".fiderror");
      else if (element.attr("name") == "productid" )
      error.insertBefore(".packageerror");   
      else
      error.insertAfter(element);   
    }
  });
});

jQuery.validator.addMethod("checkUserId", function(value, element) {
  var rtn = false;
  var appendHtml="<i class='fa fa-user-o'></i> ";
  var LoadingClass="#"+formid+"";
  $("#memberName").html("<i class='fa fa-user-o'></i>  ");
    if(value!=''){
      ShowLoading(LoadingClass);
        $.ajax({
              url: AdminUrl+"/Common/CheckMemberId", 
              data:{'username':value,'type':1},
              type:"POST",
              async:false,
              success: function(result){
              var response = $.parseJSON(result);
                  if(response.status){
                    rtn=true;
                    $("#memberName").html(appendHtml+response.data[0]['Name']);
                  }
              HideLoading(LoadingClass);
              }
            });
    }
    else{
        rtn=true;
    } 
  return rtn;
}, 'Wrong Member ID');

jQuery.validator.addMethod("checkfidUserId", function(value, element) {
  var rtn = false;
  var appendHtml="<i class='fa fa-user-o'></i> ";
  var LoadingClass="#"+formid+"";
  $("#fidName").html("<i class='fa fa-user-o'></i>  ");
  var type="Franchisee";
    if(value!=''){
      ShowLoading(LoadingClass);
        $.ajax({
              url: AdminUrl+"/Common/CheckMemberId", 
              data:{'username':value,'type':type},
              type:"POST",
              async:false,
              success: function(result){
              var response = $.parseJSON(result);
                  if(response.status){
                    rtn=true;
                    $("#fidName").html(appendHtml+response.data[0]['Name']);
                  }
              HideLoading(LoadingClass);
              }
            });
    }
    else{
        rtn=true;
    } 
  return rtn;
}, 'Wrong Franchisee ID');


jQuery.validator.addMethod("checkamount", function(value, element) {
    var rtnstatus = true;

    var qty=value;
    var mrp = $("#productid option:selected").attr('packagemrp');
    if(parseInt(qty) > 0){
        var totalAmount=parseInt(qty)*parseInt(mrp);
        $("#amount").val(totalAmount);
    }
    else
    {
     $("#amount").val('0'); 
    }
    return rtnstatus;
}, "");

$("#productid").change(function(){
  var mrp = $("#productid option:selected").attr('packagemrp');
  $("#perqty").val(mrp);

});
