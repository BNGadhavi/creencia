<?php
Class Commonmodel extends CI_Model {

	public function GetPackageList($userid,$data=array()){
		$userId=$userid;
		$MainTable="mlm_packagesetting";
		$Condition="1=1";
        if(isset($data['condition'])){
            $Condition=$Condition.$data['condition'];
        }
		$SelectColumn="id,packagename,mrp,netmrp";
        if(isset($data['extraColoumn'])){
            $SelectColumn=$SelectColumn.",".$data['extraColoumn'];
        }
        $OrderBy="id";
		$packageList=CreateSingleQuery($MainTable,$Condition,$SelectColumn,$OrderBy);
		$packageList=json_decode($packageList,true);
		return $packageList;

	}

	public  function CheckMemberidValid($memberId,$data=array()){
	    $MainTable="mlm_userlogin";
        $JoinTable=array();
        $JoinTable[0]="mlm_userdetail";
        $JoinOn=array();
        $JoinOn[0]="mlm_userlogin.id = mlm_userdetail.userid";
        $Condition="mlm_userlogin.username='$memberId'";
        $SelectColumn="mlm_userlogin.id,mlm_userdetail.fname,mlm_userlogin.activestatus,mlm_userlogin.packagecode,mlm_userlogin.lockmember,mlm_userdetail.mobile,mlm_userlogin.renewal";

        if(isset($data['memberstatus']))
        {
        	$Condition = $Condition." and mlm_userlogin.status = ".$data['memberstatus'];
        }

        if(isset($data['activestatus']))
        {
        	$Condition = $Condition." and mlm_userlogin.activestatus = ".$data['activestatus'];
        }

        if(isset($data['selfid']))
        {
        	$Condition = $Condition." and mlm_userlogin.id != ".$data['selfid'];
        }

        $CheckMember=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn); 
        $CheckMember=json_decode($CheckMember,true);
        return $CheckMember;		

	}


    public  function FindIdUsingMemberid($Memberid){
         $MainTable="mlm_userlogin";
         $Condition="username='$Memberid'";
         $SelectColumn="id";
         $GetId=CreateSingleQuery($MainTable,$Condition,$SelectColumn);
         $GetId=json_decode($GetId,true);
         return $GetId['data'][0]['id'];

    }

    public function FindSponsorId($Userid){
            $MainTable="mlm_userdownline";
            $Condition="userid='$Userid'";
            $GetId=CreateSingleQuery($MainTable,$Condition);
            $GetId=json_decode($GetId,true);
            $sponsorId=$GetId['data'][0]['sponsor'];

            $MainTable="mlm_userlogin";
            $JoinTable=array();
            $JoinTable[0]="mlm_userdetail";
            $JoinOn=array();
            $JoinOn[0]="mlm_userlogin.id = mlm_userdetail.userid";
            $Condition="mlm_userlogin.id='$sponsorId'";
            $SelectColumn="mlm_userlogin.id,mlm_userdetail.fname,mlm_userlogin.activestatus,mlm_userlogin.packagecode,mlm_userlogin.lockmember";
            $SponsorInfo=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn);
            $SponsorInfo=json_decode($SponsorInfo,true);
            return $SponsorInfo;    

    }
}
