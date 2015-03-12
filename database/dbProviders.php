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
 * dbProviders for BMAC-Warehouse
 * @author David Quennoz
 * @version February 9, 2015
 */

include_once(dirname(__FILE__).'/../domain/Provider.php');
include_once(dirname(__FILE__).'/dbinfo.php');

function create_dbProviders(){
	connect();
	mysql_query("DROP TABLE IF EXISTS dbProviders");
	$result = mysql_query("CREATE TABLE dbProviders (provider_id TEXT NOT NULL, code TEXT, type TEXT, address TEXT, city TEXT, state TEXT, zip TEXT, county TEXT, 
							contact TEXT, phone VARCHAR(12) NOT NULL, email TEXT, status TEXT, notes TEXT)");
	mysql_close();
	if(!$result){
			echo (mysql_error()."Error creating database dbProviders. \n");
			return false;
	}
	return true;
}

function retrieve_dbProviders($provider_id){
	connect();
	$result=mysql_query("SELECT * FROM dbProviders WHERE provider_id  = '".$provider_id."'");
	if(mysql_num_rows($result) !== 1){
			mysql_close();
			return false;
	}
	$result_row = mysql_fetch_assoc($result);
	$theProvider = new Provider($result_row['provider_id'], $result_row['code'], $result_row['type'], $result_row['address'], $result_row['city'], $result_row['state'],
						        $result_row['zip'], $result_row['county'], $result_row['contact'], $result_row['phone'], $result_row['email'], $result_row['status'], $result_row['notes']);
	mysql_close();
	return $theProvider;
}
function retrieveByCode_dbProviders($code){
	connect();
	$result=mysql_query("SELECT * FROM dbProviders WHERE code  = '".$code."'");
	if(mysql_num_rows($result) !== 1){
			mysql_close();
			return false;
	}
	$result_row = mysql_fetch_assoc($result);
	$theProvider = new Provider($result_row['provider_id'], $result_row['code'], $result_row['type'], $result_row['address'], $result_row['city'], $result_row['state'],
						        $result_row['zip'], $result_row['county'], $result_row['contact'], $result_row['phone'], $result_row['email'], $result_row['status'], $result_row['notes']);
	mysql_close();
	return $theProvider;
}

function getall_dbProviders(){
	connect();
	$result = mysql_query("SELECT * FROM dbProviders ORDER BY provider_id");
	$theProviders = array();
	while($result_row = mysql_fetch_assoc($result)){
		$aProvider = new Provider($result_row['provider_id'], $result_row['code'], $result_row['type'], $result_row['address'], $result_row['city'], $result_row['state'],
							   $result_row['zip'], $result_row['county'], $result_row['contact'], $result_row['phone'], $result_row['email'], $result_row['status'], $result_row['notes']);
		$theProviders[] = $aProvider;
	}
	mysql_close();
	return $theProviders;
}


// retrieve only those Providers that match the criteria given in the arguments
function getonlythose_dbProviders($provider_id, $type, $status) {
	connect();
	$query = "SELECT * FROM dbProviders WHERE provider_id LIKE '%".$provider_id."%'" . 
			 " AND type LIKE '%".$type."%'" . 
			 " AND provider_id LIKE '%".$provider_id."%'" ;
    $query .= " ORDER BY provider_id";
	$result = mysql_query($query);
	$theProviders = array();
		
	while($result_row = mysql_fetch_assoc($result)){
		$aProvider = new Provider($result_row['provider_id'], $result_row['code'], $result_row['type'], $result_row['address'], $result_row['city'], $result_row['state'],
							      $result_row['zip'], $result_row['county'], $result_row['contact'], $result_row['phone'], $result_row['email'], $result_row['status'], $result_row['notes']);
		$theProviders[] = $aProvider;
	}
	mysql_close();
	return $theProviders;
}


function insert_dbProviders($Provider){
	if(! $Provider instanceof Provider){
		return false;
	}
	connect();
	$query = "SELECT * FROM dbProviders WHERE provider_id = '" . $Provider->get_provider_id() . "'";
	$result = mysql_query($query);
	if (mysql_num_rows($result) != 0) {
		delete_dbProviders($Provider->get_provider_id());
		connect();
	}
	$query = "INSERT INTO dbProviders VALUES ('".
				$Provider->get_provider_id()."','" .
				$Provider->get_code()."','".
				$Provider->get_type()."','".
				$Provider->get_address()."','".
				$Provider->get_city()."','".
				$Provider->get_state()."','".
				$Provider->get_zip()."','".
				$Provider->get_county()."','".
				$Provider->get_contact()."','".
				$Provider->get_phone()."','".
				$Provider->get_email()."','".
				$Provider->get_status()."','".
				$Provider->get_notes().
	            "');";
	$result = mysql_query($query);
	if (!$result) {
		echo (mysql_error(). " Unable to insert into dbProviders: " . $Provider->get_provider_id(). "\n");
		mysql_close();
		return false;
	}
	mysql_close();
	return true;
}

function delete_dbProviders($provider_id){
	connect();
	$result = mysql_query("DELETE FROM dbProviders WHERE provider_id =\"".$provider_id."\"");
	mysql_close();
	if (!$result) {
		echo (mysql_error()." unable to delete from dbProviders: ".$provider_id);
		return false;
	}
	return true;
}

function update_dbProviders($Provider){
	if (! $Provider instanceof Provider) {
		echo ("Invalid argument for update_dbProviders function call");
		return false;
	}
	if (delete_dbProviders($Provider->get_provider_id()))
	return insert_dbProviders($Provider);
	else {
		echo (mysql_error()."unable to update dbProvider table: ".$Provider->get_provider_id());
		return false;
	}
}

?>