<?php
namespace FAAPI;


include_once (FA_ROOT . "/purchasing/includes/db/supp_payment_db.inc");


class Pay {
	
	// Add Item
	public function post($rest) {
		
		$req = $rest->request();
		$info = $req->post();

	
	write_supp_payment($info['trans_no'], $info['supplier_id'], $info['bank_account'],
	$info['date_'], $info['ref'], $info['supp_amount'], $info['supp_discount'], $info['memo_'], $info['bank_charge'], $info['bank_amount']);
	}
	
	
}