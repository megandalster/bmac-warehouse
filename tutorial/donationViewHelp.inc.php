<?php
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homeplate, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */ 

/**
 * User tutorial page for adding donations to the system.
 * @author Nicholas Wetzel
 * @version December 2, 2013
 */

?>

<!DOCTYPE html>
<html>
<head>
	<title>Help: Adding a Donation</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

	<h1>Adding a New Donation</h1>
	
	<p><b>Step 1: </b>To add a donation, first click on <b>donations</b> in the page header. This will bring you
		to the current day's donation log. From, here you can click on the <b>Add Donation</b> button in order
		to add a new donation to today's log. Please note that a donation can only be added to the current date at the current time.</p>
	<a href="tutorial/screenshots/DonationLog.png" class="centered" title="AddDonation" style="width:500px; display:block;">
		<img class="centered" src="tutorial/screenshots/DonationLog.png" style="display:block; width:500px; border-width:1px; border-style:solid">
	</a>
	<a href="tutorial/screenshots/AddDonation.png" class="centered" title="AddDonation" style="margin-top:20px; width:500px; display:block;">
		<img class="centered" src="tutorial/screenshots/AddDonation.png" style="display:block; width:500px; border-width:1px; border-style:solid">
	</a>
	<p>This should bring up a default donation form that looks similar to this:</p>
	<a href="tutorial/screenshots/DonationForm2.png" class="centered" title="DonationForm2" style="width:500px; display:block;">
		<img class="centered" src="tutorial/screenshots/DonationForm2.png" style="display:block; width:500px; border-width:1px; border-style:solid">
	</a>
			
	<p><b>Step 2: </b> Choose the appropriate donation form using the <b>Switch Form</b> button.
	   	The default form is used for donations that have <i>multiple</i> food types and the other 
	   	form is used for donations of only <i>one</i> type of food item. The single food type form looks similar
	   	to this: </p>
	<a href="tutorial/screenshots/DonationForm1.png" class="centered" title="DonationForm1" style="width:500px; display:block;">
		<img class="centered" src="tutorial/screenshots/DonationForm1.png" style="display:block; width:500px; border-width:1px; border-style:solid">
	</a>
	<p><b>Note: </b>Using the default form for <i>single</i> food type donations will work just as well as using the 
		<i>single</i> type form. All other types will simply have a weight equal to zero, which is already preset on the form.</p>
	
	<p><b>Step 3: </b>Choose a donor by typing the name into the <b>Donor</b> search bar. 
		As you type, a list of matching names should appear in a drop-down menu. Simply click on
		the desired donor name.</p>
	<a href="tutorial/screenshots/ChooseDonor.png" class="centered" title="ChooseDonor" style="width:500px; display:block;">
		<img class="centered" src="tutorial/screenshots/ChooseDonor.png" style="display:block; width:500px; border-width:1px; border-style:solid">
	</a>
	<p>If the name of the donor does not appear in the drop-down menu, then the new donor can be added by clicking
		the <b>New Donor</b> button. This will take you to a form for adding a new donor. Click 
		<a href="http://localhost/mch-homeplatecivi/help.php?helpPage=donorForm.php">here</a> for more details
		on how to do that. Once the new donor has been added, you can return to the donation form by clicking the 
		<b>Return to Donation Form</b> link.
		
	<p><b>Step 4: </b>Insert the the weight totals associated with the food type(s). Any additional notes about the
		donation can also be added in the <b>Additional Notes</b> section at the bottom.</p>
	<a href="tutorial/screenshots/AddingWeights.png" class="centered" title="AddingWeights" style="width:500px; display:block;">
		<img class="centered" src="tutorial/screenshots/AddingWeights.png" style="display:block; width:500px; border-width:1px; border-style:solid">
	</a>

	<p><b>Step 5: </b>If all information on the form is accurate, you can click the green <b>Submit</b> button at the bottom
		of the page. If you wish to clear the entire form and start over, then you can hit the yellow <b>Clear</b> button.
		If there are entry errors in the form, warnings will appear asking the user to correct them:</p>
   	<a href="tutorial/screenshots/EntryError.png" class="centered" title="EntryError" style="width:500px; display:block;">
		<img class="centered" src="tutorial/screenshots/EntryError.png" style="display:block; width:500px; border-width:1px; border-style:solid">
	</a>
	<p>We can see that invalid input was placed into the <i>Refrigerated</i> weight box. Fixing this issue and clicking
		submit again should generate a successful submission. The user is notified of a successful submission with a 
		green notification box:</p>
	<a href="tutorial/screenshots/SubmissionSuccess.png" class="centered" title="SubmissionSuccess" style="width:500px; display:block;">
		<img class="centered" src="tutorial/screenshots/SubmissionSuccess.png" style="display:block; width:500px; border-width:1px; border-style:solid">
	</a>
	
	<p><b>Step 6: </b>Once the donation has been submitted successfully, you can click on the <b>Return to Donation Log</b>
		button inside the green notification box or the <b>Return to Donation Log</b> link at the bottom of the page to return
		to the current day's donation log. The donation that was just added should now appear in the donation log.</p>
</body>
</html>