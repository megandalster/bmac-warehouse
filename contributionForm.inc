<?PHP
/*
 * Copyright 2014 by Allen Tucker. 
 * This program is part of Homerestore, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/

/**
 *	ContributionForm.inc
 *  a form for a receipt to be added or edited in the database
 *	@author Luis Munguia
 *	@version 3/3/2015
 */
if($_SESSION['access_level']<3) {
	echo("<p id=\"error\">You do not have sufficient permissions to edit receipts.</p>");
	include('footer.inc');
	echo('</div></div></body></html>');
	die();
}
else {// $_SESSION['access_level']==3
	echo('<p><strong>Warehouse Receipt Form</strong><br />');
	if ($id=='new') {
	  echo('Here you can add a new contribution to the database. </p>');
    }
    else {
	   echo('Here you can edit or delete a contribution from the database.</p><p>');
    }
}
?>
<form method="POST">
	<input type="hidden" name="old_id" value=<?PHP echo("\"".$contribution->get_receive_date()."\"");?>>
	<input type="hidden" name="_form_submit" value="1">
<p>(<span style="font-size:x-small;color:FF0000">*</span> indicates required information.)

<?php 
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Receipt Date: '.$contribution->get_receive_date();
	echo '<p>Provider<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" size="40" name="provider_id" tabindex=1 value="'.$contribution->get_provider_id().'">';
	echo '<input type="hidden" name="receive_date" value="'.$contribution->get_receive_date().'">';
	echo('&nbsp;&nbsp;&nbsp;&nbsp;Payment Source<span style="font-size:x-small;color:FF0000">*</span>: ');
    echo('<select name="payment_source">');
    echo('<option value="Donation"');if ($contribution->get_payment_source()=='Donation' || $contribution->get_payment_source()=='') echo (' SELECTED'); echo('>Donation</option>');
	echo('<option value="TEFAP"');if ($contribution->get_payment_source()=='TEFAP') echo (' SELECTED'); echo('>TEFAP</option>');
	echo('<option value="EFAP"');if ($contribution->get_payment_source()=='EFAP') echo (' SELECTED'); echo('>EFAP</option>');
	echo('<option value="EFAP-FB"');if ($contribution->get_payment_source()=='EFAP-FB') echo (' SELECTED'); echo('>EFAP-FB</option>');
	echo('<option value="CSFP"');if ($contribution->get_payment_source()=='CSFP') echo (' SELECTED'); echo('>CSFP</option>');
	echo('<option value="United Way"');if ($contribution->get_payment_source()=='United Way') echo (' SELECTED'); echo('>United Way</option>');
	echo('</select>');
	
?>
<fieldset>
<legend>Items received <span style="font-size:x-small;color:FF0000">*</span></legend>
	<table>		<tr><td>Product Name</td><td>Unit Wt.</td><td>Case Lots</td><td>Total Weight</td></tr>
	<?php
	$itemArray = $contribution->get_receive_items(); 
	foreach ($itemArray as $item) {
		$details = explode(":",$item);
		echo "<tr>";
	    echo '<td><input type="text" name="product-ids[]" class="product-id" id="1" tabindex=1 size=30 value="'. $details[0] . '"></td>';
		echo '<td><input type="text" name="product_unit_wt" tabindex=2 size=10 value=""></td>';
	    echo '<td><input type="text" name="product_units" type="number" tabindex=3 size=10 value="'. $details[1] . '"></td>';
		echo '<td><input type="text" name="product_total_wt" type="number" tabindex=4 size=10 value="'. $details[2] . '"></td>';
		echo "</tr>";
    }
    ?>
	</table>
</fieldset>
<?PHP
	$receive_items = array();
	$receive_items[]=$_POST['product_name'];
	$receive_items[]=$_POST['units'];
	$receive_items[]=$_POST['weight'];
	echo '<input type="hidden" name="receive_items" value="'.implode(":",$receive_items).'">';
    
	
	echo "</p>";
	echo '<p>Amount billed<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" size="8" name="billed_amt" tabindex=1 value="'.$contribution->get_billed_amt().'"></p>';
	echo('<p>Notes:<br />');
	      echo('<textarea name="notes" rows="2" cols="60">');
	      echo($contribution->get_notes());
	      echo('</textarea>');

		  echo('<input type="hidden" name="_submit_type" value="submit"><p>');
		  if ($_SESSION['access_level']==0)
		  	 echo('Hit <input type="submit" value="submit" name="submit"> to complete this application.<br /><br />');
		  else if ($id=="new")
		     echo('Hit <input type="submit" value="submit" name="submit"> to add this new receipt.<br /><br />');
		  else
		     echo('Hit <input type="submit" value="submit" name="submit"> to complete these changes.<br /><br />');
		  if ($id != 'new' && $_SESSION['access_level']>=2) {
			echo ('<input type="checkbox" name="delete-check" value="delete"> Check this box and then hit ' .
				'<input type="submit" value="delete" name="submit"> to delete this receipt from the database. </p>');
	}

?>
</form>