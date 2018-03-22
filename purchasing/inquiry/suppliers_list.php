<?php
/**********************************************************************
    Copyright (C) FrontAccounting, LLC.
	Released under the terms of the GNU General Public License, GPL, 
	as published by the Free Software Foundation, either version 3 
	of the License, or (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
    See the License here <http://www.gnu.org/licenses/gpl-3.0.html>.
***********************************************************************/
/**********************************************************************
  Page for searching supplier list and select it to supplier selection
  in pages that have the supplier dropdown lists.
  Author: bogeyman2007 from Discussion Forum. Modified by Joe Hunt
***********************************************************************/
$page_security = "SA_PURCHASEORDER";
$path_to_root = "../..";
include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/purchasing/includes/db/suppliers_db.inc");

$mode = get_company_pref('no_supplier_list');
if ($mode != 0)
	$js = get_js_set_combo_item();
else
	$js = get_js_select_combo_item();

page(_($help_context = "Suppliers"), true, false, "", $js);

if(get_post("search")) {
  $Ajax->activate("supplier_tbl");
}

start_form(false, false, $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING']);

start_table(TABLESTYLE_NOBORDER);

start_row();

text_cells(_("Supplier"), "supplier");
submit_cells("search", _("Search"), "", _("Search suppliers"), "default");

end_row();

end_table();

end_form();
div_start("supplier_tbl");

start_table(TABLESTYLE);

$th = array("", _("Supplier"), _("Short Name"), _("Address"), _("Tax ID"));

table_header($th);

$k = 0;
$name = $_GET["client_id"];
$result = get_suppliers_search(get_post("supplier"));
while ($myrow = db_fetch_assoc($result)) {
	alt_table_row_color($k);
	$value = $myrow['supplier_id'];
	if ($mode != 0) {
		$text = $myrow['supp_name'];
  		ahref_cell(_("Select"), 'javascript:void(0)', '', 'setComboItem(window.opener.document, "'.$name.'",  "'.$value.'", "'.$text.'")');
	}
	else {
  		ahref_cell(_("Select"), 'javascript:void(0)', '', 'selectComboItem(window.opener.document, "'.$name.'", "'.$value.'")');
	}
  	label_cell($myrow["supp_name"]);
  	label_cell($myrow["supp_ref"]);
  	label_cell($myrow["address"]);
  	label_cell($myrow["gst_no"]);
	end_row();
}

end_table(1);
div_end();
end_page(true);
