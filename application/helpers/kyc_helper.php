<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');	
        function KYCInfoForUser($userId,$data=array()){	
        $ci =& get_instance();        
        $image_url=$ci->config->item('image_url');
        $image_url=$image_url."KYCUpload/";

        $switchCase=",CASE
        WHEN A.kycid = '0' THEN 'Pan Card'
        WHEN A.kycid = '1' THEN 'Aadhar Card'
        ELSE 'Bank Detail'
        END as 'KYC Name'";
        $imageSelect=",concat('$image_url','',A.image) as 'Proof___imagedisplay',";      	
        $MainTable="mlm_memberdocument as A";
        $Condition="A.userid='$userId'";
        $SelectColumn="A.id,A.entrydate,A.userid".$switchCase.",A.kyctext".$imageSelect;
       
        if(isset($data['extraColumn'])){
                $SelectColumn=$SelectColumn.$data['extraColumn'];
        }
       
        if(isset($data['extraCondition'])){
                $Condition=$Condition.$data['extraCondition'];
        }
       
        if(isset($data['kycId'])){
                $kycId=$data['kycId'];
                $Condition=$Condition."and kycid='$kycId'";
        }

        $OrderBy='A.id desc';
        $GroupBy='';
        $LimitArray=array();
        $LimitArray['limit']=1;


        $KYCInfo=CreateSingleQuery($MainTable,$Condition,$SelectColumn,$OrderBy,$GroupBy,$LimitArray); 
        $KYCInfo=json_decode($KYCInfo,true);  
        return  $KYCInfo;

        }

 	function KYCSubmitProcess($data){

                $kycId=$data['kycId'];
                $kyctext=$data['kyctext'];
                $imageName=$data['image'];
                $status=$data['status'];
                $userId=$data['userId'];
                $fieldNameLogin=$data['fieldNameLogin'];
                

                $kycInsert=array();
                $kycInsert['entrydate']=CurrentDate();
                $kycInsert['userid']=$userId;
                $kycInsert['kycid']=$kycId;
                $kycInsert['kyctext']=$kyctext;
                $kycInsert['image']=$imageName;
                $kycInsert['status']=$status;
                $kycInsertId=InsertData('mlm_memberdocument',$kycInsert);
                $response=array();
                $response['status']=false;
                if($kycInsertId > 0){
                        $response['kycId']=$kycInsertId;
                        $response['status']=true;
                        $updateData=array();
                        $updateData[$fieldNameLogin] = $status;
                        $Condition=array();
                        $Condition['id']=$userId;
                        UpdateData('mlm_userlogin',$updateData,$Condition);

                        if(isset($data['fieldNameDetail']))
                        {
                                $fieldNameDetail=$data['fieldNameDetail'];        
                                $updateData=array();
                                $updateData[$fieldNameDetail] = $kyctext;
                                $Condition=array();
                                $Condition['userid']=$userId;
                                UpdateData('mlm_userdetail',$updateData,$Condition);                   
                        }
                        if($kycId == '2'){
                                $BankAccName=$data['BankAccName'];
                                $BankName=$data['BankName'];
                                $BankAccNo=$data['BankAccNo'];
                                $BankBranch=$data['BankBranch'];
                                $BankIfsc=$data['BankIfsc'];
                                $type=$data['type'];

                                $updateData=array();
                                $updateData['bankaccname'] = $BankAccName;
                                $updateData['bankname'] = $BankName;
                                $updateData['bankaccno'] = $BankAccNo;
                                $updateData['bankbranch'] = $BankBranch;
                                $updateData['bankifsc'] = $BankIfsc;
                                $updateData['banktype'] = $type;
                                $Condition=array();
                                $Condition['userid']=$userId;
                                UpdateData('mlm_userdetail',$updateData,$Condition);
                        }
                       
                }
                return $response;
               

        }
        function KYCListForAdmin($data){
        $ci =& get_instance();        
        $image_url=$ci->config->item('image_url');
        $image_url=$image_url."KYCUpload/";

        $status=$data['status'];
        $adminFlag=$data['adminFlag'];
        $MainTable="mlm_memberdocument";

        $JoinTable=array();
        $JoinTable[0]="mlm_userlogin";
        $JoinTable[1]="mlm_userdetail";
        
        
        $switchCase=",CASE
        WHEN mlm_memberdocument.kycid = '0' THEN 'Pan Card'
        WHEN mlm_memberdocument.kycid = '1' THEN 'National ID'
        ELSE 'Bank Detail'
        END as 'KYC Name',";
        $imageSelect=",concat('$image_url','',mlm_memberdocument.image,'###',mlm_memberdocument.id) as 'Proof___imagedisplay',concat(mlm_memberdocument.id,'###',CASE
        WHEN mlm_memberdocument.kycid = '0' THEN 'Pan Card'
        WHEN mlm_memberdocument.kycid = '1' THEN 'National ID'
        ELSE 'Bank Detail'
        END,'###',mlm_memberdocument.kyctext) as 'imgtext___imgtext',"; 

        $JoinOn=array();
        $JoinOn[0]="mlm_memberdocument.userid=mlm_userlogin.id";
        $JoinOn[1]="mlm_userdetail.userid=mlm_userlogin.id";
             
        $Condition="mlm_memberdocument.status='$status' and mlm_memberdocument.id in (select max(id) from mlm_memberdocument as A GROUP by A.kycid,A.userid)";
        $link='';
        if($status == '3' and $adminFlag == true){
                $link=",concat('KYCList/KYCAction/1/',mlm_memberdocument.id) as Accept___link,concat('KYCList/KYCAction/2/',mlm_memberdocument.id) as Reject___link,";
        }
        $accepteddate="";
        if($status == '1')
        {
                $accepteddate=" , mlm_memberdocument.statusdate as 'Accepted Date___convertdate' ";
        }
        $SelectColumn=$imageSelect.$link.",mlm_memberdocument.entrydate as 'Upload Date___convertdate'".$accepteddate.$switchCase."mlm_memberdocument.kyctext as 'KYC Info___split___@@@',concat(mlm_userlogin.username,'<br>',mlm_userdetail.fullname) as UserInfo";
        $kycList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,array(),'mlm_memberdocument.entrydate desc','mlm_memberdocument.kycid,mlm_memberdocument.userid'); 
        $kycList=json_decode($kycList,true);  
        return  $kycList;
        }

        function KYCUpdateProcess($data){
                $status=$data['status'];
                $kycUserId=$data['kycUserId'];

                $updateData=array();        
                $updateData['status'] = $status;
                $updateData['statusdate'] =CurrentDate();
                $Condition=array();
                $Condition['status']='3';
                $Condition['id']=$kycUserId;
                UpdateData('mlm_memberdocument',$updateData,$Condition);

                $kycInfo=PassIdTable('mlm_memberdocument',$kycUserId);
                $userId=$kycInfo['data'][0]['userid'];
                $kycType=$kycInfo['data'][0]['kycid'];
                if($kycType == '0'){
                        $fieldName="panstatus";
                        $fieldName1="panacceptid";
                }
                else if($kycType == '1'){
                        $fieldName='adharstatus';
                        $fieldName1="aadhaaracceptid";
                }
                else{
                        $fieldName='bankstatus';
                        $fieldName1="bankacceptid";       
                }

                $updateData=array();
                $updateData[$fieldName] = $status;
                $Condition=array();
                $Condition['id']=$userId;
                UpdateData('mlm_userlogin',$updateData,$Condition);

                $updateData=array();
                $updateData[$fieldName1] = $kycUserId;
                $Condition=array();
                $Condition['userid']=$userId;
                UpdateData('mlm_userdetail',$updateData,$Condition);
        }
        function CoindetailProcess($data){
                $ci =& get_instance();
                $usdt=$data['usdt'];
                $userId=$data['userId'];

                $updateData=array();
                $updateData['usdt'] = $usdt;
                $Condition=array();
                $Condition['userid']=$userId;
                UpdateData('mlm_userdetail',$updateData,$Condition); 
                $response=array();
                $response['status']=true;
                return $response;
        }
?>