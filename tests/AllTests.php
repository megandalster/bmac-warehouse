<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker.  This program is part of BMAC-Warehouse, which is free software. It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */
/*
 * Run all the BMAC-Warehouse unit tests
 */

class AllTests extends GroupTest{
	
 	  function AllTests() {
        $this->addTestFile(dirname(__FILE__).'/testPerson.php');
        $this->addTestFile(dirname(__FILE__).'/testProduct.php');
        $this->addTestFile(dirname(__FILE__).'/testdbPersons.php');

        $this->addTestFile(dirname(__FILE__).'/testProvider.php');
        $this->addTestFile(dirname(__FILE__).'/testShipment.php');
        $this->addTestFile(dirname(__FILE__).'/testContribution.php');
        $this->addTestFile(dirname(__FILE__).'/testCustomer.php');
        $this->addTestFile(dirname(__FILE__).'/testdbProducts.php');  
        $this->addTestFile(dirname(__FILE__).'/testdbCustomers.php');
        
         
        echo ("All tests complete");
 	  }
 }
?>
