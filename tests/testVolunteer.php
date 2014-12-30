<?php
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homeplate, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

include_once(dirname(__FILE__).'/../domain/Volunteer.php');
class testVolunteer extends UnitTestCase {
    function testVolunteerModule() {
             
    	//fake person to test
        $volunteer = new Volunteer("Smith", "John", "1 Scarborough Head Rd","Hilton Head", "SC", "29928", "8431112345", "", 
    				"jsmith@aol.com", "driver", "active", "123456789","SC", "14-01-29", "Wed:3,Fri:4", "59-01-01","98-01-01", "", "");
                 
        //testing getter functions
        $this->assertTrue($volunteer->get_first_name() == "John");
        $this->assertTrue($volunteer->get_last_name() == "Smith");
        $this->assertTrue($volunteer->get_address() == "1 Scarborough Head Rd");
        $this->assertTrue($volunteer->get_city() == "Hilton Head");
        $this->assertTrue($volunteer->get_state() == "SC");
        $this->assertTrue($volunteer->get_zip() == "29928");
        $this->assertTrue($volunteer->get_phone1() == "8431112345");
        $this->assertTrue($volunteer->get_phone2() == "");
        $this->assertTrue($volunteer->get_email() == "jsmith@aol.com");
                 
        // tests if the volunteer is a driver (may or may not be a team leader)
        $this->assertTrue($volunteer->is_type("driver"));
        // tests if available on the 4th Friday of the month
        $this->assertTrue($volunteer->is_available("Fri", 4));
                 
        echo ("testVolunteer complete\n");
    }
}

?>
