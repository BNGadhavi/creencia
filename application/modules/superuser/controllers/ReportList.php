<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportList extends MX_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('incomereport_helper');
        $this->load->model('ReportModel');
      

        $adminLoggedIn = $this->session->userdata('adminLoggedIn');
        $userid=$adminLoggedIn['userid'];
        $this->sessionAdminUserid=$userid;
    }

    public function BinaryIncomeReport(){
        $dateStart=$this->input->post('dateStart');
        $dateEnd=$this->input->post('dateEnd');

        $data=array();
        if($dateStart!=''){
            $data['dateStart']=$dateStart;
        }
        if($dateEnd!=''){
            $data['dateEnd']=$dateEnd;
        }

        $BinaryIncomeList=$this->ReportModel->BinaryReport($data);
        $response=array();
        $response['responseData']=$BinaryIncomeList;
        $response['pageTitle']="Binary Income Report";
        $response['modelPageName']="commonpopup.php";
        $response['submitUrl']="ReportList/BinaryIncomeReport";
        $response['searchBtn']=true;
        $this->load->view('mainTable',$response);
    }

    public function BinaryIncomeDetail(){
        $userid=$this->uri->segment(4);
        $data=array();
        $dateStart=$this->uri->segment(5);
        $dateEnd=$this->uri->segment(6);

        $data=array();
        $data['userId']=$userid;
        $data['adminFlag']=true;
        if($dateStart!=''){
            $data['dateStart']=$dateStart;
        }
        if($dateEnd!=''){
            $data['dateEnd']=$dateEnd;
        }
        
        $data['userId']=$userid;
        $data['adminFlag']=true;
        $BinaryIncomeList=BinaryIncomeHelper($data);
        $userData=array();
        $userData['userId']=$userid;
        $userInfo=$this->ReportModel->UserInfoForReport($userData);
        $response=array();
        $response['responseData']=$BinaryIncomeList;
        $response['includePageData']=$userInfo['UserData'];
        $response['pageTitle']="Binary Income";
        $this->load->view('mainTable',$response);
    }
    
    public function SponsorIncomeReport(){
        $dateStart=$this->input->post('dateStart');
        $dateEnd=$this->input->post('dateEnd');

        $data=array();
        if($dateStart!=''){
            $data['dateStart']=$dateStart;
        }
        if($dateEnd!=''){
            $data['dateEnd']=$dateEnd;
        }
        $SponsorIncomeList=$this->ReportModel->SponsorReport($data);
        $response=array();
        $response['responseData']=$SponsorIncomeList;
        $response['pageTitle']="Sponsor Income Report";
        $response['modelPageName']="commonpopup.php";
        $response['submitUrl']="ReportList/SponsorIncomeReport";
        $response['searchBtn']=true;
        $this->load->view('mainTable',$response);
    }
    public function SponsorIncomeDetail(){
        $userid=$this->uri->segment(4);
        $dateStart=$this->uri->segment(5);
        $dateEnd=$this->uri->segment(6);
        $data=array();
        $data['userId']=$userid;
        $data['adminFlag']=true;
        if($dateStart!=''){
            $data['dateStart']=$dateStart;
        }
        if($dateEnd!=''){
            $data['dateEnd']=$dateEnd;
        }
        $SponsorIncomeList=SponsorIncomeHelper($data);
        $userData=array();
        $userData['userId']=$userid;
        $userInfo=$this->ReportModel->UserInfoForReport($userData);

        $response=array();
        $response['responseData']=$SponsorIncomeList;
        $response['includePageData']=$userInfo['UserData'];
        $response['pageTitle']="Sponsor Income Report";
        $this->load->view('mainTable',$response);
    }

    public function RoiIncomeReport(){
        $dateStart=$this->input->post('dateStart');
        $dateEnd=$this->input->post('dateEnd');
        $data=array();
        if($dateStart!=''){
            $data['dateStart']=$dateStart;
        }
        if($dateEnd!=''){
            $data['dateEnd']=$dateEnd;
        }
        $text="Roi Income Report";
        $RoiIncomeList=$this->ReportModel->RoiIncomeList($data);
        $response=array();
        $response['responseData']=$RoiIncomeList;
        $response['pageTitle']=$text;
        $this->load->view('mainTable',$response);
    }
    public function RoiIncomeReports(){
        $dateStart=$this->input->post('dateStart');
        $dateEnd=$this->input->post('dateEnd');

        $data=array();
        if($dateStart!=''){
            $data['dateStart']=$dateStart;
        }
        if($dateEnd!=''){
            $data['dateEnd']=$dateEnd;
        }
        $text="Roi Income Report";
        $RoiIncomeList=$this->ReportModel->RoiIncomeLists($data);
        $response=array();
        $response['responseData']=$RoiIncomeList;
        $response['pageTitle']=$text;
        $this->load->view('mainTable',$response);
    }

    public function RoiIncomeDetail(){
        $userid=$this->uri->segment(4);
        $dateStart=$this->uri->segment(5);
        $dateEnd=$this->uri->segment(6);
        $data=array();
      
        if($dateStart!=''){
            $data['dateStart']=$dateStart;
        }
        if($dateEnd!=''){
            $data['dateEnd']=$dateEnd;
        }

        $data['userId']=$userid;
        $data['adminFlag']=true;
        $RoiIncomeList=RoiIncomeHelper($data);
        $text="Roi Income Report";
        $userData=array();
        $userData['userId']=$userid;
        $userInfo=$this->ReportModel->UserInfoForReport($userData);
        $response=array();
        $response['responseData']=$RoiIncomeList;
        $response['includePageData']=$userInfo['UserData'];
        $response['pageTitle']=$text;
        $this->load->view('mainTable',$response);
    }
    public function RoiIncomeDetails(){
        $id=$this->uri->segment(4);
        $userid=$this->uri->segment(5);
        $dateStart=$this->uri->segment(6);
        $dateEnd=$this->uri->segment(7);
        $data=array();
      
        if($dateStart!=''){
            $data['dateStart']=$dateStart;
        }
        if($dateEnd!=''){
            $data['dateEnd']=$dateEnd;
        }

        $data['id']=$id;
        $data['adminFlag']=true;
        $RoiIncomeList=$this->ReportModel->RoiIncomeHelpers($data);
        $text="Roi Income Report";
        $userData=array();
        $userData['userId']=$userid;
        $userInfo=$this->ReportModel->UserInfoForReport($userData);
        $response=array();
        $response['responseData']=$RoiIncomeList;
        $response['includePageData']=$userInfo['UserData'];
        $response['pageTitle']=$text;
        $this->load->view('mainTable',$response);
    }

     public function CapitalwalletReport(){
        $dateStart=$this->input->post('dateStart');
        $dateEnd=$this->input->post('dateEnd');

        $data=array();
        if($dateStart!=''){
            $data['dateStart']=$dateStart;
        }
        if($dateEnd!=''){
            $data['dateEnd']=$dateEnd;
        }

        $BinaryIncomeList=$this->ReportModel->Walletrpt($data);
        $response=array();
        $response['responseData']=$BinaryIncomeList;
        $response['pageTitle']="Capital Wallet Statement";
        $this->load->view('mainTable',$response);
    }
    public function Walletdetail(){
        $userid=$this->uri->segment(4);
        $data=array();
        $data['userId']=$userid;
        $data['wallettype']='Capital Wallet';
        $BinaryIncomeList=AccountStatementHelper($data);
        $response=array();
        $response['responseData']=$BinaryIncomeList;
        $response['pageTitle']="Capital Wallet Statement";
        $this->load->view('mainTable',$response);
    }
    public function MasterReport(){
        $data=array();
        //$WithdrwalList = $this->ReportModel->Masterrpt($data);
        $WithdrwalList = Masterrpt($data);
        $response=array();
        $response['responseData']=$WithdrwalList;
        $response['pageTitle']="Turnover Report";
        $this->load->view('mainTable',$response);
    }
    public function AdminchargeReport(){
        $status=1;
        $data=array();
        $dateStart=$this->input->post('dateStart');
        $dateEnd=$this->input->post('dateEnd');

        $userid=$this->sessionAdminUserid;
        $data['status']=$status;
        
        if($dateStart!=''){
            $data['dateStart']=$dateStart;
        }
        if($dateEnd!=''){
            $data['dateEnd']=$dateEnd;
        }
        //$WithdrwalList=$this->ReportModel->AdminchargeList($data);
        $WithdrwalList=$this->ReportModel->WithdrawalAdminchargeList($data);
        $response=array();
        $response['responseData']=$WithdrwalList;
        $response['pageTitle']="Admin Charge Report";
        $response['modelPageName']="commonpopup.php";
        $response['submitUrl']="ReportList/AdminchargeReport";
        $response['searchBtn']=true;
        $this->load->view('mainTable',$response);
    }
    public function DesignationReport(){
        $data=array();
        $BinaryIncomeList=$this->ReportModel->Rewardandaward($data);
        $response=array();
        $response['responseData']=$BinaryIncomeList;
        $response['pageTitle']="Reward & Award";
        $this->load->view('mainTable',$response);
    }
    public function DesignationReportDetail(){
        $rid=$this->uri->segment(4);
        $data=array();
        $data['rid']=$rid;
        $BinaryIncomeList=$this->ReportModel->Rewardandawarddetail($data);
        $response=array();
        $response['responseData']=$BinaryIncomeList;
        $response['pageTitle']="Reward & Award";
        $this->load->view('mainTable',$response);
    }
}
?>