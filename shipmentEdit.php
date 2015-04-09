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
 *	shipmentEdit.php
 *  oversees the editing of a shipment to be added, changed, or deleted from the database
 *	@author Dylan Martin
 *	@version March 13, 2015
 */
	session_start();
	session_cache_expire(30);
    include_once('database/dbShipments.php');
    include_once('domain/Shipment.php'); 
    include_once('database/dbProducts.php');
    include_once('domain/Product.php'); 
    
//    include_once('database/dbLog.php');
	date_default_timezone_set('America/Los_Angeles');
	$id = $_GET["id"];  // expecting either "new" or "yy-mm-dd:hh:mm"
	if ($id=='new') {
		$shipment = new Shipment("new", null, date('y-m-d:h:m'), null, null, null, null, null, null, null, null);
	}
	else {
		$shipment = retrieve_dbShipmentsDate($id);
		if (!$shipment) {
	         echo('<p id="error">Error: there\'s no shipment from this date in the database</p>'. $ship_date);
		     die();
        }  
	}
	$ship_date = $shipment->get_ship_date();
?>
<html>
	<head>
		<title>
			Editing <?PHP echo('Editing Shipment '.$shipment->get_ship_date());?>
		</title>
		<link rel="stylesheet" href="lib/jquery-ui.css" />
		<link rel="stylesheet" href="styles.css" type="text/css" />
		<script src="lib/jquery-1.9.1.js"></script>
		<script src="lib/jquery-ui.js"></script>
<script>
$(function() {
	$(document).on("keyup", ".product-id", function() {
		var str = $(this).val();
		var target = $(this);
		$.ajax({
			type: 'GET',
			url: 'advanced_getProducts.php?q='+str
		})
		 .done(function (response) {
			//console.log(response)
			var suggestions = $.parseJSON(response);
			//console.log(suggestions);
			target.autocomplete({
				source: suggestions	
			});
		});
	});
	
	$(document).on("keyup", ".customer-id", function() {
		var str = $(this).val();
		var target = $(this);
		$.ajax({
			type: 'GET',
			url: 'advanced_getCustomers.php?q='+str
		})
		 .done(function (response) {
			//console.log(response)
			var suggestions = $.parseJSON(response);
			//console.log(suggestions);
			target.autocomplete({
				source: suggestions	
			});
		});
	});
	
	$("#add-more").on('click', function(e) {
		e.preventDefault();
		var new_row = '<p class=ui-widget>'
	    	+ '<input type="text" name="product-id[]" class="product-id" tabindex=1 size=30>&nbsp;&nbsp;&nbsp;&nbsp;'
		 	+ '<input type="text" name="product-unit-wt[]" class="product-unit-wt" tabindex=2 size=10>&nbsp;&nbsp;&nbsp;&nbsp;'
	    	+ '<input type="text" name="product-units[]" class="product-units" tabindex=3 size=10>&nbsp;&nbsp;&nbsp;&nbsp;'
			+ '<input type="text" name="product-total-wt[]" class="product-total-wt" tabindex=4 size=10>'
			+ '</p>';
		$("#product-rows").append(new_row);
	});
	$( "#date" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true});
});
</script>
	</head>
<body>
  <div id="container">
    <?PHP include('header.php');?>
	<div id="content">
<?PHP
	if($_POST['_form_submit']!=1){
	//in this case, the form has not been submitted, so show it
		include('shipmentForm.inc');
	}
	else {
		
	//in this case, the form has been submitted, so validate it
		$customer_id = trim(str_replace('\\\'','',htmlentities(trim($_POST['customer-id']))));
		$funds_source = $_POST['funds_source'];
		$ship_date = $_POST['date'].substr($shipment->get_ship_date(),8);
		$ship_via = $_POST['ship_via'];
		$ship_items = gather_ship_items($_POST['product-id'],$_POST['product-unit-wt'],$_POST['product-units'],$_POST['product-total-wt']);
		$ship_rate = trim(str_replace('\\\'','\'',htmlentities($_POST['ship_rate'])));
		$total_weight = trim(str_replace('\\\'','\'',htmlentities($_POST['total_wt'])));
		$billed_amt = trim(str_replace('\\\'','\'',htmlentities($_POST['billed_amt'])));
		$notes = trim(str_replace('\\\'','\'',htmlentities($_POST['notes'])));
		$shipment = new Shipment($customer_id, $funds_source, $ship_date, $ship_via, $ship_items, 
			$ship_rate, $total_weight, $billed_amt, substr($ship_date,0,8), "", $notes);
		$errors = validate_form($_POST,$shipment); 	//step one is validation.
        // errors array lists problems on the form submitted
		if ($errors) {
		// display the errors and the form to fix
			show_errors($errors);
			include('shipmentForm.inc');
		}
		// this was a successful form submission; update the database and exit
		else
			process_form($_POST, $shipment);
		include('footer.inc');
		echo('</div></div></body></html>');
		die();
	}

function gather_ship_items($ids, $unit_wts, $units, $wts) {
	$ship_items = ""; 
	for ($i=0;$i<count($ids);$i++) 
	    if ($ids[$i]!="") {
	    	if ($unit_wts[$i]!="")
	    	    $ship_items .= ",".$ids[$i].";".$unit_wts[$i].":".$units[$i].":".$wts[$i];
		    else 
		        $ship_items .= ",".$ids[$i].":".$units[$i].":".$wts[$i];
	    }
	return substr($ship_items,1);
}
	
/**
* process_form sanitizes data, concatenates needed data, and enters it all into a database
*/
function process_form($post,$shipment)	{
	    //try to make the deletion
		if($post['submit']=='delete' && $post['delete-check']=='delete') {
			$result = retrieve_dbShipmentsDate($shipment->get_ship_date());
			if (!$result)
				echo('<p>Unable to delete. Shipment with timestamp ' . $shipment->get_ship_date() .' is not in the database.');
			else {
				$result = delete_dbShipmentsDate($shipment->get_ship_date());
				echo("<p>You have successfully removed the shipment with timestamp " .$shipment->get_ship_date(). " from the database.</p>");	
			}
		}

		// try to add a new contribution (receipt) to the database
		else if ($post['old_id']=='new') {
			    //check if there's already an entry
				$dup = retrieve_dbShipmentsDate($shipment->get_ship_date());
				if ($dup)
					echo('<p class="error">Unable to add shipment with timestamp' .$shipment->get_ship_date(). ' to the database. <br>Another shipment with the same timestamp is already there.');
				else {
					$result = insert_dbShipments($shipment);
					if (!$result)
                        echo ('<p class="error">Unable to add the shipment for "' .$shipment->get_customer_id(). '" to the database. <br>Please report this error to the Program manager.');
					else echo("<p>You have successfully added a shipment for " .$shipment->get_customer_id(). " with timestamp <a href='shipmentEdit.php?id=".
								$shipment->get_ship_date(). "'>".$shipment->get_ship_date()."</a> in the database.</p>");
				}
		}

		// try to replace an existing receipt in the database by removing and adding
		else {
				$result = delete_dbShipmentsDate($post['old_id']);
                if (!$result)
                   echo ('<p class="error">Unable to update shipment with timestamp ' .$post['old_id']. '. <br>Please report this error to the Program manager.');
				else {
					$result = insert_dbShipments($shipment);
                	if (!$result)
                   		echo ('<p class="error">Unable to update shipment with timestamp ' .$shipment->get_ship_date(). '. <br>Please report this error to the Foodbank Director.');
					else echo("<p>You have successfully updated the shipment for " .$shipment->get_customer_id(). " with timestamp <a href='shipmentEdit.php?id=".
								$shipment->get_ship_date(). "'>".$shipment->get_ship_date()."</a> in the database.</p>");
//					add_log_entry('<a href=\"viewContribution.php?id='.$provider_id.'\">'.'</a>\'s database entry has been updated.');
				}
		}
}

function validate_form($post,$id){
	if($id=='new' && $_POST['customer-id']==null || $_POST['customer-id']=='new'
					 || $_POST['customer-id']=='') $errors[] = 'Please enter the name of the provider';
	if (!valid_date($_POST['date'])) $errors[] = 'Please enter a valid receipt date';
	if($post['product-id']==null) $errors[] = 'Please enter the items received';
	if($post['funds_source']==null) $errors[] = 'Please enter the funds source';
	return $errors;
}
function valid_date($date)
{
    $d = DateTime::createFromFormat('y-m-d', $date);
    return $d && $d->format('y-m-d') == $date;
}

function show_errors($e){
		//this function should display all of our errors.
		echo('<div class="warning">');
		echo('<ul>');
		foreach($e as $error){
			echo("<li><strong><font color=\"red\">".$error."</font></strong></li>\n");
		}
		echo("</ul></div></p>");
}
?>
    </div>
    <?PHP include('footer.inc');?>		
  </div>
</body>
</html>
