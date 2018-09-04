<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker.  This program is part of BMAC-Warehouse, which is free software. It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */
use PHPUnit\Framework\TestCase;
include_once(dirname(__FILE__).'/../domain/Shipment.php');
include_once(dirname(__FILE__).'/../database/dbShipments.php'); 
class dbShipmentsTest extends TestCase {
	function testdbShipmentsModule() {
		
		// Setup -- test create
		$ship1 = new Shipment("Dylan3033251787", "Parentals", "1993-05-03:11:45", "BMAC", "", 
					"13", "400", "360", "2014-06-07", "1", "this");
        $ship2 = new Shipment("Gilbert3036645136", "Swamp", "2001-03-21:10:45", "BMAC", "", 
        			"3", "45", "20", "2014-02-01", "2", "is a");
        $this->assertTrue(insert_dbShipments($ship1));
		$this->assertTrue(insert_dbShipments($ship2));
		
		// Test -- test retrieve and update
		$this->assertEquals(retrieve_dbShipments($ship1->get_customer_id())->get_customer_id (), "Dylan3033251787");
		$this->assertEquals(retrieve_dbShipments($ship1->get_customer_id())->get_funds_source (), "Parentals");
		$this->assertEquals(retrieve_dbShipments($ship1->get_customer_id())->get_ship_date (), "1993-05-03:11:45");
		$this->assertEquals(retrieve_dbShipments($ship1->get_customer_id())->get_ship_via(), "BMAC");
		$this->assertEquals(retrieve_dbShipments($ship1->get_customer_id())->get_ship_items (), array());
		$this->assertEquals(retrieve_dbShipments($ship1->get_customer_id())->get_ship_rate (), "13");
		$this->assertEquals(retrieve_dbShipments($ship1->get_customer_id())->get_total_weight(), "400");
		$this->assertEquals(retrieve_dbShipments($ship1->get_customer_id())->get_total_price (), "360");
		$this->assertEquals(retrieve_dbShipments($ship1->get_customer_id())->get_invoice_date (), "2014-06-07");
		$this->assertEquals(retrieve_dbShipments($ship1->get_customer_id())->get_invoice_no(), "1");
		$this->assertEquals(retrieve_dbShipmentsDate($ship1->get_ship_date())->get_customer_id (), "Dylan3033251787");
		$this->assertEquals(retrieve_dbShipmentsDate($ship1->get_ship_date())->get_funds_source (), "Parentals");
		$this->assertEquals(retrieve_dbShipmentsDate($ship1->get_ship_date())->get_ship_date (), "1993-05-03:11:45");
		$this->assertEquals(retrieve_dbShipmentsDate($ship1->get_ship_date())->get_ship_via(), "BMAC");
		$this->assertEquals(retrieve_dbShipmentsDate($ship1->get_ship_date())->get_ship_items (), array());
		$this->assertEquals(retrieve_dbShipmentsDate($ship1->get_ship_date())->get_ship_rate (), "13");
		$this->assertEquals(retrieve_dbShipmentsDate($ship1->get_ship_date())->get_total_weight(), "400");
		$this->assertEquals(retrieve_dbShipmentsDate($ship1->get_ship_date())->get_total_price (), "360");
		$this->assertEquals(retrieve_dbShipmentsDate($ship1->get_ship_date())->get_invoice_date (), "2014-06-07");
		$this->assertEquals(retrieve_dbShipmentsDate($ship1->get_ship_date())->get_invoice_no(), "1");
		
		$ship2 = new Shipment ("Gilbert3036645136", "Pond", "2001-03-21:10:45", "BMAC", "", 
        			"3", "45", "20", "2014-02-01", "2", "is a");
		$this->assertTrue(update_dbShipments($ship2));
		$this->assertEquals(retrieve_dbShipmentsDate($ship2->get_ship_date())->get_funds_source(), "Pond");
		
		// Teardown -- test delete
		$this->assertTrue(delete_dbShipmentsDate($ship1->get_ship_date()));
		$this->assertTrue(delete_dbShipmentsDate($ship2->get_ship_date()));
		$this->assertFalse(retrieve_dbShipments($ship2->get_customer_id()));
	}
}
?>