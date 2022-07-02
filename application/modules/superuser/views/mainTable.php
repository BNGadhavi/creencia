<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once 'head.php';
	include_once 'sidebar.php';
	include_once 'header.php';
?>	

<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/plugins/notifications/css/lobibox.min.css" rel="stylesheet" type="text/css">

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
	            	if(isset($searchBtn)){?>
	            		<button onclick="searchModel();" type="button" class="btn btn-dark waves-effect waves-light search"> <i class="fa fa-search"></i> <span>Search</span> </button>

	            	<?php
	            		include $modelPageName; 	
	            	}
	            	$loadpopup=false;
	            	if(isset($autoload)){
	            		$loadpopup=true;
	            	}

	            	if(isset($this->session->setMessageData))
					{
						$actionmsg=$this->session->setMessageData['actionmsg']; 
						$actionstatus=$this->session->setMessageData['actionstatus'];
						$this->session->unset_userdata('setMessageData');
					}
					
	            	if(isset($includePageData)){
	            		include 'tableExtraData.php';
	            	}
	            	?>

	              	<div class="table-responsive">
	              		<div id="replaceTable">
	              		<?php include 'tableStructure.php'?> 
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
	function  searchModel(){
		$("#searchmodel").modal('show');
	}
	var loadpopup = '<?php echo $loadpopup; ?>';
	if(loadpopup==true)
	{
		$(".search").click();
	}
	var deleteconfirmbox = true;
	var deleteconfirmtitle = 'Are You Sure?';
	var deleteconfirmtxt = 'You Want to Delete?';
	var deletebuttonsStyling = false;
	var deleteconfirmokclass = 'btn btn-light';
	var deleteconfirmcnclass = 'btn btn-light';

	var adminurl = '<?php echo $AdminUrl; ?>';
	$(document).ready(function(){


   $('#dateStart').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy', 
        
   });

   $('#dateEnd').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy', 
        
   });

		var url = document.URL
		var lastUrl = url.substr(url.lastIndexOf('/') + 1);
		//if(lastUrl == 'ActivationReport'){
			<?php if(isset($popup)) {
				?>
				var popup='<?php echo $popup; ?>';
				if(popup){
					searchModel();
				}
				<?php
			} ?>
		//}
		if(lastUrl=='MemberList'){
			/*$.ajax({
	            url:adminurl+'MemberDetail/MemberList1',
	            data:{},
	            type:'POST',
	            async: false,
	            success:function(result)
	            {

	            $("#replaceTable").html(result);
	               
	            }
	        });  	*/
		}
		

	});		


	var sumkey=JSON.parse('<?php echo json_encode($sumkey); ?>');
	var i=0;
	$.each(sumkey, function( index, value ) {
		$("."+index+'_sum').html(value);
		i=i+1;
		if(i == 1){
			var tmp="."+index+'_sum';
			//$(tmp).prev().html("Total");
		}
	});
	
	/*for ( var i = 0, l = array.length; i < l; i++ ) {
		
		var val=array[i];
		val="."+val;


		var sum=0;
		// $(val).each(function() {
		//     var currentElement = $(this);
		//     var value = currentElement.text();
		//     sum=parseInt(sum)+parseInt(value);
		    
		// });

		if(i==0)
		{		
			var tmp=val+'_sum';
			$(tmp).prev().html("Total");
		}
		$(val+'_sum').html(sum);

	}*/

</script>

<script type="text/javascript">
$(document).on("click",".proofmodel",function(){
	var imgname = $(this).attr('imgsrc');
	var imgid = $(this).attr('imgid');

	$("#imgShowText").html("");
	if(imgid>0){
		var imgType= $("#imgtxt"+imgid+'').attr('imgType');

		var imagText=$("#imgtxt"+imgid+'').val();
		var spiltText=imagText.split("@@@");
		var modifiedText='<h3>'+imgType+'</h3>';

		$.each( spiltText, function( key, value ) {
			modifiedText=modifiedText+value+"<br>";
		});
		$("#imgShowText").html(modifiedText);
		
	}

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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/custom/delete.js"></script>
