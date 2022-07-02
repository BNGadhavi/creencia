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

	            	<?php 
	            	if(isset($searchBtn)) {
	            		?>
	            		<button onclick="searchModel();" type="button" class="btn btn-dark waves-effect waves-light search"> <i class="fa fa-search"></i> <span>Search</span> </button>
	            		<?php
	            		include $modelPageName; 	
	            	}
	            	?>

	            	<?php 
	            	if(isset($this->session->setMessageData))
					{
						//print_r($this->session->setMessageData);

						$actionmsg=$this->session->setMessageData['actionmsg']; 
						$actionstatus=$this->session->setMessageData['actionstatus'];

						$this->session->unset_userdata('setMessageData');
					} 
					?>
					<?Php 
	            	if(isset($includePageData)){
	            		include 'tableExtraData.php';
	            	}
	            	?>
	              	<div class="table-responsive">
	              		<div id="replaceTable">
	              		<?php include 'tableStructure.php'; ?> 
		              	</div>
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

<script type="text/javascript" src="<?php  echo $this->config->item('base_url');?>assets/js/bootstrap-datepicker.min.js"></script>

<script type="text/javascript">
	var sumkey=JSON.parse('<?php echo json_encode($sumkey); ?>');
	var i=0;
	$.each(sumkey, function( index, value ) {
		$("."+index+'_sum').html(value);
		i=i+1;
		if(i == 1){
			var tmp="."+index+'_sum';
			$(tmp).prev().html("Total");
		}
	});
</script>

<script type="text/javascript">

function  searchModel(){
	$("#searchmodel").modal('show');
}

$('#dateStart').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy',  
});

$('#dateEnd').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy',    
});

$(document).on("click",".proofmodel",function(){
	var imgname = $(this).attr('imgsrc');
	$("#imagedisplay").attr('src',imgname);
	$('#primarymodal').modal('toggle');
});

<?php if(isset($actionmsg)){ ?>
$(document).ready(function(){
	var msg='<?php echo $actionmsg?>';
	var status='<?php echo $actionstatus?>';
	if(status == 1){
		success_noti(msg);
	}
	else{
		error_noti(msg);
	}
}); 
<?php }?>
</script>