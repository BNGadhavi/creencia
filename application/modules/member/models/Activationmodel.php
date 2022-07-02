<?php
Class Activationmodel extends CI_Model {
  public function ActivationList($data){
    $userId=$data['userId'];
    $status=$data['status'];
  
      $MainTable="mlm_useractivation` as A";
      $JoinTable=array();
      $JoinTable[0]="mlm_userlogin as B";
      $JoinTable[1]="mlm_packagesetting as C";
      $JoinTable[2]="mlm_userlogin as D";
      $JoinTable[3]="mlm_userdetail as E";
    
      $JoinOn=array();
      $JoinOn[0]="A.fromid=B.id";
      $JoinOn[1]="A.packagecode=C.id";
      $JoinOn[2]="A.userid=D.id";
      $JoinOn[3]="D.id=E.userid";
      
      $JoinType=array();
      
      $paymentMode="case when A.activetype='0' then 'Wallet' when A.activetype='1' then 'Capital Wallet' else 'Pin' end As 'Mode'";
      if($status==0)
      {
        $Condition="(A.userid='$userId' or fromid='$userId') and A.lockpackage='0'";
      }
      else if($status=='2')
      {
        $Condition="(A.userid='$userId') and A.lockpackage='0'";
      }
      else
      {
        $Condition="(A.userid='$userId' or fromid='$userId') and A.lockpackage='1'";
      }
      $columns='';
      $link="";
      $SelectColumn=$link.$columns."A.entrydate as 'Activation Date___convertdate',concat(D.username,'<br>' ,E.fullname) as 'Member Info' ,A.netamount as 'Package Amount ($)',B.username as 'Activation By',".$paymentMode;
     
      $ActivationList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,$JoinType,'A.entrydate desc'); 
      $ActivationList=json_decode($ActivationList,true);  
      // /echo $this->db->last_query();
      return  $ActivationList;

  }	
}

?>