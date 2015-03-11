<?PHP
/*
 * Copyright 2014 by Allen Tucker. 
 * This program is part of Homerestore, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/
/*
 *	contributionForm.inc
 *  a form for a receipt to be added or edited in the database
 *	@author Allen Tucker
 *	@version 12/29/2014
 */
if($_SESSION['access_level']<3) {
		echo("<p id=\"error\">You do not have sufficient permissions to edit this receipt.</p>");
		include('footer.inc');
		echo('</div></div></body></html>');
		die();
} else { // $_SESSION['access_level']==3
	if ($id=='new') {
	  echo('<p><strong>Receipt Input Form</strong><br />');
	  echo('Here you can add a new contribution receipt to the database.</p>');
    }
    else {
	   echo('<p><strong>Receipt Information Form</strong><br />');
	   echo('Here you can edit or delete a receipt in the database.</p><p>');
    }
}
?>
<form method="POST">
	<input type="hidden" name="_form_submit" value="1">
<p>(<span style="font-size:x-small;color:FF0000">*</span> indicates required information.)

<p>	<?php 
	if ($id=="new") {
		echo 'Provider<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" name="provider_id" tabindex=1 value="">';
		echo 'Receive Date<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" name="last_name" tabindex=2 value="'.date('y-m-d:h:m').'">';
	}
	else {
		echo 'Provider: '.$contribution->get_provider_id();		
		echo 'Receive Date: '.$contribution->get_receive_date();
	}
?>
<fieldset>
<legend>Receipt Contents</legend>
	<table>
		<?php 
		if($id=='new') {
			echo('<tr><td>Items<span style="font-size:x-small;color:FF0000">*</span>:</td><td> <input type="text" size="40" name="address" tabindex=3 value="'.$contribution->get_receive_items()[0].'")"></td></tr>');
		}
		?>		
		<tr><td>Items<span style="font-size:x-small;color:FF0000">*</span>:</td><td> <input type="text" size="40" name="address" tabindex=3 value="<?PHP echo($person->get_address())?>"></td></tr>
		<tr><td>City<span style="font-size:x-small;color:FF0000">*</span>:</td><td> <input type="text" name="city" tabindex=4 value="<?PHP echo($person->get_city())?>"></td></tr>
		<tr><td>State, Zip<span style="font-size:x-small;color:FF0000">*</span>:</td>
</table>
</fieldset>
<?PHP
    
	echo ('<br>&nbsp;&nbsp;Status: ');
    echo('<select name="status">');
    echo ('<option value=""></option>');
    echo ('<option value="active"');if ($person->get_status()=='active') echo (' SELECTED'); echo('>active</option>');
	echo ('<option value="on-leave"');if ($person->get_status()=='on-leave') echo (' SELECTED'); echo('>on leave</option>');
	echo ('<option value="former"');if ($person->get_status()=='former') echo (' SELECTED'); echo('>former</option>');
	echo('</select>');
	
	$st = $person->get_type();
    $types = array('staff' => "Warehouse Staff", 'office'=>'Office Staff', 'manager'=>"Foodbank Direcxtor");
	echo('<p>Type');
	echo('<span style="font-size:x-small;color:FF0000">*</span>: ');

    foreach ($types as $key=>$value) {
    	echo ('<input type="radio" name="type" value=' . $key);
    	if (strpos($st,$key)!==false) echo(' CHECKED');
    	echo ('>' . $value . '&nbsp;&nbsp;');
    }


    echo "</p>";
	echo('<p>Notes:<br />');
	      echo('<textarea name="notes" rows="2" cols="60">');
	      echo($_POST['notes']);
	      echo('</textarea>');

		  echo('<input type="hidden" name="_submit_check" value="1"><p>');
		  if ($_SESSION['access_level']==0)
		  	 echo('Hit <input type="submit" value="Submit" name="Submit Edits"> to complete this application.<br /><br />');
		  else if ($id=="new")
		     echo('Hit <input type="submit" value="Submit" name="Submit Edits"> to add this new person.<br /><br />');
		  else
		     echo('Hit <input type="submit" value="Submit" name="Submit Edits"> to complete these changes.<br /><br />');
		  if ($id != 'new' && $_SESSION['access_level']>=2) {
			echo ('<input type="checkbox" name="deleteMe" value="DELETE"> Check this box and then hit ' .
				'<input type="submit" value="Delete" name="Delete Entry"> to delete this person from the database. </p>');
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