<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');
function SmsSend($data,$mobile,$type){
	$ci =& get_instance();
	$WebsiteUrl=$ci->config->item('website_url');
	$companyName=GetCompanyName();
	if($type == 1){ //Joining Sms
		$memberid=$data['memberid'];
		$password=$data['password'];
		$fullName=$data['fullName'];
		//$msg="Congrats! ".$fullName.", Welcome to ".$companyName.". Member ID:".$memberid.", Pwd:".$password." VISIT : ".$WebsiteUrl;
		$msg="Congrats! YOUR FREE REGISTRATION SUCCESSFULLY , Your Member ID:".$memberid.", Pwd:".$password." VISIT : ".$WebsiteUrl;
	}
	else if($type == 2){//Forget Password Sms
		$memberid=$data['memberid'];
		$password=$data['password'];
		$fullName=$data['fullName'];
		//Keep Seceret Your Login Info. Login ID:[MEMBERID], Password:[PASSWORD] Visit:[WEBSITE].                 
		$msg="Keep Seceret Your Login Info. Login ID : ".$memberid.", Password : ".$password." VISIT : ".$WebsiteUrl;
	}
	else if($type == 3){//Payout
		$mname=$data['mname'];
		$netamt=$data['netamt'];		
		$msg="Dear ".$mname." ,Your INCENTIVE Of Amt.".$netamt." has been Dispatched on ".date(CurrentDate()).". Pls. Check Your Registered Bank A/C Visit: ".$WebsiteUrl;
	}
	else if($type == 4){//Forget Transaction Password Sms

		$memberid = $data['memberid'];
	   	$securitypassword = $data['securitypassword'];
	   	$fullName = $data['fullName'];
		$msg="Keep Seceret Your Login Info. Login ID:".$memberid.",Transaction Password:".$securitypassword." Visit:".$WebsiteUrl;
	}
	else if($type == 5){//product deliver otp

		$otp = $data['otp'];
	   	$msg="Your Product Deliver OTP Is :".$otp.". Visit:".$WebsiteUrl;
	}
	else if($type == 6){ //Pingenerate Admin Msg

		$memberid = $data['memberid'];
		$noofpin = $data['noofpin'];
	   	$msg="Total ".$noofpin." Pins, has been generated for ".$memberid." on ".date(CurrentDate());
	}
	else if($type == 7){//repurchase wallet otp

		$otp = $data['otp'];
	   	$msg="Your OTP Is :".$otp.". Visit:".$WebsiteUrl;
	}
	else if($type == 8){//Pin Transfer sender

		$pins = $data['pins'];
		$fromid = $data['fromid'];
	   	$msg="You have transferred ".$pins." pins to ".$fromid." on ".date(CurrentDate())." Visit:".$WebsiteUrl;
	}
	else if($type == 9){//pin transfer reciver
		$pins = $data['pins'];
		$userid = $data['userid'];
	   	$msg="You have received ".$pins." pins from ".$userid." on ".date(CurrentDate())." Visit:".$WebsiteUrl;
	}
	else if($type == 0){
		$msg=$data['msg'];
	}

	$msgresponse ='';
	/*$ch = curl_init('https://www.txtguru.in/imobile/api.php?');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "username=romilmodi&password=37487147&source=OKKIND&dmobile=91$mobile&message=$msg");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	$msgresponse = curl_exec($ch);*/

	$api_key = $ci->config->item('smsAPI_Key');;
	$from = 'IALERT';
		
	/*$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL, "http://kutility.in/app/smsapi/index.php");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&routeid=415&type=text&contacts=".$mobile."&senderid=".$from."&msg=".$msg);
	$msgresponse = curl_exec($ch);
	curl_close($ch);*/

	$smsresponce=array();
	$smsresponce['message']=$msg;
	$smsresponce['mobile']=$mobile;
	$smsresponce['entrydate']=CurrentDate();
	$smsresponce['responce']=$msgresponse;
	$smsresponce['type']=$type;
	InsertData('mlm_smsresponce',$smsresponce);

}
function Registermail($username,$password,$email)
{
	$companyName=GetCompanyName();

	$message="<!DOCTYPE html PUBLIC -//W3C//DTD XHTML 1.0 Transitional//EN http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd>
	<html xmlns=http://www.w3.org/1999/xhtml>
		<head>
		<meta http-equiv=Content-Type content=text/html; charset=UTF-8 />
		<title>Welcome To ".$companyName."</title>
		<meta name=viewport content=width=device-width, initial-scale=1.0/>
		</head>
		<body style=margin: 0; padding: 0;>
			<table border=0 cellpadding=0 cellspacing=0 width=100%>	
				<tr>
					<td style=padding: 10px 0 30px 0;>
						<table align=center border=0 cellpadding=0 cellspacing=0 width=600 style=border: 1px solid #cccccc; border-collapse: collapse;>
							<tr>
								<td align=center bgcolor=#f6f6f4 style=padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;>
									<img src=http://divinesolutiontech.com/diniva/assets/web/images/logo1.png width=300 style=display: block; />
								</td>
							</tr>
							<tr>
								<td bgcolor=#ffffff style=padding: 40px 30px 40px 30px;> 
									<table border=0 cellpadding=0 cellspacing=0 width=100% align=center style=background-color: #EDEDED;>
										<tr align=center>
											<td style=color: #153643; font-family: Arial, sans-serif; font-size: 24px;><b>Welcome to ".$companyName."</b></td>
										</tr>
										<tr>
										<td>
										<p>Congratulation on your decision to join ".$companyName.".</p>

										<p>You are now a part of the opportunity of the millennium. DCC is an exciting people business. A business that has the potential to turn your dreams into reality. As you build your business, you will establish lifelong friendship and develope support system unparalleled in any other business.</p>
										<p>You are in this business for your self not by yourself. We have developed an effective and proven step by step plan to help you launch a profitable business of your own. You determine your own level of commitment so you can fit it around your lifestyle a personal goals. And the rewards are tremendous for those who can put forth the effort necessary to build a solid organization, one from which you can potentially benefit for the rest of your life.</p>
										<p>The bottom line of DCC - you are a SUCCESS - is to ensure that we effect many hundreds of thousands of lives in positive manner by spreading the total success attitude.</p>
											
										<p>Please find following enrollment data for your reference:</p>
										</td>
										</tr>
										<tr>
											<td>
												<table border=0 cellpadding=0 cellspacing=0 width=100%>
													<tr>
													<td style=width:195px; float:left;></td>
														<td width=260 valign=top style=margin-bottom:15px;>
															<table border=0 cellpadding=0 cellspacing=0 width=100% align=center>
																<tr  align=left>
																	<td style=padding: 25px 0 0 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height:30px!important; text-align:left;text-decoration:none!important; >
																       <br />
																		<h4><p>User Id : ".$username."</p></h4>
																		<h4><p>Password :".$password."</p></h4>
																	</td>
																</tr>
															</table>
														</td>
														<td style=font-size: 0; line-height: 0; width=20>&nbsp;
															
														</td>
														
													</tr>
												</table>
											</td>
										</tr>
										<p>We are confident that you will get a lot of satisfaction from your involvement with DCC and we wish you every Success!
											Keep it up! See you at the top!
											Winning Regards,
											DCC
										</p>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor=blue style=padding:-5px;text-decoration:none!important;>
									<table border=0 cellpadding=0 cellspacing=0 width=100% style=padding:20px;margin-left:60px!important;margin-top:25px!important;>
										<tr align=center style=width:100px;font-size:20px;color:white!important;text-decoration:none!important;>
											 <td style=color:white!important;  font-family: Arial, sans-serif; font-size: 20px; text-decoration:none!important; width=75%>
												<center>&reg; <a href=# style=color:white!important;text-decoration:none!important;> ".$companyName."</a>,2022 </center><br/>
											</td>
											<td align=right width=25%>
												<table border=0 cellpadding=0 cellspacing=0>
										
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</body>
	</html>";

	$headers = "Organization: Sender Organization\r\n";
	$headers .= "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: PHP". phpversion() ."\r\n";
    $headers .= "Reply-To: The Sender <info@dinivastaking.com> \r\n";
  	$headers .= "Return-Path: The Sender <info@dinivastaking.com>\r\n";
	$email1='info@dinivastaking.com';
	$headers .= "From:" . $email1;
	$to=$email;
	$mei = mail($to,$companyName,$message,$headers);
	return $mei;
}

/*function Forgotpass($username,$password,$email)
{
	$companyName=GetCompanyName();

	$message="<!DOCTYPE html PUBLIC -//W3C//DTD XHTML 1.0 Transitional//EN http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd>
	<html xmlns=http://www.w3.org/1999/xhtml>
		<head>
		<meta http-equiv=Content-Type content=text/html; charset=UTF-8 />
		<title>Welcome To ".$companyName."</title>
		<meta name=viewport content=width=device-width, initial-scale=1.0/>
		</head>
		<body style=margin: 0; padding: 0;>
			<table border=0 cellpadding=0 cellspacing=0 width=100%>	
				<tr>
					<td style=padding: 10px 0 30px 0;>
						<table align=center border=0 cellpadding=0 cellspacing=0 width=600 style=border: 1px solid #cccccc; border-collapse: collapse;>
							<tr>
								<td align=center bgcolor=#f6f6f4 style=padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;>
									<img src=http://nfive.me/assets/web/images/logo.jpg width=300 style=display: block; />
								</td>
							</tr>
							<tr>
								<td bgcolor=#ffffff style=padding: 40px 30px 40px 30px;> 
									<table border=0 cellpadding=0 cellspacing=0 width=100% align=center style=background-color: #EDEDED;>
										<tr align=center>
											<td style=color: #153643; font-family: Arial, sans-serif; font-size: 24px;><b>Welcome to ".$companyName."</b></td>
										</tr>
										<tr>
										<td>
										<p>Keep Secret!!!</p>
											
										<p>Keep Secret Your Login Info.</p>
										</td>
										</tr>
										<tr>
											<td>
												<table border=0 cellpadding=0 cellspacing=0 width=100%>
													<tr>
													<td style=width:195px; float:left;></td>
														<td width=260 valign=top style=margin-bottom:15px;>
															<table border=0 cellpadding=0 cellspacing=0 width=100% align=center>
																<tr  align=left>
																	<td style=padding: 25px 0 0 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height:30px!important; text-align:left;text-decoration:none!important; >
																       <br />
																		<h4><p>User Id : ".$username."</p></h4>
																		<h4><p>Password :".$password."</p></h4>
																	</td>
																</tr>
															</table>
														</td>
														<td style=font-size: 0; line-height: 0; width=20>&nbsp;
															
														</td>
														
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor=orange style=padding:-5px;text-decoration:none!important;>
									<table border=0 cellpadding=0 cellspacing=0 width=100% style=padding:20px;margin-left:60px!important;margin-top:25px!important;>
										<tr align=center style=width:100px;font-size:20px;color:white!important;text-decoration:none!important;>
											 <td style=color:white!important;  font-family: Arial, sans-serif; font-size: 20px; text-decoration:none!important; width=75%>
												<center>&reg; <a href=# style=color:white!important;text-decoration:none!important;> ".$companyName."</a>,2021 </center><br/>
											</td>
											<td align=right width=25%>
												<table border=0 cellpadding=0 cellspacing=0>
										
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</body>
	</html>";

	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$email1='info@nfivestaking.com';
	$headers .= "From:" . $email1;
	$to=$email;
	$mei = mail($to,"Forgot Password",$message,$headers);
	return $mei;
}*/
?>