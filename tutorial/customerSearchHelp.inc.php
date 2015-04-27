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
	<strong>Searching for Customers</strong>
<p>
	<B>Step 1:</B> On the navigation bar at the top of the page, find <B>the Customers tab</B>
	and select it:<BR> <BR> <a
		href="tutorial/screenshots/searchcustomerstep1.png" class="image"
		title="searchcustomerstep1.png"
		target="tutorial/screenshots/searchcustomerstep1.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/searchcustomerstep1.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/searchcustomerstep1.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<B>Step 2:</B> You can enter any part of a customer's first name or last
	name as a search criterion. For example, a search for "ann" would
	return <B>Ann</B>, <B>Ann</B>a, Di<B>ann</B>e, etc.
<p>
	You can also search for all customers with a particular status, like
	"Active" or "Inactive" or both status by selecting "All".<BR> <BR> <a
		href="tutorial/screenshots/searchcustomerstep2.png" class="image"
		title="searchcustomerstep2.png" horizontalalign="center"
		target="tutorial/screenshots/searchcustomerstep2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/searchcustomerstep2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/searchcustomerstep2.png"
		border="1px" align="middle"> </a>
</p>

<p>
	<B>Step 3:</B> After typing a cutomer's name or part of a customer's name in the "Customer Name" box,
	select the <B>Search</B> button, like this:<BR> <BR> <a
		href="tutorial/screenshots/searchcustomerstep3.png" class="image"
		title="searchcustomerstep3.png"
		target="tutorial/screenshots/searchcustomerstep3.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/searchcustomerstep3.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/searchcustomerstep3.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<B>Step 4:</B> Now you will see a list of the customer names in the database
	that match your search criteria, like this:<BR> <BR> <a
		href="tutorial/screenshots/searchcustomerstep4.png" class="image"
		title="searchcustomerstep4.png"
		target="tutorial/screenshots/searchcustomerstep4.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/searchcustomerstep4.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/searchcustomerstep4.png"
		border="1px" align="middle"> </a>
<p>
	Note that the customer's phone number and email will appear next to his/her name: <BR>
	<BR> <a href="tutorial/screenshots/searchcustomerstep42.png"
		class="image" title="searchcustomerstep42.png"
		target="tutorial/screenshots/searchcustomerstep42.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/searchcustomerstep42.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/searchcustomerstep42.png"
		border="1px" align="middle"> </a>
</p>
<p>
	If you see the customer you want to view or edit, then <B>click on</B>
	that customer's name. <br>
<p>
	<B>Step 5:</B> If you don't see what you were looking for, you can try
	again by repeating <B>Step 2</B>. <BR> <BR>
</p>

<p>
	<B>Step 6:</B> When you finish, you can return to any other function by
	selecting it on the navigation bar.