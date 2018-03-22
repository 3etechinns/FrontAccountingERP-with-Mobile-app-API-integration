<?php


require 'init.php';

	$action = 'pay';
	/*$driver_phone ='0722123123';
	$amount_paid = 500;
	
	$passenger_name = 'Amuri Bonface';
	//$passenger_email = $_POST["passenger_email"];
	$pickup_point = 'Thika';
	$dropoff_point = 'Juja';
	
	$driver_phone = $_POST["driver_phone"];
	$amount_paid = $_POST["amount_paid"];
	$pickup_point = $_POST["pickup_point"];
	$dropoff_point = $_POST["dropoff_point"];
	$passenger_name = $_POST["passenger_name"];*/
	
	$ride_code = $_POST["ride_code"];
	$driver_code = $_POST["driver_code"];
	$driver_phone = $_POST["driver_phone"];
	$driver_email = $_POST["driver_email"];
	$driver_name = $_POST["driver_name"];
	$driver_town = $_POST["driver_town"];
	$passenger_code = $_POST["passenger_code"];
	$passenger_phone = $_POST["passenger_phone"];
	$passenger_name = $_POST["passenger_name"];
	$passenger_email = $_POST["passenger_email"];
	$pickup_point = $_POST["pickup_point"];
	$dropoff_point = $_POST["dropoff_point"];
	$distance_travelled = $_POST["distance_travelled"];
	$amount_paid = $_POST["amount_paid"];
	$payment_mode = $_POST["payment_mode"];
	
	$msisdn = $_POST["msisdn"];
	$mpesa_transaction_date = $_POST["mpesa_transaction_date"];
	$mpesa_transaction_id = $_POST["mpesa_transaction_id"];
	$mpesa_amount = $_POST["mpesa_amount"];
	
$driver_pPhone='driver'.$driver_phone;

 $sql = "select trans_no from supp_trans ORDER BY trans_no DESC LIMIT 1;";  
 $result = mysqli_query($con,$sql);  
 
 if(mysqli_num_rows($result) >=0 )  
 {  
 $row = mysqli_fetch_assoc($result);  
 $b=$row["trans_no"]+1; 
 //mysqli_close($con);
 }
 else
 {
	 $b=1;
 }
$trans_no=$b;
$refN=$b.'/2018';



$sql = "select supplier_id,supp_name,supp_ref from suppliers WHERE supp_ref='$driver_pPhone';";  
$result = mysqli_query($con,$sql);  
	 
 if(mysqli_num_rows($result) >0 )  
 {  
 $row = mysqli_fetch_assoc($result);  
 $supplier_id=$row["supplier_id"]; 
 $myName=$row['supp_name'];
mysqli_close($con);
 }
 
$amount_to_pay=(80/100)*$amount_paid;

$data = array('trans_no' => $trans_no, 
				'supplier_id' => $supplier_id,
				'bank_account' => '1',
				'date_' => date("d/m/Y"),
				'ref' => $refN,
				'supp_amount' => $amount_to_pay,	
				'supp_discount' => 0,
				'memo_' => 'Ksh='.$amount_paid.' paid for Bodaorder service offered to '.$passenger_name.' from:'.$pickup_point.' to'.$dropoff_point,
				'bank_charge' => 0,
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
