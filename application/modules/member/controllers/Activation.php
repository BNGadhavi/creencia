<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activation extends MX_Controller {
	public function __construct()
  {
  	parent::__construct();
  	$this->load->helper('url');
    $this->load->helper('main_helper');
    $this->load->model('Commonmodel','CommonModel'); 
    $this->load->model('Activationmodel','ActivationModel'); 
    $this->load->helper('income_helper');
    $this->load->helper('member');
    $this->load->helper('sms');
    $this->load->helper('wallet');
    $logged_in = $this->session->userdata('logged_in');
    $userid=$logged_in['userid'];
    $memberid=$logged_in['username'];
    $this->sessionUserid=$userid;
    $this->sessionMemberid=$memberid;      
  }

	public function index() {

    $userId=$this->sessionUserid;
    $memberId=$this->sessionMemberid;
   
    $response=array();
    $packageArray=array();
    $packageArray['condition']=" and lockPackage = '0' and view='view'";
    $packageInfo=$this->CommonModel->GetPackageList($userId,$packageArray);
    $response['packagList']=$packageInfo;
    $GetMemberStatus=$this->CommonModel->CheckMemberidValid($memberId);
    if($GetMemberStatus['data'][0]['activestatus'] == '0'){
      $memberId=$memberId;
    }
    else{
      $memberId='';
    }

    $data=array();
    $data['userId']=$userId;
    $data['walletType']='Capital Wallet';
    $walletInfo=UserWalletBalance($data);

    $response['memberId']=$memberId;
    $response['walletamount']=$walletInfo['data'][0]['Balance'];
    $this->load->view('activationForm',$response);
	}
  public function ValidateBalance(){

    $userId=$this->sessionUserid;
    $packageId=$this->input->post('packageId');
    
    $packageArray=array();
    $packageArray['condition']=" and lockPackage = '0' and view='view' and id='$packageId'";
    $packageInfo=$this->CommonModel->GetPackageList($userId,$packageArray);
    $packageAmount=$packageInfo['data'][0]['netmrp'];

    $data=array();
    $data['userId']=$userId;
    $data['walletType']='Capital Wallet';
    $walletInfo=UserWalletBalance($data);
    $Balance=$walletInfo['data'][0]['Balance'];
    $response['status']=false;
    if($Balance >= $packageAmount) {
      $response['status']=true;
    }
    else{
      $response['msg']="No Sufficient Balance"; 
    }
    print_r(json_encode($response));

  }

  public function MemberidValid(){

    $userId=$this->sessionUserid;
    $memberId=$this->input->post('memberId');
    $packageId=$this->input->post('packageId');
    $CheckMemberid=$this->CommonModel->CheckMemberidValid($memberId);
    $response['status']=false;
    if($CheckMemberid['status']) {
        if($CheckMemberid['data'][0]['activestatus'] == '0'){
          $response['status']=true;
          $response['memberName']=$CheckMemberid['data'][0]['fname'];
        }
        else{
          //$response['msg']="Memberid is Already Active"; 
         $upgradtionData=array();
         $upgradtionData['memberId']=$memberId;
         $upgradtionData['newPackageId']=$packageId;
         $upgradtionData['currentPackageId']=$CheckMemberid['data'][0]['packagecode'];
         $upgardtionResponse=CheckUpgaradtionProcess($upgradtionData);
         if($upgardtionResponse['status']){
          $response['status']=true;
          $response['memberName']=$CheckMemberid['data'][0]['fname'];
         }
         else{
          $response['msg']="Memberid is Already Active"; 
         } 
        }
    }
    else{
      $response['msg']="Memberid is Invalid"; 
    }
    print_r(json_encode($response));
  }

  public function ActivationSubmit(){
    $packageId = $this->input->post('packageId');
    $memberid = $this->input->post('memberid');
    $activationMode = $this->input->post('activationMode');
    $userId=$this->sessionUserid;
    $response=array();
    $response['status'] = false;
    $saveDate=CurrentDate();
    $activeDate=$saveDate;
    $activateId=$this->CommonModel->FindIdUsingMemberid($memberid);

    $CheckMemberid=$this->CommonModel->CheckMemberidValid($memberid);
    if(!$CheckMemberid['status']){
      $response['msg']="Memberid Is Invalid";
      print_r(json_encode($response));
      exit();
    }/*
    else{
      if($CheckMemberid['data'][0]['activestatus'] != '0'){
        $response['msg']="Memberid Is Already Active";
        print_r(json_encode($response));
        exit();
      }
    }*/
    $memact=$CheckMemberid['data'][0]['activestatus'];
    $activemobile=$CheckMemberid['data'][0]['mobile'];
    if($CheckMemberid['data'][0]['activestatus'] != '0'){
      $upgradtionData=array();
      $upgradtionData['memberId']=$memberid;
      $upgradtionData['newPackageId']=$packageId;
      $upgradtionData['currentPackageId']=$CheckMemberid['data'][0]['packagecode'];
      $upgardtionResponse=CheckUpgaradtionProcess($upgradtionData);
      
      if(!$upgardtionResponse['status']){
          $response['msg']="Memberid Is Already Active";
          print_r(json_encode($response));
          exit();
      }
    }


    $packgeData=array();
    $packgeData['condition'] = " and id='$packageId'";
    $packgeData['extraColoumn']="pv,roi,roidays,roiinterval,priority,tax,netmrp,directper";
    $packageReponse=$this->CommonModel->GetPackageList($userId,$packgeData);
    $packagepv=$packageReponse['data'][0]['pv'];
    $packageamount=$packageReponse['data'][0]['mrp'];
    $packageTax=$packageReponse['data'][0]['tax'];
    $packageNetAmount=$packageReponse['data'][0]['netmrp'];
    $packagePriority=$packageReponse['data'][0]['priority'];
    $roiAmount=$packageReponse['data'][0]['roi'];
    $roiDays=$packageReponse['data'][0]['roidays'];
    $roiInterval=$packageReponse['data'][0]['roiinterval'];
    $directper=$packageReponse['data'][0]['directper'];

    $sponsorInfo=$this->CommonModel->FindSponsorId($activateId);
    $sponsorId=$sponsorInfo['data'][0]['id'];

    $newpackagepv=$packagepv;
    if($CheckMemberid['data'][0]['activestatus'] != '0'){
        $newpackagepv=0;
    } 

      $data=array();
      $data['userId']=$userId;
      $data['walletType']='Capital Wallet';
      $walletInfo=UserWalletBalance($data);
      $Balance=$walletInfo['data'][0]['Balance'];
      if($Balance < $packageNetAmount) {
        $response['msg']="You Don't Have Enough Capital Balance.";
        print_r(json_encode($response));
        exit(); 
      }

      $deductwallet=array();
      $deductwallet['userid']=$userId;
      $deductwallet['amount']=$packageNetAmount;
      $deductwallet['remarks']='Activation Of '.$memberid;
      $deductwallet['transtype']='Capital Wallet';
      $deductwallet['wallettype']='Capital Wallet';
      $walletid=WalletDeduct($deductwallet);
      $pinno=$walletid;
    
     
      $activedetail=array();
      $activedetail['entrydate'] = $saveDate;
      $activedetail['activedate']= $activeDate;
      $activedetail['userid'] = $activateId;
      $activedetail['fromid'] = $userId;
      $activedetail['packagecode'] = $packageId;
      $activedetail['activetype'] = $activationMode;
      $activedetail['activepin'] = "0";
      $activedetail['status'] = '0';
      $activedetail['activeamount'] = $packageamount;
      $activedetail['packageTax'] = '0';
      $activedetail['packageNetAmount'] = $packageNetAmount;
      $activedetail['bv'] = $packagepv;
      $activedetail['pv'] = $packagepv;
      $activedetail['type'] = '1';
      $activedetail['renew'] = '0';
      $activedetail['nooflink'] = "";
      $activedetail['linkexpirydate'] = "";
      $activeResponse=ActivationProcess($activedetail,1);

      if($activeResponse['status']){
        $activeId=$activeResponse['activeId'];
        $userid=$activateId;
        $query="SELECT A.sponsor,B.activestatus,A.side FROM `mlm_userdownline` as A , mlm_userlogin as B where A.sponsor=B.id and A.userid='$userid'";
          $resultSelects = DirectQuery($query);
          $data=$resultSelects->result_array();
          $activers = $resultSelects->result();
          $sponsorId=$data[0]['sponsor'];
          $side=$data[0]['side'];
          $sponsoractivestatus=$data[0]['activestatus'];

          if($sponsoractivestatus=='1')
          {
            if($memact=='1')
            {
            }
            else
            {
              DirectQuery("UPDATE mlm_userlogin SET activesponsor=activesponsor+1 where id='$sponsorId'");

              if($side=='0')
              {
                DirectQuery("UPDATE mlm_userlogin SET activeleftsponsor=activeleftsponsor+1 where id='$sponsorId'");
              }
              else
              {
                DirectQuery("UPDATE mlm_userlogin SET activerightsponsor=activerightsponsor+1 where id='$sponsorId'"); 
              }
            }
          }

          $directarray=array();
          $directarray['memberid']=$userid;
          $directarray['packagecode']=$packageId;
          $directarray['packagemrp']=$packageNetAmount;
          $directarray['activeId']=$activeId;
          $directarray['directper']=$directper;
          SponsorIncome($directarray);

          $roiStartDate = date('Y-m-d 23:59:59', strtotime($saveDate));

          $directarray=array();
          $directarray['userId']=$userid;
          $directarray['packageId']=$packageId;
          $directarray['roiStartDate']=$roiStartDate;
          $directarray['roiAmount']=$roiAmount;
          $directarray['roiDays']=$roiDays;
          $directarray['roiInterval']=$roiInterval;
          $directarray['activeId']=$activeId;
          $directarray['packagemrp']=$packageNetAmount;
          $directarray['roiper']="0.75";
          RoiStartProcess($directarray);
          
          $response['status']= true;
          $response['msg']="Activation Done Successfully";
      }
    print_r(json_encode($response));
  }
  
  public function ActivationReport(){
    $status=$this->uri->segment(4);
    if($status=='')
    {
      $status=0;
      $text="Activation Report";
    }
    else if($status=='2')
    {
      $status=2;
      $text="Self Activation Report";
    }
    else if($status=='3')
    {
      $status=3;
      $text="Renew Report";
    }
    else
    {
      $status=1;
      $text="Lock Activation Report";
    }
    $userId=$this->sessionUserid;
    $data=array();
    $data['userId']=$userId;
    $data['status']=$status;
    $activationList=$this->ActivationModel->ActivationList($data);
    $response=array();
    $response['responseData']=$activationList;
    $response['pageTitle']=$text;
     $this->load->view('mainTable',$response);
  }
}
?>