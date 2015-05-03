<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker. This program is part of BMAC-Warehouse, which is 
 * free software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 * 
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
	<strong>Searching for Shipments</strong>
<p>
	<B>Step 1:</B> On the navigation bar at the top of the page, find <B>the Shipments tab</B>
	and select it:<BR> <BR> <a
		href="tutorial/screenshots/shipmentSearchHelpHeader.png" class="image"
		title="shipmentSearchHelpHeader.png"
		target="tutorial/screenshots/shipmentSearchHelpHeader.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/shipmentSearchHelpHeader.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/shipmentSearchHelpHeader.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<B>Step 2:</B> To search within a date range, click first on the Date From box.  A mini calendar will
	appear. 
		<BR> <BR> <a
		href="tutorial/screenshots/shipmentSearchHelpDateFrom.png" class="image"
		title="shipmentSearchHelpDateFrom.png"
		target="tutorial/screenshots/shipmentSearchHelpDateFrom.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/shipmentSearchHelpDateFrom.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/shipmentSearchHelpDateFrom.png"
		border="1px" align="middle"> </a>
	Navigate to the date on which you want to being your search, and then click the little date on
	calendar.  <br></br>The date will then appear in the box.  
		<BR> <BR> <a
		href="tutorial/screenshots/shipmentSearchHelpDateFrom2.png" class="image"
		title="shipmentSearchHelpDateFrom2.png"
		target="tutorial/screenshots/shipmentSearchHelpDateFrom2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/shipmentSearchHelpDateFrom2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/shipmentSearchHelpDateFrom2.png"
		border="1px" align="middle"> </a>
	<br></br>Do the same thing for the "to:" box, and be <i>careful that the date range is temporally possible</i> (e.g.
	don't put a date in the "to:" box that precedes the date in the "from:" box.  
<p>
	<B>Step 2:</B> You can also search for specific customer names and products.  To search for a customer, simply
	type the name of the customer that you're searching for into the Customer Name box. 
	<BR> <BR> <a
		href="tutorial/screenshots/shipmentSearchHelpCustomer.png" class="image"
		title="shipmentSearchHelpCustomer.png"
		target="tutorial/screenshots/shipmentSearchHelpCustomer.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/shipmentSearchHelpCustomer.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/shipmentSearchHelpCustomer.png"
		border="1px" align="middle"> </a> 
	<br></br>To search for a product,
	type the name of the product into the Product box.  <BR> <BR> <a
		href="tutorial/screenshots/shipmentSearchHelpProduct.png" class="image"
		title="shipmentSearchHelpProduct.png"
		target="tutorial/screenshots/shipmentSearchHelpProduct.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/shipmentSearchHelpProduct.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/shipmentSearchHelpProduct.png"
		border="1px" align="middle"> </a>
</p>

<p>
	<B>Step 3:</B> After specifying the search criteria,
	select the <B>Search</B> button, like this:<BR> <BR> <a
		href="tutorial/screenshots/shipmentSearchHelpSearch.png" class="image"
		title="shipmentSearchHelpSearch.png"
		target="tutorial/screenshots/shipmentSearchHelpSearch.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/shipmentSearchHelpSearch.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/shipmentSearchHelpSearch.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<B>Step 4:</B> Now you will see a list of the shipments in the database
	that match your search criteria, like this:<BR> <BR> <a
		href="tutorial/screenshots/shipmentSearchHelpResults.png" class="image"
		title="shipmentSearchHelpResults.png"
		target="tutorial/screenshots/shipmentSearchHelpResults.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/shipmentSearchHelpResults.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/shipmentSearchHelpResults.png"
		border="1px" align="middle"> </a>
<p>
	
</p>
<p>
	If you see the customer you want to view or edit, then click on
	that customer's <b>ship date</b>.  For more information on adding and editing shipments,
	<a href="?helpPage=bmac-warehouse/shipmentEdit.php">click here</a>.  <br>
<p>
	<B>Step 5:</B> If you don't see what you were looking for, you can try
	again by repeating <B>Step 2</B>. <BR> <BR>
</p>

<p>
	<B>Step 6:</B> When you finish, you can return to any other function by
	selecting it on the navigation bar.