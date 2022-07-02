<?php 

if (! defined('BASEPATH')) exit('No direct script access allowed');	
    function BinaryIncomeHelper($data){
     $userId=$data['userId'];
     $MainTable="mlm_binaryincome as BI";
     $Condition="BI.userid='$userId'";
        if(isset($data['dateStart'])){
            $dateStart=$data['dateStart'];
            $dateStart = date("Y-m-d",$dateStart);
            $Condition=$Condition." and date(BI.entrydate) >= date('$dateStart')";
        }

        if(isset($data['dateEnd'])){
            $dateEnd=$data['dateEnd'];
            $dateEnd = date("Y-m-d",$dateEnd);
            $Condition=$Condition." and date(BI.entrydate) <= date('$dateEnd')";
        }
      $SelectColumn="BI.entrydate as 'Date___convertdate',BI.bfl,BI.bfr,BI.cl,BI.cr,BI.totalleft,BI.totalright,BI.mp as 'Match Pair',BI.amount as 'Amount',BI.cfl,BI.cfr";
      $OrderBy="BI.entrydate";
      //$GroupBy="BI.entrydate";
      $BinaryList=CreateSingleQuery($MainTable,$Condition,$SelectColumn,$OrderBy); 
      $BinaryList=json_decode($BinaryList,true); 
      return  $BinaryList;   
    }
    function SponsorIncomeHelper($data){	
        $userId=$data['userId'];
        $MainTable="mlm_sponsorincome as A";
        $JoinTable=array();
        $JoinTable[0]="mlm_userlogin as B";
        $JoinTable[1]="mlm_userdetail as C";
        /*$JoinTable[3]="mlm_packagesetting AS E";*/

        $JoinOn=array();
        $JoinOn[0]="A.fromid=B.id";
        $JoinOn[1]="B.id=C.userid";
        /*$JoinOn[3]="A.frompackagecode=E.id";*/

        $Condition="A.userid='$userId'";
        if(isset($data['dateStart'])){
            $dateStart=$data['dateStart'];
            $dateStart = date("Y-m-d",$dateStart);
            $Condition=$Condition." and date(A.entrydate) >= date('$dateStart')";
        }

        if(isset($data['dateEnd'])){
            $dateEnd=$data['dateEnd'];
            $dateEnd = date("Y-m-d",$dateEnd);
            $Condition=$Condition." and date(A.entrydate) <= date('$dateEnd')";
        }

        $SelectColumn="A.entrydate as 'Date___convertdate',concat(B.username,'<br>',C.fullname) as 'From id',A.amount as 'Amount ($)',A.per as 'Per(%)',A.netamount as 'Net Amount($)___sum___amount' ";

        $SponsorIncomeList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn); 
        $SponsorIncomeList=json_decode($SponsorIncomeList,true);  
        return  $SponsorIncomeList;
    }
    function RoiIncomeHelper($data){
        $userId=$data['userId'];
        $flag=$data['flag'];
        $MainTable="mlm_roiincome";
        $Condition="userid = '$userId'";
        $SelectColumn="entrydate as 'Entry Date___convertdate',netamount as 'Amount($)___sum___amount'";
        if(isset($data['dateStart'])){
            $dateStart=$data['dateStart'];
            $dateStart = date("Y-m-d",$dateStart);
            $Condition=$Condition." and date(entrydate) >= date('$dateStart')";
        }

        if(isset($data['dateEnd'])){
            $dateEnd=$data['dateEnd'];
            $dateEnd = date("Y-m-d",$dateEnd);
            $Condition=$Condition." and date(entrydate) <= date('$dateEnd')";
        }

        $RoiIncomeList=CreateSingleQuery($MainTable,$Condition,$SelectColumn); 
        $RoiIncomeList=json_decode($RoiIncomeList,true);
        return  $RoiIncomeList;
    }
    function AccountStatementHelper($data){
        $userId=$data['userId'];
        $wallettype=$data['wallettype'];
        $MainTable="mlm_transaction";
        $Condition="userid = '$userId' and wallettype='$wallettype'";
        $SelectColumn="entrydate as 'EntryDate___convertdate', remark as 'Remark', round(IF(netamount>0,netamount,0),2) as 'Credit ($)___sum___credit', round(IF(netamount<0,netamount,0),2) as 'Debit ($)___sum___debit'";
        
        $LinkIncomeList=CreateSingleQuery($MainTable,$Condition,$SelectColumn,'entrydate,id'); 
        $LinkIncomeList=json_decode($LinkIncomeList,true);
        $balancearray = array();
        $balance = 0;
        if($LinkIncomeList['status']) {
            $balancearray['status'] = true;
            foreach ($LinkIncomeList['data'] as $key => $value) {
                $balancearray['data'][$key] = $value;
                $balance =round($balance + $LinkIncomeList['data'][$key]['Credit ($)___sum___credit'] + $LinkIncomeList['data'][$key]['Debit ($)___sum___debit'],2);
                $balancearray['data'][$key]['Balance'] = $balance;
            }
        }
        else {
            $balancearray = $LinkIncomeList;
        }
        return  $balancearray;
    }

    function MemberwisePayoutHelper($data){

        $userId=$data['userId'];  
        $type=$data['type']; 
        $MainTable="mlm_payoutmaster as A";
        $Condition="A.userid='$userId' and A.type='$type'";
    
        $SelectColumn="A.payoutdate as 'Payout Date___convertdate',A.`Binary Income` as 'Binary Income___sum___bincome',A.`Direct Share Income` as 'Direct Share Income___sum___refiincome' ,A.`Royalty Income` as 'Royalty Income___sum___liincme',A.`grossamt` as 'GrossAmt___sum___GrossAmt',A.`tds` as tds___sum___tds,A.`admincharge` as AdminCharge___sum___acw,A.`netamt` as 'Net Amount___sum___nt',A.bankacc as 'Bank Account',A.bankname as 'Bank Name',A.branch as 'Branch Name',A.ifsc as 'IFSC Code'";
    
        $getPayout=CreateSingleQuery($MainTable,$Condition,$SelectColumn,'A.payoutdate desc');
        $getPayout=json_decode($getPayout,true);
        return $getPayout;

    }


     function Masterrpt($data = array()) {
        $ActiveMainTable="mlm_useractivation";
        $ActiveJoinTable=array();
        $ActiveJoinOn=array();
        $ActiveQueryString='';
        $ActiveCondition="1=1";
        $ActiveSelectColumn="date(activedate) as 'Date',
                    COUNT(*) as 'Total Activation', 
                    sum(activeamount) as 'Total Active Amount___sum___totalIncomesa'";
        $ActivationList=CreateJoinQuery($ActiveMainTable,$ActiveJoinTable,$ActiveJoinOn,$ActiveCondition,$ActiveSelectColumn,array(),'entrydate desc','date(activedate)');
        $Activationarray=json_decode($ActivationList,true);

        $BinaryData = array();
        $Binaryarray = json_decode(BinaryReportDatewise($BinaryData), true);
        $BinaryRecord = array();
        
        foreach ($Binaryarray['data'] as $key => $value) {
            $newkey = $value['Date'];
            $newvaalue = $value['Amount'];
            $BinaryRecord[$newkey] = $newvaalue;
        }

        $BinaryData = array();
        $Levelarray = json_decode(LevelReportDatewise($BinaryData), true);
        $LevelRecord = array();
        foreach ($Levelarray['data'] as $key => $value) {
            $newkey = $value['Date'];
            $newvaalue = $value['Amount'];
            $LevelRecord[$newkey] = $newvaalue;
        }

        $BinaryData = array();
        $Sponsorarray = json_decode(SponsorReportDatewise($BinaryData), true);
        $SponsorRecord = array();
        foreach ($Sponsorarray['data'] as $key => $value) {
            $newkey = $value['Date'];
            $newvaalue = $value['Amount'];
            $SponsorRecord[$newkey] = $newvaalue;
        }

        $ResponseList = array();
        //$ResponseList = $Activationarray['status'];
        $ResponseList = $Activationarray;
        foreach ($Activationarray['data'] as $key => $value) {
            $checkkey = $value['Date'];

            $difference = $value['Total Active Amount___sum___totalIncomesa'];
            if(isset($LevelRecord[$checkkey])) {
                $ResponseList['data'][$key]['Previous Benefits___sum___totalIncomes'] = $LevelRecord[$checkkey];
                $difference = $difference - $LevelRecord[$checkkey];
            }
            else {
                $ResponseList['data'][$key]['Previous Benefits___sum___totalIncomes'] = 0;
            }
            
            if(isset($BinaryRecord[$checkkey])) {
                $ResponseList['data'][$key]['Matching Bonus___sum___totalIncomee'] = $BinaryRecord[$checkkey];
                $difference = $difference - $BinaryRecord[$checkkey];
            }
            else {
                $ResponseList['data'][$key]['Matching Bonus___sum___totalIncomee'] = 0;
            }

            if(isset($SponsorRecord[$checkkey])) {
                $ResponseList['data'][$key]['Refferel Level Income___sum___reftotalIncomee'] = $SponsorRecord[$checkkey];
                $difference = $difference - $SponsorRecord[$checkkey];
            }
            else {
                $ResponseList['data'][$key]['Refferel Level Income___sum___reftotalIncomee'] = 0;
            }

            $ResponseList['data'][$key]['Total Difference___sum___totalIncome'] = $difference;
        }
        //$ResponseList = $Activationarray;
  
        return  $ResponseList;
    }
    function RewardIncomeHelper($data){    
        $userId=$data['userId'];
        $MainTable="mlm_rewardmaster as A";
        $JoinTable=array();
        $JoinTable[0]="mlm_rewardtransaction as B";

        $JoinOn=array();
        $JoinOn[0]="A.id=B.rewardid and B.userid='$userId'";

        $JoinType=array();
        $JoinType[0]='LEFT';

        $Condition="1=1";

        $SelectColumn="A.mp as 'Required Match Pair' ,A.rank as 'Designation',A.reward ,if(B.rewardid>'0',date(B.entrydate),'Pending') as 'Status'";

        $SponsorIncomeList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,$JoinType); 
        $SponsorIncomeList=json_decode($SponsorIncomeList,true);  
        return  $SponsorIncomeList;
    }
?>