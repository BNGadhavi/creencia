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
              <form id="changepassword" method="post" action="#">
                <h4 class="form-header text-uppercase">
                  <i class="fa fa-address-book-o"></i>
                   Set Transaction Password
                </h4>

                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Enter Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="oldpass" name="oldpassword" id="oldpassword" required="required"> 
                  </div>
                </div>

                 <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Re-Enter Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="newpass" name="newpassword" id="newpassword" required="required"> 
                  </div>
                </div>
                <div class="form-footer">
                    <button type="submit" id="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i>Submit </button>
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
  var submiturl = member_url+"ChangePassword/setTransactionPassword";
  var confirmbox = true;
  var reporturl = member_url+"ChangePassword/ChangeTransactionPassword";
  var buttonsStyling = false;
  var confirmoktxt = 'Yes!';
  var confirmtxt = 'You Want To Set Password!';
  var submittxt = 'Password Set Successfully.';
  var submitcntxt = 'Close';

  var confirmokclass = 'btn btn-danger';
  var confirmcnclass = 'btn btn-light';
  var confirmcntxt = 'Cancel';
  var confirmokshow = true;
  var confirmcnshow = true;
  var confirmtitle = 'Are You Sure?';
  var submitokclass = 'btn btn-light';
  var submitcnclass = 'btn btn-light';
  var submitoktxt = 'Refresh';
  
  var submitokshow = true;
  var submitcnshow = false;
  var submittitle = 'Success';
  var formid='changepassword';
  $(document).ready(function() {
    $("#changepassword").validate({
        rules: {
            oldpassword: {
                required: true,
            },
            newpassword: {
                required: true,
                equalTo: "#oldpass"
            }
        }
    });
  });
</script>
<script src="<?php  echo $this->config->item('base_url');?>assets/js/custom/submit.js"></script>