<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker.  This program is part of BMAC-Warehouse, which is free software. It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

include_once(dirname(__FILE__).'/../domain/Provider.php');
include_once(dirname(__FILE__).'/../database/dbProviders.php'); 
class testdbProviders extends UnitTestCase {
	function testdbPersonsModule() {
		//Test table creation
		$this->assertTrue(create_dbProviders());
	
		
		//Test providers
		$prov1 = new Provider("FEMA", "food", "111 Pennsylvania Dr.", "Portland", "MA", "95432", "Arlington", "John",
							  "1234567891", "femafood@fema.gov", "active", "3 months");
		$prov2 = new Provider("Plentiful Harvest", "food", "487 Thunder Ave.", "Stormshire", "WA", "96543", "Central Valley", "Jaime",
							  "9876545321", "plentifulfood@comcast.net", "inactive", "lots of grains");
		$prov3 = new Provider("Will Gates Foundation", "funds", "994 Greenview Dr.", "Seattle", "WA", "95424", "Olympia", "Billinda",
							  "9999999999", "cashmoney@aol.com", "active", "stacks on stacks");
		
        //Test inserts
		$this->assertTrue(insert_dbProviders($prov1));
		$this->assertTrue(insert_dbProviders($prov2));
		$this->assertTrue(insert_dbProviders($prov3));
		
		//Test Retrieve
		$this->assertEqual(retrieve_dbProviders($prov1->get_provider_id())->get_provider_id(), "FEMA");
		$this->assertEqual(retrieve_dbProviders($prov1->get_provider_id())->get_type(), "food");
		$this->assertEqual(retrieve_dbProviders($prov1->get_provider_id())->get_address(), "111 Pennsylvania Dr.");
		$this->assertEqual(retrieve_dbProviders($prov1->get_provider_id())->get_city(), "Portland");
		$this->assertEqual(retrieve_dbProviders($prov1->get_provider_id())->get_state(), "MA");
		$this->assertEqual(retrieve_dbProviders($prov1->get_provider_id())->get_zip(), "95432");
		$this->assertEqual(retrieve_dbProviders($prov1->get_provider_id())->get_county(), "Arlington");
		$this->assertEqual(retrieve_dbProviders($prov1->get_provider_id())->get_contact(), "John");
		$this->assertEqual(retrieve_dbProviders($prov1->get_provider_id())->get_phone(), "1234567891");
		$this->assertEqual(retrieve_dbProviders($prov1->get_provider_id())->get_email(), "femafood@fema.gov");
		$this->assertEqual(retrieve_dbProviders($prov1->get_provider_id())->get_status(), "active");
		$this->assertEqual(retrieve_dbProviders($prov1->get_provider_id())->get_notes(), "3 months");
		
		
		//Test Update with a change of address
		$prov3 = new Provider("Will Gates Foundation", "funds", "994 Greenestview Dr.", "Seattle", "WA", "95424", "Olympia", "Billinda",
							  "9999999999", "cashmoney@aol.com", "active", "stacks on stacks");
		$this->assertTrue(update_dbProviders($prov3));
		$this->assertEqual(retrieve_dbProviders($prov3->get_provider_id())->get_address(), "994 Greenestview Dr.");
		
		
		//Test Delete
		$this->assertTrue(delete_dbProviders($prov1->get_provider_id()));
		$this->assertTrue(delete_dbProviders($prov2->get_provider_id()));
		$this->assertTrue(delete_dbProviders($prov3->get_provider_id()));
		$this->assertFalse(retrieve_dbProviders($prov2->get_provider_id()));
		
		echo ("testdbProviders complete \n");
	}
}
?>