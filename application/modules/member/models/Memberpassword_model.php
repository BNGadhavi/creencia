<?php

Class Memberpassword_model extends CI_Model {

	public function checkpassword($data)
	{
		$condition = "id = " . "'" . $data['userid'] . "' AND " . "password =" . "'" . $data['oldPassword'] . "'";
		$this->db->select('*');
		$this->db->from('mlm_userlogin');
		$this->db->where($condition);
		$this->db->limit(1);
		//echo "245454545";
		$query = $this->db->get();

		//echo $this->db->last_query();

		if ($query->num_rows() == 1) {
			return true;
		} else {
			return false;
		}	

	
	}

	public function checkTransactionPassword($data)
	{
		$userid=$data['userid'];
		$oldPassword=$data['oldPassword'];
		$Condition = "id ='$userid' and securitypassword='$oldPassword'";
		$MainTable="mlm_userlogin";
		$Validate=CreateSingleQuery($MainTable,$Condition);
		$Validate = json_decode($Validate,true);
		$response=array();
		$response['status']=false;
		if($Validate['status']){
			$response['status']=true;
		}
		return $response;
	
	
	}

	public function updatepassword($data){

		$oldPassword=$data['oldPassword'];
        $newPassword=$data['newPassword'];
        $userid=$data['userid'];

        $updateData=array();
        $updateData['password'] = $newPassword;
          
        $Condition=array();
        $Condition['id']=$userid;
        
        $records=UpdateData('mlm_userlogin',$updateData,$Condition);
        $response['status']=false;
        if($records > 0){
        	$response['status']=true;
        }

        return $response;

	}

	public function updateTransactionPassword($data){
		$oldPassword=$data['oldPassword'];
        $newPassword=$data['newPassword'];
        $userid=$data['userid'];

        $updateData=array();
        $updateData['securitypassword'] = $newPassword;
          
        $Condition=array();
        $Condition['id']=$userid;
        
        $records=UpdateData('mlm_userlogin',$updateData,$Condition);
        $response['status']=false;
        if($records > 0){
        	$response['status']=true;
        }

        return $response;
	}

	public function ForgetTransactionPasswordSMS($data){
		$userid=$data['userid'];
		$response=array();

		$data=array();
		$data['extraColumn']=",B.fullname,A.securitypassword,B.mobile";
		$records=FetchMemberInfo($userid,$data);

		$SmsSendData=array();
	   	$SmsSendData['memberid'] = $records['data'][0]['username'];
	   	$SmsSendData['securitypassword'] = $records['data'][0]['securitypassword'];
	   	$SmsSendData['fullName'] = $records['data'][0]['fullname'];

	   	$mobile=$records['data'][0]['mobile'];

	   	SmsSend($SmsSendData,$mobile,4);

	   	$start=substr($mobile,0,2);
        $end=substr($mobile,8,10);
        $final=$start."xxxxxx".$end;


	   	$response['status']=true;
	   	$response['mobile']=$final;
	   	return $response;

	}

}

?>