<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

	include_once 'head.php';

	include_once 'sidebar.php';

	include_once 'header.php';

?>
<style type="text/css">
  .form-check
  {
    display: inline-block;
  }
</style>

<div class="content-wrapper">

	<div class="container-fluid">

		<div class="row">

        <div class="col-lg-12">

          <div class="card">

            <div class="card-body">
              <h4 class="form-header text-uppercase">
                <i class="fa fa-address-book-o"></i>
                 Welcome Letter
              </h4>
              
              <?php 
             $CompanyName=GetCompanyName();  
             $address='';
             $pincode='';
             $city='';
             $SponsorDetail=' - ';
             
             $city_replace="[city]"; 
             $pincode_replace="[pincode]"; 

             if(!empty($SponsorInfo))
              $SponsorDetail=$SponsorInfo['username'] ." - ". $SponsorInfo['fname'];
            
             if(!empty($UserInfo['address']))
              $address=$UserInfo['address'];
             
             if(!empty($UserInfo['pincode']))
              $pincode=$UserInfo['pincode'];
             else
               $pincode_replace="-[pincode],<br/>"; 


             if(!empty($UserInfo['city']))
              $city=$UserInfo['name'];
             else
              $city_replace="[city],<br/>";  

              
              
              $message=$WelcomeLetter['SMSBody'];
              $message=str_replace("[membername]",ucfirst($UserInfo['fname']),$message);
              $message=str_replace("[address]",$address,$message);
              $message=str_replace($pincode_replace,$pincode,$message);
              $message=str_replace($city_replace,$city,$message);
              $message=str_replace("[companyname]",$CompanyName,$message);
              $message=str_replace("[memberid]",$UserInfo['username'],$message);
              $message=str_replace("[sponsorid]",$SponsorDetail,$message);

              echo $message;
              
              ?>
            </div>

          </div>

        </div>

      </div><!--End Row-->

	</div>

</div>

<?php include_once 'footer.php'; ?>

<?php include_once 'js.php'; ?>
