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
include_once(dirname(__FILE__).'/../domain/Shipment.php');
include_once(dirname(__FILE__).'/dbShipments.php');

function retrieve_dbCustomers($customer_id){
	$con=connect();
	$query="SELECT * FROM dbCustomers WHERE customer_id  = '".$customer_id."'";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not retrieve customer with id = ".$customer_id. " ". $p->getMessage());
	}
	if($result->rowCount()!== 1){
	    $con=null;
	    return false;
	}
	$result_row = $result->fetch(PDO::FETCH_ASSOC);
	$theVol = new Customer($result_row['customer_id'], $result_row['code'], $result_row['address'], $result_row['city'], $result_row['state'], $result_row['zip'], $result_row['county'],
							$result_row['contact'], $result_row['phone'], $result_row['email'], $result_row['status'], $result_row['notes']);
	$con=null;
	return $theVol;
}
function retrieveByCode_dbCustomers($code){
	$con=connect();
	$query="SELECT * FROM dbCustomers WHERE code  = '".$code."'";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not retrieve customer with code = ".$code. " ". $p->getMessage());
	}
	if($result->rowCount()!== 1){
	    $con=null;
	    return false;
	}
	$result_row = $result->fetch(PDO::FETCH_ASSOC);
	$theVol = new Customer($result_row['customer_id'], $result_row['code'], $result_row['address'], $result_row['city'], $result_row['state'], $result_row['zip'], $result_row['county'],
							$result_row['contact'], $result_row['phone'], $result_row['email'], $result_row['status'], $result_row['notes']);
	$con=null;
	return $theVol;
}

function getall_dbCustomers(){
	$con=connect();
	$query = "SELECT * FROM dbCustomers ORDER BY city";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not retrieve from dbCustomers ". $p->getMessage());
	}
	$theVols = array();
	while($result_row = $result->fetch(PDO::FETCH_ASSOC)){
		$theVol = new Customer($result_row['customer_id'], $result_row['code'], $result_row['address'], $result_row['city'], $result_row['state'], $result_row['zip'], $result_row['county'],
							$result_row['contact'], $result_row['phone'], $result_row['email'], $result_row['status'], $result_row['notes']);
		$theVols[] = $theVol;
	}
	$con=null;
	return $theVols;
}

function getall_dbCustomer_ids(){
	$con=connect();
	$query = "SELECT customer_id FROM dbCustomers ORDER BY customer_id";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not retrieve from dbCustomers ". $p->getMessage());
	}
	$the_ids = array();
	while($result_row = $result->fetch(PDO::FETCH_ASSOC)){
		$the_ids[] = $result_row['customer_id'];
	}
	$con=null;
	return $the_ids;
}

// retrieve only those Customers that match the criteria given in the arguments
function getonlythose_dbCustomers($status, $name) {
	$con=connect();
	$query = "SELECT * FROM dbCustomers WHERE customer_id LIKE '%".$name."%'" ;
	if ($status!="") $query .= " AND status = '".$status."'";
    $query .= " ORDER BY customer_id";
    try {
        $result = $con->query($query);
    } catch (PDOException $p) {
        die("Could not retrieve from dbCustomers with id, status = ".$name . " ". $status. " ". $p->getMessage());
    }
	$theCustomers = array();	
	while($result_row = $result->fetch(PDO::FETCH_ASSOC)){
		$theCustomer = new Customer($result_row['customer_id'], $result_row['code'], $result_row['address'], $result_row['city'], $result_row['state'], $result_row['zip'], $result_row['county'],
							$result_row['contact'], $result_row['phone'], $result_row['email'], $result_row['status'], $result_row['notes']);
		$theCustomers[] = $theCustomer;
	}
	$con=null;
	return $theCustomers;
}

function getshipmentsby_dbCustomers($status, $from, $to, $funds_source) {
	$customers = getonlythose_dbCustomers($status, "");
	
	$customers_and_shipments = array();
	
	foreach($customers as $a_customer) {
		$shipments = getonlythose_dbShipments2($a_customer->get_customer_id(), $from, $to, $funds_source);
		if(!empty($shipments)) {
			$customers_and_shipments[] = array("customer" => $a_customer, "shipments" => $shipments); 
		}
	}
	
	return $customers_and_shipments;
}

function insert_dbCustomers($Customer){
	if(! $Customer instanceof Customer){
		return false;
	}
	$con=connect();
	$query = "SELECT * FROM dbCustomers WHERE customer_id = '" . $Customer->get_customer_id() . "'";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not retrieve dbCustomers ". $p->getMessage());
	}
	if($result->rowCount()!== 0){
	    delete_dbCustomers ($Customer->get_customer_id());
	    $con=connect();
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
	try {
		$result = $con->query($query);
	} catch (PDOException $p) {
		die("Could not insert customer ".$p->getMessage());
	}
	if (!$result) {
		echo ("Unable to insert into dbCustomers: " . $Customer->get_receive_date(). "\n");
		$con=null;
		return false;
	}
	$con=null;
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
	$con=connect();
	$query = "DELETE FROM dbCustomers WHERE customer_id =\"".$customer_id."\"";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not delete customer ".$p->getMessage());
	}
	$con=null;
	if (!$result) {
	    echo ("Unable to delete from dbCustomers: ".$customer_id);
	    return false;
	}
	return true;
}

// retrieve only those Customers that match the given status
function getonlythosestatus_dbCustomers($status) {
	$con=connect();
	$query = "SELECT * FROM dbCustomers WHERE status LIKE '%".$status."%'" ;
	$query .= " ORDER BY customer_id";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not retrieve from dbCustomers with status = ". $status. " ". $p->getMessage());
	}
	$theCustomers = array();
		
	while($result_row = $result->fetch(PDO::FETCH_ASSOC)){
		$theCustomer = new Customer($result_row['customer_id'], $result_row['code'], $result_row['address'], $result_row['city'], $result_row['state'], $result_row['zip'], $result_row['county'],
							$result_row['contact'], $result_row['phone'], $result_row['email'], $result_row['status'], $result_row['notes']);
		$theCustomers[] = $theCustomer;
	}
	$con=null;
	return $theCustomers;
}

?>