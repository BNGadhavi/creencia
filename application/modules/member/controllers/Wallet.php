<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet extends MX_Controller {
	public function __construct() {
    	parent::__construct();
    	$this->load->helper('url');
    	$this->load->helper('security');
      $this->load->helper('sms');
      $this->load->helper('member');
      $this->load->model('WalletModel','Walletmodel');
      $this->load->helper('wallet_helper'); 
      $this->load->model('Commonmodel','CommonModel');
      $logged_in = $this->session->userdata('logged_in');
      $userid=$logged_in['userid'];
      $this->sessionUserid=$userid;
    }
  public function index(){
     $response=array();
     $this->load->view('Walletreqform',$response);
  }

 public function WalletRequestSubmit(){
    $userId=$this->sessionUserid; 
    
    $response['status']=false;
    $imageResponse=array();
    if(isset($_FILES['proof']['name']))
    {
      $imageResponse=imageUpload('proof',$_FILES['proof']['name'],'FundRequest');
      if(!$imageResponse['status']){
        $response['msg']=$imageResponse['msg'];
      }
      else{
        $response['status']=true;
      }
    }
    
    if($response['status']){
      $data=array();

      $data['userId'] = $userId;
      $data['amount'] = $this->input->post('amount');    
      $data['transactionId'] = $this->input->post('transactionId');    
      $data['image'] = $imageResponse['imageName'];
      $data['paymentMode'] = $this->input->post('paymentMode');    
      $walletRequestProcess=$this->Walletmodel->WalletRequestProcess($data);

       $response['status']=true;
      if(!$walletRequestProcess['status']){
        $response['status']=false;
        $response['msg']="Some Error Occur.";
      }
      else{
        $memberInfo=FetchMemberInfo($userId);
        $smsData=array();
        $smsData['memberid']=$memberInfo['data'][0]['username'];
        $smsData['membername']=$memberInfo['data'][0]['fullname'];
        $smsData['amount']=$this->input->post('amount');
        /*$mobile="7236000044";
        SmsSend($smsData,$mobile,5);*/


      }
    }
    echo json_encode($response);
 }

 public function WalletRequestReport(){
    $userId=$this->sessionUserid; 
    $status=$this->uri->segment(4);
    if($status==''){
        $status=0;
        $title="Pending Wallet Request.";
    }
    else if($status=='1')
    {
        $title="Accepted Wallet Request.";
    }
    else
    {
      $title="Rejected Wallet Request.";
    }
    $getPinRequest=$this->Walletmodel->WalletRequestList($userId,$status);
    $response['responseData']=$getPinRequest;
    $response['pageTitle']=$title;
    $this->load->view('mainTable',$response);    
  }
  public function wallettransfer(){
    $userId=$this->sessionUserid; 

    $data=array();
    $data['extraColumn']=",A.activestatus,A.lockmember";
    $memberInfo=FetchMemberInfo($userId,$data);
    $response=array();
    $data=array();
    $data['userId']=$userId;
    $data['walletType']="Capital Wallet";
    $getMemberWalletBalance=UserWalletBalance($data);
    $response['lockmember']=$memberInfo['data'][0]['lockmember'];
    $response['RepurchaseWallet']=$getMemberWalletBalance;
    $this->load->view('Wallettransfer',$response);
  }
  public function Fundtransfersubmit(){
    $userId=$this->sessionUserid; 
    $memberId=$this->input->post('memberId');
    $amount=$this->input->post('amount');
    $remark=$this->input->post('remark');
    
    $response=array();
    $response['status']=false;
    $response['msg']="Some Error Occured";

    
    $data=array();
    $data['selfid']=$userId;
    $CheckMemberid=$this->CommonModel->CheckMemberidValid($memberId,$data);
    if(!$CheckMemberid['status']) {
        $response['msg']="Memberid is Invalid";
        print_r(json_encode($response));
        exit();
    }

    $data=array();
    $data['userId']=$userId;
    $data['walletType']="Capital Wallet";
    $getMemberWalletBalance=UserWalletBalance($data);
    $balance=$getMemberWalletBalance['data'][0]['Balance'];

    if($balance<$amount)
    {
      $response['status']=false;
      $response['msg']="Invalid Amount";
      print_r(json_encode($response));
      exit();
    }

    $data=array();
    $data['userid']=$this->CommonModel->FindIdUsingMemberid($memberId);
    $data['amount']=$amount;
    $data['remark']=$remark;
    $data['fromid']=$userId;
    $getPinRequest=$this->Walletmodel->Fundtransferprocess($data);
    if($getPinRequest['status'])
    {
      $response['status']=true;
      $response['msg']="Fund Transfer Successfully";
    }
    print_r(json_encode($response));
  }

  public function Fundtransferreport(){
    $userId=$this->sessionUserid; 
    $getPinRequest=$this->Walletmodel->WalletTransferReport($userId);
    $response['responseData']=$getPinRequest;
    $response['pageTitle']="Capital Wallet Transfer To Other Member Report";
    $this->load->view('mainTable',$response);    
  }

  public function Walletreceivereport(){
    $userId=$this->sessionUserid; 
    $getPinRequest=$this->Walletmodel->WalletReceiveReport($userId);
    $response['responseData']=$getPinRequest;
    $response['pageTitle']="Capital Wallet Received From Other Member Report";
    $this->load->view('mainTable',$response);    
  }
}
?>