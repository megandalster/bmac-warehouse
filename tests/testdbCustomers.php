<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker.  This program is part of BMAC-Warehouse, which is free software. It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */
use PHPUnit\Framework\TestCase;
include_once(dirname(__FILE__).'/../domain/Customer.php');
include_once(dirname(__FILE__).'/../database/dbCustomers.php'); 
class dbCustomersTest extends TestCase {
	function testdbCustomers() {
		
		//Setup -- test insert
		$cus1 = new Customer("Campfire", 1, "1 Scarborough Head Rd", "Walla Walla", "WA", "99362", "walla walla county", "contact_number_1", 
    				"5026319874", "Customer1@hotmail.com", "active", "");
		$cus2 = new Customer("Customer_id_2", 2, "1 Issac street", "Walla Walla", "WA", "99362", "walla walla county", "contact_number_2", 
    				"5026319000", "Customer2@hotmail.com", "active", "");
		
		//Test -- test retrieve and update
		$this->assertTrue(insert_dbCustomers($cus1));
	    $this->assertTrue(insert_dbCustomers($cus2));
		//Test Retrieve
		$this->assertEquals(retrieve_dbCustomers($cus1->get_customer_id())->get_customer_id (), "Campfire");
		$this->assertEquals(retrieve_dbCustomers($cus1->get_customer_id())->get_address (), "1 Scarborough Head Rd");
		$this->assertEquals(retrieve_dbCustomers($cus1->get_customer_id())->get_city (), "Walla Walla");
		$this->assertEquals(retrieve_dbCustomers($cus1->get_customer_id())->get_state(), "WA");
		$this->assertEquals(retrieve_dbCustomers($cus1->get_customer_id())->get_zip (), "99362");
		$this->assertEquals(retrieve_dbCustomers($cus1->get_customer_id())->get_county (), "walla walla county");
		$this->assertEquals(retrieve_dbCustomers($cus1->get_customer_id())->get_contact(), "contact_number_1");
		$this->assertEquals(retrieve_dbCustomers($cus1->get_customer_id())->get_phone (), "5026319874");
		$this->assertEquals(retrieve_dbCustomers($cus1->get_customer_id())->get_email (), "Customer1@hotmail.com");
		$this->assertEquals(retrieve_dbCustomers($cus1->get_customer_id())->get_status(), "active");
		$this->assertEquals(retrieve_dbCustomers($cus1->get_customer_id())->get_notes(), "");
		
		$cus2 = new Customer("Customer_id_2", 2, "55 not Issac street", "Walla Walla", "WA", "99362", "walla walla county", "contact_number_2", 
    				"5026319000", "Customer2@hotmail.com", "active", "no_notes");
		$this->assertTrue(update_dbCustomers($cus2));
		$this->assertEquals(retrieve_dbCustomers($cus2->get_customer_id())->get_address(), "55 not Issac street");
		
		//Teardown -- test delete
		$this->assertTrue(delete_dbCustomers($cus1->get_customer_id()));
		$this->assertTrue(delete_dbCustomers($cus2->get_customer_id()));
		$this->assertFalse(retrieve_dbCustomers($cus2->get_customer_id()));
	}
}
?>