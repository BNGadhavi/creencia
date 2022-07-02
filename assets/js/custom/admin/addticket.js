$(document).ready(function() {

jQuery.validator.addMethod("checkTicketName", function(value, element) {
  var rtn = false;
  var LoadingClass="#TicketNameForm";
  ShowLoading(LoadingClass);
  
  $.ajax({
          url: AdminUrl+"/Support/checkTicketName", 
          data:{'ticketName':value},
          type:"POST",
          async:false,
          success: function(result){
          var response = $.parseJSON(result);
          rtn=response.status;
          HideLoading(LoadingClass);
          }
        });
  
  return rtn;
}, 'Ticket Name Already Exist!');

$("#TicketNameForm").validate({
  rules: {
    ticketName: {
      required: true,
      checkTicketName:true,
    }
  }
});


});