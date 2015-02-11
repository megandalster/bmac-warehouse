<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker.  This program is part of BMAC-Warehouse, which is free software. It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

include_once(dirname(__FILE__).'/../domain/Product.php');
class testProduct extends UnitTestCase {
    function testProductModule() {
             
    	//fake product to test
        $product = new product("Beverages: Apple Juice", "321", "donation","41", "0.08", "15-02-02", "1000", "100", 
    				"15-02:1000:41,15-01:500:19", "1000:41", "active", "15-02", ",");
                 
        // testing getter functions
        $this->assertTrue($product->get_product_id() == "Beverages: Apple Juice");
        $this->assertTrue($product->get_product_code() == "321");
        $this->assertTrue($product->get_funding_source() == "donation");
        $this->assertTrue($product->get_unit_weight() == "41");
        $this->assertTrue($product->get_unit_price() == "0.08");
        $this->assertTrue($product->get_initial_date() == "15-02-02");
        $this->assertTrue($product->get_initial_stock() == "1000");
        $this->assertTrue($product->get_minimum_stock() == "100");
        // history stored as an array, so make it into a string for comparison
        $this->assertEqual(implode(',',$product->get_history()), "15-02:1000:41,15-01:500:19");
        $this->assertTrue($product->get_current_stock() == "1000:41");
        $this->assertTrue($product->get_status() == "active");
        $this->assertTrue($product->get_inventory_date() == "15-02");
        $this->assertTrue($product->get_notes() == ",");
        $this->assertTrue($product->is_funding_source("donation"));
                  
        echo ("testproduct complete\n");
    }
}

?>
