<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Support extends MX_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model('SupportModel');
       
        $adminLoggedIn = $this->session->userdata('adminLoggedIn');
        $userid=$adminLoggedIn['userid'];
        $this->sessionAdminUserid=$userid;
    }

    public function AddTicketName(){
        $response=array();  
        $this->load->view('addTicketName',$response);  
    } 
    
    public function checkTicketName(){
        $ticketName=$this->input->post('ticketName');
        $data=array();
        $data['ticketName']=$ticketName;
        $checkValidation=$this->SupportModel->checkTicket($data);

        $response=array();
        $response['status']=false;
        if(!$checkValidation['status']){
            $response['status']=true;
        }

        print_r(json_encode($response)); 
    } 

    public function AddTicketNameSubmit(){
        
        $ticketName=$this->input->post('ticketName');
        $data=array();
        $data['ticketName']=$ticketName;
        $saveTicket=$this->SupportModel->SaveTicketName($data);

        $response=array();
        $response['status']=false;
        $response['msg']='some error occur';

        if($saveTicket['status']){
            $response['status']=true;
            $response['msg']="Ticket Added Successfully";
        }

        print_r(json_encode($response)); 
    } 

    public function TicketReport(){

        $ticketNameList=$this->SupportModel->TicketNameList();
        $response=array();
        $response['responseData']=$ticketNameList;
        $response['pageTitle']="Ticket Name Report";

        $this->load->view('mainTable',$response);
    }

    public function DeleteTicket(){

        $id=$this->uri->segment(4);
        $data=array();
        $data['id']=$id;
        $ticketNameList=$this->SupportModel->DeleteTicket($data);
        $response=array();
        if($ticketNameList  >= 1 ){
            $response['actionstatus']=true;
            $response['actionmsg']='Ticket Deleted Successfully';
        }
        else{
            $response['actionstatus']=false;
            $response['actionmsg']='Some Error occur';
        }

        $this->session->set_userdata('setMessageData', $response);
        redirect('/superuser/Support/TicketReport');
    }

    public function CurrentTicketReport(){

        DirectQuery("UPDATE mlm_support set view='1'");

        $status=$this->uri->segment(4);
        $pageName="Current Ticket Report";
        if(isset($status))
            $pageName="Close Ticket Report";

        $data=array();
        $data['status'] = $status;        
        $CurrentTicketList=$this->SupportModel->CurrentTicketList($data);
        $response=array();
        $response['responseData']=$CurrentTicketList;
        $response['pageTitle']=$pageName;
        $this->load->view('mainTable',$response);

    }

    public function TicketDetail(){
        $ticketId=$this->uri->segment(4);
        $data=array();
        $data['ticketId'] = $ticketId;
        $getTicketInfo=$this->SupportModel->GetTicketInfo($data);
        
        $response=array();
        $response['UserInfo']=$getTicketInfo['CurrentTicket']['data'][0];
        $response['responseData']=$getTicketInfo['TicketInfo'];

        $this->load->view('ticketDetail',$response);
    }

    public function TicketReply(){
        $ticketId=$this->input->post('ticketId');
        $newMessage=$this->input->post('newMessage');

        $data=array();
        $data['ticketId'] = $ticketId;
        $data['newMessage'] = $newMessage;

        $SaveTicket=$this->SupportModel->SaveTicketReply($data);

        $response=array();
        $response['status'] = false;
        $response['msg']='Some Error Occur.';
        if($SaveTicket['status']){
            $response['status']=true;
            $response['msg']="Ticket Reply Added Successfully.";
        }

        print_r(json_encode($response));
    }   
    
    public function CloseTicket(){
         $ticketId=$this->uri->segment(4);
         $data=array();
         $data['ticketid'] = $ticketId;

         $this->SupportModel->UpdateTicketStatus($data);

         $response=array();
         $response['actionstatus']=true;
         $response['actionmsg']='Ticket Closed Successfully';
       

        $this->session->set_userdata('setMessageData', $response);
        redirect('/superuser/Support/CurrentTicketReport');




    }
  
}
?>