<?php
Class Backup_model extends CI_Model {

	public function Report($data=array()){
		$MainTable="mlm_backupmaster as A";
		$JoinTable=array();
		
		$JoinOn=array();
		
		$QueryString='';
		$Condition="1=1";
		
		$link="concat(A.backupfile) as 'Download___link'";
		$SelectColumn="A.entrydate as 'Date___convertdate',".$link;

		$BackupList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,array(),'A.entrydate desc',''); 
		$BackupList=json_decode($BackupList,true);  
		return  $BackupList;
  	}

  	public function Insert($data){
		$filename = $data['filename'];
      	$addedby = $data['addedby'];
      	$insertData=array();
      	$insertData['entrydate']=CurrentDate();
      	$insertData['backupfile']=$filename;
      	$insertData['backupby']=$addedby;
      	echo $insertId=InsertData('mlm_backupmaster',$insertData);
	}
}
?>