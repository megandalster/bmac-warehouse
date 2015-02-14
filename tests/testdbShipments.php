<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker.  This program is part of BMAC-Warehouse, which is free software. It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

include_once(dirname(__FILE__).'/../domain/Shipment.php');
include_once(dirname(__FILE__).'/../database/dbShipments.php'); 
class testdbShipments extends UnitTestCase {
	function testdbShipmentsModule() {
		//Test table creation
		$this->assertTrue(create_dbShipments());
	
		//Test shipments
		$ship1 = new Shipment("Dylan3033251787", "Parentals", "1993-05-03:11:45", "BMAC", "", 
					"13", "400", "360", "2014-06-07", "1", "this");
        $ship2 = new Shipment("Gilbert3036645136", "Swamp", "2001-03-21:10:45", "BMAC", "", 
        			"3", "45", "20", "2014-02-01", "2", "is a");
        $ship3 = new Shipment("Macaroni3033356000", "Garden", "2010-08-12:04:32", "BMAC", "", 
        			"16", "7", "34", "2014-02-02", "3", "test");
      
        //Test inserts
		$this->assertTrue(insert_dbShipments($ship1));
		$this->assertTrue(insert_dbShipments($ship2));
		$this->assertTrue(insert_dbShipments($ship3));
		
		//Test Retrieve
		$this->assertEqual(retrieve_dbShipments($ship1->customer_id())->customer_id (), "Dylan3033251787");
		$this->assertEqual(retrieve_dbShipments($ship1->customer_id())->funds_source (), "Parentals");
		$this->assertEqual(retrieve_dbShipments($ship1->customer_id())->ship_date (), "1993-05-03:11:45");
		$this->assertEqual(retrieve_dbShipments($ship1->customer_id())->ship_via(), "BMAC");
		$this->assertEqual(retrieve_dbShipments($ship1->customer_id())->ship_items (), null);
		$this->assertEqual(retrieve_dbShipments($ship1->customer_id())->ship_rate (), "13");
		$this->assertEqual(retrieve_dbShipments($ship1->customer_id())->total_weight(), "400");
		$this->assertEqual(retrieve_dbShipments($ship1->customer_id())->total_price (), "360");
		$this->assertEqual(retrieve_dbShipments($ship1->customer_id())->invoice_date (), "2014-06-07");
		$this->assertEqual(retrieve_dbShipments($ship1->customer_id())->invoice_number(), "1");
		
		//Test Update with a change of funds source
		$ship2 = new Shipment ("Gilbert303645136", "Pond", "2001-03-21:10:45", "BMAC", "", 
        			"3", "45", "20", "2014-02-01", "2", "is a");
		$this->assertTrue(update_dbShipments($ship2));
		$this->assertEqual(retrieve_dbShipments($ship2->customer_id())->funds_source(), "Pond");
		
		//Test Delete
		$this->assertTrue(delete_dbShipments($ship1->customer_id()));
		$this->assertTrue(delete_dbShipments($ship2->customer_id()));
		$this->assertTrue(delete_dbShipments($ship3->customer_id()));
		$this->assertFalse(retrieve_dbShipments($ship2->customer_id()));
		
		echo ("testdbShipments complete \n");
	}
}
?>