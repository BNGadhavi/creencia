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
              <form id="PanCardForm" method="post" action="#" enctype="multipart/form-data">
                <h4 class="form-header text-uppercase">
                  <i class="fa fa-address-book-o"></i>
                   Update Payment Detail
                </h4>
                <?php 
                  $adminFlag=false;
                  if(isset($this->session->userdata['adminLoggedIn'])) {
                    $adminFlag=true;                
                  }
                $imageUrl='';
                $usdt=$PanInfo['data'][0]['usdt'];
                $html='';
                if($usdt!=''){
                  $html="readonly='readonly' value='$usdt'";
                }
                if($adminFlag){
                  $html=" value='$usdt'";        
                }
                ?>

              <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">Cre8r Address</label>
                  <div class="col-sm-10">
                    <input type="text" name="usdt" id="usdt" class="form-control" <?php echo $html;?>>
                </div>
              </div>

              <div class="form-footer">
                  <button type="submit" class="btn btn-success" id="submit"><i class="fa fa-check-square-o"></i> SAVE</button>
              </div>
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
    var base_url='<?php echo base_url(); ?>';
    var member_url= '<?php echo $member_url;?>';
    var formid="PanCardForm";
    var submiturl = member_url+"KYCUpload/CoinSubmit";
    var confirmbox = true;
    var reporturl = member_url+"KYCUpload/Coinsdetail";
    var buttonsStyling = false;

    var confirmoktxt = 'Yes!';
    var confirmtxt = 'You Want To Update Payment Information!';
    var submittxt = 'Payment Detail Updated Successfully.';
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
<script type="text/javascript" src="<?php  echo $this->config->item('base_url');?>assets/js/custom/coinform.js"></script>
<script type="text/javascript" src="<?php  echo $this->config->item('base_url');?>assets/js/custom/submit.js"></script>
