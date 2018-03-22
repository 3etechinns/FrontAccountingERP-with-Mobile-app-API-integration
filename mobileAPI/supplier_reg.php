<?php
$action = 'suppliers';


			
$name=$_POST['name'];
$address=$_POST['address'];
$phone=$_POST['phone'];
$email=$_POST['email'];


$data = array(
	'supp_name' => $name,
	'supp_ref' => 'driver'.$phone,
	'address' => $address,
	'supp_address' => $address,
	'gst_no' => '1',
	'website' => 'n/a',
	'supp_account_no' => $phone,
	'bank_account' => '',
	'credit_limit' => '0',
	'curr_code' => 'USD',
	'payment_terms' => '4',
	'payable_account' => '1010',
	'purchase_account' => '1020',
	'payment_discount_account' => '1030',
	'notes' => 'notes',
	'tax_group_id' => '1',
	'tax_included' => '1',
	'contact' => $email,        // Not yet implemented
	'dimension_id' => '0',  // Not yet implemented
	'dimension2_id' => '0', // Not yet implemented
	'inactive' => '0');     // Not yet implemented);

$headers = array('X_company: 0', 'X_user: admin', 'X_password: officer');

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

echo print_r(json_decode($content, true), true); ?>
