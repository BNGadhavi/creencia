<?php
Class LoginModel extends CI_Model {

	public function ValidateFranchiseeLogin($data){
		$username=$data['username'];
		$password=$data['password'];
		$MainTable="mlm_franchlogin";
		$Condition="username='$username' and password='$password'";
		$CheckLogin=CreateSingleQuery($MainTable,$Condition); 
		$CheckLogin=json_decode($CheckLogin,true);  
		return $CheckLogin;		
	}

	public function ValidateMemberLogin($data){
		$username=$data['username'];
		$password=$data['password'];
		$MainTable="mlm_userlogin";
		$Condition="username='$username' and password='$password'";
		$CheckLogin=CreateSingleQuery($MainTable,$Condition); 
		$CheckLogin=json_decode($CheckLogin,true);  
		return $CheckLogin;		
	}
}
?>