<?php

Class NewsModel extends CI_Model {

	public function SaveNewsData($data){
		$news=$data['news'];
      
      $insertNewsData=array();
      $insertNewsData['entrydate']=CurrentDate();
      $insertNewsData['news']=$news;
      $insertNewsId=InsertData('mlm_news',$insertNewsData);
      $response=array();
      $response['status']=false;
      if($insertNewsId > 0){
         $response['status']=true;
      }
      return $response;
	}
   
   public function NewsDelete($data){
      $newsId=$data['newsId'];
      
      $tablename="mlm_news";
      $Condition=array();
      $Condition['id'] = $newsId;
      $responseNews=DeleteQuery($tablename,$Condition);

      $response=array();
      $response['status']=false;   
      if($responseNews > 0){
         $response['status']=true;
      }

      return $response;
     
   }
	
   public function SaveAchiverData($data){
      $achiver=$data['achiver'];
      
      $insertAchiverData=array();
      $insertAchiverData['entrydate']=CurrentDate();
      $insertAchiverData['name']=$achiver;
      $insertAchiverId=InsertData('mlm_achiever',$insertAchiverData);
      $response=array();
      $response['status']=false;
      if($insertAchiverId > 0){
         $response['status']=true;
      }
      return $response;
   }

   public function AchiverDelete($data){
      $achiverId=$data['achiverId'];
      
      $tablename="mlm_achiever";
      $Condition=array();
      $Condition['id'] = $achiverId;
      $responseAchiver=DeleteQuery($tablename,$Condition);

      $response=array();
      $response['status']=false;   
      if($responseAchiver > 0){
         $response['status']=true;
      }

      return $response;
     
   }

   public function ValidatePassword($data){
      $userId=$data['userid'];
      $password=$data['oldPassword'];
      $Condition = "id ='$userId' and password='$password'";
      $responsePass=CreateSingleQuery('mlm_admintable',$Condition);
      $responsePass=json_decode($responsePass,true); 
      if ($responsePass['status']) {
         return true;
      } else {
         return false;
      }  
   }

   public function UpdatePassword($data){
      $userId=$data['userId'];
      $oldPassword=$data['oldPassword'];
      $newPassword=$data['newPassword'];

      $updateData=array();
      $updateData['password'] = $newPassword;
      $Condition=array();
      $Condition['id']=$userId;
      UpdateData('mlm_admintable',$updateData,$Condition);
   }

   public  function UpdateLockStatus($data){
      $userId=$data['userId'];
      $status=$data['status'];

      $updateData=array();
      $updateData['lockmember'] = $status;
      $Condition=array();
      $Condition['id']=$userId;
      UpdateData('mlm_userlogin',$updateData,$Condition);

      if($status=='0')
      {
         if($data['lockmem']=='2'){
            $savedate=CurrentDate();
            $lastdate = date('Y-m-d 23:59:59', strtotime($savedate. ' + 4 months'));
            DirectQuery("UPDATE mlm_userlogin set lastdate='$lastdate' where id='$userId'");
        }
      }

      $insertLockData=array();
      $insertLockData['entrydate']=CurrentDate();
      $insertLockData['userid']=$userId;
      $insertLockData['status']=$status;

      $response=array();
      $response['status']=false;
      $lockId=InsertData('mlm_memberlock',$insertLockData);
      if($lockId > 0){
         $response['status']=true;
      }
     return $response;
   }

   public function LockMemberList(){

      $MainTable="mlm_userlogin as A";
      $JoinTable=array();
      $JoinTable[0]="mlm_userdetail as B";
     
      $JoinOn=array();
      $JoinOn[0]="A.id=B.userid";
    
      $Condition="A.lockmember in ('1','2')";
      $link="concat('Utility/UnlockMember/',A.id) as Unlock___link,";
      $SelectColumn=$link."A.username as 'Member ID',B.fullname as 'Member Name',B.mobile as 'Mobile',A.entrydate as 'Joining Date___convertdate',if(A.lockmember='1','Admin Through Lock','Software Lock') as 'Type'";

      $LockMemberList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn); 
      $LockMemberList=json_decode($LockMemberList,true);  
      return  $LockMemberList;
   }

   public function ContactUsDelete($data){
      $id=$data['id'];
      
      $tablename="mlm_contactus";
      $Condition=array();
      $Condition['id'] = $id;
      $responseAchiver=DeleteQuery($tablename,$Condition);

      $response=array();
      $response['status']=false;   
      if($responseAchiver > 0){
         $response['status']=true;
      }
      return $response;
   }

   public  function SaveShippingData($data){
      $buy=$data['buy'];
      $sell=$data['sell'];

      $updateData=array();
      $updateData['entrydate'] =CurrentDate();
      $updateData['amount'] = $buy;
      $Condition=array();
      $Condition['type']="0";
      UpdateData('mlm_nfive',$updateData,$Condition);

      $updateData=array();
      $updateData['entrydate'] =CurrentDate();
      $updateData['amount'] = $sell;
      $Condition=array();
      $Condition['type']="1";
      UpdateData('mlm_nfive',$updateData,$Condition);

      $response['status']=true;
     return $response;
   }
}
?>