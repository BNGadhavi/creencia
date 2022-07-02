<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends MX_Controller {
    public function __construct(){
    	parent::__construct();
    	$this->load->helper('url');
    	$this->load->helper('security');
    	$this->load->model('AdminModel');
        $this->load->helper('wallet_helper');
    }

    public function CheckMemberId(){
        $username=$this->input->post('username');
        $type=$this->input->post('type'); 

        if(isset($type) && $type == 'Franchisee'){
            $checkValidation = $this->AdminModel->checkFranchiseeId($username);    
        }
        else{
            $checkValidation = $this->AdminModel->checkMemberId($username);
        }
        
        print_r(json_encode($checkValidation));
    } 
    public function CheckWalletbalance(){
        $username=$this->input->post('username');
        $type=$this->input->post('type');

        $ValidationMemberid=$checkValidation = $this->AdminModel->checkMemberId($username);
        if(!$ValidationMemberid['status']){
            $response['msg']='MemberId Is Ivalid.';
            print_r(json_encode($response));
            exit();
        }
        else{
            $userId=$ValidationMemberid['data'][0]['id']; 
            $data=array();
            $data['userId']=$userId;
            $data['walletType']=$type;
            $getMemberWalletBalance=UserWalletBalance($data);
            $balance=$getMemberWalletBalance['data'][0]; 
            print_r(json_encode($balance));
            exit();
        }
    }



  
}
?>