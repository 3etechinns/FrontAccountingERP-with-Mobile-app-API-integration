<?php
 require "init.php"; 

$ref="Anto";
$name="Anthony";
$name2="test";
$address="30100";
$phone="0722199199";
$phone2="019";
$fax="null";
$email="budaboss@gmail.com";
$lang="null";
$notes="null";

$debtor_no=1;
$br_name=$name;
$branch_ref=$ref;
$br_address="N/A";
$area =1;
$salesman=1;
$default_location='DEF'; 
$tax_group_id=1;
$sales_discount_account=4510;
$receivables_account=1200;
$payment_discount_account=4500;
$default_ship_via=1;
$br_post_address="NA";

$group_no=0;
 
$inactive=0;


$name=$name ;
$debtor_ref=$ref;
$address=$address;

$curr_code="USD";
$sales_type=1;
$dimension_id=0;
$dimension2_id=0;
$credit_status=1;
$payment_terms=4;
$discount=0;
$pymt_discount=0; 
$credit_limit=1000;
$notes=$notes;
$inactive=0;
 
 	$sql_check="select id,ref,name,name2,address,phone,phone2,fax,email,lang,notes from crm_persons;";
	$result = mysqli_query($con,$sql_check);
	if(mysqli_num_rows($result) >=0 )  
	 { 
	$sql_query = "Insert into crm_persons(ref,name,name2,address,phone,phone2,fax,email,lang,notes) values('$ref','$name','$name2','$address','$phone','$phone2','$fax','$email','$lang','$notes');";
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
$sql_check2="select debtor_no,br_name,branch_ref,br_address,area,salesman,default_location,tax_group_id,sales_discount_account,receivables_account,payment_discount_account,default_ship_via,br_post_address,group_no,inactive from cust_branch;";
	$result2 = mysqli_query($con,$sql_check2);
	if(mysqli_num_rows($result2) >=0 )  
	 { 
$sql_query2 = "Insert into cust_branch(debtor_no,br_name,branch_ref,br_address,area,salesman,default_location,tax_group_id,sales_discount_account,receivables_account,payment_discount_account,default_ship_via,br_post_address,group_no,notes,inactive) values('$debtor_no','$br_name','$branch_ref','$br_address','$area','$salesman','$default_location','$tax_group_id','$sales_discount_account','$receivables_account','$payment_discount_account','$default_ship_via','$br_post_address','$group_no','$notes','$inactive');";
	mysqli_query($con, $sql_query2) or die (mysqli_error($con));
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
$sql_check3="select name,debtor_ref,address,curr_code,sales_type,dimension_id,dimension2_id,credit_status,payment_terms,discount,pymt_discount,credit_limit,notes,inactive from debtors_master;";
	$result3 = mysqli_query($con,$sql_check3);
	if(mysqli_num_rows($result3) >=0 )  
	 { 
$sql_query3 = "Insert into debtors_master(name,debtor_ref,address,curr_code,sales_type,dimension_id,dimension2_id,credit_status,payment_terms,discount,pymt_discount,credit_limit,notes,inactive) values('$name','$debtor_ref','$address','$curr_code','$sales_type','$dimension_id','$dimension2_id','$credit_status','$payment_terms','$discount','$pymt_discount','$credit_limit','$notes','$inactive');";
	mysqli_query($con, $sql_query3) or die (mysqli_error($con));
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
		
	 /*
	 
	 
	 

debtor_no,br_name,branch_ref,br_address,area,salesman,default_location,tax_group_id,sales_account,sales_discount_account,receivables_account,payment_discount_account,default_ship_via,br_post_address,group_no,notes,bank_account,inactive*/
?>