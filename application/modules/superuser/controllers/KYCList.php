<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KYCList extends MX_Controller {
	public function __construct(){
    	parent::__construct();
    	$this->load->helper('url');
    	$this->load->helper('kyc_helper');
    }

	public function KYCReport(){
        $status=$this->uri->segment(4);
        if($status ==''){
            $status=3;
        }    
        $data=array();
        $data['status']=$status;
        $data['adminFlag']=true;           
		$kycList=KYCListForAdmin($data);
		$response=array();
		$response['responseData']=$kycList;
        if($status == 3){
            $title="Pending KYC Report";
        }
        else{
         $title="Accepted KYC Report";   
        }
		$response['pageTitle']=$title;
		$this->load->view('mainTable',$response);
    }

    public function KYCAction(){
        $status=$this->uri->segment(4);
        $kycUserId=$this->uri->segment(5);

        $data=array();
        $data['status']=$status;
        $data['kycUserId']=$kycUserId;

        $responseKYC=KYCUpdateProcess($data);

        $response=array();
        $response['actionstatus']=true;
        if($status == '1'){
            $msg="KYC Accepted Successfully.";
        }
        else{
            $msg="KYC Rejected Successfully.";
        }
        $response['actionmsg']=$msg;

        $this->session->set_userdata('setMessageData', $response);
        redirect('/superuser/KYCList/KYCReport');    
    }	
}
?>