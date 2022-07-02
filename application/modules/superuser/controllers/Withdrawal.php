<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Withdrawal extends MX_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model('WithdrawalModel');
        $adminLoggedIn = $this->session->userdata('adminLoggedIn');
        $userid=$adminLoggedIn['userid'];
        $this->sessionAdminUserid=$userid;
    }

    public function Report(){

        $status=$this->uri->segment(4);
        $data=array();
        $dateStart=$this->input->post('dateStart');
        $dateEnd=$this->input->post('dateEnd');
        if($status==''){
            $status=0;
        }
        if($status>2)
        {
            $status=0;
        }
        if($status=='0')
        {
            $text="Pending";
        }
        else if($status=='1')
        {
            $text="Accepted";   
        }
        else
        {
            $text="Rejected";      
        }
        $userid=$this->sessionAdminUserid;
        $data['status']=$status;
        
        if($dateStart!=''){
            $data['dateStart']=$dateStart;
        }
        
        if($dateEnd!=''){
            $data['dateEnd']=$dateEnd;
        }

        $WithdrwalList=$this->WithdrawalModel->Report($data);
        $response=array();
        $response['responseData']=$WithdrwalList;
        $response['pageTitle']=$text." Withdrawal Request Report";
        $response['modelPageName']="commonpopup.php";
        $response['submitUrl']="Withdrawal/Report";
        $response['searchBtn']=true;

        $this->load->view('mainTable',$response);
    }

    public function WithdrawalAction(){

        $status=$this->uri->segment(4);
        $id=$this->uri->segment(5);

        $data=array();
        $data['status'] = $status;
        $data['id'] = $id;
        $data['adminid']=$this->sessionAdminUserid;
        $statusResponse=$this->WithdrawalModel->WithdrawalUpdateStatus($data);
        $response=array();
        if($statusResponse['status']){
            $response['actionstatus']=true;
            if($status==1)
                $msg="Withdrawal Accepted Successfully";
            else
                $msg="Withdrawal Rejected Successfully";
            $response['actionmsg']=$msg;
        } 
        else{
            $response['actionstatus']=false;
            $response['actionmsg']='Some Error Occur';
        }       

        $redirect="/superuser/Withdrawal/Report";
        $this->session->set_userdata('setMessageData', $response);
        redirect($redirect);

    }
}
?>