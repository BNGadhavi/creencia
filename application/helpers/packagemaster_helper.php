<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');	
	function PackageListForAdmin($data=array()){
		$MainTable="mlm_packagesetting";
		$Condition="view='view'";
		$link='id,';
		if(!isset($data['packageId'])){
			$link="concat('PackageList/EditPackageMaster/',id) as Edit___link,";
		}
		else{
			$packageId=$data['packageId'];
			$Condition=$Condition." and id='$packageId'";
		}

		$roiColumn="roi as 'Roi Amount',roidays as 'Roi Days',capping as 'Capping'";
		$roiColumn='';
		$SelectColumn=$link."id as 'id___hide',packagename as 'Package Name',mrp as 'MRP',netmrp as 'Net Amount',".$roiColumn.",pv as 'GP',bv as 'PV',priority as 'Priority',capping as 'Capping',editFlag as 'Edit___hide'";
		$PackageList=CreateSingleQuery($MainTable,$Condition,$SelectColumn,'priority');
        $PackageList=json_decode($PackageList,true);  
        return  $PackageList;
	}
?>