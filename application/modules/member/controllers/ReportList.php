<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportList extends MX_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->helper('incomereport_helper');
        $this->load->model('ReportModel'); 
        $this->load->model('Commonmodel','CommonModel');
        $logged_in = $this->session->userdata('logged_in');
        $userid=$logged_in['userid'];
        $this->sessionUserid=$userid;
    }
    
    public function index(){
        $userId=$this->sessionUserid;
        $data=array();
        $data['userId']=$userId;
        $BinaryList=BinaryIncomeHelper($data);

        $response['responseData']=$BinaryList;
        $response['pageTitle']="Binary Income";
        $this->load->view('mainTable',$response);
    }   

    public function DirectShareIncomeReport(){
        $userId=$this->sessionUserid; 

        $data=array();
        $data['userId']=$userId;
        $BinaryList=DirectShareIncomeHelper($data);

        $response['responseData']=$BinaryList;
        $response['pageTitle']="Direct Profit Share Income";
        $this->load->view('mainTable',$response);
    }

    public function RoiIncomeReport(){
        $flag=$this->uri->segment(4);
        $userId=$this->sessionUserid;  
        $data=array();
        $data['userId']=$userId;
        $data['flag']=$flag;
        $text="Roi Income Report";
        $RoiList=RoiIncomeHelper($data);
        $response=array();
        $response['responseData']=$RoiList;
        $response['pageTitle']=$text;
        $this->load->view('mainTable',$response);
    }

    public function SponsorIncomeReport(){
        $userId=$this->sessionUserid; 
        $data=array();
        $data['userId']=$userId;
        $SponsorList=SponsorIncomeHelper($data);
        $response=array();
        $response['responseData']=$SponsorList;
        $response['pageTitle']="Sponsor Income Report";
        $this->load->view('mainTable',$response);
    }
  public function AccountStatement() {
     
     $userId=$this->sessionUserid; 
     $wallettype='Income Wallet';
     $text="Income Wallet";
     if($this->uri->segment(4)){
        $wallettype='Capital Wallet';
        $text="Capital Wallet";
     }
     $data=array();
     $data['userId'] = $userId;
     $data['wallettype']=$wallettype;
     $LinkIncomeList = AccountStatementHelper($data);
     $response = array();
     $response['responseData'] = $LinkIncomeList;
     $response['pageTitle'] = $text." Account Statement";
     $this->load->view('mainTable',$response);
  } 
  public function PayoutReport() {
    $userId=$this->sessionUserid; 
    $type=1;
    $data=array();
    $data['userId'] = $userId;
    $data['type'] = $type;
    $PayoutList = MemberwisePayoutHelper($data);
    $response = array();
    $response['responseData'] = $PayoutList;
    $response['pageTitle'] ="Payout Report";
    $this->load->view('mainTable',$response);
  } 
    public function RewardIncome(){
        $userId=$this->sessionUserid;
        $data=array();
        $data['userId']=$userId;
        $BinaryList=RewardIncomeHelper($data);
        $response['responseData']=$BinaryList;
        $response['pageTitle']="Reward Income";
        $this->load->view('mainTable',$response);
    }   
}
?>