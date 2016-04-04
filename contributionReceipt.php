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
 *	contributionReceipt.php
 *  displays a contribution receipt for printing
 *	@author Allen Tucker
 *	@version June 20, 2015
 */
	session_start();
	session_cache_expire(30);
    include_once('database/dbContributions.php');
    include_once('domain/Contribution.php'); 
    include_once('database/dbProviders.php');
    include_once('domain/Provider.php'); 
	date_default_timezone_set('America/Los_Angeles');
	$id = $_GET["id"];  // expecting "yy-mm-dd:hh:mm"
	$contribution = retrieve_dbContributions($id);
	$provider = retrieve_dbProviders($contribution->get_provider_id());
?>
<html>
	<head>
		<title>
			Editing <?PHP echo('Displaying Contribution Receipt '.$contribution->get_receive_date());?>
		</title>
		<link rel="stylesheet" href="styles.css" type="text/css" />
	</head>
<body>
  <div id="container">
	<div id="contreceiptheader"></div>
	<div id="shippinginvoicecontent">
	<b><br>Receipt No: 
	<?php 
	echo $contribution->get_receive_date();
	echo "<br>Receive Date: ".pretty_date(substr($contribution->get_receive_date(),0,8));
	echo "&nbsp;&nbsp;&nbsp;&nbsp;Funds Source: </td><td>".$contribution->get_payment_source();
	echo "<br><br>Provider: <br>&nbsp;&nbsp;&nbsp;&nbsp;".$provider->get_provider_id();
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;".$provider->get_address().", ".$provider->get_city().", ".
				$provider->get_state()."  ".$provider->get_zip();
	?>
	<br><br><fieldset>
<legend>Items received</legend>
<table><tr><td>Product </td>
<td>Unit Wt</td>
<td>Case Lots</td>
<td>Total Wt. </td></tr>
		
<?php
	$itemArray = $contribution->get_receive_items();
	$total1 = 0; $total2=0;
	foreach ($itemArray as $item) {
		echo "<tr>";
		$details = explode(":",$item);
		if (strpos($details[0],";")>0) {
			$unit_weight = substr($details[0],strrpos($details[0],";")+1);
			$details[0] = substr($details[0],0,strpos($details[0],";"));
			if ($details[2]=="" && $details[1]!="")
				$details[2] = $unit_weight*$details[1];
		} 
		else $unit_weight = "";
		echo "<td>".$details[0] . '</td>';
		echo "<td align=right>".$unit_weight.'</td>';
	    echo "<td align=right>". $details[1] .'</td>';
		echo "<td align=right>".$details[2] . '</td>';
		$total1 += $details[1];
		$total2 += $details[2];
		echo "</tr>";
	}
    echo '<tr><td></td><td>Totals:</td><td align=right>'.
	    $total1.'</td><td align=right>',$total2.'</td><td>pounds.</tr></table>';
    echo '</fieldset>';
    
    echo '<p>Food Value: $'. $contribution->get_billed_amt() . '';
	echo('<p>Notes: '.$contribution->get_notes());
    echo('<br><br><br><p>BMAC Signature __________________________________________ ');
?>	
	</div>	
<a href="//pdfcrowd.com/url_to_pdf/?pdf_name=invoice.pdf">PDF Copy</a>		
	<?php 
	function pretty_date($yy_mm_dd) {
		return date('M j, Y', mktime(0,0,0,substr($yy_mm_dd,3,2),substr($yy_mm_dd,6,2),substr($yy_mm_dd,0,2)));
	}
	?>
  </div>
</body>
</html>