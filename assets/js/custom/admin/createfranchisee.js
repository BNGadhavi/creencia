$(document).ready(function() {
  $("#"+formid+'').validate({
    rules: {
      fname:{
        required: true,
      },
      stateid: {
        required: true,
      },
      city: {
        required: true,
      },
      mobile:{
        required: true,
        digits:true,
        mobileno:true,
      },
      fid: {
        required: true,
        checkfranchiseeid:true,
      },
      type:{
        required: true,
      },
      password: {
        required: true,
      },
      cpassword:{
        required: true,
        equalTo: "#password",
      },
      rent:{
        digits:true,
        min:0,
      },
      sponsorbonus:{
        digits:true,
        min:0,
      },
      sponsor:{
        checkUserId:true,
      }
    },
    errorPlacement: function(error, element) {
      if (element.attr("name") == "city" )
      error.insertAfter(".cityerror");
      else if (element.attr("name") == "stateid" )
      error.insertBefore(".staterror");   
      else if (element.attr("name") == "sponsor" )
        error.insertAfter(".membererror");
      else
      error.insertAfter(element);   
    }
  });
});

jQuery.validator.addMethod("mobileno", function(value, element) {
  return this.optional(element) || /^[6-9]{1}[0-9]+$/.test(value);
}, "Enter Valid Mobile Number");

$("#stateid").change(function(){
  var state=$("#stateid").val();
  var LoadingClass="#"+formid+"";
    if(state=='')
    {
    }  
    else
    {
        ShowLoading(LoadingClass);
        $("#city").html("<option value='' selected disabled>Select City</option>");
        $.ajax({
            url:base_url+'register/GetCity',
            data:{'state':state},
            type:'POST',
            success:function(result)
            {
                var response = $.parseJSON(result);
                if(response.status) {
                    $.each(response.city, function(i) {
                    $('#city').append('<option value="' + response.city[i].id + '">' + response.city[i].name + '</option>');
                    });
                }
                HideLoading(LoadingClass);
            }
        });
    }
});

jQuery.validator.addMethod("checkfranchiseeid", function(value, element) {
  var rtn = true;
  if($('#fid').is('[readonly]'))
  {
  }
  else
  {
    var LoadingClass="#"+formid+"";
    ShowLoading(LoadingClass);
    var type='Franchisee';
    $.ajax({
        url: AdminUrl+"/Common/CheckMemberId",
        data:{'username':value,'type':type},
        type:"POST",
        async:false,
        success: function(result){
        var response = $.parseJSON(result);
        if(response.status)
        {
          rtn=false;
        }
        HideLoading(LoadingClass);
        }
      });
  }
  return rtn;
}, 'This Franchisee Id Is Already Taken');

$("#type").change(function(){
  var rtn = false;
  var type=$("#type").val();
  var editid=$("#editid").val();
  var parentid = $('#type option:selected').attr('parentid');
  $('#parentFranchisee').html("");
  //$('#rent').val('');
  $('#parentFranchisee').html("<option value='0' >Admin</option>");
  if(type=='1')
  {
    //$('#parentFranchisee').html("<option value='0' >Admin</option>");
    //$('.districtclass').css('display','block');
    //$('#rent').prop('required',true);
  }
  else
  {
    //$('.districtclass').css('display','none');
    //$('#rent').prop('required',false);
  }
  
  if(parentid!=0){
      var LoadingClass="#"+formid+"";
      ShowLoading(LoadingClass);
      //$("#parentdiv").show();
     
        $.ajax({
            url: AdminUrl+"/Franchisee/GetParentFranchiseeId",
            data:{'parentid':parentid,'editid':editid},
            type:"POST",
            async:false,
            success: function(result){
            var response = $.parseJSON(result);
            if(response.status){
                rtn=true;
                //$('#parentFranchisee').html("<option value='0' selected>Admin</option>");
                $.each(response.data, function(i) {
                  var select='';
                  if(parentFranchiseeId==response.data[i].id){
                    select='selected';
                  }
                  $('#parentFranchisee').append('<option '+ select +' value="' + response.data[i].id + '">' + response.data[i].username + '</option>');
                });
            }
            else{
              rtn=false;
              //$('#parentFranchisee').html("<option value='0' selected>Admin</option>");
            }
          
            HideLoading(LoadingClass);
            }
        });  
  }
  else{
    rtn =true;
    //$("#parentdiv").hide();
  }

  //return rtn;
});
jQuery.validator.addMethod("checkUserId", function(value, element) {
  var rtn = false;
  var appendHtml="<i class='fa fa-user-o'></i> ";
  $("#memberName").html("<i class='fa fa-user-o'></i>  ");
    if(value!=''){
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
              }
            });
    }
    else{
        rtn=true;
    } 
  return rtn;
}, 'Wrong Sponsor ID');