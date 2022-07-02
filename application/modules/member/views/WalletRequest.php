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
              <?php
              if($viewstatus=='1')
              {
                ?>
                <div class="alert alert-dismissible alert-icon-danger" role="alert">
                      <div class="alert-icon icon-part-danger">
                        <i class="icon-close"></i>
                      </div>
                    <div class="alert-message">
                      <span><strong>Info : </strong> <?php echo $msg;?></a></span>
                    </div>
                </div>
                <?php
              }
              else if($viewstatus=='2')
              {
                ?>
                <div class="alert alert-dismissible alert-icon-danger" role="alert">
                      <div class="alert-icon icon-part-danger">
                        <i class="icon-close"></i>
                      </div>
                    <div class="alert-message">
                      <span><strong>Info : </strong> <?php echo $msg;?></a></span>
                    </div>
                </div>
                <?php
              }
              else
              {
              ?>
              <form id="WalletRequestForm" method="post" action="#" enctype="multipart/form-data">
                <h4 class="form-header text-uppercase">
                  <i class="fa fa-address-book-o"></i>
                   Capital Wallet Request
                </h4>
                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Amount ($)</label>
                    <div class="col-sm-10">
                      <input type="text" name="amount" id="amount" required="required"  class="form-control">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Payment Mode</label>
                    <div class="col-sm-10">
                      <select name="paymentMode" id="paymentMode" required="required" class="form-control">
                        <option value="" disabled selected>Please Select Payment Mode</option>
                        <option value="0">Cre8r</option>
                      </select>
                  </div>
                </div>
                <div class="form-group row usdt" style="display: none;">
                  <label for="input-10" class="col-sm-2 col-form-label">Payment Address</label>
                  <div class="col-sm-8">
                    <input type="text" name="add" id="add" required="required"  class="form-control" readonly value="9xXPvG4b52NHRyPnwmPkkBkCB45nje6DyN4MQtRA65p3">
                  </div>
                  <div class="col-sm-2">
                    <button class="btn btn-outline-primary" id="copybtn" type="button">Copy</button>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Transaction No.</label>
                    <div class="col-sm-10">
                      <input type="text" name="transactionId" id="transactionId" required="required"  class="form-control">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Upload Proof</label>
                    <div class="col-sm-10">
                      <input type="file" id="proof" name="proof" class="form-control" required="required">
                  </div>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-success" id="submit"><i class="fa fa-check-square-o"></i> Submit</button>
                </div>
              </form>
              <?php
              }
              ?>
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
    var formid="WalletRequestForm";
    var submiturl = member_url+"WalletRequest/WalletRequestSubmit";
    var confirmbox = true;
    var reporturl = member_url+"WalletRequest/WalletRequestReport";
    var buttonsStyling = false;
    var confirmoktxt = 'Yes!';
    var confirmtxt = 'You Want To Send Capital Wallet Request!';
    var submittxt = 'Capital Wallet Request Sent Successfully.';
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
    var formid="WalletRequestForm";
    $("#copybtn").click(function() {
      copyid = "add";
      const copyText = document.getElementById(copyid);
      copyText.select();
      document.execCommand('copy');
      errorswal('Address Copy Successfully', 'success', 'Success');
    });
    $("#copybtn1").click(function() {
      copyid = "add1";
      const copyText = document.getElementById(copyid);
      copyText.select();
      document.execCommand('copy');
      errorswal('Address Copy Successfully', 'success', 'Success');
    });
    function errorswal(msgtext, swaltype, swaltitle) {
      swal({
            title: swaltitle,
            text: msgtext,
            type: swaltype,
            timer: 1000,
            showConfirmButton: true,
            confirmButtonText: 'Close',
            confirmButtonClass: 'btn btn-danger',
            buttonsStyling: true,
        });
    }
</script>
<script type="text/javascript" src="<?php  echo $this->config->item('base_url');?>assets/js/custom/walletrequest.js"></script>
<script type="text/javascript" src="<?php  echo $this->config->item('base_url');?>assets/js/custom/submitwithimage.js"></script>