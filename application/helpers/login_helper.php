<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');	
	function MemberLoginHelper($data){
		$userName=$data['userName'];
		$passWord=$data['passWord'];

		$response=array();
		$response['status']=false;

	
		$MainTable="mlm_userlogin";
		$JoinTable=array();
		$JoinTable[0]="mlm_userdetail";

		$JoinOn=array();
		$JoinOn[0]="mlm_userlogin.id=mlm_userdetail.userid";
    
      $Condition="mlm_userlogin.username='$userName' and mlm_userlogin.password='$passWord'";
      $SelectColumn="mlm_userlogin.id,mlm_userlogin.username,mlm_userdetail.fullname,mlm_userlogin.lockmember,";
     
      $loginData=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn); 
      $loginData=json_decode($loginData,true);  

      	if($loginData['status']){
      		$response['status']=true;
      		$response['data']=$loginData['data'];
      	}

      	return $response;


		
	
	}

	
?>