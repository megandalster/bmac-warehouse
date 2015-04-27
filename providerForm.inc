<?PHP
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker. This program is part of BMAC-Warehouse, which is 
 * free software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 * 
 */
/**
 *	providerForm.inc
 *  a form for a provider to be added or edited in the database
 *	@author David Quennoz
 *	@version 3/3/2015
 */
if($_SESSION['access_level']<3) {
	echo("<p id=\"error\">You do not have sufficient permissions to edit providers.</p>");
	include('footer.inc');
	echo('</div></div></body></html>');
	die();
}
else {// $_SESSION['access_level']==3
	if ($id=='new') {
	  echo('<p><strong>Provider Input Form</strong><br />');
	  echo('Here you can add a new provider to the database. </p>');
    }
    else {
	   echo('<p><strong>Provider Information Form</strong><br />');
	   echo('Here you can edit or delete the provider\'s information.</p><p>');
    }
}
?>
<form method="POST">
	<input type="hidden" name="old_id" value=<?PHP echo("\"".$id."\"");?>>
	<input type="hidden" name="_form_submit" value="1">
<p>(<span style="font-size:x-small;color:FF0000">*</span> indicates required information.)

<p>	<?php 
	if ($id=="new") {
		echo 'Name<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" name="provider_id" tabindex=1 value="'.$provider->get_provider_id().'">';
	}
	else {
		echo 'Name: '.$provider->get_provider_id();		
		if($provider->get_code()!=null) {
			echo '<br>(Old Provider Code: '.$provider->get_code().")";
		}
	}
?>
<fieldset>
<legend>Contact Information</legend>
	<table>		<tr><td>Address:</td><td> <input type="text" size="40" name="address" tabindex=3 value="<?PHP echo($provider->get_address())?>"></td></tr>
		<tr><td>City:</td><td> <input type="text" name="city" tabindex=4 value="<?PHP echo($provider->get_city())?>"></td></tr>
		<tr><td>State, Zip:</td>
		<td><select name="state" tabindex=5><option value=''></option>
		<?PHP

			$states = array("AL","AK","AZ","AR","CA","CO","CT","DE","DC","FL","GA","HI","ID","IL","IN","IA",
					        "KS","KY","LA","ME","MD","MA","MI","MN","MS","MO","MT","NE","NV","NH","NJ","NM",
					        "NY","NC","ND","OH","OK","OR","PA","RI","SC","SD","TN","TX","UT","VT","VA","WA",
					        "WV","WI","WY");
			foreach ($states as $st) {
				echo "<option value='" . $st . "' ";
                if($provider->get_state() == $st ) echo("SELECTED");
                echo ">" . $st . "</option>";
			}
		?>
		</select>,
		<input type="text" name="zip" size="5" tabindex=6 value="<?PHP echo($provider->get_zip())?>"></td></tr>
		<tr><td>County:</td><td><input type="text" name="county" size="40" tabindex=7 value="<?PHP echo($provider->get_county())?>"></td></tr>
		<tr><td>Contact Name:</td><td><input type="text" name="contact" size="40" tabindex=8 value="<?PHP echo($provider->get_contact())?>"></td></tr>
		<tr><td>Contact Phone:</td><td><input type="text" name="phone" MAXLENGTH=12 tabindex=9 value="<?PHP echo $provider->get_phone()?>"></td></tr>
		<tr><td>Contact Email:</td><td><input type="text" name="email" size="40" tabindex=10 value="<?PHP echo($provider->get_email())?>"></td></tr>

</table>
</fieldset>
<?PHP
    
	echo('<p>Status<span style="font-size:x-small;color:FF0000">*</span>: ');
    echo('<select name="status">');
    echo('<option value="active"');if ($provider->get_status()=='active' || $provider->get_status()=='') echo (' SELECTED'); echo('>active</option>');
	echo('<option value="inactive"');if ($provider->get_status()=='inactive') echo (' SELECTED'); echo('>inactive</option>');
	echo('</select></p>');
	
	$st = $provider->get_type();
    $types = array('funds' => "Funds Provider", 'food'=>'Food Provider');
	echo('<p>Type');
	echo('<span style="font-size:x-small;color:FF0000">*</span>: ');

    foreach ($types as $key=>$value) {
    	echo ('<input type="radio" name="type" value=' . $key);
    	if(strpos($st,$key)!==false) echo(' CHECKED');
    	if($id=='new' && $key=='food') echo(' CHECKED');
    	echo ('>' . $value . '&nbsp;&nbsp;');
    }


    echo "</p>";
	echo('<p>Notes:<br />');
	      echo('<textarea name="notes" rows="2" cols="60">');
	      echo($provider->get_notes());
	      echo('</textarea>');

		  echo('<input type="hidden" name="_submit_type" value="submit"><p>');
		  if ($_SESSION['access_level']==0)
		  	 echo('Hit <input type="submit" value="submit" name="submit"> to complete this application.<br /><br />');
		  else if ($id=="new")
		     echo('Hit <input type="submit" value="submit" name="submit"> to add this new provider.<br /><br />');
		  else
		     echo('Hit <input type="submit" value="submit" name="submit"> to complete these changes.<br /><br />');
		  if ($id != 'new' && $_SESSION['access_level']>=2) {
			echo ('<input type="checkbox" name="delete-check" value="delete"> Check this box and then hit ' .
				'<input type="submit" value="delete" name="submit"> to delete this provider from the database. </p>');
	}

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