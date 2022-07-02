<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');
function SponsorIncome($data){
	$userid=$data['memberid'];
	$packagecode=$data['packagecode'];
	$packagemrp=$data['packagemrp'];
	$activeId=$data['activeId'];
	$directper=$data['directper'];

	$MainTable="mlm_userdownline";
	$JoinTable=array();
	$JoinTable[0]="mlm_userlogin";
	$JoinOn=array();
	$JoinOn[0]="mlm_userdownline.sponsor=mlm_userlogin.id";
	$Condition="mlm_userdownline.userid='$userid'";
	$SelectColumn="mlm_userdownline.sponsor,mlm_userlogin.packagecode,mlm_userlogin.activestatus";
	$getInfo=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn);
	$getInfo=json_decode($getInfo,true);

	if($getInfo['data'][0]['activestatus']=='1'){
		$fromid=$getInfo['data'][0]['sponsor'];
		$incomeAmount=$packagemrp * $directper /100;
		$mlm_sponsorincome=array();
		$mlm_sponsorincome['entrydate'] = CurrentDate();
		$mlm_sponsorincome['userid'] = $fromid;
		$mlm_sponsorincome['fromid'] = $userid;
		$mlm_sponsorincome['packagecode'] = $packagecode;
		$mlm_sponsorincome['amount'] = $packagemrp;
		$mlm_sponsorincome['per'] = $directper;
		$mlm_sponsorincome['netamount'] = $incomeAmount;
		$mlm_sponsorincome['refid'] =$activeId;
		$sponincomeid=InsertData('mlm_sponsorincome',$mlm_sponsorincome);

		if($sponincomeid > 0){
			$mlm_transaction['entrydate'] = CurrentDate();
			$mlm_transaction['userid'] = $fromid;
			$mlm_transaction['fromid'] = $userid;
			$mlm_transaction['status'] = 'paid';
			$mlm_transaction['refid'] = $sponincomeid;
			$mlm_transaction['remark'] = 'Sponsor Income';
			$mlm_transaction['transtype'] = 'Sponsor Income';
			$mlm_transaction['wallettype'] ='Income Wallet';
			$mlm_transaction['netamount'] = $incomeAmount;
			InsertData('mlm_transaction',$mlm_transaction);
		}
	}	
}

function RoiStartProcess($data){
	$userId=$data['userId'];
	$packageId=$data['packageId'];
	$roiStartDate=$data['roiStartDate'];
	$roiAmount=$data['roiAmount'];
	$roiDays=$data['roiDays'];
	$roiInterval=$data['roiInterval'];
	$activateId=$data['activeId'];
	$packagemrp=$data['packagemrp'];
	$roiper=$data['roiper'];

	$insertRoiData=array();
	$insertRoiData['entrydate']=CurrentDate();
	$insertRoiData['userid']=$userId;
	$insertRoiData['packagecode']=$packageId;
	$insertRoiData['roiamount']=$roiAmount;
	$insertRoiData['roiinterval']=$roiInterval;
	$insertRoiData['roicount']=0;
	$insertRoiData['roitotal']=$roiDays;
	$insertRoiData['nextroidate']=$roiStartDate;
	$insertRoiData['refid']=$activateId;
	$insertRoiData['roiper']=$roiper;
	$insertRoiData['packagemrp']=$packagemrp;
	$responseRoi=InsertData('mlm_roimaster',$insertRoiData);
	
	$response=array();
	return $response;
}
function RoiIncome($date_from, $date_to) {
	$wallettype = 'Income Wallet';

	DirectQuery("INSERT INTO `mlm_roiincome` (`entrydate`, `userid`, `roicount`, `netamount`, `clubid`, `packagecode`,`refid`) select '$date_to', `userid`, `roicount`+1, `roiamount`, `boosterFlag`, `packagecode`,`id` from mlm_roimaster where nextroidate = '$date_to' and roicount < roitotal");
	DirectQuery("UPDATE mlm_roimaster set nextroidate=DATE_ADD(nextroidate,INTERVAL `roiinterval` DAY), roicount=roicount+1 where nextroidate='$date_to' and roicount < roitotal");

	DirectQuery("INSERT INTO `mlm_transaction`(`entrydate`, `userid`, `fromid`, `status`, `refid`, `remark`, `transtype`,  `wallettype`, `netamount`) select '$date_to', `userid`, '', 'paid', `id`, 'ROI Income Generated', 'ROI Income','$wallettype',`netamount` from `mlm_roiincome` where date(entrydate)=date('$date_to')");
}
function BinaryIncome($date_from,$date_to) {
	$transtype = 'Binary Income';
	$binaryper=15;

	DirectQuery("UPDATE mlm_userlogin SET lastbinarydate = (SELECT max(entrydate) from mlm_binaryincome where userid = mlm_userlogin.id), bfl=0, bfr=0, bflbv=0, bfrbv=0");

	DirectQuery("UPDATE mlm_userlogin, mlm_binaryincome SET mlm_userlogin.bfl = mlm_binaryincome.cfl, mlm_userlogin.bfr = mlm_binaryincome.cfr WHERE mlm_binaryincome.userid = mlm_userlogin.id AND mlm_binaryincome.entrydate = mlm_userlogin.lastbinarydate");

	DirectQuery("INSERT INTO mlm_binaryincome (userid, entrydate, bfl, bfr, capping, tail) SELECT DISTINCT US.uplineid, '$date_to', UL.bfl, UL.bfr, PS.capping, UL.tail FROM mlm_userstructure AS US INNER JOIN mlm_useractivation AS UA ON UA.userid = US.userid INNER JOIN mlm_userlogin AS UL ON UL.id = US.uplineid LEFT JOIN mlm_packagesetting AS PS ON PS.id = UL.packagecode  WHERE UA.`activedate` BETWEEN '$date_from' AND '$date_to'");

	DirectQuery("UPDATE mlm_binaryincome SET cl = ( SELECT sum(UA.pv) FROM mlm_userstructure AS US INNER JOIN mlm_useractivation AS UA ON UA.userid = US.userid WHERE (UA.`activedate` BETWEEN '$date_from' AND '$date_to') AND US.uplineid = mlm_binaryincome.userid AND US.side = '0') where entrydate='$date_to'");

	DirectQuery("UPDATE mlm_binaryincome SET cr = ( SELECT sum(UA.pv) FROM mlm_userstructure AS US INNER JOIN mlm_useractivation AS UA ON UA.userid = US.userid WHERE (UA.`activedate` BETWEEN '$date_from' AND '$date_to') AND US.uplineid = mlm_binaryincome.userid AND US.side = '2') where entrydate='$date_to'");

	DirectQuery("UPDATE mlm_binaryincome SET totalleft = bfl+cl, totalright = bfr+cr where entrydate='$date_to'");
	

	DirectQuery("UPDATE mlm_binaryincome AS BI, mlm_userlogin AS UL SET BI.mp = BI.totalleft where UL.id = BI.userid AND BI.totalleft < BI.totalright and BI.entrydate = '$date_to' AND UL.activeleftsponsor >1 AND UL.activerightsponsor>0");

	DirectQuery("UPDATE mlm_binaryincome AS BI, mlm_userlogin AS UL SET BI.mp = BI.totalleft where UL.id = BI.userid AND BI.totalleft < BI.totalright and BI.entrydate = '$date_to' AND UL.activeleftsponsor >0 AND UL.activerightsponsor>1 and BI.mp='0'");
	
	DirectQuery("UPDATE mlm_binaryincome AS BI, mlm_userlogin AS UL SET BI.mp = BI.totalright where UL.id = BI.userid AND BI.totalleft >= BI.totalright and BI.entrydate = '$date_to' AND UL.activeleftsponsor > 1 AND UL.activerightsponsor>0 and BI.mp='0'");

	DirectQuery("UPDATE mlm_binaryincome AS BI, mlm_userlogin AS UL SET BI.mp = BI.totalright where UL.id = BI.userid AND BI.totalleft >= BI.totalright and BI.entrydate = '$date_to' AND UL.activeleftsponsor > 0 AND UL.activerightsponsor>1 and BI.mp='0'");

	DirectQuery("UPDATE mlm_binaryincome AS BI, mlm_userlogin AS UL SET BI.mp = BI.totalleft where UL.id = BI.userid AND BI.totalleft < BI.totalright and BI.entrydate = '$date_to' AND UL.activestatus='0'");

	DirectQuery("UPDATE mlm_binaryincome AS BI, mlm_userlogin AS UL SET BI.mp = BI.totalright where UL.id = BI.userid AND BI.totalleft >= BI.totalright and BI.entrydate = '$date_to' AND UL.activestatus='0'");

	DirectQuery("UPDATE mlm_binaryincome SET cfl=totalleft-mp, cfr=totalright-mp where entrydate = '$date_to'");

	DirectQuery("UPDATE mlm_binaryincome as A, mlm_userlogin as B SET A.amount=(A.mp * $binaryper / 100) where A.entrydate='$date_to' and A.userid=B.id and B.activestatus='1'");

	DirectQuery("UPDATE mlm_binaryincome SET amount = capping where entrydate='$date_to' and amount > capping");

	$wallettype="Income Wallet";

	DirectQuery("INSERT INTO `mlm_transaction`(`entrydate`, `userid`, `status`, `refid`,`remark`, `transtype`, `wallettype`, `netamount`) SELECT '$date_to',`userid`,'paid',`id`,'Binary Income','$transtype','$wallettype',`amount` FROM mlm_binaryincome WHERE entrydate='$date_to' AND amount>0");	
}

function RewardIncome($date_to) {
	
	DirectQuery("INSERT INTO `mlm_rewardtransaction`(`entrydate`, `userid`, `rewardid`, `reward`, `mp`, `totalmp`, `bonus`) SELECT '$date_to', BI.userid, RM.id, RM.reward, RM.mp, RM.totalmp, RM.wallet FROM mlm_binaryincome AS BI INNER JOIN mlm_rewardmaster AS RM join mlm_userlogin as A on BI.userid=A.id WHERE A.activestatus='1' and BI.userid NOT IN (SELECT userid FROM mlm_rewardtransaction WHERE RM.id = mlm_rewardtransaction.rewardid) GROUP BY BI.userid,RM.id HAVING SUM(BI.mp) >= RM.totalmp ");

	DirectQuery("UPDATE mlm_userlogin set rewardid = (SELECT max(rewardid) from mlm_rewardtransaction where mlm_userlogin.id=mlm_rewardtransaction.userid GROUP by mlm_rewardtransaction.userid)");
}

function DailyIncome() {
	$lastsessionquery = "SELECT sessionno,dateto FROM mlm_binarydate ORDER BY id DESC LIMIT 0,1";
	$lastsessionraw = DirectQuery($lastsessionquery);
	$lastsessiondata = $lastsessionraw->result();
	if(count($lastsessiondata) > 0) {
		$id = $lastsessiondata[0]->sessionno;	
	}
	else {

		$id=0;
	}
	$TodayDate = CurrentDate();
	$Yesterday = date('Y-m-d 23:59:59', strtotime('-1 day', strtotime($TodayDate)));
	$allsessionquery = "SELECT sessionno FROM mlm_session WHERE dateto <= '$Yesterday' ORDER BY sessionno DESC LIMIT 0,1";
	$allsessionraw = DirectQuery($allsessionquery);
	$allsessiondata = $allsessionraw->result();
	if(count($allsessiondata) > 0) {
		$s1 = $allsessiondata[0]->sessionno;	
	}
	else {
		$s1 = 0;
	}
	if($id==$s1) {

	}
	else {
		for($i=$id+1; $i<=$s1; $i++)
		{
			$q1 = "SELECT * FROM mlm_session WHERE sessionno='$i'";
			$q1raw = DirectQuery($q1);
			$q1raw = $q1raw->result();
			if(count($q1raw) > 0) {
				$date_from = $q1raw[0]->datefrom;
				$date_to = $q1raw[0]->dateto;
			}
			DirectQuery("INSERT INTO `mlm_binarydate`(`dateto`, `sessionno`) VALUES ('$date_to', '$i')");
			RoiIncome($date_from, $date_to);

			$day=date('D',strtotime($date_to));
			if($day=='Mon')
			{
				$monday=date('Y-m-d 00:00:00', strtotime($TodayDate. 'previous tuesday'));
				$activequery = DirectQuery("SELECT * FROM mlm_useractivation WHERE `activedate` BETWEEN '$monday' AND '$date_to'");
				$activeraw = $activequery->result();
				if(count($activeraw) > 0) {
					BinaryIncome($monday,$date_to);
					RewardIncome($monday,$date_to);
				}
			}
		}
	}
}
?> 