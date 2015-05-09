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
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
        '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Receipt Date<span style="font-size:x-small;color:FF0000">*</span>: '.
        '<input type="text" name="date" id="date" width=30 value="'.substr($contribution->get_receive_date(),0,8).'">'.
        substr($contribution->get_receive_date(),8);
	echo '<p>Provider<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" size="40" class="provider-id" name="provider-id" tabindex=1 value="'.$contribution->get_provider_id().'">';
	
	$funding_sources = get_all_funding_sources();
	echo('&nbsp;&nbsp;&nbsp;&nbsp;Payment Source<span style="font-size:x-small;color:FF0000">*</span>: ');
    echo('<select name="payment_source">');
    foreach($funding_sources as $fs=>$alias) {
    	echo('<option value="'.$fs.'"');
    	if ($contribution->get_payment_source()==$fs) echo (' SELECTED'); 
    	echo('>'.$fs.'</option>');
    }
 	echo('</select>');
	
?>
<fieldset>
<legend>Items received</legend>
<table><tr><td width="0px"></td><td width="160px">Product <span style="font-size:x-small;color:FF0000">*</span></td>
<td width="80px">Unit Wt</td>
<td width="80px">Case Lots <span style="font-size:x-small;color:FF0000">*</span></td>
<td>Total Wt. <span style="font-size:x-small;color:FF0000">*</span></td></tr></table>
		
	<?php
	$itemArray = $contribution->get_receive_items();
	$itemArray[] = "::";
	$total1 = 0; $total2=0;
	echo '<p class=ui-widget id=product-rows>';
	foreach ($itemArray as $item) {
		$details = explode(":",$item);
		if (strpos($details[0],";")>0) {
			$unit_weight = substr($details[0],strpos($details[0],";")+1);
			$details[0] = substr($details[0],0,strpos($details[0],";"));
			if ($details[2]=="" && $details[1]!="")
				$details[2] = $unit_weight*$details[1];
		} 
		else $unit_weight = "";
		echo '<input type="text" name="product-id[]" class="product-id" tabindex=1 size=20 value="'. $details[0] . '">';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="product-unit-wt[]" class="product-unit-wt" tabindex=2 size=6 value="'.$unit_weight.'">';
	    echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="product-units[]" class="product-units" tabindex=3 size=6 value="'. $details[1] . '">';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="product-total-wt[]" class="product-total-wt" tabindex=4 size=6 value="'. $details[2] . '"><br>';
		$total1 += $details[1];
		$total2 += $details[2];
    }
    echo '</p>';
	echo '<table><tr><td width="0px"></td><td width="190px"><button id="add-more">add more</button></td><td width="80px">Totals:</td><td width="80px">'.$total1.'</td><td>'.$total2.'</td></tr></table>';
	
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