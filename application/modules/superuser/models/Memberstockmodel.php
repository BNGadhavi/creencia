<?php
Class Memberstockmodel extends CI_Model {

  public function MemberInfoForStock($data){

      $id=$data['id'];
      $franchiseeInfo=PassIdTable('mlm_invoicemaster',$id);
      $userId=$franchiseeInfo['data'][0]['orderby'];      
      $MainTable="mlm_userlogin";
      $JoinTable=array();
      $JoinTable[0]="mlm_userdetail";
      $JoinOn=array();
      $JoinOn[0]="mlm_userlogin.id=mlm_userdetail.userid";
      $Condition="mlm_userlogin.id='$userId'";
      $SelectColumn="mlm_userlogin.username as Username, mlm_userdetail.fullname as Fullname,mlm_userdetail.mobile,mlm_userdetail.email";
      $UserData=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn); 
      $UserData=json_decode($UserData,true);
      $response=array();
      $response['UserData']=$UserData;
      return $response;
  }

  public function MemberRequestDetail($data){
    $id=$data['id'];

    $MainTable="mlm_productmaster as A";
    $JoinTable=array();
    $JoinTable[0]="mlm_invoicedetail as B";
    $JoinTable[1]="mlm_gstmaster as C";
     $JoinTable[2]="mlm_invoicemaster as D";
  
    $JoinOn=array();
    $JoinOn[0]="A.id=B.productid";
    $JoinOn[1]="C.id=A.hsnid";
    $JoinOn[2]="D.id=B.orderid";
    

    $JoinType=array();
    $JoinType[1]="left";
    $QueryString='';
    
    $Condition="B.orderid='$id'";
    if(isset($data['invoicepaymentid'])){
      $invoicepaymentid=$data['invoicepaymentid'];
      $Condition="B.invoicepaymentid='$invoicepaymentid'";
    }
    $SelectColumn="A.productname as 'ProductName',C.hsncode,B.qty as 'Qty',A.dp as 'MRP',if(D.interstate='0',B.cgst,'0') as 'CGST',if(D.interstate='0',B.sgst,'0') as 'SGST',if(D.interstate='1',B.igst,'0') as 'IGST',B.totaldp as 'Total MRP',B.cgstper as 'cgstper',B.igstper as 'igstper',B.sgstper as 'sgstper'";

    $List=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,$JoinType,'A.entrydate desc'); 
    $List=json_decode($List,true);  
    return  $List;

  }

  public function Purchasedetail($data){
    $id=$data['id'];

    $MainTable="mlm_invoicemaster as A";
    $Condition="A.id='$id'";
    $SelectColumn="A.id,A.invoiceserial as 'invoiceno',A.entrydate,A.status";

    $List=CreateSingleQuery($MainTable,$Condition,$SelectColumn); 
    $List=json_decode($List,true);  
    return  $List;

  }

  public function Paymentdetail($data){

   /* $image_url=$this->config->item('image_url');
    $image_url=$image_url."StockRequest/";*/

    $id=$data['id'];

    $MainTable="mlm_invoicemaster as A";
    $Condition="A.id='$id'";
    $SelectColumn="A.entrydate,A.bv";

    $casePayment="CASE
      WHEN A.paymentmode='0' THEN 'Cash'
      WHEN A.paymentmode='1' THEN 'DD/Cheque'
      WHEN A.paymentmode='4' THEN 'Wallet'
      WHEN A.paymentmode='7' THEN 'Online Payment'
      ELSE 'Neft/RTGS'
      END as 'Payment Mode',";

    //$imageLink="concat('$image_url','',A.proof) as 'Proof___imagedisplay',";

    $SelectColumn=$casePayment;

    $List=CreateSingleQuery($MainTable,$Condition,$SelectColumn); 
    $List=json_decode($List,true);  
    return  $List;

  }

  public function MemberShippingDetail($data){

      $id=$data['id'];
      $userInfo=PassIdTable('mlm_invoicemaster',$id);
      $userId=$userInfo['data'][0]['orderby'];      
      $MainTable="mlm_userlogin as UL";
      
      $JoinTable=array();
      $JoinTable[0]="mlm_userdetail as UD";
      $JoinTable[1]="mlm_invoicemaster as IM";
      $JoinTable[2]="mlm_states as ST";
      $JoinTable[3]="mlm_cities as CT";
     
      
      $JoinOn=array();
      $JoinOn[0]="UL.id=UD.userid";
      $JoinOn[1]="IM.orderby=UL.id";
      $JoinOn[2]="IM.state=ST.id";
      $JoinOn[3]="IM.city=CT.id";
      
      
      $JoinType=array();
      $JoinType[2]="left";
      $JoinType[3]="left";

      $Condition="UL.id='$userId' and IM.id='$id' and IM.ordertype='MP'";
      $SelectColumn="UL.username as Username, UD.fullname as Fullname,IM.address,ST.name as 'statename',CT.name as 'cityname',IM.couriername as 'Courier Name',IM.docketno,IM.remark,IM.pincode,IM.mobile,IM.deliveryremarks";
      $UserData=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,$JoinType); 
      $UserData=json_decode($UserData,true);
      return $UserData;
  }

  public function Report($data=array()){

      $image_url=$this->config->item('image_url');
      $image_url=$image_url."StockRequest/";
      $status=$data['status'];
      $MainTable="mlm_invoicemaster as A";
      $JoinTable=array();
      $JoinTable[0]="mlm_userlogin as B";
      $JoinTable[1]="mlm_userdetail as C";
    
      $JoinOn=array();
      $JoinOn[0]="A.orderby=B.id";
      $JoinOn[1]="B.id=C.userid";
      
      $QueryString='';
      $Condition="A.status='$status' and A.ordertype='MP' and A.activepurchase='0'";
      if($status!=7 && $status!=8 && $status!=9 ){
        //$Condition=$Condition." and A.req='yes'";
      }
      if(isset($data['dateStart'])){
        $dateStart=$data['dateStart'];
        $QueryString = "/".strtotime($dateStart);
        $dateStart = date("Y-m-d", strtotime($dateStart));
        $Condition=$Condition." and date(A.entrydate) >= date('$dateStart')";
      }

      if(isset($data['dateEnd'])){
        $dateEnd=$data['dateEnd'];
        $QueryString =$QueryString. "/".strtotime($dateEnd);
        $dateEnd = date("Y-m-d", strtotime($dateEnd));
        $Condition=$Condition." and date(A.entrydate) <= date('$dateEnd')";
      }

      $dateLink="concat('Memberstock/MemberRequestDetail/',A.id)";
      if($QueryString!=''){
        $dateLink="concat('Memberstock/MemberRequestDetail/',A.id,'$QueryString')";    
      }
      

      $casePayment="CASE
      WHEN A.paymentmode='0' THEN 'Cash'
      WHEN A.paymentmode='1' THEN 'DD/Cheque'
      WHEN A.paymentmode='4' THEN 'Wallet'
      WHEN A.paymentmode='7' THEN 'Online Payment'
      ELSE 'Neft/RTGS'
      END as 'Payment Mode',";

      $link=$dateLink." as Detail___link,";

      if($status=='1' || $status=='0' || $status=='4'){
       $link.="concat('Memberstock/Invoice/',A.id) as Invoice___link___targetblank,concat('Memberstock/CourierInvoice/',A.id) as 'Courier Invoice___link___targetblank',";     
      }
      

      $SelectColumn=$link."A.entrydate as 'Order Date___convertdate',B.username as 'Member Id',C.fname as 'Member Name',A.invoiceserial as 'invoiceno',A.qty as 'Qty',A.netamount as 'Net Amount',A.deliverycharge as 'Shipping Charge',A.pincode as 'Postal Code',A.address as 'Address',".$casePayment;
     
      $List=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,array(),'A.entrydate desc'); 
      $List=json_decode($List,true);  
     // echo $this->db->last_query();
      return  $List;
  }

  public function ActinvoiceReport($data=array()){

      $image_url=$this->config->item('image_url');
      $image_url=$image_url."StockRequest/";
      $status=$data['status'];
      $MainTable="mlm_invoicemaster as A";
      $JoinTable=array();
      $JoinTable[0]="mlm_userlogin as B";
      $JoinTable[1]="mlm_userdetail as C";
    
      $JoinOn=array();
      $JoinOn[0]="A.orderby=B.id";
      $JoinOn[1]="B.id=C.userid";
      
      $QueryString='';
      $Condition="A.status='$status' and A.ordertype='MP' and A.activepurchase='1'";
      if($status!=7 && $status!=8 && $status!=9 ){
        //$Condition=$Condition." and A.req='yes'";
      }
      if(isset($data['dateStart'])){
        $dateStart=$data['dateStart'];
        $QueryString = "/".strtotime($dateStart);
        $dateStart = date("Y-m-d", strtotime($dateStart));
        $Condition=$Condition." and date(A.entrydate) >= date('$dateStart')";
      }

      if(isset($data['dateEnd'])){
        $dateEnd=$data['dateEnd'];
        $QueryString =$QueryString. "/".strtotime($dateEnd);
        $dateEnd = date("Y-m-d", strtotime($dateEnd));
        $Condition=$Condition." and date(A.entrydate) <= date('$dateEnd')";
      }

      $dateLink="concat('Memberstock/MemberRequestDetail/',A.id)";
      if($QueryString!=''){
        $dateLink="concat('Memberstock/MemberRequestDetail/',A.id,'$QueryString')";    
      }
      

      $casePayment="CASE
      WHEN A.paymentmode='0' THEN 'Cash'
      WHEN A.paymentmode='1' THEN 'DD/Cheque'
      WHEN A.paymentmode='4' THEN 'Wallet'
      WHEN A.paymentmode='7' THEN 'Online Payment'
      ELSE 'Neft/RTGS'
      END as 'Payment Mode',";

      $link=$dateLink." as Detail___link,";

      if($status=='1' || $status=='0' || $status=='4'){
       $link.="concat('Memberstock/Invoice/',A.id) as Invoice___link___targetblank,concat('Memberstock/CourierInvoice/',A.id) as 'Courier Invoice___link___targetblank',";     
      }
      

      $SelectColumn=$link."A.entrydate as 'Order Date___convertdate',B.username as 'User Id',C.fname as 'Member Name',A.invoiceserial as 'invoiceno',A.qty as 'Qty',A.netamount as 'Net Amount',A.pincode as 'Postal Code',A.address as 'Address'";
     
      $List=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,array(),'A.entrydate desc'); 
      $List=json_decode($List,true);  
     // echo $this->db->last_query();
      return  $List;
  }


  public function PendingInvoiceList($data=array()){

      $image_url=$this->config->item('image_url');
      $image_url=$image_url."StockRequest/";

      $status=$data['status'];
      $adminstatus=$data['adminstatus'];

      $MainTable="mlm_invoicemasterpayment as A";
      $JoinTable=array();
      $JoinTable[0]="mlm_userlogin as B";
      $JoinTable[1]="mlm_userdetail as C";
      $JoinTable[2]="mlm_invoicedetail as D";
    
      $JoinOn=array();
      $JoinOn[0]="A.orderby=B.id";
      $JoinOn[1]="B.id=C.userid";
      $JoinOn[2]="A.id=D.invoicepaymentid";
      
      $QueryString='';
      $Condition="A.status='$status' and A.ordertype='MP' and A.transactionid='' and A.adminstatus='$adminstatus'";
      if($status!=7 && $status!=8 && $status!=9 ){
        $Condition=$Condition." and A.req='yes'";
      }
      if(isset($data['dateStart'])){
        $dateStart=$data['dateStart'];
        $QueryString = "/".strtotime($dateStart);
        $dateStart = date("Y-m-d", strtotime($dateStart));
        $Condition=$Condition." and date(A.entrydate) >= date('$dateStart')";
      }

      if(isset($data['dateEnd'])){
        $dateEnd=$data['dateEnd'];
        $QueryString =$QueryString. "/".strtotime($dateEnd);
        $dateEnd = date("Y-m-d", strtotime($dateEnd));
        $Condition=$Condition." and date(A.entrydate) <= date('$dateEnd')";
      }

      $dateLink="concat('Memberstock/PendingInvoiceDetail/',A.id)";
      if($QueryString!=''){
        $dateLink="concat('Memberstock/PendingInvoiceDetail/',A.id,'$QueryString')";    
      }


      $casePayment="CASE
      WHEN A.paymentmode='0' THEN 'Cash'
      WHEN A.paymentmode='1' THEN 'DD/Cheque'
      WHEN A.paymentmode='3' THEN 'Wallet'
      WHEN A.paymentmode='7' THEN 'Online Payment'
      ELSE 'Neft/RTGS'
      END as 'Payment Mode',";

      $link=$dateLink." as Detail___link,";

      if($status=='1' || $status=='0'){
       //$link.="concat('Memberstock/Invoice/',A.id) as Invoice___link___targetblank,";     
      }
      

      $SelectColumn=$link."A.entrydate as 'Order Date___convertdate',B.username as 'User Id',C.fname as 'Member Name',A.qty as 'Qty',A.netamount as 'Net Amount',A.pincode as 'Postal Code',A.address as 'Address',".$casePayment;
     
      $List=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,array(),'A.entrydate desc','D.invoicepaymentid'); 
      $List=json_decode($List,true);  
      return  $List;
  }


  public function AcceptRetrunRequest($data){
    $status=false;
    $id=$data['id'];
    $remarks=$data['remarks'];
    $adminid=$data['adminid'];

    $updateData=array();
    $updateData['status']='8';
    $updateData['returnacceptdate']=CurrentDate();

    $updateCondition=array();
    $updateCondition['id']=$id;
    $updateCondition['status']='7';

    $noofrecords=UpdateData('mlm_invoicemaster',$updateData,$updateCondition);
     $invoicemasterinfo=PassIdTable('mlm_invoicemaster',$id);

      if($noofrecords > 0){

        $paymentMode=$invoicemasterinfo['data'][0]['paymentmode'];
        $netamount=$invoicemasterinfo['data'][0]['netamount'];
        $mlm_transaction=array();
        if($paymentMode == '3'){
            $userid=$invoicemasterinfo['data'][0]['orderby'];
            $mlm_transaction['entrydate']=CurrentDate();
            $mlm_transaction['userid']=$userid;
            $mlm_transaction['fromid']=0;
            $mlm_transaction['status']='paid';
            $mlm_transaction['refid']=$id;
            $mlm_transaction['remark']='Order Return Accepted';
            $mlm_transaction['transtype']='Order Return Accepted';
            $mlm_transaction['wallettype']='Repurchase Wallet';
            $mlm_transaction['netamount']=$netamount;
            $transid=InsertData('mlm_transaction',$mlm_transaction);
        }


        $updateData=array();
        $updateData['status']='8';

        $updateCondition=array();
        $updateCondition['orderid']=$id;
        $updateCondition['status']='7'; 

        UpdateData('mlm_invoicedetail',$updateData,$updateCondition);

        $updateData=array();
        $updateData['status']='8';
        $updateData['updateby']=$adminid;
        $updateData['updatedate']=CurrentDate();
        $updateData['adminremarks']=$remarks;

        $updateCondition=array();
        $updateCondition['orderid']=$id;

        UpdateData('mlm_returnmaster',$updateData,$updateCondition);

        $MainTable="mlm_invoicedetail";
        $Condition="orderid='$id'";
        $getProductInfo=CreateSingleQuery($MainTable,$Condition,'productid as pid,qty');
        $getProductInfo=json_decode($getProductInfo,true);

        $OtherData=array();
        $adminremarks='Stock Return Request Accepted By Admin';
        $OtherData['remarks']=$adminremarks;
        $OtherData['refid']=$id;
        $stocktype="MR";
        $stockProcessPlus=stockProcess($getProductInfo['data'],$OtherData,$stocktype,0,$adminid,1);
        if($stockProcessPlus['status']){
          $status=true;
        }
      }
    $response=array();
    $response['status']=$status;

    return $response;
  }

  public function RejectRetrunRequest($data){
    $status=false;
    $id=$data['id'];
    $remarks=$data['remarks'];
    $adminid=$data['adminid'];

    $updateData=array();
    $updateData['status']='9';
    $updateData['returnrejectdate']=CurrentDate();

    $updateCondition=array();
    $updateCondition['id']=$id;
    $updateCondition['status']='7';

    $noofrecords=UpdateData('mlm_invoicemaster',$updateData,$updateCondition);


      if($noofrecords > 0){

        $updateData=array();
        $updateData['status']='9';

        $updateCondition=array();
        $updateCondition['orderid']=$id;
        $updateCondition['status']='7'; 

        UpdateData('mlm_invoicedetail',$updateData,$updateCondition);


        $updateData=array();
        $updateData['status']='9';
        $updateData['updateby']=$adminid;
        $updateData['updatedate']=CurrentDate();
        $updateData['adminremarks']=$remarks;

        $updateCondition=array();
        $updateCondition['orderid']=$id;

        UpdateData('mlm_returnmaster',$updateData,$updateCondition);
        $status=true;
        
      }
    $response=array();
    $response['status']=$status;

    return $response;
  }


}
?>