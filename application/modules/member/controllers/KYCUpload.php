<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KYCUpload extends MX_Controller {
	public function __construct()
    {
    	parent::__construct();
    	$this->load->helper('url');
      $this->load->helper('member_helper');
      $this->load->helper('kyc_helper');

      /*$this->load->model('Memberprofilemodel');
      $this->load->model('StateModel');
      $this->load->model('CityModel');
      */

      $logged_in = $this->session->userdata('logged_in');
      $userid=$logged_in['userid'];
      $this->sessionUserid=$userid;
    }
  public function NationalCard(){
     $userId=$this->sessionUserid;
     $response=array(); 
     $data=array();
     $data['extraColumn']=",A.adharstatus,B.aadharcard";
     $PanInfo=FetchMemberInfo($userId,$data);

     $kycData=array();
     $kycData['kycId']='1';
     $LastKycInfo=KYCInfoForUser($userId,$kycData);
     $response['AadhaarInfo']=$PanInfo;
     $response['LastKycInfo']=$LastKycInfo;
     $this->load->view('aadhaarUpload',$response);
  }

  public function AadhaarCardSubmit(){  
    $userId=$this->sessionUserid;
    $response=array();
    $response['status']=false;
    $imageResponse=array();
   
    if(isset($_FILES['proof']['name']))
    {
      $imageResponse=imageUpload('proof',$_FILES['proof']['name'],'KYCUpload');
      if(!$imageResponse['status']){
        $response['msg']=$imageResponse['msg'];
        print_r(json_encode($response));
        exit();
      }
      else{
        $response['status']=true;
      }
    }

    $aadhaarAdminStatus='3';
    if(isset($this->session->userdata['adminLoggedIn'])) {
      $aadhaarAdminStatus='1';
    }

    $aadhaarNo=$this->input->post('aadhaarNo');
    $kycSubmit=array();
    $kycSubmit['kycId']='1';
    $kycSubmit['kyctext']=$aadhaarNo;
    $kycSubmit['image']=$imageResponse['imageName'];
    $kycSubmit['status']=$aadhaarAdminStatus;
    $kycSubmit['userId']=$userId;
    $kycSubmit['fieldNameLogin']='adharstatus';
    $kycSubmit['fieldNameDetail']='aadharcard';

    $kycResponse=KYCSubmitProcess($kycSubmit);
    
    if($kycResponse['status']){
      $response['status']=true;
      $response['msg']="National ID Proof Uploaded Successfully.";
    }
    else{
      $response['status']=false;
      $response['msg']='Some Error Occur.';

    }
    print_r(json_encode($response));
  }
  public function Coinsdetail(){
     $userId=$this->sessionUserid;
     $response=array(); 
     $data=array();
     $data['extraColumn']=",B.usdt";
     $PanInfo=FetchMemberInfo($userId,$data);
     $response['PanInfo']=$PanInfo;
     $this->load->view('Coinaddress',$response);
  }
  public function CoinSubmit(){  
    $userId=$this->sessionUserid;
    $usdt=$this->input->post('usdt');
    $response=array();
    $response['status']=false;

    $kycSubmit=array();
    $kycSubmit['usdt']=$usdt;
    $kycSubmit['userId']=$userId;
    $kycResponse=CoindetailProcess($kycSubmit);
    if($kycResponse['status']){
      $response['status']=true;
      $response['msg']="Payment Detail Updated Successfully";
    }
    else{
      $response['status']=false;
      $response['msg']='Some Error Occur.';
    }
    print_r(json_encode($response));
  }
}
?>