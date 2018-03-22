<?php

 require "init.php";
 
 $stock_id="1";
$category_id=1;
$tax_type_id=1;
$description="Boda boda service";
$long_description="N/A";
$units="each";
$mb_flag="D";
$sales_account="4010"; 
$cogs_account="5010";
$inventory_account="1510";
$adjustment_account="5040";
$wip_account="1530";
$dimension_id=0;
$dimension2_id=0;
$purchase_cost=0.0;
$material_cost=0.0;
$labour_cost=0.0;
$overhead_cost=0.0;
$inactive=0;

$editable=0;
$depreciation_method="S";
$depreciation_rate=0.0;
$depreciation_factor=0.0;
$depreciation_start="2018-01-01";
$depreciation_date="2018-01-01";
$fa_class_id="";
 

$item_code=1;
$stock_id=$stock_id;
$description=$description; 
$category_id=$category_id;
$quantity =1;
$is_foreign=0;
$inactive=0;

$loc_code='DEF';
$stock_id=$item_code;
$reorder_level=0;

$sql_check="select stock_id, category_id,tax_type_id,description,long_description,units,mb_flag,sales_account,cogs_account,inventory_account,adjustment_account,wip_account,dimension_id,dimension2_id,purchase_cost,material_cost,labour_cost,overhead_cost,inactive,no_sale,no_purchase,editable,depreciation_method,depreciation_rate,depreciation_factor,depreciation_start,depreciation_date,fa_class_id from stock_master;";
	$result = mysqli_query($con,$sql_check);
	if(mysqli_num_rows($result) >=0 )  
	 { 
	$sql_query="Insert into stock_master(stock_id,category_id,tax_type_id,description,long_description,units,mb_flag,sales_account,cogs_account,inventory_account,adjustment_account,wip_account,dimension_id,dimension2_id,purchase_cost,material_cost,labour_cost,overhead_cost,inactive,editable,depreciation_method,depreciation_rate,depreciation_factor,depreciation_start,depreciation_date,fa_class_id )values('$stock_id','$category_id','$tax_type_id','$description','$long_description','$units','$mb_flag','$sales_account','$cogs_account','$inventory_account','$adjustment_account','$wip_account','$dimension_id','$dimension2_id','$purchase_cost','$material_cost','$labour_cost','$overhead_cost','$inactive','$editable','$depreciation_method','$depreciation_rate','$depreciation_factor','$depreciation_start','$depreciation_date','$fa_class_id');";
	mysqli_query($con, $sql_query) or die (mysqli_error($con));
	mysqli_close($con); 
	$json['reply']="Record Saved Succesfully";
		echo json_encode($json);
	 }
 		else  
	 {   
	 $json['reply'] = "Error";  
	 echo json_encode($json);
		mysqli_close($con);
	 }
	 
	 require "init.php";

$sql_check="select id,item_code,stock_id,description,category_id,quantity,is_foreign,inactive from item_codes;";
	$result = mysqli_query($con,$sql_check);
	if(mysqli_num_rows($result) >=0 )  
	 { 
	$sql_query="Insert into item_codes(item_code,stock_id,description,category_id,quantity,is_foreign,inactive)	 values('$item_code','$stock_id','$description','$category_id','$quantity','$is_foreign','$inactive');";
	mysqli_query($con, $sql_query) or die (mysqli_error($con));
	mysqli_close($con); 
	$json['reply']="Record Saved Succesfully";
		echo json_encode($json);
	 }
 		else  
	 {   
	 $json['reply'] = "Error";  
	 echo json_encode($json);
		mysqli_close($con);
	 }
	 
	 

	 require "init.php";
	 $sql_check="select loc_code,stock_id,reorder_level from loc_stock;";
	$result = mysqli_query($con,$sql_check);
	if(mysqli_num_rows($result) >=0 )  
	 { 
	$sql_query="Insert into loc_stock(loc_code,stock_id,reorder_level )	values('$loc_code','$stock_id','$reorder_level');";
	mysqli_query($con, $sql_query) or die (mysqli_error($con));
	mysqli_close($con); 
	$json['reply']="Record Saved Succesfully";
		echo json_encode($json);
	 }
 		else  
	 {   
	 $json['reply'] = "Error";  
	 echo json_encode($json);
		mysqli_close($con);
	 }

?>