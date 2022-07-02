<?php
Class Welcome extends MX_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('utility_helper');
		$this->load->model('WebModel');
		$newsData=array();
	    $achieverData=array();

        $newsResponce = ListOfNews($newsData);
        $this->newsResponce=$newsResponce;
        $achieverResponce = ListOfAchiver($achieverData);
        $this->achieverResponce=$achieverResponce;
	}
	public function Index() {
	    $response=array();
        $response['newsData'] =$this->newsResponce;
        $response['achieverData'] =$this->achieverResponce;
        //print_r($response);
	    $this->load->view('index',$response); 
  	}
  	public function About() {
	    $response=array();
	    $this->load->view('about',$response); 
  	}
  	public function Services() {
	    $response=array();
	    $this->load->view('sevices',$response); 
  	}
  	public function Contact() {
	    $response=array();
	    $this->load->view('contact',$response); 
  	}
  	public function ContactSubmit(){
	    $response['status']=false;
	   
		$data=array();
		$data['name'] = $this->input->post('name');
		$data['mobile'] = $this->input->post('mobile');
		$data['subject'] =  $this->input->post('subject');
		$data['msg'] = $this->input->post('msg');
		$ContactProcess=$this->WebModel->ContactSubmit($data);
		$response['status']=true;
		if(!$ContactProcess['status']){
			$response['status']=false;
			$response['msg']="Some Error Occur.";
		}
	    echo json_encode($response);
	}
}
?>