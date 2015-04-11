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
 *	productForm.inc
 *  a form for a product to be added or edited in the database
 *	@author Noah Jensen
 *	@version 3/1/2015
 */
if($_SESSION['access_level']<3) {
	echo("<p id=\"error\">You do not have sufficient permissions to edit products.</p>");
	include('footer.inc');
	echo('</div></div></body></html>');
	die();
}
else {// $_SESSION['access_level']==3
	if ($id=='new') {
	  echo('<p><strong>Product Input Form</strong><br />');
	  echo('Here you can add a new product to the database. </p>');
    }
    else {
	   echo('<p><strong>Product Information Form</strong><br />');
	   echo('Here you can edit or delete the product\'s information.</p><p>');
    }
}
?>
<form method="POST">
	<input type="hidden" name="old_id" value=<?PHP echo("\"".$id."\"");?>>
	<input type="hidden" name="_form_submit" value="1">
<p>(<span style="font-size:x-small;color:FF0000">*</span> indicates required information.)

<p>	<?php 
	if ($id=="new") {
		echo 'Product Name<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" name="product_id" tabindex=1 value="'.$product->get_product_id().'">';
	}
	else {
		echo 'Product Name: '.$product->get_product_id();		
		if($product->get_product_code()!=null) {
			echo '<br>(Old Product Code: '.$product->get_product_code().")";
		}
	}
?>
<fieldset>
<legend>Product Information</legend>
	<?php
	echo('<br>&nbsp;Funding Source<span style="font-size:x-small;color:FF0000">*</span>: ');
    echo('<select name="funding_source">');
    echo('<option value="TFAP"');if ($product->get_funding_source()=='TFAP') echo (' SELECTED'); echo('>TFAP</option>');
	echo '<option value="CSFP"'; if ($product->get_funding_source()=="CSFP" || $product->get_funding_source()=='2CSFP') echo " SELECTED"; echo '>CSFP or 2CSFP</option>';
	echo '<option value="INK"'; if (substr($product->get_funding_source(),0,3)=="INK") echo " SELECTED"; echo '>INK</option>';
	echo '<option value="AFF"'; if ($product->get_funding_source()=="AFF") echo " SELECTED"; echo '>AFF</option>';
	echo '<option value="FC"'; if ($product->get_funding_source()=="FC") echo " SELECTED"; echo '>FC or F.D.</option>';
	echo '<option value="SP"'; if ($product->get_funding_source()=="SP") echo " SELECTED"; echo '>SP</option>';
	echo '<option value="none"'; if ($product->get_funding_source()=="") echo " SELECTED"; echo '>--none--</option>';
	echo '<option value="Donation"'; if ($product->get_funding_source()=="Donation" || $product->get_funding_source()=="") echo " SELECTED"; echo '>Donation</option>';
	echo('</select></p>');
	$recent_inventory = $product->get_history();
    if (count($recent_inventory) > 0){
         $ri = explode(':',end($recent_inventory));
         $inv_item = pretty_date($ri[0]).": ".$ri[1]." case lots, ".$ri[2]." total pounds.";
    }
    else 
         $inv_item = " N/A";
	?>

	<table>		<tr><td>Unit Weight<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" size=10 name="unit_weight" tabindex=3 value="<?PHP echo($product->get_unit_weight())?>"></td>
		<td>Unit Price: <input type="text" size=10 name="unit_price" tabindex=4 value="<?PHP echo($product->get_unit_price())?>"></td></tr>
		<tr><td>Initial Stock: <input type="text" size=10 name="initial_stock" tabindex=5 value="<?PHP echo($product->get_initial_stock())?>"></td><td>
		Initial Date: <input type="text" size=10 name="initial_date" id="initial_date" tabindex=6 value="<?PHP echo($product->get_initial_date())?>"></td></tr><tr><td>
		Minimum Stock: <input type="text" size=10 name="minimum_stock" tabindex=7 value="<?PHP echo($product->get_minimum_stock())?>"></td></tr>
		<tr><td>Last Inventory <?PHP echo($inv_item)?></td></tr>

</table>
</fieldset>
<?PHP
    function pretty_date($yy_mm_dd) {
		return date('M j, Y', mktime(0,0,0,substr($yy_mm_dd,3,2),substr($yy_mm_dd,6,2),substr($yy_mm_dd,0,2)));
	}
				
	echo('<p>Status<span style="font-size:x-small;color:FF0000">*</span>: ');
    echo('<select name="status">');
    echo('<option value="active"');if ($product->get_status()=='active' || $product->get_status()=='') echo (' SELECTED'); echo('>active</option>');
	echo('<option value="discontinued"');if ($product->get_status()=='inactive') echo (' SELECTED'); echo('>discontinued</option>');
	echo('</select></p>');

	echo('<p>Notes:<br />');
	      echo('<textarea name="notes" rows="2" cols="60">');
	      echo($product->get_notes());
	      echo('</textarea>');

		  echo('<input type="hidden" name="_submit_type" value="submit"><p>');
		  if ($_SESSION['access_level']==0)
		  	 echo('Hit <input type="submit" value="submit" name="submit"> to complete this application.<br /><br />');
		  else if ($id=="new")
		     echo('Hit <input type="submit" value="submit" name="submit"> to add this new product.<br /><br />');
		  else
		     echo('Hit <input type="submit" value="submit" name="submit"> to complete these changes.<br /><br />');
		  if ($id != 'new' && $_SESSION['access_level']>=2) {
			echo ('<input type="checkbox" name="delete-check" value="delete"> Check this box and then hit ' .
				'<input type="submit" value="delete" name="submit"> to delete this product from the database. </p>');
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