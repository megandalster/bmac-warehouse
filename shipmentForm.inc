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
else // $_SESSION['access_level']==3
	echo('<p><strong>Shipment Input Form</strong><br />');
if ($id=='new')  
	echo('Here you can add a new shipment to the database. </p>');
else {
    echo('Here you can edit the shipment or delete it from the database. ');
    echo 'For an invoice, click <a href="'.$path.
				     'shipmentInvoice.php?id='.$shipment->get_ship_date().'" target="_BLANK"><b>here</b></a>.';
    echo ' For a label, click <a href="'.$path.
				     'shipmentLabel.php?id='.$shipment->get_ship_date().'" target="_BLANK"><b>here</b></a>. </p>';
}
?>
<form method="POST">
	<input type="hidden" name="old_id" value=<?PHP echo("\"".$id."\"");?>>
	<input type="hidden" name="_form_submit" value="1">
<p>(<span style="font-size:x-small;color:FF0000">*</span> indicates required information.)
<?php    
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
        '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ship Date<span style="font-size:x-small;color:FF0000">*</span>: '.
        '<input type="text" name="date" id="date" width=30 value="'.substr($shipment->get_ship_date(),0,8).'">'.
        substr($shipment->get_ship_date(),8);
	echo '<p>Ship To<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" size="40" class="customer-id" name="customer-id" tabindex=1 value="'.$shipment->get_customer_id().'">';
	if ($customer){
		echo '<p>Address: '.$customer->get_address().', '.$customer->get_city().', '.$customer->get_state().' '.$customer->get_zip();
	}
	$funding_sources = get_all_funding_sources();
	echo('<p>Funds Source<span style="font-size:x-small;color:FF0000">*</span>: ');
    echo('<select name="funds_source">');
    foreach($funding_sources as $fs=>$alias) {
    	echo('<option value="'.$fs.'"');
    	if ($shipment->get_funds_source()==$fs) echo (' SELECTED'); 
    	echo('>'.$fs.'</option>');
    }
    echo('</select>');

	echo('&nbsp;&nbsp;&nbsp;&nbsp;Ship Via<span style="font-size:x-small;color:FF0000">*</span>: ');
    echo('<select name="ship_via">');
    echo('<option value="BMAC"');if ($shipment->get_ship_via()=='BMAC') echo (' SELECTED'); echo('>BMAC</option>');
	echo '<option value="Customer"'; if ($shipment->get_ship_via()=='Customer') echo " SELECTED"; echo '>Customer</option>';
    echo '<option value="Other"'; if ($shipment->get_ship_via()=='Other') echo " SELECTED"; echo '>Other</option>';
	echo('</select></p>');
?>	
<fieldset>
<legend>Items shipped</legend>
<table><tr><td width="0px"></td><td width="160px">Product <span style="font-size:x-small;color:FF0000">*</span></td>
<td width="80px">Unit Wt</td>
<td width="80px">Case Lots <span style="font-size:x-small;color:FF0000">*</span></td>
<td>Total Wt. <span style="font-size:x-small;color:FF0000">*</span></td></tr></table>
		
<?php
	$itemArray = $shipment->get_ship_items();
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
		echo '&nbsp;&nbsp;<input type="text" name="product-unit-wt[]" class="product-unit-wt" tabindex=2 size=6 value="'.$unit_weight.'">';
	    echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="product-units[]" class="product-units" tabindex=3 size=6 value="'. $details[1] . '">';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="product-total-wt[]" class="product-total-wt" tabindex=4 size=6 value="'. $details[2] . '"><br>';
		$total1 += $details[1];
		$total2 += $details[2];
	}
    echo '</p>';
	echo '<table><tr><td width="0px"></td><td width="190px"><button id="add-more">add more</button></td><td width="80px">Totals:</td><td width="80px">'.
	    $total1.'</td><td width="80px">',$total2.'</td></tr></table>';
    echo '</fieldset>';
    
    echo '<p>Rate: <input type="text" name="ship_rate" size=10 class="ship_rate" value="'. $shipment->get_ship_rate() . '">';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;Billed Amt: <input type="text" name="billed_amt" size=10 class="billed_amt" value="'. $shipment->get_total_price() . '">';	
    echo('<p>Notes:<br />');
	      echo('<textarea name="notes" rows="2" cols="60">');
	      echo($shipment->get_notes());
	      echo('</textarea>');
		  
	echo('<input type="hidden" name="_submit_type" value="submit"><p>');
		  if ($id=="new")
		     echo('Hit <input type="submit" value="submit" name="submit" style="height:150px; width:100px"> to add this new shipment. ');
		  else
		     echo('Hit <input type="submit" value="submit" name="submit" style="height:150px; width:100px"> to complete these changes. ');
		  if ($id != 'new' && $_SESSION['access_level']>=2) {
			echo ('<p><input type="checkbox" name="delete-check" value="delete"> Check this box and then hit ' .
				'<input type="submit" value="delete" name="submit" style="height:150px; width:100px"> to delete this shipment from the database.');
	}
?>
</form>