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
<?php 
$imageUrl=$this->config->item('image_url');
?>

<body>

 <!-- Start wrapper-->
 <div id="wrapper" style="background-image: url(<?php echo $imageUrl; ?>bg-01.jpg); background-size: cover;">
<video autoplay="" muted="" loop="" id="myVideo">
  <source src="<?php echo base_url(); ?>assets/web/images/login.mp4" type="video/mp4">
</video>
     <div class="card-authentication2 mx-auto my-3">
      <div class="card-group">
        <!-- <div class="card mb-0">
           <div class="bg-signup2"></div>
          <div class="card-img-overlay rounded-left my-5">
                 <h2 class="text-white">Welcome to</h2>
                 <h1 class="text-white"><?php echo GetCompanyName();?></h1>
                 <p class="card-text text-white pt-3">Kindly login into your member panel with displayed user id and password</p>
             </div>
        </div> -->

        <div class="card mb-0">
          <div class="card-body">
            <div class="card-content p-3">
              <div class="text-center">
              <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/web/images/logo.png"></a>
            </div>
            <div class="card-title text-uppercase text-center py-3"><strong style="color: red;">Registration Successfully...</strong></div>
           <div class="card-title text-uppercase text-center py-3">Joining Letter</div>

           <?php 
           $SMSBody=$SmsData['SMSBody'];
           $SMSBody=str_replace("[username]",$MemberData['fullname'],$SMSBody);
           $SMSBody=str_replace("[userid]",$MemberData['username'],$SMSBody);
           $SMSBody=str_replace("[password]",$MemberData['password'],$SMSBody);
           $SMSBody=str_replace("[companyname]",GetCompanyName(),$SMSBody);
           echo $SMSBody;
           ?>
           <hr>
           <p class="text-muted"><a href="<?php echo base_url(); ?>login"> Click Here to Login</a></p>
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
