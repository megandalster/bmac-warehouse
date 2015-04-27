<?php
/*
 * Copyright 2014 by ... and Allen Tucker
 * This program is part of BMAC-Warehouse, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/**
 * dbCustomers for BMAC-Warehouse
 * @author Moustafa ElBadry
 * @version February 10, 2015
 */

include_once(dirname(__FILE__).'/../domain/Customer.php');
include_once(dirname(__FILE__).'/dbinfo.php');

function create_dbCustomers(){
	connect();
	mysql_query("DROP TABLE IF EXISTS dbCustomers");
	$result = mysql_query("CREATE TABLE dbCustomers (customer_id TEXT NOT NULL, code text, address TEXT, city TEXT, state TEXT, zip TEXT, county TEXT, contact TEXT, 
							phone VARCHAR(12) NOT NULL, email TEXT, status TEXT, notes TEXT)");
	mysql_close();
	if(!$result){
			echo (mysql_error()."Error creating database dbCustomers. \n");
			return false;
	}
	return true;
}

function retrieve_dbCustomers($customer_id){
	connect();
	$result=mysql_query("SELECT * FROM dbCustomers WHERE customer_id  = '".$customer_id."'");
	if(mysql_num_rows($result) !== 1){
			mysql_close();
			return false;
	}
	$result_row = mysql_fetch_assoc($result);
	$theVol = new Customer($result_row['customer_id'], $result_row['code'], $result_row['address'], $result_row['city'], $result_row['state'], $result_row['zip'], $result_row['county'],
							$result_row['contact'], $result_row['phone'], $result_row['email'], $result_row['status'], $result_row['notes']);
	mysql_close();
	return $theVol;
}
function retrieveByCode_dbCustomers($code){
	connect();
	$result=mysql_query("SELECT * FROM dbCustomers WHERE code  = '".$code."'");
	if(mysql_num_rows($result) !== 1){
			mysql_close();
			return false;
	}
	$result_row = mysql_fetch_assoc($result);
	$theVol = new Customer($result_row['customer_id'], $result_row['code'], $result_row['address'], $result_row['city'], $result_row['state'], $result_row['zip'], $result_row['county'],
							$result_row['contact'], $result_row['phone'], $result_row['email'], $result_row['status'], $result_row['notes']);
	mysql_close();
	return $theVol;
}

function getall_dbCustomers(){
	connect();
	$result = mysql_query("SELECT * FROM dbCustomers ORDER BY city");
	$theVols = array();
	while($result_row = mysql_fetch_assoc($result)){
		$theVol = new Customer($result_row['customer_id'], $result_row['code'], $result_row['address'], $result_row['city'], $result_row['state'], $result_row['zip'], $result_row['county'],
							$result_row['contact'], $result_row['phone'], $result_row['email'], $result_row['status'], $result_row['notes']);
		$theVols[] = $theVol;
	}
	mysql_close();
	return $theVols;
}

function getall_dbCustomer_ids(){
	connect();
	$result = mysql_query("SELECT customer_id FROM dbCustomers ORDER BY customer_id");
	$the_ids = array();
	while($result_row = mysql_fetch_assoc($result)){
		$the_ids[] = $result_row['customer_id'];
	}
	mysql_close();
	return $the_ids;
}

// retrieve only those Customers that match the criteria given in the arguments
function getonlythose_dbCustomers($status, $name) {
	connect();
	$query = "SELECT * FROM dbCustomers WHERE customer_id LIKE '%".$name."%'" ;
	if ($status=="") $query .= " AND status LIKE '%".$status."%'";
	else $query .= " AND status = '".$status."'";
    $query .= " ORDER BY customer_id";
	$result = mysql_query($query);
	$theCustomers = array();
		
	while($result_row = mysql_fetch_assoc($result)){
		$theCustomer = new Customer($result_row['customer_id'], $result_row['code'], $result_row['address'], $result_row['city'], $result_row['state'], $result_row['zip'], $result_row['county'],
							$result_row['contact'], $result_row['phone'], $result_row['email'], $result_row['status'], $result_row['notes']);
		$theCustomers[] = $theCustomer;
	}
	mysql_close();
	return $theCustomers;
}

function insert_dbCustomers($Customer){
	if(! $Customer instanceof Customer){
		return false;
	}
	connect();
	$query = "SELECT * FROM dbCustomers WHERE customer_id = '" . $Customer->get_customer_id() . "'";
	$result = mysql_query($query);
	if (mysql_num_rows($result) != 0) {
		delete_dbCustomers ($Customer->get_customer_id());
		connect();
	}
	$query = "INSERT INTO dbCustomers VALUES ('".
				$Customer->get_customer_id()."','" .
				$Customer->get_code()."','".
				$Customer->get_address()."','".
				$Customer->get_city()."','".
				$Customer->get_state()."','".
				$Customer->get_zip()."','".
				$Customer->get_county()."','".
				$Customer->get_contact()."','".
				$Customer->get_phone()."','".
				$Customer->get_email()."','".
				$Customer->get_status()."','".
				$Customer->get_notes().
	            "');";
	$result = mysql_query($query);
	if (!$result) {
		echo (mysql_error(). " Unable to insert into dbCustomers: " . $Customer->get_customer_id(). "\n");
		mysql_close();
		return false;
	}
	mysql_close();
	return true;
	
}

function update_dbCustomers($Customer){
	if (! $Customer instanceof Customer) {
		echo ("Invalid argument for update_dbCustomers function call");
		return false;
	}
	if (delete_dbCustomers($Customer->get_customer_id()))
	return insert_dbCustomers($Customer);
	else {
		echo (mysql_error()."unable to update dbCustomers table: ".$Customer->get_customer_id());
		return false;
	}
}

function delete_dbCustomers($customer_id){
	connect();
	$result = mysql_query("DELETE FROM dbCustomers WHERE customer_id =\"".$customer_id."\"");
	mysql_close();
	if (!$result) {
		echo (mysql_error()." unable to delete from dbCustomers: ".$customer_id);
		return false;
	}
	return true;
}

// retrieve only those Customers that match the given status
function getonlythosestatus_dbCustomers($status) {
	connect();
	$query = "SELECT * FROM dbCustomers WHERE status LIKE '%".$status."%'" ;
	$query .= " ORDER BY customer_id";
	$result = mysql_query($query);
	$theCustomers = array();
		
	while($result_row = mysql_fetch_assoc($result)){
		$theCustomer = new Customer($result_row['customer_id'], $result_row['code'], $result_row['address'], $result_row['city'], $result_row['state'], $result_row['zip'], $result_row['county'],
							$result_row['contact'], $result_row['phone'], $result_row['email'], $result_row['status'], $result_row['notes']);
		$theCustomers[] = $theCustomer;
	}
	mysql_close();
	return $theCustomers;
}

?>