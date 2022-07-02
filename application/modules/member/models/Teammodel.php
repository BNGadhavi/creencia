<?php
Class Teammodel extends CI_Model {
	public function GetSponsorList($userid,$data=array()){
            $userId=$userid;
            $MainTable="mlm_userdownline";
            $JoinTable=array();
            $JoinTable[0]="mlm_userdetail";
            $JoinTable[1]="mlm_userlogin";
            $JoinTable[2]="mlm_packagesetting";
            $JoinOn=array();
            $JoinOn[0]="mlm_userdownline.userid = mlm_userdetail.userid";
            $JoinOn[1]="mlm_userlogin.id = mlm_userdetail.userid";
            $JoinOn[2]="mlm_userlogin.packagecode = mlm_packagesetting.id";
            $JoinType=array();
            $JoinType[2]="left";
            $orderBy="mlm_userdetail.fullname";
            $SideCondition="IF(mlm_userdownline.side='0','Left','Right') as 'Side'";
            $SideCondition='';
            $Condition="mlm_userdownline.sponsor='$userId'";

            if(isset($data['side'])){
                  $Condition=$Condition." and mlm_userdownline.side = '".$data['side']."'";
            }

            $SelectColumn="concat(mlm_userlogin.username,'<br>',mlm_userdetail.fullname) as 'MemberID<br> MemberName',mlm_userlogin.entrydate  as 'Joining Date', IF(mlm_userlogin.activestatus = '1', mlm_userlogin.activedate, '-' ) as 'Active Date',".$SideCondition.",mlm_packagesetting.packagename as 'Package Name'";

            $MemberSponsorList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,$JoinType,$orderBy); 
            $MemberSponsorList=json_decode($MemberSponsorList,true);  
            return  $MemberSponsorList;
	}
	public function GetDownline($userid,$data=array()){
            $MainTable="mlm_userstructure";
            $Condition="uplineid = '$userid' and jointype='1'";
            $SelectColumn="concat('TeamList/DownlineSummary?level=',levelno,'&direct=','0') as Detail___link ,id as id___hide,levelno as 'Level No' ,count(*) as 'Total Member___sum___membersum'";
            $OrderBy="levelno";
            $GroupBy="levelno";
            $DownlineList=CreateSingleQuery($MainTable,$Condition,$SelectColumn,$OrderBy,$GroupBy);
            $DownlineList=json_decode($DownlineList,true);
            return  $DownlineList;
	}
      public function GetDirectDownline($userid,$data=array()){
            $MainTable="mlm_sponsorstructure";
            $Condition="uplineid = '$userid' and levelno<'41'";
            $SelectColumn="concat('TeamList/DownlineSummary?level=',levelno,'&direct=','1') as Detail___link ,id as id___hide,levelno as 'Level No' ,count(*) as 'Total Member___sum___membersum'";
            $OrderBy="levelno";
            $GroupBy="levelno";
            $DownlineList=CreateSingleQuery($MainTable,$Condition,$SelectColumn,$OrderBy,$GroupBy);
            $DownlineList=json_decode($DownlineList,true);
            return  $DownlineList;
      }
	public function GetDownlineLevelwise($userid,$data=array()){
      	$userId=$userid;
      	$MainTable="mlm_userstructure";
            $JoinTable=array();
            $JoinTable[0]="mlm_userdetail";
            $JoinTable[1]="mlm_userlogin";
            $JoinTable[2]="mlm_packagesetting";
            $JoinOn=array();
            $JoinOn[0]="mlm_userstructure.userid=mlm_userdetail.userid";
            $JoinOn[1]="mlm_userlogin.id = mlm_userdetail.userid";
            $JoinOn[2]="mlm_userlogin.packagecode = mlm_packagesetting.id";
            $JoinType=array();
            $JoinType[2]="left";
            $orderBy="mlm_userstructure.levelno";
            $Condition="mlm_userstructure.uplineid='$userId'";
            //$Coloum=",mlm_userdetail.mobile as 'Mobile',mlm_userdetail.email as 'Email',";
            $Coloum=",";
            $GroupBy="";
            if(isset($data['levelno'])){
            	$Condition=$Condition." and mlm_userstructure.levelno = '".$data['levelno']."'";
            } 
            else
            {
            	$Coloum=$Coloum."mlm_userstructure.levelno as Level No,";
            }

            if(isset($data['side'])){
                  $Condition=$Condition." and mlm_userstructure.side = '".$data['side']."'";
            }
            if(isset($data['active'])){
                  $Condition=$Condition." and mlm_userlogin.activestatus = '1'";
            }

            if(isset($data['dateStart'])){
                  $dateStart = $data['dateStart'];
                  $dateStart = date("Y-m-d", strtotime($dateStart));
                  $Condition = $Condition." AND DATE(mlm_userlogin.activedate) >= DATE('$dateStart')";
            }

            if(isset($data['dateEnd'])){
                  $dateEnd = $data['dateEnd'];
                  $dateEnd = date("Y-m-d", strtotime($dateEnd));
                  $Condition = $Condition." AND DATE(mlm_userlogin.activedate) <= DATE('$dateEnd')";
            }
            

            $SideCondition="IF(mlm_userstructure.side='0','Left','Right') as 'Side',";
            //$SideCondition='';
            $SelectColumn="mlm_userlogin.username as 'Member ID',mlm_userdetail.fullname as 'MemberName',mlm_userlogin.entrydate  as 'Joining Date___convertdate',IF(mlm_userlogin.activestatus = '1', mlm_userlogin.activedate, '-' ) as 'Active Date'". $Coloum . $SideCondition." mlm_packagesetting.packagename as 'Package Name'";
         		
            $MemberDownlineList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,$JoinType,$orderBy,$GroupBy); 
            $MemberDownlineList=json_decode($MemberDownlineList,true);  
            return $MemberDownlineList;
	}
      public function GetDirectDownlineLevelwise($userid,$data=array()){
            $userId=$userid;
            $MainTable="mlm_sponsorstructure";
            $JoinTable=array();
            $JoinTable[0]="mlm_userdetail";
            $JoinTable[1]="mlm_userlogin";
            $JoinTable[2]="mlm_packagesetting";
            $JoinOn=array();
            $JoinOn[0]="mlm_sponsorstructure.userid=mlm_userdetail.userid";
            $JoinOn[1]="mlm_userlogin.id = mlm_userdetail.userid";
            $JoinOn[2]="mlm_userlogin.packagecode = mlm_packagesetting.id";
            $JoinType=array();
            $JoinType[2]="left";
            $orderBy="mlm_sponsorstructure.levelno";
            $Condition="mlm_sponsorstructure.uplineid='$userId'";
            $Coloum=",mlm_userdetail.mobile as 'Mobile',mlm_userdetail.email as 'Email',";
            if(isset($data['levelno'])){
                  $Condition=$Condition." and mlm_sponsorstructure.levelno = '".$data['levelno']."'";
            } 
            else
            {
                  $Coloum=$Coloum."mlm_sponsorstructure.levelno as Level No,";
            }
            $SelectColumn="mlm_userlogin.username as 'Member ID',mlm_userdetail.fullname as 'MemberName',mlm_userlogin.entrydate  as 'Joining Date___convertdate'". $Coloum ." mlm_packagesetting.packagename";
                  
            $MemberDownlineList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,$JoinType,$orderBy); 
            $MemberDownlineList=json_decode($MemberDownlineList,true);  
            return $MemberDownlineList;
            
      }   
      public function GetLevelwisebv($userid,$data=array()){
            $userId=$userid;
            $MainTable="mlm_invoicemaster as A";
            $JoinTable=array();
            $JoinTable[0]="mlm_sponsorstructure as B";
            $JoinOn=array();
            $JoinOn[0]="B.userid=A.orderby";
            $JoinType=array();
            $orderBy="B.levelno";
            $Condition="B.uplineid='$userId' and A.ordertype='MP' and A.status in ('1','4') and A.activepurchase='0'";
            $SelectColumn="B.levelno , ifnull(sum(A.bv),0) as 'Total BV'";
            $GroupBy="B.levelno";
            $MemberSponsorList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,$JoinType,$orderBy,$GroupBy); 
            $MemberSponsorList=json_decode($MemberSponsorList,true);  
            //echo $this->db->last_query();
            return  $MemberSponsorList;
	}
}
?>