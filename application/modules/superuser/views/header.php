<header class="topbar-nav">
  <nav class="navbar navbar-expand fixed-top bg-white">
    <ul class="navbar-nav mr-auto align-items-center">
      <li class="nav-item">
        <a class="nav-link toggle-menu" href="javascript:void();">
         <i class="fa fa-bars menu-icon"></i>
       </a>
      </li>
      <li class="nav-item"></li>
    </ul>
    <?php
    /*$adminLoggedIn = $this->session->userdata('adminLoggedIn');
    $adminuserid=$adminLoggedIn['userid'];
    if($adminuserid <'3')
    {
    ?>
    <ul class="navbar-nav align-items-center right-nav-link">
      <?php
      	$pincount=0;
      	$queryds="SELECT count(*) as 'pin' FROM `mlm_pinrequest` where status='0'";
				$resultSelectss = DirectQuery($queryds);
				$vre = $resultSelectss->result();
				if(count($vre) > 0) {
					$datad=$resultSelectss->result_array();
					$pincount=$datad[0]['pin'];
				}
      ?>
				<li class="nav-item dropdown-lg">
		      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
			    <i class="fa fa-pinterest-p"></i><span class="badge badge-danger badge-up"><?php echo $pincount; ?></span></a>
		      <div class="dropdown-menu dropdown-menu-right">
		        <ul class="list-group list-group-flush">
		         <li class="list-group-item d-flex justify-content-between align-items-center">
		          You have Pending Pin Request.
		          <span class="badge badge-danger"><?php echo  $pincount; ?></span>
		         </li>
		         <li class="list-group-item"><a href="<?php echo $AdminUrl ?>PinRequest/PinRequestReport/0">See All Request</a></li>
		        </ul>
		      </div>
		    </li>

		   <?php
      	$walletcount=0;
      	$queryds="SELECT count(*) as 'pin' FROM `mlm_walletorder` where status='0'";
				$resultSelectss = DirectQuery($queryds);
				$vre = $resultSelectss->result();
				if(count($vre) > 0) {
					$datad=$resultSelectss->result_array();
					$walletcount=$datad[0]['pin'];
				}
      ?>
				<li class="nav-item dropdown-lg">
		      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
			    <i class="fa fa-inr"></i><span class="badge badge-danger badge-up"><?php echo $walletcount; ?></span></a>
		      <div class="dropdown-menu dropdown-menu-right">
		        <ul class="list-group list-group-flush">
		         <li class="list-group-item d-flex justify-content-between align-items-center">
		          You have Pending Wallet Request.
		          <span class="badge badge-danger"><?php echo  $walletcount; ?></span>
		         </li>
		         <li class="list-group-item"><a href="<?php echo $AdminUrl ?>Wallet/WalletReport/0">See All Request</a></li>
		        </ul>
		      </div>
		    </li>

		    <?php
      	$activepurchasecount=0;
      	$queryds="SELECT count(*) as 'pin' FROM `mlm_invoicemaster` where status='1' and activepurchase='1' and ordertype='MP'";
				$resultSelectss = DirectQuery($queryds);
				$vre = $resultSelectss->result();
				if(count($vre) > 0) {
					$datad=$resultSelectss->result_array();
					$activepurchasecount=$datad[0]['pin'];
				}
      ?>
				<li class="nav-item dropdown-lg">
		      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
			    <i class="fa fa-shopping-bag"></i><span class="badge badge-danger badge-up"><?php echo $activepurchasecount; ?></span></a>
		      <div class="dropdown-menu dropdown-menu-right">
		        <ul class="list-group list-group-flush">
		         <li class="list-group-item d-flex justify-content-between align-items-center">
		          You have Pending Activation Purchase.
		          <span class="badge badge-danger"><?php echo  $activepurchasecount; ?></span>
		         </li>
		         <li class="list-group-item"><a href="<?php echo $AdminUrl ?>Memberstock/ActivationInvoice/1">See All Request</a></li>
		        </ul>
		      </div>
		    </li>

		     <?php
      	$purchasecount=0;
      	$queryds="SELECT count(*) as 'pin' FROM `mlm_invoicemaster` where status='1' and activepurchase='0' and ordertype='MP'";
				$resultSelectss = DirectQuery($queryds);
				$vre = $resultSelectss->result();
				if(count($vre) > 0) {
					$datad=$resultSelectss->result_array();
					$purchasecount=$datad[0]['pin'];
				}
      ?>
				<li class="nav-item dropdown-lg">
		      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
			    <i class="fa fa-shopping-cart"></i><span class="badge badge-danger badge-up"><?php echo $purchasecount; ?></span></a>
		      <div class="dropdown-menu dropdown-menu-right">
		        <ul class="list-group list-group-flush">
		         <li class="list-group-item d-flex justify-content-between align-items-center">
		          You have Pending Re-Purchase Request.
		          <span class="badge badge-danger"><?php echo  $purchasecount; ?></span>
		         </li>
		         <li class="list-group-item"><a href="<?php echo $AdminUrl ?>Memberstock/index/1">See All Request</a></li>
		        </ul>
		      </div>
		    </li>

		   <?php
      	$withdrawcount=0;
      	$queryds="SELECT count(*) as 'pin' FROM `mlm_withdrawalreq` where status='0'";
				$resultSelectss = DirectQuery($queryds);
				$vre = $resultSelectss->result();
				if(count($vre) > 0) {
					$datad=$resultSelectss->result_array();
					$withdrawcount=$datad[0]['pin'];
				}
      ?>
				<li class="nav-item dropdown-lg">
		      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
			    <i class="fa fa-bell"></i><span class="badge badge-danger badge-up"><?php echo $withdrawcount; ?></span></a>
		      <div class="dropdown-menu dropdown-menu-right">
		        <ul class="list-group list-group-flush">
		         <li class="list-group-item d-flex justify-content-between align-items-center">
		          You have Pending Withdrawal Request.
		          <span class="badge badge-danger"><?php echo  $withdrawcount; ?></span>
		         </li>
		         <li class="list-group-item"><a href="<?php echo $AdminUrl ?>Withdrawal/Report/0">See All Request</a></li>
		        </ul>
		      </div>
		    </li>

		    <?php
      	$kyccount=0;
      	$queryds="SELECT count(*) as 'pin' FROM `mlm_memberdocument` where status='0'";
				$resultSelectss = DirectQuery($queryds);
				$vre = $resultSelectss->result();
				if(count($vre) > 0) {
					$datad=$resultSelectss->result_array();
					$kyccount=$datad[0]['pin'];
				}
      ?>
				<li class="nav-item dropdown-lg">
		      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
			    <i class="fa fa-camera"></i><span class="badge badge-danger badge-up"><?php echo $kyccount; ?></span></a>
		      <div class="dropdown-menu dropdown-menu-right">
		        <ul class="list-group list-group-flush">
		         <li class="list-group-item d-flex justify-content-between align-items-center">
		          You have Pending KYC Request.
		          <span class="badge badge-danger"><?php echo  $kyccount; ?></span>
		         </li>
		         <li class="list-group-item"><a href="<?php echo $AdminUrl ?>KYCList/KYCReport">See All Request</a></li>
		        </ul>
		      </div>
		    </li>


		     <?php
      	$supportcount=0;
      	$queryds="SELECT count(*) as 'pin' FROM `mlm_support` where view='0' and source!='admin'";
				$resultSelectss = DirectQuery($queryds);
				$vre = $resultSelectss->result();
				if(count($vre) > 0) {
					$datad=$resultSelectss->result_array();
					$supportcount=$datad[0]['pin'];
				}
      ?>
				<li class="nav-item dropdown-lg">
		      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
			    <i class="fa fa-ticket"></i><span class="badge badge-danger badge-up"><?php echo $supportcount; ?></span></a>
		      <div class="dropdown-menu dropdown-menu-right">
		        <ul class="list-group list-group-flush">
		         <li class="list-group-item d-flex justify-content-between align-items-center">
		          You have Pending Support Ticket.
		          <span class="badge badge-danger"><?php echo  $supportcount; ?></span>
		         </li>
		         <li class="list-group-item"><a href="<?php echo $AdminUrl ?>Support/CurrentTicketReport">See All Request</a></li>
		        </ul>
		      </div>
		    </li>
    </ul>
    <?php
  	}*/
  	?>
  </nav>
</header>
<div class="clearfix"></div>