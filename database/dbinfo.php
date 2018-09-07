<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker. This program is part of BMAC-Warehouse, which is 
 * free software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 * 
 */

function connect() {
	$host = "localhost";
	$database = "bmacwarehousedb";
	$user = "bmacwarehousedb";
	$password = "math204";
	try {
	   $con = new PDO('mysql:host=localhost;dbname=bmacwarehousedb', 
	       'bmacwarehousedb', 'math204');
	   return $con;
	}
    catch (PDOException $e) {
        echo 'Unable to connect to the database : ' . $e;
        return $e;
    }
}
?>