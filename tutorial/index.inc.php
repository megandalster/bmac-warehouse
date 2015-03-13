<?PHP
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homeplate, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */
	session_start();
	session_cache_expire(30);
?>
<html>
	<head>
		<title>	MCH Homeplate Help Index</title>
		<link rel="stylesheet" type="text/css" href="styles.css"> 
	</head>
<body>
<ol>	
	<li class="helpList"><a href="?helpPage=viewDonation1.php">Working with Donations</a>
		<ul class="helpList">
			<li class="helpList"><a href="?helpPage=viewDonation2.php">Adding a New Donation</a></li>
			<li class="helpList"><a href="help.php?helpPage=donationLogView.php">Editing and Removing Donations from the Log</a></li>
		</ul>
	</li>
	<li class="helpList"><b>Working with the Donor Database</b>
		<ul class="helpList">
			<li class="helpList"><a href="?helpPage=donorSearch.php">Searching for Donors</a></li>
		    <li class="helpList"><a href="?helpPage=donorEdit.php">Editing Donors</a></li>
		    <li class="helpList"><a href="?helpPage=donorForm.php">Adding New Donors </a></li>
		</ul>
	</li>
	<li class="helpList"><a href="?helpPage=viewReports.php">Generating and Exporting Reports</a> (Managers Only)</li>
</ol>
	<p>If these help pages don't answer your questions, please contact the <a href="mailto:bm$mchpp.org">Operations Manager</a>
		 or call the office (207-725-2716).</p>
</body>
</html>

