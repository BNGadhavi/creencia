<?php
require_once  'head.php';
require_once  'header.php';
?>
<link href="<?php echo base_url(); ?>assets/css/sweetalert2.min.css" rel="stylesheet"/>
<link href="<?php echo base_url(); ?>assets/css/custom/common.css" rel="stylesheet"/>
<link href="<?php echo base_url(); ?>assets/css/showLoading.css" rel="stylesheet"/>
<style type="text/css">
.error {
    color: #ff0000;
}
</style>
<section class="page-title">
	<div class="container">
    	<div class="row clearfix">
            <div class="col-xs-12 text-center pull-left">
				<h1>Contact us</h1>
			</div>
            <div class="col-xs-12 pull-right text-center path"><a href="<?php echo base_url(); ?>">Home</a>&ensp;/&ensp;<a href="#">Contact us</a></div>
			<div class="overlay"></div>
        </div>
    </div>
</section>

<section class="feature-style-three">
	<div class="container">			
		<div class="item-list">
			<div class="row">
				<div class="item">
					<div class="column col-md-4 col-sm-6 col-xs-12">
						<div class="inner-box">
							<div class="icon-box"><span class="icon flaticon-pin-1"></span></div>
							<h3>Location</h3>
							<div class="text"><p>Office address coming soon...</p></div>
						</div>
					</div>
				</div>
				
				<div class="item">
					<div class="column col-md-4 col-sm-6 col-xs-12">
						<div class="inner-box">
							<div class="icon-box"><span class="icon flaticon-cell-phone"></span></div>
							<h3>Phone Number</h3>
							<div class="text"><p>+91-1234 567 890</p></div>
						</div>
					</div>
				</div>
				
				<div class="item">
					<div class="column col-md-4 col-sm-6 col-xs-12">
						<div class="inner-box">
							<div class="icon-box"><span class="icon flaticon-message"></span></div>
							<h3>E-Mail Us</h3>
							<div class="text"><p>support@creencia.io </p></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="contact_us">
	<div class="container">   
        <div class="sec-title text-center">
            <h2>Submit your Feedback</h2>
			<p>Hi, Please complete the feedback, It will help us to serve you better.</p>
        </div>
        <div class="default-form-area">
			<form id='contactForm' name='contact_form' class='col-md-10 col-md-offset-1 default-form card-body' action="#" enctype="multipart/form-data" method='post'>
				<div class="row clearfix">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="form-group style-two">
							<input type="text" name="name" id="name" class="form-control" value="" placeholder="Enter Your Name">
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="form-group style-two">
							<input type="text" name="mobile" id="mobile" class="form-control" value="" placeholder="Enter Your Mobile">
						</div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="form-group style-two">
							<input type="text" name="subject" id="subject" class="form-control" value="" placeholder="Your Subject">
						</div>
					</div>	
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="form-group style-two">
							<textarea name="msg" id="msg" cols="30" rows="10" placeholder="Your Message" class="form-control"></textarea>
						</div>
					</div>   											  
				</div>
				<div class="contact-section-btn text-center">
					<div class="form-group style-two">
						<input class="thm-btn thm-color" type="submit" value="send message">
					</div>
				</div> 
			</form>
		</div>          
	</div>
</section>
<?php
require_once  'footer.php';
require_once  'foot.php';
?>
<script src="<?php  echo $this->config->item('base_url');?>assets/js/validate.js"></script>
<script src="<?php  echo $this->config->item('base_url');?>assets/js/validateadditional.js"></script>
<script src="<?php  echo $this->config->item('base_url');?>assets/js/sweetalert2.min.js"></script>

<script src="<?php  echo $this->config->item('base_url');?>assets/js/jquery.showLoading.min.js"></script>

<script src="<?php  echo $this->config->item('base_url');?>assets/js/select2.min.js"></script>

<script src="<?php  echo $this->config->item('base_url');?>assets/js/custom/common.js"></script>
<script type="text/javascript">

var web_url= '<?php echo $web_url;?>';
var formid="contactForm";
var submiturl = web_url+"Welcome/ContactSubmit";
var confirmbox = true;
var buttonsStyling = false;
var confirmoktxt = 'Yes!';
var confirmtxt = 'You Want To Send Message!';
var submittxt = 'Message Send Successfully.';
var submitcntxt = 'Cancel';
var confirmokclass = 'btn btn-danger';
var confirmcnclass = 'btn btn-light';
var confirmcntxt = 'Cancel';
var confirmokshow = true;
var confirmcnshow = true;
var confirmtitle = 'Are You Sure?';
var submitokclass = 'btn btn-light';
var submitcnclass = 'btn btn-light';
var submitoktxt = 'Report';
var submitokshow = false;
var submitcnshow = true;
var submittitle = 'Success';

$(document).ready(function() {
    $("#"+formid+'').validate({
        rules: {
            subject: {
                required: true,
            },
            mobile:{
                digits:true,
                required: true,
            },
            name:{
                required: true,
            },
            msg:{
                required: true,
            }
        }
    });
});
</script>
<script src="<?php  echo $this->config->item('base_url');?>assets/js/custom/submit.js"></script>