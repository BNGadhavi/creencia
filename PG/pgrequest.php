<?php
session_start();
include  'Authentication.php';

$spURL = null;
$spDomain = "https://securepay.sabpaisa.in/SabPaisa/sabPaisaInit";    //URL provided by SabPaisa(Mandatory)
$username = "Ish988@sp";                                            //Username provided by Sabpaisa (Mandatory) 
$password = "wF2F0io7gdNj";                          				  //Password provided by Sabpaisa (Mandatory) 
$programID="5666";                                                  //Transaction ID (Mandatory) 
$clientCode = "NITE5";                                           //Client Code Provided by Sabpaisa (Mandatory) 
$authKey = "vuQy2eFx4q095E03";                         //Authentication Key Provided By Sabpaisa  (Mandatory only if authentication is enabled) 
$authIV = "qz7zPW07upqREhuo"; 		                    //Authentication IV Provided by Sabpaisa(Mandatory only if authentication is enabled)
$txnId=rand(10005000,99999999);                         // Unique For Every Transaction
$txnAmt = "10";                                                   //Transaction Amount (Mandatory)
$URLsuccess = "https://mplwellness.biz/PG/pgresponse.php";          //Return URL upon successful transaction (Mandatory)
$URLfailure = "https://mplwellness.biz/PG/pgresponse.php";             //Return URL upon failed Transaction (Mandatory)
$payerFirstName ="Mukesh";                             //Payer's First Name (Mandatory)
$payerLastName ="Kumar";                              //Payer's Last Name (Mandatory)
$payerContact = "8796541230";                       //Payer's Contact Number (Mandatory)
$payerEmail = "test@gmail.com";                   //Payer's Email ID (Mandatory)

$spURL ="?clientName=".$clientCode."&usern=".$username."&pass=".$password."&amt=".$txnAmt."&txnId=".$txnId."&firstName=".$payerFirstName."&lstName=".$payerLastName."&contactNo=".$payerContact."&Email=".$payerEmail."&ru=".$URLsuccess."&failureURL=".$URLfailure;

$EncryptDecrypt = new EncryptDecrypt(); 
$spURL = $EncryptDecrypt->encrypt($spURL,$authIV,$authKey); 
$spURL = str_replace("+", "%2B",$spURL); 
$spURL="?query=".$spURL."&clientName=".$clientCode;  
$spURL = $spDomain.$spURL; 

header("location:".$spURL);
?>
