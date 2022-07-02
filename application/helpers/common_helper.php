<?php 
if (! defined('BASEPATH')) exit('No direct script access allowed');
	function CreateSingleQuery($MainTable,$Condition,$SelectColumn="*",$OrderBy='',$GroupBy='',$LimitArray=array()) {
		$ci =& get_instance();
	 	$ci->db->select($SelectColumn);
		$ci->db->from($MainTable);	
		$ci->db->where($Condition);
		if($GroupBy != ''){
			$ci->db->group_by($GroupBy);
		}
		
		if($OrderBy != ''){
			$ci->db->order_by($OrderBy);
		}
		if(!empty($LimitArray)){
			if(!isset($LimitArray['start'])) $LimitArray['start']=0;
			$ci->db->limit($LimitArray['limit'],$LimitArray['start']);
		}
		
		$query = $ci->db->get();
		//echo $ci->db->last_query();
		$result=$query->result();
		
		$response=array();	
		$response['status']=false;
		$response['query']=$ci->db->last_query();
		if ($query->num_rows() >= 1)
		{
			$response['status']=true;
			$response['data']=$result;
		}
		return json_encode($response);
	}
    function CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,$JoinType=array(),$OrderBy='',$GroupBy='',$LimitArray=array()) { 
	  	$ci =& get_instance();
	 	$ci->db->select($SelectColumn);
		$ci->db->from($MainTable);	
		for($i=0;$i<count($JoinTable);$i++)
		{	
			if(array_key_exists($i, $JoinType))
			{
				$ci->db->join($JoinTable[$i],$JoinOn[$i],$JoinType[$i]);						
			}
			else
			{
				$ci->db->join($JoinTable[$i],$JoinOn[$i]);			
			}
			
		}
		$ci->db->where($Condition);
		if($GroupBy != ''){
			$ci->db->group_by($GroupBy);
		}
		if($OrderBy != ''){
			$ci->db->order_by($OrderBy);
		}
		if(!empty($LimitArray)){
			if(!isset($LimitArray['start'])) $LimitArray['start']=0;
			$ci->db->limit($LimitArray['limit'],$LimitArray['start']);
		}
		$query = $ci->db->get();
		//echo $ci->db->last_query();
		$result=$query->result();
		
		$response=array();	
		$response['status']=false;
		$response['query']=$ci->db->last_query();
		$response['data']=array();
		if ($query->num_rows() >= 1)
		{
			$response['status']=true;
			$response['data']=$result;
		}
		//print_r($response);
		return json_encode($response);
		
    }
    function InsertData($tableName,$data)
    {
    	$ci =& get_instance();
     	$ci->db->insert($tableName, $data);
     	return $ci->db->insert_id();
    }
    function UpdateData($tableName,$data,$Condition)
    {
    	$ci =& get_instance();
    	foreach ($Condition as $key => $value) {
    		
    		$ci->db->where($key,$value);	
    	}
    	$ci->db->update($tableName, $data);
    	return $ci->db->affected_rows();
    	//echo $ci->db->last_query();
    	
    }
    function DeleteQuery($tableName,$Condition)
    {
    	if(empty($Condition)){
    		$response=array();
    		return $response['msg'] = "Condition is missing.";
    	}
    	$ci =& get_instance();
    	$ci->db->delete($tableName, $Condition);
    	return $ci->db->affected_rows();
    }
    function DirectQuery($query){
    	$ci =& get_instance();
    	$data=$ci->db->query($query);
    	return $data;
    	//echo $ci->db->last_query();
    }
    function GetCompanyName()
    {
    	$companyName="CREENCIA";
    	return $companyName;
    }
    function ConvertDate($date)
    {	
    	if($date=='' || $date=='0000-00-00 00:00:00'){
			
			return "--";
		}
		else{
			$date=date_create($date);
			return date_format($date,"d-m-Y");	
		}
    	
    }

    function ConvertDateTime($date)
    {	
    	if($date=='' || $date=='0000-00-00 00:00:00'){
			
			return "--";
		}
		else{
			$date=date_create($date);
			return date_format($date,"d-m-Y H:i:s");	
		}
    	
    }

    function getMemberName($userid) {
		$selectProfile = "SELECT * FROM mlm_userdetail WHERE userid = '$userid'";
		$resultSelect = DirectQuery($selectProfile);
		$resultSelect = $resultSelect->result_array();
		return $resultSelect[0]['fname'];
	}
    function CurrentDate()
    {
    	date_default_timezone_set("Asia/Kolkata");
    	return date("Y-m-d H:i:s");
    }
    function imageUpload($fieldName,$imageName,$folderName,$sizeCondition=array())
    {	
    	$ci =& get_instance();
    	$mainFolder="./assets/images/";
    	
    	//$imageName=time().'_'.$imageName;

    	$ext = pathinfo($imageName, PATHINFO_EXTENSION);

    	//$imageName=time().'_'.$imageName;
    	$imageName=time().'.'.$ext;

    	$updateImageName=strtolower(preg_replace('/[^a-zA-Z0-9-_.]/','', $imageName));
	    
	    $config['upload_path'] = $mainFolder.$folderName; 
	    $config['file_name'] = $updateImageName;
	    $config['overwrite'] = TRUE;
	    $config["allowed_types"] = 'jpg|jpeg|png|gif';
	    if(!empty($sizeCondition)){
		    $config["max_size"] = 1024;
		    $config["max_width"] = 400;
		    $config["max_height"] = 400;
	    }
	    $ci->load->library('upload', $config);
	    $ci->upload->initialize($config);
	    $response['status']=false;
	    if(!$ci->upload->do_upload($fieldName)) {               
	    	$response['msg']=strip_tags($ci->upload->display_errors());
	       
	    } else {
	      $response['status']=true;
	      $response['imageName']=$updateImageName;
	    }  	
	    
	   return $response;
    }

    function multiimageUpload($fieldName, $folderName, $sizeCondition=array()) {
    	
    	$ci =& get_instance();
    	$ci->load->library('upload');
    	$mainFolder="./assets/images/";

    	$imageresponse = array();
    	$response['status'] = false;
        $ImageCount = count($_FILES[$fieldName]['name']);

        for($i = 0; $i < $ImageCount; $i++) {
    		$imageName = $_FILES[$fieldName]['name'][$i];
    		$ext = pathinfo($imageName, PATHINFO_EXTENSION);

    		//$imageName=time().'_'.$imageName;
	    	$randNumber=rand(10,10000);
	    	$imageName=$randNumber."_".time().'.'.$ext;
	    	$updateImageName=strtolower(preg_replace('/[^a-zA-Z0-9-_.]/','', $imageName));
			
			$config['upload_path'] = $mainFolder.$folderName;
			$config['file_name'] = $updateImageName;
	        $config['allowed_types'] = 'jpg|jpeg|png';
	        
		    if(!empty($sizeCondition)) {
			    $config["max_size"] = 1024;
			    $config["max_width"] = 600;
			    $config["max_height"] = 600;
		    }

		    $_FILES['file']['name']       = $_FILES[$fieldName]['name'][$i];
	        $_FILES['file']['type']       = $_FILES[$fieldName]['type'][$i];
	        $_FILES['file']['tmp_name']   = $_FILES[$fieldName]['tmp_name'][$i];
	        $_FILES['file']['error']      = $_FILES[$fieldName]['error'][$i];
	        $_FILES['file']['size']       = $_FILES[$fieldName]['size'][$i];

	        $ci->load->library('upload', $config);
	        $ci->upload->initialize($config);

	        // Upload file to server
	        if($ci->upload->do_upload('file')){
	            // Uploaded file data
	            $imageData = $ci->upload->data();
	            $uploadImgData[$i][$fieldName] = $imageData['file_name'];
	            $response['status'] = true;
	            $response['imagename'][] = $updateImageName;
	        }
	        else {
	        	$response['msg']=strip_tags($ci->upload->display_errors());
	        }
	    }
	    return $response;
    }
    function PassIdTable($tableName,$id){
	  	$Condition = "id='$id'";
	    $getData = CreateSingleQuery($tableName,$Condition);
		$getData = json_decode($getData,true);
		return $getData;
    }
    function  GenerateTicketId(){
	   	$l=1;
	   
	    while($l==1)
	    {
	        $encode="123456789";
	        $pos=substr(str_shuffle($encode),0,5);
	        $MainTable="mlm_support";
			$Condition="ticketid='$pos'";
	        
	        $res=CreateSingleQuery($MainTable,$Condition);
			$res=json_decode($res,true);
			if($res['status']==false){
				$l=0;
			}
	    }
	    return $pos;
    }
    
    function  GenerateUserName(){
	   	$l=1;
	   
	    while($l==1)
	    {
	        $encode="123456789";
	        $username=substr(str_shuffle($encode),0,6);
	        //$username="D".$username;
	        $MainTable="mlm_userlogin";
			$Condition="username='$username'";
	        
	        $res=CreateSingleQuery($MainTable,$Condition);
			$res=json_decode($res,true);
			if($res['status']==false){
				$l=0;
			}
	    }
	    return $username;
    }
    function Charges(){
    	$data=array();
    	$data['TDS']=5;
    	$data['AdminCharge']=2;
    	$data['WithoutPanTDS']=10;
    	$data['MinimumWithdrwal']=300;
 		return $data;
    }
    function AdminMenuRight($adminid) {
		$userid = $adminid;
		$MainTable = "mlm_adminmenu AS AM";
		$JoinTable = array();
	    $JoinTable[0] = "mlm_admenusetting AS AMS";
	    $JoinTable[1] = "mlm_admenusetting AS AMS1";
	   
	    $JoinOn = array();
	    $JoinOn[0] = "AM.menuid = AMS.id";
	    $JoinOn[1] = "AMS.parentmenu = AMS1.id";
	   
	    $JoinType = array();
	    $Condition = "AM.userid = '$userid' AND AMS.menushow = '1' AND AMS1.menushow = '1'";
	    $OrderBy = "AMS.parentmenu ASC,AMS.menusrno ASC";
		$SelectColumn = "AMS.id, AMS1.id AS 'Parent Id', AMS1.menuname AS 'Parent Name', AMS.menuname, AMS.parentmenu, AMS.submenu, AM.status, IF(AMS.iconclass='','fa fa-circle-o',AMS.iconclass) AS iconclass , IF(AMS1.iconclass='','fa fa-home',AMS1.iconclass) AS 'Parent Icon', IF(AMS.menulink='#','javaScript:void();',AMS.menulink) AS 'menulink', IF(AMS1.menulink='#','javaScript:void();','AMS1.menulink') AS 'Parent Menulink'";

		$AdminData = CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,$JoinType,$OrderBy);
		$AdminData = json_decode($AdminData,true);  

		$FinalRightData = array();
		foreach ($AdminData['data'] as $key => $value) {
            $parentKey = $value['Parent Id'];
            if(!array_key_exists($parentKey, $FinalRightData)) {
                $FinalRightData[$parentKey]['Parent Menu'] = $value['Parent Name'];
                $FinalRightData[$parentKey]['icon'] = $value['Parent Icon'];
                $FinalRightData[$parentKey]['link'] = $value['Parent Menulink'];
            }
            $FinalRightData[$parentKey]['sub'][$value['id']]['name'] = $value['menuname'];
            $FinalRightData[$parentKey]['sub'][$value['id']]['link'] = $value['menulink'];
            $FinalRightData[$parentKey]['sub'][$value['id']]['icon'] = $value['iconclass'];
        }
		return $FinalRightData;
	}

	function RemoveNull($array){
		foreach ($array as $key => $value) 
		{
			if(is_array($value))
				$array[$key] = RemoveNull($value);
			else
			{
				if (is_null($value))
				$array[$key] = "";
			}
		}
		
		return $array;

	}

	function getProfilePicture($userid) {
		$selectProfile = "SELECT IF(profile='','active.png',profile) AS profile FROM mlm_userdetail WHERE userid = '$userid'";
		$resultSelect = DirectQuery($selectProfile);
		$resultSelect = $resultSelect->result_array();
		return $resultSelect[0]['profile'];
	}
?>