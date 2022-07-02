<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

	include_once 'head.php';

	include_once 'sidebar.php';

	include_once 'header.php';

?>	

<div class="content-wrapper">

	<div class="container-fluid">
		<div class="row pt-2 pb-2">
			<div class="col-sm-9">
				<h4 class="page-title">Dashboard</h4>
			</div>
		</div>

		<div class="card bg-transparent mt-3 shadow-none border border-light">
		    <div class="card-content">
				<div class="row">
					<?php
						foreach ($topwidget as $key => $value) {
							$keyarr = explode('@@@', $key);
							$target='';
							if(isset($keyarr[4])){
								$link=$AdminUrl.$keyarr[4];
								$target="target='_blank'";
								$target="";
							}
							?>
							<div class="col-12 col-lg-3 col-xl-3">
							    <div class="card bg-pattern-dark">
							    	<a href="<?php echo $link;?>" <?php echo $target?>>
							            <div class="card-body">
								            <div class="media">
												<div class="media-body text-left">
									            <h4 class="text-white"><?php echo $value; ?></h4>
									            <span class="text-white"><?php echo $keyarr[0]; ?></span>
									            </div>
									            <div class="align-self-center w-circle-icon rounded bg-contrast">
								                <i class="<?php echo $keyarr[2]; ?> text-white"></i>
								            </div>
								            </div>
							            </div>
						        	</a>
					          	</div>
							</div>		
							<?php
						}
					?>
				</div>
			</div>
	  	</div>
	</div>

</div>

<?php include_once 'footer.php'; ?>

<?php include_once 'js.php'; ?>