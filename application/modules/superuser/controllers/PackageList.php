<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PackageList extends MX_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('packagemaster_helper');
        $this->load->model('PackageModel');

        $adminLoggedIn = $this->session->userdata('adminLoggedIn');
        $userid=$adminLoggedIn['userid'];
        $this->sessionAdminUserid=$userid;
    }

    public function Index(){
        $PackageList=PackageListForAdmin();
        $response=array();
        $response['responseData']=$PackageList;
        $response['pageTitle']="Package  Report";
        $this->load->view('mainTable',$response);
    }

    public function AddPackageMaster(){
        $response=array();
        $this->load->view('packageMaster',$response);
    }

    public function AddPackageMasterSubmit(){
        $userid=$this->sessionAdminUserid;
        $packageName=$this->input->post('packageName');
        $amount=$this->input->post('amount');
        $tax=$this->input->post('tax');
        $roiAmt=$this->input->post('roiAmt');
        $roiDays=$this->input->post('roiDays');
        $capping=$this->input->post('capping');
        $directPer=$this->input->post('directPer');
        $packagePV=$this->input->post('packagePV');
        $packageBV=$this->input->post('packageBV');
        $priority=$this->input->post('priority');
        
        $data=array();
        $data['packageName'] = $packageName;
        $data['amount'] = $amount;
        $data['tax'] = $tax;
        $data['roiAmt'] = $roiAmt;
        $data['roiDays'] = $roiDays;
        $data['capping'] = $capping;
        $data['directPer'] = $directPer;
        $data['packagePV'] = $packageBV;
        $data['packageBV'] = $packagePV;
        $data['priority'] = $priority;
        $data['addedby'] =$userid;
        $data['shoppingbal']=$amount;

        $response=array();
        $response['status']=false;
        $response['msg']='Some Error Occur.';
        $addInfo=$this->PackageModel->AddPackageMaster($data);
        if($addInfo['status']){
            $response['status']=true;
            $response['msg']="Package Information Added Successfully";
        }

        print_r(json_encode($response));

    }

    public function EditPackageMaster(){
        $packageId=$this->uri->segment(4);
        $data=array();
        $data['packageId'] = $packageId;
        $PackageInfo=PackageListForAdmin($data);
        $response=array();
        $response['packageInfo']=$PackageInfo;
        $this->load->view('packageMaster',$response);
    }
    public function EditPackageMasterSubmit(){
        $userid=$this->sessionAdminUserid;
        $packageId=$this->input->post('packageId');
        $packageName=$this->input->post('packageName');
        $amount=$this->input->post('amount');
        $tax=$this->input->post('tax');
        $roiAmt=$this->input->post('roiAmt');
        $roiDays=$this->input->post('roiDays');
        $capping=$this->input->post('capping');
        $directPer=$this->input->post('directPer');
        $packagePV=$this->input->post('packagePV');
        $packageBV=$this->input->post('packageBV');
        $priority=$this->input->post('priority');
        
        $data=array();
        $data['packageName'] = $packageName;
        $data['amount'] = $amount;
        $data['tax'] = $tax;
        $data['roiAmt'] = $roiAmt;
        $data['roiDays'] = $roiDays;
        $data['capping'] = $capping;
        $data['directPer'] = $directPer;
        $data['packagePV'] = $packagePV;
        $data['addedby'] =$userid;
        $data['packageId']=$packageId;
        $data['packageBV'] = $packageBV;
        $data['priority'] = $priority;
        $data['shoppingbal']=$amount;

        $response=array();
       
        $response['status']=false;
        $response['msg']="Some Error Occur";
       
        $updateInfo=$this->PackageModel->UpdatePackageMaster($data);
        if($updateInfo['status']){
            $response['status']=true;
            $response['msg']="Package Information Updated Successfully";
        }

        print_r(json_encode($response));

    }

    
}
?>