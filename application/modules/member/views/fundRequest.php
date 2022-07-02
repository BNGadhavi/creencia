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

              <form id="FundRequestForm" method="post" action="#" enctype="multipart/form-data">

                <h4 class="form-header text-uppercase">

                  <i class="fa fa-address-book-o"></i>
                   Fund Request
                </h4>

               
              <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">Amount</label>
                  <div class="col-sm-10">
                    <input type="text" name="amount" id="amount" required="required" class="form-control">
                </div>
              </div>

              <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">Payment Mode</label>
                  <div class="col-sm-10">
                    <select name="paymentMode" id="paymentMode" required="required" class="form-control">
                      <option value="0">Cash</option>
                      <option value="1">Neft/RTGS</option>
                      <option value="2">Cheque</option>
                    </select>
                </div>
              </div>

                <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">Receipt / Neft / Cheque Number</label>
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
  
    var member_url= '<?php echo $member_url;?>';
    var formid="FundRequestForm";
    var submiturl = member_url+"FundRequest/FundRequestSubmit";
    var confirmbox = true;
    var reporturl = member_url+"FundRequest/FundRequestReport";
    var buttonsStyling = false;

    var confirmoktxt = 'Yes!';
    var confirmtxt = 'You Want To Request Fund!';
    var submittxt = 'Fund Request Done Successfully.';
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

</script>
<script type="text/javascript" src="<?php  echo $this->config->item('base_url');?>assets/js/custom/fundrequest.js"></script>
