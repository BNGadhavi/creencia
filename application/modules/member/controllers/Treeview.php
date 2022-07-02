<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Treeview extends MX_Controller {
	public function __construct()
    {
    	parent::__construct();
    	$this->load->helper('url');
      $this->load->helper('main_helper');
      $this->load->helper('treeview_helper');
      $this->load->helper('member_helper');
      $this->load->model('Commonmodel','CommonModel');
      $this->load->model('Activationmodel','ActivationModel'); 
      $logged_in = $this->session->userdata('logged_in');
      $userid=$logged_in['userid'];
      $memberid=$logged_in['username'];
      $this->sessionUserid=$userid;
      $this->sessionMemberid=$memberid;

      
    }

	public function index(){

    $userId=$this->sessionUserid;
    $memberId=$this->sessionMemberid;

    if($this->uri->segment(4)) {
      $user = $this->uri->segment(4);
    }
    else {
      $user = $userId;
    }

    $downarr = checkdownid($user, $userId);
    if($downarr['status']) {
      $user = $user; 
    }
    else {
      $user = $userId;  
    }

    $response = array();
    $MainTable="mlm_userlogin";
    $JoinTable=array();
    $JoinTable[0]="mlm_userdetail";
    $JoinTable[1]="mlm_userstructure";
    $JoinTable[2]="mlm_userdownline";
    
    $JoinOn=array();
    $JoinOn[0]="mlm_userlogin.id=mlm_userdetail.userid";
    $JoinOn[1]="mlm_userdetail.userid=mlm_userstructure.userid";
    $JoinOn[2]="mlm_userdetail.userid=mlm_userdownline.userid";
  
    $Condition="mlm_userstructure.uplineid='$user' and mlm_userstructure.levelno<=4";
    $SelectColumn="mlm_userlogin.id,mlm_userlogin.username, mlm_userlogin.activestatus, mlm_userlogin.purchasestatus, mlm_userdownline.upline,mlm_userstructure.levelno,mlm_userdownline.side,mlm_userdetail.fullname";
   
    $TreeList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,array(),'mlm_userstructure.levelno'); 
    $TreeList=json_decode($TreeList,true);
    $TreeData=$TreeList['data'];
    $newArray=array();
    foreach ($TreeData as $key => $value) {
      $upline=$value['upline'];
      $side=$value['side'];
      $newArray[$upline][$side]['username']=$value['username'];
      $newArray[$upline][$side]['name']=$value['fullname'];
      $newArray[$upline][$side]['userid']=$value['id'];
      $newArray[$upline][$side]['activestatus']= $value['activestatus'];
      $newArray[$upline][$side]['purchasestatus']= $value['purchasestatus'];
    }

    $MainTableUser = "mlm_userlogin";
    $JoinTableUser = array();
    $JoinTableUser[0] = "mlm_userdetail";
    $JoinTableUser[1] = "mlm_userdownline";

    $JoinOnUser = array();
    $JoinOnUser[0] = "mlm_userlogin.id = mlm_userdetail.userid";
    $JoinOnUser[1] = "mlm_userlogin.id = mlm_userdownline.userid";

    $JoinTypeUser = array();
    $JoinTypeUser[1] = 'left'; 

    $ConditionUser = "mlm_userlogin.id = '$user'";
    $SelectColumnUser = "mlm_userlogin.id AS 'userid', mlm_userlogin.username AS 'username', mlm_userlogin.activestatus, mlm_userlogin.purchasestatus, mlm_userdetail.fullname AS 'name', mlm_userdownline.upline";

    $TreeListUser = CreateJoinQuery($MainTableUser, $JoinTableUser, $JoinOnUser, $ConditionUser, $SelectColumnUser, $JoinTypeUser); 
    $TreeListUser = json_decode($TreeListUser,true);
    $TreeDataUser[0] = $TreeListUser['data'];

    $response['treeData'] = $newArray;
    $response['selfid'] = $user;
    $response['loginid'] = $userId;
    $response['uplineid'] = $TreeListUser['data'][0]['upline'];
    $response['treeDatauser'] = $TreeDataUser;
    $this->load->view('treeview',$response);
	}

  public function checkdownid() {
    $downid = $this->input->post('downid');
    $downmemid = FindIdUsingMemberidHelper($downid);
    if($downmemid) {
    }
    else {
      $response['status'] = false;
      echo json_encode($response);
      exit;
    }
    $userId = $this->sessionUserid;
    $downarr = checkdownid($downmemid, $userId);
    $downarr['userid'] = $downmemid;
    echo json_encode($downarr);
    exit;
  }
}
?>