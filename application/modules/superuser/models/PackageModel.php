<?php
Class PackageModel extends CI_Model {
   public function AddPackageMaster($data){
      $packageName=$data['packageName'];
      $amount=$data['amount'];
      $packagePV=$data['packagePV'];
      $tax=$data['tax'];
      $roiAmt=$data['roiAmt'];
      $roiDays=$data['roiDays'];
      $capping=$data['capping'];
      $directPer=$data['directPer'];
      $addedby=$data['addedby'];
      $packageBV=$data['packageBV'];
      $priority=$data['priority'];
      $shoppingbal=$data['shoppingbal'];

      $netamount=$amount+$tax;
      $insertPackageData= array();
      $insertPackageData['entrydate'] = CurrentDate();
      $insertPackageData['packagename'] = $packageName;
      $insertPackageData['activestatus'] = '1';
      $insertPackageData['priority'] = $amount;
      $insertPackageData['mrp'] = $amount;
      $insertPackageData['tax'] = $tax;
      $insertPackageData['netmrp'] = $netamount;
      $insertPackageData['pv'] = $packagePV;
      $insertPackageData['roi'] = $roiAmt;
      $insertPackageData['roidays'] = $roiDays;
      $insertPackageData['roiinterval'] = 1;
      $insertPackageData['directper'] = $directPer;
      $insertPackageData['addedby'] = $addedby;
      $insertPackageData['capping'] = $capping;
      $insertPackageData['bv'] = $packageBV;
      $insertPackageData['priority'] = $priority;
      $insertPackageData['shoppingbal'] = $shoppingbal;
      $packageId=InsertData('mlm_packagesetting',$insertPackageData);

      $response=array();
      $response['status']=false;
      if($packageId > 0){
         $response['status']=true;
      }  

      return $response;


   }
   public function UpdatePackageMaster($data){
      $packageId=$data['packageId'];
      $packageName=$data['packageName'];
      $amount=$data['amount'];
      $packagePV=$data['packagePV'];
      $tax=$data['tax'];
      $roiAmt=$data['roiAmt'];
      $roiDays=$data['roiDays'];
      $capping=$data['capping'];
      $directPer=$data['directPer'];
      $updateby=$data['addedby'];
      $packageBV=$data['packageBV'];
      $priority=$data['priority'];

      $netamount=$amount+$tax;
      $updateData=array();
      $updateData['updatedate'] = CurrentDate();
      $updateData['packagename'] = $packageName;
      $updateData['activestatus'] = '1';
      $updateData['priority'] = $amount;
      $updateData['mrp'] = $amount;
      $updateData['tax'] = $tax;
      $updateData['netmrp'] = $netamount;
      $updateData['pv'] = $packagePV;
      $updateData['roi'] = $roiAmt;
      $updateData['roidays'] = $roiDays;
      $updateData['roiinterval'] = 1;
      $updateData['directper'] = $directPer;
      $updateData['updateby'] = $updateby;
      $updateData['capping'] = $capping;
      $updateData['bv'] = $packageBV;
      $updateData['priority'] = $priority;
      $updateData['shoppingbal'] = $shoppingbal;
      
      $Condition=array();
      $Condition['id']=$packageId;

      $updateRes=UpdateData('mlm_packagesetting',$updateData,$Condition);
      $response=array();
      $response['status']=false;
      if($updateRes > 0){
         $response['status']=true;
      }
      return $response;
   }

}
?>