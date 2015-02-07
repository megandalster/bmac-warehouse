<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker. This program is part of BMAC-Warehouse, which is 
 * free software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 * 
 */

include_once(dirname(__FILE__).'/../domain/Shipment.php');
class testShipment extends UnitTestCase {
    function testShipmentModule() {
             
    	//fake shipment to test
        $shipment = new Shipment("Fred.5098675309", "FEMA", "2014-05-03:12:34","BMAC", "cranberry sauce:40,peas:10", 
        			"10", "350", "100", "2014-05-10", "35", "this is a test");
                 
        // testing getter functions
        $this->assertTrue($shipment->get_customer_id() == "Fred.5098675309");
        $this->assertTrue($shipment->get_funds_source() == "FEMA");
        $this->assertTrue($shipment->get_ship_date() == "2014-05-03:12:34");
        $this->assertTrue($shipment->get_ship_via() == "BMAC");
        // ship_items stored as an array, so make it into a string for comparison
        $this->assertEqual(implode(',',$shipment->get_ship_items()), "cranberry sauce:40,peas:10");
        $this->assertTrue($shipment->get_ship_rate() == "10");
        $this->assertTrue($shipment->get_total_weight() == "350");
        $this->assertTrue($shipment->get_total_price() == "100");
        $this->assertTrue($shipment->get_invoice_date() == "2014-05-10");
        $this->assertTrue($shipment->get_invoice_no() == "35");
        $this->assertTrue($shipment->get_notes() == "this is a test");
                  
        echo ("testShipment complete\n");
    }
}