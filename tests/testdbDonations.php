<?php
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homeplate, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/**
 * Provides the test module for the dbDonations file.
 * @author Nicholas Wetzel
 * @version May 8, 2012
 */

include_once(dirname(__FILE__).'/../domain/Donation.php');
include_once(dirname(__FILE__).'/../database/dbDonations.php');
class testdbDonations extends UnitTestCase {
    function testdbDonationsModule() {
    	
        // creates an empty dbDonations table
        // $this->assertTrue(create_dbDonations());
        
        // creates some donations to add to the database
       	$donation = new Donation("11-12-2911:30:30","HHI","12-01-01","John Jones","","");
    	$donation2 = new Donation("11-12-2914:10:45","SUN","12-01-02","Mary Jones","household:10","");
    	$donation3 = new Donation("11-12-2909:00:55","HHI","12-01-03","Jones Bros","building:2","Completed");
        // tests the insert function
        $this->assertTrue(insert_dbDonations($donation));
        $this->assertTrue(insert_dbDonations($donation2));
        $this->assertTrue(insert_dbDonations($donation3));                
        
        //tests the retrieve function
        $this->assertEqual(retrieve_dbDonations($donation3->get_id())->get_id (), "11-12-2909:00:55");
        $this->assertEqual(retrieve_dbDonations($donation3->get_id())->get_area (), "HHI");
        $this->assertEqual(retrieve_dbDonations($donation3->get_id())->get_items (), array("building:2"));
        $this->assertEqual(retrieve_dbDonations($donation3->get_id())->get_item_count (), 2);
        $this->assertEqual(retrieve_dbDonations($donation3->get_id())->get_notes (), "Completed");    
                 
        //tests the update function
        $donation->set_notes("Completed");
        $this->assertTrue(update_dbDonations($donation));
        $this->assertEqual(retrieve_dbDonations($donation->get_id())->get_notes (), "Completed");   
         
        //tests the delete function
        $this->assertTrue(delete_dbDonations($donation->get_id()));
        $this->assertTrue(delete_dbDonations($donation2->get_id()));
        $this->assertTrue(delete_dbDonations($donation3->get_id()));
        $this->assertFalse(retrieve_dbDonations($donation2->get_id()));
                 
        echo ("testdbDonations complete");
    }
}
