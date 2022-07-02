<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once 'head.php';
	include_once 'sidebar.php';
	include_once 'header.php';
?>	

<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/plugins/notifications/css/lobibox.min.css" rel="stylesheet" type="text/css">



<!--  <link href="<?php  echo $this->config->item('base_url');?>assets/css/datatables.min.css" rel="stylesheet" type="text/css"> -->
<style type="text/css">
#example
{
	font-family: 'Open Sans', sans-serif !important;
	font-size: 13px;
}
.search{
	float: right;
    margin: 10px 10px;
}
</style>
<div class="content-wrapper">

	<div class="container-fluid">

		<div class="row">

	        <div class="col-lg-12">

	          <div class="card">

	            <div class="card-header"><i class="fa fa-table"></i><?php echo $pageTitle; ?></div>

	            <div class="card-body">
	            	<div class="table-responsive">
	              		
	              		<table id="example" class="display table table-striped table-bordered table-hover table-full-width dataTable" cellspacing="0" width="100%">
				            <thead>
				                <tr>
				                    <!-- <th>No</th> -->
				                    <th>&nbsp</th>
				                    <th>Member ID</th>
				                    <th>Password</th>
				                    <th>Trans. Password</th>
				                    <th>Name</th>
				                    <th>SponsorInfo</th>
				                    <th>Side</th>
				                    <th>Entrydate</th>
				                    <th>ActiveDetail</th>
				                    <th>email</th>
				                    <th>MobileNo</th>
				                    <th>pincode</th>
				                </tr>
				            </thead>
				            <tbody>
				            </tbody>
				 
				            <tfoot>
				                <tr>
				                    <th>&nbsp</th>
				                    <th>Member ID</th>
				                    <th>Password</th>
				                    <th>Trans. Password</th>
				                    <th>Name</th>
				                    <th>SponsorInfo</th>
				                    <th>Side</th>
				                    <th>Entrydate</th>
				                    <th>ActiveDetail</th>
				                    <th>email</th>
				                    <th>MobileNo</th>
				                    <th>pincode</th>
				                </tr>
				            </tfoot>
				        </table>

	            	</div>

	            </div>

	          </div>

	        </div>

	    </div><!-- End Row-->

	</div>

</div>

<?php include_once 'footer.php'; ?>

<?php include_once 'js.php'; ?>
<?php //include_once 'datatable.php'; ?>
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

<!-- 
<script type="text/javascript" src="<?php  echo $this->config->item('base_url');?>assets/js/datatables.min.js"></script>  -->

<script type="text/javascript">
 
var table;
 
$(document).ready(function() {
 	var AdminUrl= '<?php echo $AdminUrl;?>';
    //datatables
     
    table = $('#example').DataTable({ 
 		
 		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": AdminUrl+'MemberDetail/MemberListAjax',
            "type": "POST"
        },
        dom: 'lBfrtip',
	   	/*buttons: [
	    	'excel', 'csv', 'pdf', 'copy'
	   	],*/

	   	buttons: [ 'copy', 'excel', 'pdf', 'print' ],
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
 
    });

    //table.buttons().container().appendTo( '#example_wrapper .col-md-6:eq(0)' );

      

      
 
});
</script>