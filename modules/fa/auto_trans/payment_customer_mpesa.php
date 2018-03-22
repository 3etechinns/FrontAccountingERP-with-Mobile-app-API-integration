<?php

require 'init.php';
$action = 'payments';
			 $rideId=$_POST['rideId'];
             $myPhone=$_POST['myPhone'];
             $myName=$_POST['myName'];
             $paymentMethod=$_POST['paymentMethod'];
             $pickup_point=$_POST['pickup_point'];
             $dropoff_point=$_POST['dropoff_point'];
             $mpesaAmount=$_POST['amount'];
             $mpesaTransactionId=$_POST['mpesaTransactionId '];
             $mpesaTransactionDate=$_POST['mpesaTransactionDate '];
			 
			 /*
				$rideId="56";
				
				$myPhone="0717264871";
				$amount="500";
				
				$myNname="Amuri";
				
				$paymentMethod="cash";
				$pickup_point="thika";
				$dropoff_point="juja";
				$mpesaAmount=$amount;
             $mpesaTransactionId="MXDVBRHYU8OJ";
             $mpesaTransactionDate=("d/m/Y");*/
			 
			 
$mypPhone='boda'.$myPhone;


$sql = "select debtor_no,name,debtor_ref  from debtors_master WHERE debtor_ref='$mypPhone';";  
$result = mysqli_query($con,$sql);  
	 
 if(mysqli_num_rows($result) >0 )  
 {  
 $row = mysqli_fetch_assoc($result);  
 $debtor_id=$row["debtor_no"]; 
 $myName=$row['name'];
// mysqli_close($con);
 }
 require 'init.php';
 $sql = "select id from audit_trail ORDER BY id DESC LIMIT 1;";  
 $result = mysqli_query($con,$sql);  
 
 if(mysqli_num_rows($result) >0 )  
 {  
 $row = mysqli_fetch_assoc($result);  
 $x=$row["id"]+1; 
 //mysqli_close($con);
 }else
 {
	 $x=1;
 }
$refN=$x.'/2018';


require 'init.php';
 $sql = "select trans_no from audit_trail ORDER BY trans_no DESC LIMIT 1;";  
 $result = mysqli_query($con,$sql);  
 
 if(mysqli_num_rows($result) >0 )  
 {  
 $row = mysqli_fetch_assoc($result);  
 $b=$row["trans_no"]+1; 
 mysqli_close($con);
 }
$trans_no=$b;

		  
$data = array('trans_no' => $trans_no, 
				'customer_id' => $debtor_id,
				'branch_id' => $debtor_id,
				'bank_account' => '1',
				'date_' => date("d/m/Y"),
				'ref' => $refN,
				'amount' => $mpesaAmount,	
				'discount' => 0,
				'memo_' => 'Mpesa Code:'.$mpesaTransactionId.' Date:'.$mpesaTransactionDate.'Payment for Trip from:'.$pickup_point.' To:'.$dropoff_point.' Paid Via'.$paymentMethod,
				'rate' => 0,
				'charge' => 0,
				'bank_amount' => 0
			);

//$headers = array('X_company: 0', 'X_user: admin', 'X_password: admin');
# headers and data (this is API dependent, some uses XML)

$headers = array();

//*optional headers
//$headers[] = "Accept: application/json";
//$headers[] = "Content-Type: application/json";


$headers[] = 'X_company: 0';
$headers[] = 'X_user: admin';
$headers[] = 'X_password: officer';

//$url = "http://localhost/backoffice/modules/fa/$action/";
$url = "http://www.bodaorder.co.ke/backoffice/modules/fa/$action/";


// create a new cURL for data retrieval 
$ch = curl_init();
curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);



ob_start();
curl_exec($ch);
$content = ob_get_contents(); 
ob_end_clean(); 

curl_close($ch);

echo print_r(json_encode($content, true), true); ?>
