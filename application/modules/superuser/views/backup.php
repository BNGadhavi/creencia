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
              <form id="BlogForm" method="post" action="#" enctype="multipart/form-data">
                <h4 class="form-header text-uppercase">
                  <i class="fa fa-address-book-o"></i>
                  Data Backup
                </h4>
                <div class="form-footer">
                    <button type="submit" class="btn btn-success" id="submit"><i class="fa fa-check-square-o"></i>Backup Now</button>
                </div>
              </form>

              <div class="table-responsive">
                <div id="replaceTable">
                  <table id='example' class='table table-striped table-bordered table-hover table-full-width'>
                    <thead>
                      <tr>
                        <th>SR</th>
                        <th>Entrydate</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $i=1;
                        foreach ($responseData['data'] as $key => $value) {
                          ?>
                          <tr>
                            <td><?php echo  $i++; ?></td>
                            <td><?php echo ConvertDate($value['Date___convertdate']); ?></td>
                            <td><a href="<?php echo base_url()."".$value['Download___link']; ?>" target="_blank">Download</a></td>
                          </tr>
                          <?php
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div><!--End Row-->
	</div>
</div>

<?php include_once 'footer.php'; ?>
<?php include_once 'js.php'; ?>
<?php include_once 'datatable.php'; ?>
<script type="text/javascript">
    var AdminUrl= '<?php echo $AdminUrl;?>';
    var formid="BlogForm";
    var submiturl = AdminUrl+"Backup/backupdb";
    var confirmbox = true;
    var reporturl = AdminUrl+"Backup/";
    var buttonsStyling = false;

    var confirmoktxt = 'Yes!';
    var confirmtxt = 'You Want To get Backup!';
    var submittxt = 'Backup Saved Successfully.';
    var submitcntxt = 'Cancel';

    var confirmokclass = 'btn btn-danger';
    var confirmcnclass = 'btn btn-light';
    var confirmcntxt = 'Cancel';
    var confirmokshow = true;
    var confirmcnshow = true;
    var confirmtitle = 'Are You Sure?';
    var submitokclass = 'btn btn-light';
    var submitcnclass = 'btn btn-light';
    var submitoktxt = 'View Report';
    var submitokshow = true;
    var submitcnshow = false;
    var submittitle = 'Success';

    $(document).ready(function() {
      $("#"+formid).validate({
      });
    });


    var formbtnclick = false;
    $.validator.setDefaults({
        submitHandler: function() {
            if(!formbtnclick) {            
                if(confirmbox) {
                    swal({
                        title: confirmtitle,
                        text: confirmtxt,
                        type: 'warning',
                        showCancelButton: confirmcnshow,
                        showConfirmButton: confirmokshow,
                        buttonsStyling: buttonsStyling,
                        confirmButtonClass: confirmokclass,
                        confirmButtonText: confirmoktxt,
                        cancelButtonText: confirmcntxt,
                        cancelButtonClass: confirmcnclass
                    }).then(function(){
                        submitfun();
                    });
                }
                else {
                    submitfun();
                }
            } 
        }
    });

    function submitfun() {
        formbtnclick = true;
        var LoadingClass=".card-body";
        ShowLoading(LoadingClass);
        
        $.ajax({
            url: submiturl,
            async: false,
            type: "POST",
            data: $("#"+formid+'').serialize(),
            success: function(msg)
            {
                HideLoading(LoadingClass);
                window.location.href = reporturl;
            },
            error:function()
            {
                HideLoading(LoadingClass);
                errorswal('Some Error Occur.','error', 'Error');    
            }
        });
    }
</script>