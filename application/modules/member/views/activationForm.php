<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once 'head.php';
	include_once 'sidebar.php';
	include_once 'header.php';
?>
<div class="content-wrapper">
	<div class="container-fluid">
		<div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <form id="activationForm" method="post" action="#">
                <h4 class="form-header text-uppercase">
                  <i class="fa fa-address-book-o"></i>
                   Activation
                </h4>
                <?php
                  $iconName="icon-info";
                  $iconClass="icon-part-danger";
                  $divClass="alert-icon-danger";
                  $strongText="Capital Wallet Balance.";
                  ?>
                  <div class="alert alert-dismissible <?php echo $divClass?>" role="alert">
                      <div class="alert-icon <?php echo $iconClass?>">
                        <i class="<?php echo $iconName;?>"></i>
                      </div>
                    <div class="alert-message">
                      <span><strong><?php echo $strongText;?> : <?php echo $walletamount; ?> &nbsp;$</strong> </span>
                    </div>
                  </div>
                <div class="form-group row">
                 <label for="basic-input" class="col-sm-2 col-form-label">Package Name</label>
                  <div class="col-sm-10">
                    <div class="input-group mb-3 packageerror">
                       <select name="packageId" id="packageId" required="required" class="form-control" onchange="packageamt();getPin();">
                      <option value="" disabled="disabled" selected="selected">Select Package</option>
                      <?php 
                      foreach ($packagList['data'] as  $value) {
                        ?>
                        <option value="<?php echo $value['id']?>" mrp="<?php echo $value['mrp'];?>"><?php echo $value['packagename']?></option>
                      <?php } ?>
                      
                    </select>
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="packagemrp">
                          <i class='fa fa-usd'></i>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>

                 <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Memberid</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="memberid" name="memberid"  required="required" value="<?php echo $memberId?>" <?php if($memberId!=''){?> readonly <?php }?>> 

                      <div class="alert alert-success alert-dismissible" role="alert">
                        <div class="alert-message membername" style="display:none;">
                          <span><strong>Member Name : </strong><span id="memberName"></span></span>
                        </div>
                      </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Activation Mode</label>
                  <div class="col-sm-10">
                    <select name="activationMode" id="activationMode" required="required" class="form-control">
                      <!-- <option value="0" selected="selected">Pin</option> -->
                      <option value="1" selected="selected">Capital Wallet</option>
                    </select>
                  </div>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Activate</button>
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
  
   var member_url= '<?php echo $member_url;?>';
   var submiturl = member_url+"Activation/ActivationSubmit";
   var confirmbox = true;
   var reporturl = member_url+"Activation";
   var buttonsStyling = false;

  var confirmoktxt = 'Yes, Activate!';
  var confirmtxt = 'You Want To Activate!';
  var submittxt = 'Activation Done Successfully.';
  var submitcntxt = 'Close';

  var confirmokclass = 'btn btn-danger';
  var confirmcnclass = 'btn btn-light';
  
  var confirmcntxt = 'Cancel';
  var confirmokshow = true;
  var confirmcnshow = true;
  var confirmtitle = 'Are You Sure?';

  var submitokclass = 'btn btn-light';
  var submitcnclass = 'btn btn-light';
  var submitoktxt = 'Close';
  
  var submitokshow = false;
  var submitcnshow = true;
  var submittitle = 'Success';
  var formid='activationForm';
  var balance="<?php echo $walletamount; ?>";
</script>
<script type="text/javascript" src="<?php  echo $this->config->item('base_url');?>assets/js/custom/activation.js"></script>
<script src="<?php  echo $this->config->item('base_url');?>assets/js/custom/submit.js"></script>