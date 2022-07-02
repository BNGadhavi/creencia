<?php 

if (! defined('BASEPATH')) exit('No direct script access allowed');	
	function FetchMemberInfo($userId,$data=array()){	
		
		
        $MainTable="mlm_userlogin as A";
        $JoinTable=array();
        $JoinTable[0]="mlm_userdetail as B";
       
        $JoinOn=array();
        $JoinOn[0]="A.id=B.userid";
    
        $Condition="A.id='$userId'";
        $SelectColumn="A.id,A.username,B.fullname,A.packagecode,B.state";
        if(isset($data['extraColumn'])){
        	$SelectColumn=$SelectColumn.$data['extraColumn'];
        }
        if(isset($data['extraCondition'])){
        	$Condition=$Condition.$data['extraCondition'];
        }

        $MemberInfo=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn); 
        $MemberInfo=json_decode($MemberInfo,true);  
        return  $MemberInfo;
		
	}
 	
        function FindIdUsingMemberidHelper($Memberid)
        {
         $MainTable="mlm_userlogin";
         $Condition="username='$Memberid'";
         $SelectColumn="id";
         $GetId=CreateSingleQuery($MainTable,$Condition,$SelectColumn);
         $GetId=json_decode($GetId,true);
         if($GetId['status']){
                return $GetId['data'][0]['id'];       
         }
         else{
                return false;
         }
         
        }
?>