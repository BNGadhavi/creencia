<?php
$web_url=$this->config->item('GlobalWebUrl');
?>
<div class="boxed_wrapper">
	<div class="header-top">
		<div class="container clearfix">
			<!--Top Left-->
			<div class="top-left pull-left">
				<ul class="links-nav clearfix">
					<li><a href="#"><span class="fa fa-phone"></span> Call:  123 4561 5523 </a></li>
					<li><a href="#"><span class="fa fa-envelope"></span>Email:  info@creencia.io</a></li>
				</ul>
			</div>
			<!--Top Right-->
                <div class="top-right pull-right">
				<div class="social-links clearfix">
					<a href="#"><span class="fa fa-facebook-f"></span></a>
					<a href="#"><span class="fa fa-twitter"></span></a>
					<a href="#"><span class="fa fa-linkedin"></span></a>
					<a href="#"><span class="fa fa-instagram"></span></a>
					<a href="#"><span class="fa fa-pinterest-p"></span></a>
				</div>
			</div>
		</div>
	</div><!-- Header Top End -->

	<div class="mainmenu-area stricky">
	    <div class="container">
	    	<div class="row">
	    		<div class="col-md-3">
					<div class="main-logo">
						<a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/web/images/logo.png" alt="logo"></a>
					</div>
				</div>
				<div class="col-md-8 menu-column">
					<nav class="main-menu">
			            <div class="navbar-header">     
			                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			                    <span class="icon-bar"></span>
			                    <span class="icon-bar"></span>
			                    <span class="icon-bar"></span>
			                    <span class="icon-bar"></span>
			                </button>
			            </div>
			            <div class="navbar-collapse collapse clearfix">
			                <ul class="navigation clearfix">

			                    <li class="current"><a href="<?php echo base_url(); ?>">Home</a></li>                 
			                    <li><a href="<?php echo base_url(); ?>About">About us</a></li>
                                <li><a href="<?php echo base_url(); ?>Services">Services</a></li>
                                <li><a href="<?php echo base_url(); ?>Contact">Contact Us</a></li>
                                <li><a href="<?php echo base_url(); ?>register">Registration</a></li>
			                </ul>
			                <ul class="mobile-menu clearfix">
			                    <li class="current"><a href="<?php echo base_url(); ?>Contact">Home</a></li>                 
			                    <li><a href="<?php echo base_url(); ?>About">About us</a></li>
                                <li><a href="<?php echo base_url(); ?>Services">Services</a></li>
                                <li><a href="<?php echo base_url(); ?>Contact">Contact us</a></li>
                                <li><a href="<?php echo base_url(); ?>register">Registration</a></li>
			                </ul>
			            </div>
			        </nav>
				</div>
				<div class="col-md-1">
					<div class="right-area">
					   <div class="link_btn float_right">
						   <a href="<?php echo base_url(); ?>login" class="thm-btn">Login</a>
					   </div>
					</div>	
				</div>
	    	</div>
	        
	    </div>
	</div>