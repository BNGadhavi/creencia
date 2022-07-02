<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminMaster extends MX_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('AdminMasterModel');
        $adminLoggedIn = $this->session->userdata('adminLoggedIn');
        $userid = $adminLoggedIn['userid'];
        $this->sessionAdminUserid=$userid;
    }

    public function Index() {
        $adminLoggedIn = $this->session->userdata('adminLoggedIn');
        $userid = $adminLoggedIn['userid'];
        $data = array();
        $data['type'] = 1;
        $data['userid'] = $userid;
        $response = array();
        $ReportData = $this->AdminMasterModel->Report($data);
        $response['responseData'] = $ReportData;
        $response['pageTitle'] = "Admin Report";
        $this->load->view('mainTable',$response);
    }

    public function AdminRight() {
        $data = array();
        $adminLoggedIn = $this->session->userdata('adminLoggedIn');
        $userid = $adminLoggedIn['userid'];
        $data['type'] = 1;
        $data['userid'] = $userid;
        $ReportData = $this->AdminMasterModel->Report($data);
        $RightData = $this->AdminMasterModel->RightData($data);
        
        $FinalRightData = array();
        $index = 0;
        foreach ($RightData['data'] as $key => $value) {
            $parentKey = $value['Parent Id'];
            if(!array_key_exists($parentKey, $FinalRightData)) {
                $FinalRightData[$parentKey]['Parent Menu'] = $value['Parent Name']; 
            }
            $FinalRightData[$parentKey]['sub'][$value['id']] = $value['menuname'];
        }

        $response = array();
        $response['responseData'] = $ReportData;
        $response['rightData'] = $FinalRightData;
        $response['pageTitle'] = "Admin Right";
        $this->load->view('AdminRight',$response);
    }

    public function RightUpdate() {
        $adminLoggedIn = $this->session->userdata('adminLoggedIn');
        $userid = $adminLoggedIn['userid'];

        $this->AdminMasterModel->RightUpdate($userid, $_POST);
        $response = array();
        $response['status'] = true;
        echo json_encode($response);
    }

    public function RightCheck() {
        $userid = $_POST['userid'];
        $data['userid'] = $userid;
        $RightStatus = $this->AdminMasterModel->RightStatus($data);
        echo json_encode($RightStatus);     
    }
}
?>