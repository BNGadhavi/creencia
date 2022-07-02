<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Support extends MX_Controller {
	public function __construct(){
    	parent::__construct();
    	$this->load->helper('url');
    	$this->load->helper('security');
    	$this->load->model('Supportmodel','SupportModel');


    	$logged_in = $this->session->userdata('logged_in');
      	$userid=$logged_in['userid'];
      	$this->sessionUserid=$userid;
    }

    public function RaiseTicket(){
		$response=array();
    	$response['ticketList']=$this->SupportModel->GetTicketName();
    	$this->load->view('raiseTicket',$response);
    }

    public function RaiseTicketSubmit(){
    	$ticketIssue=$this->input->post('ticketIssue');
    	$message=$this->input->post('message');

    	$data=array();
    	$data['ticketIssue'] = $ticketIssue;
    	$data['message'] =$message;
    	$data['destination'] = 'admin';
    	$data['userid'] = $this->sessionUserid;
    	$data['source'] = $this->sessionUserid;

    	$saveticket=$this->SupportModel->SaveTicket($data);

    	$response=array();
    	$response['status']=false;
    	$response['msg']='Some Error Occur.';

    	if($saveticket['status']){

    		$response['status']=true;
    		$response['msg']='Issue Send To Admin Successfully.';
    	}

    	print_r(json_encode($response));
    }

    public function TicketReport(){
    	$data=array();
    	$status=$this->uri->segment(4);

    	$data['userid'] = $this->sessionUserid;
    	$data['status'] = $status;

    	$pageName="Current Ticket Report";
    	if(isset($status))
    		$pageName="Close Ticket Report";

    	$ticketList=$this->SupportModel->TicketList($data);
    	$response=array();
    	$response['responseData']=$ticketList;
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
        $data['message'] = $newMessage;
        $data['destination'] = 'admin';
    	$data['userid'] = $this->sessionUserid;
    	$data['source'] = $this->sessionUserid;

        $SaveTicket=$this->SupportModel->SaveTicket($data);

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
        redirect('/member/Support/TicketReport');

    }
}
?>