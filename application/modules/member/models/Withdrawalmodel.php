<?php

Class Withdrawalmodel extends CI_Model {

	public function WithdrawalValidation($userId,$flag=0){
		$msg='';
		$response=array();
		$data=array();
		$charges=array();
		$charges=Charges();
		$data['extraColumn']=",A.adharstatus";
		$getMemberInfo=FetchMemberInfo($userId,$data);
		
		if($getMemberInfo['data'][0]['adharstatus'] == '1'){
			$response['valid']=true;
		}
		else{
			$response['valid']=false;
		}
		$response['BankInfo']=$getMemberInfo;
		$response['AdminCharge']=$charges['AdminCharge'];
		$response['msg']=$msg;
		return $response;
	}

	public function Insert($data){

		$response=array();
		$response['status']=false;
		$userId=$data['userId'];
		$amount=$data['amount'];
		$paymentMode=$data['paymentMode'];
		$address=$data['address'];
		$dollar=$data['dollar'];
		$sellprice=$data['sellprice'];
		$AdminCharge=$data['AdminCharge'];
		$netamount=$data['netamount'];

		$withdrwalData=array();
		$withdrwalData['entrydate']=CurrentDate();
		$withdrwalData['userid']=$userId;
		$withdrwalData['amount']=$amount;
		$withdrwalData['sellprice']=$sellprice;
		$withdrwalData['dollar']=$dollar;
		$withdrwalData['admincharge']=$AdminCharge;
		$withdrwalData['netamount']=$netamount;
		$withdrwalData['pmode']=$paymentMode;
		$withdrwalData['address']=$address;
		$withdrwalData['status']='0';
		$WithdrawalId=InsertData('mlm_withdrawalreq',$withdrwalData);

		if($WithdrawalId > 0){
			$transType="Withdrawal Request";
			$walletType="Income Wallet";
			$transactionData=array();
			$transactionData['entrydate']=CurrentDate();
			$transactionData['userid']=$userId;
			$transactionData['fromid']=0;
			$transactionData['status']='paid';
			$transactionData['refid']=$WithdrawalId;
			$transactionData['remark']=$transType;
			$transactionData['transtype']=$transType;
			$transactionData['wallettype']=$walletType;
			$transactionData['netamount']=-$netamount;
			$TransId=InsertData('mlm_transaction',$transactionData);
			if($TransId > 0){
				$transactionData=array();
				$transactionData['entrydate']=CurrentDate();
				$transactionData['userid']=$userId;
				$transactionData['fromid']=0;
				$transactionData['status']='paid';
				$transactionData['refid']=$WithdrawalId;
				$transactionData['remark']=$transType." Admin Charge";
				$transactionData['transtype']=$transType;
				$transactionData['wallettype']=$walletType;
				$transactionData['netamount']=-$AdminCharge;
				InsertData('mlm_transaction',$transactionData);
				$response['status']=true;
			}
		}
		return $response;
	}

	public function Report($data){
		$userId=$data['userId'];
		$MainTable="mlm_withdrawalreq";
		$Condition="userid='$userId'";
		$casePayment="CASE
	    WHEN status='0' THEN 'Pending'
	    WHEN status='1' THEN 'Accepted'
	    ELSE 'Rejected'
	    END as 'Status'";
		$SelectColumn=$casePayment.",entrydate as 'Entrydate___convertdate',amount as 'Amount ($)',admincharge as 'Admin Charge($)',netamount as 'Amount($)',CASE
	    WHEN pmode='0' THEN 'Cre8r' WHEN pmode='1' THEN 'Cre8r' ELSE 'Cre8r' END as 'Payment Mode',address";
		$withdrwalRequest=CreateSingleQuery($MainTable,$Condition,$SelectColumn,'entrydate desc');
		$withdrwalRequest=json_decode($withdrwalRequest,true);
		return $withdrwalRequest;

	}
}

?>