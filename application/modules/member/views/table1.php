<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

	include_once 'head.php';

	include_once 'sidebar.php';

	include_once 'header.php';

?>	

<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">

<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">

<div class="content-wrapper">

	<div class="container-fluid">

		<div class="row">

	        <div class="col-lg-12">

	          <div class="card">

	            <div class="card-header"><i class="fa fa-table"></i> Data Exporting1</div>

	            <div class="card-body">

	              	<div class="table-responsive">

	              		<?php print_r($test);?>

		              	<?php include 'table_include.php';?>

	            	</div>

	            </div>

	          </div>

	        </div>

	    </div><!-- End Row-->

	</div>

</div>

<?php include_once 'footer.php'; ?>

<?php include_once 'js.php'; ?>

<?php include_once 'datatable.php'; ?>