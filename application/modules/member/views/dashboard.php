<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once 'head.php';
	include_once 'sidebar.php';
	include_once 'header.php';
?>
<style type="text/css">
	.modal-content {
    	background: black;
	}
  #timer{
    font-family: sans-serif;
    color: #fff;
    display: inline-block;
    font-weight: 100;
    text-align: center;
    font-size: 24px;
    margin-top: 10px;
  }
  #timer > div{
    padding: 5px;
    border-radius: 3px;
    /*background: #5018f1;*/
    display: inline-block;
  }

  #timer div > span{
    padding: 3px;
    border-radius: 3px;
    /*background: #6d7cff;*/
    display: inline-block;
  }

  .smalltext{
    padding-top: 3px;
    font-size: 14px;
  }
</style>
<link href="<?php echo base_url(); ?>assets/css/custom/widget.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<div class="content-wrapper">

	<div class="container-fluid">

		<div class="row pt-2 pb-2">
			<div class="col-sm-9">
				<h4 class="page-title">Dashboard</h4>
			</div>
		</div>
		<?php /*<div class="row">
			<div class="col-lg-12">
	          	<div class="card">
	            	<div class="card-header text-white bg-dark">Step Of Activation</div>
            		<div class="card-body">
            			<div class="col-lg-12" style="float: left">
	          				<div class="col-lg-6" style="float: left">
	          					Step - 1  Active Your ID <?php if($activestatus) { ?> <i class="fa fa-check-square-o" style="color: green;"> <?php } else { ?> <i class="fa fa-close" style="color: red;"> <?php } ?></i> 
	          				</div>
	          				<div class="col-lg-6" style="float: left">
	          					Step - 2  Fill All The Detail In Member Detail <?php if($profiledetail) { ?> <i class="fa fa-check-square-o" style="color: green;"> <?php } else { ?> <i class="fa fa-close" style="color: red;"> <?php } ?></i> 
	          				</div>
	          				<div class="col-lg-6" style="float: left">
	          					Step - 3  Select Joining Product <?php if($productselect) { ?> <i class="fa fa-check-square-o" style="color: green;"> <?php } else { ?> <i class="fa fa-close" style="color: red;"> <?php } ?></i> 
	          				</div>
	          				<div class="col-lg-6" style="float: left">
	          					Step - 4  Confirm Product Dispatch <?php if($dispatch) { ?> <i class="fa fa-check-square-o" style="color: green;"> <?php } else { ?> <i class="fa fa-close" style="color: red;"> <?php } ?></i> 
	          				</div>
          				</div>
          			
          				<div class="col-lg-12" style="float: left;margin-top: 21px;">
	          				<div class="col-lg-12" style="float: left;margin-bottom: 15px;"><i class="fa fa-star"></i> Upload KYC Document</div>

	          				<div class="col-lg-6" style="float: left">
	          					KYC - 1  Pancard <?php if($panstatus) { ?> <i class="fa fa-check-square-o" style="color: green;"> <?php } else { ?> <i class="fa fa-close" style="color: red;"> <?php } ?></i>
	          				</div>

	          				<div class="col-lg-6" style="float: left">
	          					KYC - 2  Bankdetail <?php if($bankstatus) { ?> <i class="fa fa-check-square-o" style="color: green;"> <?php } else { ?> <i class="fa fa-close" style="color: red;"> <?php } ?></i>
	          				</div>
	          			</div>
	          		</div>
	          	</div>
	        </div>
	        
	        <div class="col-lg-12">
	            <div class="card">
		            <div class="card-body"> 
		                <ul class="nav nav-tabs nav-tabs-primary">
		                  <li class="nav-item">
		                    <a class="nav-link active" data-toggle="tab" href="#tabe-1"><i class="icon-home"></i> <span class="hidden-xs">Referel Link</span></a>
		                  </li>
		                  <li class="nav-item ">
		                    <a class="nav-link" data-toggle="tab" href="#tabe-2"><i class="icon-user"></i> <span class="hidden-xs">Left Side Referel Link</span></a>
		                  </li>
		                  <li class="nav-item ">
		                    <a class="nav-link" data-toggle="tab" href="#tabe-3"><i class="icon-user"></i> <span class="hidden-xs">Right Side Referel Link</span></a>
		                  </li>
		                </ul>

		                <!-- Tab panes -->
		                <div class="tab-content">
		                  <div id="tabe-1" class="container tab-pane active">
		                    <a href='<?php echo base_url()."register/index/".$logged_insess['username']; ?>' target="_blank"><?php echo base_url()."register/index/".$logged_insess['username']; ?></a>
		                  </div>
		                  <div id="tabe-2" class="container tab-pane fade ">
		                    <a href='<?php echo base_url()."register/index/".$logged_insess['username']."/0"; ?>' target="_blank"><?php echo base_url()."register/index/".$logged_insess['username']."/0"; ?></a>
		                  </div>
		                  <div id="tabe-3" class="container tab-pane fade ">
		                    <a href='<?php echo base_url()."register/index/".$logged_insess['username']."/2"; ?>' target="_blank"><?php echo base_url()."register/index/".$logged_insess['username']."/2"; ?></a>
		                  </div>
		                  
		                </div>
		            </div>

		            
	            </div>

	        </div>
        </div> */

        /*if($pstatus)
        {
        ?>
        <?php if($profile->deliverflag=='0'){?>
			<div class="demo-checkbox">
		    	<input type="checkbox" id="termscond" name="termscond" class="filled-in chk-col-primary" required="">
		   		<label for="termscond">I have received the products and I agree to abide by terms and conditions of Finedwise</label>
		  	</div>
	   <?php } } */?>
	   <?php
	   $st=$profile->Package;
	   if($st!='Inactive')
	   {
	   ?>
	   			<div class="row pt-2 pb-2">
						<div class="col-md-12 col-xs-12">
                <div class="row">
                    <div class="col-md-3 col-xs-12">
                        <p style="text-align: right; padding: 4px 10px; color: #ffffff; background: #3fb1d9; border-top-left-radius: 60px;">
                            Referral Link :
                        </p>
                    </div>
                    <div class="col-md-9 col-xs-12">

                    	<div class="input-group mb-3">
						  	<div class="input-group-prepend">
								<button class="btn btn-outline-primary" type="button"><a href="<?php echo base_url()."register/index/".$logged_insess['username']; ?>" class="newentrya" target="_blank">New Registration</a></button>
						  	</div>
						  	<input type="text" class="form-control" id="copyrefrral" style="background-color: rgb(255, 255, 255); color: #525252;" autocomplete="off" readonly value="<?php echo base_url()."register/index/".$logged_insess['username']; ?>">
						  	<div class="input-group-append">
								<button class="btn btn-outline-primary" id="copybtn" type="button">Copy</button>
						  	</div>
						</div>
                    </div>
                </div>
            </div>
		</div>
		
		<?php
		}
		/*
		?>
	   <div class="col-lg-12">
	        <div class="card">
	            <div class="card-body"> 
	                <ul class="nav nav-tabs nav-tabs-primary">
	                  <li class="nav-item">
	                    <a class="nav-link active" data-toggle="tab" href="#tabe-1"><i class="icon-home"></i> <span class="hidden-xs">Referel Link</span></a>
	                  </li>
	                  <li class="nav-item hide-div">
	                    <a class="nav-link" data-toggle="tab" href="#tabe-2"><i class="icon-user"></i> <span class="hidden-xs">Left Side Referel Link</span></a>
	                  </li>
	                  <li class="nav-item hide-div">
	                    <a class="nav-link" data-toggle="tab" href="#tabe-3"><i class="icon-user"></i> <span class="hidden-xs">Right Side Referel Link</span></a>
	                  </li>
	                </ul>

	                <!-- Tab panes -->
	                <div class="tab-content">
	                  <div id="tabe-1" class="container tab-pane active">
	                    <a href='<?php echo base_url()."register/index/".$logged_insess['username']; ?>' target="_blank"><?php echo base_url()."register/index/".$logged_insess['username']; ?></a>
	                  </div>
	                  <div id="tabe-2" class="container tab-pane fade ">
	                    <a href='<?php echo base_url()."register/index/".$logged_insess['username']."/0"; ?>' target="_blank"><?php echo base_url()."register/index/".$logged_insess['username']."/0"; ?></a>
	                  </div>
	                  <div id="tabe-3" class="container tab-pane fade ">
	                    <a href='<?php echo base_url()."register/index/".$logged_insess['username']."/2"; ?>' target="_blank"><?php echo base_url()."register/index/".$logged_insess['username']."/2"; ?></a>
	                  </div>
	                  
	                </div>
	            </div>
	        </div>
	    </div>
	    <?php
		*/
	   $linkas=$member_url."WalletRequest";
		?>
		<div class="card bg-transparent mt-3 shadow-none border border-light">
		    <div class="card-content">
				<div class="row">
					<?php
						foreach ($topwidget as $key => $value) {
							$keyarr = explode('@@@', $key);
							$target='';
							if(isset($keyarr[4])){
								$link=$member_url.$keyarr[4];
								$target="target='_blank'";
							}
							?>
							<div class="col-lg-3">
								<div class="card border-<?php echo $keyarr[5]; ?> iconflip border-left-sm">
								<?php if(isset($keyarr[4])){ ?>
									<a href="<?php echo $link;?>" <?php echo $target?>>
								<?php }?>			
								<div class="card-body">
									<div class="media">
										<div class="media-body text-left">
											<h4 class="text-<?php echo $keyarr[5]; ?> textzoomin"><?php echo $value; ?></h4>
											<span class="textzoomout" style="color:black;"><?php echo $keyarr[0]; ?></span>
										</div>
										<div class="align-self-center w-circle-icon rounded-circle gradient-<?php echo $keyarr[3]; ?>">
							      	<i class="<?php echo $keyarr[2]; ?> text-white"></i>
							      </div>
									</div>
								</div>
								</div>
								<?php if(isset($keyarr[4])){ ?>
									</a>
								<?php }?>
							</div>		
							<?php
						}
					?>
				</div>
			</div>
	  	</div>
	  	<!-- <?php
				$activestatus=$profile->activestatus;
				$purchasestatus=$profile->purchasestatus;
				$lastdate=$profile->lastdate;
				if($activestatus=='1')
				{
	      ?>
			  	<div class="col-xl-4 col-md-4">
			        <div class="row">
			            <div class="col-xl-12 col-md-12">
			                <div class="card card-icon text-white gradient-knight">
			                  <div class="row no-gutters">
			                      <div class="col">
			                        <div class="card-body">
			                          <div><strong>Repurchase Time Left</strong></div>
			                          <div class="list-group list-group-flush small">
			                              <div id="timer">
			                                <div><span class="days"></span><div class="smalltext">Days</div></div>
			                                <div><span class="hours"></span><div class="smalltext">Hours</div></div>
			                                <div><span class="minutes"></span><div class="smalltext">Minutes</div></div>
			                                <div><span class="seconds"></span><div class="smalltext">Seconds</div></div>
			                              </div>
			                          </div>
			                        </div>
			                      </div>
			                  </div>
			                </div>
			            </div>
			        </div>
		      </div>
      	<?php
      	}
      	?> -->
	  		
	  	<div class="row">
		  	<div class="col-lg-4">
	            <div class="profile-card-3">
		            <div class="card">
						<div class="user-fullimage text-center">
						    <img src="<?php echo base_url(); ?>assets/images/Profile/<?php echo $ProfilePictureImage; ?>" data-toggle="tooltip" id="profilepic" data-placement="bottom" title="" data-original-title="Click Here to Change Profile Picture" alt="user avatar" class="card-img-top cursor" style="width: 50%;height: 60%;">
						    <div class="details hide-div">
						      <h5 class="mb-1 text-white ml-3">Mark Jhonsan</h5>
							  <h6 class="text-white ml-3">Senior Designer</h6>
							</div>
						</div>

						<form action="<?php echo $member_url; ?>Dashboard/ProfileSubmit" id="ProfileChange" class="hide-div" method="POST" enctype="multipart/form-data">
							<input type="file" name="profile" id="profile">
							<input type="submit" name="profilesubmit" id="profilesubmit">
						</form>

						<div class="card-body text-center">
							<ul class="list-group list-group-flush">
								<li class="list-group-item"><b>Profile Detail</b></li>
								<li class="list-group-item hide-div">
									<div class="media-body " data-toggle="modal" data-target="#icard" >
			                                <b>Click Here </b>
			                                <small>ID-Card</small>
		                            </div>
	                        	</li>
								<li class="list-group-item"><b>UserName</b> : <?php echo $profile->username; ?></li>
								<li class="list-group-item"><b>Name</b> : <?php echo $profile->fullname; ?></li>
								<?php /*	
								<li class="list-group-item"><b>Leadership Status</b> : <?php echo $profile->leadership; ?></li>
								*/?>
								<li class="list-group-item"><b>Sponsor</b> : <?php echo $profile->spon; ?></li>
								<li class="list-group-item"><b>Mobile</b> : <?php echo $profile->mobile; ?></li>
								<li class="list-group-item"><b>Package Name</b> : <?php echo $profile->Package; ?></li>
								<li class="list-group-item"><b>Joining Date</b> : <?php echo ConvertDate($profile->entrydate); ?></li>
								<li class="list-group-item"><b>Activation Date</b> : <?php $acdate=$profile->activedate; if($acdate!='0000-00-00 00:00:00'){ echo $acdate; } else { echo "Inactive"; } ?> </li>
							  </ul>
						</div>
		            </div>
				</div>
	        </div>
	       
	        <div class="col-lg-8">
	        	<div class="row">
	        		<?php foreach ($sidewidget as $key => $value) {
	        			$keyarr = explode('@@@', $key);
	        			if(isset($keyarr[4])){
							$link=$member_url.$keyarr[4];
							$target="target='_blank'";
						}
	        			?>
	        			<div class="col-lg-6">
				        	<div class="card iconflip gradient-<?php echo $keyarr[3]; ?>">
				        		<?php if(isset($keyarr[4])){?>
				        			<a href="<?php echo $link;?>" <?php echo $target?>>
				        		<?php }?>		
					            <div class="card-body">
					                <div class="media">
							            <div class="media-body text-left">
							            	<h4 class="text-white"><?php echo $value; ?></h4>
							                <span class="text-white"><?php echo $keyarr[0]; ?></span>
							            </div>
										<div class="align-self-center w-circle-icon rounded gradient-<?php echo $keyarr[3]; ?>">
							                <i class="<?php echo $keyarr[2]; ?> text-white"></i>
							            </div>
					            	</div>
					            </div>
					            <?php if(isset($keyarr[4])){?>
					        		</a>
					        	<?php }?>
					        </div>
					    </div>
	        			<?php
	        		} ?>
			    </div>
	        </div>
	    </div>
	</div>
</div>
<?php include_once 'footer.php'; ?>

<?php include_once 'js.php'; ?>
<script type="text/javascript">
	
	var member_url= '<?php echo $member_url;?>';
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="<?php  echo $this->config->item('base_url');?>assets/js/custom/dashboard.js"></script>
<script type="text/javascript">
$("#copybtn").click(function() {
	copyid = "copyrefrral";
	const copyText = document.getElementById(copyid);
	copyText.select();
	document.execCommand('copy');
});
$("#copybtns").click(function() {
	copyid = "copyrefrrals";
	const copyText = document.getElementById(copyid);
	copyText.select();
	document.execCommand('copy');
});
</script>