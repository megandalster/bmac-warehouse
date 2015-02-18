<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker.  This program is part of BMAC-Warehouse, which is free software. It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

include_once(dirname(__FILE__).'/../domain/Customer.php');
include_once(dirname(__FILE__).'/../database/dbCustomers.php'); 
class testdbCustomers extends UnitTestCase {
	
	function testdbCustomersModule() {
		//Test table creation
		//$this->assertTrue(create_dbCustomers());
	
		//Test Customers
		 $cus1 = new Customer("Campfire", "1 Scarborough Head Rd", "Walla Walla", "WA", "99362", "walla walla county", "contact_number_1", 
    				"5026319874", "Customer1@hotmail.com", "active", "");
		$cus2 = new Customer("Customer_id_2", "1 Issac street", "Walla Walla", "WA", "99362", "walla walla county", "contact_number_2", 
    				"5026319000", "Customer2@hotmail.com", "active", "");
		$cus3 = new Customer("Customer_id_3", "3 Rose street", "Walla Walla", "WA", "99362", "walla walla county", "contact_number_3", 
    				"5026550000", "Customer3@hotmail.com", "active", "no_notes");
        //Test inserts
		$this->assertTrue(insert_dbCustomers($cus1));
	    $this->assertTrue(insert_dbCustomers($cus2));
		$this->assertTrue(insert_dbCustomers($cus3));
		//Test Retrieve
		$this->assertEqual(retrieve_dbCustomers($cus1->get_customer_id())->get_customer_id (), "Campfire");
		$this->assertEqual(retrieve_dbCustomers($cus1->get_customer_id())->get_address (), "1 Scarborough Head Rd");
		$this->assertEqual(retrieve_dbCustomers($cus1->get_customer_id())->get_city (), "Walla Walla");
		$this->assertEqual(retrieve_dbCustomers($cus1->get_customer_id())->get_state(), "WA");
		$this->assertEqual(retrieve_dbCustomers($cus1->get_customer_id())->get_zip (), "99362");
		$this->assertEqual(retrieve_dbCustomers($cus1->get_customer_id())->get_county (), "walla walla county");
		$this->assertEqual(retrieve_dbCustomers($cus1->get_customer_id())->get_contact(), "contact_number_1");
		$this->assertEqual(retrieve_dbCustomers($cus1->get_customer_id())->get_phone (), "5026319874");
		$this->assertEqual(retrieve_dbCustomers($cus1->get_customer_id())->get_email (), "Customer1@hotmail.com");
		$this->assertEqual(retrieve_dbCustomers($cus1->get_customer_id())->get_status(), "active");
		$this->assertEqual(retrieve_dbCustomers($cus1->get_customer_id())->get_notes(), "");
		
		//Test Update with a change of address
		$cus2 = new Customer("Customer_id_2", "55 not Issac street", "Walla Walla", "WA", "99362", "walla walla county", "contact_number_2", 
    				"5026319000", "Customer2@hotmail.com", "active", "no_notes");
		$this->assertTrue(update_dbCustomers($cus2));
		$this->assertEqual(retrieve_dbCustomers($cus2->get_customer_id())->get_address(), "55 not Issac street");
		
		//Test Delete
		$this->assertTrue(delete_dbCustomers($cus1->get_customer_id()));
		$this->assertTrue(delete_dbCustomers($cus2->get_customer_id()));
		$this->assertTrue(delete_dbCustomers($cus3->get_customer_id()));
		$this->assertFalse(retrieve_dbCustomers($cus2->get_customer_id()));
		
		echo ("testdbCustomers complete \n");
	}
}
?>