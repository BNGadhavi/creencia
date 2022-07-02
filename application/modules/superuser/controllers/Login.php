<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MX_Controller {
	public function __construct(){
    	parent::__construct();
    	$this->load->helper('url');
    	$this->load->helper('security');
    	$this->load->model('LoginModel');
     
    }

  	public function index(){
  		$this->load->view('login');
  	}
	
    public function checkusername(){
        $username=$this->input->post('username');
        $ValidateUsername=$this->LoginModel->ValidateUsername($username);
        $response=array();
        $response['status']=false;
        if($ValidateUsername['status']){
            $response['status']=true;
        }
        
        print_r(json_encode($response));
    }

    public function LoginSubmit(){
       $username=$this->input->post('username');
       $password=$this->input->post('password'); 

       $data=array();
       $data['username']=$username;
       $data['password']=$password;
       $Validate=$this->LoginModel->ValidateLogin($data);
       if($Validate['status']){
        $session_data = array(
          'username' => $data['username'],
          'userid' => $Validate['data'][0]['id'],
        );
        
          $this->session->set_userdata('adminLoggedIn', $session_data);
          redirect('/superuser/dashboard');
       }
       else{
         $data=array();
          $data = array(
          'error_message' => 'Invalid Username or Password'
          );
          $this->load->view('login', $data);
       }
       
    }
}
?>