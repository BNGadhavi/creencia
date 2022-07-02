<?php
Class Memberprofilemodel extends CI_Model {

	public function __construct()
    {
        parent::__construct();
    }

	public function GetMemberProfileData($data)
	{
		$userId=$data['userid'];

		$condition = "userid = " . "'" . $userId ."'";
		$this->db->select('*');
		$this->db->from('mlm_userdetail');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		$result=$query->result();

		return $result;

	}

	public function UpdateMemberProfileData($data)
	{
		$this->db->set('fname', $data['FullName']); 
		$this->db->set('fullname', $data['FullName']); 
		$this->db->set('email', $data['Email']); 
		$this->db->set('mobile', $data['Mobile']); 
		$this->db->set('whatsapp', $data['Whatsapp']); 
		//$this->db->set('panno', $data['Pancard']); 
		$this->db->set('address', $data['Address']); 
		$this->db->set('pincode', $data['pincode']); 
		$this->db->set('state', $data['State']); 
		$this->db->set('city', $data['City']); 
		$this->db->set('nominee', $data['NomineeName']); 
		$this->db->set('nomineerel', $data['NomineeRel']); 
		/*$this->db->set('bankaccname', $data['BankAccName']); 
		$this->db->set('bankname', $data['BankName']); 
		$this->db->set('bankbranch', $data['BankBranch']); 
		$this->db->set('bankifsc', $data['BankIfsc']); 
		$this->db->set('banktype', $data['type']); 
		$this->db->set('bankaccno', $data['BankAccNo']); */
		$this->db->where('userid', $data['userId']); 
		$update=$this->db->update('mlm_userdetail');
		//echo $this->db->last_query();
		$arrres=array();
		if($update>=1)
		{
			$arrres['status']=true;
		}
		else
		{
			$arrres['status']=false;
		}

		return $arrres;
	}

	public function WelcomeLetterData($data){
		$userId=$data['userId'];
		$MainTable="mlm_userdownline";

		$JoinTable=array();
		$JoinTable[0]="mlm_userlogin";
		$JoinTable[1]="mlm_userdetail";

		$JoinOn=array();
		$JoinOn[0]="mlm_userdownline.sponsor = mlm_userlogin.id";
		$JoinOn[1]="mlm_userlogin.id = mlm_userdetail.userid";


		$Condition="mlm_userdownline.userid='$userId'";
		$SelectColumn="mlm_userlogin.id,mlm_userlogin.username,mlm_userdetail.fname";
		$Query_Response=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn);

		$Query_Response=json_decode($Query_Response,true);


		$Create_Wl=CreateSingleQuery("mlm_smssetting","SMSType='Member Welcome'");
		$Create_Wl=json_decode($Create_Wl,true);    


		$MainTable="mlm_userlogin";

		$JoinTable=array();
		$JoinTable[0]="mlm_userdetail";
		$JoinTable[1]="mlm_cities";


		$JoinOn=array();
		$JoinOn[0]="mlm_userlogin.id = mlm_userdetail.userid";
		$JoinOn[1]="mlm_userdetail.city = mlm_cities.id";

		$JoinType=array();
		$JoinType[1]="left";

		$Condition="mlm_userlogin.id='$userId'";
		$SelectColumn="mlm_userlogin.id,mlm_userlogin.username,mlm_userdetail.fname,mlm_userdetail.city,mlm_userdetail.address,mlm_cities.name,mlm_userdetail.pincode";
		$Member_Que_Response=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,$JoinType); 
		$Member_Que_Response=json_decode($Member_Que_Response,true);    

		$SponsorDetail=array();
		if($Query_Response['status'])
		{
		$SponsorDetail=$Query_Response['data'][0];
		}
		$response['WelcomeLetter']=$Create_Wl['data'][0];
		$response['SponsorInfo']=$SponsorDetail;
		$response['UserInfo']=$Member_Que_Response['data'][0];

		return $response;

	}

}

?>