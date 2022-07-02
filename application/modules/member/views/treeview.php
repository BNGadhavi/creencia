<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

	include_once 'head.php';

	include_once 'sidebar.php';

	include_once 'header.php';

?>
<link href="<?php echo base_url(); ?>assets/css/genealogy.css" rel="stylesheet"/>

<div class="content-wrapper">

	<div class="container-fluid">

		<div class="row">

        <div class="col-lg-12">

          <div class="card">

            <div class="card-body" style="overflow-x: scroll;">

              <h4 class="form-header text-uppercase">
                <i class="fa fa-address-book-o"></i>
                 Genealogy
              </h4>

              <div class="row">
                <div class="col-lg-3" style="margin-bottom: 20px;">
                    <?php 
                    if($selfid!=$loginid){
                    ?>
                    <a class="btn btn-s-md btn-primary btn-rounded" href="<?php echo $uplineid; ?>">UP</a>
                    <a class="btn btn-s-md btn-info btn-rounded" href="<?php echo $loginid; ?>">Me</a>
                    <?php } ?>
                </div>
                <div class="col-lg-4" style="margin-bottom: 20px; ">
                    <form id="searchgen" action="#" method="post">
                      
                      <div class="form-group row">
                        <div class="col-sm-9">
                          <div class="input-group mb-3 errorafter">
                            <input type="text" class="form-control" id="downid" name="downid" placeholder="Downline UserId">
                            <div class="input-group-append">
                              <button class="btn btn-outline-primary" type="submit" style="cursor: pointer;">Submit</button>
                            </div>
                          </div>
                        </div>
                      </div>

                    </form>
                </div>
                <div class="col-lg-5" style="margin-bottom: 20px;">
                    <input type="image" src="<?php echo base_url(); ?>assets/images/TreeView/active.png" style="height:35px;width:40px;border-width:0px;">  Active &nbsp;
                    <!-- <input type="image" src="<?php echo base_url(); ?>assets/images/TreeView/repactive.png" style="height:35px;width:40px;border-width:0px;">  Repurchase &nbsp; -->
                    <input type="image" src="<?php echo base_url(); ?>assets/images/TreeView/inactive.png" style="height:35px;width:40px;border-width:0px;">  InActive &nbsp;
                    
                    <input type="image" src="<?php echo base_url(); ?>assets/images/TreeView/blank.png" style="height:35px;width:40px;border-width:0px;">  No Member &nbsp;
                </div>
              </div>

              <table border="0" align="center" cellspacing="0" cellpadding="0" width="90%" id="loaderid">
                <tbody>
                  <tr>
                    <td colspan="16" align="center" style="width: 100%;">
                      <input data-toggle="popover" <?php echo treeviewattr($selfid); ?> data-trigger="hover" data-container="body" data-placement="right" data-html="true" id="" type="image" name=""  src="<?php echo base_url(); ?>assets/images/TreeView/<?php echo treeviewmemberid($treeDatauser, '0', '0', 'image'); ?>" style="height:35px;width:40px;border-width:0px;">
                      <?php echo treeviewpopupdiv($selfid); ?>
                      <br>
                      <a href="#" style="
font-family:Verdana;font-size:Small;font-weight:normal;text-decoration:none;font-weight: 700"><?php echo treeviewmemberid($treeDatauser, '0', '0', 'username'); ?></a> <br>
                      <a href="#" style="
font-family:Verdana;font-size:Small;font-weight:normal;text-decoration:none;font-weight: 700"><?php echo treeviewmemberid($treeDatauser, '0', '0', 'name'); ?></a>
                      <div class="ajax__balloon_popup" style="display: none; position: absolute; visibility: hidden;"><span class="rect"><span class=" large">
                        <div class="rect large bottom_right_shadow">
                          <div class="rect large bottom_right">
                            <div class="ajax__content"></div>
                          </div>
                        </div>
                        </span></span></div>
                        
                      </div>

                    </td>
                  </tr>
                  <tr style="height: 2%;">
                    <td align="center" style="width: 22.5%;" colspan="4">&nbsp;</td>
                    <td align="center" style="border-width: medium; border-color: #CC0099; border-radius: 20px 0 0 0; width: 22.5%; border-top-style: solid; border-left-style: solid;" colspan="4">&nbsp;</td>
                    <td align="center" style="border-width: medium; border-color: #CC0099; border-radius: 0 20px 0 0; width: 22.5%; border-top-style: solid; border-right-style: solid;" colspan="4">&nbsp;</td>
                    <td align="center" style="width: 22.5%;" colspan="4">&nbsp;</td>
                  </tr>
                  <tr align="center">
                    <?php $memberl = treeviewmemberid($treeData, $selfid, '0', 'userid'); ?>
                    <td align="center" colspan="8" class="style9" style="width: 45%;">
                      
                      <input  type="image" <?php echo treeviewattr($memberl); ?> src="<?php echo base_url(); ?>assets/images/TreeView/<?php echo treeviewmemberid($treeData, $selfid, '0', 'image') ?>" style="height:35px;width:40px;border-width:0px;">
                      <br>
                      <?php echo treeviewpopupdiv($memberl); ?>
                      <a href="#" onclick="newredirectfun('<?php echo $memberl; ?>','<?php echo $selfid ?>','left');" style="
font-family:Verdana;font-size:Small;font-weight:normal;text-decoration:none;font-weight: 700"><?php echo treeviewmemberid($treeData, $selfid, '0', 'username'); ?></a> <br>
                      <a href="#" onclick="newredirectfun('<?php echo $memberl; ?>','<?php echo $selfid ?>','left');" style="
font-family:Verdana;font-size:Small;font-weight:normal;text-decoration:none;font-weight: 700"><?php echo treeviewmemberid($treeData, $selfid, '0', 'name'); ?></a> <br>
                      <div class="ajax__balloon_popup" style="display: none; position: absolute; visibility: hidden;"><span class="rect"><span class=" large">
                        <div class="rect large bottom_right_shadow">
                          <div class="rect large bottom_right">
                            <div class="ajax__content"></div>
                          </div>
                        </div>
                        </span></span></div></td>
                        <?php $memberr = treeviewmemberid($treeData, $selfid, '2', 'userid'); ?>
                    <td colspan="8" align="center" class="style9" style="width: 45%">
                      <?php echo treeviewpopupdiv($memberr); ?>
                      <input type="image" <?php echo treeviewattr($memberr); ?> src="<?php echo base_url(); ?>assets/images/TreeView/<?php echo treeviewmemberid($treeData, $selfid, '2', 'image'); ?>" style="height:35px;width:40px;border-width:0px;">
                      <br>
                      <a href="#" onclick="newredirectfun('<?php echo $memberr; ?>','<?php echo $selfid ?>','right');" style="
font-family:Verdana;font-size:Small;font-weight:normal;text-decoration:none;font-weight: 700"><?php echo treeviewmemberid($treeData, $selfid, '2', 'username'); ?></a> <br>
                      <a href="#" onclick="newredirectfun('<?php echo $memberr; ?>','<?php echo $selfid ?>','right');" style="
font-family:Verdana;font-size:Small;font-weight:normal;text-decoration:none;font-weight: 700"><?php echo treeviewmemberid($treeData, $selfid, '2', 'name');; ?></a> <br>
                      <div class="ajax__balloon_popup" style="display: none; position: absolute; visibility: hidden;"><span class="rect"><span class=" large">
                        <div class="rect large bottom_left_shadow">
                          <div class="rect large bottom_left">
                            <div class="ajax__content"></div>
                          </div>
                        </div>
                        </span></span></div></td>
                  </tr>
                  <tr style="height: 2%;">
                    <td align="center" style="width: 11.25%;" colspan="2">&nbsp;</td>
                    <td align="center" style="border-width: medium; border-color: #CC0099; width: 11.25%;
                                  border-top-style: solid; border-radius: 20px 0 0 0; border-left-style: solid;" colspan="2">&nbsp;</td>
                    <td align="center" style="border-width: medium; border-color: #CC0099; border-radius: 0 20px 0 0;
                                  width: 11.25%; border-top-style: solid; border-right-style: solid;" colspan="2">&nbsp;</td>
                    <td align="center" style="width: 11.25%;" colspan="2">&nbsp;</td>
                    <td align="center" style="width: 11.25%;" colspan="2">&nbsp;</td>
                    <td align="center" style="border-width: medium; border-color: #CC0099; border-radius: 20px 0 0 0; width: 11.25%; border-top-style: solid; border-left-style: solid;" colspan="2">&nbsp;</td>
                    <td align="center" style="border-width: medium; border-color: #CC0099; border-radius: 0 20px 0 0; width: 11.25%; border-top-style: solid; border-right-style: solid;" colspan="2">&nbsp;</td>
                    <td align="center" style="width: 11.25%;" colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <?php $memberll = treeviewmemberid($treeData, $memberl, '0', 'userid'); ?>
                    <td align="center" colspan="4" class="style10" style="width: 22.5%;">
                      <?php echo treeviewpopupdiv($memberll); ?>
                      <input type="image" <?php echo treeviewattr($memberll); ?> src="<?php echo base_url(); ?>assets/images/TreeView/<?php echo treeviewmemberid($treeData, $memberl, '0', 'image'); ?>" style="height:35px;width:40px;border-width:0px;">
                      <br>
                      <a href="#" onclick="newredirectfun('<?php echo $memberll; ?>','<?php echo $memberl ?>','left');" style="
font-family:Verdana;font-size:Small;font-weight:normal;text-decoration:none;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberl, '0', 'username'); ?></a> <br>
                      <a href="#" onclick="newredirectfun('<?php echo $memberll; ?>','<?php echo $memberl ?>','left');" style="
font-family:Verdana;font-size:Small;font-weight:normal;text-decoration:none;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberl, '0', 'name'); ?></a>
                      <div class="ajax__balloon_popup" style="display: none; position: absolute; visibility: hidden;"><span class="rect"><span class=" large">
                        <div class="rect large top_right_shadow">
                          <div class="rect large top_right">
                            <div class="ajax__content"></div>
                          </div>
                        </div>
                        </span></span></div></td>
                    <?php $memberlr = treeviewmemberid($treeData, $memberl, '2', 'userid'); ?>
                    <td align="center" colspan="4"  class="style10" style="width: 22.5%;">&nbsp;
                       <?php echo treeviewpopupdiv($memberlr); ?>
                      <input type="image" <?php echo treeviewattr($memberlr); ?> src="<?php echo base_url(); ?>assets/images/TreeView/<?php echo treeviewmemberid($treeData, $memberl, '2', 'image'); ?>" style="height:35px;width:40px;border-width:0px;">
                      <br>
                      <a href="#" onclick="newredirectfun('<?php echo $memberlr; ?>','<?php echo $memberl ?>','right');" style="
font-family:Verdana;font-size:Small;font-weight:normal;text-decoration:none;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberl, '2', 'username'); ?></a> <br>
                      <a href="#" onclick="newredirectfun('<?php echo $memberlr; ?>','<?php echo $memberl ?>','right');" style="
font-family:Verdana;font-size:Small;font-weight:normal;text-decoration:none;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberl, '2', 'name'); ?></a> <br>
                      <div class="ajax__balloon_popup" style="display: none; position: absolute; visibility: hidden;"><span class="rect"><span class=" large">
                        <div class="rect large top_left_shadow">
                          <div class="rect large top_left">
                            <div class="ajax__content"></div>
                          </div>
                        </div>
                        </span></span></div></td>
                    <?php $memberrl = treeviewmemberid($treeData, $memberr, '0', 'userid'); ?>
                    <td align="center" colspan="4" class="style10" style="width: 22.5%;">
                      <?php echo treeviewpopupdiv($memberrl); ?>
                      <input  type="image" <?php echo treeviewattr($memberrl); ?> src="<?php echo base_url(); ?>assets/images/TreeView/<?php echo treeviewmemberid($treeData, $memberr, '0', 'image'); ?>" style="height:35px;width:40px;border-width:0px;">
                      <br>
                      <a href="#" onclick="newredirectfun('<?php echo $memberrl; ?>','<?php echo $memberr ?>','left');" style="
font-family:Verdana;font-size:Small;font-weight:normal;text-decoration:none;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberr, '0', 'username'); ?></a> <br>
                      <a href="#" onclick="newredirectfun('<?php echo $memberrl; ?>','<?php echo $memberr ?>','left');" style="
font-family:Verdana;font-size:Small;font-weight:normal;text-decoration:none;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberr, '0', 'name'); ?></a> <br>
                      <div class="ajax__balloon_popup" style="display: none; position: absolute; visibility: hidden;"><span class="rect"><span class=" large">
                        <div class="rect large top_left_shadow">
                          <div class="rect large top_left">
                            <div class="ajax__content"></div>
                          </div>
                        </div>
                        </span></span></div></td>
                        <?php $memberrr = treeviewmemberid($treeData, $memberr, '2', 'userid'); ?>
                    <td align="center" colspan="4" class="style10" style="width: 22.5%;">
                      <?php echo treeviewpopupdiv($memberrr); ?>
                      <input  type="image" <?php echo treeviewattr($memberrr); ?> src="<?php echo base_url(); ?>assets/images/TreeView/<?php echo treeviewmemberid($treeData, $memberr, '2', 'image'); ?>" style="height:35px;width:40px;border-width:0px;">
                      <br>
                      <a href="#" onclick="newredirectfun('<?php echo $memberrr; ?>','<?php echo $memberr ?>','right');" style="
font-family:Verdana;font-size:Small;font-weight:normal;text-decoration:none;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberr, '2', 'username'); ?></a> <br>
                      <a onclick="newredirectfun('<?php echo $memberrr; ?>','<?php echo $memberr ?>','right');" href="#" style="
font-family:Verdana;font-size:Small;font-weight:normal;text-decoration:none;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberr, '2', 'name'); ?></a> <br>
                      <div id="ctl00_ContentPlaceHolder11_BalloonPopupExtender8_balloonPopup" class="ajax__balloon_popup" style="display: none; position: absolute; visibility: hidden;"><span class="rect"><span class=" large">
                        <div class="rect large top_left_shadow">
                          <div class="rect large top_left">
                            <div class="ajax__content"></div>
                          </div>
                        </div>
                        </span></span></div></td>
                  </tr>
                  <tr>
                    <td class="style12" style="width: 5.63%;"></td>
                    <td style="border-width: medium; border-color: #CC0099; border-top-style: solid;
                                  border-radius: 20px 0 0 0; border-left-style: solid;" class="style12"></td>
                    <td style="border-width: medium; border-color: #CC0099; border-top-style: solid;
                                  border-right-style: solid; border-radius: 0 20px 0 0;" class="style12"></td>
                    <td class="style12" style="width: 5.63%;"></td>
                    <td class="style12" style="width: 5.63%;"></td>
                    <td style="border-width: medium; border-color: #CC0099; border-radius: 20px 0 0 0;
                                  border-top-style: solid; border-left-style: solid;" class="style12"></td>
                    <td style="border-width: medium; border-color: #CC0099; border-radius: 0 20px 0 0;
                                  border-top-style: solid; border-right-style: solid;" class="style12"></td>
                    <td class="style12" style="width: 5.63%;"></td>
                    <td class="style12" style="width: 5.63%;"></td>
                    <td style="border-width: medium; border-color: #CC0099; border-top-style: solid;
                                  border-left-style: solid; border-radius: 20px 0 0 0;" class="style12"></td>
                    <td style="border-width: medium; border-color: #CC0099; border-top-style: solid;
                                  border-right-style: solid; border-radius: 0 20px 0 0;" class="style12"></td>
                    <td class="style12" style="width: 5.63%;"></td>
                    <td class="style12" style="width: 5.63%;"></td>
                    <td style="border-width: medium; border-color: #CC0099; border-top-style: solid;
                                  border-radius: 20px 0 0 0; border-left-style: solid;" class="style12"></td>
                    <td style="border-width: medium; border-color: #CC0099; border-top-style: solid;
                                  border-right-style: solid; border-radius: 0 20px 0 0;" class="style12"></td>
                    <td class="style12" style="width: 5.63%;"></td>
                  </tr>
                  <?php $memberlll = treeviewmemberid($treeData, $memberll, '0', 'userid'); ?>
                  <tr>
                    <td colspan="2" align="center" class="style11" style="width: 11.25%;">
                      <?php echo treeviewpopupdiv($memberlll); ?>
                      <input type="image" <?php echo treeviewattr($memberlll); ?> src="<?php echo base_url(); ?>assets/images/TreeView/<?php echo treeviewmemberid($treeData, $memberll, '0', 'image'); ?>" style="height:35px;width:40px;border-width:0px;">
                      <br>
                      <a href="#" onclick="newredirectfun('<?php echo $memberlll; ?>','<?php echo $memberll ?>','left');" style="
font-family:Verdana;font-size:Small;font-weight:normal;text-decoration:none;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberll, '0', 'username'); ?></a> <br>
                      <a href="#" onclick="newredirectfun('<?php echo $memberlll; ?>','<?php echo $memberll ?>','left');" style="
font-family:Verdana;font-size:Small;font-weight:normal;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberll, '0', 'name'); ?></a>
                      <div id="ctl00_ContentPlaceHolder11_BalloonPopupExtender9_balloonPopup" class="ajax__balloon_popup" style="display: none; position: absolute; visibility: hidden;"><span class="rect"><span class=" large">
                        <div class="rect large top_right_shadow">
                          <div class="rect large top_right">
                            <div class="ajax__content"></div>
                          </div>
                        </div>
                        </span></span></div></td>
                        <?php $memberllr = treeviewmemberid($treeData, $memberll, '2', 'userid'); ?>
                    <td colspan="2" align="center" class="style11" style="width: 11.25%;">
                      <?php echo treeviewpopupdiv($memberllr); ?>
                      <input   type="image" <?php echo treeviewattr($memberllr); ?> src="<?php echo base_url(); ?>assets/images/TreeView/<?php echo treeviewmemberid($treeData, $memberll, '2', 'image'); ?>" style="height:35px;width:40px;border-width:0px;">
                      <br>
                      <a  href="#" onclick="newredirectfun('<?php echo $memberllr; ?>','<?php echo $memberll ?>','right');" style="
font-family:Verdana;font-size:Small;font-weight:normal;text-decoration:none;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberll, '2', 'username'); ?></a> <br>
                      <a href="#" onclick="newredirectfun('<?php echo $memberllr; ?>','<?php echo $memberll ?>','right');" style="
font-family:Verdana;font-size:Small;font-weight:normal;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberll, '2', 'name'); ?></a>
                      <div id="ctl00_ContentPlaceHolder11_BalloonPopupExtender10_balloonPopup" class="ajax__balloon_popup" style="display: none; position: absolute; visibility: hidden;"><span class="rect"><span class=" large">
                        <div class="rect large top_right_shadow">
                          <div class="rect large top_right">
                            <div class="ajax__content"></div>
                          </div>
                        </div>
                        </span></span></div></td>
                        <?php $memberlrl = treeviewmemberid($treeData, $memberlr, '0', 'userid'); ?>
                    <td colspan="2" align="center" class="style11" style="width: 11.25%;">
                      <?php echo treeviewpopupdiv($memberlrl); ?>
                      <input type="image" <?php echo treeviewattr($memberlrl); ?> src="<?php echo base_url(); ?>assets/images/TreeView/<?php echo treeviewmemberid($treeData, $memberlr, '0', 'image'); ?>" style="height:35px;width:40px;border-width:0px;">
                      <br>
                      <a onclick="newredirectfun('<?php echo $memberlrl; ?>','<?php echo $memberlr; ?>','left');"  href="#" style="
font-family:Verdana;font-size:Small;font-weight:normal;text-decoration:none;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberlr, '0', 'username'); ?></a> <br>
                      <a onclick="newredirectfun('<?php echo $memberlrl; ?>','<?php echo $memberlr; ?>','left');"  href="#" style="
font-family:Verdana;font-size:Small;font-weight:normal;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberlr, '0', 'name'); ?></a>
                      <div id="ctl00_ContentPlaceHolder11_BalloonPopupExtender11_balloonPopup" class="ajax__balloon_popup" style="display: none; position: absolute; visibility: hidden;"><span class="rect"><span class=" large">
                        <div class="rect large top_right_shadow">
                          <div class="rect large top_right">
                            <div class="ajax__content"></div>
                          </div>
                        </div>
                        </span></span></div></td>
                        <?php $memberlrr = treeviewmemberid($treeData, $memberlr, '2', 'userid'); ?>
                    <td colspan="2" align="center" class="style11" style="width: 11.25%;">
                      <?php echo treeviewpopupdiv($memberlrr); ?>
                      <input type="image" <?php echo treeviewattr($memberlrr); ?> src="<?php echo base_url(); ?>assets/images/TreeView/<?php echo treeviewmemberid($treeData, $memberlr, '2', 'image'); ?>" style="height:35px;width:40px;border-width:0px;">
                      <br>
                      <a href="#" onclick="newredirectfun('<?php echo $memberlrr; ?>','<?php echo $memberlr; ?>','right');" style="
font-family:Verdana;font-size:Small;font-weight:normal;text-decoration:none;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberlr, '2', 'username'); ?></a> <br>
                      <a href="#" onclick="newredirectfun('<?php echo $memberlrr; ?>','<?php echo $memberlr; ?>','right');" style="
font-family:Verdana;font-size:Small;font-weight:normal;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberlr, '2', 'name'); ?></a>
                      <div id="ctl00_ContentPlaceHolder11_BalloonPopupExtender12_balloonPopup" class="ajax__balloon_popup" style="display: none; position: absolute; visibility: hidden;"><span class="rect"><span class=" large">
                        <div class="rect large top_left_shadow">
                          <div class="rect large top_left">
                            <div class="ajax__content"></div>
                          </div>
                        </div>
                        </span></span></div></td>
                        <?php $memberrll = treeviewmemberid($treeData, $memberrl, '0', 'userid'); ?>
                    <td colspan="2" align="center" class="style11" style="width: 11.25%;">
                      <?php echo treeviewpopupdiv($memberrll); ?>
                      <input type="image" <?php echo treeviewattr($memberrll); ?> src="<?php echo base_url(); ?>assets/images/TreeView/<?php echo treeviewmemberid($treeData, $memberrl, '0', 'image'); ?>" style="height:35px;width:40px;border-width:0px;">
                      <br>
                      <a href="#" onclick="newredirectfun('<?php echo $memberrll; ?>','<?php echo $memberrl; ?>','left');" style="
font-family:Verdana;font-size:Small;font-weight:normal;text-decoration:none;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberrl, '0', 'username'); ?></a> <br>
                      <a href="#" onclick="newredirectfun('<?php echo $memberrll; ?>','<?php echo $memberrl; ?>','left');" style="
font-family:Verdana;font-size:Small;font-weight:normal;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberrl, '0', 'name'); ?></a>
                      <div id="ctl00_ContentPlaceHolder11_BalloonPopupExtender13_balloonPopup" class="ajax__balloon_popup" style="display: none; position: absolute; visibility: hidden;"><span class="rect"><span class=" large">
                        <div class="rect large top_left_shadow">
                          <div class="rect large top_left">
                            <div class="ajax__content"></div>
                          </div>
                        </div>
                        </span></span></div></td>
                        <?php $memberrlr = treeviewmemberid($treeData, $memberrl, '2', 'userid'); ?>
                    <td colspan="2" align="center" class="style11" style="width: 11.25%;">
                      <?php echo treeviewpopupdiv($memberrlr); ?>
                      <input  type="image" <?php echo treeviewattr($memberrlr); ?> src="<?php echo base_url(); ?>assets/images/TreeView/<?php echo treeviewmemberid($treeData, $memberrl, '2', 'image'); ?>" style="height:35px;width:40px;border-width:0px;">
                      <br>
                      <a href="#" onclick="newredirectfun('<?php echo $memberrlr; ?>','<?php echo $memberrl; ?>','right');" style="
font-family:Verdana;font-size:Small;font-weight:normal;text-decoration:none;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberrl, '2', 'username'); ?></a> <br>
                      <a onclick="newredirectfun('<?php echo $memberrlr; ?>','<?php echo $memberrl; ?>','right');" href="#" style="
font-family:Verdana;font-size:Small;font-weight:normal;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberrl, '2', 'name'); ?></a>
                      <div id="ctl00_ContentPlaceHolder11_BalloonPopupExtender14_balloonPopup" class="ajax__balloon_popup" style="display: none; position: absolute; visibility: hidden;"><span class="rect"><span class=" large">
                        <div class="rect large top_left_shadow">
                          <div class="rect large top_left">
                            <div class="ajax__content"></div>
                          </div>
                        </div>
                        </span></span></div></td>
                        <?php $memberrrl = treeviewmemberid($treeData, $memberrr, '0', 'userid'); ?>
                    <td colspan="2" align="center" class="style11" style="width: 11.25%;">
                      <?php echo treeviewpopupdiv($memberrrl); ?>
                      <input    type="image" <?php echo treeviewattr($memberrrl); ?> src="<?php echo base_url(); ?>assets/images/TreeView/<?php echo treeviewmemberid($treeData, $memberrr, '0', 'image'); ?>" style="height:35px;width:40px;border-width:0px;">
                      <br>
                      <a href="#" onclick="newredirectfun('<?php echo $memberrrl; ?>','<?php echo $memberrr; ?>','left');" style="
font-family:Verdana;font-size:Small;font-weight:normal;text-decoration:none;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberrr, '0', 'username'); ?></a> <br>
                      <a href="#" onclick="newredirectfun('<?php echo $memberrrl; ?>','<?php echo $memberrr; ?>','left');" style="
font-family:Verdana;font-size:Small;font-weight:normal;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberrr, '0', 'name'); ?></a>
                      <div id="ctl00_ContentPlaceHolder11_BalloonPopupExtender15_balloonPopup" class="ajax__balloon_popup" style="display: none; position: absolute; visibility: hidden;"><span class="rect"><span class=" large">
                        <div class="rect large top_left_shadow">
                          <div class="rect large top_left">
                            <div class="ajax__content"></div>
                          </div>
                        </div>
                        </span></span></div></td>
                        <?php $memberrrr = treeviewmemberid($treeData, $memberrr, '2', 'userid'); ?>
                    <td colspan="2" align="center" class="style11" style="width: 11.25%;">
                     <?php echo treeviewpopupdiv($memberrrr); ?>
                      <input type="image" <?php echo treeviewattr($memberrrr); ?> src="<?php echo base_url(); ?>assets/images/TreeView/<?php echo treeviewmemberid($treeData, $memberrr, '2', 'image'); ?>" style="height:35px;width:40px;border-width:0px;">
                      <br>
                      <a href="#" onclick="newredirectfun('<?php echo $memberrrr; ?>','<?php echo $memberrr; ?>','right');" style="
font-family:Verdana;font-size:Small;font-weight:normal;text-decoration:none;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberrr, '2', 'username'); ?></a> <br>
                      <a href="#" onclick="newredirectfun('<?php echo $memberrrr; ?>','<?php echo $memberrr; ?>','right');" style="
font-family:Verdana;font-size:Small;font-weight:normal;font-weight: 700"><?php echo treeviewmemberid($treeData, $memberrr, '2', 'name'); ?></a>
                      <div id="ctl00_ContentPlaceHolder11_BalloonPopupExtender2_balloonPopup" class="ajax__balloon_popup" style="display: none; position: absolute; visibility: hidden;"><span class="rect"><span class=" large">
                        <div class="rect large top_left_shadow">
                          <div class="rect large top_left">
                            <div class="ajax__content"></div>
                          </div>
                        </div>
                        </span></span></div></td>
                  </tr>
                  <tr>
                    <td align="center" class="style11"><br>
                      <br></td>
                    <td align="center" class="style11"><br>
                      <br></td>
                    <td align="center" class="style11"><br>
                      <br></td>
                    <td align="center" class="style11"><br>
                      <br></td>
                    <td align="center" class="style11"><br>
                      <br></td>
                    <td align="center" class="style11"><br>
                      <br></td>
                    <td align="center" class="style11"><br>
                      <br></td>
                    <td align="center" class="style11"><br>
                      <br></td>
                    <td align="center" class="style11"><br>
                      <br></td>
                    <td align="center" class="style11"><br>
                      <br></td>
                    <td align="center" class="style11"><br>
                      <br></td>
                    <td align="center" class="style11"><br>
                      <br></td>
                    <td align="center" class="style11"><br>
                      <br></td>
                    <td align="center" class="style11"><br>
                      <br></td>
                    <td align="center" class="style11"><br>
                      <br></td>
                    <td align="center" class="style11"><br>
                      <br></td>
                  </tr>
                </tbody>
            </table>



            </div>

          </div>

        </div>

      </div><!--End Row-->

	</div>

</div>

<?php include_once 'footer.php'; ?>

<?php include_once 'js.php'; ?>

<script type="text/javascript">
  var memberurl = '<?php echo $member_url; ?>';

  $("[data-toggle=popover]").each(function(i, obj) {
    $(this).popover({
      html: true,
      content: function() {
        var id = $(this).attr('id')
        return $('#popover-content-' + id).html();
      }
    });
  });

  function newredirectfun(currid,oldid,side){
    if(currid!='-'){
      var url = "<?php echo $member_url; ?>treeview/index/"+currid;
      window.location=url;
    }
  }

  var LoadingClass = '#loaderid';

  $.validator.addMethod( "checkdownid", function(value, element) {
      rtnstatus = false;

      $.ajax({
          url: memberurl+"treeview/checkdownid",
          async: false,
          type: "POST",
          data: "downid="+value,
          beforeSend: function() {
            ShowLoading(LoadingClass);
          },
          success: function(msg)
          {
            var response = $.parseJSON(msg);
            rtnstatus = response.status;
            if(rtnstatus) {
              downmemid = response.userid;
            }
            else {
              HideLoading(LoadingClass);
            }
            //HideLoading(LoadingClass);
          }
      });
      return rtnstatus;
  }, "Wrong Memberid.");

  var downmemid = 0;
  formbtnclick = false;

  $.validator.setDefaults({
      submitHandler: function() {
        if(!formbtnclick) {
          formbtnclick = true;    
          newredirectfun(downmemid, '-', '-');
        }
      }
  });

  $(document).ready(function() {
    $("#searchgen").validate({
      rules: {
        downid: {
            required: true,
            checkdownid: true,
        },
      },
      errorPlacement: function(error, element) {
        if (element.attr("name") == "downid" )
            error.insertAfter(".errorafter");
        else
            error.insertAfter(element);
      },
      
    });
  });
</script>