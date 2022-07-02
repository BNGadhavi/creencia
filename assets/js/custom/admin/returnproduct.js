$(document).ready(function() {
  $("#"+formid).validate({
    ignore: [],
    rules: {
      franchiseetype:{
        required: true,
      },
      franchiseeid:{
        required: true,
      },
      productcount: {
        checkaddproduct: true,
      },
      
    },
     errorPlacement: function(error, element) {
      if (element.attr("name") == "franchiseetype" )
        error.insertBefore(".typeerror"); 
      else if (element.attr("name") == "franchiseeid" )
        error.insertBefore(".franchiseeerror"); 
      else if(element.attr("name") == "productcount")
            error.insertAfter(".producterrormsg");  
      else
        error.insertAfter(element);   
    }
  });
});

$.validator.addMethod("checkaddproduct", function(value, element) {
    console.log("akdjkahdjahdj");
    var rtnstatus = false;
    var productid=$("#productid").val();
    if($("#ajaxresult table tbody tr").length > 0) {
        if(productid!=''){
            rtnstatus = true;    
        }
        
    }
    console.log(rtnstatus);
    return rtnstatus;
}, "Please Add Atleast one product");


$('#franchiseetype').change(function() {
     var franchiseetype=$("#franchiseetype").val();
     var LoadingClass="#"+formid;
    $("#franchiseeid").html("<option value='' selected disabled>Select Franchisee</option>");
     if(franchiseetype!=''){
      ShowLoading(LoadingClass);
        $.ajax({
            url: AdminUrl+"/Franchiseestock/GetFranchiseeUsingType", 
            data:{'franchiseetype':franchiseetype},
            type:"POST",
            async:false,
            success: function(result){
            var response = $.parseJSON(result);
                
                if(response.status){
                  $.each(response.data, function(i) {
                    $('#franchiseeid').append('<option value="' + response.data[i].id + '">' + response.data[i].fullname + '</option>');
                    });
                }
            HideLoading(LoadingClass);
            }
        });

     }
});

$(document).find("#deduct").click(function(){
    
    var franchiseeid=$("#franchiseeid").val();
    var LoadingClass="#"+formid;
      
    if(franchiseeid!='') {
      $('#default-datatable').dataTable().fnDestroy();
      ShowLoading(LoadingClass);
      $.ajax({
        url: AdminUrl+"/Franchiseestock/GetStockOfFranchisee", 
        data:{'franchiseeid':franchiseeid},
        type:"POST",
        async:false,
        success: function(result){
        //var response = $.parseJSON(result);
        //if(response.status){
          $(".modal-body").html(result);
          $('#productModel').modal('toggle');
        //}
        HideLoading(LoadingClass);
        }
      });
      $('#default-datatable').dataTable();
    }
});


$('#franchiseeid').change(function() {
    var franchiseeid=$("#franchiseeid").val();
    var LoadingClass="#"+formid;
    if(franchiseeid!=''){
      ShowLoading(LoadingClass);
      $.ajax({
            url: AdminUrl+"/Franchiseestock/GetParentFranchisee", 
            data:{'franchiseeid':franchiseeid},
            type:"POST",
            async:false,
            success: function(result){
            var response = $.parseJSON(result);
            if(response.status){
              $("#parentfranchisee").val(response.name);
            }
            HideLoading(LoadingClass);
            }
        });
    }
});