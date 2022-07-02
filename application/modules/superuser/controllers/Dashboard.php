<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {
	public function __construct(){
    	parent::__construct();
    	$this->load->helper('url');
    	$this->load->helper('security');
        $this->load->helper('income');
        $this->load->helper('sms');
    	$this->load->model('Dashboard_model');
        if (!isset($this->session->userdata['adminLoggedIn'])) {
            $redirection = base_url('index.php/superuser/login');
            header("location: $redirection");
        }
        DailyIncome();
        $adminLoggedIn = $this->session->userdata('adminLoggedIn');
        $userid=$adminLoggedIn['userid'];
        $this->sessionAdminUserid=$userid;
    }

	public function index(){
        $userid=$this->sessionAdminUserid;
        $topwidgetresult = $this->Dashboard_model->dashboardTopWidget($userid);
        if(count($topwidgetresult) > 0) {
            $response['topwidget'] = $topwidgetresult[0];
        }
        else {
            $response['topwidget'] = $topwidgetresult;
        }
        
        
        $this->load->view('Dashboard', $response);
    }
    public function logout() {
        // Removing session data
        $sess_array = array(
            'username' => '',
            'userid' => ''
        );
        $this->session->unset_userdata('adminLoggedIn', $sess_array);
        $data['message_display'] = 'Successfully Logout';
        $this->load->view('login', $data);
    }
    public function sessionentry() {
        $d1='2021-04-29 00:00:00';
        $d='2021-04-29 23:59:59';
        $i=0;
        while($i<3000)
        {
            DirectQuery("insert into mlm_session (`datefrom`,`dateto`) VALUES ('$d1','$d')");
            $d1=date('Y-m-d H:i:s',strtotime($d1 . ' + 1 day'));
            $d=date('Y-m-d H:i:s',strtotime($d . ' + 1 day'));
            $i++;
        }
    }
    public function Income() {
        //DailyIncome();
    }
    public function Emailcheck() {
        Registermail('NFC336678','123','kamal.kd78@gmail.com');

    }
}
?>