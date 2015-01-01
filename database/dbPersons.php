<?php
/*
 * Copyright 2014 by Allen Tucker
 * This program is part of BMAC-Warehouse, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/**
 * dbPersons for BMAC-Warehouse
 * @author Allen Tucker
 * @version December 29, 2014
 */

include_once(dirname(__FILE__).'/../domain/Person.php');
include_once(dirname(__FILE__).'/dbinfo.php');

function create_dbPersons(){
	connect();
	mysql_query("DROP TABLE IF EXISTS dbPersons");
	$result = mysql_query("CREATE TABLE dbPersons (id TEXT NOT NULL, last_name TEXT, first_name TEXT, address TEXT, city TEXT, state TEXT, zip TEXT, 
							phone1 VARCHAR(12) NOT NULL, phone2 VARCHAR(12), email TEXT, type TEXT, status TEXT, notes TEXT, password TEXT)");
	mysql_close();
	if(!$result){
			echo (mysql_error()."Error creating database dbPersons. \n");
			return false;
	}
	return true;
}

function retrieve_dbPersons($id){
	connect();
	$result=mysql_query("SELECT * FROM dbPersons WHERE id  = '".$id."'");
	if(mysql_num_rows($result) !== 1){
			mysql_close();
			return false;
	}
	$result_row = mysql_fetch_assoc($result);
	$theVol = new Person($result_row['last_name'], $result_row['first_name'], $result_row['address'], $result_row['city'], $result_row['state'],
							$result_row['zip'], $result_row['phone1'], $result_row['phone2'], $result_row['email'], $result_row['type'], $result_row['status'],
							$result_row['notes'], $result_row['password']);
	mysql_close();
	return $theVol;
}

function getall_dbPersons(){
	connect();
	$result = mysql_query("SELECT * FROM dbPersons ORDER BY last_name");
	$theVols = array();
	while($result_row = mysql_fetch_assoc($result)){
		$theVol = new Person($result_row['last_name'], $result_row['first_name'], $result_row['address'], $result_row['city'], $result_row['state'],
							$result_row['zip'], $result_row['phone1'], $result_row['phone2'], $result_row['email'], $result_row['type'], $result_row['status'],
							$result_row['notes'], $result_row['password']);
		$theVols[] = $theVol;
	}
	mysql_close();
	return $theVols;
}

// retrieve only those Persons that match the criteria given in the arguments
function getonlythose_dbPersons($type, $status, $name) {
	connect();
	$query = "SELECT * FROM dbPersons WHERE type LIKE '%".$type."%'" . 
			 " AND status LIKE '%".$status."%'" . 
			 " AND (first_name LIKE '%".$name."%' OR last_name LIKE '%".$name."%')" ;
    $query .= " ORDER BY last_name";
	$result = mysql_query($query);
	$thePersonss = array();
		
	while($result_row = mysql_fetch_assoc($result)){
		$thePerson = new Person($result_row['last_name'], $result_row['first_name'], $result_row['address'], $result_row['city'], $result_row['state'],
							$result_row['zip'], $result_row['phone1'], $result_row['phone2'], $result_row['email'], $result_row['type'], $result_row['status'],
							$result_row['notes'], $result_row['password']);
		$thePersons[] = $thePerson;
	}
	mysql_close();
	return $thePersons;
}

function insert_dbPersons($Person){
	if(! $Person instanceof Person){
		return false;
	}
	connect();
	$query = "SELECT * FROM dbPersons WHERE id = '" . $Person->get_id() . "'";
	$result = mysql_query($query);
	if (mysql_num_rows($result) != 0) {
		delete_dbPersons ($Person->get_id());
		connect();
	}
	$query = "INSERT INTO dbPersons VALUES ('".
				$Person->get_id()."','" .
				$Person->get_last_name()."','".
				$Person->get_first_name()."','".
				$Person->get_address()."','".
				$Person->get_city()."','".
				$Person->get_state()."','".
				$Person->get_zip()."','".
				$Person->get_phone1()."','".
				$Person->get_phone2()."','".
				$Person->get_email()."','".
				$Person->get_type()."','".
				$Person->get_status()."','".
				$Person->get_notes()."','".
				$Person->get_password().
	            "');";
	$result = mysql_query($query);
	if (!$result) {
		echo (mysql_error(). " Unable to insert into dbPersons: " . $Person->get_id(). "\n");
		mysql_close();
		return false;
	}
	mysql_close();
	return true;
	
}

function update_dbPersons($Person){
	if (! $Person instanceof Person) {
		echo ("Invalid argument for update_dbPerson function call");
		return false;
	}
	if (delete_dbPersons($Person->get_id()))
	return insert_dbPersons($Person);
	else {
		echo (mysql_error()."unable to update dbPersons table: ".$Person->get_id());
		return false;
	}
}

function delete_dbPersons($id){
	connect();
	$result = mysql_query("DELETE FROM dbPersons WHERE id =\"".$id."\"");
	mysql_close();
	if (!$result) {
		echo (mysql_error()." unable to delete from dbPersons: ".$id);
		return false;
	}
	return true;
}

?>