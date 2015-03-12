<?PHP
/*
 * Copyright 2014 by Allen Tucker. 
 * This program is part of Homerestore, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/
/**
 *	shipmentForm.inc
 *  a form for a provider to be added or edited in the database
 *	@author Dylan Martin
 *	@version 3/13/2015
 */
if($_SESSION['access_level']<3) {
	echo("<p id=\"error\">You do not have sufficient permissions to edit providers.</p>");
	include('footer.inc');
	echo('</div></div></body></html>');
	die();
	}
	else {// $_SESSION['access_level']==3
	if ($ship_date=='new') {
	  echo('<p><strong>Shipment Input Form</strong><br />');
	  echo('Here you can add a new shipment to the database. </p>');
    }
    else {
	   echo('<p><strong>Shipment Information Form</strong><br />');
	   echo('Here you can edit or delete the Shipment\'s information.</p><p>');
    }
}

?>
<form method="POST">
	<input type="hidden" name="old_id" value=<?PHP echo("\"".$ship_date."\"");?>>
	<input type="hidden" name="_form_submit" value="1">
<p>(<span style="font-size:x-small;color:FF0000">*</span> indicates required information.)

<fieldset>
<legend>Shipment Information</legend>
<p>	<?php 
	if ($ship_date=="new") {
		echo 'Ship Date<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" name="ship_date" tabindex=1 value="'.$shipment->get_ship_date.'">';
			}
	else 	
		echo 'Ship To: '.$shipment->get_customer_id();
		echo '<br>Date: '.$shipment->get_ship_date();		
?>

	<?php
	echo('<p>Funds Source<span style="font-size:x-small;color:FF0000">*</span>: ');
    echo('<select name="funds_source">');
    echo('<option value="BMAC"');if ($shipment->get_funds_source()=='BMAC' || $shipment->get_funds_source()=='') echo (' SELECTED'); echo('>BMAC</option>');
	echo '<option value="CSFP"'; if ($shipment->get_funds_source()=='CSFP' || $shipment->get_funds_source()=='2CSFP') echo " SELECTED"; echo '>CSFP</option>';
    echo('<option value="United Way"');if ($shipment->get_funds_source()=='United Way') echo (' SELECTED'); echo('>United Way</option>');
	echo '<option value="Donation"'; if ($shipment->get_funds_source()=='Donation') echo " SELECTED"; echo '>Donation</option>';
	echo('</select></p>');
	?>
	<?php
	echo('<p>Ship Via<span style="font-size:x-small;color:FF0000">*</span>: ');
    echo('<select name="ship_via">');
    echo('<option value="BMAC"');if ($shipment->get_ship_via()=='BMAC' || $shipment->get_ship_via()=='') echo (' SELECTED'); echo('>BMAC</option>');
	echo '<option value="CSFP"'; if ($shipment->get_ship_via()=='CSFP' || $shipment->get_ship_via()=='2CSFP') echo " SELECTED"; echo '>CSFP</option>';
    echo('<option value="United Way"');if ($shipment->get_ship_via()=='United Way') echo (' SELECTED'); echo('>United Way</option>');
	echo '<option value="Donation"'; if ($shipment->get_ship_via()=='Donation') echo " SELECTED"; echo '>Donation</option>';
	echo('</select></p>');
	?>
	<table>		
	    <tr><td>Address:</td><td> <input type="text" size="40" name="address" tabindex=3 value=""></td></tr>
		<tr><td>City:</td><td> <input type="text" name="city" tabindex=4 value=""></td></tr>
		<tr><td>State, Zip:</td>
		<td><select name="state" tabindex=5><option value=''></option>
		<!-- Need a way to pick out the states -->
		<?PHP
		/*
			$states = array("AL","AK","AZ","AR","CA","CO","CT","DE","DC","FL","GA","HI","ID","IL","IN","IA",
					        "KS","KY","LA","ME","MD","MA","MI","MN","MS","MO","MT","NE","NV","NH","NJ","NM",
					        "NY","NC","ND","OH","OK","OR","PA","RI","SC","SD","TN","TX","UT","VT","VA","WA",
					        "WV","WI","WY");
			foreach ($states as $st) {
				echo "<option value='" . $st . "' ";
                if($provider->get_state() == $st ) echo("SELECTED");
                echo ">" . $st . "</option>";
			}
		*/
		?>
		
		</select>,
		<!-- Need a way to insert values for here -->
		<input type="text" name="zip" size="5" tabindex=6 value=""></td></tr>
		<tr><td>County:</td><td><input type="text" name="county" size="40" tabindex=7 value=""></td></tr>
		<tr><td>Contact Name:</td><td><input type="text" name="contact" size="40" tabindex=8 value=""></td></tr>
		<tr><td>Contact Phone:</td><td><input type="text" name="phone" MAXLENGTH=12 tabindex=9 value=""></td></tr>
		<tr><td>Contact Email:</td><td><input type="text" name="email" size="40" tabindex=10 value=""></td></tr>

	</table>
	

	<table>		
		<tr><td>Product Name<span style="font-size:x-small;color:FF0000">*</span>:</td><td> <input type="text" name="product_name" tabindex=3 value="<?PHP echo($shipment->get_customer_id())?>"></td></tr>
		<tr><td>Case Lots:</td><td> <input type="text" name="ship_items" tabindex=4 value="<?PHP echo($shipment->get_ship_items())?>"></td></tr>
		<tr><td>Total Weight:</td><td> <input type="text" name="total_weight" tabindex=5 value="<?PHP echo($shipment->get_total_weight())?>"></td></tr>
		<tr><td>Rate:</td><td> <input type="text" name="ship_rate" tabindex=6 value="<?PHP echo($shipment->get_ship_rate())?>"></td></tr>
		<tr><td>Billed Amt:</td><td> <input type="text" name="total_price" tabindex=7 value="<?PHP echo($shipment->get_total_price())?>"></td></tr>
		
        
		

	</table>

	<?php
    

	echo('<p>Notes:<br />');
	      echo('<textarea name="notes" rows="2" cols="60">');
	      echo($_POST['notes']);
	      echo('</textarea>');

		  echo('<input type="hidden" name="_submit_check" value="1"><p>');
		  if ($_SESSION['access_level']==0)
		  	 echo('Hit <input type="submit" value="Submit" name="Submit Edits"> to complete this application.<br /><br />');
		  else if ($ship_date=="new")
		     echo('Hit <input type="submit" value="Submit" name="Submit Edits"> to add this new person.<br /><br />');
		  else
		     echo('Hit <input type="submit" value="Submit" name="Submit Edits"> to complete these changes.<br /><br />');
		  if ($id != 'new' && $_SESSION['access_level']>=2) {
			echo ('<input type="checkbox" name="deleteMe" value="DELETE"> Check this box and then hit ' .
				'<input type="submit" value="Delete" name="Delete Entry"> to delete this person from the database. </p>');
	}
	?>
</fieldset>
<?php
/*
function &select_date($month, $day, $year, $month_name, $day_name, $year_name) {
		$months = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
        echo('<select name='.$month_name.'><option value=""></option>');
		echo('');
        for ($i = 1; $i <= 12; $i++) {
            echo '<option value='.(($i<10)?"0".$i:$i);
            if ($month==$i) 
            	echo(' SELECTED');
            echo '>' . $months[$i] . ' </option>';
        }
		echo "</select>";

		echo '<select name='.$day_name.'><option value=""></option>';
		for ($i = 1; $i <= 31; $i++) {
            echo '<option value='.(($i<10)?"0".$i:$i); 
            if($day==$i) 
            	echo(' SELECTED'); 
            echo '>' . $i . ' </option>'; 
		}
		echo "</select>";
        // handles a year range of 90 years, from today+10 to today-80
		echo '<select name='.$year_name.'><option value=""></option>';
		$start_year = date("Y")+10;
        for ($i = $start_year; $i >= ($start_year-90); $i--){
         	echo '<option value='.substr($i,2,2); 
         	if($year==substr($i,2,2)) 
         		echo(' SELECTED'); 
         	echo '>' . $i . ' </option>'; 
        }
		echo "</select>";	
}
*/
?>
</form>