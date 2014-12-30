<?php

/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homeplate, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */  

include_once(dirname(__FILE__).'/../domain/DonationLog.php');
class testDonationLog extends UnitTestCase {
    function testDonationLogModule() {    
    	//fake donationLog to test
    	$donationLog = new DonationLog("11-12-28HHI", 
    	"Shaws Brunswick,St Pauls Church","", "Note.");
    	
    	//testing getter functions
    	$this->assertTrue($donationLog->get_id() == "11-12-28HHI");
    	$this->assertEqual($donationLog->get_day(), "Wednesday December 28, 2011");
	   	$this->assertEqual($donationLog->get_donations(), array("Shaws Brunswick","St Pauls Church"));
	   	$this->assertEqual($donationLog->get_status(), "created");
	   	
    	$this->assertEqual($donationLog->get_notes(), "Note.");
   	
        echo ("testDonationLog complete\n");
    }
}

?>
