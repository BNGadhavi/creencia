<?php
Class WalletModel extends CI_Model {
   public function WalletRequestProcess($data){
      $WalletRequest=array();
      $WalletRequest['entrydate'] =  CurrentDate();
      $WalletRequest['userid'] = $data['userId'];
      $WalletRequest['status'] ='0';
      if(isset($data['status'])){
          $WalletRequest['status'] =$data['status'];
      }
      $WalletRequest['type'] ='0';
      $WalletRequest['reqtype'] ='1';
      $WalletRequest['amount'] =$data['amount'];
      $WalletRequest['paymentmode'] =$data['paymentMode'];
      $WalletRequest['transactionId'] =$data['transactionId'];
      $WalletRequest['buyprice'] =$data['buyprice'];
      $WalletRequest['coinprice'] =$data['coinprice'];
      if(isset($data['image'])){
         $WalletRequest['proof'] =$data['image'];
      }
      if(isset($data['onlinepaymentamount'])){
         $WalletRequest['onlinepaymentamount'] =$data['onlinepaymentamount'];         
      }
      $WalletRequestId=InsertData('mlm_walletorder',$WalletRequest);
      $response['status']=false;
      if($WalletRequestId>0){
         $response['status']=true;
         $response['entryid']=$WalletRequestId;
      }
      return $response;
   }

   public function WalletRequestList($userId,$status){
      $image_url=$this->config->item('image_url');
      $image_url=$image_url."FundRequest/";

      $MainTable="mlm_walletorder";
      $JoinTable=array();
   
      $JoinOn=array();

      $MainCondition="userid='$userId' and status='$status'";

      $proof='';
      if($status!=4 and $status!=5 and $status!=6 and $status!=3){
         $proof="if(reqtype='1',concat('$image_url','',proof),'') as 'Proof___imagedisplay',";
      }
      $SelectColumn=$proof."entrydate as 'Request Date',concat(amount,' $') as 'Total Amount',if(type='0','Credit','Debit') as Type, ,case when paymentmode='0' then 'USDC' when  paymentmode='1' then 'USDC' when  paymentmode='2' then 'USDC'  else 'Admin Done This' end as 'Payment Mode',transactionId as 'Transaction No',remarks as 'Remarks'";
      $OrderBy="entrydate desc"; 
      $PinRequestReport=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$MainCondition,$SelectColumn,array(),$OrderBy);
      $PinRequestReport=json_decode($PinRequestReport,true);
      //print_r($PinRequestReport);
      return $PinRequestReport;    
     }

      public function Fundtransferprocess($data){
      
      $response=array();
      $response['status']=false;

      $userid=$data['userid'];
      $amount=$data['amount'];
      $remark=$data['remark'];
      $fromid=$data['fromid'];

      $PinTransferData=array();
      $PinTransferData['entrydate']=CurrentDate();
      $PinTransferData['userid'] =$fromid;
      $PinTransferData['fromid'] =$userid;
      $PinTransferData['amount'] =$amount;
      $PinTransferData['remark'] =$remark;
      $PinTransferData['status'] = '1'; 
      $PinTransferData['reqtype'] ='2';
      $PinTransferId=InsertData('mlm_walletmaster',$PinTransferData);
      if($PinTransferId>0)
      {
         $remark='Capital Wallet Received';
         $transaction['entrydate']  =  Currentdate();
         $transaction['userid']     =  $userid;
         $transaction['fromid']     =  $fromid;
         $transaction['status']     =  'paid';
         $transaction['refid']      =  $PinTransferId;
         $transaction['remark']     =  $remark;
         $transaction['transtype']  =  'Capital Wallet Received';
         $transaction['wallettype'] =  'Capital Wallet';
         $transaction['netamount']  =  $amount;
         $transactionId=InsertData('mlm_transaction',$transaction);

        
         $remark='Capital Wallet Transfer';

         $transaction['entrydate']  =  Currentdate();
         $transaction['userid']     =  $fromid;
         $transaction['fromid']     =  $userid;
         $transaction['status']     =  'paid';
         $transaction['refid']      =  $PinTransferId;
         $transaction['remark']     =  $remark;
         $transaction['transtype']  =  'Capital Wallet Transfer';
         $transaction['wallettype'] =  'Capital Wallet';
         $transaction['netamount']  =  -$amount;
         $transactionId=InsertData('mlm_transaction',$transaction);
         $response['status']=true;
      }
      return $response;
   }
   public function WalletTransferReport($userid,$data=array()){
      $MainTable="mlm_walletmaster as A";
      $JoinTable=array();
      $JoinTable[0]="mlm_userlogin as B";
      $JoinTable[1]="mlm_userdetail as C";
      $JoinOn=array();
      $JoinOn[0]="A.fromid=B.id";
      $JoinOn[1]="B.id=C.userid";
      $JoinType=array();
      $Condition="A.userid='$userid' and A.reqtype='2'";

      $statusCondition="case when A.status='0' then 'Pending' when A.status='1' then 'Success' else 'Rejected' end as 'Status'";

      $SelectColumn="A.entrydate as entrydate___convertdate,B.username as 'From ID',C.fullname as 'Member Name', A.amount as 'Capital Wallet',".$statusCondition;
      $PinList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,$JoinType,'A.entrydate desc'); 
      $PinList=json_decode($PinList,true);  
      return  $PinList;
   }
   
   public function WalletReceiveReport($userid,$data=array()){
      $MainTable="mlm_walletmaster as A";
      $JoinTable=array();
      $JoinTable[0]="mlm_userlogin as B";
      $JoinTable[1]="mlm_userdetail as C";
      $JoinOn=array();
      $JoinOn[0]="A.userid=B.id";
      $JoinOn[1]="B.id=C.userid";
      $JoinType=array();
      $Condition="A.fromid='$userid' and A.reqtype='2'";

      $statusCondition="case when A.status='0' then 'Pending' when A.status='1' then 'Success' else 'Rejected' end as 'Status'";

      $SelectColumn="A.entrydate as entrydate___convertdate,B.username as 'From ID',C.fullname as 'Member Name', A.amount as 'Capital Wallet',".$statusCondition;
      $PinList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,$JoinType,'A.entrydate desc'); 
      $PinList=json_decode($PinList,true);  
      return  $PinList;
   }
}

?>