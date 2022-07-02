<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once 'head.php';
?>
<div id="wrapper">
	<div class="card border-primary border-top-sm border-bottom-sm card-authentication1 mx-auto my-4 animated bounceInDown">
		<div class="card-body">
		 <div class="card-content p-2">
		 	<div class="text-center">
		 		<img src="<?php echo base_url(); ?>assets/images/logo/logo.png"  width="75%">
		 	</div>
			<div class="card-title text-uppercase text-center py-3">Sign Up</div>
			    <form>
				  <div class="form-group">
				   <div class="position-relative has-icon-right">
					  <label for="exampleInputName" class="sr-only">Name</label>
					  <input type="text" id="exampleInputName" class="form-control form-control-rounded" placeholder="Name">
					  <div class="form-control-position">
						  <i class="icon-user"></i>
					  </div>
				   </div>
				  </div>
				  <div class="form-group">
				   <div class="position-relative has-icon-right">
					  <label for="exampleInputEmailId" class="sr-only">Email ID</label>
					  <input type="text" id="exampleInputEmailId" class="form-control form-control-rounded" placeholder="Email ID">
					  <div class="form-control-position">
						  <i class="icon-envelope-open"></i>
					  </div>
				   </div>
				  </div>
				  <div class="form-group">
				   <div class="position-relative has-icon-right">
					  <label for="exampleInputPassword" class="sr-only">Password</label>
					  <input type="text" id="exampleInputPassword" class="form-control form-control-rounded" placeholder="Password">
					  <div class="form-control-position">
						  <i class="icon-lock"></i>
					  </div>
				   </div>
				  </div>
				  <div class="form-group">
				   <div class="position-relative has-icon-right">
					  <label for="exampleInputRetryPassword" class="sr-only">Retry Password</label>
					  <input type="password" id="exampleInputRetryPassword" class="form-control form-control-rounded" placeholder="Retry Password">
					  <div class="form-control-position">
						  <i class="icon-lock"></i>
					  </div>
				   </div>
				  </div>
				 <button type="button" class="btn btn-primary shadow-primary btn-round btn-block waves-effect waves-light">Sign Up</button>
				  <div class="text-center pt-3">
					<p class="text-muted">Already have an account? <a href="<?php echo base_url(); ?>index.php/Dashboard/login"> Sign In here</a></p>
				  </div>
				 </form>
			</div>
		  </div>
	    </div>
    
     <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->
</div><!--wrapper-->
<?php include_once 'js.php'; ?>