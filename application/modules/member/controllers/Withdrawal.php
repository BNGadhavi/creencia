<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Withdrawal extends MX_Controller {
	public function __construct() {
    	parent::__construct();
    	$this->load->helper('url');
    	$this->load->helper('security');
      $this->load->helper('wallet_helper');
      $this->load->helper('member_helper');
      $this->load->model('Withdrawalmodel','WithdrawalModel');
      $this->load->model('Memberpassword_model','MemberPassword_model');

      $logged_in = $this->session->userdata('logged_in');
      $userid=$logged_in['userid'];
      $this->sessionUserid=$userid;
      $chargeList=Charges();
      $this->MinWithdrawal=10;
      $this->MaxWithdrawal=1000;

      $WithdrwalDayArray=array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');    
      $this->WithdrwalDayArray=$WithdrwalDayArray;
    }

    public function index(){
      $userId=$this->sessionUserid;
      
      $response=array();
      $data=array();

      $data['userId']=$userId;
      $withdrwalRequestReport=$this->WithdrawalModel->Report($data);

      $response['responseData']=$withdrwalRequestReport;
      $response['pageTitle']="Withdrawal Request Report";
      $this->load->view('mainTable',$response);
    }

    public function Add(){
      $userId=$this->sessionUserid;
      
      $data=array();
      $data['userId']=$userId;
      $data['walletType']="Income Wallet";
      $getMemberWalletBalance=UserWalletBalance($data);
      /*$today=CurrentDate();
      $timestamp = strtotime($today);
      $day = date('D', $timestamp);
      $dayArray=array();
      $dayArray=$this->WithdrwalDayArray;
      $dayStatus=false;
      $validmsg="You Can't Place Withdrwal Today";
      if(in_array($day, $dayArray)){
        $dayStatus=true;
        $validmsg='';
      }*/
      $data=array();
      $data['extraColumn']=",B.usdt";
      $PanInfo=FetchMemberInfo($userId,$data);
      $response=array();
      $response['walletBalance']=$getMemberWalletBalance;
      $response['MinAmount']= $this->MinWithdrawal;
      $response['MaxAmount']= $this->MaxWithdrawal;
      $withdrwalRequest=$this->WithdrawalModel->WithdrawalValidation($userId);
      $response['valid']=$withdrwalRequest['valid'];
      $response['msg']=$withdrwalRequest['msg'];
      
     /* if(!$dayStatus){
        $response['valid']=false;
        $response['msg']=$validmsg;
      }*/
      $data=array();
      $data['extraColumn']=",A.activestatus,A.lockmember";
      $memberInfo=FetchMemberInfo($userId,$data);
      $response['lockmember']=$memberInfo['data'][0]['lockmember'];
      $response['PanInfo']=$PanInfo;
      $this->load->view('WithdrawalForm',$response);
    }
    public function Insert(){

      $userId=$this->sessionUserid;
      $amount=$this->input->post('amount');
      $paymentMode=$this->input->post('paymentMode');
      //$address=$this->input->post('address');
      $MinWithdrawal=$this->MinWithdrawal;
      
      $response=array();
      $response['status']=false;
      $data=array();
      $data['userId']=$userId;
      $data['walletType']="Capital Wallet";
      $getMemberWalletBalance=UserWalletBalance($data);
      $walletBalance=$getMemberWalletBalance['data'][0]['Balance'];

    
      if($amount< $MinWithdrawal){//min amount validation
          $response['msg']="Please Enter A Value Greater Than Or Equal To ".$MinWithdrawal;
          print_r(json_encode($response));
          exit(); 
      }

      if($walletBalance < $amount){//max amount validation
          $response['msg']="Please Enter A Value Less Than Or Equal To ".$walletBalance;
          print_r(json_encode($response));
          exit(); 
      }
      $data=array();
      $data['extraColumn']=",B.usdt";
      $PanInfo=FetchMemberInfo($userId,$data);
      $usdt=$PanInfo['data'][0]['usdt'];

      $address=$usdt;

      $admincharge=$amount * 5/ 100;
      $netamount=$amount -$admincharge;

      $data=array();
      $data['userId']=$userId;
      $data['amount']=$amount;
      $data['paymentMode']=$paymentMode;
      $data['address']=$address;
      $data['dollar']='0';
      $data['sellprice']='0';
      $data['AdminCharge']=$admincharge;
      $data['netamount']=$netamount;
      $responseWithdrawal=$this->WithdrawalModel->Insert($data);
      if($responseWithdrawal['status']){
        $response['status']=true;
        $response['msg']="Withdrwal Request Sended Successfully.";
      }
      print_r(json_encode($response));
    }  
}
?>