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
                $tabindex='1';
                $franchText="Add";
                ?>
                <form id="CreateKit" method="post" action="#" enctype="multipart/form-data">
                  <h4 class="form-header text-uppercase">
                    <i class="fa fa-address-book-o"></i>
                    Create Product Kit
                  </h4>

                  <div class="form-group row">
                    <label for="input-10" class="col-sm-2 col-form-label">Kit ID</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="kitid" name="kitid" required="required" tabindex="<?php echo $tabindex++; ?>">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="input-10" class="col-sm-2 col-form-label">Kit Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="kitnames" name="kitnames" required="required" tabindex="<?php echo $tabindex++; ?>">
                    </div>
                  </div>

                  <div class="form-group row stateloading">
                    <label for="input-10" class="col-sm-2 col-form-label">Select Package</label>
                    <div class="col-sm-10 input-group mb-3 ">
                      <select name="pcode" id="pcode" required="required" class="custom-select" tabindex="<?php echo $tabindex++; ?>">
                        <option value="" disabled="disabled" selected="selected">Select Package</option>
                        <?php
                        foreach ($packagelist['data'] as $rs) 
                        {
                        ?>
                          <option value="<?php echo $rs['id'];?>" mrp="<?php echo $rs['mrp'];?>"><?php echo $rs['packagename'];?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <div class="input-group-append">
                        <span class="input-group-text" id="pmrp">
                          <i class='fa fa-inr'></i>
                        </span>
                      </div>
                    </div>
                    <div class="pcodeerror" style="float: right;"></div>
                  </div>

                  <div class="form-group row">
                    <label for="input-10" class="col-sm-2 col-form-label">District Commission <small>(In Amount)</small></label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="discommission" name="discommission" required="required" tabindex="<?php echo $tabindex++; ?>">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="input-10" class="col-sm-2 col-form-label">Mini Commission <small>(In Amount)</small></label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="minicommission" name="minicommission" required="required" tabindex="<?php echo $tabindex++; ?>">
                    </div>
                  </div>


                  <div class="form-group row">
                    <input type="hidden" name="productid" class="form-control" id="productid">
                    <input type="hidden" name="productqty" class="form-control" id="productqty">
                  </div>

                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-body">
                        <label id="plabel">Select Product</label>
                        <div class="table-responsive">
                          <table class="table">
                            <thead class="thead-light">
                              <tr>
                                <th scope="col">SR.</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">MRP</th>
                                <th scope="col">QTY</th>
                                <th scope="col">Add/Update</th>
                                <th scope="col">Delete</th>
                              </tr>
                            </thead>
                            <tbody>
                              
                                <?php
                                  $sr=1;
                                  foreach ($productlist as $rs) 
                                  {
                                    $id=$rs['id'];
                                  ?>
                                  <tr>
                                    <th scope="row"><?php echo $sr++; ?></th>
                                    <td><?php echo $pname=$rs['productname'];?></td>
                                    <td><?php echo $mrp=$rs['mrp'];?></td>
                                    <td>
                                      <input type='number' class='form-control mainqty<?php echo $id; ?>' value='0' placeholder='Enter Quantity' name='qty<?php echo $id; ?>' id='qty<?php echo $id; ?>'>
                                    </td>
                                    <td>
                                      <button type="button" class="btn btn-primary waves-effect waves-light m-1 cursor addtokit" name='add<?php echo $id; ?>' id='add<?php echo $id; ?>' value='Add' pid='<?php echo $id; ?>' mrp='<?php echo $mrp; ?>'> <i class="fa fa-cart-plus"></i> <span id="spans<?php echo $id; ?>">Add</span> </button>
                                    </td>
                                    <td>
                                      <button type="button" class="btn btn-danger waves-effect waves-light m-1 cursor deletekit" name='delete<?php echo $id; ?>' id='delete<?php echo $id; ?>' pid='<?php echo $id; ?>' mrp='<?php echo $mrp; ?>'><i class="fa fa fa-trash-o"></i> <span>Delete</span></button>
                                    </td>
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
                                    
                  <div class="form-footer">
                      <button type="submit" class="btn btn-success" tabindex="<?php echo $tabindex++; ?>" id="submit"><i class="fa fa-check-square-o"></i> SAVE</button>
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
    var base_url='<?php echo base_url();?>';
    var AdminUrl= '<?php echo $AdminUrl;?>';
    var formid="CreateKit";
    var submiturl = AdminUrl+"ProductKit/Insert";
    var confirmbox = true;
    var reporturl = AdminUrl+"ProductKit";
    var buttonsStyling = false;
    var confirmoktxt = 'Yes!';
    var confirmtxt = 'You Want To <?php echo $franchText; ?> Kit!';
    var submittxt = 'Kit <?php echo $franchText; ?> Successfully.';
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
<script type="text/javascript" src="<?php  echo $this->config->item('base_url');?>assets/js/custom/admin/createkit.js"></script>
<script type="text/javascript" src="<?php  echo $this->config->item('base_url');?>assets/js/custom/admin/submit.js"></script>
