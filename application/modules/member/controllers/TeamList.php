<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TeamList extends MX_Controller {
	public function __construct() {
    	parent::__construct();
      $this->load->model('TeamModel','TeamModel'); 
      $logged_in = $this->session->userdata('logged_in');
      $userid=$logged_in['userid'];
      $this->sessionUserid=$userid;
    }

    
  public function index(){
    $userId=$this->sessionUserid;
    $side = $this->input->get('side', TRUE );

    $data = array();
    $text = '';
    if($side != '') {
      $data['side'] = $side;
      if($side == '0') {
        $text = " - Left";
      }
      else if($side == '2') {
        $text = " - Right";
      }
    }

    $MemberSponsorList=$this->TeamModel->GetSponsorList($userId, $data);
    $response=array();
    $response['responseData']=$MemberSponsorList;
    $response['pageTitle']="Direct Associate".$text;
    $this->load->view('mainTable',$response);

  }

  public function LevelWiseSummary(){
    $type=$this->uri->segment(4);
    if($type=='')
    {
      $userId=$this->sessionUserid; 
      $DownlineList=$this->TeamModel->GetDownline($userId);
      $response=array();
      $response['responseData']=$DownlineList;
      $response['pageTitle']="Level Wise Summary";
    }
    else
    {
      $userId=$this->sessionUserid; 
      $DownlineList=$this->TeamModel->GetDirectDownline($userId);
      $response=array();
      $response['responseData']=$DownlineList;
      $response['pageTitle']="Direct Sponsor Summary";
    }
    $this->load->view('mainTable',$response);

  }
	
  public function DownlineSummary(){
    $userId=$this->sessionUserid; 
    $levelNo=$this->input->get('level', TRUE );
    $direct=$this->input->get('direct', TRUE );
    $side = $this->input->get('side', TRUE );
    $active = $this->input->get('active', TRUE );
    $today = $this->input->get('today', TRUE );

    if($direct==0)
    {
      $data=array();
      $data['levelno']=$levelNo;

      $text = '';
      if($side != '') {
        $data['side'] = $side;
        if($side == '0') {
          $text = " - Left";
        }
        else if($side == '2') {
          $text = " - Right";
        }
      }
      if($active != '') {
        $data['active'] = $active;
        $text = " - Active List".$text;
      }
      if($today != '') {
        $data['dateStart'] = CurrentDate();
      }

      $DetailDownlineList=$this->TeamModel->GetDownlineLevelwise($userId,$data);

      $response=array();
      $response['responseData']=$DetailDownlineList;
      $response['pageTitle']="Downline Summary".$text;
      $this->load->view('mainTable',$response);
    }
    else
    {
      $data=array();
      $data['levelno']=$levelNo;
      $DetailDownlineList=$this->TeamModel->GetDirectDownlineLevelwise($userId,$data);

      $response=array();
      $response['responseData']=$DetailDownlineList;
      $response['pageTitle']="Direct Downline Summary";
      $this->load->view('mainTable',$response);
    }
    
  }
  public function Levelbvreport(){
    $userId=$this->sessionUserid; 
    $DownlineList=$this->TeamModel->GetLevelwisebv($userId);
    $response=array();
    $response['responseData']=$DownlineList;
    $response['pageTitle']="Level Wise BV Report";
    $this->load->view('mainTable',$response);
  }
}
?>