

<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/js/jszip.min.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/js/pdfmake.min.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/js/vfs_fonts.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/js/buttons.html5.min.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/js/buttons.print.min.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/notifications/js/notifications.min.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/notifications/js/notification-custom-script.js"></script>

<script>

     $(document).ready(function() {

      //Default data table

       $('#default-datatable').DataTable();





       var table = $('#example').DataTable( {

        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

        buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ]

      } );

 

     table.buttons().container()

        .appendTo( '#example_wrapper .col-md-6:eq(0)' );

      

      } );



</script>