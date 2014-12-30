<?php
/*
 * Copyright 2014 by Hartley Brody, Richardo Hopkins, Nicholas Wetzel, and Allen
 * Tucker.  This program is part of Homerestore, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/**
 * dbDonors class for Homerestore
 * @author Hartley Brody, Nick Wetzel & Sawyer Bowman
 * @version October 8, 2013
 */

include_once(dirname(__FILE__).'/../domain/Donor.php');
include_once(dirname(__FILE__).'/dbinfo.php');

function create_dbDonors(){
	connect();
	mysql_query("DROP TABLE IF EXISTS dbDonors");
	$result = mysql_query("CREATE TABLE dbDonors (id TEXT NOT NULL, month_name TEXT, day_name TEXT, year_name TEXT, type TEXT, address TEXT, city TEXT, state TEXT,
                            zip TEXT, neighborhood TEXT, phone1 VARCHAR(12) NOT NULL, email TEXT, geox TEXT, geoy TEXT,
						    notes TEXT)");
	mysql_close();
	if(!$result){
			echo (mysql_error()."Error creating database table dbDonors. <br>");
			return false;
	}
	return true;
}

function retrieve_dbDonors($id){
	connect();
	$result = mysql_query("SELECT * FROM dbDonors WHERE id  = '".$id."'");
	if(mysql_num_rows($result) != 1){
			mysql_close();
			return false;
	}
	$result_row = mysql_fetch_assoc($result);
	$theDonor = new Donor($result_row['id'], $result_row['month_name'], $result_row['day_name'], $result_row['year_name'], $result_row['type'], $result_row['address'],
                            $result_row['city'], $result_row['state'], $result_row['zip'], $result_row['neighborhood'], $result_row['phone1'], 
                            $result_row['email'], $result_row['notes']);
	mysql_close();
	return $theDonor;
}


function getall_dbDonors(){
	connect();
	$result = mysql_query("SELECT * FROM dbDonors ORDER BY id");
	$theDonors = array();
	while($result_row = mysql_fetch_assoc($result)){
		$theDonor = new Donor($result_row['id'], 
				$result_row['month_name'], 
				$result_row['day_name'],
				$result_row['year_name'],
				$result_row['type'], 
				$result_row['address'], 
				$result_row['city'], 
				$result_row['state'], 
				$result_row['zip'], 
				$result_row['neighborhood'], 
				$result_row['phone1'], 
				$result_row['email'], 
				$result_row['notes']);
		$theDonors[] = $theDonor;
	}
	mysql_close();
	return $theDonors;
}

// new method used on donorSearch page
function getall_donorsFiltered($name, $city)
{
	connect();
	$query = "SELECT * FROM dbDonors ";
	if ($name)
	{
		$query .= "WHERE id LIKE '%" . $name . "%'";
	}
	if ($city && $name)
	{
		$query .= " AND city LIKE '%" . $city . "%'";
	}
	if ($city && !$name)
	{
		$query .= "WHERE city LIKE '%" . $city . "%'";
	}
	$result = mysql_query($query);
	$theDonors = array();
	while ($result_row = mysql_fetch_assoc($result))
	{
		$theDonor = new Donor($result_row['id'], $result_row['month_name'], $result_row['day_name'], $result_row['year_name'], $result_row['type'], $result_row['address'],
                            $result_row['city'], $result_row['state'], $result_row['zip'], $result_row['neighborhood'], $result_row['phone1'], 
                            $result_row['email'], $result_row['notes']);
		$theDonors[] = $theDonor;
	}
	mysql_close();
	return $theDonors;
}

// if this isn't being used for anything maybe we can delete it?
function getall_donors($area, $type, $status, $name, $availability) {
	connect();
    $query = "SELECT * FROM dbDonors WHERE type like '%". $type . "%' ";
            if($name) $query .= "AND id LIKE '%" . $name ."%' ";
            if($availability) { 
            	$query .= "AND (";
            	foreach ($availability as $day)
                	$query .= "days LIKE '%".$day."%' OR ";
            	$query = substr($query, 0, strlen( $query ) - 4).") ";
            }
            $query .= "ORDER BY id";
 
    $result = mysql_query ($query);
    $theDonors = array();
//    while ($result_row = mysql_fetch_assoc($result)) {
       	$theDonor = new Donor($result_row['id'], $result_row['month_name'], $result_row['day_name'], $result_row['year_name'], $result_row['type'], $result_row['address'],
                            $result_row['city'], $result_row['state'], $result_row['zip'], $result_row['neighborhood'], $result_row['phone1'], 
                            $result_row['email'], $result_row['notes']);
		$theDonors[] = $theDonor;
//    }
	mysql_close();
    return $theDonors; 
}

function insert_dbDonors($donor){
	if(!$donor instanceof Donor){
		return false;
	}
	connect();
	$query = "SELECT * FROM dbDonors WHERE id = '" . $donor->get_id() . "'";
	$result = mysql_query($query);
	if (mysql_num_rows($result) != 0) {
		delete_dbDonors($donor->get_id());
		connect();
	}
	$query = "INSERT INTO dbDonors VALUES ('".
				$donor->get_id()."','" .
				$donor->get_month()."','".
				$donor->get_day()."','".
				$donor->get_year()."','".
				$donor->get_type()."','".
				$donor->get_address()."','".
				$donor->get_city()."','".
				$donor->get_state()."','".
				$donor->get_zip()."','".
				$donor->get_neighborhood()."','".
				$donor->get_phone1()."','".	
				$donor->get_email()."','".
				$donor->get_notes()."','".
				$donor->get_lat()."','".
				$donor->get_lng().
	            "');";
	$result = mysql_query($query);
	if (!$result) {
		echo (mysql_error(). " Unable to insert into dbDonors: " . $donor->get_id(). "\n");
		mysql_close();
		return false;
	}
	mysql_close();
	return true;
	
}

function update_dbDonors($donor){
	if (! $donor instanceof Donor) {
		echo ("Invalid argument for update_dbDonors function call");
		return false;
	}
	if (delete_dbDonors($donor->get_id()))
	return insert_dbDonors($donor);
	else {
		echo (mysql_error()."unable to update dbDonors table: ".$donor->get_id());
		return false;
	}
}

function delete_dbDonors($id){
	connect();
	$result = mysql_query("DELETE FROM dbDonors WHERE id =\"".$id."\"");
	mysql_close();
	if (!$result) {
		echo (mysql_error()." unable to delete from dbDonors: ".$id);
		return false;
	}
	return true;
}
?>