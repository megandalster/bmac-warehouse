<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker. This program is part of BMAC-Warehouse, which is 
 * free software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 * 
 */

include_once(dirname(__FILE__).'/../domain/Provider.php');
class testProvider extends UnitTestCase {
    function testProviderModule() {
             
    	//fake provider to test
        $provider = new Provider("FEMA", "food", "1 Lincoln Rd.", "Walla Walla", "WA", "99362", "Columbia", "Seamus",
        						 "1234567899", "hey@aol.com", "active", "shay-mus");

        
        // testing getter functions
        $this->assertTrue($provider->get_id() == "FEMA");
        $this->assertTrue($provider->get_type() == "food");
        $this->assertTrue($provider->get_address() == "1 Lincoln Rd.");
        $this->assertTrue($provider->get_city() == "Walla Walla");
        $this->assertTrue($provider->get_state() == "WA");
        $this->assertTrue($provider->get_zip() == "99362");
        $this->assertTrue($provider->get_county() == "Columbia");
        $this->assertTrue($provider->get_contact() == "Seamus");
        $this->assertTrue($provider->get_phone() == "1234567899");
        $this->assertTrue($provider->get_email() == "hey@aol.com");
        $this->assertTrue($provider->get_status() == "active");
        $this->assertTrue($provider->get_notes() == "shay-mus");
        
                  
        echo ("testProvider complete\n");
    }
}

?>