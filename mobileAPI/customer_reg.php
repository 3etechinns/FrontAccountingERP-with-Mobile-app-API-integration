<?php

//require_once 'init.php';

$action = 'customers';

 /*$sql = "select id from crm_persons ORDER BY id DESC LIMIT 1;";  
 $result = mysqli_query($con,$sql);  
 
 if(mysqli_num_rows($result) >0 )  
 {  
 $row = mysqli_fetch_assoc($result);  
 $x=$row["id"]+1; 
 mysqli_close($con);
 }*/
			
$name=$_POST['name'];
$address=$_POST['address'];
$phone=$_POST['phone'];
$email=$_POST['email'];

$data = array ('name' => $name,'debtor_ref' => 'boda'.$phone,'address' => $address,'tax_id' =>1, 'curr_code' => 'KSH','email'=>$email,'phone'=>$phone,'credit_status' => 1,'payment_terms' => 4,'discount' => 0,'pymt_discount' => 0,'credit_limit' => 0,'sales_type'=>1);

$headers = array('X_company: 0', 'X_user: admin', 'X_password: officer');

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

echo print_r(json_decode($content, true), true); ?>
