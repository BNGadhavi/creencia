<?php
Class Registermodel extends CI_Model {

	public function JoiningInfo($data){
		$username=$data['username'];
		$MainTable="mlm_userlogin";
		$JoinTable=array();
		$JoinTable[0]="mlm_userdetail";
		$JoinOn=array();
		$JoinOn[0]="mlm_userlogin.id = mlm_userdetail.userid";
		$Condition="mlm_userlogin.username='$username'";
		$SelectColumn="mlm_userlogin.username,mlm_userlogin.password,mlm_userdetail.fullname";

		$memberData=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn); 
      	$memberData=json_decode($memberData,true);
      	return $memberData;
	}
	public function SmsData($data){
		$id=$data['id'];
		$getSmsData=PassIdTable('mlm_smssetting',$id);
		return $getSmsData;
	}

	public function ForgetPasswordProcess($data){
		$userId=$data['userId'];
		$forgetData=array();
		$forgetData['extraColumn']=",B.email,A.password";
		$fetchMemberInfo=FetchMemberInfo($userId,$forgetData);
		$email=$fetchMemberInfo['data'][0]['email'];
		$smsReposne=array();
		$smsReposne['status']=false;
   		if($email!='')
   		{
   			$smsReposne['status']=true;
   			Forgotpass($fetchMemberInfo['data'][0]['username'],$fetchMemberInfo['data'][0]['password'],$email);	
   		}
   		return $smsReposne;
	}
}

?>