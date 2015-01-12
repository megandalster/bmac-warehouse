<?php

/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homerestore, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/*
 *  Enable the user to generate reports of previous donations based
 *  on donor type, donation type, donor name and date range.
 *  
 *  @author Nicholas Wetzel & Kevin Tabb
 *  @version December 21, 2013
 */

session_start();
session_cache_expire(30);

include_once('database/dbDonors.php');
include_once('domain/Donor.php');

// Setting the default time zone
date_default_timezone_set('America/New_York');

// grab the current date
$today = date('Y-M-d');
$currentday = substr($today, 9, 2);
$currentmonth = substr($today, 5, 3);
$currentyear = substr($today, 0, 4);

// An array of all of our known donors
$donor_array = getall_dbDonors();
$num_donors = count($donor_array);

// Build a concatenated string of donors used to set up javaScript array of donors
$donor_names = array();
for($i = 0; $i < count($donor_array); $i++){
	$donor_names[$i] = $donor_array[$i]->get_id();
}
$donors = implode(",", $donor_names);

?>
<html>
<head>
	<title>Reports</title>
	<link rel="stylesheet" href="styles.css" type="text/css" />
</head>

<body onload="build_donor_array('<?php echo $donors ?>')">

<div id="container"><?php include('header.php');?>

<div id="content">
<?php echo "<h4>Today is ".date('l F j, Y', time())."</h4>"; ?>

<!-- Form for selecting report criteria -->
<form method="post">

<br>

<!-- Report type -->
<div>
<p style="display:inline">Report selection :</p>
<select name="report_type">
	<option value=""></option>
	<option value="truck1">Truck 1 only</option>
	<option value="truck2">Truck 2 only</option>
	<option value="decons">DECONs only</option>
</select>
</div>

<br>

<!-- Allow the user to select a specific donor by name -->
<p style="display:inline;">Single Donor Option (type name or leave blank) :</p>
<div style="display:inline; position:absolute; width:250px; z-index:100;">
<input type="text" name="donor_name" id="donor_name" value="" onkeyup="update_donor_dropdown()" 
       onclick="update_donor_dropdown()" style="width:250px; position:relative; bottom:3px">
<table id="search_table" style="background:#dddddd; width:250px; position:relative; bottom:3px"></table>
</div>

<br><br>

<!-- Date Range -->
<fieldset class="padded"><legend>Select Report Dates</legend>

<!-- Query previous week -->
<div>
	<input type="radio" name="report_span" value="weekly"> 
	<p style="display:inline">Last Week</p>
</div>

<br>

<!-- Query a specific date -->
<div>
	<input type="radio" name="report_span" value="daily">
	<p style="display:inline">Single Day</p>
	<?php 
	
	$months = array ("Jan", "Feb", "Mar", "Apr", "May", "Jun",
				 "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

	// month selector
	echo '<select name="daily_month">';
	foreach($months as $month){
		if($month == $currentmonth)
			echo '<option value="'.$month.'" selected>'.$month.'</option>';
		else 
			echo '<option value="'.$month.'">'.$month.'</option>';
	}
	echo '</select>&nbsp;';

	// day selector
	echo '<select name="daily_day">';
	for($i = 1; $i <=31; $i++){
		if($i == $currentday)
			echo '<option value="'.$i.'" selected>'.$i.'</option>';
		else
			echo '<option value="'.$i.'">'.$i.'</option>';
	}
	echo '</select>';

	// year selector
	echo '<select name="daily_year">';
	for($i = $currentyear; $i >= 1990; $i--){
		echo '<option value="'.$i.'">'.$i.'</option>';
	}
	echo '</select>';
	?>
</div>
 
<br>

<!-- Query a given date range -->
<div>
	<input type="radio" name="report_span" value="range"> 
	<p style="display:inline">Date Range</p>
	<?php 

	// starting month selector
	echo '<select name="range_month_start">';
	foreach($months as $month){
		echo '<option value="'.$month.'">'.$month.'</option>';
	}
	echo '</select>&nbsp;';

	// starting day selector
	echo '<select name="range_day_start">';
	for($i = 1; $i <=31; $i++){
		echo '<option value="'.$i.'">'.$i.'</option>';
	}
	echo '</select>';

	$current_time = getdate(time());

	// starting year selector
	echo '<select name="range_year_start">';
	for($i = $currentyear; $i >= 1990; $i--){
		echo '<option value="'.$i.'">'.$i.'</option>';
	}
	echo '</select>&nbsp; to ';

	// end month selector
	echo '<select name="range_month_end">';
	foreach($months as $month){
		echo '<option value="'.$month.'">'.$month.'</option>';
	}
	echo '</select>&nbsp;';

	// end day selector
	echo '<select name="range_day_end">';
	for($i = 1; $i <=31; $i++){
		echo '<option value="'.$i.'">'.$i.'</option>';
	}
	echo '</select>';

	// end year selector
	echo '<select name="range_year_end">';
	for($i = $currentyear; $i >= 1990; $i--){
		echo '<option value="'.$i.'">'.$i.'</option>';
	}
	echo '</select>';
?>
</div>

</fieldset>
<br>

<!-- submit button -->
<input type="hidden" name="submitted" value="true">
<input type="submit"name="generate" value="Generate Report">
</form>

<?php
// if the request has been submitted then process it
if(isset($_POST['submitted'])){

	// time stamp the report
	$today = date("F j, Y");
	
	// generate the report header and pdf headers
	$header = array("<p><b>Habitat for Humanity ReStore Donation Report</b></p>");
	$header[] = "<p>Report generated on: ".$today."</p>";
	
	$pdfHeader = array("Report generated on: ".$today);
	
	// report type
	$header[] = "<p>Report type: ";
	
	if ($_POST['report_type'] == "foodtype"){
		$header[] = "Item Type Breakdown</p>";
		$pdfHeader[] = "Report type: Item Type Breakdown";
	}
	else if($_POST['report_type'] == "totalweight"){
		$header[] = "Total Items</p>";
		$pdfHeader[] = "Report type: Total Items";
	}
	else{
		$header[] = "Not specified</p>";
		$pdfHeader[] = "Report type: Not specified";
	}
	
	// donor scope
	$header[] = "<p>Donors: ";
	
	if ($_POST['donor_name']!=""){
		$header[] = $_POST['donor_name']."</p>";
		$pdfHeader[] = "Donors: ".$_POST['donor_name'];
	}
	else if($_POST['report_group'] == "individual"){
		$header[] = "Individuals</p>";
		$pdfHeader[] = "Donors: Individuals";
	}
	else if($_POST['report_group'] == "organization"){
		$header[] = "Organizations</p>";
		$pdfHeader[] = "Donors: Organizations";
	}
	else{
		$header[] = "All</p>";
		$pdfHeader[] = "Donors: All";
	}
	
	// date range
	$header[] = "<p>Date Range: ";
	
	// determine the date range type we are using
	if($_POST['report_span'] == "weekly")
	{
		$time = strtotime('last monday', strtotime('tomorrow',time())) - 604800;
		$endTime = $time + 518400;

		$start_date = date('y-m-d', $time);
		$end_date = date('y-m-d', $endTime);

		$header[] = "Week of ".date('l F j, Y', $time)."</p>";
		$pdfHeader[] = "Date Range: Week of ".date('l F j, Y', $time);
	}

	else if($_POST['report_span'] == "daily")
	{
		$month = $_POST['daily_month'];
		$day = $_POST['daily_day'];
		$year = $_POST['daily_year'];

		$time = strtotime($month.' '.$day.', '.$year);
		
		$start_date = date('y-m-d', $time);
		$end_date = $start_date;
		
		$header[] = date('l F j, Y', $time)."</p>";
		$pdfHeader[] = "Date Range: ".date('l F j, Y', $time);
	}	
    else if($_POST['report_span'] == "range")
    {
		$time = strtotime($_POST['range_day_start'].$_POST['range_month_start'].$_POST['range_year_start']);
		$endTime = strtotime($_POST['range_day_end'].$_POST['range_month_end'].$_POST['range_year_end']);

		$start_date = date('y-m-d', $time);
		$end_date = date('y-m-d', $endTime);

		$header[] = date('F j, Y', $time) . " to " . date('F j, Y', $endTime)."</p>";
		$pdfHeader[] = "Date Range: ".date('F j, Y', $time) . " to " . date('F j, Y', $endTime);
		
		// make sure the date range is valid
		if($time > $endTime){
			$header[] = "<p style='color:red'>Sorry, the date range you entered is invalid.</p>";
			$pdfHeader[] = "Date Range: Sorry, the date range you entered is invalid.";
		}
	}
	else{
		$header[] = "<span style='color:red'>Please insert date range</span></p>";
		$pdfHeader[] = "Date Range: Please insert date range";
	}
	
	echo "<hr><br>";
	foreach ($header as $piece) echo $piece;
	echo "<br>";	
	
	// retrieve all of the donations matching the user criteria
	$all_donations = getall_dbDonations_between_dates($_POST['donor_name'], $start_date, $end_date);

	// set session variables used for generating PDF report
	$_SESSION['donor_name_pdf'] = $_POST['donor_name'];
	$_SESSION['start_date'] = $start_date;
	$_SESSION['end_date'] = $end_date;
	$_SESSION['type_pdf'] = $_POST['report_type'];
	$_SESSION['pdfHeaders'] = implode("?", $pdfHeader);
	
	// finally build the table
	build_table($_POST['report_type'], $_POST['report_group'], $_POST['donor_name'], 8, $all_donations);
	
	// add the option to open it up as a PDF
	echo '<a href="viewReportPDF.php" target="_blank" style="display:inline-block; margin:20px 15px; width:100px">Generate PDF</a>';
}

/*
 * Method for building the report table.
 * @arguments: 
 * 		type -> ("totalweight" or "foodtype")
 * 		group -> ("all", "individuals" or "organizations")
 * 		donor -> (name of donor if specified)
 * 		items_per_donation -> (number of food item types in a donation)
 * 		donations -> (array of donations)
 */ 
function build_table($type, $group, $donor, $items_per_donation, $donations){

	// keep track of total weights
	$type_weights = array("Household" => 0,"Appliances" => 0, "Building" => 0, "Other" => 0);
	
	// add a boolean variable to determine if we need to check by donor type
	$check_group = ($group != "all" && $donor == "" ? true : false);
	
	echo "<table style='margin-left:15px'><tr style='background-color:#adc2eb'>";
	echo "<td class='report_cell'><b>Donor<b></th>";
	echo "<td class='report_cell'><b>Date</b></th>";

	// if generating by foodtype
	if($type == "foodtype"){
		foreach($type_weights as $item => $weight)
			echo("<td class='report_cell'><b>".$item."</b></td>");
	}

	echo "<td class='report_cell'><b>Total Items</b></td>";
	echo "</tr>";
	
	// helper variable for alternating row colors
	$row_index = 0;
	
	// each donation generates a row in the table
	foreach($donations as $donation){

		// if we need to check for type then we have to pull from dbDonors
		if($check_group){
			$donor = retrieve_dbDonors($donation->get_donor_id());
			if($donor->get_type() != $group)
				continue;
		}
		// create alternating row colors
		if($row_index % 2)
			echo "<tr style='background-color:#dddddd'>";
		else
			echo "<tr style='background-color:#efefef'>";
		
		echo "<td class='report_cell'>".$donation->get_donor_id()."</td>";
		echo "<td class='report_cell'>".$donation->get_date()."</td>";

		// if we are generating by foodtype then print out all of the foodtype weights
		if($type == "foodtype"){
			$j = 0;
			foreach($type_weights as $item => &$weight){
				echo "<td class='report_cell'>".$donation->get_item_weight($j)."</td>";
				$weight += $donation->get_item_weight($j);
				++$j;
			}
		}

		echo "<td class='report_cell'>".$donation->get_item_count()."</td>";
		$total_weight += $donation->get_item_count();
		$row_index++;
	}
	
	// finally add the total weight row
	echo "<tr>";
	
	// empty cells for alignment
	echo "<td></td><td></td>";
	
	// add total weights for food types
	if($_POST['report_type'] == "foodtype"){
		foreach($type_weights as $item => $weight)
			echo "<td class='report_cell' style='background-color:#ffff88'>".$weight."</td>";
	}
	// add the total weight cell
	echo "<td class='report_cell' style='background-color:#ffff88'>".$total_weight."</td>";
	// close the table 
	echo "</tr></table>";
	
}

function export_foodtype_data($header, $food_types, $row_totals, $food_type_totals ) {
	$filename = "dataexport.csv";
	$handle = fopen($filename, "w");
	fputcsv($handle, $header);
	fputcsv($handle, $food_types);
	foreach ($row_totals as $row_total) {
		fputcsv($handle, $row_total);
	}
	fputcsv($handle, $food_type_totals);
	fclose($handle);	
}

function export_data($header, $donations, $tw) {
	$filename = "dataexport.csv";
	$handle = fopen($filename, "w");
	
	fputcsv($handle, $header);
	for ($i=0; $i<count($donations); ++$i) {
		if($donations[$i] != null)
			$myArray = array($donations[$i]->get_donor_id(),$pickups[$i]->get_total_weight());
		else 
			$myArray = array("","");
		fputcsv($handle, $myArray);
	}
	$myArray = array("Totals", $twp, "Totals", $twd);
	fputcsv($handle, $myArray);
	fclose($handle);	
}

?> 
<table></table>
</div>
<?php include('footer.inc');?>
</div>

<script type="text/javascript">

    var donors = new Array();

	// Method for building the array of donor names 
	function build_donor_array(donor_names){
		var temp_donors = donor_names.split(",");
 		for(var i = 0; i < temp_donors.length; i++){
 	 		var donor = temp_donors[i];
			donors.push(donor);
 		}
	}

	// Method for updating the list of donors matching the search results 
	function donor_search_array(search_string, matches){
		var size = parseInt(search_string.length);
		for(var i = 0; i < donors.length; i++){
			if(search_string.localeCompare(donors[i].substr(0, size)) == 0)
				matches.push(donors[i]);
		}
	}

	// Method for building the drop down list based on user search input 
	function update_donor_dropdown(){

		// initial empty array of matches 
		var matches = new Array();
		
		// first clear the search table completely 
		var table = document.getElementById("search_table");
		while(table.lastChild){
			table.removeChild(table.lastChild);
		}

		// make sure the table is visible 
		table.style.display = "block";

		// grab the input and find the matching donors 
		var search_box = document.getElementById("donor_name");
		var search_string = document.getElementById("donor_name").value;
		donor_search_array(search_string, matches);

		// only add elements if the search string has input 
		if(search_string.length){
			// add a new element to the drop down menu for each of the matches 
			for(var i = 0; i < matches.length; i++){
				// create the elements 
				table.insertRow(-1);  
				var row = table.rows.item(table.rows.length - 1);
				row.insertCell(-1);
				var cell = row.cells.item(row.cells.length - 1);

				// now link the text (donor name) to the cell and set the style
				cell.innerHTML = matches[i];
				cell.style.width = "250px";
				cell.onclick = function(){search_box.value = this.innerHTML;table.style.display = "none"};
				cell.onmouseover = function(){this.style.background = "#EEEEEE";this.style.cursor = "pointer";};
				cell.onmouseout = function(){this.style.background = "#DDDDDD";};
			}
		}
	}
	
</script>
</body>
</html>
