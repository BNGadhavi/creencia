<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once 'head.php';
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
<video autoplay="" muted="" loop="" id="myVideo">
  <source src="<?php echo base_url(); ?>assets/web/images/login.mp4" type="video/mp4">
</video>
<div id="wrapper">
		<div class="card border-primary border-top-sm border-bottom-sm card-authentication1 mx-auto my-5 animated bounceInDown">
		<div class="card-body">
		 <div class="card-content p-2">
		 	<div class="text-center">
		 		<img src="<?php echo base_url(); ?>assets/web/images/logo.png" style="width: 100%;">
		 	</div>
		  	<div class="card-title text-uppercase text-center py-3">Sign In</div>
		  	<form action="<?php echo base_url(); ?>login/LoginSubmit" id="loginform" method="post">
			  <div class="form-group">
			   <div class="position-relative has-icon-right">
				  <label for="exampleInputUsername" class="sr-only">Username</label>
				  <input required="required" type="text" id="username" name="username" value="<?php echo set_value('username'); ?>" class="form-control form-control-rounded" placeholder="<?php echo $this->lang->line('label_userid'); ?>">
				  <?php echo form_error('username'); ?>
				  <div class="form-control-position">
					  <i class="icon-user"></i>
				  </div>
			   </div>
			  </div>
			  <div class="form-group">
			   	<div class="position-relative has-icon-right">
					<label for="exampleInputPassword" class="sr-only">Password</label>
					<input required="required" type="password" id="password" name="password" value="<?php echo set_value('password'); ?>" class="form-control form-control-rounded" placeholder="<?php echo $this->lang->line('label_password'); ?>">
					<?php echo form_error('password'); 
					if (isset($error_message)) {
						echo "<label class='error'>".$error_message."</label>";
					}
					?>

					<div class="form-control-position">
					  <i class="icon-lock"></i>
					</div>
				</div>
			  </div>
			<div class="form-row mr-0 ml-0">
			 <div class="form-group col-6 text-right">
			  <!-- <a href="authentication-reset-password.html">Reset Password</a> -->
			 </div>
			</div>
			 <button type="submit" class="btn btn-primary shadow-primary btn-round btn-block waves-effect waves-light">Sign In</button>
			  <div class="text-center pt-3">
			  </div>
			 </form>

			 
			  <div class="text-center pt-3">

				<p class="text-muted">Do not have an account? <a href="<?php echo base_url(); ?>register"> Sign Up here</a></p>
				<p class="text-muted">Forget Password ? <a href="<?php echo base_url(); ?>register/ForgetPassword"> Click here</a></p>

			  </div>


		   </div>
		  </div>
	     </div>
    
     <!--Start Back To Top Button-->
		    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
		    <!--End Back To Top Button-->
	</div><!--wrapper-->
<?php include_once 'js.php'; ?>
<script src="<?php echo base_url(); ?>assets/js/custom/memberlogin.js"></script>
