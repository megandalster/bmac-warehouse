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
 *	shipmentForm.inc
 *  a form for a shipment to be added or edited in the database
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
	if ($customer_id=='new') {
	  echo('<p><strong>Shipment Input Form</strong><br />');
	  echo('Here you can add a new shipment to the database. </p>');
    }
    else {
	   echo('<p><strong>Shipment Information Form</strong><br />');
	   echo('Here you can edit the shipment or delete it from the database.</p><p>');
    }
}

?>
<form method="POST">
	<input type="hidden" name="old_id" value=<?PHP echo("\"".$customer_id."\"");?>>
	<input type="hidden" name="_form_submit" value="1">
<p>(<span style="font-size:x-small;color:FF0000">*</span> indicates required information.)

<fieldset>
<legend>Shipment Information</legend>
<p>	<?php 
	if ($customer_id=="new") 
		echo 'Ship To:<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" name="customer_id" tabindex=1 value="'.$shipment->get_customer_id().'">';
	else 	
		echo 'Ship To: '.$shipment->get_customer_id();
	echo '<br>Date: '.$shipment->get_ship_date();		
?>

	<?php
	echo('<p>Funds Source<span style="font-size:x-small;color:FF0000">*</span>: ');
    echo('<select name="funds_source">');
    echo('<option value="BMAC"');if ($shipment->get_funds_source()=='BMAC') echo (' SELECTED'); echo('>BMAC</option>');
	echo '<option value="CSFP"'; if ($shipment->get_funds_source()=='CSFP') echo " SELECTED"; echo '>CSFP</option>';
    echo('<option value="United Way"');if ($shipment->get_funds_source()=='United Way') echo (' SELECTED'); echo('>United Way</option>');
	echo '<option value="Donation"'; if ($shipment->get_funds_source()=='Donation') echo " SELECTED"; echo '>Donation</option>';
	echo('</select>');

	echo('&nbsp;&nbsp;&nbsp;&nbsp;Ship Via<span style="font-size:x-small;color:FF0000">*</span>: ');
    echo('<select name="ship_via">');
    echo('<option value="BMAC"');if ($shipment->get_ship_via()=='BMAC') echo (' SELECTED'); echo('>BMAC</option>');
	echo '<option value="Customer"'; if ($shipment->get_ship_via()=='Customer') echo " SELECTED"; echo '>Customer</option>';
    echo '<option value="Other"'; if ($shipment->get_ship_via()=='Other') echo " SELECTED"; echo '>Other</option>';
	echo('</select></p>');
	?>
	
	<table>		
		Product Name<span style="font-size:large;color:FF0000">*</span>: <input type="text" name="product_name" tabindex=3 value="<?PHP echo($shipment->get_customer_id())?>">
		Case Lots<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" name="ship_items" size="5" tabindex=4 value="<?PHP echo(implode(',',$shipment->get_ship_items()))?>">
		Total Weight<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" name="total_weight" size="5" tabindex=5 value="<?PHP echo($shipment->get_total_weight())?>">
		<br></br><tr><td>Rate: <input type="text" name="ship_rate" size="5" tabindex=6 value="<?PHP echo($shipment->get_ship_rate())?>">
		Billed Amt: <input type="text" name="total_price" size="5" tabindex=7 value="<?PHP echo($shipment->get_total_price())?>">
		
        
		

	</table>

	<?php
    

	echo('<p>Notes:<br />');
	      echo('<textarea name="notes" rows="2" cols="60">');
	      echo($_POST['notes']);
	      echo('</textarea>');
echo "</fieldset>";
		  echo('<input type="hidden" name="_submit_check" value="1"><p>');
		  if ($customer_id=="new")
		     echo('Hit <input type="submit" value="Submit" name="Submit Edits"> to add this new shipment.<br /><br />');
		  else
		     echo('Hit <input type="submit" value="Submit" name="Submit Edits"> to complete these changes.<br /><br />');
		  if ($customer_id != 'new' && $_SESSION['access_level']>=2) {
			echo ('<input type="checkbox" name="deleteMe" value="DELETE"> Check this box and then hit ' .
				'<input type="submit" value="Delete" name="Delete Entry"> to delete this shipment from the database. </p>');
	}
	?>

<?php

?>
</form>