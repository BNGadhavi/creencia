<?php
Class AdminModel extends CI_Model {

	public function GetPackageList($data=array()){
      $MainTable="mlm_packagesetting";
      $Condition="1=1";
      if(isset($data['condition'])){
            $Condition=$Condition.$data['condition'];
      }
      $SelectColumn="id,packagename,netmrp as 'mrp'";
      $OrderBy="packagename";
      $packageList=CreateSingleQuery($MainTable,$Condition,$SelectColumn,$OrderBy);
      $packageList=json_decode($packageList,true);
      return $packageList;
	}

      public function checkMemberId($username,$condition='',$extraColumn=''){
        $MainTable="mlm_userlogin";
        $JoinTable=array();
        $JoinTable[0]="mlm_userdetail";
        $JoinOn=array();
        $JoinOn[0]="mlm_userlogin.id = mlm_userdetail.userid";
        $MainCondition="mlm_userlogin.username='$username'";
        if($condition !=''){
            $MainCondition=$MainCondition.$condition;
        }
        $SelectColumn="mlm_userlogin.id,mlm_userdetail.fname as 'Name',mlm_userlogin.activestatus";
        if($extraColumn!=''){   
          $SelectColumn=$SelectColumn.$extraColumn;
        }
        $CheckMember=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$MainCondition,$SelectColumn); 
        $CheckMember=json_decode($CheckMember,true);
        return $CheckMember;

      }

      public function checkFranchiseeId($username,$condition=''){
        $MainTable="mlm_franchlogin";
        $JoinTable=array();
        $JoinTable[0]="mlm_franchdetail";
        $JoinOn=array();
        $JoinOn[0]="mlm_franchlogin.id = mlm_franchdetail.userid";
        $MainCondition="mlm_franchlogin.username='$username'";
        if($condition !=''){
            $MainCondition=$MainCondition.$condition;
        }
        $SelectColumn="mlm_franchlogin.id,mlm_franchdetail.fullname as 'Name'";
        
        $CheckFranchisee=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$MainCondition,$SelectColumn); 
        $CheckFranchisee=json_decode($CheckFranchisee,true);
        return $CheckFranchisee;

      }
      public function GetProductList($data=array()){
      $MainTable="mlm_productmaster";
      $Condition="status ='0'";
      if(isset($data['condition'])){

            $Condition=$Condition.$data['condition'];
      }
      $OrderBy="entrydate desc";
      $productList=CreateSingleQuery($MainTable,$Condition,'',$OrderBy);
      $productList=json_decode($productList,true);
      return $productList;
  }


	
}
?>