<?php
/*
 * Copyright 2014 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker. This program is part of BMAC-Warehouse, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/
?>

<script src="lib/jquery-1.9.1.js"></script>
<script src="lib/jquery-ui.js"></script>
<script
	src="lib/bootstrap/js/bootstrap.js"></script>

<script>
	$(function () {
		$('img[rel=popover]').popover({
			  html: true,
			  trigger: 'hover',
			  placement: 'right',
			  content: function(){return '<img border="3" src="'+$(this).data('img') + '" width="60%"/>';}
			});
	});
</script>

<p>
	<strong>Adding and Updating Shipments</strong>
<p>This page will help you add and/or update shipments in the database.
<p><strong>Updating an Existing Shipment</strong>
<p>
	<strong>Step 1:</strong> First you need to <strong>search</strong> for
	the shipment whose information you want to edit. <BR> <BR> <a
		href="tutorial/screenshots/shipmentEditHeader.png" class="image"
		title="shipmentEditHeader.png"
		target="tutorial/screenshots/shipmentEditHeader.png">
		&nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/shipmentEditHeader.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/shipmentEditHeader.png"
		border="1px" align="middle"> </a>
</p>
<p>
	To see more information on searching, <a
		href="?helpPage=bmac-warehouse/shipmentSearch.php">click here</a>.
</p>

<p>
	<strong>Step 2:</strong> After finding that shipment, click on
	its <b>Ship Date</b>. You will now see a page with all of the shipment's
	information, like this:<BR> <BR> <a
		href="tutorial/screenshots/shipmentEditInfo.png" class="image"
		title="shipmentEditInfo.png"
		target="tutorial/screenshots/shipmentEditInfo.png">
		&nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/shipmentEditInfo.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/shipmentEditInfo.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<strong>Step 3:</strong> To change any of the shipment
	's information,
	just retype or reselect it. For instance, to change its Funding Source,
	select one of the funding sources from the drop down list.  To add more items to the shipment, 
	use the "add more" button at the bottom of the table. <br><i>REMEMBER:</i> No fields marked by <font
		color="#FF0000">*</font> can be left blank.
</p>

<p>
	<strong>Step 4:</strong> When you finish making changes, select <strong>Submit</strong>
	at the bottom of the page.  You will see a page like this:<BR> <BR> <a
		href="tutorial/screenshots/shipmentEditSubmit.png" class="image"
		title="shipmentEditSubmit.png"
		target="tutorial/screenshots/shipmentEditSubmit.png">
		&nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/shipmentEditSubmit.png" rel="popover"
		data-img="tutorial/screenshots/shipmentEditSubmit.png" width="10%"
		border="1px" align="middle"> </a>
		<br></br>
		Or, if you want to delete a shipment, check the box and hit <b>delete</b>.  You will see a page like this:
		<BR> <BR> <a
		href="tutorial/screenshots/shipmentEditDelete.png" class="image"
		title="shipmentEditDelete.png"
		target="tutorial/screenshots/shipmentEditDelete.png">
		&nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/shipmentEditDelete.png" rel="popover"
		data-img="tutorial/screenshots/shipmentEditDelete.png" width="10%"
		border="1px" align="middle"> </a>
</p>

<p>
	<B>Step 5:</B> If errors occur, <font color=#FF0000>red</font> warnings
	will tell you what you need to correct, like this:<BR> <BR> <a
		href="tutorial/screenshots/shipmentEditError.png" class="image"
		title="shipmentEditError.png"
		target="tutorial/screenshots/shipmentEditError.png"
		horizontalalign="center"> &nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/shipmentEditError.png" width="10%"
		border="1px" rel="popover"
		data-img="tutorial/screenshots/shipmentEditError.png" align="middle"> </a>
	<BR></BR>*After you have make these corrections, repeat <B>Step
		4</B>.
<p>
	<B>Step 6:</B> If you have no errors or omissions, you will see a page
	telling you the edit was successful, like this:<BR> <BR> <a
		href="tutorial/screenshots/shipmentEditSuccess.png" class="image"
		title="shipmentEditSuccess.png"
		target="tutorial/screenshots/shipmentEditSuccess.png"
		horizontalalign="center"> &nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/shipmentEditSuccess.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/shipmentEditSuccess.png"
		border="1px" align="middle"> </a>
<p>
	<B>Step 7:</B> When you finish, you can return to any other function by
	selecting it on the navigation bar.
<p><strong>Adding a New Shipment</strong>
<p>
	<strong>Step 1:</strong> First, <strong> click on </strong>
	the "Add new shipment" option.  You will now see an empty shipment information
	page that looks like this:
	<!--fix this stuff.  Change the screenshots-->
	<BR> <BR> <a
		href="tutorial/screenshots/shipmentEditEmpty.png" class="image"
		title="shipmentEditEmpty.png"
		target="tutorial/screenshots/shipmentEditEmpty.png">
		&nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/shipmentEditEmpty.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/shipmentEditEmpty.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<strong>Step 2:</strong> Each shipment must have a Ship Date, a Ship To and Funding Source,
	a Ship Via, and at least one Product.  These are "autocomplete" fields, which means that a list of choices
	will appear when you being typing.  For example, to select Helpline as the Ship To customer, begin typing 
	"hel", and then select Helpline from the list below.  
		<BR> <BR> <a
		href="tutorial/screenshots/shipmentEditShipTo.png" class="image"
		title="shipmentEditShipTo.png"
		target="tutorial/screenshots/shipmentEditShipTo.png">
		&nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/shipmentEditShipTo.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/shipmentEditShipTo.png"
		border="1px" align="middle"> </a>
 <p>
	This is the same with products.  To add Apple Sauce to the list of products, being typing "app", and then pick
	the item that you want off the list. 
		<BR> <BR> <a
		href="tutorial/screenshots/shipmentEditNewProduct.png" class="image"
		title="shipmentEditNewProduct.png"
		target="tutorial/screenshots/shipmentEditNewProduct.png">
		&nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/shipmentEditNewProduct.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/shipmentEditNewProduct.png"
		border="1px" align="middle"> </a>

	<p>
	Note that for each product you select for a shipment, a unit weight may appear.  You must also enter either
	the number of units (noted as Case Lots) to get the total weight of that product.
	To add more items to the shipment, 
	use the "add more" button at the bottom of the table. <br><i>REMEMBER:</i> No fields marked by <font
		color="#FF0000">*</font> can be left blank.
</p>
<p>
	<strong>Step 3:</strong> When you finish making changes, select <strong>Submit</strong>
	at the bottom of the page.  You will see a page like this:<BR> <BR> <a
		href="tutorial/screenshots/shipmentEditSubmit.png" class="image"
		title="shipmentEditSubmit.png"
		target="tutorial/screenshots/shipmentEditSubmit.png">
		&nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/shipmentEditSubmit.png" rel="popover"
		data-img="tutorial/screenshots/shipmentEditSubmit.png" width="10%"
		border="1px" align="middle"> </a>
		<br></br>
</p>
		