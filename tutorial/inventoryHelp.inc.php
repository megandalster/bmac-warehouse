<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker.  This program is part of Homerestore, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
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
	<strong>Using the Inventory Worksheet</strong>
</p>
<p> Here you can view the products that the warehouse has currently in stock, their history, and you can also update their current stock.<br>
	You can also undo recent changes to products if the information you input was erroneous.
</p>
<p>
	<B>Step 1:</B> On the navigation bar at the top of the page, find <B>Work on inventory for all active products with names that begin with:</B>
	and type in the search box the initial letters of the products you want to review. Then, press enter or update:<BR> <BR> <a
		href="tutorial/screenshots/inventoryHelp1.png" class="image"
		title="inventoryHelp1.png" horizontalalign="center"
		target="tutorial/screenshots/inventoryHelp1.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/inventoryHelp1.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/inventoryHelp1.png"
		border="1px" align="center"> </a>
</p>
<p>
	<B>Step 2:</B> You should now see a long list of all products that match your search parameters:<BR> <BR> <a
		href="tutorial/screenshots/inventoryHelp2.png" class="image"
		title="inventoryHelp2.png" horizontalalign="center"
		target="tutorial/screenshots/inventoryHelp2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/inventoryHelp2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/inventoryHelp2.png"
		border="1px" align="center"> </a><BR> You can scroll down to see the full list. <br>(NOTE:&nbsp All fields marked
		by <font color="#FF0000">*</font> are required before a person can be
	added to the database.)
</p>

<p>
	<B>Step 3:</B> There will be two boxes at the right of each product information, where you can edit their <B>Current Stock in case lots</B> and
	their <B>Current Stock in total weight</B> by typing them in the box and hitting update.<BR> <BR> <b>1.</b><a
		href="tutorial/screenshots/inventoryHelp3.png" class="image"
		title="inventoryHelp3.png" horizontalalign="center"
		target="tutorial/screenshots/inventoryHelp3.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/inventoryHelp3.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/inventoryHelp3.png"
		border="1px" align="center"> </a>
		<BR> <BR> <b>2.</b><a
		href="tutorial/screenshots/inventoryHelp3-2.png" class="image"
		title="inventoryHelp3-2.png" horizontalalign="center"
		target="tutorial/screenshots/inventoryHelp3-2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/inventoryHelp3-2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/inventoryHelp3-2.png"
		border="1px" align="center"> </a>

</p>
<p>
	<B>Step 4:</B> If you leave either box blank, it will be automatically computed given the last inventory check of the product, plus its recent shipments and receipts, like so:<BR> <BR> <b>1.</b><a
		href="tutorial/screenshots/inventoryHelp4.png" class="image"
		title="inventoryHelp4.png" horizontalalign="center"
		target="tutorial/screenshots/inventoryHelp4.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/inventoryHelp4.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/inventoryHelp4.png"
		border="1px" align="center"> </a>
		<BR> <BR> <b>2.</b><a
		href="tutorial/screenshots/inventoryHelp4-2.png" class="image"
		title="inventoryHelp4-2.png" horizontalalign="center"
		target="tutorial/screenshots/inventoryHelp4-2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/inventoryHelp4-2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/inventoryHelp4-2.png"
		border="1px" align="center"> </a>

</p>
		
		
		
		
<p>
	<B>Step 5:</B> If you make a mistake or omit a required field, check the <b>Undo</b> box and hit update on the product you wish to revert changes:<BR> <BR> <a
		href="tutorial/screenshots/inventoryHelp5.png" class="image"
		title="inventoryHelp5.png" horizontalalign="center"
		target="tutorial/screenshots/inventoryHelp5.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/inventoryHelp5.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/inventoryHelp5.png"
		border="1px" align="center"> </a>
		<BR> <BR> <b>2.</b><a
		href="tutorial/screenshots/inventoryHelp5-2.png" class="image"
		title="inventoryHelp5-2.png" horizontalalign="center"
		target="tutorial/screenshots/inventoryHelp5-2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/inventoryHelp5-2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/inventoryHelp5-2.png"
		border="1px" align="center"> </a>

</p>

<p>
	<B>Step 6:</B> When you finish, you can return to any other function by
	selecting it on the navigation bar. 
</p>