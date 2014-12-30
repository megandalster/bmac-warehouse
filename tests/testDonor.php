<?php
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homeplate, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/**
 * Provides the test module for the Donor class.
 * @author Nicholas Wetzel
 * @version October 20, 2012
 */

include_once(dirname(__FILE__).'/../domain/Donor.php');
class testDonor extends UnitTestCase {
    function testDonorModule() {  

    	//fake donor to test
        $donor = new Donor("Hannafords", "Jul", "04", "2001", "organization", "345 Maine St", "Cornelius", 
                            "NC", "20511", "7048775483", "Wayne Gretzky", "wgretzky@nhl.com", "This is a test case");
        
         //testing getter functions
        $this->assertTrue($donor->get_id() == "Hannafords");
        $this->assertTrue($donor->get_month() == "Jul");
        $this->assertTrue($donor->get_day() == "04");
        $this->assertTrue($donor->get_year() == "2001");
        $this->assertTrue($donor->get_type() == "organization");
        $this->assertTrue($donor->get_address() == "345 Maine St");
        $this->assertTrue($donor->get_city() == "Cornelius");
        $this->assertTrue($donor->get_state() == "NC");
        $this->assertTrue($donor->get_zip() == "20511");
        $this->assertTrue($donor->get_phone1() == "7048775483");
        $this->assertTrue($donor->get_contact() == "Wayne Gretzky");
        $this->assertTrue($donor->get_notes() == "This is a test case");
                   
        echo ("testDonor complete\n");			
    }
}

?>
