$(document).ready(function() {
    $("#"+formid+'').validate({
        ignore: [],
        rules: {
            productqty: {
                required:true,
                //validatebalance:true,
            },
            franchisee: {
                required: true,
            }
        },
        messages: {
            productqty: {
                required: "Please Add Atleast One Product Kit",
            }
        },
        errorPlacement: function(error, element) {
                if (element.attr("name") == "franchisee" )
                    error.insertAfter(".franchiseeerror");              
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
        
        calulateTotal(pid,qty);
        $("#productid").val(productids+comma+pid);
        $("#productqty").val(productqty+comma+pqty);
        footertotal();
        $("#add"+pid).addClass('removetokit');
        $("#add"+pid).val('Update');
        $(".mainqty"+pid).val(pqty);
        cust_msg_show(0, 'success', 'top right','fa fa-check-circle', 'Product Added Successfully');    
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

function fetchfranchisee(value)
{
    $.ajax({
        url:AdminUrl+"/Franchiseestock/FranchiseeList",
        data:{'value':value},
        type:'POST',
        success:function(result)
        {
            var response = $.parseJSON(result);
            if(response.status) {
                $.each(response.data, function(i) {
                $('#franchisee').append('<option value="' + response.data[i].id + '">' + response.data[i].name + ' - ' + response.data[i].username + '</option>');
                });
            }
            
        }
    });
}




// _____________________________PRODUCT CODE END______________________________





