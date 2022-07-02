$(document).ready(function() {
    $("#"+formid+'').validate({
        rules: {
            packageId: {
                required: true,
            },
            noofpin:{
                digits:true,
                required: true,
                min:1,
                checkbal:true,
            }
        },
        errorPlacement: function(error, element) {
        if (element.attr("name") == "packageId" )
            error.insertAfter(".packageerror");
        else if (element.attr("name") == "noofpin" )
            error.insertAfter(".pinerror");
        else
             error.insertAfter(element);   
        }
    });
});
function packageamt(){
    var packageId = $("#packageId").val();
    var packageMrp = $("#packageId option:selected").attr('mrp');
    $("#packagemrp").html(packageMrp+"&nbsp;<i aria-hidden='true' class='fa fa-inr'></i>");
}

jQuery.validator.addMethod("checkbal", function(value, element) {
    var rtn = false;
    var LoadingClass="#"+formid+"";
    $("#tdsAmount").html("");
    $("#acAmount").html("");
    $("#netAmount").html(0);
    ShowLoading(LoadingClass);
    if(parseInt(value)>0)
    {
        var packageMrp = $("#packageId option:selected").attr('mrp');
        var total=parseInt(packageMrp) * parseInt(value);
        var totaltds=parseInt(total) * TDS /100;
        var totalac=parseInt(total) * AdminCharge /100;
        var net=parseInt(total) + parseFloat(totaltds) + parseFloat(totalac);
        totaltds=totaltds.toFixed(2);
        totalac=totalac.toFixed(2);
        net=net.toFixed(2);
        if(parseFloat(wallet)>=parseFloat(net))
        {
            rtn = true; 
        }
        if(isNaN(totaltds))
        {
            totaltds=0;
        }
        if(isNaN(net))
        {
            net=0;
        }
        if(isNaN(totalac))
        {
            totalac=0;
        }
        $("#tdsAmount").html("( " +totaltds+ " <i aria-hidden='true' class='fa fa-inr'></i> ) || ");
        $("#acAmount").html("( " +totalac+ " <i aria-hidden='true' class='fa fa-inr'></i> ) || ");
        $("#netAmount").html(net+" <i aria-hidden='true' class='fa fa-inr'></i>"); 
    }
    HideLoading(LoadingClass);
    
  return rtn;
}, 'Insufficiant Balance');
