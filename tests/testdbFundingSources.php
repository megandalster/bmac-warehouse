<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker.  This program is part of BMAC-Warehouse, which is free software. It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

include_once(dirname(__FILE__).'/../database/dbFundingSources.php');
class testdbFundingSources extends UnitTestCase {
    function testdbFundingSourcesModule() {
                  
        // testing getter functions
        $this->assertTrue(delete_funding_source("CSFP"));
        $this->assertTrue(add_funding_source("CSFP","2CSFP"));
        $fs = get_all_funding_sources();
        foreach ($fs as $source=>$aliases) {
        	echo $source.":".$aliases."\n";
        }         
        echo ("testdbFundingSources complete\n");
    }
}

?>
