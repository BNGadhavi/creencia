<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet extends MX_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('wallet_helper');
        $this->load->model('AdminModel');
        $this->load->helper('main_helper');
        $this->load->helper('income_helper');
   
        $adminLoggedIn = $this->session->userdata('adminLoggedIn');
        $userid=$adminLoggedIn['userid'];
        $this->sessionAdminUserid=$userid;
    }

    public function index(){
        $response=array();
        $this->load->view('walletForm',$response);
    }

    public function WalletFormSubmit(){
        $type = $this->input->post('type');
        $memberId = $this->input->post('memberId');
        $amount = $this->input->post('amount');
        $remarks = $this->input->post('remarks');
        $response=array();
        $response['status']=false;
        $response['msg']='Some Error Occur.';
        $ValidationMemberid=$checkValidation = $this->AdminModel->checkMemberId($memberId);
        if(!$ValidationMemberid['status']){
            $response['msg']='MemberId Is Ivalid.';
            print_r(json_encode($response));
            exit();
        }
        else{
            $userId=$ValidationMemberid['data'][0]['id']; 
        }
        $data=array();
        $data['userid']=$userId;
        $data['type']=$type;
        $data['reqtype']='0';
        $data['amount']=$amount;
        $data['status']='1';
        $data['statusdate']=Currentdate();
        $data['statusby']=$this->sessionAdminUserid;
        $data['remarks']=$remarks;
        $walletresponse=WalletProcess($data);
        if($walletresponse['status']){
            $data['walletorderId']=$walletresponse['walletorderId'];
            $tranascationResponse=WalletTransactionEntry($data);
            if($tranascationResponse['status']){
                $response['status']=true;
                $response['msg']='Transaction Done Successfully.';    
            }
        }
        print_r(json_encode($response));
    }
    public function WalletReport(){
        $status=$this->uri->segment(4);
        $adminFlag=false;
         $tmp="";
        if($status ==''|| $status=='1' || $status=='4'){
            if($status=='' || $status=='1' ){
                $status='1';  
                $tmp='';  
            }
            
            $Name=$tmp." Accepted Capital Wallet Report";    
        }
        else{
            if($status == 0 || $status == 3)
             {
                $adminFlag=true;
                if($status==0){
                     $tmp='';
                }
                $Name=$tmp." Pending Capital Wallet Report";    
             }
             else{
                if($status==2){
                     $tmp='';
                }
                $Name=$tmp." Rejected Capital Wallet Report";
             }   
        }
        $data=array();
        $data['status']=$status;
        $data['adminFlag']=$adminFlag;
        $WalletList=WalletReport($data);
        $response=array();
        $response['responseData']=$WalletList;
        $response['pageTitle']=$Name;
        $this->load->view('mainTable',$response);
    }
    public function FundRequestAction(){
        $status=$this->uri->segment(4);
        $walletid=$this->uri->segment(5);
        $adminid=$this->sessionAdminUserid;

        $response=array();
        $response['status']=false;
        $response['actionstatus']=false;
        $response['actionmsg']='Some Error Occur.';

        $getWalletData=GetWalletData($walletid);
        $userid=$getWalletData['data'][0]['userid'];
        $amount=$getWalletData['data'][0]['amount'];
        $statusalready=$getWalletData['data'][0]['status'];

        $redirect="/superuser/Wallet/WalletReport/0";
        
        if($statusalready==1){
            $redirect="/superuser/Wallet/WalletReport/1";
        }
        else if($statusalready==2){
            $redirect="/superuser/Wallet/WalletReport/2";
        }
        if($statusalready=='0')
        {
            if($status=='1')
            {
                /*$coins=$amount*$buyprice;
                $data=array();
                $data['buyprice']=$buyprice;
                $data['coinprice']=$coins;*/
                $getWalsletData=WalletRequestSubmit($walletid,$status,$adminid);
                if($getWalsletData['status'])
                {
                    $data=array();
                    $data['userid']=$userid;
                    $data['type']='Credit';
                    $data['amount']=$amount;
                    $data['remarks']="Wallet Request Accepted";
                    $data['walletorderId']=$walletid;
                    $data['coinprice']='0';
                    $tranascationResponse=WalletTransactionEntry($data);
                    if($tranascationResponse['status']){
                        $response['status']=true;
                        $response['actionstatus']=true;
                        $response['actionmsg']='Request Accepted Successfully.';    
                    }
                }
            }
            else
            {
                $getWalsletData=WalletRequestSubmit($walletid,$status,$adminid);
                $response['status']=true;
                $response['actionstatus']=true;
                $response['actionmsg']='Request Rejected Successfully.';
            }
        }
        else
        {
            $response['status']=false;
            $response['actionstatus']=false;
            $response['actionmsg']='Request Already Done.';   
        }
        $this->session->set_userdata('setMessageData', $response);
        redirect($redirect);
    }

    public function WalletTransferReport(){
        
        $adminFlag=true;
        $data=array();
        $data['adminFlag']=$adminFlag;
        $WalletList=WalletTransferReport($data);
        $response=array();
        $response['responseData']=$WalletList;
        $response['pageTitle']='Wallet Transfer Report';
        $this->load->view('mainTable',$response);
    }
}
?>