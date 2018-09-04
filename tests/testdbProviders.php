<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker.  This program is part of BMAC-Warehouse, which is free software. It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */
use PHPUnit\Framework\TestCase;
include_once(dirname(__FILE__).'/../domain/Provider.php');
include_once(dirname(__FILE__).'/../database/dbProviders.php'); 
class dbProvidersTest extends TestCase {
	function testdbPersonsModule() {
		
		//Setup -- test create
		$prov1 = new Provider("FEMA", 1, "food", "111 Pennsylvania Dr.", "Portland", "MA", "95432", "Arlington", "John",
							  "1234567891", "femafood@fema.gov", "active", "3 months");
		$prov2 = new Provider("Plentiful Harvest", 2, "food", "487 Thunder Ave.", "Stormshire", "WA", "96543", "Central Valley", "Jaime",
							  "9876545321", "plentifulfood@comcast.net", "inactive", "lots of grains");
		$this->assertTrue(insert_dbProviders($prov1));
		$this->assertTrue(insert_dbProviders($prov2));
		
		//Test -- retrieve and update
		$this->assertEquals(retrieve_dbProviders($prov1->get_provider_id())->get_provider_id(), "FEMA");
		$this->assertEquals(retrieve_dbProviders($prov1->get_provider_id())->get_type(), "food");
		$this->assertEquals(retrieve_dbProviders($prov1->get_provider_id())->get_address(), "111 Pennsylvania Dr.");
		$this->assertEquals(retrieve_dbProviders($prov1->get_provider_id())->get_city(), "Portland");
		$this->assertEquals(retrieve_dbProviders($prov1->get_provider_id())->get_state(), "MA");
		$this->assertEquals(retrieve_dbProviders($prov1->get_provider_id())->get_zip(), "95432");
		$this->assertEquals(retrieve_dbProviders($prov1->get_provider_id())->get_county(), "Arlington");
		$this->assertEquals(retrieve_dbProviders($prov1->get_provider_id())->get_contact(), "John");
		$this->assertEquals(retrieve_dbProviders($prov1->get_provider_id())->get_phone(), "1234567891");
		$this->assertEquals(retrieve_dbProviders($prov1->get_provider_id())->get_email(), "femafood@fema.gov");
		$this->assertEquals(retrieve_dbProviders($prov1->get_provider_id())->get_status(), "active");
		$this->assertEquals(retrieve_dbProviders($prov1->get_provider_id())->get_notes(), "3 months");
		
		
		//Test Update with a change of address
		$prov2 = new Provider("Plentiful Harvest", 2, "food", "487 Thunder Ave.", "Stormshire", "WA", "96543", "Central Valley", "Jaime",
		    "9876545321", "plentifulfood@comcast.net", "active", "lots of grains");
		$this->assertTrue(update_dbProviders($prov2));
		$this->assertEquals(retrieve_dbProviders($prov2->get_provider_id())->get_status(), "active");
		
		//Teardown -- test delete
		$this->assertTrue(delete_dbProviders($prov1->get_provider_id()));
		$this->assertTrue(delete_dbProviders($prov2->get_provider_id()));
		$this->assertFalse(retrieve_dbProviders($prov2->get_provider_id()));	
	}
}
?>