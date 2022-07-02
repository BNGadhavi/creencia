$( document ).ready(function() {
   // console.log( "ready!" );
    $('#default-datatable').dataTable().fnDestroy();
    $("#default-datatable").dataTable({"bPaginate": false});

});
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
        var mrp=$(".MRP"+pid).html();
        var dp=$(".DP"+pid).html();
        var bv=$(".BV"+pid).html();

        var TotalMrp=mrp*qty;   
        var TotalDp=dp*qty;   
        var TotalBv=bv*qty;

        netdp=netdp+TotalDp;
        netmrp=netmrp+TotalMrp;
        netbv=netbv+TotalBv;

        if(userFlag == 'member'){
            var bv1=$(".BV"+pid).html();
            var TotalBv1=bv1*qty;
            netbv1=netbv1+TotalBv1;
        }

    });
    if(isNaN(netdp)) 
    {
        netdp = 0;
    }
    if(isNaN(netmrp)) 
    {
        netmrp = 0;
    }
    if(isNaN(netbv)) 
    {
        netbv = 0;
    }

    netmrp=netmrp.toFixed(2);
    netdp=netdp.toFixed(2);
    netbv=netbv.toFixed(2);


    $(".mrptotal").html(netmrp);
    $(".dptotal").html(netdp);
    $(".pvtotal").html(netbv);
    $("#finaldp").val(netdp);

    if(userFlag == 'member'){
        if(isNaN(netbv1)) {
            netbv1 = 0;
        }
        $(".bvtotal").html(parseFloat(netbv1)); 
        $("#productmrp").val(netmrp);   
    }
    
}


function calulateTotal(pid,qty){

    var mrp=$(".MRP"+pid).html();
    var dp=$(".DP"+pid).html();
    var bv=$(".BV"+pid).html();
    
    var TotalMrp=mrp*qty;   
    var TotalDp=dp*qty;   
    var TotalBv=bv*qty;

   
    $(".mrptotal"+pid).html(TotalMrp);
    $(".dptotal"+pid).html(TotalDp);
    $(".pvtotal"+pid).html(TotalBv);

    if(userFlag == 'member'){
        var bv1=$(".BV"+pid).html();
        var TotalBv1=bv1*qty;
        $(".pvtotal"+pid).html(TotalBv1);
    }

}

function removeTotal(pid){

    $(".mrptotal"+pid).html(0);
    $(".dptotal"+pid).html(0);
    $(".pvtotal"+pid).html(0);
    if(userFlag == 'member'){
        $(".bvtotal"+pid).html(0);    
    }
    
}

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
        if(typeof stockValidateFlag !== 'undefined'){
            if(stockValidateFlag){
                var avilableQty=$(".TotalQty"+pid).html();
                if(parseInt(avilableQty) < parseInt(pqty)){
                    removekit(pid, '1', pqty);
                    removeTotal(pid);
                    footertotal();
                    $(".add"+pid).val('Add');
                    $(".mainqty"+pid).val('1');
                    cust_msg_show(0, 'error', 'top right','fa fa-times-circle', 'Product Out Of Stock');     
                    return;
                }

            }
        }
        calulateTotal(pid,qty);
        $("#productid").val(productids+comma+pid);
        $("#productqty").val(productqty+comma+pqty);
        footertotal();
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

// _____________________________PRODUCT CODE END______________________________

$("#stockadd").click(function(){
    var productids = $("#productid").val();
    var productqty = $("#productqty").val();
    if(productids!='' && productqty!='')
    {
        $.ajax({
            url:ajaxurl,
            data:{'productids':productids,'productqty':productqty},
            type:'POST',
            success:function(result)
            {
                $("#stockaddcancel").click();
                $("#ajaxresult").html(result); 
                footertotal(); 
                $(".TotalQty").css('display','none'); 
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
});