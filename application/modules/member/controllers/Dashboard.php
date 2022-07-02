<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {
	public function __construct()
    {
    	parent::__construct();
    	$this->load->helper('url');
    	$this->load->helper('security');
    	$this->load->model('Dashboard_model');
    	$this->load->library('pagination');
    	$this->load->helper('income');
    	$this->load->helper('sms_helper');
    	if (!isset($this->session->userdata['logged_in'])) {
			$redirection = base_url('login');
			header("location: $redirection");
		}
    	$logged_in = $this->session->userdata('logged_in');
		$userid=$logged_in['userid'];
		$memberid=$logged_in['username'];
		$this->sessionUserid=$userid;
		$this->sessionMemberid=$memberid;
		//DailyIncome();
    }

	public function index()
	{
		$userId=$this->sessionUserid;
    	$memberId=$this->sessionMemberid;
    	
    	$topwidgetresult = $this->Dashboard_model->dashboardTopWidget($userId);
    	$response['topwidget'] = $topwidgetresult[0];

    	$profileresult = $this->Dashboard_model->profileDetail($userId);
    	$response['profile'] = $profileresult[0];

    	$sidewidgetresult = $this->Dashboard_model->dashboardSideWidget($userId);
    	$response['sidewidget'] = $sidewidgetresult[0];
    	
    	$this->load->view('dashboard', $response);
	}
	public function table()
	{
		$this->load->view('table');
	}
	public function table1()
	{
		$data=array();

		$config['use_page_numbers'] = TRUE;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['total_rows'] = 30;
		$config['per_page'] = 5;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$this->db->select('*');
		$this->db->from('mlm_userlogin');
		//$this->db->limit(10);
		$query = $this->db->get()->result();
		$data['test']=$query;
		$this->load->view('table1',$data);
	}
	public function form()
	{
		$this->load->view('form');
	}
	public function login()
	{
		$this->load->view('login');
	}
	public function signup()
	{
		$this->load->view('signup');
	}
	public function login_submit()
	{
		
		/*$result = $this->Dashboard_model->uselogindata('456789');
		print_r($result);*/
		
		/*$this->form_validation->set_rules('username', 'Username', 'trim|required|callback_checkusername',
			array('required' => 'You must provide a %s.')
		);

		
	
		$this->form_validation->set_rules('password', 'Password', 'trim|required',
			array('required' => 'You must provide a %s.')
		);
		
		if ($this->form_validation->run() == FALSE) {
			if(isset($this->session->userdata['logged_in'])) {
				$this->load->view('dashboard');
			}
			else {
				$this->load->view('login');
			}
		}
		else {*/
			$data = array(
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password')
			);
			$result = $this->Dashboard_model->login($data);
			if($result == TRUE) {
				$username = $this->input->post('username');
				$result = $this->Dashboard_model->uselogindata($username);
				if($result[0]->lockmember != '0' ){
					$data = array(
					'error_message' => 'UserId  Is Locked'
					);
			
					$this->load->view('login', $data);
					
				}
				else{
					
					$session_data = array(
					'username' => $result[0]->username,
					'userid' => $result[0]->id,
					);
				// Add user data in session
					$this->session->set_userdata('logged_in', $session_data);
					redirect('/member/dashboard');
				}
				
			} 
			else {
				$data = array(
					'error_message' => 'Invalid Username or Password'
				);
				$this->load->view('login', $data);
			}
		//}
	}
	public function logout() {
		// Removing session data
		$sess_array = array(
			'username' => '',
			'userid' => ''
		);
		$this->session->unset_userdata('logged_in', $sess_array);
		$data['message_display'] = 'Successfully Logout';
		redirect('/login');
	}

	public function ProfileSubmit() {
		$userId=$this->sessionUserid;
		$imageResponse=array();
		$response['status'] = true;
		if(isset($_FILES['profile']['name']))
	    {
			$imageResponse = imageUpload('profile',$_FILES['profile']['name'],'Profile');
			if(!$imageResponse['status']){
				$response['msg'] = $imageResponse['msg'];
			}
			else{
				$response['status'] = true;
			}
	    }
	    if($response['status']) {
	    	$data = array();
      		$Condition = array();
      		$data['image'] = $imageResponse['imageName'];
      		$data['userId'] = $userId;
      		$ProfileChange = $this->Dashboard_model->ProfileSubmit($data);
	    }
		
		$this->index();
	}
}
?>