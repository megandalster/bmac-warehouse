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
	if ($id=='new') {
	  echo('<p><strong>Receipt Input Form</strong><br />');
	  echo('Here you can add a new receipt to the database. </p>');
    }
    else {
	   echo('<p><strong>Receipt Information Form</strong><br />');
	   echo('Here you can edit or delete the receipt\'s information.</p><p>');
    }
}
?>
<form method="POST">
	<input type="hidden" name="old_id" value=<?PHP echo("\"".$receive_date."\"");?>>
	<input type="hidden" name="_form_submit" value="1">
<p>(<span style="font-size:x-small;color:FF0000">*</span> indicates required information.)

<p>	<?php 
	if ($id=="new") {
		$new_receive_date = date('y-m-d:h:i');
		echo '<input type="hidden" name="receive_date" value="'.$new_receive_date.'">';
		echo '<p>Receipt Date: '.$new_receive_date.'</p>';
		

	}
	else {
		echo '<input type="hidden" name="receive_date" value="'.$contribution->get_receive_date().'">';
		echo 'Receipt Date: '.$contribution->get_receive_date();
		

				
	}
	echo '<p>Provider<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" name="provider_id" tabindex=1 value="'.$contribution->get_provider_id().'"></p>';
	
	$itemArray = $contribution->get_receive_items();
?>
<fieldset>
<legend>Items received <span style="font-size:x-small;color:FF0000">*</span></legend>
	<table>		<tr><td>Product name:</td><td> <input type="text" name="product_name" tabindex=3 value="<?PHP echo($itemArray[0])?>"></td></tr>
		<tr><td>Units:</td><td> <input type="text" name="units" tabindex=4 value="<?PHP echo($itemArray[1])?>"></td></tr>
		<tr><td>Weight:</td><td> <input type="text" name="weight" tabindex=4 value="<?PHP echo($itemArray[2	])?>"></td></tr>


</table>
</fieldset>
<?PHP
	$receive_items = array();
	$receive_items[]=$_POST['product_name'];
	$receive_items[]=$_POST['units'];
	$receive_items[]=$_POST['weight'];
	echo '<input type="hidden" name="receive_items" value="'.implode(":",$receive_items).'">';
    echo('<p>Payment Source<span style="font-size:x-small;color:FF0000">*</span>: ');
    echo('<select name="payment_source">');
    echo('<option value="Donation"');if ($contribution->get_payment_source()=='Donation' || $contribution->get_payment_source()=='') echo (' SELECTED'); echo('>Donation</option>');
	echo('<option value="TEFAP"');if ($contribution->get_payment_source()=='TEFAP') echo (' SELECTED'); echo('>TEFAP</option>');
	echo('<option value="EFAP"');if ($contribution->get_payment_source()=='EFAP') echo (' SELECTED'); echo('>EFAP</option>');
	echo('<option value="EFAP-FB"');if ($contribution->get_payment_source()=='EFAP-FB') echo (' SELECTED'); echo('>EFAP-FB</option>');
	echo('<option value="CSFP"');if ($contribution->get_payment_source()=='CSFP') echo (' SELECTED'); echo('>CSFP</option>');
	echo('<option value="United Way"');if ($contribution->get_payment_source()=='United Way') echo (' SELECTED'); echo('>United Way</option>');
	echo('</select></p>');
	
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