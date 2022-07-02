<?php
if (!isset($this->session->userdata['logged_in'])) {
	$redirection = base_url('login');
	header("location: $redirection");
}
$member_url=$this->config->item('GlobalMemberUrl');
$base_url=$this->config->item('base_url');
?>
<style type="text/css">
/*.sidebar-menu>li>a {
	padding: 13px 5px 13px 15px;
	display: block;
	border-left: 3px solid transparent;
	color:white!important;
	font-size: 15px;
}
.sidebar-menu .sidebar-submenu>li>a {
	padding: 5px 5px 5px 15px;
	display: block;
	font-size: 14px;
	color: white!important;
}*/
</style>
			<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
				<div class="brand-logo">
					<a href="<?php echo $member_url; ?>Dashboard">
						<center><h4><?php //echo GetCompanyName();?></h4><img src="<?php echo base_url(); ?>assets/web/images/logo.png" class="logo-icon" alt="logo icon" style='max-width: 100%'></center>
					</a>
				</div>
				<ul class="sidebar-menu do-nicescrol">
					<li class="sidebar-header">Menu</li>
					<li>
				        <a href="<?php echo $member_url; ?>Dashboard" class="waves-effect">
						<i class="fa fa-home"></i> <span>Dashboard</span>
						<small class="badge float-right badge-info"></small>
						</a>
				    </li>
				    <li>
				        <a href="javaScript:void();" class="waves-effect">
				          <i class="fa fa-home"></i> <span>Profile</span>
				          <i class="fa fa-angle-left float-right"></i>
				        </a>
				        <ul class="sidebar-submenu menu-open" >
					        <li><a href="<?php echo $member_url; ?>MemberProfile/WelcomeLetter"><i class="fa fa-circle-o"></i>Welcome Letter</a></li>
					        <li><a href="<?php echo $member_url; ?>MemberProfile"><i class="fa fa-circle-o"></i>Member Profile</a></li>
					        <li><a href="<?php echo $member_url; ?>ChangePassword"><i class="fa fa-circle-o"></i>Change Password</a></li>
					        <li><a href="<?php echo $member_url; ?>ChangePassword/ChangeTransactionPassword"><i class="fa fa-circle-o"></i>Change Transaction Password</a></li>
				    	</ul>
      				</li>
      				 <li class="">
				        <a href="javaScript:void();" class="waves-effect">
				          <i class="fa fa-home"></i> <span>KYC Upload</span>
				          <i class="fa fa-angle-left float-right"></i>
				        </a>
				        <ul class="sidebar-submenu menu-open" >
					      	<li><a href="<?php echo $member_url; ?>KYCUpload/NationalCard"><i class="fa fa-circle-o"></i>National ID Proof </a></li>
					 	</ul>
      				</li>
      				<li>
				        <a href="javaScript:void();" class="waves-effect">
				          <i class="fa fa-home"></i> <span>My Team</span>
				          <i class="fa fa-angle-left float-right"></i>
				        </a>
				       	<ul class="sidebar-submenu menu-open" >
				       		<li><a href="<?php echo $member_url; ?>TeamList"><i class="fa fa-circle-o"></i>Direct Associate</a></li>
				        	<li><a href="<?php echo $member_url; ?>TeamList/LevelWiseSummary"><i class="fa fa-circle-o"></i>LevelWise Summary</a></li>
				        	<li class="hide-div"><a href="<?php echo $member_url; ?>TeamList/DownlineSummary"><i class="fa fa-circle-o"></i>Downline Summary</a></li>
				        	<li class=""><a href="<?php echo $member_url; ?>TeamList/DownlineSummary?side=0"><i class="fa fa-circle-o"></i>Left Downline Summary</a></li>
				        	<li class=""><a href="<?php echo $member_url; ?>TeamList/DownlineSummary?side=2"><i class="fa fa-circle-o"></i>Right Downline Summary</a></li>
				        	<li class=""><a href="<?php echo $member_url; ?>TeamList/DownlineSummary"><i class="fa fa-circle-o"></i>All Downline Summary</a></li>
				        	<li><a href="<?php echo $member_url; ?>treeview"><i class="fa fa-circle-o"></i>Genealogy</a></li>
				        </ul>
      				</li>
      				

      				<li class="hide-div">
					    <a href="javaScript:void();" class="waves-effect">
					    <i class="fa fa-home"></i> <span>Internal Wallet Transfer</span>
				        <i class="fa fa-angle-left float-right"></i>
				        </a>
				        <ul class="sidebar-submenu menu-open" >
							<li><a href="<?php echo $member_url; ?>Wallet/IncomeWallettoRepurchase"><i class="fa fa-circle-o"></i>Income To Repurchase Transfer</a></li>
					        <li><a href="<?php echo $member_url; ?>Wallet/InternalFundtransferreport/1"><i class="fa fa-circle-o"></i>Income To Repurchase Transfer Report</a></li>

					        <li><a href="<?php echo $member_url; ?>Wallet/RepurchaseWallettoIncome"><i class="fa fa-circle-o"></i>Repurchase To Income Transfer</a></li>
					        <li><a href="<?php echo $member_url; ?>Wallet/InternalFundtransferreport"><i class="fa fa-circle-o"></i>Repurchase To Income Transfer Report</a></li>
					    </ul>
      				</li> 
      				<li>
					    <a href="javaScript:void();" class="waves-effect">
					    <i class="fa fa-home"></i> <span>Capital Wallet</span>
				        <i class="fa fa-angle-left float-right"></i>
				        </a>
				        <ul class="sidebar-submenu menu-open" >
					        <li><a href="<?php echo $member_url; ?>WalletRequest"><i class="fa fa-circle-o"></i>Capital Wallet Request</a></li>
					        <li><a href="<?php echo $member_url; ?>WalletRequest/WalletRequestReport"><i class="fa fa-circle-o"></i>Pending Request Report</a></li>
					        <li><a href="<?php echo $member_url; ?>WalletRequest/WalletRequestReport/1"><i class="fa fa-circle-o"></i>Accepted Request Report</a></li>
					        <li><a href="<?php echo $member_url; ?>WalletRequest/WalletRequestReport/2"><i class="fa fa-circle-o"></i>Rejected Request Report</a></li>
					        <li><a href="<?php echo $member_url; ?>ReportList/AccountStatement/1"><i class="fa fa-circle-o"></i>Capital Wallet Statement</a></li>
					    </ul>
      				</li> 
      				<li class="">
					    <a href="javaScript:void();" class="waves-effect">
					    <i class="fa fa-home"></i> <span>Activation</span>
				        <i class="fa fa-angle-left float-right"></i>
				        </a>
				        <ul class="sidebar-submenu menu-open" >
					        <li><a href="<?php echo $member_url; ?>Activation"><i class="fa fa-circle-o"></i>New Activation</a></li>
					        <li><a href="<?php echo $member_url; ?>Activation/ActivationReport"><i class="fa fa-circle-o"></i>Activation Report</a></li>
					    </ul>
      				</li> 

      				<li class="">
					    <a href="javaScript:void();" class="waves-effect">
					    <i class="fa fa-home"></i> <span>Capital Wallet Transfer</span>
				        <i class="fa fa-angle-left float-right"></i>
				        </a>
				        <ul class="sidebar-submenu menu-open" >
							<li><a href="<?php echo $member_url; ?>Wallet/wallettransfer"><i class="fa fa-circle-o"></i>Wallet Transfer</a></li>
					        <li><a href="<?php echo $member_url; ?>Wallet/Fundtransferreport"><i class="fa fa-circle-o"></i>Wallet Transfer Report</a></li>
					        <li><a href="<?php echo $member_url; ?>Wallet/Walletreceivereport"><i class="fa fa-circle-o"></i>Wallet Receive Report</a></li>
					    </ul>
      				</li>

      				<li>
					    <a href="javaScript:void();" class="waves-effect">
					    <i class="fa fa-home"></i> <span>Income</span>
				        <i class="fa fa-angle-left float-right"></i>
				        </a>
				        <ul class="sidebar-submenu menu-open" >
					        <li><a href="<?php echo $member_url; ?>ReportList/SponsorIncomeReport"><i class="fa fa-circle-o"></i>Sponsor Income</a></li>
					        <li><a href="<?php echo $member_url; ?>ReportList/RoiIncomeReport/0"><i class="fa fa-circle-o"></i>ROI Income</a></li>
					        <li><a href="<?php echo $member_url; ?>ReportList/"><i class="fa fa-circle-o"></i>Binary Income</a></li>
					        <li><a href="<?php echo $member_url; ?>ReportList/RewardIncome"><i class="fa fa-circle-o"></i>Reward Income</a></li>
					        <li><a href="<?php echo $member_url; ?>ReportList/AccountStatement"><i class="fa fa-circle-o"></i>Account Statement</a></li>
					        
					     </ul>
      				</li>
      				
      				<li class="">
					    <a href="javaScript:void();" class="waves-effect">
					    <i class="fa fa-home"></i> <span>Withdrawal</span>
				        <i class="fa fa-angle-left float-right"></i>
				        </a>
				        <ul class="sidebar-submenu menu-open" >
				        	<li><a href="<?php echo $member_url; ?>KYCUpload/Coinsdetail"><i class="fa fa-circle-o"></i>Add Payment Detail</a></li>
					     	<li><a href="<?php echo $member_url; ?>Withdrawal/Add"><i class="fa fa-circle-o"></i>Withdrawal</a></li>
					     	<li><a href="<?php echo $member_url; ?>Withdrawal/"><i class="fa fa-circle-o"></i>Withdrawal Report</a></li>
					     </ul>
      				</li>

      				<li>
					    <a href="javaScript:void();" class="waves-effect">
					    <i class="fa fa-home"></i> <span>Support</span>
				        <i class="fa fa-angle-left float-right"></i>
				        </a>
				        <ul class="sidebar-submenu menu-open" >
					       	 <li><a href="<?php echo $member_url; ?>Support/RaiseTicket"><i class="fa fa-circle-o"></i>Raise Ticket</a></li>
					        <li><a href="<?php echo $member_url; ?>Support/TicketReport"><i class="fa fa-circle-o"></i>Current Ticket Report</a></li>
					        <li><a href="<?php echo $member_url; ?>Support/TicketReport/1"><i class="fa fa-circle-o"></i>Closed Ticket Report</a></li>
					     </ul>
      				</li>
					<li>
				        <a href="<?php echo $member_url; ?>Dashboard/logout" class="waves-effect">
				          <i class="fa fa-home"></i> <span>Logout</span>
				          <small class="badge float-right badge-info"></small>
				        </a>
				    </li>
				</ul>
			</div>