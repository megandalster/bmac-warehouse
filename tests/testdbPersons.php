<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker.  This program is part of BMAC-Warehouse, which is free software. It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */
use PHPUnit\Framework\TestCase;
include_once(dirname(__FILE__).'/../domain/Person.php');
include_once(dirname(__FILE__).'/../database/dbPersons.php'); 
class dbPersonsTest extends TestCase {
	function testdbPersons() {
		
		//Setup -- test insert
		$per1 = new Person("Brody", "Hartley", "1 Scarborough Head Rd","Walla Walla", "WA", "99362", "1112345678", "", 
    				"Hartley.Brody@gmail.com", "staff", "active", "", "");
        $per2 = new Person("Hopkins", "Richardo", "2 Scarborough Head Rd","Walla Walla", "WA", "99362", "1112345679", "", 
    				"milkywayw@gmail.com", "office", "active", "", "");
		$this->assertTrue(insert_dbPersons($per1));
		$this->assertTrue(insert_dbPersons($per2));
		
		//Test -- test retrieve and update
		$this->assertEquals(retrieve_dbPersons($per1->get_id())->get_id (), "Hartley1112345678");
		$this->assertEquals(retrieve_dbPersons($per1->get_id())->get_first_name (), "Hartley");
		$this->assertEquals(retrieve_dbPersons($per1->get_id())->get_last_name (), "Brody");
		$this->assertEquals(retrieve_dbPersons($per1->get_id())->get_address(), "1 Scarborough Head Rd");
		$this->assertEquals(retrieve_dbPersons($per1->get_id())->get_city (), "Walla Walla");
		$this->assertEquals(retrieve_dbPersons($per1->get_id())->get_state (), "WA");
		$this->assertEquals(retrieve_dbPersons($per1->get_id())->get_zip(), "99362");
		$this->assertEquals(retrieve_dbPersons($per1->get_id())->get_phone1 (), 1112345678);
		$this->assertEquals(retrieve_dbPersons($per1->get_id())->get_phone2 (), null);
		$this->assertEquals(retrieve_dbPersons($per1->get_id())->get_email(), "Hartley.Brody@gmail.com");
		$per2 = new Person("Hopkins", "Richardo", "444 Park","Hilton Head", "SC", "29928", "1112345679", "", 
    				"milkywayw@gmail.com", "office", "active", "", "");
		$this->assertTrue(update_dbPersons($per2));
		$this->assertEquals(retrieve_dbPersons($per2->get_id())->get_address(), "444 Park");
		
		//Teardown -- test delete
		$this->assertTrue(delete_dbPersons($per1->get_id()));
		$this->assertTrue(delete_dbPersons($per2->get_id()));
		$this->assertFalse(retrieve_dbPersons($per2->get_id()));
	}
}
?>