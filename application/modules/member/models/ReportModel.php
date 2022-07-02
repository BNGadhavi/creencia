<?php
Class ReportModel extends CI_Model {
   public function BinaryReport($userid,$data=array()){
      $userId=$userid;
   	$MainTable="mlm_binaryincome";
      $Condition="userid='$userId'";
      $SelectColumn="entrydate as 'Date___convertdate',bfl,bfr,cl,cr,totalleft,totalright,mp as 'Match Pair',amount, cfl,cfr";
      $OrderBy="entrydate asc";
      
      $BinaryList=CreateSingleQuery($MainTable,$Condition,$SelectColumn,$OrderBy); 
      $BinaryList=json_decode($BinaryList,true);  
      return  $BinaryList;
	}
      
  public function RoiReport($userid,$data=array()){
      $userId=$userid;
      $MainTable="mlm_roiincome";
      $JoinTable=array();
      $JoinTable[0]="mlm_userlogin";
      $JoinTable[1]="mlm_userdetail";
    
      $JoinOn=array();
      $JoinOn[0]="mlm_roiincome.userid=mlm_userlogin.id";
      $JoinOn[1]="mlm_userlogin.id=mlm_userdetail.userid";
    
      $Condition="mlm_roiincome.userid='$userId'";
      $SelectColumn="mlm_roiincome.entrydate as 'Date___convertdate',mlm_userlogin.username as 'Member ID',mlm_userdetail.fullname as 'Member Name',mlm_roiincome.netamount as 'Amount'";
     
      $RoiList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn); 
      $RoiList=json_decode($RoiList,true);  
      return  $RoiList;
  }   

  public function SponsorReport($userid,$data=array()){
 

      $userId=$userid;
      $MainTable="mlm_sponsorincome as A";
      $JoinTable=array();
      $JoinTable[0]="mlm_userlogin as B";
      $JoinTable[1]="mlm_userdetail as C";
      $JoinTable[2]="mlm_packagesetting as D";
      $JoinTable[3]="mlm_packagesetting AS E";
    
      $JoinOn=array();
      $JoinOn[0]="A.fromid=B.id";
      $JoinOn[1]="B.id=C.userid";
      $JoinOn[2]="A.packagecode=D.id";
      $JoinOn[3]="A.frompackagecode=E.id";
    
      $Condition="A.userid='$userId'";
      $SelectColumn="A.entrydate as 'Date___convertdate',concat(B.username,'<br>',C.fullname) as 'From id',D.packagename as 'Package Name',D.mrp as 'Package Amount',A.per as 'Per(%)',A.netamount as 'Net Amount' ";
     
      $SponsorIncomeList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn); 
      $SponsorIncomeList=json_decode($SponsorIncomeList,true);  
      return  $SponsorIncomeList;

  }
         



}
?>