<?php
Class Dashboard_model extends CI_Model {
	public function dashboardTopWidget($userId) {
		$cdate = CurrentDate();
		
		//DirectQuery("UPDATE mlm_userlogin set rewardid = (SELECT max(rewardid) from mlm_rewardtransaction where mlm_userlogin.id=mlm_rewardtransaction.userid GROUP by mlm_rewardtransaction.userid)");
		
		$MainTable="`mlm_adminmenu`";
		$Condition="userid='$userId' and menuid in (select id from mlm_admenusetting WHERE parentmenu=2 and id='17')";
		$Select="id";
		$Joining=CreateSingleQuery($MainTable,$Condition,$Select); 
        $Joining=json_decode($Joining,true);  

        $JoiningQuery = '';
        if($Joining['status'])
        {	
			$JoiningQuery="(SELECT count(*) FROM mlm_userlogin) AS 'Total Joining@@@#@@@icon-user@@@danger@@@MemberDetail/MemberListNew',
			(SELECT count(*) FROM mlm_userlogin WHERE DATE(entrydate) = DATE('$cdate')) AS 'Today Joining@@@#@@@icon-user@@@danger@@@MemberDetail/MemberList/1',
			(SELECT COALESCE(count(id),0) FROM mlm_useractivation where lockpackage='0' ) AS 'Total Activation@@@#@@@icon-user@@@danger@@@MemberDetail/ActivationReports',
			(SELECT COALESCE(count(id),0)  FROM mlm_useractivation WHERE DATE(entrydate) = DATE('$cdate') and lockpackage='0') AS 'Today Activation@@@#@@@icon-user@@@danger@@@MemberDetail/ActivationReport/0/1',
			(SELECT COALESCE(round(SUM(pv),2),0) FROM mlm_useractivation) AS 'Joining Turnover($)@@@#@@@icon-wallet@@@danger@@@MemberDetail/ActivationReports',
			(SELECT ifnull(round(sum(netamount),2),0) FROM `mlm_transaction` WHERE wallettype='Capital Wallet')AS 'Total Capital Wallet@@@#@@@icon-wallet@@@danger@@@ReportList/CapitalwalletReport'
			";			
		}

        $MainTable = "`mlm_adminmenu`";
		$Condition = "userid='$userId' and menuid in (select id from mlm_admenusetting WHERE parentmenu=125)";
		$Select = "id";
		$income = CreateSingleQuery($MainTable,$Condition,$Select); 
        $income = json_decode($income,true);  

        $WalletQuery = '';
        if($income['status']){
        	if($JoiningQuery != '') {
        		$WalletQuery = ', ';
        	}
        	$WalletQuery .= "(SELECT COALESCE(count(*),0)  FROM mlm_walletorder WHERE status = '0') AS 'Pending Capital Wallet Request@@@#@@@icon-wallet@@@danger@@@Wallet/WalletReport/0',
        	(SELECT COALESCE(count(*),0)  FROM mlm_walletorder WHERE status = '2') AS 'Rejected Capital Wallet Request@@@#@@@icon-wallet@@@danger@@@Wallet/WalletReport/2'
    		";
        }


		$MainTable = "`mlm_adminmenu`";
		$Condition = "userid='$userId' and menuid in (select id from mlm_admenusetting WHERE parentmenu=11)";
		$Select = "id";
		$income = CreateSingleQuery($MainTable,$Condition,$Select); 
        $income = json_decode($income,true);  

        $IncomeQuery = '';
        if($income['status']){
        	if($JoiningQuery != '' || $WalletQuery!='') {
        		$IncomeQuery = ', ';
        	}
        	$IncomeQuery .= "
        	(SELECT COALESCE(round(SUM(netamount),2),0) FROM mlm_sponsorincome) AS 'Sponsor Income@@@#@@@icon-wallet@@@danger@@@ReportList/SponsorIncomeReport',
        	(SELECT COALESCE(round(SUM(netamount),2),0) FROM mlm_roiincome) AS 'ROI Income@@@#@@@icon-wallet@@@danger@@@ReportList/RoiIncomeReports',
        	(SELECT COALESCE(round(SUM(amount),2),0) FROM mlm_binaryincome) AS 'Binary Income@@@#@@@icon-wallet@@@danger@@@ReportList/BinaryIncomeReport'
     		";
        }
		
		$MainTable="`mlm_adminmenu`";
		$Condition="userid='$userId' and menuid in (select id from mlm_admenusetting WHERE parentmenu=213)";
		$Select="id";
		$Withdrwal=CreateSingleQuery($MainTable,$Condition,$Select); 
        $Withdrwal=json_decode($Withdrwal,true);  

        $WithdrwalQuery='';
        if($Withdrwal['status']){

        	if($JoiningQuery != '' || $WalletQuery!='' || $IncomeQuery!='') {
        		$WithdrwalQuery = ', ';
        	}

	    	$WithdrwalQuery .= "
	    	(SELECT COALESCE(round(count(*),2),0) FROM mlm_withdrawalreq where status='0') AS 'Pending Withdrawal Request@@@#@@@icon-wallet@@@danger@@@Withdrawal/Report/0',
	    	(SELECT COALESCE(round(SUM(netamount),2),0) FROM mlm_withdrawalreq where status='1') AS 'Total Withdrawal($)@@@#@@@icon-wallet@@@danger@@@Withdrawal/Report/1'
	    	";
    	}

	   	IF($JoiningQuery == '' && $IncomeQuery == '' && $WithdrwalQuery == '' && $WalletQuery=='') {
	   		$topwidgetresult = array();
	   	}
	   	else {
	   		$topwidgetquery="SELECT ".$JoiningQuery.$WalletQuery.$IncomeQuery.$WithdrwalQuery;
			$topwidgetraw = DirectQuery($topwidgetquery);
	    	$topwidgetresult = $topwidgetraw->result();	
	   	}
	   	
		return $topwidgetresult;
	}
}
?>