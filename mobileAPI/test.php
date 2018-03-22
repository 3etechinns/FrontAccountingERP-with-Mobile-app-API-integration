<?php
require 'init.php';

$action = 'sales';
	
				/*$rideId=$_POST['rideId'];
				$Longitude=$_POST['Longitude'];
				$Latitude=$_POST['Latitude'];
				$Email=$_POST['Email'];
				$myPhone=$_POST['myPhone'];
				$TotalPrice=$_POST['TotalPrice'];
				$distance=$_POST['distance'];
				$myFname=$_POST['myFname'];
				$myLname=$_POST['myLname'];
				$paymentMethod=$_POST['paymentMethod'];
				$pickup_point=$_POST['pickup_point'];
				//$drop_latitude=$_POST['drop_latitude'];
				//$drop_longitude=$_POST['drop_longitude'];*/
				$rideId="56";
				$Longitude="36.9";
				$Latitude="0.1";
				$Email="amuribonface@gmail";
				$myPhone="0722199199";
				$TotalPrice="500";
				$distance="30km";
				$myFname="Amuri";
				$myLname="Bonface";
				
				$paymentMethod="cash";
				$pickup_point="thika";
				$dropoff_point="juja";			

				
				$mypPhone='boda'.$myPhone;

 $sql = "select id from debtor_trans_details ORDER BY id DESC LIMIT 1;";  
 $result = mysqli_query($con,$sql);  
 
 if(mysqli_num_rows($result) >0 )  
 {  
 $row = mysqli_fetch_assoc($result);  
 $x=$row["id"]+1; 
 //mysqli_close($con);
 }
 
 $refN='0'.$x.'/2018';

$sql = "select debtor_no,name,debtor_ref  from debtors_master WHERE debtor_ref='$mypPhone';";  
$result = mysqli_query($con,$sql);  
	 
 if(mysqli_num_rows($result) >0 )  
 {  
 $row = mysqli_fetch_assoc($result);  
 $debtor_id=$row["debtor_no"]; 
 $myName=$row['name'];
 mysqli_close($con);
 }
  
$data = json_encode(array(
				'trans_type' => '10',
				'ref' => $refN, 
				'comments' => 'pickup_point='.$pickup_point.'Destination='.$dropoff_point,
				'order_date' => date("d-m-Y"),
				'delivery_date' => date("d-m-Y"),
				'cust_ref' => $mypPhone,
				'deliver_to' => $myName,
				'delivery_address' => $dropoff_point,
				'phone' => $myPhone,
				'ship_via' => '0',
				'location' => 'DEF',
				'freight_cost' => 0,
				'customer_id' => '3',
				'branch_id' => '2',
				'sales_type' => '1',
				'dimension_id' => '0',
				'dimension2_id' => '0',

				'items' => array(
					0 => array(
						'stock_id' => 1,
						'qty' => 1,
						'price' => $TotalPrice,
						'discount' => 0,
						'description' => 'To pay Via: '.$paymentMethod.' '.'Distance'.$distance
					)
				),
			));
					
 
//$headers = array('X_company: 0', 'X_user: admin', 'X_password: admin');
# headers and data (this is API dependent, some uses XML)

$headers = array();

//*optional headers
$headers[] = "Accept: application/json";
$headers[] = "Content-Type: application/json";


$headers[] = 'X_company: 0';
$headers[] = 'X_user: admin';
$headers[] = 'X_password: officer';

//$url = "http://localhost/frontaccounting/modules/fa/$action/";
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
echo print_r(json_decode($data, true), true); 
 ?>