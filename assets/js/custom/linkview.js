$( document ).ready(function() {
    setTimeout( function(){ 
    $("#waiting").hide(1000);
    $("#submit").show(1000);
    } , 10000);
});

function SaveLink(){
    var linkid=$("#userlinkid").val();
    
    $.ajax({
        url: member_url+"LinkList/SaveLink",
        async: false,
        type: "POST",
        data: "linkid="+linkid,
        success: function(msg)
        {
                var response = $.parseJSON(msg);
                var confirmtitle='';
                var confirmokclass='';
                var confirmoktxt = 'Close';
                var type='success';
                if(response.status){
                    rtnstatus = true;
                    confirmtitle='Success';
                    confirmokclass='btn btn-light';
                }
                else{
                    confirmtitle='Sorry!';
                    type="warning";
                    confirmokclass='btn btn-danger';
                }

                confirmtxt=response.msg;
                setTimeout( function(){ 
                window.top.close();
                } , 5000);

                swal({
                    title: confirmtitle,
                    text: confirmtxt,
                    type: type,
                    showConfirmButton: true,
                    buttonsStyling: false,
                    confirmButtonClass: confirmokclass,
                    confirmButtonText: confirmoktxt,
                    background: 'rgba(0, 0, 0, 0.96)'
                    }).then(function(){
                    window.top.close();
                });

        }
    });
  }