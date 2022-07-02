<?php

Class Supportmodel extends CI_Model {

	public function GetTicketName($data=array()){
    $MainTable="mlm_ticketissue";
    $Condition="1=1";
    $getTicketList=CreateSingleQuery($MainTable,$Condition); 
    $getTicketList=json_decode($getTicketList,true);
    return $getTicketList;
	}

	public function SaveTicket($data){

    if(isset($data['ticketId'])){
      $ticketId=$data['ticketId'];
      $Condition="ticketid = '$ticketId'";
      $getTickerInfo=CreateSingleQuery('mlm_support',$Condition); 
      $getTickerInfo=json_decode($getTickerInfo,true);
      $data['ticketIssue']=$getTickerInfo['data'][0]['issue'];
    }
    else{
      $ticketId=GenerateTicketId();  
    }
		

		    $mlmSupport=array();
        $mlmSupport['ticketid'] = $ticketId;
        $mlmSupport['userid'] = $data['userid'];
        $mlmSupport['source'] = $data['source'];
        $mlmSupport['date'] = CurrentDate();
        $mlmSupport['destination'] = 'admin';
        $mlmSupport['issue'] = $data['ticketIssue']; 
        $mlmSupport['msg'] = $data['message']; 
        $mlmSupport['pin'] = '0'; 
        $SupportId=InsertData('mlm_support',$mlmSupport);

        $response=array();
        $response['status'] =false;
        if($SupportId > 0){
        	$response['status'] =true;
        }
        return $response;	
	}

	public function TicketList($data){

		$userid=$data['userid'];
		$MainTable="mlm_support AS A";
	    $JoinTable=array();
	    $JoinTable[0]="mlm_ticketissue as D";

	    $JoinOn=array(); 
	    $JoinOn[0]="A.issue=D.id";

	    $status='0';
	    if(isset($data['status']))
	      $status=$data['status'];

	    $Condition="A.pin='$status' and A.userid='$userid'";

	    $SelectColumn="concat('Support/TicketDetail/',A.ticketid) as 'Detail___link',A.`date` as 'Sending Date___convertdate',A.ticketid,D.issue ,A.msg as 'Description'";
	    
	    
	    $orderBy="A.date desc";
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