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
	<strong>Searching for Products</strong>
<p>
	<B>Step 1:</B> On the navigation bar at the top of the page, find <B>the Products tab</B>
	and select it:<BR> <BR> <a
		href="tutorial/screenshots/productsearchstep1.png" class="image"
		title="productsearchstep1.png"
		target="tutorial/screenshots/productsearchstep1.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/productsearchstep1.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/productsearchstep1.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<B>Step 2:</B> You can enter any part of a Product's
	name as a search criterion. For example, a search for "alm" would
	return <B>Alm</B>onds, S<B>alm</B>on, Canned S<B>alm</B>on, etc.
<p>
	You can also search for all Products with a particular status, like
	"Active" or "Discontinued" or both status by selecting "All". 
<p>	
	Likewise, you can
	search for any Products with a particular Funding Source, like "TFAP" or
	"Food Donation" or search through all funding sources by selecting "Any".<BR> <BR> <a
		href="tutorial/screenshots/productsearchstep2.png" class="image"
		title="productsearchstep2.png" horizontalalign="center"
		target="tutorial/screenshots/productsearchstep2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/productsearchstep2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/productsearchstep2.png"
		border="1px" align="middle"> </a>
</p>

<p>
	<B>Step 3:</B> After typing a Product's name or part of a Product's name in the "Product Name" box,
	select the <B>Search</B> button, like this:<BR> <BR> <a
		href="tutorial/screenshots/productsearchstep3.png" class="image"
		title="productsearchstep3.png"
		target="tutorial/screenshots/productsearchstep3.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/productsearchstep3.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/productsearchstep3.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<B>Step 4:</B> Now you will see a list of the Product names in the database
	that match your search criteria, like this:<BR> <BR> <a
		href="tutorial/screenshots/productsearchstep4.png" class="image"
		title="productsearchstep4.png"
		target="tutorial/screenshots/productsearchstep4.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/productsearchstep4.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/productsearchstep4.png"
		border="1px" align="middle"> </a>
<p>
	Note that the Product's <b>most recent inventory information</b> will appear next to its name: <BR>
	<BR> <a href="tutorial/screenshots/productsearchstep5.png"
		class="image" title="productsearchstep5.png"
		target="tutorial/screenshots/productsearchstep5.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/productsearchstep5.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/productsearchstep5.png"
		border="1px" align="middle"> </a>
</p>
<p>
	If you see the Product you want to view or edit, then <B>click on</B>
	that Product's name. <br>
	
	If you see the Product you want to update the product's inventory, then <B>click on</B>
	the inventory worksheet link at the top of the page. <br>
	<p>
	To see more information on updating product inventory, <a
		href="?helpPage=inventoryHelp.php">click here</a>.
<p>
	<B>Step 5:</B> If you don't see what you were looking for, you can try
	again by repeating <B>Step 2</B>. <BR> <BR>
</p>

<p>
	<B>Step 6:</B> When you finish, you can return to any other function by
	selecting it on the navigation bar.