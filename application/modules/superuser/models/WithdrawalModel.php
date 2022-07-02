<?php
Class WithdrawalModel extends CI_Model {

	public function Report($data){
		$status=$data['status'];

		$MainTable="mlm_withdrawalreq as A";
        $JoinTable=array();
        $JoinTable[0]="mlm_userlogin as B";
        $JoinTable[1]="mlm_userdetail as C";
        
        $JoinOn=array();
        $JoinOn[0]="A.userid=B.id";
        $JoinOn[1]="B.id=C.userid";

        $casePayment="CASE
	    WHEN A.status='0' THEN 'Pending'
	    WHEN A.status='1' THEN 'Accept'
	    ELSE 'Reject'
	    END as 'Status'";
        
        $link='';
        if($status == '0'){
        	$link="concat('Withdrawal/WithdrawalAction/1/',A.id) as Accept___link___acceptbtn,concat('Withdrawal/WithdrawalAction/2/',A.id) as Reject___link___rejectbtn,";	
        }
        
        $Condition="A.status='$status'";
        if(isset($data['dateStart'])){
	        $dateStart=$data['dateStart'];
	        $dateStart = date("Y-m-d", strtotime($dateStart));
	        $Condition=$Condition." and date(A.entrydate) >= date('$dateStart')";
      	}

      if(isset($data['dateEnd'])){
	        $dateEnd=$data['dateEnd'];
	        $dateEnd = date("Y-m-d", strtotime($dateEnd));
	        $Condition=$Condition." and date(A.entrydate) <= date('$dateEnd')";
      	}

      
        //$SelectColumn=$link."A.entrydate as 'Entrydate___convertdate',concat(B.username,'<br>',C.fullname) as 'Member id',A.amount as 'Amount',A.admincharge as 'AdminCharge',A.tds as 'TDS',A.netamount as 'Net Amount',".$casePayment.",A.bankname as 'Bank Name',A.banktype as 'Bank Type',A.bankifsc as 'Bank IFSC',A.bankaccno as 'Bank Account Number',A.bankbranch as 'Bank Branch',A.bankaccname as 'Bank Holder Name'";
        $SelectColumn=$link."A.entrydate as 'Entrydate___convertdate',concat(B.username,'<br>',C.fullname) as 'Member id',A.amount as 'Amount ($)',A.admincharge as 'AdminCharge ($)',A.netamount as 'Net Amount ($)',CASE
	    WHEN A.pmode='0' THEN 'Cre8r' WHEN A.pmode='1' THEN 'Cre8r' ELSE 'Cre8r' END as 'Payment Mode',A.address";

        $ReportList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,array(),'A.entrydate desc'); 
        $ReportList=json_decode($ReportList,true);  
        return  $ReportList;

	}

	public function WithdrawalUpdateStatus($data){
		$id=$data['id'];
		$status=$data['status'];
		$adminid=$data['adminid'];

		$checkStatus=PassIdTable('mlm_withdrawalreq',$id);
		if($checkStatus['data'][0]['status']!='0'){
			$response['status']=false;
			return $response;
		}
		$updateData=array();
		$updateData['status'] = $status;
		$updateData['statusdate'] =CurrentDate();
		$updateData['statusby'] = $adminid;

		$Condition=array();
		$Condition['id']=$id;
		$Condition['status']='0';
		$records=UpdateData('mlm_withdrawalreq',$updateData,$Condition);
		if($records > 0){
			$response['status']=true;	

			if($status == '2'){
				$transType="Withdrawal Request Rejected";
				$walletType="Income Wallet";
				$transactionData=array();
				$transactionData['entrydate']=CurrentDate();
				$transactionData['userid']=$checkStatus['data'][0]['userid'];
				$transactionData['fromid']=0;
				$transactionData['status']='paid';
				$transactionData['refid']=$id;
				$transactionData['remark']=$transType;
				$transactionData['transtype']=$transType;
				$transactionData['wallettype']=$walletType;
				$transactionData['netamount']=$checkStatus['data'][0]['netamount'];
				$TransId=InsertData('mlm_transaction',$transactionData);

				$transactionData=array();
				$transactionData['entrydate']=CurrentDate();
				$transactionData['userid']=$checkStatus['data'][0]['userid'];
				$transactionData['fromid']=0;
				$transactionData['status']='paid';
				$transactionData['refid']=$id;
				$transactionData['remark']=$transType." Admin Charge";
				$transactionData['transtype']=$transType;
				$transactionData['wallettype']=$walletType;
				$transactionData['netamount']=$checkStatus['data'][0]['admincharge'];
				$TransId=InsertData('mlm_transaction',$transactionData);
			}
			else{
				/*$chargesData=array();
				$chargesData['entrydate']=CurrentDate();
				$chargesData['userid']=$checkStatus['data'][0]['userid'];
				$chargesData['totalamount']=$checkStatus['data'][0]['amount'];
				$chargesData['tds']=$checkStatus['data'][0]['tds'];
				$chargesData['admincharge']=$checkStatus['data'][0]['admincharge'];
				$chargesData['refid']=$id;
				$chargesData['type']='0';
				$chargesData['orderby']='0';
				$ChargeId=InsertData('mlm_chargestransaction',$chargesData);*/
			}
		}
		return $response;
	}
}
?>