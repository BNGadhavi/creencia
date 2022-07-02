<?php
Class ReportModel extends CI_Model {
  public function UserInfoForReport($data){

      $userId=$data['userId'];
      $MainTable="mlm_userlogin";
      $JoinTable=array();
      $JoinTable[0]="mlm_userdetail";
      $JoinOn=array();
      $JoinOn[0]="mlm_userlogin.id=mlm_userdetail.userid";
      $Condition="mlm_userlogin.id='$userId'";
      $SelectColumn="mlm_userlogin.username as Username___div___12, mlm_userdetail.fullname as Fullname___div___12";
      $UserData=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn); 
      $UserData=json_decode($UserData,true);
      $response=array();
      $response['UserData']=$UserData;
      return $response;
  }
  
  public function BinaryReport($data=array()){
      $MainTable="mlm_binaryincome as A";
      $JoinTable=array();
      $JoinTable[0]="mlm_userlogin as B";
      $JoinTable[1]="mlm_userdetail as C";
    
      $JoinOn=array();
      $JoinOn[0]="A.userid=B.id";
      $JoinOn[1]="B.id=C.userid";
      
      $QueryString='';
      $Condition="1=1";
      if(isset($data['dateStart'])){
        $dateStart=$data['dateStart'];
        $QueryString = "/".strtotime($dateStart);
        $dateStart = date("Y-m-d", strtotime($dateStart));
        $Condition=$Condition." and date(A.entrydate) >= date('$dateStart')";
      }

      if(isset($data['dateEnd'])){
        $dateEnd=$data['dateEnd'];
        $QueryString =$QueryString. "/".strtotime($dateEnd);
        $dateEnd = date("Y-m-d", strtotime($dateEnd));
        $Condition=$Condition." and date(A.entrydate) <= date('$dateEnd')";
      }

      $dateLink="concat('ReportList/BinaryIncomeDetail/',A.userid)";
      if($QueryString!=''){
        $dateLink="concat('ReportList/BinaryIncomeDetail/',A.userid,'$QueryString')";    
      }

      $link=$dateLink." as Detail___link,";
      $SelectColumn=$link."B.username as 'Member Id',C.fullname as 'Member Name' , round(sum(amount),2) as 'Total Income___sum___totalIncome' ";
     
      $BinaryIncomeList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,array(),'A.entrydate desc',' A.userid'); 
      $BinaryIncomeList=json_decode($BinaryIncomeList,true);  
      return  $BinaryIncomeList;
  }

  public function SponsorReport($data=array()){
      $MainTable="mlm_sponsorincome as A";
      $JoinTable=array();
      $JoinTable[0]="mlm_userlogin as B";
      $JoinTable[1]="mlm_userdetail as C";
    
      $JoinOn=array();
      $JoinOn[0]="A.userid=B.id";
      $JoinOn[1]="B.id=C.userid";
    
      $Condition="1=1";
      $QueryString='';
      if(isset($data['dateStart'])){
        $dateStart=$data['dateStart'];
        $QueryString = "/".strtotime($dateStart);
        $dateStart = date("Y-m-d", strtotime($dateStart));
        $Condition=$Condition." and date(A.entrydate) >= date('$dateStart')";
      }

      if(isset($data['dateEnd'])){
        $dateEnd=$data['dateEnd'];
        $QueryString =$QueryString. "/".strtotime($dateEnd);
        $dateEnd = date("Y-m-d", strtotime($dateEnd));
        $Condition=$Condition." and date(A.entrydate) <= date('$dateEnd')";
      }

      $dateLink="concat('ReportList/SponsorIncomeDetail/',A.userid)";
      if($QueryString!=''){
        $dateLink="concat('ReportList/SponsorIncomeDetail/',A.userid,'$QueryString')";    
      }
      $link=$dateLink."as Detail___link,";
      $SelectColumn=$link."B.username as 'Member Id',C.fullname as 'Member Name' , round(sum(netamount),2) as 'Total Income___sum___totalIncome' ";
     
      $SponsorIncomeList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,array(),'A.entrydate desc',' A.userid'); 
      $SponsorIncomeList=json_decode($SponsorIncomeList,true);  
      return  $SponsorIncomeList;
  }
  public function RoiIncomeList($data=array()){
      $MainTable="`mlm_roiincome` AS RI";
      $JoinTable=array();
      $JoinTable[0]="mlm_userlogin AS UL";
      $JoinTable[1]="mlm_userdetail AS UD";
    
      $JoinOn=array();
      $JoinOn[0]="UL.id = RI.userid";
      $JoinOn[1]="UD.userid = RI.userid";
    
      $Condition="1=1";
      $QueryString='';
      if(isset($data['dateStart'])){
        $dateStart=$data['dateStart'];
        $QueryString = "/".strtotime($dateStart);
        $dateStart = date("Y-m-d", strtotime($dateStart));
        $Condition=$Condition." and date(RI.entrydate) >= date('$dateStart')";
      }

      if(isset($data['dateEnd'])){
        $dateEnd=$data['dateEnd'];
        $QueryString =$QueryString. "/".strtotime($dateEnd);
        $dateEnd = date("Y-m-d", strtotime($dateEnd));
        $Condition=$Condition." and date(RI.entrydate) <= date('$dateEnd')";
      }

      $dateLink="concat('ReportList/RoiIncomeDetail/',RI.userid)";
      if($QueryString!=''){
        $dateLink="concat('ReportList/RoiIncomeDetail/',RI.userid,'$QueryString')";    
      }

      $link=$dateLink." as Detail___link,";
      $SelectColumn=$link."UL.username AS 'Member ID',UD.fullname AS 'Member Name',SUM(round(RI.netamount,4)) as 'Amount___sum___amountSum' ";
     
      $RoiIncomeList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,array(),'RI.entrydate desc',' RI.userid'); 
      $RoiIncomeList=json_decode($RoiIncomeList,true);  
      return  $RoiIncomeList;

  }

  public function RoiIncomeLists($data=array()){
      $MainTable="`mlm_roimaster` AS A";
      $JoinTable=array();
      $JoinTable[0]="mlm_userlogin AS UL";
      $JoinTable[1]="mlm_userdetail AS UD";
    
      $JoinOn=array();
      $JoinOn[0]="UL.id = A.userid";
      $JoinOn[1]="UD.userid = A.userid";
    
      $Condition="1=1";
      $QueryString='';
      if(isset($data['dateStart'])){
        $dateStart=$data['dateStart'];
        $QueryString = "/".strtotime($dateStart);
        $dateStart = date("Y-m-d", strtotime($dateStart));
        $Condition=$Condition." and date(A.entrydate) >= date('$dateStart')";
      }

      if(isset($data['dateEnd'])){
        $dateEnd=$data['dateEnd'];
        $QueryString =$QueryString. "/".strtotime($dateEnd);
        $dateEnd = date("Y-m-d", strtotime($dateEnd));
        $Condition=$Condition." and date(A.entrydate) <= date('$dateEnd')";
      }

      $dateLink="concat('ReportList/RoiIncomeDetails/',A.id,'/',A.userid)";
      if($QueryString!=''){
        $dateLink="concat('ReportList/RoiIncomeDetails/',A.id,'/',A.userid,'$QueryString')";    
      }

      $link=$dateLink." as Detail___link,";
      $SelectColumn=$link."A.entrydate as 'Entrydate___convertdate',UL.username AS 'Member ID',UD.fullname AS 'Member Name',A.packagemrp as 'Amount',A.roiper as '%',A.roiamount as 'Per Day Amount',round(A.roicount*A.roiamount,2) as 'Total Amount___sum___amountSum',A.nextroidate as 'Next Date'";
     
      $RoiIncomeList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,array(),'A.id asc'); 
      $RoiIncomeList=json_decode($RoiIncomeList,true);  
      return  $RoiIncomeList;

  }

  public function RoiIncomeHelpers($data=array()){
      $id=$data['id'];
      $MainTable="`mlm_roiincome` AS RI";
      $JoinTable=array();
    
      $JoinOn=array();
    
      $Condition="RI.refid='$id'";
      $QueryString='';
      if(isset($data['dateStart'])){
        $dateStart=$data['dateStart'];
        $QueryString = "/".strtotime($dateStart);
        $dateStart = date("Y-m-d", strtotime($dateStart));
        $Condition=$Condition." and date(RI.entrydate) >= date('$dateStart')";
      }

      if(isset($data['dateEnd'])){
        $dateEnd=$data['dateEnd'];
        $QueryString =$QueryString. "/".strtotime($dateEnd);
        $dateEnd = date("Y-m-d", strtotime($dateEnd));
        $Condition=$Condition." and date(RI.entrydate) <= date('$dateEnd')";
      }

      $SelectColumn="RI.entrydate as 'Entrydate___convertdate',round(RI.netamount,2) as 'Amount___sum___amountSum' ";
     
      $RoiIncomeList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,array(),'RI.entrydate desc'); 
      $RoiIncomeList=json_decode($RoiIncomeList,true);  
      return  $RoiIncomeList;
  }

  public function Masterrpt($data=array()){
      $MainTable="mlm_useractivation";
      $JoinTable=array();
      $JoinOn=array();
      $QueryString='';
      $Condition="1=1";
      
      $SelectColumn="date(activedate) as 'Date',
                    COUNT(*) as 'Total Activation', 
                    sum(activeamount) as 'Total Active Amount___sum___totalIncomesa', 
                    (SELECT COALESCE(sum(netamount),0) from mlm_levelincome where date(entrydate)=date(mlm_useractivation.activedate)) as 'Previous Benefits___sum___totalIncomes',
                    (SELECT COALESCE(sum(amount),0) from mlm_binaryincome where date(entrydate)=date(mlm_useractivation.activedate)) as 'Matching Bonus___sum___totalIncomee',
                    (SELECT COALESCE(sum(netamount),0) from mlm_sponsorbinaryincome where date(entrydate)=date(mlm_useractivation.activedate)) as 'Refferel Level Income___sum___reftotalIncomee',
                    sum(activeamount) - ((SELECT COALESCE(sum(netamount),0) from mlm_levelincome where date(entrydate)=date(mlm_useractivation.activedate))+  (SELECT COALESCE(sum(amount),0) from mlm_binaryincome where date(entrydate)=date(mlm_useractivation.activedate))) - (SELECT COALESCE(sum(netamount),0) from mlm_sponsorbinaryincome where date(entrydate)=date(mlm_useractivation.activedate)) as 'Total Difference___sum___totalIncome'";
     
      $BinaryIncomeList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,array(),'entrydate desc','date(activedate)'); 
      $BinaryIncomeList=json_decode($BinaryIncomeList,true);  
      return  $BinaryIncomeList;
  }

  public function WithdrawalAdminchargeList($data){
        
        $MainTable="mlm_chargestransaction as A";
        $JoinTable=array();
        $JoinTable[0]="mlm_userlogin as B";
        $JoinTable[1]="mlm_userdetail as C";
        
        $JoinOn=array();
        $JoinOn[0]="A.userid=B.id";
        $JoinOn[1]="B.id=C.userid";

        $Condition="A.orderby='0'";
        if(isset($data['dateStart'])){
          $dateStart=$data['dateStart'];
          $dateStart = date("Y-m-d", strtotime($dateStart));
          $Condition=$Condition." and date(A.entrydate) >= date('$dateStart')";
        }

      if(isset($data['dateEnd'])){
          $dateEnd=$data['dateEnd'];
          $dateEnd = date("Y-m-d", strtotime($dateEnd));
          $Condition=$Condition." and date(A.entrydate) <= date('$dateEnd')";
        }
      
        $SelectColumn="A.entrydate as 'Entrydate___convertdate', ROUND(A.totalamount,2) as 'Gross Amount___sum___grossamt', ROUND(A.admincharge,2) as 'Admincharge___sum___admincharge',if(A.type='0','Withdrawal','Fund Transfer') as Type";
        $GroupBy = 'A.payoutdate';
        $ReportList=CreateSingleQuery($MainTable,$Condition, $SelectColumn,'A.entrydate desc'); 
        $ReportList=json_decode($ReportList,true);
        return  $ReportList;
  }

  public function Walletrpt($data){
     $MainTable="mlm_transaction as A";

     $JoinTable=array();
     $JoinTable[0]="mlm_userlogin as B";
     $JoinTable[1]="mlm_userdetail as C";

     $JoinOn=array();
     $JoinOn[0]="A.userid=B.id";
     $JoinOn[1]="B.id=C.userid";

     $JoinType=array();
     $Condition="A.wallettype='Capital Wallet'";
     $QueryString='';
    if(isset($data['dateStart'])){
      $dateStart=$data['dateStart'];
      $QueryString = "/".strtotime($dateStart);
      $dateStart = date("Y-m-d", strtotime($dateStart));
      $Condition=$Condition." and date(A.entrydate) >= date('$dateStart')";
    }

    if(isset($data['dateEnd'])){
      $dateEnd=$data['dateEnd'];
      $QueryString =$QueryString. "/".strtotime($dateEnd);
      $dateEnd = date("Y-m-d", strtotime($dateEnd));
      $Condition=$Condition." and date(A.entrydate) <= date('$dateEnd')";
    }

    $dateLink="concat('ReportList/Walletdetail/',A.userid)";
    if($QueryString!=''){
      $dateLink="concat('ReportList/Walletdetail/',A.userid,'$QueryString')";    
    }
    $link=$dateLink."as Detail___link,";
     $SelectColumn=$link."B.username as 'Member ID',C.fullname as 'Member Name',sum(A.netamount) as 'Total Capital Wallet___sum___amountSum'";
     $SponsorIncomeList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn, array(), '', ' A.userid');
     $BinaryList=json_decode($SponsorIncomeList,true); 
     return  $BinaryList;   
  }
  public function Rewardandaward($data=array()){
      $MainTable="`mlm_rewardtransaction` AS RT";
      $JoinTable=array();
      $JoinTable[0]=" mlm_rewardmaster AS RM";
    
      $JoinOn=array();
      
      $JoinOn[0]="RT.rewardid=RM.id";

      $JoinType = array();
      $Condition="1=1";

      $dateLink="concat('ReportList/DesignationReportDetail/',RT.rewardid)";
      $link=$dateLink." as Detail___link,";

      $SelectColumn=$link."RM.reward as 'Reward',RM.rank as 'Designation',count(*) as 'Total Eligible Member'";
      $LevelIncomeList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,$JoinType,'RM.id asc',' RT.rewardid'); 
      $LevelIncomeList=json_decode($LevelIncomeList,true);  
      return  $LevelIncomeList;
   }
   public function Rewardandawarddetail($data=array()){
      $rid=$data['rid'];
      $MainTable="`mlm_rewardtransaction` AS RT";
      $JoinTable=array();
      $JoinTable[0]="mlm_userlogin AS UL";
      $JoinTable[1]="mlm_userdetail AS UD";
      $JoinTable[2]=" mlm_rewardmaster AS RM";
    
      $JoinOn=array();
      $JoinOn[0]="UL.id = RT.userid";
      $JoinOn[1]="UD.userid = RT.userid";
      $JoinOn[2]="RT.rewardid=RM.id";

      $JoinType = array();
      /*$JoinType[2]="LEFT";
      $JoinType[3]="LEFT";
    */
      $Condition="RT.rewardid='$rid'";

      $SelectColumn="RT.entrydate as 'Entrydate___convertdate',UL.username AS 'Member Id',UD.fullname AS 'Member Name',RM.rank as 'Designation',RM.reward AS 'Reward'";
      $LevelIncomeList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,$JoinType,'RT.entrydate asc'); 
      $LevelIncomeList=json_decode($LevelIncomeList,true);  
      return  $LevelIncomeList;
   }
} 
?>