<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker.  This program is part of BMAC-Warehouse, which is free software. It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */
use PHPUnit\Framework\TestCase;
include_once(dirname(__FILE__).'/../domain/Contribution.php');
include_once(dirname(__FILE__).'/../database/dbContributions.php'); 
class ContributionsTest extends TestCase {
	function testdbContributions() {
		
		//Set Up -- test insert
		$con1 = new Contribution("Walmart", "14-01-01-00:00:00", "Cranapple Juice:1000:100,Cranberry Juice:1000:100", "", "", "Test1");
		$con2 = new Contribution("Costco", "14-02-01-00:00:00", "Cranapple Juice:1000:100,Cranberry Juice:1000:100", "", "", "Test2");
		$this->assertTrue(insert_dbContributions($con1));
		$this->assertTrue(insert_dbContributions($con2));
		
		//Test -- test retrieve and update
		$this->assertEquals(retrieve_dbContributions($con1->get_receive_date())->get_provider_id(), "Walmart");
		$this->assertEquals(retrieve_dbContributions($con1->get_receive_date())->get_receive_items(), explode(",","Cranapple Juice:1000:100,Cranberry Juice:1000:100"));
		$this->assertEquals(retrieve_dbContributions($con1->get_receive_date())->get_notes(), "Test1");
		$con2 = new Contribution("Costco", "14-02-01-00:00:00", "Cranapple Juice:1000:100,Cranberry Juice:1000:100,Mystery Meat:1000:100", "", "", "Test2");
		$this->assertTrue(update_dbContributions($con2));
		$this->assertEquals(retrieve_dbContributions($con2->get_receive_date())->get_receive_items(), explode(',',"Cranapple Juice:1000:100,Cranberry Juice:1000:100,Mystery Meat:1000:100"));
		
		// Teardown -- test delete
		$this->assertTrue(delete_dbContributions($con1->get_receive_date()));
		$this->assertTrue(delete_dbContributions($con2->get_receive_date()));
		$this->assertFalse(retrieve_dbContributions($con2->get_receive_date()));
	}
}
?>