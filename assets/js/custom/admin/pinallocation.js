$(document).ready(function() {

jQuery.validator.addMethod("checkUserId", function(value, element) {
  var rtn = false;
  var type = $("input[name='type']:checked").val();
  var msg="Wrong Username";
  var appendHtml="<i class='fa fa-user-o'></i> ";
  var LoadingClass="#PinAllocationForm";
  $("#memberName").html("<i class='fa fa-user-o'></i>  ");
    if(value!='' && type!=''){
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
                    $("#memberName").html(appendHtml+response.data[0]['Name']);
                  }
              HideLoading(LoadingClass);
              }
            });
    }
    else{
        msg="Enter Username";
        rtn=true;
    } 
  return rtn;
}, 'Wrong Username');

$("#PinAllocationForm").validate({
  rules: {
    type:{
      required: true,
    },
    packageId: {
      required: true,
    },
    memberId: {
      required: true,
      checkUserId:true,
    },
    noOfPin:{
      digits:true,
      required: true,
    },
  },
  errorPlacement: function(error, element) {
    if (element.attr("name") == "memberId" )
    error.insertAfter(".membererror");
    else if (element.attr("name") == "packageId" )
    error.insertBefore(".packageerror");   
    else
    error.insertAfter(element);   
  }
});


});