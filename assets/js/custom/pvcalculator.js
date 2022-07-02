$( document ).ready(function() {
    $('#default-datatable').dataTable().fnDestroy();
    $("#default-datatable").dataTable({"bPaginate": true});
});

// _____________________________PRODUCT CODE START______________________________
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

function calulateTotal(pid,qty){
    var mrp=$(".MRP"+pid).html();
    var dp=$(".DP"+pid).html();
    var bv=$(".BV"+pid).html();
    var pv=$(".PV"+pid).html();
    
    var TotalMrp = mrp*qty;   
    var TotalDp = dp*qty;   
    var TotalBv = bv*qty;
    var TotalPv = pv*qty;
   
    $(".mrptotal"+pid).html(TotalMrp);
    $(".dptotal"+pid).html(TotalDp);
    $(".bvtotal"+pid).html(TotalBv);
    $(".pvtotal"+pid).html(TotalPv);

    var netmrp = parseFloat($(".mrptotal").html());
    var netdp = parseFloat($(".dptotal").html());
    var netbv = parseFloat($(".bvtotal").html());
    var netpv = parseFloat($(".pvtotal").html());

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
    if(isNaN(netpv)) 
    {
        netpv = 0;
    }

    netmrp = parseFloat(netmrp) + parseFloat(TotalMrp);
    netdp = parseFloat(netdp) + parseFloat(TotalDp);
    netbv = parseFloat(netbv) + parseFloat(TotalBv);
    netpv = parseFloat(netpv) + parseFloat(TotalPv);

    /*netmrp = netmrp.toFixed(2);
    netdp = netdp.toFixed(2);
    netbv = netbv.toFixed(2);
    netpv = netpv.toFixed(2);*/
    $(".mrptotal").html(netmrp);
    $(".dptotal").html(netdp);
    $(".bvtotal").html(netbv);
    $(".pvtotal").html(netpv);

}

function removeFooterTotal(pid) {
    var TotalMrp = $(".mrptotal"+pid).html();
    var TotalDp = $(".dptotal"+pid).html();
    var TotalBv = $(".bvtotal"+pid).html();
    var TotalPv = $(".pvtotal"+pid).html();

    var netmrp = $(".mrptotal").html();
    var netdp = $(".dptotal").html();
    var netbv = $(".bvtotal").html();
    var netpv = $(".pvtotal").html();

    netmrp = netmrp - TotalMrp;
    netdp = netdp - TotalDp;
    netbv = netbv - TotalBv;
    netpv = netpv - TotalPv;

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
    if(isNaN(netpv)) 
    {
        netpv = 0;
    }

    netmrp = netmrp.toFixed(2);
    netdp = netdp.toFixed(2);
    netbv = netbv.toFixed(2);
    netpv = netpv.toFixed(2);
    $(".mrptotal").html(netmrp);
    $(".dptotal").html(netdp);
    $(".bvtotal").html(netbv);
    $(".pvtotal").html(netpv);
}

function addtokit(pid, qty) {
    var pqty = qty;
    if(parseInt(pqty)>0 && pqty % 1 === 0)
    {
        var productids = $("#productid").val();
        var productqty = $("#productqty").val();
        var comma = ",";
        if(productids == '') {
            comma = '';
        }

        calulateTotal(pid,qty);
        $("#productid").val(productids+comma+pid);
        $("#productqty").val(productqty+comma+pqty);
        $(".add"+pid).addClass('removetokit');
        $(".add"+pid).val('Update');
        $(".mainqty"+pid).val(pqty);
        cust_msg_show(0, 'success', 'top right', 'fa fa-check-circle', 'Product Added Successfully');
    }
    else 
    {
       cust_msg_show(0, 'error', 'top right', 'fa fa-times-circle', 'Enter Proper Quantity');
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
            removeFooterTotal(pid);
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
                cust_msg_show(0, 'success', 'top right','fa fa-check-circle', 'Product Remove Successfully');
            }
        }
    }
    else
    {
        cust_msg_show(0, 'error', 'top right','fa fa-times-circle', 'Enter Proper Quantity');
    }
}