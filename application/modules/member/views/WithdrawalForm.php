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
                /*$BankName=$BankInfo['data'][0]['bankname'];
                $BankType=$BankInfo['data'][0]['banktype'];
                $BankIfsc=$BankInfo['data'][0]['bankifsc'];
                $BankAccNo=$BankInfo['data'][0]['bankaccno'];
                $BankBranch=$BankInfo['data'][0]['bankbranch'];
                $BankAccName=$BankInfo['data'][0]['bankaccname'];
                $TDS=$TDS;
                $AdminCharge=$AdminCharge;
                $MinAmount=$MinAmount;*/
                $Balance=$walletBalance['data'][0]['Balance'];
               ?>
                
                <?php
                if($lockmember=='0')
                {
                  if(!$valid){?>
                   <div class="alert alert-dismissible alert-icon-danger" role="alert">
                      <div class="alert-icon icon-part-danger">
                        <i class="icon-close"></i>
                      </div>
                    <div class="alert-message">
                      <span><strong>Warning : </strong> <?php echo $msg;?></a></span>
                    </div>
                </div>
                <?php }

                else{
                ?>
                  <form id="withdrawalForm" method="post" action="#">
                    <h4 class="form-header text-uppercase">
                      <i class="fa fa-address-book-o"></i>
                           Withdrawal Request
                    </h4>
                    <div class="alert alert-dismissible alert-icon-warning" role="alert">
                          <div class="alert-icon icon-part-warning">
                            <i class="icon-info"></i>
                          </div>
                        <div class="alert-message">
                          <span><strong>Income Wallet Balance : <?php echo $Balance;?> </strong></span>
                        </div>
                    </div>
                   
                    <div class="form-group row">
                      <label for="input-10" class="col-sm-2 col-form-label">Enter Income Wallet</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="amount" name="amount"  required="required" > 
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="input-10" class="col-sm-2 col-form-label">Admin Charge (5%)</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="ac" name="ac"  required="required" readonly> 
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="input-10" class="col-sm-2 col-form-label">Net Income Wallet ($)</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="netamount" name="netamount"  required="required" readonly> 
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="input-10" class="col-sm-2 col-form-label">Payment Mode</label>
                        <div class="col-sm-10">
                          <select name="paymentMode" id="paymentMode" required="required" class="form-control">
                            <option value="0">USDC</option>
                           </select>
                      </div>
                    </div>
                    <div class="form-group row usdt">
                      <label for="input-10" class="col-sm-2 col-form-label">USDC Address</label>
                      <div class="col-sm-10">
                        <input type="text" name="usdt" id="usdt" required="required" readonly class="form-control" value="<?php echo $PanInfo['data'][0]['usdt']; ?>">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="input-10" class="col-sm-2 col-form-label">Transaction Password</label>
                      <div class="col-sm-10">
                        <input type="password" class="form-control" id="transactionPassword" name="transactionPassword"  required="required" > 
                      </div>
                    </div>
                   
                    <?php
                    if($valid){
                    ?><div class="form-footer">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Request</button>
                      </div>
                  <?php }
                  ?>
                  </form>
            <?php 
             }
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
  var submiturl = member_url+"Withdrawal/Insert";
  var confirmbox = true;
  var reporturl = member_url+"Withdrawal";
  var buttonsStyling = false;

  var confirmoktxt = 'Yes, Withdrawal!';
  var confirmtxt = 'You Want To Send Withdrawal Request!';
  var submittxt = 'Withdrawal Request Done Successfully.';
  var submitcntxt = 'Close';

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
  var formid='withdrawalForm';
  var MinAmount='<?php echo $MinAmount; ?>';
  var MaxAmount='<?php echo $MaxAmount; ?>';
  var MaxAmount='<?php echo $MaxAmount; ?>';
  var Balance='<?php echo $Balance; ?>';
</script>
<script type="text/javascript" src="<?php  echo $this->config->item('base_url');?>assets/js/custom/withdrawal.js"></script>
<script src="<?php  echo $this->config->item('base_url');?>assets/js/custom/submit.js"></script>