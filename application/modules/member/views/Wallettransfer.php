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
</style>
<div class="content-wrapper">
	<div class="container-fluid">
		<div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <form id="Wallettransfer" method="post" action="#">
                <h4 class="form-header text-uppercase">
                  <i class="fa fa-address-book-o"></i>
                  Capital Wallet Transfer To Other Member
                </h4>
                <?php
                if($lockmember=='0')
                {
                  ?>
                <div class="alert alert-dismissible alert-icon-info" role="alert">
                  <div class="alert-icon icon-part-info">
                    <i class="icon-info"></i>
                  </div>
                  <div class="alert-message">
                    <span><strong>Capital Wallet Balance : </strong> <?php echo $Balance=$RepurchaseWallet['data'][0]['Balance']; ?></span>
                  </div>
                </div>
                <div class="form-group row">
                 <label for="basic-input" class="col-sm-2 col-form-label">Member Id</label>
                  <div class="col-sm-10">
                    <div class="input-group mb-3 membererror">
                      <input type="text" class="form-control" id="memberId" name="memberId" required="required">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="memberName">
                          <i class='fa fa-user-o'></i>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Enter Capital Wallet</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="amount" name="amount"  required="required" > 
                  </div>
                </div>
                <div class="form-group row hide-div">
                  <label for="input-10" class="col-sm-2 col-form-label">Remark</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" id="remark" name="remark"></textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Transaction Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="transactionPassword" name="transactionPassword"  required="required" > 
                  </div>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i>Transfer</button>
                </div>

              </form>
              <?php
                }
                else
                {
                  $iconName="icon-close";
                  $iconClass="icon-part-danger";
                  $divClass="alert-icon-danger";
                  $strongText="Locked.";
                  ?>
                  <div class="alert alert-dismissible <?php echo $divClass?>" role="alert">
                      <div class="alert-icon <?php echo $iconClass?>">
                        <i class="<?php echo $iconName;?>"></i>
                      </div>
                    <div class="alert-message">
                      <span><strong><?php echo $strongText;?>!</strong> Your ID Is Locked...Please Contact Admin.</a></span>
                    </div>
                  </div>
                  <?php
                }
                ?>
              <?php /*
              <form id="ResendOTP" method="post" action="#" enctype="multipart/form-data">
                  <button type="submit" class="btn btn-warning" id="resendotp" style="float: right;margin-top: -48px"><i class="fa fa-check-square-o"></i>Send OTP</button>
              </form>
              */?>
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
    var formid="Wallettransfer";
    var submiturl = member_url+"Wallet/Fundtransfersubmit";
    var confirmbox = true;
    var reporturl = member_url+"Wallet/Fundtransferreport";
    var buttonsStyling = false;

    var confirmoktxt = 'Yes!';
    var confirmtxt = 'You Want To Transfer Capital Wallet!';
    var submittxt = 'Capital Wallet Transfer Successfully.';
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
    
    var submitokshow = true;
    var submitcnshow = false;
    var submittitle = 'Success';
    var Balance='<?php echo $Balance?>';
</script>
<script type="text/javascript" src="<?php  echo $this->config->item('base_url');?>assets/js/custom/wallettransfer.js"></script>
<script src="<?php  echo $this->config->item('base_url');?>assets/js/custom/submit.js"></script>