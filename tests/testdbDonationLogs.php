<?php
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homeplate, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/*
 * Created Febuary 27, 2008
 * @author Richardo 
 */
include_once(dirname(__FILE__).'/../domain/DonationLog.php'); 
include_once(dirname(__FILE__).'/../database/dbDonationLogs.php');
class testdbDonationLogs extends UnitTestCase {
      function testdbDonationLogsModule() {
      	
 			//Test table creation
			// $this->assertTrue(create_dbDonationLogs()); 	  	
			$r1 = new DonationLog("11-12-28HHI", "","", "Note.");
			$this->assertTrue(insert_dbDonationLogs($r1));

			$r2 = new DonationLog("13-10-12HHI", "", "", "Note - boxes are heavy.");
			$this->assertTrue(insert_dbDonationLogs($r2));
			// should return false for a duplicate entry
	//		$this->assertFalse(insert_dbDonationLogs($r2));

			//get a donationLog
			$r = get_donationLog("11-12-28");
			$this->assertTrue($r != null);

			//remove all DonationLogs
			$this->assertTrue(delete_dbDonationLogs($r1));
			$this->assertTrue(delete_dbDonationLogs($r2));
			//try to remove a donationLog that is not in the db - should not work
			$this->assertFalse(delete_dbDonationLogs($r2));

			echo("testdbDonationLogs complete");

      }
}


?>
