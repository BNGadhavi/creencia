<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

	include_once 'head.php';

	include_once 'sidebar.php';

	include_once 'header.php';

?>	


<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">

<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">

<style type="text/css">
#example
{
	font-family: 'Open Sans', sans-serif !important;
	font-size: 13px;
}
	
</style>
<div class="content-wrapper">

	<div class="container-fluid">

		<div class="row">

	        <div class="col-lg-12">

	          <div class="card">

	            <div class="card-header"><i class="fa fa-table"></i>Direct Associate</div>

	            <div class="card-body">

	              	<div class="table-responsive">

	              		<?php
	              		$data=$MemberSponsorList['data'];
	              		
	              		?>
	              		 
		              	<?php include 'tableStructure.php'?> 
		              	<?php 
		              	/*$thead="<table id='example' class='table table-bordered'><thead><tr><th>SR</th>";
		              	$tbody="<tbody>";
						$tfoot="<tfoot><tr><th>SR</th>";			              	
		              	$counter=0;


		              	for($i=0;$i<count($data);$i++){

		       		     $counter++;
		              	 $tbody=$tbody."<tr><td>".$counter."</td>";
		              	 

			              	foreach ($data[$i] as  $key => $value) {
			              			
			              			//print_r($value);
				              		if($counter == 1){
				              			$thead=$thead."<th class='search_txt'>". ucwords($key) ."</th>";
				              			$tfoot=$tfoot."<th class='search_txt'>". ucwords($key) ."</th>";
				              		}

				              		if($key == "EntryDate")
				              		$value=ConvertDate($value);		

				              	   $tbody=$tbody."<td>". $value ."</td>";	

			              	}

			              $tbody=$tbody."</tr>";
			            }

			            $thead=$thead."</tr></thead>";
			            $tbody=$tbody."</tbody>";
			            $tfoot=$tfoot."</tfoot></table>";

			            echo $thead.$tbody.$tfoot;*/
		              	?>
		              	

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
