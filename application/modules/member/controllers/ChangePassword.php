<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ChangePassword extends MX_Controller {
	public function __construct(){
    	parent::__construct();
    	$this->load->helper('sms_helper');
      $this->load->helper('member_helper');
      $this->load->model('Memberpassword_model','MemberPassword_model');
      
      $logged_in = $this->session->userdata('logged_in');
      $userid=$logged_in['userid'];
      $this->sessionUserid=$userid;
    }

	public function index()
  {
		$this->load->view('changepassword');
	}

  public function CheckPassword(){
       $oldPassword=$this->input->post('oldpass');
      
       $logged_in = $this->session->userdata('logged_in');
       $userid=$logged_in['userid'];

       $data=array();
       $data['userid']=$userid;
       $data['oldPassword']=$oldPassword;   

       $result = $this->MemberPassword_model->checkpassword($data);
        
       $response['status']=false;

       if($result){
         $response['status']=true;        
       }
       else
       {
          $response['status']=false;   
       }
     print_r(json_encode($response));
     
  }

  public function UpdateChangePassword(){
    $userid=$this->sessionUserid;
    $oldPassword=$this->input->post('oldpassword');
    $newPassword=$this->input->post('newpassword');

    $data['oldPassword']=$oldPassword;
    $data['newPassword']=$newPassword;
    $data['userid']=$userid;
    $response=array();
    $response['status']=false;    
    $response['msg']="Old Password Is Wrong";
    $result = $this->MemberPassword_model->checkpassword($data);
    if($result){
        $updatePasswordfun = $this->MemberPassword_model->updatepassword($data); 
        $response['status']=true;             
    }
    print_r(json_encode($response));
  }

  public function ChangeTransactionPassword()
  {
      $userid=$this->sessionUserid;
      $tabelName="mlm_userlogin";
      $condition = "id ='$userid'";
      $getData=CreateSingleQuery($tabelName,$condition);
      $getData=json_decode($getData,true);
      $spassword=$getData['data'][0]['securitypassword'];
      if($spassword=='')
      {
        $this->load->view('SetTransactionPassword');
      }
      else
      {
        $this->load->view('changeTransactionPassword',$spassword);
      }
      
  }
    
  public function CheckTransactionPassword(){
       $userid=$this->sessionUserid;
       $oldPassword=$this->input->post('password');
      
       $data=array();
       $data['userid']=$userid;
       $data['oldPassword']=$oldPassword;   

       $result = $this->MemberPassword_model->checkTransactionPassword($data);
       $response['status']=false;

       if($result['status']){
         $response['status']=true;        
       }
       print_r(json_encode($response));     
  }

  public function UpdateTransactionPassword(){
        $oldPassword=$this->input->post('oldpassword');
        $newPassword=$this->input->post('newpassword');

        $userid=$this->sessionUserid;
        $data=array();
        $data['oldPassword']=$oldPassword;
        $data['newPassword']=$newPassword;
        $data['userid']=$userid;

        $result = $this->MemberPassword_model->checkTransactionPassword($data);
        $response['status']=false;
        $response['msg']="Old Password Is Wrong";    
        if($result['status']) {
            $updatePasswordfun = $this->MemberPassword_model->updateTransactionPassword($data); 
            $response['status']=true;             
        }
        print_r(json_encode($response));
  }

  public function ForgetTransactionPassword(){
      $userid=$this->sessionUserid;
      $response=array();
      $response['status']=false;
      $response['msg']='Some Error Occur';
      
      $data=array();
      $data['userid']=$userid;
      $result = $this->MemberPassword_model->ForgetTransactionPasswordSMS($data);
      if($result['status']){
          $response['status']=true;
          $mobile=$result['mobile'];
          $response['msg']='Your password has been sent to your mobile number '.$mobile;
      }
      print_r(json_encode($response));
  }
  public function setTransactionPassword(){
        $oldPassword=$this->input->post('oldpassword');
        $newPassword=$this->input->post('newpassword');

        $userid=$this->sessionUserid;
        $data=array();
        $data['oldPassword']=$oldPassword;
        $data['newPassword']=$newPassword;
        $data['userid']=$userid;
        $updatePasswordfun = $this->MemberPassword_model->updateTransactionPassword($data); 
        $response['status']=true;             
        print_r(json_encode($response));
  }


}
?>