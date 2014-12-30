<?php

/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homeplate, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/**
 * Provides the test module for the Donation class.
 * @author Nicholas Wetzel
 * @version May 8, 2012
 */

include_once(dirname(__FILE__).'/../domain/Donation.php');
class testDonation extends UnitTestCase{
	function testDonationModule() {     
    	//create a test donation/client
    	$donation = new Donation("11-12-2911:30:30","HHI","12-01-01","John Jones", "", "");
    	$donation2 = new Donation("11-12-2914:15:34","HHI","12-01-01","Mary Jones","household:2","");

        
    	//testing getter functions
    	$this->assertEqual($donation->get_id(), "11-12-2911:30:30");
    	$this->assertTrue($donation->get_time() == "11:30:30");
    	$this->assertTrue($donation->get_items() == array());
    	$this->assertTrue($donation->get_total_weight() == 0);
    	$this->assertTrue($donation->get_notes() == "");
    	$this->assertEqual($donation2->get_item_count(), 2);
    	$donation2->add_item("building:4");
    	$this->assertEqual($donation2->get_item_count(), 6);
  		$donation2->remove_item("household:2");
   		$this->assertEqual($donation2->get_item_count(), 4);

    	//echoing
		echo ("testDonation complete!\n");
    }
}

?>
