<?php 
$imageUrl=$this->config->item('image_url');
?>
<!DOCTYPE html>
<html lang="en" style="background-image: url(<?php echo $imageUrl; ?>bg-01.jpg);">

<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title><?php echo GetCompanyName();?></title>
  <link rel="icon" href="<?php echo base_url(); ?>assets/web/images/favicon.png" type="image/x-icon">
  <!--favicon-->
  <!-- Bootstrap core CSS-->
  <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="<?php echo base_url(); ?>assets/css/animate.css" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="<?php echo base_url(); ?>assets/css/icons.css" rel="stylesheet" type="text/css"/>
  <!-- Custom Style-->
  <link href="<?php echo base_url(); ?>assets/css/app-style.css" rel="stylesheet"/>
  <link href="<?php echo base_url(); ?>assets/css/select2.min.css" rel="stylesheet"/>
  <link href="<?php echo base_url(); ?>assets/css/showLoading.css" rel="stylesheet"/>
  <link href="<?php echo base_url(); ?>assets/css/sweetalert2.min.css" rel="stylesheet"/>
  <link href="<?php echo base_url(); ?>assets/css/custom/common.css" rel="stylesheet"/>
  
</head>
<style type="text/css">
	#myVideo {
    position: fixed;
    right: 0;
    bottom: 0;
    min-width: 100%;
    min-height: 100%;
}
audio, canvas, progress, video {
    display: inline-block;
    vertical-align: baseline;
}
</style>
<body>
<!-- Start wrapper-->
 <div id="wrapper" style="background-image: url(<?php echo $imageUrl; ?>bg-01.jpg);">
<video autoplay="" muted="" loop="" id="myVideo">
  <source src="<?php echo base_url(); ?>assets/web/images/login.mp4" type="video/mp4">
</video>
	   <div class="card-authentication2 mx-auto my-3">
	    <div class="card-group">
	    	<div class="card mb-0">
	    	   <div class="bg-signup2"></div>
	    		<div class="card-img-overlay rounded-left my-5">
                 <h2 class="text-white">Welcome to</h2>
                 <h1 class="text-white"><?php echo GetCompanyName();?></h1>
                 <p class="card-text text-white pt-3">Please fill this details to enroll into our exclusive business plan</p>
             </div>
	    	</div>
	    	<?php 
	    	$pinno='';
	    	if(isset($_GET['pinno'])){
	    		$pinno=$_GET['pinno'];	
	    	}
	    	
	    	?>
	    	<div class="card mb-0">
	    		<div class="card-body">
	    			<div class="card-content p-3">
	    				<div class="text-center">
					 		<img src="<?php echo base_url(); ?>assets/web/images/logo.png" style="max-width: 100%;">
					 	</div>
					 <div class="card-title text-uppercase text-center py-3">Sign Up</div>
					    <form method="post" action="#" id="registerForm">
					
					<?php if($pinFlag== '1'){?>
						  
						  <div class="form-group">
						   <div class="position-relative has-icon-left">
							  <label for="pinnumber" class="sr-only">Pin Number</label>
							  <input type="text" id="pinno" class="form-control" placeholder="Enter Pin Number" name="pinno" required="required" value="<?php echo $pinno;?>">
							  <div class="form-control-position">
								  <i class="fa fa-key"></i>
							  </div>
						   </div>
						  </div>
						  
					<?php }
					if($sponsorId=='')
					{
						$sponsorId="";
					}
					
					?>	 
						  <div class="form-group">
						   <div class="position-relative has-icon-left">
							  <label for="sponsorid" class="sr-only">Sponsor Id</label>
							  <input type="text" id="sponsorId" name="sponsorId" value="<?php echo $sponsorId; ?>" class="form-control" placeholder="Enter Sponsorid *" required="required">
							  <div class="form-control-position">
								  <i class="fa fa-user"></i>
							  </div>
						   </div>
						  </div>
						   <div style="text-align: center;display: none;" id="sponsorDiv">
						   		<label id="sponsorName"></label>
						   </div>	

						 
						  <div class="form-group">
						   <div class="position-relative has-icon-left">
							  <label for="sponsorid" class="sr-only">Side</label>
							  	 <div class="form-check" style="display: inline-block;">
                    <input class="form-check-input" checked="checked" type="radio" name="side" id="sideLeft" value="Left" required="required">
                    <label class="form-check-label" for="sideLeft">
                    Left
                    </label>
                  </div>
                 
                  <div class="form-check"  style="display: inline-block;">
                    <input class="form-check-input" type="radio" name="side" id="sideRight" value="Right"  <?php if($side == 2) { echo "checked"; } ?> required="required">
                    <label class="form-check-label" for="sideRight">
                   Right
                    </label>
                  </div>

						   </div>
						   <div class="side-div"></div>
						  </div>
						
						 
						  <div class="form-group">
						   <div class="position-relative has-icon-left">
							  <label for="sponsorid" class="sr-only">Full Name</label>
							  
							  <input type="text" id="fullName" name="fullName" class="form-control" placeholder="Enter Full Name *" required="required">
							  <div class="form-control-position">
								  <i class="fa fa-user"></i>
							  </div>
						   </div>
						  </div>

						  <div class="form-group hide-div">
						   <div class="position-relative has-icon-left">
							  <label for="username" class="sr-only">Username</label>
							  <input type="text" id="userName" name="userName" class="form-control" placeholder="Enter User Name" required="required">
							  <div class="form-control-position">
								  <i class="fa fa-user"></i>
							  </div>
						   </div>
						  </div>

						  <div class="form-group">
						   <div class="position-relative has-icon-left">
							  <label for="Password" class="sr-only">Password</label>
							  <input type="password" id="password" name="password" autocomplete="new-password" class="form-control" placeholder="Password *" required="required">
							  <div class="form-control-position">
								  <i class="fa fa-lock"></i>
							  </div>
						   </div>
						  </div>

						  <div class="form-group">
						   <div class="position-relative has-icon-left">
							  <label for="RetryPassword" class="sr-only">Confirm Password</label>
							  <input type="password" id="password2" name="password2" class="form-control" placeholder="Re-enter Password *" required="required">
							  <div class="form-control-position">
								  <i class="fa fa-lock"></i>
							  </div>
						   </div>
						  </div>

						  <div class="form-group">
						   <div class="position-relative has-icon-left">
							  <label for="Password" class="sr-only">Transaction Password</label>
							  <input type="password" id="transactionPassword" name="transactionPassword" autocomplete="new-password" class="form-control" placeholder="Transaction Password *" required="required">
							  <div class="form-control-position">
								  <i class="fa fa-lock"></i>
							  </div>
						   </div>
						  </div>

						  <div class="form-group">
						   <div class="position-relative has-icon-left">
							  <label for="RetryPassword" class="sr-only">Retry Transaction Password</label>
							  <input type="password" id="transactionPassword2" name="transactionPassword2" class="form-control" placeholder="Re-enter Transaction Password *" required="required">
							  <div class="form-control-position">
								  <i class="fa fa-lock"></i>
							  </div>
						   </div>
						  </div>
						
						
						 <div class="form-group">
						   <div class="position-relative has-icon-left">
							  <label for="sponsorid" class="sr-only">Mobile</label>
							  <input type="text" id="mobile" name="mobile" class="form-control" placeholder="Enter Mobile *" required="required">
							  <div class="form-control-position">
								  <i class="fa fa-phone"></i>
							  </div>
						   </div>
						  </div>	

						  <div class="form-group hide-div">
						   <div class="position-relative has-icon-left">
							  <label for="sponsorid" class="sr-only">WhatsApp</label>
							  <input type="text" id="whatsApp" name="whatsApp" class="form-control" placeholder="Enter WhatsApp Number">
							  <div class="form-control-position">
								  <i class="fa fa-mobile"></i>
							  </div>
						   </div>
						  </div>

						  <div class="form-group">
						   <div class="position-relative has-icon-left">
							  <label for="sponsorid" class="sr-only">Email Address</label>
							  <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email Address *">
							  <div class="form-control-position">
								  <i class="fa fa-envelope"></i>
							  </div>
						   </div>
						  </div>

						  <div class="form-group hide-div">
						   <div class="position-relative has-icon-left">
							  <label for="sponsorid" class="sr-only">Pan Number</label>
							  <input type="text" id="pannumber" name="pannumber" class="form-control" placeholder="Enter Pan Number">
							  <div class="form-control-position">
								  <i class="fa fa-list-ol"></i>
							  </div>
						   </div>
						  </div>

						   <div class="form-group">
						   <div class="position-relative has-icon-left">
							  <label for="sponsorid" class="sr-only">Address</label>
							  <input type="text" id="address" name="address" required="" class="form-control" placeholder="Enter Full Address">
							  <div class="form-control-position">
								  <i class="fa fa-address-book"></i>
							  </div>
						   </div>
						  </div>	

						  <div class="form-group">
						   <div class="position-relative has-icon-left">
									<select name="country" id="country" required="" class="form-control select-box">
										<option selected value="" disabled="disabled">Select Country</option>
											<?php 
			                      foreach ($countrylist as $rs) {?>
			                          <option value="<?php echo $rs['id'];?>"><?php echo $rs['name'];?></option>
			                      <?php }
			                     ?>
									</select>
						   </div>
						   <div class="country-div"></div>
						  </div>
						  

						  <div class="form-group">
						   <div class="position-relative has-icon-left">
									<select name="state" id="state" required="" class="form-control select-box">
										<option selected value="" disabled="disabled">Select State</option>
									</select>
						   </div>
						   <div class="state-div"></div>
						  </div>

						  <div class="form-group ">
						   <div class="position-relative has-icon-left">
							<select name="city" id="city" required="" class="form-control select-box">
								<option selected value="" disabled="disabled">Select City</option>
							</select>
						   </div>
						   <div class="city-div"></div>
						  </div>

						  <div class="form-group hide-div">
						   <div class="position-relative has-icon-left">
							  <label for="sponsorid" class="sr-only">Pincode</label>
							  <input type="text" id="pincode" name="pincode" class="form-control" placeholder="Enter Pincode" required="required">
							  <div class="form-control-position">
								  <i class="fa fa-map-marker"></i>
							  </div>
						   </div>
						  </div>

						  <div class="form-group hide-div">
						   <div class="position-relative has-icon-left">
							  <label for="sponsorid" class="sr-only">Nominee Name</label>
							  <input type="text" id="nomineeName" required="" name="nomineeName" class="form-control" placeholder="Enter Nominee Name" required="required">
							  <div class="form-control-position">
								  <i class="fa fa-user"></i>
							  </div>
						   </div>
						  </div>

						  <div class="form-group hide-div">
						   <div class="position-relative has-icon-left">
							<select name="relNominee" required="" id="relNominee" class="form-control select-box">
								<option selected value="" disabled="disabled">Select Relation With Nominee</option>
								<option value="son">Son</option>
								<option value="brother">Brother</option>
								<option value="sister">Sister</option>
								<option value="father">Father</option>
								<option value="wife">Wife</option>
								<option value="mother">Mother</option>
								<option value="daughter">Daughter</option>
								<option value="brother in law">Brother In Law</option>
								<option value="brother in law">Father In Law</option>
								<option value="husband">Husband</option>
							</select>
						   </div>
						   <div class="relNominee-div"></div>
						  </div>


						  <div class="form-group mb-0">
						   <div class="demo-checkbox">
			                <input type="checkbox" id="termscond" name="termscond" class="filled-in chk-col-primary" required="" />
			                <label for="termscond">I agree to all the Terms and Condition*</label>
			                <div class="termscond-div"></div>
						  </div>
						 </div>

						
						 <button type="submit" class="btn btn-outline-primary btn-block waves-effect waves-light">Sign Up</button>
						 <div class="text-center pt-3">
						 <hr>
						 <p class="text-muted">Already have an account? <a href="<?php echo base_url(); ?>login"> Login</a></p>
						 <p class="text-muted">Go to Website <a href="<?php echo base_url();?>"> Click Here</a></p>
						 </div>
					</form>
				 </div>
				</div>
	    	</div>
	     </div>
	    </div>
    
     <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->
	</div><!--wrapper-->
	
  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
 
</body>

</html>
<script type="text/javascript">
	var base_url='<?php echo base_url();?>';
</script>
<script src="<?php echo base_url(); ?>assets/js/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/validateadditional.js"></script>
<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.showLoading.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/custom/common.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/custom/register.js"></script>
