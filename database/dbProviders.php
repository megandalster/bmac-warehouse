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

include_once(dirname(__FILE__).'/../domain/Contribution.php');
include_once(dirname(__FILE__).'/dbContributions.php');

function create_dbProviders(){
	$con=connect();
	mysql_query("DROP TABLE IF EXISTS dbProviders");
	$result = mysql_query("CREATE TABLE dbProviders (provider_id TEXT NOT NULL, code TEXT, type TEXT, address TEXT, city TEXT, state TEXT, zip TEXT, county TEXT, 
							contact TEXT, phone VARCHAR(12) NOT NULL, email TEXT, status TEXT, notes TEXT)");
	$con=null;
	if(!$result){
			echo (mysql_error()."Error creating database dbProviders. \n");
			return false;
	}
	return true;
}

function retrieve_dbProviders($provider_id){
	$con=connect();
	$result=mysql_query("SELECT * FROM dbProviders WHERE provider_id  = '".$provider_id."'");
	if(mysql_num_rows($result) !== 1){
			$con=null;
			return false;
	}
	$result_row = mysql_fetch_assoc($result);
	$theProvider = new Provider($result_row['provider_id'], $result_row['code'], $result_row['type'], $result_row['address'], $result_row['city'], $result_row['state'],
						        $result_row['zip'], $result_row['county'], $result_row['contact'], $result_row['phone'], $result_row['email'], $result_row['status'], $result_row['notes']);
	$con=null;
	return $theProvider;
}
function retrieveByCode_dbProviders($code){
	$con=connect();
	$result=mysql_query("SELECT * FROM dbProviders WHERE code  = '".$code."'");
	if(mysql_num_rows($result) !== 1){
			$con=null;
			return false;
	}
	$result_row = mysql_fetch_assoc($result);
	$theProvider = new Provider($result_row['provider_id'], $result_row['code'], $result_row['type'], $result_row['address'], $result_row['city'], $result_row['state'],
						        $result_row['zip'], $result_row['county'], $result_row['contact'], $result_row['phone'], $result_row['email'], $result_row['status'], $result_row['notes']);
	$con=null;
	return $theProvider;
}

function getall_dbProviders(){
	$con=connect();
	$result = mysql_query("SELECT * FROM dbProviders ORDER BY provider_id");
	$theProviders = array();
	while($result_row = mysql_fetch_assoc($result)){
		$aProvider = new Provider($result_row['provider_id'], $result_row['code'], $result_row['type'], $result_row['address'], $result_row['city'], $result_row['state'],
							   $result_row['zip'], $result_row['county'], $result_row['contact'], $result_row['phone'], $result_row['email'], $result_row['status'], $result_row['notes']);
		$theProviders[] = $aProvider;
	}
	$con=null;
	return $theProviders;
}

function getall_dbProvider_ids(){
	$con=connect();
	$result = mysql_query("SELECT provider_id FROM dbProviders ORDER BY provider_id");
	$the_ids = array();
	while($result_row = mysql_fetch_assoc($result)){
		$the_ids[] = $result_row['provider_id'];
	}
	$con=null;
	return $the_ids;
}


// retrieve only those Providers that match the criteria given in the arguments
function getonlythose_dbProviders($provider_id, $type, $status) {
	$con=connect();
	
	$query = "SELECT * FROM dbProviders WHERE provider_id LIKE '%".$provider_id."%'" . 
			 " AND type LIKE '%".$type."%'" . 
			 " AND provider_id LIKE '%".$provider_id."%'"; 		 
	if ($status=="") $query .= " AND status LIKE '%".$status."%'";
	else $query .= " AND status = '".$status."'";
    $query .= " ORDER BY provider_id";
	$result = mysql_query($query);
	$theProviders = array();
		
	while($result_row = mysql_fetch_assoc($result)){
		$aProvider = new Provider($result_row['provider_id'], $result_row['code'], $result_row['type'], $result_row['address'], $result_row['city'], $result_row['state'],
							      $result_row['zip'], $result_row['county'], $result_row['contact'], $result_row['phone'], $result_row['email'], $result_row['status'], $result_row['notes']);
		$theProviders[] = $aProvider;
	}
	$con=null;
	return $theProviders;
}

function getcontributionsby_dbProviders($status, $from, $to) {
	$providers = getonlythose_dbProviders(null, null, $status);
	
	$providers_and_contributions = array();
	
	foreach($providers as $a_provider) {
		$contributions = getonlythose_dbContributions2($a_provider->get_provider_id(), $from, $to);
		if(!empty($contributions)) {
			$providers_and_contributions[] = array("provider" => $a_provider, "contributions" => $contributions); 
		}
	}
	
	return $providers_and_contributions;
}

function insert_dbProviders($Provider){
	if(! $Provider instanceof Provider){
		return false;
	}
	$con=connect();
	$query = "SELECT * FROM dbProviders WHERE provider_id = '" . $Provider->get_provider_id() . "'";
	$result = mysql_query($query);
	if (mysql_num_rows($result) != 0) {
		delete_dbProviders($Provider->get_provider_id());
		$con=connect();
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
		$con=null;
		return false;
	}
	$con=null;
	return true;
}

function delete_dbProviders($provider_id){
	$con=connect();
	$result = mysql_query("DELETE FROM dbProviders WHERE provider_id =\"".$provider_id."\"");
	$con=null;
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