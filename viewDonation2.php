<?php

/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen 
 * Tucker.  This program is part of Homerestore, which is free software.  It comes 
 * with absolutely no warranty.  You can redistribute and/or modify it under the 
 * terms of the GNU Public License as published by the Free Software Foundation 
 * (see <http://www.gnu.org/licenses/). 
*/

/*
 * One of the donation templates for Homerestore. This donation
 * template records the weight of a predefined set of product types
 * for any given donation.
 *
 * @author Nicholas Wetzel & Kevin Tabb
 * @version December 21, 2013
 */

/*
 * This file creates the data entry page for donations that record separate entries for
 * different product types.
 */
session_start();
session_cache_expire(30);

include_once('database/dbDonationLogs.php');
include_once('domain/DonationLog.php');
include_once('database/dbDonations.php');
include_once('domain/Donation.php');
include_once('database/dbDonors.php');
include_once('domain/Donor.php');

// Setting the default time zone 
date_default_timezone_set('America/New_York');

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

<!DOCTYPE html>

<html>
<head>
<title>Donation</title>
<link rel="stylesheet" href="styles.css" type="text/css">
</head>
<body onload="build_donor_array('<?php echo $donors ?>')">

	<div id="container">
		<?php include('header.php');?>
		
		<div id="content">
			<br>
			<?php 
			$donationID = $_GET['donationID'];
			$thisDate = $_GET['date'];
			// if the current donation has not been created then create it and add it to the database.
				// otherwise, retrieve it from the database.
			if ($donationID == "new") {
					$donation1 = new Donation(date('y-m-dH:i:s'),"",$thisDate, "", "", "");
					echo "<b>Adding a new pick-up:</b><br><br>";
			}
			else{
					$donation1 = retrieve_dbDonations($donationID);
					echo "<b>Editing an existing pick-up:</b><br><br>";
			}

			// if values have been submitted, then validate and update the database if valid
			if(isset($_POST['submitted'])){
				$errors = false;
				
				// array of post variable names (with "nice name" values) that should be validated as numbers
				$post_names = array("household" => "Household Items", 
									"appliances" => "Appliances",
								    "building" => "Building Materials",
								    "other" => "Other");		
				// now check to make sure these are valid numbers
				foreach($post_names as $name => $nice_name){
					if($_POST[$name]!="" && !is_numeric($_POST[$name])){
						echo('<div class = "warning"><b>Please enter a valid '.$nice_name.' count.</b>
							  </div><br>'); $errors = true;
					}
				}
				// and check for a valid route
				if ($_POST['area']==""){
						echo('<div class = "warning"><b>Please select a route.</b></div><br>'); $errors = true;
				}
				// set the values based on the POST variables
				$area = $_POST['area'];
				$household = $_POST['household'];
				$appliances = $_POST['appliances'];
				$building = $_POST['building'];
				$other = $_POST['other'];
				$donation_notes = $_POST['donation_notes'];
				$item_count = $_POST['item_count'];
				$donor = $_POST['donor'];
				
				// make sure a donor is selected
				if(!in_array($donor, $donor_names)) {  // validate donor selection
					echo('<div class = "warning"><b>Please select a donor.</b>
						</div><br>'); $errors = true;
				}
				
				// if there are no syntax errors then set the donation elements
				if(!$errors) {
					$donation1->set_donor_id($donor);
					$donation1->set_area($area);
					$donation1->set_item("household",$household);
					$donation1->set_item("appliances",$appliances);
					$donation1->set_item("building",$building);
					$donation1->set_item("other",$other);
					$donation1->set_item_count($item_count);
					$donation1->set_notes($donation_notes);
					
					// find the associated donation log
					$dlog = get_donationLog($donation1->get_date());
					
					// create the donation log if it doesn't exist
					if(!$dlog){
						$dlog = new DonationLog($donation1->get_date(),"","","");
						insert_dbDonationLogs($dlog);
					}

					// add, replace or remove the contructed donation object
					if(isset($_POST['add'])){
						// add or replace the constructed donation to the database and donation log
						update_dbDonations($donation1);
						$dlog->add_donation($donation1->get_id());
						update_dbDonationLogs($dlog);  // also add the donation's id to this day's donation log
					
						echo('<div class="success"><p class="centered" style="width:200px; font-size="14px"><b>Donation successfully added!</b></p>');
						echo('<button type="submit" form="return" class="centered" style="width:200px; display:block;">');
						echo('<b>Return to Donation Log</b></button></div><br>');
					}
					// delete the donation object
					else if(isset($_POST['delete'])){
						
						// first check if the user actually wants to delete
						if($_POST['delete'] == 'confirm'){
							echo('<div class="notify"><p class="centered" style="width:338px; font-size="14px">');
							echo('<b>Are you sure you want to remove this donation?</b></p>');
							echo('<div class="centered" style="width:225px">');
							echo('<button name="delete" type="submit" form="donation_form" value="yes" style="width:100px; display:inline-block; margin-right:24px">Yes</button>');
							echo('<button name="delete" type="submit" form="donation_form" value="no" style="width:100px; display:inline-block;">No</button>');
							echo('</div></div><br>');
						}
						// remove the donation from the database and donation log
						else if($_POST['delete'] == 'yes'){
							if(retrieve_dbDonations($donation1->get_id())){
								delete_dbDonations($donation1->get_id());
								$dlog->remove_donation($donation1->get_id());
								update_dbDonationLogs($dlog);
								
								echo('<div class="success"><p class="centered" style="width:215px; font-size="14px"><b>Donation successfully removed!</b></p>');
								echo('<button type="submit" form="return" class="centered" style="width:200px; display:block;">');
								echo('<b>Return to Donation Log</b></button></div><br>');
							}
						}
					}
				}
			}
			// the donation already exists so we grab it from the database
			else{	
				// now set the values according to the new or existing donation
				$household = count($donation1->get_items()) > 0 ? intval($donation1->get_count(0)) : 0;
				$appliances = count($donation1->get_items()) > 0 ? intval($donation1->get_count(1)) : 0;
				$building = count($donation1->get_items()) > 0 ? intval($donation1->get_count(2)) : 0;
				$other = count($donation1->get_items()) > 0 ? intval($donation1->get_count(3)) : 0;
				$donation_notes = $donation1->get_notes();
				$item_count = intval($donation1->get_item_count());
				$donor = $donation1->get_donor_id();
				$date = $donation1->get_date();
			}
			?>

			<!-- The form to set all donation information except the date and time -->
			<form id="donation_form" name="donation_form" method="post">
			<fieldset>
				<legend>
					<b><i>Date / Route</i> </b>
				</legend>
				<?php
				echo $donation1->get_pretty_date() . " / ";
    			$areas = array(""=>"", "HHI"=>"Truck 1", "SUN"=> "Truck 2", "BFT"=> "DECON");
				echo('<select name="area">');
				foreach ($areas as $area => $route) {
  					echo ('<option value='.$area);
  					if ($donation1->get_area()==$area) 
  						echo (' SELECTED'); 
  					echo('>'.$route.'</option>');
				}
				echo('</select>');
				?>
			</fieldset>
			<br>
			
				<!-- An field to set the donor or create a new one -->
				<fieldset>
					<legend>
						<b><i>Donor</i> </b>
					</legend>
					<input type="text" id="donor" name="donor" value="<?php echo($donor == "" ? "Search..." : $donor);?>" onkeyup="update_donor_dropdown()" 
					       onclick="update_donor_dropdown()" style="width:250px; position:relative">
					       
					<table id="search_table" style="position:absolute; z-index:100; background:#dddddd; width:250px"></table>
					
					<button type="submit" value="new" name="id" form="donor_form">New Donor</button>
				</fieldset>
				<br>
				<!-- The data entry fields for product types and donation notes -->
				<fieldset>
					<legend>
						<b><i>Donation</i> </b>
					</legend>
					<br>
					<table>
						<tr>
							<td class="padded"><b>Type</b></td>
							<td class="padded"><b>Item Count</b></td>
							<?php 
								// if this is a new form, then add the ability to switch to the other form
								if(!isset($_POST['submitted']) && $donationID=="new")
									echo ('<td class="padded"><button type="submit" form="short_form">Switch Form</button></td>')
							?>
						</tr>
						<tr>
							<td class="padded">Household Items</td>
							<td class="padded"><input type="text" size="10" id="household" name="household"
								onkeyup="updateTotal()" <?php echo 'value='.$household?>></td>
						</tr>
						<tr>
							<td class="padded">Appliances</td>
							<td class="padded"><input type="text" size="10" id="appliances" name="appliances"
								onkeyup="updateTotal()" <?php echo 'value='.$appliances?>></td>
						</tr>
						<tr>
							<td class="padded">Building Materials</td>
							<td class="padded"><input type="text" size="10" id="building" name="building" 
								onkeyup="updateTotal()" <?php echo 'value='.$building?>></td>
						</tr>
						<tr>
							<td class="padded">Other</td>
							<td class="padded"><input type="text" size="10" id="other" name="other" 
								onkeyup="updateTotal()" <?php echo 'value='.$other?>></td>
						</tr>
						<tr>
							<td class="padded"><b>Total</b></td>
							<td class="padded"><input type="text" size="10" id="item_count" 
								name="item_count" <?php echo 'value='.$item_count?> readonly></td>
							<td class="padded">*This will be filled automatically</td>
						</tr>
					</table>

					<br>
					
					<i>Additional notes:</i><br>
					<textarea rows="3" cols="50" id="donation_notes" 
							  name="donation_notes"><?php echo $donation_notes;?></textarea>

					<!-- A hidden variable that, when submitted, is used to display submitted values and update the databases -->
					<input type="hidden" name="submitted" value="set">
					
					<!-- A hidden variable that stores the date of the submitted donation -->
					<input type="hidden" name="date" value=<?php echo $date?>><br><br>
					
					<!-- A button to submit the donation -->
					<button name="add" type="submit" value="submit" style="font-size: 14px; margin-right:5px; background:#B2E0B2">Submit</button>
	
					<!-- A button to delete the donation if it exists -->
					<?php
					// the button should be displayed only if the donation exists
					if(retrieve_dbDonations($donation1->get_id())){
						echo '<button name="delete" type="submit" value="confirm" style="font-size:14px; margin-right:5px; background:#FF9999;">Delete</button>';
					}
					?>
					
					<!-- A button to clear all values to zero -->
					<button type="button" onclick="clearInputs()" style="font-size:14px; background:#FFFFDD">Clear</button>
					
				</fieldset>
			</form>
			<br><br>

			<!-- Form to take us to the donor adding template -->
			<form id="donor_form" action="donorEdit.php" method="get">
			</form>
			
			<!-- A form for returning to the donation log -->
			<form id="return" action="donationLogView.php" method="get">
				<!-- Pass the donation date to the form -->
				<input type="hidden" name="date" value="<?php echo($donation1->get_date())?>">
				<input type="hidden" name="area" value="<?php echo($donation1->get_area())?>">
			</form>					
			
			<?php
			// The link to return to the current Donation Log.
			echo '<a style="font-size:16px" href="donationLogView.php?area='.$donation1->get_area().'&date='.$donation1->get_date().'">Return to Pick-up Schedule</a><br><br>';
			echo '</div>';
			include('footer.inc');
			?>
		</div>
	</div>

<script type="text/javascript">

	var names = ["household", "appliances", "building", "other", "item_count"];

    var donors = new Array();

	// This function will set the input values to zero on the donation form 
	// and clear the donation notes.
	function clearInputs(){
		for(var i = 0; i < names.length; i++){	
			document.getElementById(names[i]).value = "0";
		}
		document.getElementById("donation_notes").value = "";
		document.getElementById("donor").value = "";
	}

	// Function to update the total weight value as the user inputs data
	function updateTotal(){
		var total = 0;
		for(var i = 0; i < names.length - 1; i++){	
			if (document.getElementById(names[i]).value!="")	
			    total += parseInt(document.getElementById(names[i]).value);
		}
		document.getElementById("item_count").value = total.toFixed().toString();
	}

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
		var search_box = document.getElementById("donor");
		var search_string = document.getElementById("donor").value;
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
