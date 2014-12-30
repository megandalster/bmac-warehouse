<?php 
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homeplate, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/**
 * User tutorial page for viewing, editing and removing donations in the system.
 * @author Nicholas Wetzel
 * @version December 2, 2013
 */

?>

<!DOCTYPE html>
<html>
<head>
	<title>Help: Viewing, Editing and Removing Donations</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
	<h1>Viewing, Editing and Removing Donations from the Log</h1>
			
	<p><b>Step 1: </b>Navigate to today's donation log by clicking the <b>donations</b> link in the page header.</p>
	<a href="tutorial/screenshots/DonationLog.png" class="centered" title="DonationLog" style="width:500px; display:block;">
		<img class="centered" src="tutorial/screenshots/DonationLog.png" style="display:block; width:500px; border-width:1px; border-style:solid">
	</a>
	<p>If you wish to view the log of a different day, you can use the <b>Previous Day</b> and <b>Next Day</b> links
		above the table of donations. 
		
	<p><b>Step 2: </b>Click on a donor's name associated with a donation to view that particular donation's details.</p>
	<a href="tutorial/screenshots/EditDonation.png" class="centered" title="EditDonation" style="width:500px; display:block;">
		<img class="centered" src="tutorial/screenshots/EditDonation.png" style="display:block; width:500px; border-width:1px; border-style:solid">
	</a>
	<p>Doing this will generate a default donation form with values corresponding to those of the selected donation.</p>
	<a href="tutorial/screenshots/SampleDonation.png" class="centered" title="SampleDonation" style="width:500px; display:block;">
		<img class="centered" src="tutorial/screenshots/SampleDonation.png" style="display:block; width:500px; border-width:1px; border-style:solid">
	</a>
	
	<p><b>Step 3: </b>You may now edit the selected donation just as you would if you were adding a new donation. Click
		<a href="http://localhost/mch-homeplatecivi/help.php?helpPage=viewDonation2.php">here</a> for more information on
		how to do that. You can also delete a donation from the log by clicking the red <b>Delete</b> button at the 
		bottom of the form. A green notification box will appear after a successful deletion:</p>
	<a href="tutorial/screenshots/DeleteDonation.png" class="centered" title="Delete" style="width:500px; display:block;">
		<img class="centered" src="tutorial/screenshots/DeleteDonation.png" style="display:block; width:500px; border-width:1px; border-style:solid">
	</a>
	
	<p><b>Step 4: </b>If you have removed a donation, then you can navigate back to the current donation log
		by clicking the <b>Return to Donation Log</b> button inside the green notification box. Please note that this
		button will navigate you back to the <i>present</i> day's donation log. Therefore, if you deleted or
		edited a donation from a different day, you would have to navigate back to that donation log to see the changes.
	
</body>
</html>