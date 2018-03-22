<?php
$action = 'customers';

$data = json_encode(Array ('name'=> 'Anthony','debtor_ref' => 'jj','address' => '30100','tax_id' =>1, 'currency_code' => 'USD','credit_status' => 1,'payment_terms' => 4,'discount' => 0,'pymt_discount' => 0,'credit_limit' => 1000) );

$headers = array('X_company: 0', 'X_user: admin', 'X_password: admin');

$url = "http://localhost/frontaccounting/modules/fa/$action/";

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
