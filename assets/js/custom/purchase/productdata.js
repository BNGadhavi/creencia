function GetTotalCount(){
    $.ajax({
            url:PurchaseUrl+'FindCount',
            data:{},
            type:'POST',
            async: false,
            success:function(result)
            { 
             var response = $.parseJSON(result);  
              $("#cartcount").html(response.cartcount);  
              $("#TotalAmount").html(response.totaldp)
            }
        });
    getProductList();
}

function getProductList(){
    $("#cartdiv").html('');
    $.ajax({
            url:PurchaseUrl+'OrderProductList',
            data:{},
            type:'POST',
            async: false,
            success:function(result)
            { 
              $("#cartdiv").html(result);
            }
        });
}

$( document ).ready(function() {
    /*var currentLocation=$(location).attr('href');
    var getSearchingFlag = currentLocation.includes("Maincategory");
    if(getSearchingFlag){
        $("#searchIcon").css("display","block");
    }  
    else{
       $("#searchIcon").css("display","none"); 
    }
*/
    GetTotalCount();
});

/*$(window).bind("load", function() { 
     // insert your code here 
     GetTotalCount();
});*/


function GetSubcategoryProduct(id,type,append){
    
    //type = 0 All Product,1:subcategory

    var LoadingClass="#productsection";
    $("#loadingimg").show();
    var sortby=$("#sortby").val();
    var search=$("#search").val();
    if(id == ''){
        var id=$("#categoryid").val();
    }
    if(append){
        $("#productsection").html('');
        startLimit=0;
    }
    processing = false;
    $.ajax({
        url:PurchaseUrl+'SubCategoryProduct',
        data:{'id':id,'type':type,'startLimit':startLimit,'sortby':sortby,'search':search},
        type:'POST',
        async: false,
        success:function(result)
        {
            if(result.trim() == 'no'){
                processing = false;    
            }
            else{
                $("#productsection").append(result);
                processing = true;
                startLimit=parseInt(startLimit)+1;     
            }
            $("#search-popup").removeClass("popup-visible");
            //HideLoading(LoadingClass);
            $("#loadingimg").hide();
        }
    });

}
function AddToCart(productid,type,pqty=0){
    /*
    type 0 :Product List
    type 1 :Product Detail
    type 2 :Update Cart
    */
    var LoadingClass=".cart-details";

    if(type==0 || type==1){
        LoadingClass="#addtocart"+productid;
    }
    var qty=0;
    if(type== 1){
        qty=$("#qty"+productid+'').val();
    }
    else if(type==0){
        qty=1;
    }
    else{
        qty=pqty;
    }

    if(parseInt(qty) <= 0){
       cust_notification('error','top right','fa fa-times','Enter Proper Quantity'); 
    }
    else{

        ShowLoading(LoadingClass);
        $.ajax({
            url:PurchaseUrl+'AddProduct',
            data:{'productid':productid,'qty':qty,'type':type},
            type:'POST',
            async: false,
            success:function(result)
            {   
                var response = $.parseJSON(result);
                if(response.status){
                    cust_notification('success','top right','fa fa-check-circle-o',response.msg);
                    GetTotalCount();

                }
                else{
                    cust_notification('error','top right','fa fa-times',response.msg); 
                }
                
                HideLoading(LoadingClass);
            }
        });

        //HideLoading(LoadingClass);

    }


}    
function RemoveProduct(Detailid=0,type=0){
    var LoadingClass="#cart-table";
    ShowLoading(LoadingClass);
    $.ajax({
            url:PurchaseUrl+'RemoveProduct',
            data:{'Detailid':Detailid,'type':type},
            type:'POST',
            async: false,
            success:function(result)
            {   
                var response = $.parseJSON(result);
                if(response.status){
                    GetTotalCount();
                    if(parseInt(Detailid)==0){
                        window.location.reload();
                    }
                    else{
                        $("#producttr"+Detailid+'').html('');
                    }
                    cust_notification('success','top right','fa fa-check-circle-o',response.msg);     
                }
                else{
                    cust_notification('error','top right','fa fa-times',response.msg); 
                }
                
                HideLoading(LoadingClass);
            }
        });

}
function updateCart(){
    var changevalid = false;
      $('.cstmqty').each(function(index,item){
        var oldqty = parseInt($(this).attr('qty'));
        var newqty = parseInt($(this).val());
        if(oldqty == newqty) {

        }
        else {
          changevalid = true;
          AddToCart($(this).attr('pid'),2,newqty);
        }
      });

      if(changevalid) {
        window.location.reload();
      }
      else {
        window.location.reload();
        //cust_notification('error','top right','fa fa-times','No Changes Are Done In Cart'); 
      }
}




