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
              <form id="MemberShortForm" method="post" action="#" enctype="multipart/form-data" target="_blank">
                <h4 class="form-header text-uppercase">
                  <i class="fa fa-address-book-o"></i>
                  Member ShortCut
                </h4>
                
                <div class="form-group row usersection">
                  <label for="input-10" class="col-sm-2 col-form-label">UserId</label>
                  <div class="col-sm-10">
                   <div class="input-group mb-3 membererror">
                    <input type="text" class="form-control" id="memberId" name="memberId" required="required" value="<?php echo $memberId; ?>">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="memberName">
                        <i class='fa fa-user-o'></i>
                      </span>
                    </div>
                  </div>
                  </div>
                </div>
 
                <div class="form-footer">
                    <button type="submit" class="btn btn-success hide-div" data-rdrct="dashboard" id="submit"><i class="fa fa-check-square-o"></i> submit</button>
                    <button type="button" class="btn btn-success memsub" data-rdrct="" id="login"><i class="fa fa-check-square-o"></i> Login</button>
                    <button type="button" class="btn btn-success memsub" data-rdrct="treeview" id="genealogy"><i class="fa fa-check-square-o"></i> Genealogy</button>
                    <button type="button" class="btn btn-success memsub" data-rdrct="MemberProfile" id="edit"><i class="fa fa-check-square-o"></i> Edit Profile</button>
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
    var AdminUrl = '<?php echo $AdminUrl;?>';
    var formid = 'MemberShortForm';
</script>
<script type="text/javascript" src="<?php  echo $this->config->item('base_url');?>assets/js/custom/admin/mebershortcut.js"></script>
