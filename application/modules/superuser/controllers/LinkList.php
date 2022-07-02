<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LinkList extends MX_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('packagemaster_helper');
        $this->load->helper('link_helper');
        $this->load->model('LinkModel');

        $adminLoggedIn = $this->session->userdata('adminLoggedIn');
        $userid=$adminLoggedIn['userid'];
        $this->sessionAdminUserid=$userid;
        exit();
    }

    public function Index(){
        $data=array();
        $data['adminFlag']=true;
        $LinkList=AllLinkList($data);
        $response=array();
        $response['responseData']=$LinkList;
        $response['pageTitle']="Link Report";
        $this->load->view('mainTable',$response);
    }

    public function LinkMaster(){
        $PackageList=PackageListForAdmin();
        $response=array();
        $response['packageList']=$PackageList;
        $this->load->view('linkMaster',$response);
    }

    public function LinkMasterSubmit(){
        $packageId=$this->input->post('packagename');
        $link=$this->input->post('link');

        $response=array();
        $response['status']=false;
        $response['msg']='Some Error Occur';        
        $data=array();
        
        $data['packageId']=$packageId;
        $data['link']=$link;
        $responseLinkData=$this->LinkModel->SaveLinkData($data);        
        if($responseLinkData['status']){
            $response['status']=true;
            $response['msg']="Link Saved Successfully.";
        }

        print_r(json_encode($response));
    }

    public function DeleteLink(){
        $linkId=$this->uri->segment(4); 

        $response=array();
        $response['actionstatus']=false;
        $response['actionmsg']='Some Error Occur';        
 
        $data=array();
        $data['linkId']=$linkId;
        $responseLinkData=$this->LinkModel->LinkDelete($data);        
        
      
        if($responseLinkData['status']){
            $response['actionstatus']=true;
            $response['actionmsg']='Link Deleted Successfully';
        } 
        $this->session->set_userdata('setMessageData', $response);
        redirect('/mainadmin/LinkList');

       
    }
    

    
}
?>