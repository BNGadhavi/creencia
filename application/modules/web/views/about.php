<?php
require_once  'head.php';
require_once  'header.php';
?>
<section class="page-title">
	<div class="container">
    	<div class="row clearfix">
            <div class="col-xs-12 text-center pull-left">
				<h1>About us</h1>
			</div>
            <div class="col-xs-12 pull-right text-center path"><a href="<?php echo base_url(); ?>">Home</a>&ensp;/&ensp;<a href="#">About us</a></div>
			<div class="overlay"></div>
        </div>
    </div>
</section>
<!--Page Title Ends-->

<section class="about">
	<div class="container">
		<div class="item-list">
			<div class="row">
				<div class="col-md-7 col-sm-12 col-xs-12">
					<div class="item clearfix">
						<div class="sec-title">
							<h2>About Creencia</h2>
						</div>
						<div class="content-box">
							<h4>We are building the cryptoeconomy – a more fair, accessible, efficient, and transparent financial system enabled by crypto.</h4>
							<p>We started in 2018 with the radical idea that anyone, anywhere, should be able to easily and securely send and receive USD Coin. Today, we offer a trusted and easy-to-use platform for accessing the broader cryptoeconomy.</p>
						</div>
						
						<!--Fact Counter-->
						
					</div>
				</div>
				<div class="col-md-5 col-sm-10 col-xs-12">
					<div class="item">
						<figure class="image-box">
							<img src="<?php echo base_url(); ?>assets/web/images/about-2.jpg" alt="" />
						</figure>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!--Paralax Style One-->
<section class="parallax-style-one" style="background-image:url(<?php echo base_url(); ?>assets/web/images/background/bg-1.jpg);">
	<div class="container">
		<div class="sec-title">
			<h2>Creencia powers the <span> cryptoeconomy </span></h2>
			<p>Customers around the world discover and begin their journeys with crypto through Creencia.</p>
		</div>									
		<ul class="link_btn text-center">
			<li><a href="<?php echo base_url(); ?>login" class="thm-btn style-two">Login</a></li>
			<li><a href="<?php echo base_url(); ?>register" class="thm-btn style-two">Registration</a></li>
		</ul>	
	</div>
</section>	

<!--team section-->

<section class="about about-2">
	<div class="container">
		<div class="item-list">
			<div class="row">
			
				<div class="col-md-6 col-xs-12">
					<div class="item">
						<figure class="image-box">
							<img src="<?php echo base_url(); ?>assets/web/images/desktop.jpg" alt="" class="center-block img-responsive">
						</figure>
					</div>
				</div>
				<div class="col-md-6 col-xs-12">
					<div class="item clearfix">
						<div class="sec-title">
							<h2 class="left">Buy and Sell USD Coin</h2>
						</div>
						<div class="content-box">
							<h4>Buy &amp; Sell Crypto on Creencia: Where You Trade Crypto in 3 Steps</h4>
							<p>Creencia is a safe and secure platform to buy and sell cryptocurrencies quickly using our streamlined buy/sell process. You're just three steps away from your first USD Coin Ethereum, and other cryptocurrencies.</p>
							<a href="#" class="thm-btn">Join Us Now</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
require_once  'footer.php';
require_once  'foot.php';
?>