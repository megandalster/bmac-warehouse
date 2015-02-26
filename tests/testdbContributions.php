<?php
//insert,delete,retrieve,update
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker.  This program is part of BMAC-Warehouse, which is free software. It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

include_once(dirname(__FILE__).'/../domain/Contribution.php');
include_once(dirname(__FILE__).'/../database/dbContributions.php'); 
class testdbContributions extends UnitTestCase {
	function testdbContributionsModule() {
		//Test table creation
		// $this->assertTrue(create_dbContributions()); // no need to test this any more -- the database will be live and will need to be preserved
		//Test Contributions
		$con1 = new Contribution("Walmart", "14-01-01-00:00:00", "Cranapple Juice:1000:100,Cranberry Juice:1000:100", "", "", "Test1");
		$con2 = new Contribution("Costco", "14-02-01-00:00:00", "Cranapple Juice:1000:100,Cranberry Juice:1000:100", "", "", "Test2");
        $con3 = new Contribution("Safeway", "14-02-02-00:00:00", "Cranapple Juice:1000:100,Cranberry Juice:1000:100", "", "", "Test3");
        //Test inserts
		$this->assertTrue(insert_dbContributions($con1));
		$this->assertTrue(insert_dbContributions($con2));
		$this->assertTrue(insert_dbContributions($con3));
		//Test Retrieve
		$this->assertEqual(retrieve_dbContributions($con1->get_provider_id())->get_provider_id (), "Walmart");
		$this->assertEqual(retrieve_dbContributions($con1->get_provider_id())->get_receive_date(), "14-01-01-00:00:00");
		$this->assertEqual(retrieve_dbContributions($con1->get_provider_id())->get_receive_items(), explode(",","Cranapple Juice:1000:100,Cranberry Juice:1000:100"));
		$this->assertEqual(retrieve_dbContributions($con1->get_provider_id())->get_notes(), "Test1");

		
		//Test Update with a change of items received
		$con2 = new Contribution("Costco", "14-02-01-00:00:00", "Cranapple Juice:1000:100,Cranberry Juice:1000:100,Mystery Meat:1000:100", "", "", "Test2");
		$this->assertTrue(update_dbContributions($con2));
		$this->assertEqual(retrieve_dbContributions($con2->get_provider_id())->get_receive_items(), explode(',',"Cranapple Juice:1000:100,Cranberry Juice:1000:100,Mystery Meat:1000:100"));
		
		//Test Delete
		$this->assertTrue(delete_dbContributions($con1->get_provider_id()));
		$this->assertTrue(delete_dbContributions($con2->get_provider_id()));
		$this->assertTrue(delete_dbContributions($con3->get_provider_id()));
		$this->assertFalse(retrieve_dbProducts($con2->get_provider_id()));
		
		echo ("testdbContributions complete \n");
	}
}
?>