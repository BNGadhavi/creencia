<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utility extends MX_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('utility_helper');
        $this->load->model('NewsModel');
        $this->load->model('AdminModel');
        $this->load->helper('member_helper');
      
        $adminLoggedIn = $this->session->userdata('adminLoggedIn');
        $userid=$adminLoggedIn['userid'];
        $this->sessionAdminUserid=$userid;
    }

    public function NewsMaster(){
        $response=array();
        $this->load->view('newsMaster',$response);
    }

    public function NewsMasterSubmit(){
        $news=$this->input->post('news');
        $response=array();
        $response['status']=false;
        $response['msg']='Some Error Occur';        
        $data=array();
        
        $data['news']=$news;
        $responseNewsData=$this->NewsModel->SaveNewsData($data);        
        if($responseNewsData['status']){
            $response['status']=true;
            $response['msg']="News Saved Successfully.";
        }

        print_r(json_encode($response));
    }
    public function NewsList(){
        $data=array();
        $data['adminFlag']=true;
        $news=ListOfNews($data);
        $response=array();
        $response['responseData']=$news;
        $response['pageTitle']="News Report";
        $this->load->view('mainTable',$response);
    }

    public function DeleteNews(){
        $newsId=$this->uri->segment(4);
        $response=array();
        $response['actionstatus']=false;
        $response['actionmsg']='Some Error Occur';        
 
        $data=array();
        $data['newsId']=$newsId;
        $responseNewsData=$this->NewsModel->NewsDelete($data);        
        
      
        if($responseNewsData['status']){
            $response['actionstatus']=true;
            $response['actionmsg']='News Deleted Successfully';
        } 
        $this->session->set_userdata('setMessageData', $response);
        redirect('/superuser/Utility/NewsList'); 
    }

    public function AchiverMaster(){
        $response=array();
        $this->load->view('achiverMaster',$response);
    }

    public function AchiverMasterSubmit(){
        $achiver=$this->input->post('achiver');
        $response=array();
        $response['status']=false;
        $response['msg']='Some Error Occur';        
        $data=array();
        
        $data['achiver']=$achiver;
        $responseNewsData=$this->NewsModel->SaveAchiverData($data);        
        if($responseNewsData['status']){
            $response['status']=true;
            $response['msg']="Achiver Saved Successfully.";
        }

        print_r(json_encode($response));
    }
    public function AchiverList(){
        $data=array();
        $data['adminFlag']=true;
        $achiver=ListOfAchiver($data);
        $response=array();
        $response['responseData']=$achiver;
        $response['pageTitle']="Achiver Report";
        $this->load->view('mainTable',$response);
    }

    public function DeleteAchiver(){
        $achiverId=$this->uri->segment(4);
        $response=array();
        $response['actionstatus']=false;
        $response['actionmsg']='Some Error Occur';        
 
        $data=array();
        $data['achiverId']=$achiverId;
        $responseNewsData=$this->NewsModel->AchiverDelete($data);        
        
      
        if($responseNewsData['status']){
            $response['actionstatus']=true;
            $response['actionmsg']='Achiever Deleted Successfully';
        } 
        $this->session->set_userdata('setMessageData', $response);
        redirect('/superuser/Utility/AchiverList'); 
    }

    public function ChangePassword(){
        $response=array();
        $this->load->view('changePassword',$response);
    }

    public function CheckPassword(){
        $oldPassword=$this->input->post('oldpass');
        $userid= $this->sessionAdminUserid;

        $data=array();
        $data['userid']=$userid;
        $data['oldPassword']=$oldPassword;   

        $result = $this->NewsModel->ValidatePassword($data);
        $response=array();
        $response['status']=false;
        if($result){
            $response['status']=true;        
        }
    
        print_r(json_encode($response));
    }

    public function UpdateChangePassword(){

        $userid= $this->sessionAdminUserid;
        $oldPassword=$this->input->post('oldpassword');
        $newPassword=$this->input->post('newpassword');

        $data=array();
        $data['userid']=$userid;
        $data['oldPassword']=$oldPassword;   

        $response=array();
        $response['status']=false;
        $response['msg']='Some Error Occur';
        $result = $this->NewsModel->ValidatePassword($data);
        if(!$result){
            $response['msg']='Old Password Is Invalid';
            print_r(json_encode($response));
            exit();
        }

        $updatePasswordData=array();
        $updatePasswordData['userId']=$userid;
        $updatePasswordData['oldPassword']=$oldPassword;
        $updatePasswordData['newPassword']=$newPassword;
        $this->NewsModel->UpdatePassword($updatePasswordData);
        $response['status']=true;
        $response['msg']='Password Updated Successfully.';

        print_r(json_encode($response));
    }
   
    public function LockMember(){
        $response=array();
        $this->load->view('lockMember',$response);
    }

    public function ValidateLockMemberId(){
        $memberId=$this->input->post('memberId');
        $extraColumn=",mlm_userlogin.lockmember";
        $MemberInfo=$this->AdminModel->checkMemberId($memberId,'',$extraColumn);
        $response['status']=false;
       
        if($MemberInfo['status']){
            if($MemberInfo['data'][0]['lockmember']=='1'){
                $response['msg']='MemberId Is Already Locked';
            }
            else{
                $response['status']=true;
                $response['Name']=$MemberInfo['data'][0]['Name'];
            }
        }
        else{
             $response['msg']='MemberId Is Invalid';
        }
        print_r(json_encode($response));
    }

   public function LockMemberSubmit(){
    $memberId=$this->input->post('memberId');
    $extraColumn=",mlm_userlogin.lockmember";
    $MemberInfo=$this->AdminModel->checkMemberId($memberId,'',$extraColumn);
    $response['status']=false;

    if($MemberInfo['status']){
        if($MemberInfo['data'][0]['lockmember']=='1'){
            $response['msg']='MemberId Is Already Locked';
            print_r(json_encode($response));
            exit();
        }
        else if($MemberInfo['data'][0]['lockmember']=='2'){
            $response['msg']='MemberId Is Already Locked';
            print_r(json_encode($response));
            exit();
        }

    }
    else{
         $response['msg']='MemberId Is Invalid';
         print_r(json_encode($response));
         exit();
    }
      

        $userId=$MemberInfo['data'][0]['id'];
        $data=array();
        $data['userId'] = $userId;
        $data['status']='1';
        $data['memberId']=$memberId;
        $lockResponse=$this->NewsModel->UpdateLockStatus($data);
        if($lockResponse['status']){
            $response['status']=true;
            $response['msg']="User Locked Successfully.";
        }
        print_r(json_encode($response));
    }

    public function LockMemberReport(){
        $lockMemberList=$this->NewsModel->LockMemberList();
        $response=array();
        $response['responseData']=$lockMemberList;
        $response['pageTitle']="Lock Member Report";
        $this->load->view('mainTable',$response);
    }
    public function UnlockMember(){
        $userId=$this->uri->segment(4);

        $data=array();
        $data['extraColumn']=",A.activestatus,A.lockmember";
        $memberInfo=FetchMemberInfo($userId,$data);
        $lockmem=$memberInfo['data'][0]['lockmember'];

        $data=array();
        $data['userId'] = $userId;
        $data['status']='0';
        $data['lockmem']=$lockmem;
        $response=array();
        $response['actionstatus']=false;
        $response['actionmsg']='Some Error Occur';

        $lockResponse=$this->NewsModel->UpdateLockStatus($data);
        if($lockResponse['status']){
            $response['actionstatus']=true;
            $response['actionmsg']='User Unlocked Successfully.';
        }
        $this->session->set_userdata('setMessageData', $response);
        redirect('/superuser/Utility/LockMemberReport');
    }
    public function ContactUsReport(){
        $data=array();
        $data['adminFlag']=true;
        $achiver=ListOfContactus($data);
        $response=array();
        $response['responseData']=$achiver;
        $response['pageTitle']="Contactus Report";
        $this->load->view('mainTable',$response);
    }

    public function DeleteContact(){
        $achiverId=$this->uri->segment(4);
        $response=array();
        $response['actionstatus']=false;
        $response['actionmsg']='Some Error Occur';        
 
        $data=array();
        $data['id']=$achiverId;
        $responseNewsData=$this->NewsModel->ContactUsDelete($data);        
        
      
        if($responseNewsData['status']){
            $response['actionstatus']=true;
            $response['actionmsg']='Record Deleted Successfully';
        } 
        $this->session->set_userdata('setMessageData', $response);
        redirect('/superuser/Utility/ContactUsReport'); 
    }
    public function Coinsetup(){
        $response=array();
        $tabelName="mlm_nfive";
        $condition = "type ='0'";
        $getData=CreateSingleQuery($tabelName,$condition);
        $getData=json_decode($getData,true);
        $response['buy'] = $getData['data'][0];
        $tabelName="mlm_nfive";
        $condition = "type ='1'";
        $getData=CreateSingleQuery($tabelName,$condition);
        $getData=json_decode($getData,true);
        $response['sell'] = $getData['data'][0];
        $this->load->view('Shippingcharge',$response);
    }
    public function Shippingchargeupdate(){
        $buy=$this->input->post('buy');
        $sell=$this->input->post('sell');
        $response=array();
        $response['status']=false;
        $response['msg']='Some Error Occur';        
        $data=array();
        $data['buy']=$buy;
        $data['sell']=$sell;
        $responseNewsData=$this->NewsModel->SaveShippingData($data);        
        if($responseNewsData['status']){
            $response['status']=true;
            $response['msg']="Shipping Charge Amount Updated Successfully.";
        }

        print_r(json_encode($response));
    }
}
?>