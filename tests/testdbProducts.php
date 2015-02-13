<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker.  This program is part of BMAC-Warehouse, which is free software. It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

include_once(dirname(__FILE__).'/../domain/Product.php');
include_once(dirname(__FILE__).'/../database/dbProducts.php'); 
class testdbProducts extends UnitTestCase {
	function testdbProductsModule() {
		//Test table creation
		$this->assertTrue(create_dbProducts());
	
		//Test Products
		$prod1 = new product("Beverages: Apple Juice", "321", "donation","41", "0.08", "15-02-02", "1000", "100", 
    				"15-02:1000:41,15-01:500:19", "1000:41", "active", "15-02", ",");
        $prod2 = new product("Soup: Canned", "321", "donation","41", "0.08", "15-02-02", "1000", "100", 
    				"15-02:1000:41,15-01:500:19", "1000:41", "active", "15-02", ",");
        $prod3 = new product("Fruit: Canned Peaches", "321", "donation","41", "0.08", "15-02-02", "1000", "100", 
    				"15-02:1000:41,15-01:500:19", "1000:41", "active", "15-02", ",");
        //Test inserts
		$this->assertTrue(insert_dbProducts($prod1));
		$this->assertTrue(insert_dbProducts($prod2));
		$this->assertTrue(insert_dbProducts($prod3));
		//Test Retrieve
		$this->assertEqual(retrieve_dbProducts($prod1->get_product_id())->get_product_id (), "Beverages: Apple Juice");
		$this->assertEqual(retrieve_dbProducts($prod1->get_product_id())->get_product_code (), "321");
		$this->assertEqual(retrieve_dbProducts($prod1->get_product_id())->get_funding_source (), "donation");
		$this->assertEqual(retrieve_dbProducts($prod1->get_product_id())->get_unit_weight(), "41");
		$this->assertEqual(retrieve_dbProducts($prod1->get_product_id())->get_unit_price (), "0.08");
		$this->assertEqual(retrieve_dbProducts($prod1->get_product_id())->get_initial_date (), "15-02-02");
		$this->assertEqual(retrieve_dbProducts($prod1->get_product_id())->get_initial_stock(), "1000");
		$this->assertEqual(retrieve_dbProducts($prod1->get_product_id())->get_minimum_stock (), "100");
		$this->assertEqual(retrieve_dbProducts($prod1->get_product_id())->get_history (), explode(",","15-02:1000:41,15-01:500:19"));
		//check how to test history. STOPPED HERE
		$this->assertEqual(retrieve_dbProducts($prod1->get_product_id())->get_current_stock (), "1000:41");
		$this->assertEqual(retrieve_dbProducts($prod1->get_product_id())->get_status (), "active");
		$this->assertEqual(retrieve_dbProducts($prod1->get_product_id())->get_inventory_date (), "15-02");
		$this->assertEqual(retrieve_dbProducts($prod1->get_product_id())->get_notes (), ",");
		
		//Test Update with a change of address
		$prod2 = new product("Soup: Canned", "321", "donation","41", "0.08", "15-02-02", "1000", "100", 
    				"15-02:1000:41,15-01:500:19", "900:41", "active", "15-02", ",");
		$this->assertTrue(update_dbProducts($prod2));
		$this->assertEqual(retrieve_dbProducts($prod2->get_product_id())->get_current_stock(), "900:41");
		
		//Test Delete
		$this->assertTrue(delete_dbProducts($prod1->get_product_id()));
		$this->assertTrue(delete_dbProducts($prod2->get_product_id()));
		$this->assertTrue(delete_dbProducts($prod3->get_product_id()));
		$this->assertFalse(retrieve_dbProducts($prod2->get_product_id()));
		
		echo ("testdbProducts complete \n");
	}
}
?>