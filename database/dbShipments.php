<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker.  This program is part of BMAC-Warehouse, which is free software. It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/**
 * dbShipments for BMAC-Warehouse
 * @author Dylan Martin
 * @version 13 February 2015
 */

include_once(dirname(__FILE__).'/../domain/Shipment.php');
include_once(dirname(__FILE__).'/dbinfo.php');

function create_dbShipments(){
	connect();
	mysql_query("DROP TABLE IF EXISTS dbShipments");
	$result = mysql_query("CREATE TABLE dbShipments (customer_id TEXT NOT NULL, funds_source TEXT, 
							ship_date TEXT, ship_via TEXT, ship_items TEXT, ship_rate TEXT, 
							total_weight TEXT, total_price TEXT, invoice_date TEXT, invoice_no TEXT, 
							notes TEXT)");
	mysql_close();
	if(!$result){
		echo (mysql_error()."Error creating database dbShipments. \n");
		return false;
	}
	return true;
}

function retrieve_dbShipments($customer_id){
	connect();
	$result=mysql_query("SELECT * FROM dbShipments WHERE customer_id  = '".$customer_id."'");
	if(mysql_num_rows($result) !== 1){
		mysql_close();
		return false;
	}
	$result_row = mysql_fetch_assoc($result);
	$theShipment = new Shipment($result_row['customer_id'], $result_row['funds_source'], $result_row['ship_date'], $result_row['ship_via'], $result_row['ship_items'], $result_row['ship_rate'],
							$result_row['total_weight'], $result_row['total_price'], $result_row['invoice_date'], $result_row['invoice_no'], $result_row['notes']);
	mysql_close();
	return $theShipment;
	
}


function getall_dbShipments(){
	connect();
	$result = mysql_query("SELECT * FROM dbShipments ORDER BY funds_source");
	$theVols = array();
	while($result_row = mysql_fetch_assoc($result)){
		$theVol = new Shipment($result_row['customer_id'], $result_row['funds_source'], $result_row['ship_date'], $result_row['ship_via'], $result_row['ship_items'], $result_row['ship_rate'],
		$result_row['total_weight'], $result_row['total_price'], $result_row['invoice_date'], $result_row['invoice_no'], $result_row['notes']);	
		$theVols[] = $theVol;
	}
	mysql_close();
	return $theVols;
}


function getonlythose_dbShipments($funds_source, $ship_via, $total_weight) {
	connect();
	$query = "SELECT * FROM dbShipments WHERE funds_source LIKE '%".$funds_source."%'" .
			 " AND ship_via LIKE '%".$ship_via."%'" . 
			 " AND total_weight LIKE '%".$total_weight."%'" ;
	$query .= " ORDER BY total_weight";
	$result = mysql_query($query);
	$theShipments = array();

	while($result_row = mysql_fetch_assoc($result)){
		$theShipment = new Shipment($result_row['customer_id'], $result_row['funds_source'], $result_row['ship_date'], $result_row['ship_via'], $result_row['ship_items'], $result_row['ship_rate'],
		$result_row['total_weight'], $result_row['total_price'], $result_row['invoice_date'], $result_row['invoice_no'], $result_row['notes']);	
		$theShipments[] = $theShipment;
	}
	mysql_close();
	return $theShipments;
}

function insert_dbShipments($Shipment){
	if(! $Shipment instanceof Shipment){
		return false;
	}
	connect();
	$query = "SELECT * FROM dbShipments WHERE customer_id = '" . $Shipment->get_customer_id() . "'";
	$result = mysql_query($query);
	if (mysql_num_rows($result) != 0) {
		delete_dbShipments ($Shipment->get_customer_id());
		connect();
	}
	$query = "INSERT INTO dbShipments VALUES ('".
				$Shipment->get_customer_id()."','" .
				$Shipment->get_funds_source()."','".
				$Shipment->get_ship_date()."','".
				$Shipment->get_ship_via()."','".
				implode(',',$Shipment->get_ship_items()). "','".
				$Shipment->get_ship_rate()."','".
				$Shipment->get_total_weight()."','".
				$Shipment->get_total_price()."','".
				$Shipment->get_invoice_date()."','".
				$Shipment->get_invoice_no()."','".
				$Shipment->get_notes().
	            "');";
	$result = mysql_query($query);
	if (!$result) {
		echo (mysql_error(). " Unable to insert into dbShipments: " . $Shipment->get_customer_id(). "\n");
		mysql_close();
		return false;
	}
	mysql_close();
	return true;

}

function update_dbShipments($Shipment){
	if (! $Shipment instanceof Shipment) {
		echo ("Invalid argument for update_dbShipment function call");
		return false;
	}
	if (delete_dbShipments($Shipment->get_customer_id()))
	return insert_dbShipments($Shipment);
	else {
		echo (mysql_error()."unable to update dbShipments table: ".$Shipment->get_customer_id());
		return false;
	}
}

function delete_dbShipments($customer_id){
	connect();
	$result = mysql_query("DELETE FROM dbShipments WHERE customer_id =\"".$customer_id."\"");
	mysql_close();
	if (!$result) {
		echo (mysql_error()." unable to delete from dbShipments: ".$customer_id);
		return false;
	}
	return true;
}

?>