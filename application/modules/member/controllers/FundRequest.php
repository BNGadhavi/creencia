<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FundRequest extends MX_Controller {
	public function __construct()
    {
    	parent::__construct();
    	$this->load->helper('url');
      $this->load->helper('wallet_helper');
      $logged_in = $this->session->userdata('logged_in');
      $userid=$logged_in['userid'];
      $memberid=$logged_in['username'];
      $this->sessionUserid=$userid;
      $this->sessionMemberid=$memberid;

      $this->load->model('WalletModel','WalletModel'); 
     

      $this->ApiKey=$this->config->item('apikey');
      $this->ApiPW=$this->config->item('apipw');
      $this->extracharge=2;

    }

	public function index(){
    $response=array();
    $this->load->view('fundRequest',$response);
	}
  
  public function FundRequestSubmit(){
    $userId=$this->sessionUserid; 
    $response=array();
    $response['status']=false;
    $response['msg']='Some Error Occur';
    $imageResponse=array();
    if(isset($_FILES['proof']['name']))
    {
      $imageResponse=imageUpload('proof',$_FILES['proof']['name'],'FundRequest');
        if(!$imageResponse['status']){
          $response['msg']=$imageResponse['msg'];
          print_r(json_encode($response));
          exit();
        }
        else{
          $response['status']=true;
        }
    }

    $data=array();
    $data['userid'] = $userId;
    $data['amount'] = $this->input->post('amount');    
    $data['transactionId'] = $this->input->post('transactionId');    
    $data['image'] = $imageResponse['imageName'];
    $data['paymentMode'] = $this->input->post('paymentMode');    
    $data['status']='0';
    $data['type']     = 'Credit';
    $data['reqtype']  ='1';
    
    $walletReponse=WalletProcess($data);
    
    if($walletReponse['status']){
      $response['status']=true;
      $response['msg']="Wallet Request Send Successfully.";
    }

    print_r(json_encode($response));

  }
  
  public function FundRequestReport(){

    $userId=$this->sessionUserid; 
    $response=array();
    $data=array();
    $data['userid']=$userId;
    $WalletReport=WalletReport($data);
    /*echo "<pre>";
    print_r($WalletReport);*/
    $response['responseData']=$WalletReport;
    $response['pageTitle']="Fund Request Report";
    $this->load->view('mainTable',$response);
    

  }

  public function FundGenerate(){
    $userId=$this->sessionUserid; 
    $extracharge =$this->extracharge;
    $response=array();
    $response['extracharge']=$extracharge;
    $response['apikey'] =  $this->ApiKey;
    $response['apipw'] =  $this->ApiPW;
    $response['TotalPurchaseAmount']=0;

    $this->load->view('WalletGeneratenew',$response);
  } 

  public function WalletGeneratePay() {
    $userId = $this->sessionUserid; 
    $data = array();
    
    $amount = $this->input->post('amount');
    $data['userId'] = $userId;   
    $data['amount'] = $amount;

    $extracharge = $this->extracharge;
    $FinalAmount = $amount + ($amount * $extracharge / 100);
    //$FinalAmount = $amount;
    
    $data['totalamount'] = $FinalAmount;
    $data['paymentMode'] = '3';
    $data['extracharge'] = $extracharge;
    $txnId=GenerateTransId();
    //$FinalAmount=$this->input->post('amount');   
    $data=array();
    $data['userId'] = $userId;
    $data['amount'] = $amount;    
    $data['onlinepaymentamount']=$FinalAmount;
    $data['paymentMode'] = '4';    
    $data['transactionId'] = $txnId;    
    $data['status'] = '3'; 
    $WalletRequestProcess=$this->WalletModel->WalletRequestProcess($data);
    $response['status'] = false;
    $response['msg'] = "Some Error Occur.";
    if($WalletRequestProcess['status']) {
      $TotalPurchaseAmount = 0;
      if($FinalAmount > 0) {
        $TotalPurchaseAmount = ($FinalAmount * 100);
        //echo $TotalPurchaseAmount;
        $data = array();
        $data['amount'] = $TotalPurchaseAmount;
        $getOrderId = GeneratePaymentOrderId($data);    
      }
      else {
        $getOrderId['orderId'] = '';    
      }
      $response['status'] = true;
      $response['refid'] = $WalletRequestProcess['entryid'];
      $response['TotalPurchaseAmount'] = $TotalPurchaseAmount;
      $response['paymentOrderId'] = $getOrderId['orderId'];  
    }

    print_r(json_encode($response));
  }

  public function WalletGeneratePaySubmit() {
    $userid = $this->sessionUserid; 

    $refid = $this->input->post('orderid');
    $transactionId = $this->input->post('paymentid');
    $response['status'] = false;
    $response['msg'] = "Some Error Occur.";
    if($transactionId == '') {

    }
    else {
      $responsestatus='4';
      $statusdate=CurrentDate();    
      DirectQuery("UPDATE mlm_walletorder SET status='4',statusdate='$statusdate',paymentgatewayid='$transactionId' where id='$refid'");
      //$PinRequestProcess = UpdateWalletGenerateProcess($data);
      if($responsestatus=='4'){
        $response=PaymentSuccessEntry($userid,$refid);
        $responsestatus1=true;
        $responsemsg='Payment Done successfully'; 
        $response['msg']=$responsemsg;
        $response['status']=true;
      }
    
        //print_r(json_encode($response));
      /*  $redirect="/member/WalletRequest/WalletRequestReport/4";
        $this->session->set_userdata('setMessageData', $response);
        redirect($redirect);*/
      
    }
    print_r(json_encode($response));
  }

}
?>