<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker. This program is part of BMAC-Warehouse, which is 
 * free software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 */
/*
 * reports page for BMAC Warehouse
 * @author Jerrick Hoang and Allen Tucker
 * @version 3/13/2015
 */
session_start();
session_cache_expire(30);

include_once('header.php');
date_default_timezone_set('America/Los_Angeles');
                	 
?>

<html>
<head>
<title>Search for data objects</title>	
<link rel="stylesheet" href="styles.css" type="text/css" />
<link rel="stylesheet" href="lib/jquery-ui.css" />
<script src="lib/jquery-1.9.1.js"></script>
<script src="lib/jquery-ui.js"></script>
<script>
$(function() {
	$( "#from" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true});
	$( "#to" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true});

	$(document).on("keyup", ".volunteer-name", function() {
		var str = $(this).val();
		var target = $(this);
		$.ajax({
			type: 'get',
			url: 'reportsCompute.php?q='+str,
			success: function (response) {
				var suggestions = $.parseJSON(response);
				console.log(target);
				target.autocomplete({
					source: suggestions
				});
			}
		});
	});

	$("input[name='date']").change(function() {
		if ($("input[name='date']:checked").val() == 'date-range') {
			$("#fromto").show();
		} else {
			$("#fromto").hide();
		}
	});

	$("#report-submit").on('click', function (e) {
		e.preventDefault();
		$.ajax({
			type: 'post',
			url: 'reportsCompute.php',
			data: $('#search-fields').serialize(),
			success: function (response) {
				$("#outputs").html(response);
			}
		});
	} );
	
	$("#add-more").on('click', function(e) {
		e.preventDefault();
		var new_input = '<div class="ui-widget"> <input type="text" name="volunteer-names[]" class="volunteer-name"></div>';
		$("#volunteer-name-inputs").append(new_input);
	})
});
</script>
</head>
<body>
<div id="container">

<div id = "content">
<div>
	<p id="search-fields-container">
	<form id = "search-fields" method="post">
		<input type="hidden" name="_form_submit" value="report" />
		<p class = "search-description" id="today"> <b>BMAC Warehouse Reports</b><br> Report date: <?php echo Date("F d, Y");?></p>
	<table>	<tr>
		<td class = "search-description" valign="top"> Select Report Type: 
		<p>	<select multiple name="report-types[]" id = "report-type" size="6">
	  		<option value="shipments">Inventory Shipments</option>
	  		<option value="receipts">Inventory Receipts</option>
	  		<option value="inventory">Current Inventory</option>
	  		<option value="customers">Current Customers</option>
	  		<option value="providers">Current Providers</option>
			</select>
		</p>
		</td>
		<td class = "search-description" valign="top"> Date Range: 
			<p id="fromto"> from : <input name = "from" type="text" id="from"><br>
							&nbsp;&nbsp;&nbsp;&nbsp;to : <input name = "to" type="text" id="to"></p>
		</td>
		<td class = "search-description" valign="top"> Status:
		    <p id="status-input"> <select name="status" id = "report-status">
	  		<option value="">--any--</option>
	  		<option value="active">Active</option>
	  		<option value="inactive">Inactive/Discontinued</option>
		</td>
		<td class = "search-description" valign="top"> Funding Source:
		    <p id="funding-sourceinput"> <select name="funding-source" id = "report-funding-source">
	  		<option value="">--any--</option>
	  		<option value="TFAP">TFAP</option>
	  		<option value="CSFP">CSFP</option>
	  		<option value="INK">INK</option>
	  		<option value="donation">Donation</option>
		</td>
	</tr> <tr> <td></td><td></td><td>
	To view the report <p>Hit <input type="submit" value="submit" id ="report-submit" class ="btn"></p>
	</td>
	<td>
	To save the report <p>Hit <input type="submit" value="CSV" id ="report-csv" class ="btn">
	</p>
	</td>
	</tr>
	</table>
	</form>
	<p id="outputs">

	</p>
</div>
</div>
</div>

</body>