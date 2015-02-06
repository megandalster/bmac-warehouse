<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker.  This program is part of BMAC-Warehouse, which is free software. It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

include_once(dirname(__FILE__).'/../domain/Person.php');
class testPerson extends UnitTestCase {
    function testPersonModule() {
             
    	//fake person to test
        $person = new Person("Smith", "John", "1 Scarborough Head Rd","Walula", "WA", "99123", "8431112345", "", 
    				"jsmith@aol.com", "staff", "active", "", "");
                 
        // testing getter functions
        $this->assertTrue($person->get_first_name() == "John");
        $this->assertTrue($person->get_last_name() == "Smith");
        $this->assertTrue($person->get_address() == "1 Scarborough Head Rd");
        $this->assertTrue($person->get_city() == "Walula");
        $this->assertTrue($person->get_state() == "WA");
        $this->assertTrue($person->get_zip() == "99123");
        $this->assertTrue($person->get_phone1() == "8431112345");
        $this->assertTrue($person->get_phone2() == "");
        $this->assertTrue($person->get_email() == "jsmith@aol.com");
        $this->assertTrue($person->is_type("staff"));
                  
        echo ("testPerson complete\n");
    }
}

?>
