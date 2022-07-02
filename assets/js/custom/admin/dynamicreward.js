/*function errorswal(msgtext, swaltype, swaltitle) {
    swal({
        title: swaltitle,
        text: msgtext,
        type: swaltype,
        timer: 4000,
        showConfirmButton: true,
        confirmButtonText: 'Close',
        confirmButtonClass: 'btn btn-danger',
        buttonsStyling: true,
    });
}*/
$(document).ready(function() {
    $("#"+formid).validate({
        rules: {
            datefrom : {
                required: true,
            },
            dateto : {
                required: true,
                checkdate:true,
            },
            'matchpair[]' : { required : true,digits:true,min:1, },
            'reqmatchpair[]' : { required : true,digits:true,min:1, },
            'reward[]' : { required : true, },
        }
    });
});

$.validator.addMethod("checkdate", function(value, element) {
    var rtnstatus=true;
    var datefrom = $('#datefrom').val();
    if(Date.parse(datefrom) >= Date.parse(value)){
       rtnstatus=false;
    }
    return rtnstatus;
}, "End date should not be less then the start date");

$("#add").click(function() {
    var optlen = $(document).find('.matchdiv').length;

    if(parseInt(optlen) >= parseInt(maxoptionindex)) {
        errorswal("You Can't Add More than " + maxoptionindex, 'error', 'Error');
    }
    else {
        var datahtml = dataclon.replace(/indexvalue/gi, optionindex);
        $(".addbtn").before(datahtml);
        optionindex++;
    }
});
$('body').on('click', '.remove', function() {
   var optlen = $(document).find('.matchdiv').length;
    if(parseInt(optlen) <= 1) {
        errorswal("Atleast one Data is Required.", 'error', 'Error');
    }
    else {
        var deleteid = $(this).attr('matchindex');
        $(document).find('#optindex'+deleteid+'').remove();
    }
});