<?php
Class WebModel extends CI_Model {
  public function ContactSubmit($data){
    $response=array();
    $response['status'] = false;
    $mlm_contactus=array();
    $mlm_contactus['entrydate'] = CurrentDate();
    $mlm_contactus['name'] = $data['name'];
    $mlm_contactus['mobile'] = $data['mobile'];
    $mlm_contactus['msg'] = $data['msg'];
    $mlm_contactus['subject'] =$data['subject'];

    $mlm_contactusId=InsertData('mlm_contactus',$mlm_contactus);
    if($mlm_contactusId > 0){
      $response['status'] = true;
    }
    return $response;
  }
}
?>