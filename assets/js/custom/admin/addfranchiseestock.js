$(document).ready(function() {
  $("#"+formid+'').validate({
    ignore: [],
    rules: {
      franchisee: {
        required: true,
      },
      /*invoiceDate: {
        required: true,
      },
      invoiceNo: {
        required: true,
      },*/
      productcount: {
        checkaddproduct: true,

      },
    },
    errorPlacement: function(error, element) {
            if (element.attr("name") == "franchisee" )
                error.insertAfter(".franchiseeerror");              
            else if(element.attr("name") == "productcount")
                error.insertAfter(".producterrormsg");      
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

/*$(document).find("#adds").click(function(){
    $('#productModel').modal('toggle');
});
$(document).find("#adds").click(function(){
    $('#modal-xl').modal('toggle');
});*/


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

