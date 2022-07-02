$(document).ready(function() {

  $("#"+formid+'').validate({
  	ignore: [],
    rules: {
      kitname:{
        required: true,
      },
      pcode: {
        required: true,
      },
      productqty: {
	  	required:true,
	  },
      kitid:{
        required: true,
        checkkitid:true,
      },
      discommission: {
        required:true,
        min:0,
        digits:true,
      },
      minicommission:{
        required: true,
        min:0,
        digits:true,
      }
    },
    messages: {
        productqty: {
            required: "Please Add Atleast One Product",
        }
    },
    errorPlacement: function(error, element) {
    	if (element.attr("name") == "pcode" )
      	error.insertAfter(".pcodeerror");
      	else if (element.attr("name") == "productqty" )
      	error.insertAfter("#plabel");
    	else
     	error.insertAfter(element);   
    }
  });
});

$(document).find(".addtokit").click(function(){
    var pid = $(this).attr('pid');
    if($(this).hasClass('removetokit')) 
    {
        removekit(pid,'');
    }
    else
    {
        addtokit(pid);
    }
});
$(document).find(".deletekit").click(function(){
    var pid = $(this).attr('pid');
    removekit(pid,'1');
});

function addtokit(pid) 
{
    var pqty = $("#qty"+pid).val();
    if(parseInt(pqty)>0)
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
        $("#add"+pid).addClass('removetokit');
        $("#spans"+pid).text('Update');
        $(".mainqty"+pid).val(pqty);

        cust_msg_show(0, 'success', 'top right','fa fa-check-circle', 'Product Added Successfully');
    }
    else
    {
        cust_msg_show(0, 'error', 'top right','fa fa-times-circle', 'Enter Proper Quantity');
    }
}

function removekit(pid,deleteid)
{
    var pqtys = $("#qty"+pid).val();
    if(parseInt(pqtys)>0)
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

        if(deleteid=='')
        {
            addtokit(pid);
        }
        else
        {
        	cust_msg_show(0, 'info', 'top right','fa fa-times-circle', 'Product Deleted Successfully');
        	$("#qty"+pid).val('0');
        	$("#spans"+pid).text('Add');
        }
    }
    else
    {
    	cust_msg_show(0, 'error', 'top right','fa fa-times-circle', 'Enter Proper Quantity');
    }
}

jQuery.validator.addMethod("checkkitid", function(value, element) {
    var rtn = true;
    var LoadingClass="#"+formid+"";
    ShowLoading(LoadingClass);
    $.ajax({
        url: AdminUrl+"/ProductKit/CheckKitid",
        data:{'kitid':value},
        type:"POST",
        async:false,
        success: function(result){
            var response = $.parseJSON(result);
            if(!response.status)
            {
              rtn=false;
            }
            HideLoading(LoadingClass);
        }
      });
  return rtn;
}, 'This Kit Id Is Already Taken');

$("#pcode").change(function(){
    var mrp=$('option:selected', this).attr('mrp');
    var appendHtml="<i class='fa fa-inr'></i> ";
    $("#pmrp").html(appendHtml+mrp);
});