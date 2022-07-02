<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorymaster extends MX_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Categorymodel','CategoryModel');
        $adminLoggedIn = $this->session->userdata('adminLoggedIn');
        $userid = $adminLoggedIn['userid'];
        $this->sessionAdminUserid=$userid;
    }

    public function Index() {
        $data = array();
        $data['adminFlag']=true;
        $ReportData = $this->CategoryModel->Report($data);
        $response = array();
        
        $response['responseData'] = $ReportData;
        $response['pageTitle'] = "Category Master Report";
        $this->load->view('mainTable',$response);
    }

    public function Add(){
        $response = array();
        $response['formflag'] = 0;
        $data=array();
        $data['parentCondition']=true;
        $response['categoryList']=$this->CategoryModel->GetAllCategory($data);
        $this->load->view('CategoryAddForm',$response);
    }


    public function Insert(){
        $parentCategory = $this->input->post('parentCategory');
        $category = $this->input->post('Category');
        $editid = $this->input->post('editid');
            
        $adminLoggedIn = $this->session->userdata('adminLoggedIn');
        $userid = $adminLoggedIn['userid'];
        
        $response = array();
        $response['status'] = false;
        $response['msg'] = 'Some Error Occur';        
        $data = array();
        
        $data['parentCategory'] = $parentCategory;
        $data['category'] = $category;
        $data['editid'] = $editid;
        $data['addedby'] = $userid;
        if($editid > 0) {
            $responseLinkData = $this->CategoryModel->Update($data);
        }
        else {
            $responseLinkData = $this->CategoryModel->Insert($data);
        }

        if($responseLinkData['status']){
            $response['status'] = true;
            $response['msg'] = "Category Saved Successfully.";
        }
        print_r(json_encode($response));
    }

   public function Edit(){
        
        $response = array();
        $response['formflag'] = 0;
        if($this->uri->segment(4)) {
            $Id = $this->uri->segment(4);
            $data['Id'] = $Id;
            $EditData = $this->CategoryModel->Edit($data);
            if($EditData['status']) {
                $response['EditData'] = $EditData['data'][0];
                $response['formflag'] = $Id;
                $response['categoryList']=$this->CategoryModel->GetAllCategory();
            }
        }
        $this->load->view('CategoryAddForm',$response);
    }

    public function Delete() {
        $Id = $this->uri->segment(4);
        $response = array();
        $response['actionstatus'] = false;
        $response['actionmsg'] = 'Some Error Occur';

        $adminLoggedIn = $this->session->userdata('adminLoggedIn');
        $userid = $adminLoggedIn['userid'];

        $data = array();
        $data['Id'] = $Id;
        $data['adminid'] = $userid;
        $responseGSTData = $this->CategoryModel->Delete($data);
        if($responseGSTData['status']){
            $response['actionstatus'] = true;
            $response['actionmsg'] = 'Category Deleted Successfully';
        }
        echo json_encode($response);
    }


    
}
?>