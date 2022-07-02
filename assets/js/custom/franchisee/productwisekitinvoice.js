$(document).ready(function() {
    $("#"+formid+'').validate({
        ignore: [],
        rules: {
            productqty: {
                required:true,
                validatestock:true,
            },
            memberid:{
                required: true,
                checkmemberid:true,
            },
            otp:{
            	required: true,
             	validateOtp:true,
        	}
        },
        messages: {
            productqty: {
                required: "Please Add Atleast One Product Kit",
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "memberid" )
                     error.insertAfter(".membererror");     
            else
                error.insertAfter(element);   
        }
    });
});

jQuery.validator.addMethod("ValidateBalance", function(value, element) {
    var rtnstatus = false;
    /*var finalamount=$("#finalamount").val();

    if(parseInt(finalamount) > parseInt(balance)){
        
    }
    else{
        rtnstatus=true;
    }
   
    return rtnstatus;*/
}, "You Have Not Enough Balance");
 
if(typeof userFlag !== 'undefined'){
}
else{
    var userFlag='';      
}
$(document).ready(function() {

    if(typeof stockValidateFlag !== 'undefined'){
     
    }
    else{
        var stockValidateFlag=false;
    }

    

});

// _____________________________PRODUCT CODE START______________________________
$(document).find("#adds").click(function(){
    $('#productModel').modal('toggle');
});
$(document).find("#adds").click(function(){
    $('#modal-xl').modal('toggle');
});

function addtokit(pid, qty) 
{
    
    var pqty = qty;
    var finalamount=$("#finalamount").val();
    if(parseInt(pqty)>0 && pqty % 1 === 0)
    {   
        
        var productids = $("#productid").val();
        var productqty = $("#productqty").val();
        var comma = ",";
        if(productids == '') 
        {
            comma = '';
        }

        var avilableQty=$("#add"+pid).attr('stock');
        if(parseInt(avilableQty) < parseInt(pqty)){
            removekit(pid, '1', pqty);
            removeTotal(pid);
            footertotal();
            $("#add"+pid).val('Add');
            $(".mainqty"+pid).val('1');
            cust_msg_show(0, 'error', 'top right','fa fa-times-circle', 'Enter Proper Quantity');     
        }
        else
        {
            calulateTotal(pid,qty);
            $("#productid").val(productids+comma+pid);
            $("#productqty").val(productqty+comma+pqty);
            footertotal();
            $("#add"+pid).addClass('removetokit');
            $("#add"+pid).val('Update');
            $(".mainqty"+pid).val(pqty);
            cust_msg_show(0, 'success', 'top right','fa fa-check-circle', 'Product Added Successfully');
        }
    }
    else 
    {
       cust_msg_show(0, 'error', 'top right','fa fa-times-circle', 'Enter Proper Quantity');
    }
}

$('body').on('click', '.addtokit', function() {
    var pid = $(this).attr('pid');
    //var qty = $(this).closest('tr').find('.qtytextbox').val();
    var qty = $("#qty"+pid+'').val();

    if($(this).hasClass('removetokit')) 
    {
        removekit(pid, '', qty);
    }
    else
    {
        //console.log("Hello");
        addtokit(pid, qty);
    }
});



$('body').on('click', '.deletekit', function() {
    var pid = $(this).attr('pid');
    //var qty = $(this).closest('tr').find('.qtytextbox').val();
    var qty = $("#qty"+pid+'').val();
    removekit(pid, '1', qty);
});

function footertotal()
{
    //Footer Total
    var pias = $("#productid").val();
    var parr = pias.split(',');

    var pqtyaw = $("#productqty").val();
    var pqarr = pqtyaw.split(',');
    var netdp=0;
    var netmrp=0;
    var netbv=0;
    var netbv1=0;
    $.each(parr,function(key, value)
    {
        var qty=pqarr[key];
        var pid=value;
        var mrp=$("#add"+pid).attr('mrp');
        var TotalMrp=mrp*qty;   
        netmrp=netmrp+TotalMrp;
    });
    
    if(isNaN(netmrp)) 
    {
        netmrp = 0;
    }
    netmrp=netmrp.toFixed(2);
    $(".mrptotal").html(netmrp);
    $("#finalamount").val(netmrp);
    //ValidateBalance();
}


function calulateTotal(pid,qty){
    var mrp=$("#add"+pid).attr('mrp');
    var TotalMrp=mrp*qty;   
    $(".mrptotal"+pid).html(TotalMrp);
}

function removeTotal(pid){
    $(".mrptotal"+pid).html(0);
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
                removeTotal(pid);
                footertotal();
                cust_msg_show(0, 'success', 'top right','fa fa-check-circle', 'Product Remove Successfully');
            }
        }
    }
    else
    {
        cust_msg_show(0, 'error', 'top right','fa fa-times-circle', 'Enter Proper Quantity');
    }
}
function getkitdetail(kitid){
    $.ajax({
            url:Franchisee_url+'MemberInvoice/GetProductKitDetail',
            data:{'kitid':kitid},
            type:'POST',
            async: false,
            success:function(result){
                $('#primarymodaldata').modal('toggle');
                $("#primarymodaldata").modal('show');
                $(".modal-body-data").html(result);
            }
    });
}

var membermsg = function() {
   return membererror;
};

$.validator.addMethod("checkmemberid", function(value, element) {
    value=$("#memberid").val();
    var LoadingClass="#"+formid;
    var rtnstatus = false;
    var appendHtml="<i class='fa fa-user-o'></i> ";
    $("#memberName").html("<i class='fa fa-user-o'></i>  ");
    $("#Balance").val('0');
    $("#mobile").val('0');
    $.ajax({
            url:Franchisee_url+'CommonController/KitMemberidValid',
            data:{'memberId':value,'type':0},
            type:'POST',
            dataType:"json",
            async: false,
            beforeSend: function() {
                ShowLoading(LoadingClass);
            },
            success:function(result)
            {
               rtnstatus = result.status;
               var actstatus=result.activestatus;
               $("#memberstatus").val(actstatus);
               activemember=result.activestatus;
                if(rtnstatus)
                {	
                    $("#memberName").html(appendHtml+result.memberName);
                    if(result.activestatus=='1'){
                        $("#Balance").val(result.balance);
                        $("#mobile").val(result.mobile);

                        var walletbalance=result.balance;
                        var pias = $("#productid").val();
                        if(pias!='')
                        {
                        	var parr = pias.split(',');
					        var pqtyaw = $("#productqty").val();
					        var pqarr = pqtyaw.split(',');
					        var withgstop='0';
					        $.each(parr,function(key, value)
					        {
					            var qtyqp=pqarr[key];
					            var piadfh=value;
				                var mrp = $("#add"+piadfh).attr('mrp');
				                var totalop= parseFloat(mrp) * parseInt(qtyqp);
				                withgstop=parseFloat(withgstop)+parseFloat(totalop);    
					        });    
					        var datd=isNaN(parseFloat(withgstop)) ? 0 : parseFloat(withgstop);
					        var netamountas= parseFloat(datd);
					        if(parseFloat(netamountas) > parseFloat(walletbalance)){
					        	rtnstatus = false;
                        		membererror="Insufficiant Wallet Balance.";
					        }
                        }
                    }
                    else{
                        rtnstatus = false;
                        membererror="Member ID Inactive.";
                    }
                }
                else{
                     membererror=result.msg;
                }
                HideLoading(LoadingClass);
            }
        }); 
    return rtnstatus;
}, membermsg);

function sendotp() {
	var memberid = $("#memberid").val();
	var mobile = $("#mobile").val();
	if(memberid!='')
	{
		if(activemember=='1')
		{
			if(parseInt(mobile)>0)
			{
				var pias = $("#productid").val();
                if(pias!='')
                {
                	var parr = pias.split(',');
			        var pqtyaw = $("#productqty").val();
			        var pqarr = pqtyaw.split(',');
			        var withgstop='0';
			        $.each(parr,function(key, value)
			        {
			            var qtyqp=pqarr[key];
			            var piadfh=value;
		                var mrp = $("#add"+piadfh).attr('mrp');
		                var totalop= parseFloat(mrp) * parseInt(qtyqp);
		                withgstop=parseFloat(withgstop)+parseFloat(totalop);    
			        });    
			        var datd=isNaN(parseFloat(withgstop)) ? 0 : parseFloat(withgstop);
			        var netamountas= parseFloat(datd);
			        var walletbalance = $("#Balance").val();

			        if(parseFloat(netamountas) > parseFloat(walletbalance)){
                		errorswal("Insufficiant Wallet Balance.", 'error', 'Error');
			        }
			        else
			        {
			        	var LoadingClass="#"+formid;
			        	$.ajax({
			                url:Franchisee_url+'CommonController/Sendotp',
			                data:{'memberId':memberid,type:1},
			                type:'POST',
			                dataType:"json",
			                async: false,
			                beforeSend: function() {
			                    ShowLoading(LoadingClass);
			                },
			                success:function(result)
			                {
			                    HideLoading(LoadingClass);
			                    errorswal("OTP Sent To Your Register Mobile No", 'success', 'Success');
			                }
			            }); 
			        }
                }
                else
                {
                	errorswal("Please Add Product First", 'error', 'Error');
                }
			}
			else
			{
				errorswal("Please First Update Mobile No.", 'error', 'Error');
			}
		}
		else
		{
			errorswal("Member ID Inactive", 'error', 'Error');
		}
	}
	else
	{
		errorswal("Enter Member ID", 'error', 'Error');
	}
}
function errorswal(msgtext, swaltype, swaltitle) {
    swal({
        title: swaltitle,
        text: msgtext,
        type: swaltype,
        timer: 5000,
        showConfirmButton: true,
        confirmButtonText: 'Close',
        confirmButtonClass: 'btn btn-danger',
        buttonsStyling: true,
    });
}
$.validator.addMethod("validateOtp", function(value, element) {
    var LoadingClass="#"+formid;
    var rtnstatus = false;

    var memberid=$("#memberid").val();
    var otp=$("#otp").val();
    
    $.ajax({
            url:Franchisee_url+'CommonController/ValidateOTP',
            data:{'memberid':memberid,'otp':otp},
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

jQuery.validator.addMethod("validatestock", function(value, element) {
    var rtnstatus = false;
    var productid = $("#productid").val();
    var productqty = $("#productqty").val();
    $.ajax({
        url:Franchisee_url+'MemberInvoice/CheckProductKitStock',
        data:{'productid':productid,'productqty':productqty},
        type:'POST',
        dataType:"json",
        async: false,
        success:function(result){
            rtnstatus = result.status;
        }
    });
    return rtnstatus;
}, "Insufficiant Kit's Product Stock");