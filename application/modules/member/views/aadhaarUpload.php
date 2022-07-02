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
  i.fa.fa-user-o,i.fa.fa-key {
    padding-right: 5px;
 }
 .kyc-image{
  width: 30%;
 }
 .kyc-div{
  text-align: center; 
 }
</style>

<div class="content-wrapper">

	<div class="container-fluid">

		<div class="row">

        <div class="col-lg-12">

          <div class="card">

            <div class="card-body">


              <form id="AadhaarCardForm" method="post" action="#" enctype="multipart/form-data">

                <h4 class="form-header text-uppercase">

                  <i class="fa fa-address-book-o"></i>
                   National ID Proof Uploadation
                </h4>

                <?php 
                  $adminFlag=false;
                  if(isset($this->session->userdata['adminLoggedIn'])) {
                    $adminFlag=true;                
                  }
                ?>

                <?php

                $imageUrl='';

                if($LastKycInfo['status']){
                  $imageUrl=$LastKycInfo['data'][0]['Proof___imagedisplay'];
                }
                $aadharNumber=$AadhaarInfo['data'][0]['aadharcard'];
                $aadharStatus=$AadhaarInfo['data'][0]['adharstatus'];
                $html='';
                if($aadharNumber!=''){
                  $html="readonly='readonly' value='$aadharNumber'";
                }
                if($adminFlag)
                {
                  $html="value='$aadharNumber'";
                }

                $aadhaarMsg='';
                if($aadharStatus == '1'){
                  $aadhaarMsg='Your National ID Information Accepted Successfully.';
                  $iconName="icon-check";
                  $iconClass="icon-part-success";
                  $divClass="alert-icon-success";
                  $strongText="Success";
                }
                else if($aadharStatus == '2'){
                 $aadhaarMsg='Your National ID Information Rejected.';
                  $iconName="icon-close";
                  $iconClass="icon-part-danger";
                  $divClass="alert-icon-danger";
                  $strongText="Reject";
                }
                else if($aadharStatus == '3'){
                 $aadhaarMsg='Your National ID Information Is Under Process next 48 hours we will responce.';
                 $iconName="icon-warning";
                 $iconClass="icon-part-warning";
                 $divClass="alert-icon-warning";
                 $strongText="Pending";
                }

                if($aadhaarMsg != ''){?>
                  <div class="alert alert-dismissible <?php echo $divClass?>" role="alert">
                      <div class="alert-icon <?php echo $iconClass?>">
                        <i class="<?php echo $iconName;?>"></i>
                      </div>
                    <div class="alert-message">
                      <span><strong><?php echo $strongText;?>!</strong> <?php echo $aadhaarMsg;?></a></span>
                    </div>
                  </div>
                <?php }

                ?>

              <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">ID Number</label>
                  <div class="col-sm-10">
                    <input type="text" name="aadhaarNo" id="aadhaarNo" required="required" class="form-control" <?php echo $html;?>>
                </div>
              </div>
          

              <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">Upload Proof</label>
                  <div class="col-sm-10">
                    <input type="file" id="proof" name="proof" class="form-control" required="required">
                </div>
              </div>

              <?php
              if($imageUrl!=''){?>
                <div class="kyc-div">
                <img src="<?php echo $imageUrl?>" class="kyc-image">
              </div>
              <?php }
               ?>

                <?php if(($aadharStatus == '0' || $aadharStatus =='2') || $adminFlag==true){?>
                <div class="form-footer">
                    <button type="submit" class="btn btn-success" id="submit"><i class="fa fa-check-square-o"></i> SAVE</button>
                </div>
              <?php }?>


              </form>

            </div>

          </div>

        </div>

      </div><!--End Row-->

	</div>

</div>

<?php include_once 'footer.php'; ?>

<?php include_once 'js.php'; ?>

<script type="text/javascript">
  
    var member_url= '<?php echo $member_url;?>';
    var formid="AadhaarCardForm";
    var submiturl = member_url+"KYCUpload/AadhaarCardSubmit";
    var confirmbox = true;
    var reporturl = member_url+"KYCUpload/NationalCard";
    var buttonsStyling = false;

    var confirmoktxt = 'Yes!';
    var confirmtxt = 'You Want To Update KYC Information!';
    var submittxt = 'ID Proof Updated Successfully.';
    var submitcntxt = 'Cancel';


    var confirmokclass = 'btn btn-danger';
    var confirmcnclass = 'btn btn-light';
    
    var confirmcntxt = 'Cancel';
    var confirmokshow = true;
    var confirmcnshow = true;
    var confirmtitle = 'Are You Sure?';
  

    var submitokclass = 'btn btn-light';
    var submitcnclass = 'btn btn-light';
    var submitoktxt = 'More Update';
    
    var submitokshow = true;
    var submitcnshow = false;
    var submittitle = 'Success';

</script>

<script type="text/javascript" src="<?php  echo $this->config->item('base_url');?>assets/js/custom/aadhaarcardform.js"></script>
<script type="text/javascript" src="<?php  echo $this->config->item('base_url');?>assets/js/custom/submitwithimage.js"></script>
