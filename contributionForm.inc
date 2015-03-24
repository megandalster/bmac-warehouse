<?PHP
/*
 * Copyright 2014 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker. This program is part of BMAC-Warehouse, which is free software.
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
	<input type="hidden" name="old_id" value=<?PHP echo("\"".$id."\"");?>>
	<input type="hidden" name="_form_submit" value="1">
<p>(<span style="font-size:x-small;color:FF0000">*</span> indicates required information.)

<?php 
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Receipt Date: '.$contribution->get_receive_date();
	echo '<p>Provider<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" size="40" class="provider-id" name="provider-id" tabindex=1 value="'.$contribution->get_provider_id().'">';
	// echo '<input type="hidden" name="receive_date" value="'.$contribution->get_receive_date().'">';
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
<legend>Items received</legend>
<table><tr><td width="0px"></td><td width="250px">Product <span style="font-size:x-small;color:FF0000">*</span></td>
<td width="110px">Unit Wt</td>
<td width="110px">Case Lots <span style="font-size:x-small;color:FF0000">*</span></td>
<td>Total Wt. <span style="font-size:x-small;color:FF0000">*</span></td></tr></table>
		
	<?php
	$itemArray = $contribution->get_receive_items();
	$itemArray[] = "::";
	$total1 = 0; $total2=0;
	echo '<p class=ui-widget id=product-rows>';
	foreach ($itemArray as $item) {
		$details = explode(":",$item);
		$unit_weight = retrieveWithFunding_dbProducts($details[0], $contribution->get_payment_source()); 
		if (!$unit_weight) $unit_weight = "";
		echo '<input type="text" name="product-id[]" class="product-id" tabindex=1 size=30 value="'. $details[0] . '">';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="product-unit-wt[]" class="product-unit-wt" tabindex=2 size=10 value="'.$unit_weight.'">';
	    echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="product-units[]" class="product-units" tabindex=3 size=10 value="'. $details[1] . '">';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="product-total-wt[]" class="product-total-wt" tabindex=4 size=10 value="'. $details[2] . '">';
		$total1 += $details[1];
		$total2 += $details[2];
    }
    echo '</p>';
	echo '<table><tr><td width="0px"></td><td width="250px"><button id="add-more">add more</button></td><td width="110px">Totals:</td><td width="110px">'.$total1.'</td><td>'.$total2.'</td></tr></table>';
	
    echo '</fieldset>';
	echo '<p>Amount billed<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" size="8" name="billed_amt" tabindex=1 value="'.$contribution->get_billed_amt().'"></p>';
	echo('<p>Notes:<br />');
	      echo('<textarea name="notes" rows="2" cols="60">');
	      echo($contribution->get_notes());
	      echo('</textarea>');

		  echo('<input type="hidden" name="_submit_type" value="submit"><p>');
		  if ($id=="new")
		     echo('Hit <input type="submit" value="submit" name="submit"> to add this new receipt.<br /><br />');
		  else
		     echo('Hit <input type="submit" value="submit" name="submit"> to complete these changes.<br /><br />');
		  if ($id != 'new' && $_SESSION['access_level']>=2) {
			echo ('<input type="checkbox" name="delete-check" value="delete"> Check this box and then hit ' .
				'<input type="submit" value="delete" name="submit"> to delete this receipt from the database.');
	}

?>
</form>