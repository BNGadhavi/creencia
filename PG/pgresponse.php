<?php





session_start();

include('Authentication.php');



$query = $_REQUEST['query'];

$authKey = " ";

$authIV = " ";

$decText = null;

$EncryptDecrypt = new EncryptDecrypt();



$query = str_replace("%2B","+",$query);



$decText = $EncryptDecrypt -> decrypt($query, $authIV, $authKey); 



//echo $decText;

$userid = $_SESSION['userid'];



echo "<br>";

echo "<br>";



 

// echo $userid;



echo "<br>";

echo "<br>";

$token = strtok($decText,"&");

//echo $token;

$i=0;



//pgRespCode=F&PGTxnNo=37811436&SabPaisaTxId=7399702091711511122664015&issuerRefNo=NA&authIdCode=0&amount=57.0&clientTxnId=TESTING020917115040588&firstName=TPK&lastName=Test&payMode=CreditCards&email=test@gmail.com&mobileNo=9908944111&spRespCode=0000&cid=null&bid=null&clientCode=CXY10&payeeProfile=Student&transDate=Sat Sep 02 11:55:00 IST 2017&spRespStatus=success¶m3=BE&challanNo=&reMsg=null&orgTxnAmount=55.0&programId=mtech

while ($token !== false)

{

  $i=$i+1;

  $token1=strchr($token, "=");

  $token=strtok("&");

  $fstr=ltrim($token1,"=");

  echo "<br>";

echo "<br>";

//echo $fstr;

  if($i==2)

     $pgTxnId=$fstr;

     echo "<br>";

echo "<br>";

  // echo $pgTxnId;

  if($i==3)

     $sptxnId=$fstr;

  if($i==4)

      $issuerRefNo=$fstr;   

   if($i==5)

       $authIdCode=$fstr; 

   if($i==6)

       $payAmt=$fstr;

       echo "<br>";

echo "<br>";

    //  echo $payAmt;

  if($i==7)

     $clientTxnId=$fstr;

  if($i==8)

     $firstName=$fstr;

    // echo $spRespstat;

   if($i==9)

     $lastName=$fstr;

   if($i==10)

     $payMode=$fstr;

   if($i==11)

     $email=$fstr;

   if($i==12)

       $mobileNo=$fstr;  

   if($i==13)

	$spRespCode=$fstr;  

   if($i==14)

	$cid=$fstr;	

   if($i==15)

	$bid=$fstr;

   if($i==16)

	$clientcode=$fstr;

   if($i==17)

	$payerProfile=$fstr;

   if($i==18)

	$transDate=$fstr;

//	echo $transDate;

  if($i==19)

	$spRespstat=$fstr;

//	echo $spRespstat;

  if($i==20)

	 $challanNo=$fstr;				

	

  if($i==21)

     $amt=$fstr;

  if($i==22)

	$programId=$fstr;

	if($i==46)

	$ufd20=$fstr;

//echo $ufd20;	

	if($token == true)

	{

	    $up = "UPDATE  buy_now SET txid='$pgTxnId', tx_dt='$transDate', status='1' WHERE student_id='$userid'";

	      //$up = "UPDATE  buy_now SET txid='$pgTxnId', tx_dt='$transDate', status=1 WHERE student_id=$ufd20";

	     // echo $up;

	    mysqli_query($conn,$up);

	    

	}

	

	

}



?>



<?php

include('header.php');

?>













<div class="page-content-wrapper">

    <div class="page-content">

        <div class="page-bar">

            <div class="page-title-breadcrumb">

                <div class=" pull-left">

                    <div class="page-title">Payment Success Page</div>

                </div>

               

            </div>

        </div>

        <div class="row">

            <div class="col-md-12 col-sm-12">

                <div class="card card-box">

                    <div class="card-body " id="bar-parent2">

                        <div class="row">

                          <h1>Thank You, Your payment for Rs. <?php echo $payAmt;?> is successful. You can have your reciept by clicking on print button given below. </h1>

                            <div class="col-md-6 col-sm-6">

                                

                                    <a href="pdf/fpdf/add_receipt.php?user_id=<?php echo $userid?>&pay_type=Pros_Fee" class="btn btn-success" target="_blank">Print Receipt</a>

                                    <a href="download_prospectus.php?user_id=<?php echo $userid?>" class="btn btn-primary">Download Prospectus</a>

                                    <br>

                                     <br>

                                    <p> <span class="badge badge-sucess">Note:</span> You can print recipt any time if required.</p>

                                </div>

                            </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <?php include('footer.php'); ?>

