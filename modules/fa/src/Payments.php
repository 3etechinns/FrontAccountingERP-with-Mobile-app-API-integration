<?php
namespace FAAPI;

include_once (FA_ROOT . "/sales/includes/db/payment_db.inc");



class Payments {
	
	// Add Item
	public function post($rest) {
		//include_once (API_ROOT . "/sales.inc");
		//sales_add();
	//	include_once (FA_ROOT . "/sales/includes/db/payment_db.inc");
		$req = $rest->request();
		$info = $req->post();
		
	write_customer_payment($info['trans_no'], $info['customer_id'], $info['branch_id'], $info['bank_account'],
	$info['date_'], $info['ref'], $info['amount'], $info['discount'], $info['memo_'], $info['rate'], $info['charge'], $info['bank_amount']);
	}
	
}