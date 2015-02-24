<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker. This program is part of BMAC-Warehouse, which is 
 * free software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 * 
 */


/**
 * dbProducts for BMAC-Warehouse
 * @author Noah Jensen
 * @version February 9, 2015
 */

include_once(dirname(__FILE__).'/../domain/Product.php');
include_once(dirname(__FILE__).'/dbinfo.php');

function create_dbProducts(){
	connect();
	mysql_query("DROP TABLE IF EXISTS dbProducts");
	$result = mysql_query("CREATE TABLE dbProducts (product_id TEXT NOT NULL, product_code TEXT, funding_source TEXT, unit_weight TEXT, unit_price TEXT, initial_date TEXT, initial_stock TEXT, 
							minimum_stock TEXT, history TEXT, current_stock TEXT, inventory_date TEXT, status TEXT, notes TEXT)");
	mysql_close();
	if(!$result){
			echo (mysql_error()."Error creating database dbProducts. \n");
			return false;
	}
	return true;
}

function retrieve_dbProducts($product_id){
	connect();
	$result=mysql_query("SELECT * FROM dbProducts WHERE product_id  = '".$product_id."'");
	if(mysql_num_rows($result) !== 1){
			mysql_close();
			return false;
	}
	$result_row = mysql_fetch_assoc($result);
	$theProd = new Product($result_row['product_id'],$result_row['product_code'], $result_row['funding_source'], $result_row['unit_weight'], $result_row['unit_price'], $result_row['initial_date'],
							$result_row['initial_stock'], $result_row['minimum_stock'], $result_row['history'], $result_row['current_stock'], $result_row['inventory_date'], $result_row['status'], 
							$result_row['notes']);
	mysql_close();
	return $theProd;
}
function retrieveByCode_dbProducts($product_code){
	connect();
	$result=mysql_query("SELECT * FROM dbProducts WHERE product_code  = '".$product_code."'");
	if(mysql_num_rows($result) !== 1){
			mysql_close();
			return false;
	}
	$result_row = mysql_fetch_assoc($result);
	$theProd = new Product($result_row['product_id'],$result_row['product_code'], $result_row['funding_source'], $result_row['unit_weight'], $result_row['unit_price'], $result_row['initial_date'],
							$result_row['initial_stock'], $result_row['minimum_stock'], $result_row['history'], $result_row['current_stock'], $result_row['inventory_date'], $result_row['status'], 
							$result_row['notes']);
	mysql_close();
	return $theProd;
}


function getall_dbProducts(){
	connect();
	$result = mysql_query("SELECT * FROM dbProducts ORDER BY product_id");
	$theProds = array();
	while($result_row = mysql_fetch_assoc($result)){
		$theProd = new Product($result_row['product_id'],$result_row['product_code'], $result_row['funding_source'], $result_row['unit_weight'], $result_row['unit_price'], $result_row['initial_date'],
							$result_row['initial_stock'], $result_row['minimum_stock'], $result_row['history'], $result_row['current_stock'], $result_row['inventory_date'], $result_row['status'],
							$result_row['notes']);
		$theProds[] = $theProd;
	}
	mysql_close();
	return $theProds;
}

function getall_dbProduct_ids(){
	connect();
	$result = mysql_query("SELECT product_id FROM dbProducts ORDER BY product_id");
	$the_ids = array();
	while($result_row = mysql_fetch_assoc($result)){
		$the_ids[] = $result_row['product_id'];
	}
	mysql_close();
	return $the_ids;
}

// retrieve only those Products that match the criteria given in the arguments
function getonlythose_dbProducts($product_id, $funding_source, $status) {
	connect();
	$query = "SELECT * FROM dbProducts WHERE type LIKE '%".$product_id."%'" . 
			 " AND status LIKE '%".$funding_source."%'" . 
			 "  AND status LIKE '%".$status."%'" ;
    $query .= " ORDER BY last_name";
	$result = mysql_query($query);
	$theProducts = array();
		
	while($result_row = mysql_fetch_assoc($result)){
		$theProduct = new Product($result_row['product_id'],$result_row['product_code'], $result_row['funding_source'], $result_row['unit_weight'], $result_row['unit_price'], $result_row['initial_date'],
							$result_row['initial_stock'], $result_row['minimum_stock'], $result_row['history'], $result_row['current_stock'], $result_row['inventory_date'], $result_row['status'],
							$result_row['notes']);
		$theProducts[] = $theProduct;
	}
	mysql_close();
	return $theProducts;
}

function insert_dbProducts($Product){
	if(! $Product instanceof Product){
		return false;
	}
	connect();
	$query = "SELECT * FROM dbProducts WHERE product_id = '" . $Product->get_product_id() . "'";
	$result = mysql_query($query);
	if (mysql_num_rows($result) != 0) {
		delete_dbProducts ($Product->get_product_id());
		connect();
	}
	$query = "INSERT INTO dbProducts VALUES ('".
				$Product->get_product_id()."','" .
				$Product->get_product_code()."','".
				$Product->get_funding_source()."','".
				$Product->get_unit_weight()."','".
				$Product->get_unit_price()."','".
				$Product->get_initial_date()."','".
				$Product->get_initial_stock()."','".
				$Product->get_minimum_stock()."','".
				implode(",",$Product->get_history())."','".
				$Product->get_current_stock()."','".
				$Product->get_inventory_date()."','".
				$Product->get_status()."','".
				$Product->get_notes()."');";
	$result = mysql_query($query);
	if (!$result) {
		echo (mysql_error(). " Unable to insert into dbProducts: " . $Product->get_product_id(). "\n");
		mysql_close();
		return false;
	}
	mysql_close();
	return true;
	
}

function update_dbProducts($Product){
	if (! $Product instanceof Product) {
		echo ("Invalid argument for update_dbProduct function call");
		return false;
	}
	if (delete_dbProducts($Product->get_product_id()))
	return insert_dbProducts($Product);
	else {
		echo (mysql_error()."unable to update dbProducts table: ".$Product->get_product_id());
		return false;
	}
}

function delete_dbProducts($product_id){
	connect();
	$result = mysql_query("DELETE FROM dbProducts WHERE product_id =\"".$product_id."\"");
	mysql_close();
	if (!$result) {
		echo (mysql_error()." unable to delete from dbProducts: ".$product_id);
		return false;
	}
	return true;
}

?>