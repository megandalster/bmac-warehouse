<?php 
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homeplate, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/**
 * User tutorial page for general management of donations.
 * @author Nicholas Wetzel
 * @version December 2, 2013
 */

?>

<!DOCTYPE html>
<html>
<head>
	<title>Help: Working with Donations</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

	<h1>Working with Donations</h1>
	
	<p> The <b>donation log</b> is a list of all donations recorded today. You may add a donation to the log, remove a donation from the log, 
	or add new donors who aren't already in the database before recording their donations. Follow the steps below
	to get acquainted with the donation management capabilities.</p>
	
	<p><b>Step 1: </b>Navigate to today's donation log by clicking the <b>donations</b> link in the page header.</p>
	<a href="tutorial/screenshots/DonationLog.png" class="centered" title="DonationLog" style="width:500px; display:block;">
		<img class="centered" src="tutorial/screenshots/DonationLog.png" style="display:block; width:500px; border-width:1px; border-style:solid">
	</a>	
	<p>This will bring up the current day's donation log. If no donations have been recorded 
		for the current day, then we will see an empty table. However, if there are donations associated with the 
		current day, then we should see them listed like this:</p>
	<a href="tutorial/screenshots/SampleLog.png" class="centered" title="SampleLog" style="width:500px; display:block;">
		<img class="centered" src="tutorial/screenshots/SampleLog.png" style="display:block; width:500px; border-width:1px; border-style:solid">
	</a>
	<p>From this log, you can view, edit and remove any of the donations associated with that day. Click 
	<a href="http://localhost/mch-homeplatecivi/help.php?helpPage=donationLogView.php">here</a> for more information on that.
	You may also view and edit other daily donation logs by using the <b>Previous Day</b> and <b>Next Day</b> links above
	the list of donations.</p>
	
	<p><b>Step 2: </b>Navigate to the default donation form by clicking the <b>Add Donation</b> button in the
		donation log. This will generate the default donation form. For more information about adding donations, 
		click <a href="http://localhost/mch-homeplatecivi/help.php?helpPage=viewDonation2.php">here</a>.
	
</body>
</html>