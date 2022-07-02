<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MemberProfile extends MX_Controller {
	public function __construct()
    {
    	parent::__construct();
    	$this->load->helper('url');
    	$this->load->helper('security');
      $this->load->helper('common_helper');

      $this->load->model('Memberprofilemodel');
      $this->load->model('Statemodel');
      $this->load->model('Citymodel');


      

      $logged_in = $this->session->userdata('logged_in');
      $userid=$logged_in['userid'];
      $this->sessionUserid=$userid;
      
    }

	public function index()
	{

    $userId=$this->sessionUserid;
    $data=array();
    $data['userid']=$userId;
    $response=array();
    $response_profile=$this->Memberprofilemodel->GetMemberProfileData($data);  
  
    $state=array();
    $response_state=$this->Statemodel->GetStateList($state);  

    if($response_state['status'])
    {
      $state_list=$response_state['result'];         
    }
    else
    {
      $state_list=array(); 
    }


    $city_list=array();

   if($response_profile[0]->city != 0 && $response_profile[0]->city != '')
    {
      $city_param['city_id']=$response_profile[0]->city;
      $city_list=$this->Citymodel->GetCityList($city_param);  
      $city_list=$city_list['result'][0];  
    }
    else
    {
     $city_list=array(); 
    }

     $response['response_profile']=$response_profile[0];  
     $response['response_state']=$state_list;  
     $response['response_city']=$city_list;  

     $this->load->view('EditProfile',$response);


	}

  public function MemberProfileSubmit()
  {
    $userId=$this->sessionUserid;
    $data=array();
    
    $data['userId']         =    $userId;
    $data['FullName']       =    $this->input->post('FullName');
    $data['Email']          =    $this->input->post('Email');
    $data['Mobile']         =    $this->input->post('Mobile');
    $data['Whatsapp']       =    $this->input->post('Whatsapp');
    //$data['Pancard']        =    $this->input->post('Pancard');
    $data['Address']        =    $this->input->post('Address');
    $data['pincode']        =    $this->input->post('pincode');
    $data['State']          =    $this->input->post('State');
    $data['City']           =    $this->input->post('City');
    $data['NomineeName']    =    $this->input->post('NomineeName');
    $data['NomineeRel']     =    $this->input->post('NomineeRel');
    $data['BankAccName']    =    $this->input->post('BankAccName');
    $data['BankAccNo']      =    $this->input->post('BankAccNo');
    $data['BankName']       =    $this->input->post('BankName');
    $data['Otherbankname']  =    $this->input->post('Otherbankname');
    $data['BankBranch']     =    $this->input->post('BankBranch');
    $data['type']           =    $this->input->post('type');    
    $data['BankIfsc']       =    $this->input->post('BankIfsc');    
    $response_profile=$this->Memberprofilemodel->UpdateMemberProfileData($data);  

    $response=array();
    if($response_profile)
    {
      
        $response['status']=true;             
    }
    else
    {
        $response['status']=false;    
        $response['msg']="Some Error Occur";    
    }

    print_r(json_encode($response));

  }
  
  public function WelcomeLetter()
  {
      $userId=$this->sessionUserid;
      
      //$userId=3;
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

      $this->load->view('welcomeletter',$response);
    
  }
  public function GetCityStateWise()
  {

      $state_id=$this->input->post('state');  
      $city_param['state_id']=$state_id;
      $city_list=$this->Citymodel->GetCityList($city_param);  

      $response=array();
      $response['status']=false;
      if($city_list['status'] == true)
      {
        $response['status']=true;
        $response['result']=$city_list['result'];
      }
     
      print_r(json_encode($response));
   


  }

  

}
?>