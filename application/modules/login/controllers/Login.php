<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
Class Login extends MX_Controller {
  public function __construct(){
      parent::__construct();
      $this->load->model('LoginModel');
   }

  public function Index(){
      $response=array();
      $this->load->view('login',$response); 
  }
  public function LoginSubmit(){
    $username=$this->input->post('username');
    $password=$this->input->post('password'); 
    $type=$this->input->post('type'); 

    $failurl="login";
    $password = preg_replace('/\s+/', '', $password);

    $data=array();
    $data['username']=$username;
    $data['password']=$password;
    $Validate=$this->LoginModel->ValidateMemberLogin($data);
   
    $msg="Invalid Username or Password";
    if($Validate['status']){
      
      if($Validate['data'][0]['lockmember'] != '0'){
          $msg="UserId  Is Locked";
          $data = array(
          'error_message' => $msg
        );
        $this->load->view( $failurl, $data);
      }
      else{
        $userId=$Validate['data'][0]['id'];
        $MainTable="mlm_userdetail";
        $Condition="userid='$userId'";
        $getMemberInfo=CreateSingleQuery($MainTable,$Condition);
        $getMemberInfo=json_decode($getMemberInfo,true);

        $session_data = array(
        'username' => $data['username'],
        'userid' => $Validate['data'][0]['id'],
        'membername'=>$getMemberInfo['data'][0]['fname'],
        );
        $this->session->set_userdata('logged_in', $session_data);
        $redirect="/member/Dashboard";  
        redirect($redirect);
      }
    }
    else{
      $data=array();
      $data = array(
      'error_message' => 'Invalid Username or Password'
      );
      
      $this->load->view( $failurl, $data);
    }
  }
	
}
?>