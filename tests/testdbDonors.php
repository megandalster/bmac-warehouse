<?php
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homeplate, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/**
 * Provides the test module for the dbDonors file.
 * @author Nicholas Wetzel
 * @version May 9, 2012
 */

include_once(dirname(__FILE__).'/../domain/Donor.php');
include_once(dirname(__FILE__).'/../database/dbDonors.php'); 
class testdbDonors extends UnitTestCase {
	
	function testdbDonorsModule() {
	
		//Test Donors
		$donor1 = new Donor("Whole Foods Brunswick", "Jan", "21", "2000", "organization", "123 Maine St", "Brunswick", 
                            "ME", "04011", "2077253500", "Alex Ovechkin", "aovechkin@bowdoin.edu", "This is a test case");
        $donor2 = new Donor("Hannafords", "Jul", "04", "2001", "organization", "345 Maine St", "Cornelius", 
                            "NC", "20511", "7048775483", "Harry Truman", "htruman@whitehouse.gov", "This is a test case #2");
        $donor3 = new Donor("Cecilia Jupe", "Nov", "21", "2002", "individual", "201 Lagoona Drive", "Brunswick", 
                            "ME", "04011", "207555555", "Cecilia Jupe", "cjupe@gmail.com", "This is a test case #3");

		//Test inserts
		$this->assertTrue(insert_dbDonors($donor1));
		$this->assertTrue(insert_dbDonors($donor2));
		$this->assertTrue(insert_dbDonors($donor3));
		
        //Test Retrieve
		$this->assertEquals(retrieve_dbDonors($donor1->get_id())->get_id(), "Whole Foods Brunswick");
		$this->assertEquals(retrieve_dbDonors($donor1->get_id())->get_month(), "Jan");
		$this->assertEquals(retrieve_dbDonors($donor1->get_id())->get_day(), "21");
		$this->assertEquals(retrieve_dbDonors($donor1->get_id())->get_year(), "2000");
		$this->assertEquals(retrieve_dbDonors($donor1->get_id())->get_type(), "organization");
		$this->assertEquals(retrieve_dbDonors($donor1->get_id())->get_address(), "123 Maine St");
		$this->assertEquals(retrieve_dbDonors($donor1->get_id())->get_city(), "Brunswick");
		$this->assertEquals(retrieve_dbDonors($donor1->get_id())->get_state(), "ME");
		$this->assertEquals(retrieve_dbDonors($donor1->get_id())->get_zip(), "04011");
		$this->assertEquals(retrieve_dbDonors($donor1->get_id())->get_phone1(), "2077253500");
		$this->assertEquals(retrieve_dbDonors($donor1->get_id())->get_contact(), "Alex Ovechkin");
		$this->assertEquals(retrieve_dbDonors($donor1->get_id())->get_email(), "aovechkin@bowdoin.edu");
		$this->assertEquals(retrieve_dbDonors($donor1->get_id())->get_notes(), "This is a test case");
		
		//Test Update with a change of chain name & comment
		$donor2 = new Donor("Hannafords", "Jul", "04", "2001", "organization", "345 Maine St", "Cornelius", 
                            "NC", "20511", "7048775483", "Harry Truman", "new", "This is a test case #2");
		$this->assertTrue(update_dbDonors($donor2));
		$this->assertEquals(retrieve_dbDonors($donor2->get_id())->get_email(), "new");
		
		//Test Delete
		$this->assertTrue(delete_dbDonors($donor1->get_id()));
		$this->assertTrue(delete_dbDonors($donor2->get_id()));
		$this->assertTrue(delete_dbDonors($donor3->get_id()));
		$this->assertFalse(retrieve_dbDonors($donor1->get_id()));
		
		echo ("testdbDonors complete \n");
	}
}
?>