<?php

Class LoginModel extends CI_Model {

	public function ValidateUsername($username){
		$username=$username;
   		$MainTable="mlm_admintable";
      	$Condition="username='$username'";
      	$CheckUsername=CreateSingleQuery($MainTable,$Condition); 
      	$CheckUsername=json_decode($CheckUsername,true);  
      	return $CheckUsername;		

	}
	public function ValidateLogin($data){
		$username=$data['username'];
		$password=$data['password'];
   		$MainTable="mlm_admintable";
      	$Condition="username='$username' and password='$password'";
      	$CheckLogin=CreateSingleQuery($MainTable,$Condition); 
      	$CheckLogin=json_decode($CheckLogin,true);  
      	return $CheckLogin;		
	}
}
?>