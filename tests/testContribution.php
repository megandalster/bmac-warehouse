<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker.  This program is part of BMAC-Warehouse, which is free software. It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

include_once(dirname(__FILE__).'/../domain/Contribution.php');
class testContribution extends UnitTestCase {
    function testContributionModule() {
             
    	//fake contribution to test
        $contribution = new Contribution("John Jones", "15-02-05", array("Cranapple Juice:100"), "THIS IS A TEST");
                 
        // testing getter functions
        $this->assertTrue($contribution->get_provider_id() == "John Jones");
		$this->assertTrue($contribution->get_receive_date() == "15-02-05");
		$this->assertTrue($contribution->get_receive_items() == array("Cranapple Juice:100"));
		$this->assertTrue($contribution->get_notes() == "THIS IS A TEST");
                  
        echo ("testContribution complete\n");
    }
}

?>
