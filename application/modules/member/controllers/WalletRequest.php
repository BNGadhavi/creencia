<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WalletRequest extends MX_Controller {
	public function __construct() {
    	parent::__construct();

      $this->load->model('WalletModel','WalletModel'); 
      $this->load->model('Commonmodel','CommonModel');
      $logged_in = $this->session->userdata('logged_in');

      $this->load->helper('wallet'); 
      $userid=$logged_in['userid'];
      $memberid=$logged_in['username'];
      $this->sessionUserid=$userid;
      $this->sessionMemberid=$memberid;      
    }

  public function index(){
    $userId=$this->sessionUserid;
    $memberId=$this->sessionMemberid;

    $viewstatus='0';
    $msg="";
    /*$GetMemberStatus=$this->CommonModel->CheckMemberidValid($memberId);
    if($GetMemberStatus['data'][0]['activestatus'] == '0'){
        $fssefxdfsdf="SELECT * FROM `mlm_walletorder` where userid='$userId' and status='0' and type='0'";
        $bfdzgdsz = DirectQuery($fssefxdfsdf);
        $dsfdsfsdf = $bfdzgdsz->result();
        if(count($dsfdsfsdf) > 0) {
          $viewstatus='2';
          $msg="Your Request Is In Pending.";
        }
    }
    else
    {
      $viewstatus='1';
      $msg="You Are Already Active.";
    }*/
    $response=array();
    $response['viewstatus']=$viewstatus;
    $response['msg']=$msg;
    $this->load->view('WalletRequest',$response);
  }

  public function WalletRequestSubmit(){
    $userId=$this->sessionUserid;
    $memberId=$this->sessionMemberid;
    $response['status']=false;
    /*$GetMemberStatus=$this->CommonModel->CheckMemberidValid($memberId);
    if($GetMemberStatus['data'][0]['activestatus'] == '0'){
        $fssefxdfsdf="SELECT * FROM `mlm_walletorder` where userid='$userId' and status='0' and type='0'";
        $bfdzgdsz = DirectQuery($fssefxdfsdf);
        $dsfdsfsdf = $bfdzgdsz->result();
        if(count($dsfdsfsdf) > 0) {
          $response['status']=false;
          $response['msg']="Your Request Is In Pending.";
          echo json_encode($response);
          exit();
        }
    }
    else
    {
      $response['status']=false;
      $response['msg']="You Are Already Active.";
      echo json_encode($response);
      exit();
    }*/
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
      $data['paymentMode'] = $this->input->post('paymentMode');    
      $data['transactionId'] = $this->input->post('transactionId');    
      $data['image'] = $imageResponse['imageName'];
      $data['buyprice']='0';
      $data['coinprice']='0';
      $WalletRequestProcess=$this->WalletModel->WalletRequestProcess($data);
      $response['status']=true;
      if(!$WalletRequestProcess['status']){
        $response['status']=false;
        $response['msg']="Some Error Occur.";
      }
    }
    echo json_encode($response);
 }
 public function WalletRequestReport(){
    $userId=$this->sessionUserid; 
    $status=$this->uri->segment(4);
    //echo $status;
    $tmp="";
    $title="Pending Capital Wallet Request";
    if($status=='' || $status =='0' || $status=='3'){
        
      if($status==''){
          $status=0;
        }

        $title="Pending Capital Wallet Request";
    }
    else if($status=='1' || $status=='4')
    {
        $title="Accepted Capital Wallet Request";

    }
    else
    {
      $title="Rejected Capital Wallet Request";
    }
    $getPinRequest=$this->WalletModel->WalletRequestList($userId,$status);
    if($status=='3' and $status='4' and $status=='5'){
      $tmp='Online ';
    }
    $response['responseData']=$getPinRequest;
    $response['pageTitle']=$tmp.$title;
    $this->load->view('mainTable',$response);    
  }
}
?>