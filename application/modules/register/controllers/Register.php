<?php
Class Register extends MX_Controller {
   public function __construct() {
      parent::__construct();
      $this->load->helper('main_helper');
      $this->load->helper('sms_helper');
      $this->load->helper('member_helper');
      $this->load->helper('income_helper');
      $this->load->model('Registermodel','RegisterModel');      
   }

	public function index() {
      $response=array();
      $tabelName="mlm_states";
      $condition = "country_id =101";
      
      $checkPinFlag=JoiningPinType();
      $response['pinFlag']=$checkPinFlag['pintype'];
      $sponsorId = '';
      $side = 0;
      if($this->uri->segment(3)) {
         $sponsorId = $this->uri->segment(3);   
      }
      if($this->uri->segment(4)) {
         $side = $this->uri->segment(4);   
      }
      
      $getData=CreateSingleQuery($tabelName,$condition);
      $getData=json_decode($getData,true);
      $response['statelist'] = $getData['data'];

      $tabelName="mlm_countries";
      $condition = "101=101";
      $getData=CreateSingleQuery($tabelName,$condition);
      $getData=json_decode($getData,true);
      $response['countrylist'] = $getData['data'];

      $response['sponsorId'] = $sponsorId;
      $response['side'] = $side;

      $this->load->view('Signup',$response);	
	}
   public function checkMemberid() {
      $memberid=$this->input->post('memberid');
      $data=array();
      $data['memberid']=$memberid;
      $validteSponsorid=RegisterSponosrid(1,$data);
      $response=array();
      $response['status']=$validteSponsorid['status'];
      if($response['status']){
         $response['membername']=$validteSponsorid['data'][0]['fullname'];   
      }
      print_r(json_encode($response));
   }

   public function checkUsername() {
      $username=$this->input->post('username');
      $data=array();
      $data['username']=$username;
      $validateUserid=ValidateUserId($data);

      $response=array();
      if($validateUserid['status']){
         $response['status']=true;
      }
      else{
       $response['status']=false;  
      }

      print_r(json_encode($response));
   }

   public function GetCity() {
      $state=$this->input->post('state');
      $data=array();
      $data['state']=$state;
      $getCityList=GetCityList($data);
      $response=array();
      $response['status']=$getCityList['status'];
      $response['city']=$getCityList['data'];      
      
      print_r(json_encode($response));
   }

   public function GetState() {
      $country=$this->input->post('country');
      $data=array();
      $data['country']=$country;
      $getCityList=GetStateList($data);
      $response=array();
      $response['status']=$getCityList['status'];
      $response['state']=$getCityList['data'];      
      
      print_r(json_encode($response));
   }

   public function registerSubmit() {
      $pinno=$this->input->post('pinno');
      $typeofjoining=$this->input->post('typeofjoining');
      $sponsorId=$this->input->post('sponsorId');
      $side=$this->input->post('side');
      $fullName=$this->input->post('fullName');
      $userName=$this->input->post('userName');
      $password=$this->input->post('password');
      $transactionPassword=$this->input->post('transactionPassword');
      $mobile=$this->input->post('mobile');
      $whatsApp=$this->input->post('whatsApp');
      $email=$this->input->post('email');
      $address=$this->input->post('address');
      $pannumber=$this->input->post('pannumber');
      $country=$this->input->post('country');
      $state=$this->input->post('state');
      $city=$this->input->post('city');
      $pincode=$this->input->post('pincode');
      $nomineeName=$this->input->post('nomineeName');
      $relNominee=$this->input->post('relNominee');
      $data=array();
      $data['pinno'] = $pinno;
      $data['sponsorId'] = $sponsorId;
      $data['side'] = $side;
      $data['fullName'] = $fullName;
      $data['userName'] = $userName;
      $data['password'] = $password;
      $data['transactionPassword']=$transactionPassword;
      $data['mobile'] = $mobile;
      $data['whatsApp'] = $whatsApp;
      $data['email'] = $email;
      $data['address'] = $address;
      $data['pannumber'] = $pannumber;
      $data['country'] = $country;
      $data['state'] = $state;
      $data['city'] = $city;
      $data['pincode'] = $pincode;
      $data['nomineeName'] = $nomineeName;
      $data['relNominee'] = $relNominee;
      $registermsg=RegisterProcess($data);
      if($registermsg['status']){
         if($typeofjoining=='1')
         {
            $memberid=$registermsg['username'];
            $userid=$registermsg['userid'];
            $fullName=$registermsg['fullName'];

            $session_data = array(
              'username' => $memberid,
              'userid' => $userid,
              'membername'=>$fullName,
            );
            $this->session->set_userdata('logged_in', $session_data);
         }
         else
         {
            $registermsg['encryptedUser']=base64_encode($registermsg['username']);   
         }
      }
      print_r(json_encode($registermsg));
   }

   public function joiningLetter() {
      $username=$this->uri->segment(3);
      $username=base64_decode($username);

      $registerData=array();
      $registerData['username'] = $username;
      $responseData=$this->RegisterModel->JoiningInfo($registerData);

      $Smsdata=array();
      $Smsdata['id']=20;
      $SmsResponse=$this->RegisterModel->SmsData($Smsdata);

      $response=array();
      $response['SmsData']=$SmsResponse['data'][0];   
      $response['MemberData']=$responseData['data'][0];
      $this->load->view('joiningLetter',$response);
   }

   public function ForgetPassword() {
      $response=array();
      $this->load->view('forgetPassword',$response);      
   }

   public function ForgetPasswordValidateUserId(){
      $memberid=$this->input->post('memberid');
      $getUserId=FindIdUsingMemberidHelper($memberid);
      if(!$getUserId){
         print_r(json_encode($response));
         exit();
      }
      
      $fetchMemberInfo=FetchMemberInfo($getUserId);
      $response=array();
      $response['status']=false;
      if($fetchMemberInfo['status']){
         $response['status']=true;
      }

      print_r(json_encode($response));
   }

   public function ForgetPasswordSubmit() {
      $memberid=$this->input->post('userId');
      $getUserId=FindIdUsingMemberidHelper($memberid);
      $response=array();
      $response['status']=false;
      $response['msg']='Some Error Occur';
      if(!$getUserId){
         $response['msg']='Username Is Invalid';
         print_r(json_encode($response));
         exit();
      }
   
      $data=array();
      $data['userId']=$getUserId;
      $responseForget=$this->RegisterModel->ForgetPasswordProcess($data);
      if($responseForget['status'])
      {
         $response['status']=true;
         $response['msg']='Password Sended Your Register E-mail Address';   
      }
      else
      {
         $response['status']=false;
         $response['msg']='Your E-mail id is Blank.Please Contact To Admin';     
      }
      print_r(json_encode($response));
   }
}
?>