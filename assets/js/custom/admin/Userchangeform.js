$(document).ready(function() {

$("#"+formid).validate({
  rules: {
    oldmemberId: {
      required: true,
      checkUserId:true,
    },
    newmemberId:{
      required: true,
      validateUserId:true,
    },
  },
  errorPlacement: function(error, element) {
    if (element.attr("name") == "oldmemberId" )
    error.insertAfter(".membererror");
    else
    error.insertAfter(element);   
  }
});

jQuery.validator.addMethod("checkUserId", function(value, element) {
  var rtn = false;
  var msg="Wrong Username";
  var appendHtml="<i class='fa fa-user-o'></i> ";
  var LoadingClass="#"+formid;
  $("#memberName").html("<i class='fa fa-user-o'></i>  ");
    if(value!='' ){
      ShowLoading(LoadingClass);
        $.ajax({
              url: AdminUrl+"/Common/CheckMemberId", 
              data:{'username':value},
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


jQuery.validator.addMethod("validateUserId", function(value, element) {
  var rtn = true;
  var LoadingClass="#"+formid;
    if(value!='' ){
      ShowLoading(LoadingClass);
        $.ajax({
              url: AdminUrl+"/Common/CheckMemberId", 
              data:{'username':value},
              type:"POST",
              async:false,
              success: function(result){
              var response = $.parseJSON(result);
                  if(response.status){
                    rtn=false;
                  }
              HideLoading(LoadingClass);
              }
            });
    }
  return rtn;
}, 'Username Is Already Used');


});