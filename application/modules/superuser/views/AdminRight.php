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
            
              <form id="RightForm" class="customform" method="post" action="#" enctype="multipart/form-data">

                <h4 class="form-header text-uppercase">
                  <i class="fa fa-address-book-o"></i>
                  <?php echo $pageTitle; ?>
                </h4>

                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Select Admin : </label>
                    <div class="col-sm-10">
                     <select name="userid" id="userid" required="required" class="form-control">
                      <option value="" disabled="" selected="" >Select Admin</option>
                       <?php foreach ($responseData['data'] as $key => $value) { ?>
                        <option value="<?php echo $value['id___hide']; ?>"><?php echo $value['Username']; ?></option>
                       <?php }
                       ?>
                     </select>
                  </div>
                </div>

                <div class="form-group row adminright">
                <?php

                foreach ($rightData as $key => $value) {
                  ?>
                    <div class="col-sm-4 ">
                      <div class="card-header text-uppercase">
                        <div class="form-check paddingleft0">
                          <input class="form-check-input maincheckbox" name="menu[]" type="checkbox" value="<?php echo $key; ?>" id="<?php echo $key; ?>" allcheck='<?php echo $key; ?>'>
                          <label class="form-check-label textbold" for="<?php echo $key; ?>">
                          <?php echo $value['Parent Menu']; ?>
                          </label>
                        </div>
                      </div>
                      <div class="card-body">
                        <?php
                        foreach ($value['sub'] as $k => $v) {
                          ?>
                          <div class="form-check">
                            <input class="form-check-input <?php echo $key; ?>" type="checkbox" value="<?php echo $k; ?>" name="submenu[]" id="<?php echo $k; ?>">
                            <label class="form-check-label" for="<?php echo $k; ?>">
                            <?php echo $v; ?>
                            </label>
                          </div>
                          <?php
                        }
                        ?>
                      </div>
                    </div>
                  <?php  
                }
                ?>
                </div>
                
                <div class="form-footer">
                    <button type="submit" class="btn btn-success" id="submit"><i class="fa fa-check-square-o"></i> Save</button>
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
    var formid = "RightForm";
    var submiturl = AdminUrl+"AdminMaster/RightUpdate";
    var confirmbox = true;
    var reporturl = AdminUrl+"AdminMaster";
    var buttonsStyling = false;

    var confirmoktxt = 'Yes!';
    var confirmtxt = 'You Want Update Right!';
    var submittxt = 'Right Updated Successfully.';
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
<script type="text/javascript" src="<?php  echo $this->config->item('base_url');?>assets/js/custom/admin/submit.js"></script>
<script type="text/javascript">

  $(document).ready(function() {
    $("#"+formid).validate({
      rules: {
        userid : {
          required: true,
        },
      },
    });
  });

  $(document).on('click','.maincheckbox',function(){
    var allcheck = $(this).attr('allcheck');
    var checkid = $(this).attr('id');
    if($(this).is(":checked")) {
      $("."+allcheck).prop('checked',true);  
    }
    else {
      $("."+allcheck).prop('checked',false);
    }
  });

  $(document).on('change','#userid',function() {
    var adminid = $(this).val();
    if(parseInt(adminid) > 0) {
      
      var LoadingClass=".card-body";
      ShowLoading(LoadingClass);
      $.ajax({
          url: AdminUrl+"AdminMaster/RightCheck",
          async: false,
          type: "POST",
          data: "userid="+adminid,
          beforeSend: function(){
            
          },
          success: function(msg)
          {
            var response = $.parseJSON(msg);
            var dataarr = response.data;
            $.each( dataarr, function( i, val ) {
              if($("#"+val.menuid).length > 0) {
                $("#"+val.menuid).prop('checked',true);
              }
            });
            HideLoading(LoadingClass);
          },
          error:function()
          {
            HideLoading(LoadingClass);
            cust_msg_show(cust_pop_msg_show, 'error', 'top right', 'fa fa-times-circle', 'Some Error Occur.');    
          }
      });

    }
  });
</script>
