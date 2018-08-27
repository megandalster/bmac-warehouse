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
 * dbPersons for BMAC-Warehouse
 * @author Allen Tucker
 * @version December 29, 2014
 */

include_once(dirname(__FILE__).'/../domain/Person.php');
include_once(dirname(__FILE__).'/dbinfo.php');

function retrieve_dbPersons($id){
	$con=connect();
	$query="SELECT * FROM dbPersons WHERE id  = '".$id."'";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not retrieve person with id ".$id. " ". $p->getMessage());
	}
	if($result->rowCount()!== 1){
	    $con=null;
	    return false;
	}
	$result_row = $result->fetch(PDO::FETCH_ASSOC);
	$theVol = new Person($result_row['last_name'], $result_row['first_name'], $result_row['address'], $result_row['city'], $result_row['state'],
							$result_row['zip'], $result_row['phone1'], $result_row['phone2'], $result_row['email'], $result_row['type'], $result_row['status'],
							$result_row['notes'], $result_row['password']);
	$con=null;
	return $theVol;
}

function getall_dbPersons(){
	$con=connect();
	$query = "SELECT * FROM dbPersons ORDER BY last_name";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not retrieve from dbPersons ".$p->getMessage());
	}
	$theVols = array();
	while($result_row = $result->fetch(PDO::FETCH_ASSOC)){
		$theVol = new Person($result_row['last_name'], $result_row['first_name'], $result_row['address'], $result_row['city'], $result_row['state'],
							$result_row['zip'], $result_row['phone1'], $result_row['phone2'], $result_row['email'], $result_row['type'], $result_row['status'],
							$result_row['notes'], $result_row['password']);
		$theVols[] = $theVol;
	}
	$con=null;
	return $theVols;
}

// retrieve only those Persons that match the criteria given in the arguments
function getonlythose_dbPersons($type, $status, $name) {
	$con=connect();
	$query = "SELECT * FROM dbPersons WHERE type LIKE '%".$type."%'" . 
			 " AND status LIKE '%".$status."%'" . 
			 " AND (first_name LIKE '%".$name."%' OR last_name LIKE '%".$name."%')" ;
    $query .= " ORDER BY last_name";
    try {
        $result = $con->query($query);
    } catch (PDOException $p) {
        die("Could not retrieve from dbPersons ".$p->getMessage());
    }
    $thePersons = array();
		
	while($result_row = $result->fetch(PDO::FETCH_ASSOC)){
		$thePerson = new Person($result_row['last_name'], $result_row['first_name'], $result_row['address'], $result_row['city'], $result_row['state'],
							$result_row['zip'], $result_row['phone1'], $result_row['phone2'], $result_row['email'], $result_row['type'], $result_row['status'],
							$result_row['notes'], $result_row['password']);
		$thePersons[] = $thePerson;
	}
	$con=null;
	return $thePersons;
}

function insert_dbPersons($Person){
	if(! $Person instanceof Person){
		return false;
	}
	$con=connect();
	$query = "SELECT * FROM dbPersons WHERE id = '" . $Person->get_id() . "'";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not retrieve dbPersons ". $p->getMessage());
	}
	if($result->rowCount()!== 0){
	    delete_dbPersons ($Person->get_id());
	    $con=connect();
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
	try {
		$result = $con->query($query);
    } catch (PDOException $p) {
        die("Could not insert contribution ".$p->getMessage());
	}
	if (!$result) {
        echo ("Unable to insert into dbPersons: " . $Person->get_id(). "\n");
        $con=null;
        return false;
	}
	$con=null;
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
	$con=connect();
	$query = "DELETE FROM dbPersons WHERE id =\"".$id."\"";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not delete person ".$p->getMessage());
	}
	$con=null;
	if (!$result) {
		echo (" unable to delete from dbPersons: ".$id);
		return false;
	}
	return true;
}

?>