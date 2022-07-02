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

              <form id="TicketReplyForm" method="post" action="#" enctype="multipart/form-data">

                <h4 class="form-header text-uppercase">

                  <i class="fa fa-address-book-o"></i>
                  Ticket Detail
                </h4>

               
                  
                  <div class="form-group row">
                    <label for="input-10" class="col-sm-2 col-form-label">Ticket Id</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="ticketId" name="ticketId" required="required" readonly="readonly" value="<?php echo $UserInfo['ticketid']?>">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="input-10" class="col-sm-2 col-form-label">Issue</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="issue" name="issue" required="required" readonly="readonly" value="<?php echo $UserInfo['issue']?>">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="input-10" class="col-sm-2 col-form-label">Message</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="message" name="message" required="required" readonly="readonly" value="<?php echo $UserInfo['Description']?>">
                    </div>
                  </div>
                  
                   <div class="form-group row">
                    <label for="input-10" class="col-sm-2 col-form-label">New Message</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="newMessage" name="newMessage" required="required">
                    </div>
                  </div>

                  <?php if($UserInfo['pin'] == 0){?>
                  <div class="form-footer">
                      <button type="submit" class="btn btn-success" id="submit"><i class="fa fa-check-square-o"></i> SAVE</button>
                      <a href="<?php echo $member_url;?>Support/CloseTicket/<?php echo $UserInfo['ticketid']?>">
                        <button type="button" class="btn btn-primary" id="closeTicket"><i class="fa fa-times-circle" aria-hidden="true"></i> Close Ticket</button> 
                      </a>
                  </div>
                 <?php }?> 
                </form>
              

              <?php include 'tableStructure.php';?>

            </div>

          </div>

        </div>

      </div><!--End Row-->

	</div>

</div>

<?php include_once 'footer.php'; ?>

<?php include_once 'js.php'; ?>

<script type="text/javascript">
  
    var memberUrl= '<?php echo $member_url;?>';
    var formid="TicketReplyForm";
    var submiturl = memberUrl+"Support/TicketReply";
    var confirmbox = true;
    var reporturl = memberUrl+"Support/TicketReport";
    var buttonsStyling = false;

    var confirmoktxt = 'Yes!';
    var confirmtxt = 'You Want To Add Ticket Reply!';
    var submittxt = 'Ticket Reply Added Successfully.';
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

</script>
<script type="text/javascript" src="<?php  echo $this->config->item('base_url');?>assets/js/custom/addticketreply.js"></script>
<script type="text/javascript" src="<?php  echo $this->config->item('base_url');?>assets/js/custom/submit.js"></script>
<?php include 'datatable.php';?>