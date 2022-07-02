<?php

Class Login extends MX_Controller {
   public function __construct()
   {
      parent::__construct();
      $this->load->helper('main_helper');
      $this->load->helper('sms_helper');
      $this->load->helper('member_helper');
      $this->load->helper('income_helper');
      $this->load->model('RegisterModel');
      
   }

	public function FranchiseeLogin(){
      $response=array();
      $this->load->view('franchiseeLogin',$response);	
	}

   
}
?>