<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct()
    {
    	parent::__construct();
    	$this->load->helper('url');
    	$this->load->model('Dashboard_model');
    }

	public function index()
	{
		$this->load->view('dashboard');
	}
	public function table()
	{
		$this->load->view('table');
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
		$this->form_validation->set_rules('username', 'Username', 'trim|callback_checkusername|required',
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
		else {
			$data = array(
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password')
			);
			$result = $this->Dashboard_model->login($data);
			if($result == TRUE) {
				$username = $this->input->post('username');
				$result = $this->Dashboard_model->uselogindata($username);
				$session_data = array(
					'username' => $result[0]->username,
					'userid' => $result[0]->id,
				);
				// Add user data in session
				$this->session->set_userdata('logged_in', $session_data);
				$this->load->view('dashboard');
			} 
			else {
				$data = array(
					'error_message' => 'Invalid Username or Password'
				);
				$this->load->view('login', $data);
			}
		}
	}

	public function checkusername($uname) {
		$result = $this->Dashboard_model->uselogindata($uname);
		if($result == FALSE) {
			$this->form_validation->set_message('checkusername', 'Invalid {field}');
			return false;
		}
		else {
			return true;
		}
	}

	public function logout() {
		// Removing session data
		$sess_array = array(
			'username' => '',
			'userid' => ''
		);
		$this->session->unset_userdata('logged_in', $sess_array);
		$data['message_display'] = 'Successfully Logout';
		$this->load->view('login', $data);
	}
}
?>