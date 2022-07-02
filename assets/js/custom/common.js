 $(document).ready(function() {
    $('.select-box').select2();

    // Setup - add a text input to each footer cell
    if($("#example").length > 0) {
        $('#example tfoot th.search_txt').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" class="tblfootcol" placeholder="Search '+title+'" />' );
        } );
        table = $("#example").DataTable();
        table.destroy();
        // Apply the search
        table.columns().every( function () {
            var that = this;
            $( 'input.tblfootcol', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that.search( this.value ).draw();
                }
            });
        });
    }
});
function ShowLoading(ClassName)
{
	 $(ClassName).showLoading();
}
function HideLoading(ClassName)
{
	 $(ClassName).hideLoading();
}
function errorswal(msgtext, swaltype, swaltitle) {
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
}
function infoswal(msgtext, swaltype, swaltitle) {
    swal({
        title: swaltitle,
        text: msgtext,
        type: swaltype,
        timer: 4000,
        showConfirmButton: true,
        confirmButtonText: 'Close',
        confirmButtonClass: 'btn btn-info',
        buttonsStyling: true,
    });
}