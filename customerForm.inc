<?PHP
/*
 * Copyright 2014 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker. This program is part of BMAC-Warehouse, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/

/*
 *	customerEdit.php
 *  oversees the editing of a customer to be added, changed, or deleted from the database
 *	@author Moustafa ElBadry
 *	@version March 04, 2015
 */


if($_SESSION['access_level']<3)
    if ($_SESSION['_customer_id']!=$customer->get_customer_id()){
		echo("<p customer_id=\"error\">You do not have sufficient permissions to edit this customer.</p>");
		include('footer.inc');
		echo('</div></div></body></html>');
		die();
	}
	else {
		echo('<p><strong>Customer Information Form</strong><br />');
	    echo('Here you can edit your own information in the database.' .
	    	 '<br>When you are finished, hit <b>Submit</b> at the bottom of this page.');
	}
else // $_SESSION['access_level']==3
	if ($customer_id=='new') {
	  echo('<p><strong>Customer Input Form</strong><br />');
	  echo('Here you can add a new customer to the database. </p>');
    }
    else {
	   echo('<p><strong>Customer Information Form</strong><br />');
	   echo('Here you can edit, or delete a customer.</p><p>');
    }

?>
<form method="POST">
	<input type="hidden" name="old_customer_id" value=<?PHP echo("\"".$customer_id."\"");?>>
	
	<input type="hidden" name="_form_submit" value="1">
<p>(<span style="font-size:x-small;color:FF0000">*</span> indicates required information.)

<p>	<?php 
	if ($customer_id=="new") {
		echo 'Customer ID<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" name="customer_id" tabindex=1 value="'.$customer->get_customer_id().'">';
		
	}
	else 	{
		echo 'Name: '.$customer->get_customer_id();
		if ($customer->get_code()!="")
			echo '<br>(Old customer code: '.$customer->get_code().")";	
	}	
?>
<fieldset>
<legend>Contact Information</legend>
	<table>		<tr><td>Address<span style="font-size:x-small;color:FF0000">*</span>:</td><td> <input type="text" size="40" name="address" tabindex=3 value="<?PHP echo($customer->get_address())?>"></td></tr>
		<tr><td>City<span style="font-size:x-small;color:FF0000">*</span>:</td><td> <input type="text" name="city" tabindex=4 value="<?PHP echo($customer->get_city())?>"></td></tr>
		<tr><td>State, Zip<span style="font-size:x-small;color:FF0000">*</span>:</td>
		<td><select name="state" tabindex=5>
		<?PHP

			$states = array("AL","AK","AZ","AR","CA","CO","CT","DE","DC","FL","GA","HI","ID","IL","IN","IA",
					        "KS","KY","LA","ME","MD","MA","MI","MN","MS","MO","MT","NE","NV","NH","NJ","NM",
					        "NY","NC","ND","OH","OK","OR","PA","RI","SC","SD","TN","TX","UT","VT","VA","WA",
					        "WV","WI","WY");
			foreach ($states as $st) {
				echo "<option value='" . $st . "' ";
                if($customer->get_state() == $st ) echo("SELECTED");
                else if ($customer_id == "new" && $st =="WA") echo("SELECTED");
                echo ">" . $st . "</option>";
			}
		?>
		</select>,
		<input type="text" name="zip" size="5" tabindex=6 value="<?PHP echo($customer->get_zip())?>"></td></tr>
		<tr>
		<?php
				echo '<td>Primary Phone:</td><td> <input type="text" name="phone" MAXLENGTH=12 tabindex=7 value="'.$customer->get_phone().'"></td>';
			
		?>
		<td>Contact Person:</td><td><input type="text" name="contact" MAXLENGTH=12 tabindex=8 value="<?PHP echo $customer->get_contact()?>"></td></tr>
		<tr><td>Email:</td><td><input type="text" name="email" size="40" tabindex=9 value="<?PHP echo($customer->get_email())?>"></td></tr>

</table>
</fieldset>
<?PHP
    
	echo ('<br>&nbsp;&nbsp;Status: ');
    echo('<select name="status">');
    echo ('<option value="active"');if ($customer->get_status()=='active') echo (' SELECTED'); echo('>active</option>');
	echo ('<option value="inactive"');if ($customer->get_status()=='inactive') echo (' SELECTED'); echo('>inactive</option>');
	echo('</select>');
	

    echo "</p>";
	echo('<p>Notes:<br />');
	      echo('<textarea name="notes" rows="2" cols="60">');
	      echo($_POST['notes']);
	      echo('</textarea>');

		  echo('<input type="hidden" name="_submit_check" value="1"><p>');
		  if ($_SESSION['access_level']==0)
		  	 echo('Hit <input type="submit" value="Submit" name="Submit Edits"> to complete this application.<br /><br />');
		  else if ($customer_id=="new")
		     echo('Hit <input type="submit" value="Submit" name="Submit Edits"> to add this new customer.<br /><br />');
		  else
		     echo('Hit <input type="submit" value="Submit" name="Submit Edits"> to complete these changes.<br /><br />');
		  if ($customer_id != 'new' && $_SESSION['access_level']>=2) {
			echo ('<input type="checkbox" name="deleteMe" value="DELETE"> Check this box and then hit ' .
				'<input type="submit" value="Delete" name="Delete Entry"> to delete this customer from the database. </p>');
	}

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

?>
</form>