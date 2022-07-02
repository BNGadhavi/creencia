<?php
Class SupportModel extends CI_Model {
  public function checkTicket($data){

    $ticketName=$data['ticketName'];    
    $MainTable="mlm_ticketissue";
    $Condition="issue='$ticketName'";
    $checkTicketValidation=CreateSingleQuery($MainTable,$Condition); 
    $checkTicketValidation=json_decode($checkTicketValidation,true);
    return $checkTicketValidation;
  }

  public function SaveTicketName($data){

    $ticketName=$data['ticketName'];
    
    $mlmTicketIssue=array();
    $mlmTicketIssue['entrydate'] = CurrentDate();
    $mlmTicketIssue['issue'] = $ticketName;
    $mlmTicketId=InsertData('mlm_ticketissue',$mlmTicketIssue);

    $response=array();
    $response['status'] =false;
    if($mlmTicketId > 0){
      $response['status'] =true;
    }

    return $response;
  }

  public function TicketNameList($data=array()){
    $MainTable="mlm_ticketissue";
    $Condition="1=1";
    $SelectColoumn="concat('Support/DeleteTicket/',id) as 'Delete___link',entrydate as 'Entrydate___convertdate',issue as 'Name'";
    $TicketNameList=CreateSingleQuery($MainTable,$Condition,$SelectColoumn); 
    $TicketNameList=json_decode($TicketNameList,true);
    return $TicketNameList;

  }

  public function DeleteTicket($data){
    $id=$data['id'];
    $tablename="mlm_ticketissue";
    $Condition=array();
    $Condition['id'] = $id;
    $response=DeleteQuery($tablename,$Condition);
    return $response;
  }

  public function CurrentTicketList($data=array()){

    $MainTable="mlm_support AS A";
    $JoinTable=array();
    $JoinTable[0]="mlm_userlogin as B";
    $JoinTable[1]="mlm_userdetail as C";
    $JoinTable[2]="mlm_ticketissue as D";

    $JoinOn=array(); 
    $JoinOn[0]="A.userid=B.id";
    $JoinOn[1]="A.userid=C.userid";
    $JoinOn[2]="A.issue=D.id";

    $status='0';
    if(isset($data['status']))
      $status=$data['status'];

    $Condition="A.pin='$status'";

    $SelectColumn="concat('Support/TicketDetail/',A.ticketid) as 'Detail___link',A.`date` as 'Sending Date___convertdate',A.ticketid,concat(B.username,'<br>',C.fullname) as 'Member Info' ,D.issue ,A.msg as 'Description'";
    
    
    $orderBy="A.date";
    $groupBy="A.ticketid";
    $CurrentList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,array(),$orderBy,$groupBy); 
    $CurrentList=json_decode($CurrentList,true);
    return $CurrentList;
  }

  public function GetTicketInfo($data){
      $ticketId=$data['ticketId'];
      $MainTable="mlm_support AS A";
      $JoinTable=array();
      $JoinTable[0]="mlm_userlogin as B";
      $JoinTable[1]="mlm_userdetail as C";
      $JoinTable[2]="mlm_ticketissue as D";

      $JoinOn=array(); 
      $JoinOn[0]="A.userid=B.id";
      $JoinOn[1]="A.userid=C.userid";
      $JoinOn[2]="A.issue=D.id";

      $Condition="A.ticketid='$ticketId'";
      $SelectColumn="A.ticketid,B.username,C.fullname,D.issue ,A.msg as 'Description',A.pin";
      
      
      $orderBy="A.id desc";
      $CurrentTicket=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,array(),$orderBy); 
      $CurrentTicket=json_decode($CurrentTicket,true);

      $MainTable='mlm_support';
      $SelectColumn="date as date___convertdate,msg as 'Description'";
      $Condition="ticketid = '$ticketId'";

      $TicketInfo=CreateSingleQuery($MainTable,$Condition,$SelectColumn); 
      $TicketInfo=json_decode($TicketInfo,true);


      $response=array();
      $response['CurrentTicket'] = $CurrentTicket;
      $response['TicketInfo'] = $TicketInfo;

      return $response;

  }

  public function SaveTicketReply($data){

    $ticketid=$data['ticketId'];
    $newMessage=$data['newMessage'];

    $Condition="ticketid = '$ticketid'";
    $getTickerInfo=CreateSingleQuery('mlm_support',$Condition); 
    $getTickerInfo=json_decode($getTickerInfo,true);
    
    $mlmTicketIssue=array();
    $mlmTicketIssue['date'] = CurrentDate();
    $mlmTicketIssue['ticketid'] = $ticketid;
    $mlmTicketIssue['userid'] = $getTickerInfo['data'][0]['userid'];
    $mlmTicketIssue['source'] = 'admin';
    $mlmTicketIssue['destination'] = $getTickerInfo['data'][0]['userid'];
    $mlmTicketIssue['issue'] = $getTickerInfo['data'][0]['issue'];
    $mlmTicketIssue['msg'] = $newMessage;
    $mlmTicketIssue['pin'] = 0;
    $mlmTicketId=InsertData('mlm_support',$mlmTicketIssue);

    $response=array();
    $response['status']=false;
    if($mlmTicketId > 0){
      $response['status'] =true;
    }

    return $response;

  }

  public function UpdateTicketStatus($data){

    $ticketid=$data['ticketid'];

    $updateData=array();
    $updateData['pin'] = '1';
          
    $Condition=array();
    $Condition['ticketid']=$ticketid;
      
    UpdateData('mlm_support',$updateData,$Condition);
    $response=array();
    $response['status']=true;

    return $response;

  }

  
}
?>