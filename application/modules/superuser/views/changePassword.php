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

              <form id="ChangePasswordForm" method="post" action="#" enctype="multipart/form-data">

                <h4 class="form-header text-uppercase">

                  <i class="fa fa-address-book-o"></i>
                  Change Password
                </h4>

                
                 <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Old Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="oldpass" name="oldpassword" id="oldpassword" required="required"> 
                  </div>
                </div>

                 <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">New Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="newpass" name="newpassword" id="newpassword" required="required"> 
                  </div>
                </div>

                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Re-enter Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="reenterpass" name="reenetrpassword" id="reenetrpassword" required="required"> 
                  </div>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-success" id="submit"><i class="fa fa-check-square-o"></i> Update</button>
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
  
    var AdminUrl= '<?php echo $AdminUrl;?>';
    var formid="ChangePasswordForm";
    var submiturl = AdminUrl+"Utility/UpdateChangePassword";
    var confirmbox = true;
    var reporturl = AdminUrl+"Utility/ChangePassword";
    var buttonsStyling = false;

    var confirmoktxt = 'Yes!';
    var confirmtxt = 'You Want To Change Password!';
    var submittxt = 'Password Updated Successfully.';
    var submitcntxt = 'Cancel';


    var confirmokclass = 'btn btn-danger';
    var confirmcnclass = 'btn btn-light';
    
    var confirmcntxt = 'Cancel';
    var confirmokshow = true;
    var confirmcnshow = true;
    var confirmtitle = 'Are You Sure?';
  

    var submitokclass = 'btn btn-light';
    var submitcnclass = 'btn btn-light';
    var submitoktxt = 'Close';
    
    var submitokshow = true;
    var submitcnshow = false;
    var submittitle = 'Success';

</script>
<script type="text/javascript" src="<?php  echo $this->config->item('base_url');?>assets/js/custom/admin/changepassword.js"></script>
<script type="text/javascript" src="<?php  echo $this->config->item('base_url');?>assets/js/custom/admin/submit.js"></script>
