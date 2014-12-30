<?php
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homerestore, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/**
 *  A form for a client to be added or edited in the database
 *  
 *	@author Hartley Brody, Sawyer Bowman & Nick Wetzel
 *	@version October 22, 2013
 */
include_once("donorEdit.php");
include_once("domain/Donor.php");
include_once("database/dbDonors.php");

//Make a new donor
$id = $_GET['id'];
$today = date('Y-M-d');
$currentday = substr($today, 9, 2);
$currentmonth = substr($today, 5, 3);
$currentyear = substr($today, 0, 4);
if ($_GET['id'] == "new") {
	$donor = new Donor("", "", "", "", "", "", "Bluffton", "SC", "", "","", "", "");
	echo('<p><strong>New Donor Form</strong><br />');
}
//Edit an existing donor
else {
	$donor = retrieve_dbDonors($_GET['id']);
	echo('<p><strong>Edit Existing Donor</strong><br />');
	echo('Here you can edit an existing donor!</p><p>');
}  
?>

<form method="POST">
	<input type="hidden" name="old_id" value=<?PHP echo("\"".$id."\"");?>>
	<input type="hidden" name="_form_submit" value="1">
<p>(<span style="font-size:x-small;color:FF0000">*</span> indicates required information.)

<p>Date Entered<span style="font-size:x-small;color:FF0000">*</span>:<br />
<select id="month_name" name="month_name" tabindex=2>
	
	<?PHP
	$months = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	foreach ($months as $month) {
		echo "<option value'" . $month . "' ";
		if($donor->get_month() == $month ) echo("SELECTED");
		else if ($month == $currentmonth) echo("SELECTED");
		echo ">" . $month . "</option>";
	}
/*
	echo('<select name='.$month_name.'><option value=""></option>');
	echo('');
    for ($i = 1; $i <= 12; $i++) {
    	echo '<option value='.(($i<10)?"0".$i:$i);
        if ($month==$i) 
            echo(' SELECTED');
        echo '>' . $months[$i] . ' </option>';
    }
    */
	?>
	
</select>
<select id="day_name" name="day_name">
	
	<?PHP
	$days = array("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
	foreach ($days as $day) {
		echo "<option value'" . $day . "' ";
		if($donor->get_day() == $day ) echo("SELECTED");
		else if ($day == $currentday) echo("SELECTED");
		echo ">" . $day . "</option>";
	}
	?>
	
</select>
<select id="year_name" name="year_name">
	
	<?PHP
	$years = array();
	$tempyear = 2000;
	$count = 0;
	for ($tempyear; $tempyear<=2100; $tempyear++){
		$years[$count]=$tempyear;
		$count+=1;
	}
	foreach ($years as $year) {
		echo "<option value'" . $year . "' ";
		if($donor->get_year() == $year ) echo("SELECTED");
		else if ($year == $currentyear) echo("SELECTED");
		echo ">" . $year . "</option>";
	}
	
	?>
	
</select>

<p>Donor Name<span style="font-size:x-small;color:FF0000">*</span>:<br />
<input type="text" size="40" id="id" name="id" tabindex=2 value="<?PHP echo($donor->get_id())?>">

<fieldset>
	<legend>Contact Information (fill in as much as you can)</legend>
		<table>		<tr><td>Address<span style="font-size:x-small;color:FF0000"></span>:</td><td> <input type="text" size="40" id="address" name="address" tabindex=3 value="<?PHP echo($donor->get_address())?>"></td></tr>
			<tr><td>Plantation/Neighborhood<span style="font-size:x-small;color:FF0000"></span>:</td>
			<td><input type="text" id="neighborhood" name="neighborhood" size="40" tabindex=7 value="<?PHP echo($donor->get_neighborhood())?>">
			<tr><td>City<span style="font-size:x-small;color:FF0000"></span>:</td><td> <input type="text" id="city" name="city" tabindex=4 value="<?PHP echo($donor->get_city())?>"></td></tr>
			<tr><td>State<span style="font-size:x-small;color:FF0000"></span>:</td>
			<td><select id="state" name="state" tabindex=5>
			<?PHP

			$states = array("GA","SC");
			foreach ($states as $st) {
				echo "<option value='" . $st . "' ";
                if($donor->get_state() == $st ) echo("SELECTED");
                else if ($id == "new" && $st =="SC") echo("SELECTED");
                echo ">" . $st . "</option>";
			}
			?>
			</select>
			<tr><td>Zip:</td><td> <input type="text" id="zip" name="zip" size="5" tabindex=6 value="<?PHP echo($donor->get_zip())?>"></td></tr>
			<tr><td>Phone<span style="font-size:x-small;color:FF0000">*</span>:</td><td> <input type="text" id="phone1" name="phone1" size="12" tabindex=8 value="<?PHP echo($donor->get_phone1())?>"></td></tr>
			<tr><td>Email<span style="font-size:x-small;color:FF0000"></span>:</td><td> <input type="text" id="email" name="email" size="30" tabindex=9 value="<?PHP echo($donor->get_email())?>"></td></tr>
		</table>
</fieldset>

<p>
		<?PHP
		  echo('<p>Notes:<br />');
	      echo('<textarea id="notes" name="notes" rows="2" cols="60">');
	      echo($donor->get_notes());
	      echo('</textarea>');
		  	
		  echo('<input type="hidden" name="_submit_check" value="1"><p>');
		  //New donor
		  if ($id=="new"){
		     echo('Hit <button type="submit" value="_form_submit" name="Submit New Donor">Submit</button> to add this new donor.<br /><br />');
		     echo('Hit <button type="reset" value="Clear" name="Clear New Donor Information">Clear</button> to clear this form.<br /><br />');
		  }
		  //Existing donor
		  else {
		  	echo('Hit <button type="submit" value="_form_submit" name="Submit Edits">Submit</button> to complete these changes.<br /><br />');
		  	echo('Hit <button type="button" onclick = "clearText()" value="Clear" name="Clear Existing Donor Information">Clear</button> to clear the existing donor information.<br /><br />');
		  	?>
		  	<script type ="text/javascript">
		  	var fieldNames = ["id", "month_name", "day_name", "year_name", "type", "address", "city", "state", "zip", "contact", "phone1", "email", "notes"];
		  		function clearText() {
					for (var i = 0; i<fieldNames.length; i++){
						if (fieldNames[i] == "month_name"){
							document.getElementById(fieldNames[i]).value = "<?php echo($currentmonth);?>";
						}
						else if (fieldNames[i] == "day_name"){
							document.getElementById(fieldNames[i]).value = <?php echo($currentday);?>;
						}
						else if (fieldNames[i] == "year_name"){
							document.getElementById(fieldNames[i]).value = <?php echo($currentyear);?>;
						}
						else if (fieldNames[i] == "city"){
							document.getElementById(fieldNames[i]).value = "Brunswick";
						}
						else if (fieldNames[i] == "state"){
							document.getElementById(fieldNames[i]).value = "ME";
						}
						else if (fieldNames[i] == "zip"){
							document.getElementById(fieldNames[i]).value = "04011";
						}
						else {
							document.getElementById(fieldNames[i]).value = "";
						}
					}
		  		}
		  	</script>
		  	<?PHP
		  	echo ('<input type="checkbox" name="deleteMe" value="DELETE"> Check this box and then hit ' .'<input type="submit" value="Delete" name="Delete Entry"> to delete this client from the database. <br />' );
		  }
		?>

</form>