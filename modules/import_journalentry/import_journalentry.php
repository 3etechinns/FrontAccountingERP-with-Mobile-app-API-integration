<?php
/**********************************************
Author: Tom Hallman
Name: Import Journal Entry/Deposit/Payment
Free software under GNU GPL
***********************************************/
$page_security = 11;
$path_to_root="../..";

include_once($path_to_root . "/includes/ui/items_cart.inc");
include_once($path_to_root . "/includes/session.inc");

// Turn these next two lines on for debugging
//error_reporting(E_ALL);
//ini_set("display_errors", "on");

//--------------------------------------------------------------------------------------------------

function init_cart($type)  // Copied from gl/gl_journal::handle_new_order() & gl/gl_bank::handle_new_order()
{
	if ($type == 'journalentry') {
		
		if (isset($_SESSION['journal_items']))
		{
			$_SESSION['journal_items']->clear_items();
			unset ($_SESSION['journal_items']);
		}
	
		session_register("journal_items");
	
	    $_SESSION['journal_items'] = new items_cart(systypes::journal_entry());
	
		$_POST['date_'] = Today();
		if (!is_date_in_fiscalyear($_POST['date_']))
			$_POST['date_'] = end_fiscalyear();
		$_SESSION['journal_items']->tran_date = $_POST['date_'];
		
	}
	elseif ($type == 'deposit' || $type == 'payment') {

		if (isset($_SESSION['pay_items']))
		{
			$_SESSION['pay_items']->clear_items();
			unset ($_SESSION['pay_items']);
		}
	
		session_register("pay_items");
	
		if ($type == 'deposit') {
			$_SESSION['pay_items'] = new items_cart(systypes::bank_deposit());
			$_SESSION['page_title'] = _("Bank Account Deposit Entry"); // For next page
		} 
		elseif ($type =='payment') {
			$_SESSION['pay_items'] = new items_cart(systypes::bank_payment());
			$_SESSION['page_title'] = _("Bank Account Payment Entry"); // For next page
		}

		$_POST['date_'] = Today();
		if (!is_date_in_fiscalyear($_POST['date_']))
			$_POST['date_'] = end_fiscalyear();
		$_SESSION['pay_items']->tran_date = $_POST['date_'];
		
	}	
}

//--------------------------------------------------------------------------------------------------

function import_type_list_row($label, $name, $selected=null)
{
	$arr = array( 
		'journalentry'=> "Journal Entry",
		'deposit'=> "Deposit",
		'payment'=> "Payment"
	);
	
	echo "<tr><td>$label</td><td>";
	array_selector($name, $selected, $arr);
	echo "</td></tr>\n";
}

//--------------------------------------------------------------------------------------------------

function get_dimension_id_from_reference($ref)
{
	if ($ref == null || $ref == '')
		return 0;
		
    $sql = "SELECT id FROM ".TB_PREF."dimensions WHERE reference LIKE '$ref'";

	$result = db_query($sql, null);
	
	$row = db_fetch_row($result);
	
	return $row[0];
}

//--------------------------------------------------------------------------------------------------

// If the import button was selected, we'll process the form here.  (If not, skip to actual content below.)
if (isset($_POST['import']))
{
	if (isset($_FILES['imp']) && $_FILES['imp']['name'] != '')
	{
		$filename = $_FILES['imp']['tmp_name'];
		$sep = $_POST['sep'];
		$type = $_POST['type'];
		
		// Open the file
		$fp = @fopen($filename, "r");
		if (!$fp)
			die("Error opening file $filename");

		// Initialize the journal entry / deposit / payment
		init_cart($type);
			
		// Process the import file
		$lines = 0;		
		while ($data = fgetcsv($fp, 4096, $sep))
		{
			// Skip the first line, as it's a header
			if ($lines++ == 0) continue;
			
			// Skip blank lines (which shouldn't happen in a well-formed CSV, but we'll be safe)
			if (count($data) == 1) continue;
						
			// Parse the row of data; Format: accountcode,dimension1,dimension2,amount,memo
			list($code, $dim1_ref, $dim2_ref, $amt, $memo) = $data;
			$dim1 = get_dimension_id_from_reference($dim1_ref);
			$dim2 = get_dimension_id_from_reference($dim2_ref);
			
			if ($type == 'journalentry') {
				// Add to the journal entry
				$_SESSION['journal_items']->add_gl_item($code, $dim1, $dim2, $amt, $memo);
			}
			elseif ($type == 'deposit' || $type == 'payment') {
				if ($type == 'deposit')
					$amt = -$amt;					
				// Add to the deposit/payment
				$_SESSION['pay_items']->add_gl_item($code, $dim1, $dim2, $amt, $memo);
			}
		}
		@fclose($fp);
		
		// Redirect to appropriate page
		if ($type == 'journalentry')
			$next_page = $path_to_root . "/gl/gl_journal.php";
		elseif ($type == 'deposit')
			$next_page = $path_to_root . "/gl/gl_bank.php";
		elseif ($type == 'payment')
			$next_page = $path_to_root . "/gl/gl_bank.php";
		meta_forward($next_page);
		exit;
	}
	else
		display_error("No import file selected");
}

// Begin the UI
include_once($path_to_root . "/includes/ui.inc");

page("Import Journal Entry/Deposit/Payment");

start_form(true);

start_table("$table_style2");

if (!isset($_POST['type']))
	$_POST['type'] = "journalentry";

if (!isset($_POST['sep']))
	$_POST['sep'] = ",";
	
table_section_title("Import Settings");
import_type_list_row("Import Type:", 'type', $_POST['type']);
text_row("Field Separator:", 'sep', $_POST['sep'], 2, 1);
label_row("Import File:", "<input type='file' id='imp' name='imp'>");

end_table(1);

submit_center('import', "Perform Import");

end_form();

end_page();

?>
