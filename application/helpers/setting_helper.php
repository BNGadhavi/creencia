<?php 

if (! defined('BASEPATH')) exit('No direct script access allowed');
 	
function JoiningPinType(){
	/*
	0=Free Joining
	1=With Pin Joining
	*/
	$pintype='0';
	$response=array();
	$response['pintype']=$pintype;
	return $response;

}

function SideFlag(){
	$sideFlag=false;
	$response=array();
	$response['sideFlag']=$sideFlag;
	return $response;

}
	
	
?>