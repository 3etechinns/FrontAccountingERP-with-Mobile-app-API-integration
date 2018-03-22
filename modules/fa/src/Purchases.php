<?php
namespace FAAPI;

include_once (FA_ROOT . "/purchasing/includes/db/supp_trans_db.inc");
include_once (FA_ROOT . "/purchasing/includes/db/invoice_items_db.inc");
include_once (FA_ROOT . "/purchasing/includes/db/supp_payment_db.inc");

class Purchases {
	// Get Items
	public function get($rest) {
		$req = $rest->request();

		$page = $req->get("page");

		$sql = get_sql_for_supplier_inquiry(ALL_TEXT, '1/1/0000', '1/1/9999');
		$result = db_query($sql, 'oops');
		
		$body = array();

		while ($row = db_fetch_assoc($result)) {
			$body[] = $row;
		}
		
		api_success_response(json_encode($body));
	}
	
	public function getByType($rest, $trans_type) {
		$req = $rest->request();

		$page = $req->get("page");

		$sql = get_sql_for_supplier_inquiry(ALL_TEXT, '0000-01-01', '9999-12-31');
		$result = db_query($sql, 'oops');
		
// 		if ($page == null) {
// 			sales_all($trans_type);
// 		} else {
// 			// If page = 1 the value will be 0, if page = 2 the value will be 1, ...
// 			$from = -- $page * RESULTS_PER_PAGE;
// 			sales_all($trans_type, $from);
// 		}
	}

	// Get Specific Item by Id
	public function getById($rest, $trans_no, $trans_type) {
		include_once (API_ROOT . "/sales.inc");
		sales_get($trans_no, $trans_type);
	}

	// Add Item
	public function post($rest) {
		//include_once (API_ROOT . "/sales.inc");
		//sales_add();
		include_once (FA_ROOT . "/purchasing/includes/db/supp_trans_db.inc");
		$req = $rest->request();
		$info = $req->post();
		
		
	add_supp_invoice_item($info['type'], $info['trans_no'],$info['stock_id'], $info['description'], $info['gl_code'],$info['amount'], 0, 1, 1, $info['trans_no'], $info['memo_'], 0, 0);
	
	add_supp_invoice_gl_item($info['type'], $info['trans_no'], $info['gl_code'],$info['amount'], $info['memo_'], 0, 0);


	write_supp_trans($info['type'],$info['trans_no'], $info['supplier_id'], $info['date_'], $info['due_date'], $info['reference'], $info['supp_reference'],
	$info['amount'],0, $info['discount'],$err_msg="", 0, 0);
	}
	
	

	// Edit Specific Item
	public function put($rest, $trans_no, $trans_type) {
		include_once (API_ROOT . "/sales.inc");
		sales_edit($trans_no, $trans_type);
	}

	// Delete Specific Item
	public function delete($rest, $branch_id, $uuid) {
		include_once (API_ROOT . "/sales.inc");
		sales_cancel($branch_id, $uuid);
	}
}