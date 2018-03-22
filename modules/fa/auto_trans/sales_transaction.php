<?php
$action = 'sales';
$data = json_encode(array(
				'trans_type' => 10,
				'ref' => '22/2018', 
				'comments' => 'cash_sale',
				'order_date' => date("d/m/Y"),
				'delivery_date' => date("d/m/Y"),
				'cust_ref' => 'joe',
				'deliver_to' => 'deliver_to',
				'delivery_address' => 'delivery_address',
				'phone' => 'phone',
				'ship_via' => 'ship_via',
				'location' => 'DEF',
				'freight_cost' => 0,
				'customer_id' => '3',
				'branch_id' => '3',
				'sales_type' => '1',
				'dimension_id' => '0',
				'dimension2_id' => '0',

				'items' => array(
					0 => array(
						'stock_id' => '1',
						'qty' => '1',
						'price' => '2',
						'discount' => '0',
						'description' => 'description'
					)
				),
			));
			
		/*	
$data= json_encode(array
						('ref'=>'auto','trans_type' => '10',
							'comments'=>'cash_sale',
							'order_date'=>'11/14/2017',
							'payment'=>'4',
							'payment_terms'=>'cash_sale',

									'due_date'=>'11/14/2017',
									'phone'=>'',
									'cust_ref'=>'joe',
									'delivery_address'=>'N/A',
									'ship_via'=>'1',
									'deliver_to'=>'DonaldEasterLLC',
									'delivery_date'=>'11/14/2017',
									'location'=>'DEF',
									'freight_cost'=>'0',
									'email'=>'',
									'customer_id'=>'3',
									'branch_id'=>'3',
									'sales_type'=>'1',
									'dimension_id'=>'0',
									'dimension2_id'=>'0',
									'items'=>Array
											(
												0=>Array
														(
														'id'=>'1',
														'stock_id'=>'1',
														'qty'=>'2',
														'units'=>'each',
														'price'=>'250',
														'discount'=>'0',
														'description'=>'service'
														)
										),

						'sub_total'=>'250',
						'display_total'=>'600',
));

			
	*/		

			
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

echo print_r(json_decode($content, true), true); ?>
