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
        $this->addTestFile(dirname(__FILE__).'/testPerson.php');
        $this->addTestFile(dirname(__FILE__).'/testdbPersons.php');
        $this->addTestFile(dirname(__FILE__).'/testProvider.php');
         
        echo ("All tests complete");
 	  }
 }
?>
