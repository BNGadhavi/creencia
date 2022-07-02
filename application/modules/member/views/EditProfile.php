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
  .select2-results__option[aria-selected=true] { display: none;}

</style>

<div class="content-wrapper">

	<div class="container-fluid">

		<div class="row">

        <div class="col-lg-12">

          <div class="card">

            <div class="card-body">

              <form id="EditProfileForm" method="post" action="#">

                <h4 class="form-header text-uppercase">

                  <i class="fa fa-address-book-o"></i>
                   Edit Profile
                </h4>
                <?php 
                $adminFlag=false;
                if(isset($this->session->userdata['adminLoggedIn'])) {
                  $adminFlag=true;                
                }
                ?>

                <?php 
                $fullName=$response_profile->fname;
                $Email=$response_profile->email;
                $MobileNo=$response_profile->mobile;
                $Whatsapp=$response_profile->whatsapp;
                $PanNo=$response_profile->panno;
                $Address=$response_profile->address;
                $State=$response_profile->state;
                $City=$response_profile->city;
                $Nominee=$response_profile->nominee;
                $NomineeRel=$response_profile->nomineerel;
                $BankName=$response_profile->bankname;
                $BankAccName=$response_profile->bankaccname;
                $BankBranch=$response_profile->bankbranch;
                $BankAccNo=$response_profile->bankaccno;
                $BankType=$response_profile->banktype;
                $BankIfsc=$response_profile->bankifsc;
                $pincode=$response_profile->pincode;
                ?>

                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Full Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="FullName" name="FullName" required="required" value="<?php echo $fullName;?>"
                    <?php if($fullName !='' and !$adminFlag){?>
                      readonly="readonly"
                    <?php }?>
                    > 
                  </div>
                </div>

                 <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" id="Email" name="Email" value="<?php echo $Email;?>" 
                      <?php if($Email !='' and !$adminFlag){?>
                        readonly="readonly"
                      <?php }?>
                    > 
                  </div>
                </div>

                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Mobile Number</label>
                  <div class="col-sm-10">
                    <input  class="form-control" type="number" id="Mobile" min="10" maxlength="10" name="Mobile" value="<?php echo $MobileNo;?>" 
                    <?php if($MobileNo !=0 and !$adminFlag){?>
                        readonly="readonly"
                      <?php }?>
                    > 
                  </div>
                </div>

                <div class="form-group row hide-div">
                  <label for="input-10" class="col-sm-2 col-form-label">Whatsapp No</label>
                  <div class="col-sm-10">
                    <input  class="form-control" type="number" id="Whatsapp" min="10" maxlength="10" name="Whatsapp"  value="<?php $Whatsapp;?>"> 
                  </div>
                </div>

                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Address</label>
                  <div class="col-sm-10">
                    <input  class="form-control" type="text" id="Address" name="Address"  value="<?php echo $Address;?>"
                      <?php if($Address !='' and !$adminFlag){?>
                        readonly="readonly"
                      <?php }?>
                    > 
                  </div>
                </div>
               

                 <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">State</label>
                  <div class="col-sm-10">
                   <select class="form-control select-box" name="State" id="State">
                     <option value="">Select State</option>
                      <?php 
                      foreach ($response_state as $rs) {?>
                          <option value="<?php echo $rs->id;?>"><?php echo $rs->name;?></option>
                      <?php }
                      ?>

                   </select>
                  </div>
                </div>

               
               
                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">City</label>
                  <div class="col-sm-10">
                   <select class="form-control select-box" name="City" id="City">
                    
                     <?php if( $response_city->id !=''){
                      ?>
                     <option selected="selected" value="<?php echo $response_city->id;?>"><?php echo $response_city->name;?></option>
                     <?php }
                     else{?>
                       <option value="" selected="selected">Select City</option>
                     <?php }?>
                     
                   </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Nominee Name</label>
                  <div class="col-sm-10">
                    <input  class="form-control" type="text" id="NomineeName" name="NomineeName"  value="<?php echo $Nominee;?>"
                     <?php if($Nominee !='' and !$adminFlag){?>
                        readonly="readonly"
                      <?php }?>
                    > 
                  </div>
                </div>

                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Nominee Relation</label>
                  <div class="col-sm-10">
                     <select class="form-control select-box" name="NomineeRel" id="NomineeRel">
                        <option value="">Select Nominee Relation</option>
                        <option value="son">Son</option>
                        <option value="brother">Brother</option>
                        <option value="sister">Sister</option>
                        <option value="father">Father</option>
                        <option value="wife">Wife</option>
                        <option value="mother">Mother</option>
                        <option value="daughter">Daughter</option>
                        <option value="brother in law">Brother In Law</option>
                        <option value="brother in law">Father In Law</option>
                        <option value="husband">Husband</option> 
                   </select>
                  </div>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
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
    var formid="EditProfileForm";
    var submiturl = member_url+"MemberProfile/MemberProfileSubmit";
    var confirmbox = true;
    var reporturl = member_url+"MemberProfile";
    var buttonsStyling = false;

    var confirmoktxt = 'Yes, Update!';
    var confirmtxt = 'You Want To Update Profile!';
    var submittxt = 'Profile Updated Successfully.';
    var submitcntxt = 'Cancle';


    var confirmokclass = 'btn btn-danger';
    var confirmcnclass = 'btn btn-light';
    
    var confirmcntxt = 'Cancel';
    var confirmokshow = true;
    var confirmcnshow = true;
    var confirmtitle = 'Are You Sure?';
  

    var submitokclass = 'btn btn-light';
    var submitcnclass = 'btn btn-light';
    var submitoktxt = 'More Update';
    
    var submitokshow = true;
    var submitcnshow = false;
    var submittitle = 'Success';
    var city='<?php echo $City;?>'; 
    var adminFlag='<?php echo $adminFlag?>'; 
 $(document).ready(function() {
  var state='<?php echo $State?>';
  var nomineerel='<?php echo $NomineeRel?>';

  $('#State').val(state).trigger('change');
  $('#NomineeRel').val(nomineerel).trigger('change');

  if(adminFlag == false){
    if(state!=0){
      $("#State [value!='"+state+"']").remove();
    }
    if(city!=0){
       $("#City [value!='"+city+"']").remove(); 
    }
    if(nomineerel!='')
    {
      $("#NomineeRel [value!='"+nomineerel+"']").remove();    
    }
    $("#BankName [value!='"+bankname+"']").remove();  
    if(banktype !=''){
      $(".type").attr('disabled', true);
    }  
  }
});

</script>
<script type="text/javascript" src="<?php  echo $this->config->item('base_url');?>assets/js/custom/editprofile.js"></script>
<script src="<?php  echo $this->config->item('base_url');?>assets/js/custom/submit.js"></script>