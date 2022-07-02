$(document).ready(function() {

$(document).find("#adds").click();

  $("#"+formid+"").validate({
    ignore: [],
    rules: {
        productcount: {
            checkaddproduct: true,
        },
        proof:{
            extension: "jpg|png|jpeg",  
        }
       /* walletuse:{
             required: false,
        },
        otp:{
             required: false,
             validateOtp:true,
        }*/
    },
    errorPlacement: function(error, element) {
        if(element.attr("name") == "productcount")
            error.insertAfter(".producterrormsg");
        /*else if(element.attr("name") == "walletuse")
            error.insertAfter(".walletuse-label");*/         
        else
            error.insertAfter(element);   
    },
    invalidHandler: function(form, validator) {
        if($(validator.errorList[0].element).attr("id") == 'productcount')
        {
            $(document).find("#adds").click();
        }
    }
  });
});

$.validator.addMethod("checkaddproduct", function(value, element) {
    var rtnstatus = false;
    if($("#ajaxresult table tbody tr").length > 0) {
        rtnstatus = true;
    }
    return rtnstatus;
}, "Please Add Atleast one product");


$(document).find("#stockadd").click(function(){
   if($("#productid").val()!='') 
    {
         $("#pmode").css("display","block");

         $("#walletbalance").html(walletBalance);
         if(parseInt(walletBalance)<=0){
            $("#walletuse").prop("disabled", true);
         }
         else{
            $("#walletuse").prop("disabled", false);
         }

          var TotalPaidAmt=$("#finaldp").val();
          var cashamt=TotalPaidAmt;
          $('#cashamt').html(cashamt);
    }
    else
    {
         $("#pmode").css("display","none");
    }
});


$('#walletuse').on('change', function() { 
    var LoadingClass="#"+formid;
    var rtnstatus = false;
    var TotalPaidAmt=$("#finaldp").val();
    var cashamt=TotalPaidAmt;
    var WalletAmt=$("#walletbalance").html();   
    var paymentwallet=0;

    $("#cashamt").html(cashamt);
    $("#paymentwallet").html(0); 

    if(document.getElementById('walletuse').checked) { 
       // $('#otp').attr('required',true);
        $("#otpdiv").css('display','flex');
        if(parseInt(WalletAmt) >= parseInt(TotalPaidAmt)){
            paymentwallet=TotalPaidAmt;
            cashamt=0;
        }
        else{
            cashamt=TotalPaidAmt-WalletAmt;   
            paymentwallet=TotalPaidAmt-cashamt;
        }    
        
        $("#cashamt").html(cashamt);
        $("#paymentwallet").html(paymentwallet);
        
         $.ajax({
                url:Franchisee_url+'CommonController/Sendfranchiseeotp',
                data:{'fid':fid,type:2},
                type:'POST',
                dataType:"json",
                async: false,
                beforeSend: function() {
                    ShowLoading(LoadingClass);
                },
                success:function(result)
                {
                    HideLoading(LoadingClass);
                   
                }
            }); 
       
    }
    else{
        //$('#otp').attr('required',false);
        $("#otpdiv").css('display','none');
        cashamt=TotalPaidAmt;
        $("#cashamt").html(cashamt);
        $("#paymentwallet").html(0);    
    }
    
    if(cashamt==0){
        
        $("#pmode").css('display','none');
        $('#tno').attr('required',false);
        $('#pmode1').attr('required',false);
        $('#proof').attr('required',false);
    } 
    else{
        $("#pmode").css('display','block');  
        $('#tno').attr('required',true);
        $('#pmode1').attr('required',true);
        $('#proof').attr('required',true);
    }
   
});



/*// _____________________________PRODUCT CODE START______________________________

$('body').on('click', '.addtokit', function() {
    var pid = $(this).attr('pid');
    var qty = $(this).closest('tr').find('.qtytextbox').val();
    if($(this).hasClass('removetokit')) 
    {
       
        removekit(pid, '', qty);
    }
    else
    {
       
        addtokit(pid, qty);
    }
});

$('body').on('click', '.deletekit', function() {
    var pid = $(this).attr('pid');
    var qty = $(this).closest('tr').find('.qtytextbox').val();
    removekit(pid, '1', qty);
});

function addtokit(pid, qty) 
{
    var pqty = qty;
    if(parseInt(pqty)>0 && pqty % 1 === 0)
    {
        var productids = $("#productid").val();
        var productqty = $("#productqty").val();
        var comma = ",";
        
        if(productids == '') 
        {
            comma = '';
        }
        $("#productid").val(productids+comma+pid);
        $("#productqty").val(productqty+comma+pqty);
        $(".add"+pid).addClass('removetokit');
        $(".add"+pid).val('Update');
        $(".mainqty"+pid).val(pqty);
        cust_msg_show(0, 'success', 'top right','fa fa-check-circle', 'Product Added Successfully');
    }
    else 
    {
       cust_msg_show(0, 'error', 'top right','fa fa-times-circle', 'Enter Proper Quantity');
    }
}

function removekit(pid, deleteid, qty)
{
    var pqtys = qty;
    if((parseInt(pqtys)>0 || deleteid!='') && (pqtys % 1 === 0))
    {
        var productids = $("#productid").val();
        var productarr = productids.split(',');

        var productqty = $("#productqty").val();
        var productqtyarr = productqty.split(',');
        
        var removeid = '';

        $.each( productarr, function( key, value ) {
            if(value == pid) {
                removeid = key;

            }
        });

        console.log(removeid);
        if(parseInt(removeid)>=0)
        {
            productarr.splice(removeid,1);
            productqtyarr.splice(removeid,1);
            
            $("#productid").val(productarr.join());
            $("#productqty").val(productqtyarr.join());    
        }
        
        //$("#qty"+pid).attr('readonly',false);
        if(deleteid=='')
        {
            addtokit(pid,qty);
        }
        else
        {
            if(parseInt(removeid)>=0)
            {
                $(document).find("#tr"+pid).remove();
                $(".add"+pid).val('Add');
                $(".mainqty"+pid).val('1');
            
                cust_msg_show(0, 'success', 'top right','fa fa-check-circle', 'Product Remove Successfully');
            }
        }
    }
    else
    {
        cust_msg_show(0, 'error', 'top right','fa fa-times-circle', 'Enter Proper Quantity');
    }
}

// _____________________________PRODUCT CODE END______________________________

$("#stockadd").click(function(){
    var productids = $("#productid").val();
    var productqty = $("#productqty").val();
    if(productids!='' && productqty!='')
    {
        $.ajax({
            url:CommonUrl+"Stockcommon/Createtable",
            data:{'productids':productids,'productqty':productqty},
            type:'POST',
            success:function(result)
            {
                $("#stockaddcancel").click();
                $("#ajaxresult").html(result);   
            }
        });
    }
    else
    {
        swal({
            title: 'Please Add Atleast One Product',
            text: '',
            type: 'warning',
            buttonsStyling: false,
            confirmButtonClass: 'btn btn-light'
           
        })
    }
});*/


$.validator.addMethod("validateOtp", function(value, element) {
    var LoadingClass="#"+formid;
    var rtnstatus = false;

    var otp=$("#otp").val();
    
    $.ajax({
            url:Franchisee_url+'CommonController/ValidatefranchiseeOTP',
            data:{'fid':fid,'otp':otp},
            type:'POST',
            dataType:"json",
            async: false,
            beforeSend: function() {
                ShowLoading(LoadingClass);
            },
            success:function(result){
                rtnstatus = result.status;
                HideLoading(LoadingClass);

            }
        }); 
    return rtnstatus;
},'Invalid OTP');