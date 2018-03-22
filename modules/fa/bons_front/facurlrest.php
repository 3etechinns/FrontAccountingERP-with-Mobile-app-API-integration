<?php
// FrontAccounting Bridge REST Test Script
// Author: Ap.Muthu
// Website: www.apmuthu.com
// Release Date: 2012-11-28

include_once "fabridge.php";

$method = isset($_GET['m']) ? $_GET['m'] : 'g'; // g, p, t, d => GET, POST, PUT, DELETE
$action = isset($_GET['a']) ? $_GET['a'] : '';
$record = isset($_GET['r']) ? $_GET['r'] : '';
$filter = isset($_GET['f']) ? $_GET['f'] : false;

/*Sample Data for POST
$data = json_encode(array(
'firstName'=> 'John',
'lastName'=> 'Doe'
));
*/


$output = fa_bridge($method, $action, $record, $filter, $data);
echo print_r($output, true);

?>
