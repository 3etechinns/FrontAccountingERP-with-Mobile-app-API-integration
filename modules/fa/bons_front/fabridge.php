<?php
/*
FrontAccounting Bridge Function
Ref: http://singletonio.blogspot.in/2009/07/simple-php-rest-client-using-curl.html
Author: Ap.Muthu
Website: http://www.apmuthu.com
Release Date: 2012-11-28
*/

define("REST_URL",   "http://localhost/frontaccounting/modules/fa/");
define("COMPANY_NO", "0");
define("REST_USER",  "admin");
define("REST_PWD",   "adm");
$action = 'customers';

$data = json_encode(array (
'CustName' => 'Anthony','debtor_ref' => 'jj','address' => '30100','tax_id' =>1, 'curr_code' => 'USD','dimension_id' => 0,'dimension2_id' => 0,'credit_status' => 1,'payment_terms' => 4,'discount' => 0,'pymt_discount' => 0,'credit_limit' => 1000,'notes' => 'null' ) );

function fa_bridge($method="POST", $action, $record="", $filter=false, $data=true) {


$url = REST_URL. "/$action/";
if ($filter) $url .= "/$filter";

# headers and data (this is API dependent, some uses XML)
$headers = array();


// optional headers
$headers[] = "Accept: application/json";
$headers[] = "Content-Type: application/json";


$headers[] = "X_company: ".COMPANY_NO;
$headers[] = "X_user: ".REST_USER;
$headers[] = "X_password: ".REST_PWD;

$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_HEADER, 0);
curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt($handle, CURLOPT_POST, true);
		curl_setopt($handle, CURLOPT_POSTFIELDS, $data);

// grab URL and pass it to the variable and not browser
ob_start();
curl_exec($handle);
$content = ob_get_contents(); 
ob_end_clean(); 
$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

// close cURL resource, and free up system resources
curl_close($handle);

$content = ($code == "200") ? json_decode($content, true) : false;

return $content;
}

?>