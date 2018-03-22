<?php
$action = 'customers';
$headers = array('X_company: 0', 'X_user: admin', 'X_password: admin');
$url = "http://localhost/frontaccounting/modules/fa/$action/";

// create a new cURL for data retrieval 
$ch = curl_init();
curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);

ob_start();
curl_exec($ch);
$content = ob_get_contents(); 
ob_end_clean(); 
curl_close($ch);

echo print_r(json_decode($content, true), true); ?>
