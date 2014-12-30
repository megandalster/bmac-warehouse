<?php
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homeplate, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/*
 * Run all the RMH Homeroom unit tests
 */

class AllTests extends GroupTest{
	
 	  function AllTests() {
        $this->addTestFile(dirname(__FILE__).'/testDonor.php');
		$this->addTestFile(dirname(__FILE__).'/testDonationLog.php');
        $this->addTestFile(dirname(__FILE__).'/testDonation.php');
        $this->addTestFile(dirname(__FILE__).'/testVolunteer.php');
        //$this->addTestFile(dirname(__FILE__).'/testDonationReport.php');
     //   $this->addTestFile(dirname(__FILE__).'/testdbDonors.php');
		$this->addTestFile(dirname(__FILE__).'/testdbDonationLogs.php');
        $this->addTestFile(dirname(__FILE__).'/testdbDonations.php');
        $this->addTestFile(dirname(__FILE__).'/testdbVolunteers.php');
        //$this->addTestFile(dirname(__FILE__).'/testdbDonationReports.php');
        
        echo ("All tests complete");
 	  }
 }
?>
