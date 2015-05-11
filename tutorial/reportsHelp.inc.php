<?php
/*
 * Copyright 2013 by Jerrick Hoang, Ivy Xing, Sam Roberts, James Cook,
 * Johnny Coster, Judy Yang, Jackson Moniaga, Oliver Radwan,
 * Maxwell Palmer, Nolan McNair, Taylor Talmage, and Allen Tucker.
 * This program is part of RMH Homebase, which is free software.  It comes with
 * absolutely no warranty. You can redistribute and/or modify it under the terms
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 *
 */
?>
<script src="lib/jquery-1.9.1.js"></script>
<script src="lib/jquery-ui.js"></script>
<script
	src="lib/bootstrap/js/bootstrap.js"></script>

<script>
	$(function () {
		$('img[rel=popover]').popover({
			  html: true,
			  trigger: 'hover',
			  placement: 'right',
			  content: function(){return '<img border="3" src="'+$(this).data('img') + '" width="60%"/>';}
			});
	});
</script>

<p>
	<strong>Generating Reports</strong>
<p>
	<B>Step 1:</B> On the navigation bar at the top of the page, find <B>reports</B>
	, like this:<BR> <BR> <a href="tutorial/screenshots/ReportsHelp1.png"
		class="image" title="ReportsHelp1.png" horizontalalign="center"
		target="tutorial/screenshots/ReportsHelp1.png"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/ReportsHelp1.png" width="10%" rel="popover"
		data-img="tutorial/screenshots/ReportsHelp1.png" border="1px"
		align="center"> </a> <BR>
	<BR>Click on it and you should see the following page: <BR>
	<BR> <a href="tutorial/screenshots/ReportsHelp2.png" class="image"
		title="ReportsHelp2.png" horizontalalign="center"
		target="tutorial/screenshots/ReportsHelp2.png"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/ReportsHelp2.png" width="10%" rel="popover"
		data-img="tutorial/screenshots/ReportsHelp2.png" border="1px"
		align="center"> </a> <BR>
<p>
	<B>Step 2:</B>		
		Here you can select which report you want to run.
		<BR>
		<BR>
		To select a report, <b>click on</b> one of the reports on the menu like so:
		<BR>
	<BR>
	<a href="tutorial/screenshots/ReportsHelp3.png" class="image"
		title="ReportsHelp3.png" horizontalalign="center"
		target="tutorial/screenshots/ReportsHelp3.png"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/ReportsHelp3.png" width="10%" rel="popover"
		data-img="tutorial/screenshots/ReportsHelp3.png" border="1px"
		align="center"> </a> <BR>
	<BR>
<p>
<b>Note:</b> Steps 3-5 apply to only certain reports. Depending on the report you are
running, you can skip step 3, 4, or 5.
<p>
	<B>Step 3:</B> Once you have clicked on a report, you can now specify the time period of the report:
	<BR>This step only applies to:<BR>&nbsp&nbsp-Inventory Shipments<BR>&nbsp&nbsp-Inventory Receipts<BR>&nbsp&nbsp-Current Inventory<BR>&nbsp&nbsp-Current Providers
	<BR><BR> <a href="tutorial/screenshots/ReportsHelp41.png" class="image"
		title="ReportsHelp41.png" horizontalalign="center"
		target="tutorial/screenshots/ReportsHelp41.png"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/ReportsHelp41.png" width="10%" rel="popover"
		data-img="tutorial/screenshots/ReportsHelp41.png" border="1px"
		align="center"> </a> <BR><BR>
Using the Date Picker which will appear when clicking on the field: <BR>
&nbsp&nbsp-Fill in the "From" date with the starting date for your report. <BR>
&nbsp&nbsp-Fill in the "To" date with the ending date for your report.	
<BR><BR>
<b>Note:</b> If you want to view a report over all time, you can leave "From" and "To" blank. <BR>
&nbsp&nbsp-If you want to report all activity from a given date to to present, only fill in the "From" date. <BR>
&nbsp&nbsp-If you want to report all activity up to a given date, only fill in the "To" date. <BR>

<p>
	<B>Step 4:</B> Limiting the report to a particular Status:
	<BR>This step only applies to:<BR>&nbsp&nbsp-Current Inventory<BR>&nbsp&nbsp-Current Customers<BR>&nbsp&nbsp-Current Providers
	<BR><BR> <a href="tutorial/screenshots/ReportsHelp42.png" class="image"
		title="ReportsHelp42.png" horizontalalign="center"
		target="tutorial/screenshots/ReportsHelp42.png"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/ReportsHelp42.png" width="10%" rel="popover"
		data-img="tutorial/screenshots/ReportsHelp42.png" border="1px"
		align="center"> </a> <BR><BR>
By default, these reports only apply to products, customers, and providers with active status.  To obtain
these reports for inactive/discontinued products, customers, or providers, select "Inactive/Discontinued" in the Status drop-down menu:<BR>
<BR>
<p>
	<B>Step 5:</B> Specifying the Funding Source:
	<BR>This step only applies to:<BR>&nbsp&nbsp-Inventory Shipments<BR>&nbsp&nbsp-Inventory Receipts<BR>&nbsp&nbsp-Current Inventory
	<BR><BR> <a href="tutorial/screenshots/ReportsHelp43.png" class="image"
		title="ReportsHelp43.png" horizontalalign="center"
		target="tutorial/screenshots/ReportsHelp43.png"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/ReportsHelp43.png" width="10%" rel="popover"
		data-img="tutorial/screenshots/ReportsHelp43.png" border="1px"
		align="center"> </a> <BR><BR>
Using the Drop down menu which will appear when clicking on the field: <BR>
&nbsp&nbsp-Select the status for which you want to filter the results. <BR>
<BR>
<b>Note:</b> If you leave this field set to "any", your report will cover all funding sources. <BR>
<p>
	<B>Step 6:</B> To generate your report, select the <B>Submit</B> button, like this:<BR> <BR>
	<a href="tutorial/screenshots/ReportsHelp5.png" class="image"
		title="ReportsHelp5.png" horizontalalign="center"
		target="tutorial/screenshots/ReportsHelp5.png"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/ReportsHelp5.png" width="10%" rel="popover"
		data-img="tutorial/screenshots/ReportsHelp5.png" border="1px"
		align="center"> </a>
<p>
	<BR>The report for <B>Inventory Shipments</B> or <B>Inventory Receipts</B> may look like this: <BR>
		<BR> <a href="tutorial/screenshots/ReportsHelp61.png" class="image"
		title="ReportsHelp61.png" horizontalalign="center"
		target="tutorial/screenshots/ReportsHelp61.png"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/ReportsHelp61.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/ReportsHelp61.png"
		border="1px" align="center"> </a> <BR><BR>
	The report for <B>Current Providers</B> may look like this:<BR> <BR> 
	<a	href="tutorial/screenshots/ReportsHelp6.png" class="image"
		title="ReportsHelp6.png" horizontalalign="center"
		target="tutorial/screenshots/ReportsHelp6.png"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/ReportsHelp6.png" width="10%" rel="popover"
		data-img="tutorial/screenshots/ReportsHelp6.png" border="1px"
		align="center"> </a> <BR>Note that the report sums up a provider's billed amount & total weight after the bolded line. <BR>
	<BR>The report for <B>Current Inventory</B> may look like this:
	<BR>
	<BR> <a href="tutorial/screenshots/ReportsHelp62.png" class="image"
		title="ReportsHelp62.png" horizontalalign="center"
		target="tutorial/screenshots/ReportsHelp62.png"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/ReportsHelp62.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/ReportsHelp62.png"
		border="1px" align="center"> </a> <BR>Note that the current stock weight is computed by subtracting shipment weight and adding receipts weight to the last inventory weight.<BR>
	<BR>And the report for <B>Current Customers</B> may look
	like this: <BR>
	<BR> <a href="tutorial/screenshots/ReportsHelp63.png" class="image"
		title="ReportsHelp63.png" horizontalalign="center"
		target="tutorial/screenshots/ReportsHelp63.png"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/ReportsHelp63.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/ReportsHelp63.png"
		border="1px" align="center"> </a> <BR>Note that clicking on a customer leads to that customer's information page.
<p>
	<B>Step 7:</B> You may export your report to a CSV file for further processing as a spreadsheet.  
	To do this, check the box to the right of the "Submit" button and hit that button again.  Your report
	will be saved as the file "export.csv", which you can download by pointing your browser to it.  
	<br><br>That is,
	go to the URL in your browser and change the phrase that begins "reports.php" to "export.csv" and hit
	enter.  The file "export.csv" should now appear in your computer's Downloads folder and can be immediately
	opened in Excel.
<p>	
	<B>Step 8:</B> When you finish, you can generate a new report by
	refreshing the page and following the steps above.  Or else you may return to any
	other function by selecting it on the navigation bar.