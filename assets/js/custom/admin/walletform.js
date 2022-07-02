$(document).ready(function() {
    $("#"+formid).validate({
      rules: {
        type:{
          required: true,
        },
        memberId: {
          required: true,
          checkBalance:true,
          checkUserId:true,
        },
        amount:{
          digits:true,
          required: true,
        },
      },
      errorPlacement: function(error, element) {
        if (element.attr("name") == "memberId" )
        error.insertAfter(".membererror");
        else if (element.attr("name") == "type" )
        error.insertAfter(".type-div");   
        else
        error.insertAfter(element);   
      }
    });
});

jQuery.validator.addMethod("checkUserId", function(value, element) {
  var rtn = false;
  var type = $("input[name='type']:checked").val();
  var msg="Wrong Username";
  var appendHtml="<i class='fa fa-user-o'></i> ";
  var LoadingClass="#"+formid;
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

jQuery.validator.addMethod("checkBalance", function(value, element) {
  var rtn = true;
  var type = "Capital Wallet";
  $(".bal").css('display','none');
  var LoadingClass="#"+formid;
    if(value!='' && type!=''){
      ShowLoading(LoadingClass);
      $.ajax({
        url: AdminUrl+"/Common/CheckWalletbalance", 
        data:{'username':value,'type':type},
        type:"POST",
        async:false,
        success: function(result){
        var response = $.parseJSON(result);
        if(parseFloat(response.Balance)>'0')
        {
          $(".bal").css('display','block');
          $("#bal").text(response.Balance);
        }
        else
        {
          $(".bal").css('display','block');
          $("#bal").text('0'); 
        }
        HideLoading(LoadingClass);
        }
      });
    }
  return rtn;
}, '');
