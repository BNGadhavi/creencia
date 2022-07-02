<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title><?php echo GetCompanyName();?></title>
  <!--favicon-->
  <link rel="icon" href="<?php echo base_url(); ?>assets/web/images/favicon.png" type="image/x-icon">
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
<?php 
$imageUrl=$this->config->item('image_url');
?>
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
<body style="background-image: url(<?php echo $imageUrl; ?>bg-01.jpg); background-size: cover;">
<video autoplay="" muted="" loop="" id="myVideo">
  <source src="<?php echo base_url(); ?>assets/web/images/login.mp4" type="video/mp4">
</video>
 <!-- Start wrapper-->
 <div id="wrapper" >
	   <div class="card-authentication2 mx-auto my-5">
	    <div class="card-group">
	    	<!-- <div class="card mb-0">
	    	   <div class="bg-reset-password2"></div>
	    		<div class="card-img-overlay rounded-left my-5">
                 <h2 class="text-white">Welcome to</h2>
                 <h1 class="text-white"><?php echo GetCompanyName();?></h1>
                 <p class="card-text text-white pt-3">Please fill up your user id to get password on your registered mobile number</p>
             </div>
	    	</div> -->

	      <div class="card mb-0">
	    	<div class="card-body">
	         <div class="card-content p-3">
	         		<div class="text-center">
					 		<img src="<?php echo base_url(); ?>assets/web/images/logo.png">
					 	</div>
					 <div class="card-title text-uppercase text-center pb-3">Forget Password</div>
			    <form id="ResetPasswordForm" method="post" action="#">
				  <div class="form-group">
				   <div class="position-relative has-icon-left">
					  <label for="exampleInputEmailAddress" class="sr-only">Userid</label>
						<input type="text" id="userId" name="userId" class="form-control" placeholder="User Id">
						<div class="form-control-position">
						<i class="fa fa-user"></i>
					 </div>
				   </div>
				  </div>
				  <button type="submit" class="btn btn-outline-primary btn-block waves-effect waves-light">Forget Password</button>
				 
				 <div class="clearfix"></div>
				  <div class="text-center pt-3">
					<hr>
					
					<p class="text-muted">Return to the <a href="<?php echo base_url(); ?>login"> Login</a></p>
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

<script src="<?php echo base_url(); ?>assets/js/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/validateadditional.js"></script>
<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.showLoading.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/custom/common.js"></script>
<script type="text/javascript">
	var base_url='<?php echo base_url();?>';
	var submiturl =base_url+"register/ForgetPasswordSubmit";
	var confirmbox = true;
	var reporturl = base_url+"register/ForgetPassword";
	var buttonsStyling = false;

	var welcomeletter = true;

	var confirmoktxt = 'YES';
	var confirmtxt = 'You Want to Submit....!';

	var submitcntxt = 'Close';

	var confirmokclass = 'btn btn-danger';
	var confirmcnclass = 'btn btn-light';

	var confirmcntxt = 'Cancel';
	var confirmokshow = true;
	var confirmcnshow = true;
	var confirmtitle = 'Are You Sure?';


	var submitokclass = 'btn btn-light';
	var submitcnclass = 'btn btn-light';
	var submitoktxt = 'Close';

	var submitokshow = false;
	var submitcnshow = true;
	var submittitle = 'Success';
  var  submittxt="Password Sended Your Register E-mail Address";
	var formid="ResetPasswordForm";


</script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/custom/resetpassword.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/custom/submit.js"></script>
