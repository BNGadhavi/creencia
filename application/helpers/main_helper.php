<?php 

if (! defined('BASEPATH')) exit('No direct script access allowed');	
 	function RegisterSponosrid($flag,$data){
 		//$flag=0 return status
		//$flag=1 return data
		$memberid=$data['memberid'];
		$tablename="mlm_userlogin";
		
		$joinTable=array();
		$joinTable[0]='mlm_userdetail';

		$joinOn=array();
		$joinOn[0]="mlm_userlogin.id=mlm_userdetail.userid";

		$condition="mlm_userlogin.username='$memberid' and mlm_userlogin.lockmember='0' and mlm_userlogin.lockmember ='0' and mlm_userlogin.activestatus='1'";
		$selectColoumn="mlm_userlogin.id, mlm_userdetail.fullname, IF(mlm_userlogin.sleft=0,mlm_userlogin.id,mlm_userlogin.sleft) AS sleft, IF(mlm_userlogin.sright=0,mlm_userlogin.id,mlm_userlogin.sright) AS sright";

		$checkValidation=CreateJoinQuery($tablename,$joinTable,$joinOn,$condition,$selectColoumn);
		$checkValidation=json_decode($checkValidation,true);
		$response=array();
		if($flag == 1){
			return $checkValidation;
		}

		$response=array();
		$response['status']=false;
		if($checkValidation['status']){
			$response['status']=true;

		}
		return $response;
 	}
	function ValidateUserId($data){
		$username=$data['username'];
		$tablename="mlm_userlogin";
		$condition="username='$username'";
		$checkValidation=CreateSingleQuery($tablename,$condition);
		$checkValidation=json_decode($checkValidation,true);
		return $checkValidation;
	}

	function GetCityList($data){
		$state=$data['state'];
		$tablename="mlm_cities";
		$condition="state_id='$state'";
		$CityList=CreateSingleQuery($tablename,$condition);
		$CityList=json_decode($CityList,true);
		return $CityList;
	}
	function GetStateList($data){
		$country=$data['country'];
		$tablename="mlm_states";
		$condition="country_id='$country'";
		$CityList=CreateSingleQuery($tablename,$condition);
		$CityList=json_decode($CityList,true);
		return $CityList;
	}

	function RegisterProcess($data){
	  $ci =& get_instance();

	  $response=array();
	  $response['status']=false;
      $pinno=$data['pinno'];
      $sponsorId=$data['sponsorId'];
      $side=$data['side'] ;
      $fullName=$data['fullName'];
      $userName=$data['userName'];
      $password=$data['password'];
      $transactionPassword=$data['transactionPassword'];
      $mobile=$data['mobile'];
      $whatsApp=$data['whatsApp'];
      $email=$data['email'];
      $address=$data['address'];
      $pannumber=$data['pannumber'];

      $country=$data['country'];
      $state=$data['state'];
      $city=$data['city'];
      $pincode=$data['pincode'];
      $nomineeName=$data['nomineeName'];
      $relNominee=$data['relNominee'];
      $saveDate=CurrentDate();
      $activeDate=NULL;
      $activestatus='0';
      $checkPinFlag=JoiningPinType();

      $pinFlag=$checkPinFlag['pintype'];

      /*if($pannumber !=''){
	      	$panData=array();
	      	$panData['pancard']=$pannumber;
	      	$panValidate=RegisterPanValidate($panData);
	      	if(!$panValidate['status']){
	      		$response['msg']="Pan Number Is Already Used.";
		        return $response;
	      	}
      }*/
     
	  $activationDate="";
	  $packagecode=0;
	  $pinid=0;
	  $packageamount=0;
	  $packageTax=0;
	  $packageNetAmount=0;
	  $packagebv=0;
	  $packagepv=0;
	  $welcomebonus=0;
	  $nooflink=0;
	  $nooflinkdays=0;
	  $linkexpirydate=NULL;

      if($pinFlag == '1'){
      	  $pindata=array();
	      $pindata['pinno'] = $pinno;
	      $getPinData=RegisterPinValidate(1,$pindata);
	      
			if(!($getPinData['status'])){
				if(!$checkValidation['status']){
				    $response['msg']="Pin Number is invalid.";
				    return $response;
				}
			}

			$activeDate=$saveDate;
			$activestatus='1';

			$packagecode=$getPinData['data'][0]['packagecode'];
			$pinid=$getPinData['data'][0]['id'];
			$packageInfo=PassIdTable('mlm_packagesetting',$packagecode);
			$packageamount=$packageInfo['data'][0]['mrp'];
			$packagebv=$packageInfo['data'][0]['bv'];
			$packagepv=$packageInfo['data'][0]['pv'];
			$packageTax=$packageInfo['data'][0]['tax'];
			$packageNetAmount=$packageInfo['data'][0]['netmrp'];	
			$welcomebonus=$packageInfo['data'][0]['welcomebonus'];

			$nooflink=$packageInfo['data'][0]['nooflink'];
			$nooflinkdays=$packageInfo['data'][0]['nooflinkdays'];
			if($nooflink > 0){
				$addingdate=date_create($saveDate);
				date_add($addingdate,date_interval_create_from_date_string("$nooflinkdays days"));
				$linkexpirydate=date_format($addingdate,"Y-m-d H:i:s");	
			}

      }
      
		$sponsorData=array();
		$sponsorData['memberid'] = $sponsorId;
		$validateSponsorId=RegisterSponosrid(1,$sponsorData);
		if(!($validateSponsorId['status'])){
				$response['msg']="Sponsorid is invalid.";
		    	return $response;
		}
		
		$sponsorField='';
		if($side == "Left"){
			$side='0';
		}
		else{
			$side='2';
		}
		if($side=='0'){
			$findplacement=	$validateSponsorId['data'][0]['sleft'];
			$fieldName="sleft";
			$sponsorField='leftsponsor';
		}
		else{
			$findplacement=	$validateSponsorId['data'][0]['sright'];
			$fieldName="sright";
			$sponsorField='rightsponsor';
		}
		$uplineid = FindUplineId($findplacement, $side);
		$sponId=$validateSponsorId['data'][0]['id'];
		//$uplineid=$sponId;
      if($userName!='')
      {	  
      	  $userIdData=array();
	      $userIdData['username'] = $userName;
	      $validateUserId=ValidateUserId($userIdData);
	      if($validateUserId['status']){
	      	$response['msg']="Username is already Used.";
            return $response;
	      }
	  }
	  else{
		$userName=GenerateUserName();  	
	  }
	
		$userlogin=array();  
		$userlogin['entrydate'] =$saveDate;
		$userlogin['activedate'] = $activeDate;
		$userlogin['activestatus'] =$activestatus;
		$userlogin['username'] = $userName;
		$userlogin['password'] = $password;
		$userlogin['securitypassword'] = $transactionPassword;
		$userlogin['packagecode'] = $packagecode;
		$userlogin['capping']=0;
		if(isset($data['apiflag'])){
			$userlogin['joinfrom'] = '1';	
		}
		$userid = InsertData('mlm_userlogin',$userlogin);
		if($userid > 0){

		}
		else{
			$response['msg']="Some Error Occur.";
	        return $response;
	        
		}

		$StateName='';
		if($state!=''){
		
		$findState=PassIdTable('mlm_states',$state);
		if($findState['status']){
			$StateName=$findState['data'][0]['name'];		
			}
		
		}
		else{
			$state=0;
		}

		if($country!=''){
		
		}
		else{
			$country=0;
		}
		
		$CityName='';
		if($city!=''){
		$findCity=PassIdTable('mlm_cities',$city);
		if($findCity['status']){
			$CityName=$findCity['data'][0]['name'];
			}
		
		}
		else{
			$city=0;
		}

		if($pinFlag == '1'){
		
			$passPinData=array();
			$passPinData['status']='1';
			$passPinData['usedby']=$userid;
			$passPinData['statusdate']=$saveDate;
			$passPinData['pinno']=$pinno;
			$passPinData['pinid']=$pinid;
			$passPinData['fromid']=$userid;
			$passPinData['type']='2';

			ActivationPinProcess($passPinData);
	  	}

	    $userdetail=array();
	    $userdetail['userid'] = $userid;
		$userdetail['fname'] = $fullName;
		$userdetail['fullname'] =$fullName;
		$userdetail['email'] = $email;
	    $userdetail['mobile'] = $mobile;
	    $userdetail['panno'] = $pannumber;
	    $userdetail['address'] = $address;
	    $userdetail['country'] = $country;
	    $userdetail['state'] = $state;
	    $userdetail['city'] = $city;
	    $userdetail['pincode'] = $pincode;
	    $userdetail['nominee'] = $nomineeName;
	    $userdetail['nomineerel'] = $relNominee;
	    $userdetail['whatsapp'] = $whatsApp;            
		$userDetailId=InsertData('mlm_userdetail',$userdetail);
		if($userDetailId > 0){
		}
		else{
			$response['msg']="Some Error Occur.";
	        return $response;
		}
		
		$userdownline=array();
		$userdownline['userid'] = $userid;
	    $userdownline['sponsor'] = $sponId;
	    $userdownline['side'] = $side;
		$userdownline['upline'] = $uplineid;
		InsertData('mlm_userdownline',$userdownline);

		DirectQuery("INSERT INTO `mlm_sponsorstructure` (`userid`, `uplineid`, `levelno`, `entrydate`) VALUES ('$userid', '$sponId', '1', '$saveDate')");

		DirectQuery("INSERT INTO `mlm_sponsorstructure` (`uplineid`, `userid`, `entrydate`, `levelno`) SELECT `uplineid`, '$userid', '$saveDate', `levelno`+1 FROM `mlm_sponsorstructure` WHERE `userid`='$sponId' AND levelno!=0");
		$insertUserStructureData=array();
		$insertUserStructureData['userid']=$userid;
		$insertUserStructureData['uplineid']=$uplineid;
		$insertUserStructureData['side']=$side;
		$insertUserStructureData['entryDate']=$saveDate;
		$insertUserStructureData['activationDate']=$activeDate;
		$insertUserStructureData['jointype']='1';
		$insertUserStructureData['pv']=$packagepv;
		InsertUserStructure($insertUserStructureData);

		$updateUpline=array();
	    $updateUpline[$fieldName] = $userid;
		$Condition=array();
		$Condition['id']=$sponId;
		UpdateData('mlm_userlogin',$updateUpline,$Condition);
 
	   	if($email!='')
	   	{
	   		//Registermail($userName,$password,$email);	
	   	}
	    $response['status']=true;
	    $response['msg']="Joining Done Successfully.";
	    $response['username']=$userName;
	    $response['password']=$password;
	    $response['userid']=$userid;
	    $response['fullName']=$fullName;
	    
	    return $response;
	}


	function FindUplineId($sponid, $side, $Joining_type = '1') {		
		$k=0;
		while($k == 0)
		{	

			$MainTable="mlm_userstructure";
			$Condition="uplineid = '$sponid' AND levelno = '1' AND side = '$side' AND jointype = '$Joining_type'";
			$GetPlacement=CreateSingleQuery($MainTable,$Condition,'userid');
			$GetPlacement=json_decode($GetPlacement,true);
			if($GetPlacement['status'])
			{
				$sponid=$GetPlacement['data'][0]['userid'];
			}
			else
			{
				$placement=$sponid;
				$k=1;
			}
		}
		return $placement;
	}

	function InsertUserStructure($data){

		$userid=$data['userid'];
		$uplineid=$data['uplineid'];
		$side=$data['side'];
		$entrydate=$data['entryDate'];
		$activedate=$data['activationDate'];
		$jointype=$data['jointype'];
		$pv=$data['pv'];

		$FirstLeveLEntry=array();
		$FirstLeveLEntry['userid']=$userid;
		$FirstLeveLEntry['uplineid']=$uplineid;
		$FirstLeveLEntry['side']=$side;
		$FirstLeveLEntry['levelno']=1;
		$FirstLeveLEntry['entrydate']=$entrydate;
		$FirstLeveLEntry['jointype']=$jointype;
		InsertData('mlm_userstructure',$FirstLeveLEntry);

		$dowlineQuery="INSERT INTO `mlm_userstructure` (`uplineid`, `userid`, `entrydate`, `levelno`, `side`, `jointype`) select `uplineid`, '$userid', '$entrydate', `levelno`+1, `side`, '$jointype' from `mlm_userstructure` where `userid`='$uplineid' and levelno!=0 and jointype='$jointype'";

		DirectQuery($dowlineQuery);

	}

	function InsertUserSponStructure($data){

		$userid=$data['userid'];
		$uplineid=$data['uplineid'];
		$side=$data['side'];
		$entrydate=$data['entryDate'];
		$activedate=$data['activationDate'];
		$jointype=$data['jointype'];
		$pv=$data['pv'];

		$FirstLeveLEntry=array();
		$FirstLeveLEntry['userid']=$userid;
		$FirstLeveLEntry['uplineid']=$uplineid;
		$FirstLeveLEntry['side']=$side;
		$FirstLeveLEntry['levelno']=1;
		$FirstLeveLEntry['entrydate']=$entrydate;
		$FirstLeveLEntry['jointype']=$jointype;
		InsertData('mlm_usersponstructure',$FirstLeveLEntry);

		$dowlineQuery="INSERT INTO `mlm_usersponstructure` (`uplineid`, `userid`, `entrydate`, `levelno`, `side`, `jointype`) select `uplineid`, '$userid', '$entrydate', `levelno`+1, `side`, '$jointype' from `mlm_usersponstructure` where `userid`='$uplineid' and levelno!=0 and jointype='$jointype'";

		DirectQuery($dowlineQuery);

	}

	function ActivationProcess($data,$type=0){


	    $saveDate=$data['entrydate'];
	    $activedate=$data['activedate'];
	    $userid=$data['userid'];
	    $fromid=$data['fromid'];
	    $packagecode=$data['packagecode'];
	    $activetype=$data['activetype'];
	    $pinno=$data['activepin'];
	    $status=$data['status'];
	    $packageamount=$data['activeamount'];
	    $packageTax=$data['packageTax'];
	    $packageNetAmount=$data['packageNetAmount'];
	    $packagebv=$data['bv'];
	    $packagepv=$data['pv'];
	    $type=$data['type'];
	    //$renew=$data['renew'];
	    $flag=0;
	    
	    $activeProcess=array();

	    if(isset($data['pcodeupdate'])){
	    	$pcodeupdate=$data['pcodeupdate'];
	    	if($pcodeupdate == 'no'){
	    		$flag=1;
	    		$activeProcess['lockpackage']='1';
	    	}
	    }
	  
	    
	    $activeProcess['entrydate']=$saveDate;
	    $activeProcess['activedate']=$activedate;
	    $activeProcess['userid']=$userid;
	    $activeProcess['fromid']=$fromid;
	    $activeProcess['packagecode']=$packagecode;
	    $activeProcess['activetype']=$activetype;
	    $activeProcess['activepin']=$pinno;
	    $activeProcess['status']=$status;
	    $activeProcess['activeamount']=$packageamount;
	    $activeProcess['packagetax']=$packageTax;
	    $activeProcess['netamount']=$packageNetAmount;
	    $activeProcess['bv']=$packagebv;
	    $activeProcess['pv']=$packagepv;
	    $activeProcess['type']=$type;
	    //$activeProcess['renew']=$renew;
	   if(isset($data['apiflag'])){
	    	$activeProcess['joinfrom']='1';
	    }
	    $activeId=InsertData('mlm_useractivation',$activeProcess);
	    $response=array();
	    $response['status'] = false;
	    if($activeId > 0){
	    	
	    	if($type == 1){
				$getOrderInfo=PassIdTable('mlm_userlogin',$userid);
				$purchasestatus=$getOrderInfo['data'][0]['purchasestatus'];
				$updateLoginData=array();
				if($flag==1)
				{
					$packagecode=0;
					$updateLoginData['lockmember'] ='0';
				}
				$updateLoginData['activedate'] = $activedate;
				$updateLoginData['activestatus'] = '1';
				/*if($purchasestatus=='0')
				{
					$updateLoginData['puchasedate'] = $activedate;
					$updateLoginData['purchasestatus'] = '1';	
				}*/
				$updateLoginData['packagecode'] =$packagecode;
				$updateLoginCondition=array();
				$updateLoginCondition['id']=$userid;

				UpdateData('mlm_userlogin',$updateLoginData,$updateLoginCondition);

	    	}
	    	
	    	$response['status'] = true;
	    	$response['activeId']=$activeId;
	    }
	    return $response;
	}
	
	function CheckUpgaradtionProcess($data){
		 $memberId=$data['memberId'];
         $newPackageId=$data['newPackageId'];
         $currentPackageId=$data['currentPackageId'];

         $response=array();
         $response['status']=true;

         if($newPackageId > 0 and $currentPackageId > 0){
			$response['status']=false;
			$currentPackageInfo=PassIdTable("mlm_packagesetting",$currentPackageId);
			$newPackageInfo=PassIdTable("mlm_packagesetting",$newPackageId);

			$currentPackagePriority=$currentPackageInfo['data'][0]['priority'];
			$newPackagePriority=$newPackageInfo['data'][0]['priority'];
	         if($newPackagePriority > $currentPackagePriority){
	         		$response['status']=true;
	         }	
         }
         
        

         return $response;

	}
?>