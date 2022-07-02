<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');	
	
	function WalletProcess($data){
		
		$memberId=$data['userid'];
		$type=$data['type'];
		$reqtype=$data['reqtype'];
		$amount=$data['amount'];
		$status=$data['status'];
	
		$remarks='';
		if(isset($data['remarks']))
			$remarks=$data['remarks'];
	
		$image='';
		if(isset($data['image']))
			$image=$data['image'];
	
		$paymentMode=NULL;
		if(isset($data['paymentMode']))
			$paymentMode=$data['paymentMode'];
		
		$transactionId='';
		if(isset($data['transactionId']))
			$transactionId=$data['transactionId'];
		
		$statusdate=NULL;
		$statusby=0;
		
		if($type == "Credit"){
			$saveType='0';
			$updateAmount=$amount;
		}
		else{
			$saveType='1';	
			$updateAmount=-$amount;
		}
		
		if(isset($data['statusdate']))
			$statusdate=$data['statusdate'];
		
		if(isset($data['statusby']))
			$statusby=$data['statusby'];

		$response=array();
		$response['status']=false;
	
		$saveWalletData=array();
		$saveWalletData['entrydate']	=	Currentdate();
		$saveWalletData['userid']		=	$memberId;
		$saveWalletData['type']			=	$saveType;
		$saveWalletData['reqtype']		=	$reqtype;
		$saveWalletData['amount']		=	$amount;
		$saveWalletData['status']		=	$status;
		$saveWalletData['statusdate']	=	$statusdate;
		$saveWalletData['statusby']		=	$statusby;
		$saveWalletData['remarks']		=	$remarks;
		$saveWalletData['paymentmode']	=	$paymentMode;
		$saveWalletData['transactionId']=	$transactionId;
		$saveWalletData['proof']		=	$image;

		$walletorderId=InsertData('mlm_walletorder',$saveWalletData);

		if($walletorderId > 0){
			$response['status']=true;
			$response['walletorderId']=$walletorderId;
		}
		return $response;
	}

	function WalletTransactionEntry($data){
		$response=array();
		$response['status']=false;
		$wallettype="Capital Wallet";
		$remarks=$data['remarks'];
		if($data['type'] == "Credit")
		{
			$updateAmount=$data['amount'];
			$transtype="Capital Wallet";
			if($remarks=='')
			{
				$remarks='Admin Added Wallet';
			}
			//$remarks='Request Accepted';
		}
		else
		{
			$transtype="Deduct To Wallet";
			$updateAmount=-$data['amount'];
			if($remarks=='')
			{
				$remarks='Admin Deduct Wallet';
			}
		}
		$transaction['entrydate']	=	Currentdate();
		$transaction['userid']		=	$data['userid'];
		$transaction['status']		=	'paid';
		$transaction['refid']		=	$data['walletorderId'];
		$transaction['remark']		=	$remarks;
		$transaction['transtype']	=	$transtype;
		$transaction['wallettype']	=	$wallettype;
		$transaction['netamount']	=	$updateAmount;
		$transactionId=InsertData('mlm_transaction',$transaction);
		if($transactionId > 0){
				$response['status']=true;
		}
		return $response;
	}
	
	function WalletReport($data){
		$ci =& get_instance();
		$image_url=$ci->config->item('image_url');
      	$image_url=$image_url."FundRequest/";
		$MainTable="mlm_walletorder";
		$JoinTable=array();
		$JoinTable[0]="mlm_userlogin";
		$JoinTable[1]="mlm_userdetail";

		$JoinOn=array();
		$JoinOn[0]="mlm_walletorder.userid=mlm_userlogin.id";
		$JoinOn[1]="mlm_userlogin.id=mlm_userdetail.userid";

		$Condition="1=1";
		if(isset($data['status'])){
			$status=$data['status']; 
			$Condition=$Condition." and mlm_walletorder.status='$status'";
		}
		$link='';
		if(isset($data['adminFlag'])){
			if($data['adminFlag']==true)
				$link="concat('Wallet/FundRequestAction/1/',mlm_walletorder.id) as Accept___link___acceptbtn,concat('Wallet/FundRequestAction/2/',mlm_walletorder.id) as Reject___link___rejectbtn,";
		}

		
		$memberColoumn="concat(mlm_userlogin.username,'<br>',mlm_userdetail.fullname) as 'Member Info'";
		$proofColoumn="if(mlm_walletorder.proof!='',concat('$image_url','',mlm_walletorder.proof),'') as 'Proof___imagedisplay',";
		$statusCase="case 
		when mlm_walletorder.status='0' then 'Pending' 
		when mlm_walletorder.status='1' then 'Accepted' 
		else 'Rejected' end as 'Status'";

		$pmodeCase=",case 
		when mlm_walletorder.paymentmode='0' then 'Cre8r' 
		when mlm_walletorder.paymentmode='1' then 'Cre8r' 
		else 'Admin' end as 'Payment Mode'";
		if(isset($data['userid'])){
			$userid=$data['userid']; 
			$Condition=$Condition." and mlm_walletorder.userid='$userid'";
			$memberColoumn='';
			
		}
		
		$SelectColumn=$link.$proofColoumn."mlm_walletorder.entrydate as 'Date___convertdatetime',".$memberColoumn.",concat(mlm_walletorder.amount,' $') as 'Amount',if(mlm_walletorder.type='0','Credit','Debit') as Type,".$statusCase.$pmodeCase.",mlm_walletorder.statusdate as 'StatusDate___convertdate',mlm_walletorder.remarks,mlm_walletorder.transactionId as 'Transaction Id'";
		//$SelectColumn=$link.$proofColoumn."mlm_walletorder.entrydate as 'Date___convertdatetime',".$memberColoumn.",concat(mlm_walletorder.amount,' $') as 'Amount',".$statusCase.$pmodeCase.",mlm_walletorder.transactionId as 'Transaction Id',mlm_walletorder.statusdate as 'StatusDate___convertdate'";

		$WalletList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,array(),'mlm_walletorder.entrydate desc'); 
		$WalletList=json_decode($WalletList,true);  
		return  $WalletList;
	}

	function WalletTransferReport($data){

		$MainTable="mlm_walletmaster as A";
		$JoinTable=array();
		$JoinTable[0]="mlm_userlogin as B";
		$JoinTable[1]="mlm_userdetail as C";
		$JoinTable[2]="mlm_userlogin as D";
		$JoinTable[3]="mlm_userdetail as E";

		$JoinOn=array();
		$JoinOn[0]="A.fromid=B.id";
		$JoinOn[1]="B.id=C.userid";

		$JoinOn[2]="A.userid=D.id";
		$JoinOn[3]="D.id=E.userid";
		

		$Condition="1=1";
		$memberColoumn="concat(B.username,'<br>',C.fullname) as 'Member Info',concat(D.username,'<br>',E.fullname) as 'From Info'";
		$statusCase="case when A.status='0' then 'Pending' when A.status='1' then 'Accept' else 'Reject' end as 'Status'";

		$SelectColumn="A.entrydate as 'Date___convertdate',".$memberColoumn.",A.amount as 'Capital Wallet'";

		$WalletList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,array(),'A.entrydate desc'); 
		$WalletList=json_decode($WalletList,true); 
		return  $WalletList;

	}
	
	function WalletDeduct($data){

		$userid=$data['userid'];
		$amount=$data['amount'];
		$remarks=$data['remarks'];
		$transtype=$data['transtype'];
		$wallettype=$data['wallettype'];

		$InsertData=array();
		$InsertData['entrydate']=Currentdate();
		$InsertData['userid']=$userid;
		$InsertData['status']='paid';
		$InsertData['refid']=0;
		$InsertData['remark']=$remarks;
		$InsertData['transtype']=$transtype;
		$InsertData['wallettype']=$wallettype;
		$InsertData['netamount']=-$amount;
		$res=InsertData('mlm_transaction',$InsertData);
		return $res;

	}

	function WalletAdd($data){

		$userid=$data['userid'];
		$amount=$data['amount'];
		$remarks=$data['remarks'];
		$transtype=$data['transtype'];
		$wallettype=$data['wallettype'];
		$refid=$data['refid'];

		$InsertData=array();
		$InsertData['entrydate']=Currentdate();
		$InsertData['userid']=$userid;
		$InsertData['status']='paid';
		$InsertData['refid']=$refid;
		$InsertData['remark']=$remarks;
		$InsertData['transtype']=$transtype;
		$InsertData['wallettype']=$wallettype;
		$InsertData['netamount']=$amount;
		$res=InsertData('mlm_transaction',$InsertData);
		return $res;

	}
	
	function UserWalletBalance($data){
		$userId=$data['userId'];
		$walletType="Income Wallet";
		if(isset($data['walletType'])){
			$walletType=$data['walletType'];
		}

		$MainTable="mlm_transaction";
		$Condition="userid = '$userId' and wallettype='$walletType'";
		$SelectColumn="ifnull(round(sum(netamount),2),0) as Balance";
		$getBalance=CreateSingleQuery($MainTable,$Condition,$SelectColumn);
		$getBalance=json_decode($getBalance,true);  
		return  $getBalance;
	}

	function GetWalletData($id){	
		$tablename="mlm_walletorder";
		$condition="id='$id'and (status='0' || status='3')";
		$checkValidation=CreateSingleQuery($tablename,$condition);
		$checkValidation=json_decode($checkValidation,true);
		return $checkValidation;
	}

	function WalletRequestSubmit($id,$status,$adminid){	
		$response=array();
		$response['status']=false;
		$updateData=array();
		$updateData['status'] = $status;
		$updateData['statusby'] = $adminid;
		$updateData['statusdate'] =Currentdate();
		$Condition=array();
		$Condition['id']=$id;
		$responseNews=UpdateData('mlm_walletorder',$updateData,$Condition);
		if($responseNews > 0){
			$response['status']=true;
		}
		return $response;
	}
?>