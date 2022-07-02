<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MemberDetail extends MX_Controller {
	public function __construct(){
    	parent::__construct();
    	$this->load->helper('url');
    	$this->load->helper('security');
        $this->load->Model('MemberDetailModel');
        $this->load->Model('Customers_model','customers');
        $this->load->model('AdminModel');
    }
    
    public function MemberList(){
        $todayFlag=$this->uri->segment(4);
        $today=array();
        if($todayFlag == 1){
            $dateFrom = date('Y-m-d', strtotime(CurrentDate()));
            $dateTo = date('Y-m-d', strtotime(CurrentDate()));
            $today['dateFrom']=$dateFrom;
            $today['dateTo']=$dateTo;
        }

        $memberList=$this->MemberDetailModel->MemberReport($today);
        $response=array();
        $response['responseData']=$memberList;
        $response['pageTitle']="Member Report";
        $this->load->view('mainTable',$response);        
    }

    public function MemberListNew(){
        /*$todayFlag=$this->uri->segment(4);
        $today=array();
        if($todayFlag == 1){
            $dateFrom = date('Y-m-d', strtotime(CurrentDate()));
            $dateTo = date('Y-m-d', strtotime(CurrentDate()));
            $today['dateFrom']=$dateFrom;
            $today['dateTo']=$dateTo;
        }
*/
        //$memberList=$this->MemberDetailModel->MemberReport($today);
        $response=array();
        $response['responseData']=array();
        $response['pageTitle']="Member Report";
        $this->load->view('memberList',$response);        
    }

    public function MemberListAjax(){


        /*$todayFlag=$this->uri->segment(4);
        $today=array();
        if($todayFlag == 1){
            $dateFrom = date('Y-m-d', strtotime(CurrentDate()));
            $dateTo = date('Y-m-d', strtotime(CurrentDate()));
            $today['dateFrom']=$dateFrom;
            $today['dateTo']=$dateTo;
        }
*/     
        $list = $this->customers->get_datatables();
       
        $data = array();
        $no = $_POST['start'];
        $i=1;
        foreach ($list as $customers) {
            $no++;
            $row = array();
            //$row[] = $i;
            $username=$customers->username;
            $link="<a href='MemberShortcut/$username'>Login</a>";

            $row[] = $link;
            $row[] = $customers->username;
            $row[] = $customers->Password;
            $row[] = $customers->securitypassword;
            $row[] = $customers->fname;
            $row[] = $customers->SponsorInfo;
            $row[] = $customers->Side;
            $row[] = ConvertDate($customers->entrydate);
            $row[] = $customers->ActiveDetail;
            $row[] = $customers->email;
            $row[] = $customers->MobileNo;
            $row[] = $customers->pincode;  

            /*$row[] = $customers->Id;
            $row[] = $customers->username;
            $row[] = $customers->Password;
            $row[] = $customers->entrydate;
            $row[] = $customers->activedate;*/
                      
            $data[] = $row;
            $i++;
        }
        

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->customers->count_all(),
                        "recordsFiltered" => $this->customers->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }


    public function AjaxmemberList(){
        
        $response['pageTitle']="Member Report";
        $this->load->view('AjaxmainTable',$response);        
    }

    public function ajax_call(){
       $param=$_REQUEST;
       $response=$this->MemberDetailModel->AjaxMemberReport($param);
       echo json_encode($response);
    }

	public function PackageWiseMember(){

		$packageList=$this->MemberDetailModel->PackageWiseMemberList();
		$response=array();
		$response['responseData']=$packageList;
		$response['pageTitle']="Packagewise Member Report";
		$this->load->view('mainTable',$response);
    }

    public function PackageWiseMemberDetail(){
    	$packagecode=$this->uri->segment(4);
    	$data=array();
    	$data['packagecode'] = $packagecode;
    	$packageList=$this->MemberDetailModel->PackageWiseUserDetail($data);
    	$response=array();
    	$response['responseData']=$packageList;
		$response['pageTitle']="Packagewise Member Report";
		$this->load->view('mainTable',$response);
    }

    public function ActivationReport(){
    	$status=$this->uri->segment(4);
        $todayFlag=$this->uri->segment(5);
        $today=array();
        if($todayFlag == 1){
            $dateFrom = date('Y-m-d', strtotime(CurrentDate()));
            $dateTo = date('Y-m-d', strtotime(CurrentDate()));
            $today['dateFrom']=$dateFrom;
            $today['dateTo']=$dateTo;
        }
        $dateStart=$this->input->post('dateStart');
        $dateEnd=$this->input->post('dateEnd');

        if($dateStart!=''){
            $dateStart = date('Y-m-d', strtotime($dateStart));
            $today['dateFrom']=$dateStart;
        }
        if($dateEnd!=''){
            $dateEnd = date('Y-m-d', strtotime($dateEnd));
            $today['dateTo']=$dateEnd;
        }

    	$text="Lock Member ";
    	if($status==''){
            $status=0;
            $text="";
        }

        if($status == 0){
            $text="";            
        }
        $activeList=array();
        $popup=true;
        if(@$today['dateTo']!='' || @$today['dateFrom']!=''){
            $activeList=$this->MemberDetailModel->ActivationList($status,$today);    
            $popup=false;
        }
    	
    	$response=array();
    	$response['responseData']=$activeList;
    	$response['pageTitle']=$text."Activation Report";
        if($status==3){
            $response['pageTitle']="Renew Report";
        }
        $response['modelPageName']="commonpopup.php";
        $response['submitUrl']="MemberDetail/ActivationReport/".$status;
        $response['searchBtn']=true;
        $response['popup']=$popup;
        //print_r($response);
		$this->load->view('mainTable',$response);
    }

    public function MemberShortcut(){
        $response['memberId'] = '';
        if($this->uri->segment(4)) {
            $response['memberId'] = $this->uri->segment(4);
        }
        $this->load->view('memberShortcut',$response);
    }
	
    public function MemberLogin(){
        $username = $this->input->post('memberId');
        $rdrct = '/member/dashboard';
        if($this->uri->segment(4)) {
            $rdrct = '/member/'.$this->uri->segment(4);
        }

        $result = $this->MemberDetailModel->LoginMember($username);

        if($result == false) {
            $response[''] = '';
            $this->load->view('memberShortcut',$response);
        }
        else {
            $session_data = array(
            'username' => $result[0]->username,
            'userid' => $result[0]->id,
            );
            $this->session->set_userdata('logged_in', $session_data);
            redirect($rdrct);
        }
    }

    public function Usernamechange(){
        $response=array();
        $this->load->view('usernamechange',$response);
    }

    public function UsernamechangeSubmit(){
        $oldmemberId=$this->input->post('oldmemberId');
        $newmemberId=$this->input->post('newmemberId');
        
        $response=array();
        $response['status']=false;
        $response['msg']='Some Error Occur';

        $checkValidation = $this->AdminModel->checkMemberId($oldmemberId);
        if(!$checkValidation['status']){
          $response['msg']='Memberid Is Invalid';
          print_r(json_encode($response));  
        }

        $checkValidationnew = $this->AdminModel->checkMemberId($newmemberId);
        if($checkValidationnew['status']){
          $response['msg']='Memberid Is Already Used';
          print_r(json_encode($response));  
        }

        $data=array();
        $data['oldmemberId']=$oldmemberId;
        $data['newmemberId']=$newmemberId;
        $data['userid']=$checkValidation['data'][0]['id'];
        $updateusername = $this->MemberDetailModel->UpdateUsername($data);

        if($updateusername['status']){
            $response['status']=true;
            $response['msg']='Username Updated Successfully';
        }
        print_r(json_encode($response));    
    }
    public function ActivationReports(){
        $today=array();
        $dateStart=$this->input->post('dateStart');
        $dateEnd=$this->input->post('dateEnd');

        if($dateStart!=''){
            $dateStart = date('Y-m-d', strtotime($dateStart));
            $today['dateFrom']=$dateStart;
        }
        if($dateEnd!=''){
            $dateEnd = date('Y-m-d', strtotime($dateEnd));
            $today['dateTo']=$dateEnd;
        }

        $activeList=$this->MemberDetailModel->ActivationList($today);    
        $popup=false;
    
        $response=array();
        $response['responseData']=$activeList;
        $response['pageTitle']="Activation Report";
        $response['modelPageName']="commonpopup.php";
        $response['submitUrl']="MemberDetail/ActivationReports/";
        $response['searchBtn']=true;
        $this->load->view('mainTable',$response);
    }
}
?>