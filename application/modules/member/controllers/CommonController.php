<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CommonController extends MX_Controller {
	public function __construct()
    {
    	parent::__construct();
    	$this->load->helper('url');
    	$this->load->helper('security');
    	
    	$this->load->model('Commonmodel','CommonModel'); 

    	$logged_in = $this->session->userdata('logged_in');
      	$userid=$logged_in['userid'];
      	$username=$logged_in['username'];
      	$this->sessionUserid=$userid;
      	$this->sessionUserName=$username;
    }
    public function MemberidValid()
    {
    	$userId=$this->sessionUserid;
        $UserName=$this->sessionUserName;
        $memberId=$this->input->post('memberId');
        $data=array();
        $data['selfid']=$userId;
        $CheckMemberid=$this->CommonModel->CheckMemberidValid($memberId,$data);
        $response['status']=false;
        if($CheckMemberid['status']) {
        	$response['status']=true;
        	$response['memberName']=$CheckMemberid['data'][0]['fname'];
            $response['activestatus']=$CheckMemberid['data'][0]['activestatus'];
        }
        print_r(json_encode($response));
    }
}
?>