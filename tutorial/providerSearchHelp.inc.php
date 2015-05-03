<?php
/*
 * Copyright 2013 by Jerrick Hoang, Ivy Xing, Sam Roberts, James Cook,
 * Johnny Coster, Judy Yang, Jackson Moniaga, Oliver Radwan,
 * Maxwell Palmer, Nolan McNair, Taylor Talmage, and Allen Tucker.
 * This program is part of RMH Homebase, which is free software.  It comes with
 * absolutely no warranty. You can redistribute and/or modify it under the terms
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
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
	<strong>Searching for Providers</strong>
<p>
	<B>Step 1:</B> On the navigation bar at the top of the page, click on <B>providers:</B>
	<BR> <BR> <a href="tutorial/screenshots/searchproviderstep1.png"
		class="image" title="searchproviderstep1.png"
		target="tutorial/screenshots/searchproviderstep1.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/searchproviderstep1.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/searchproviderstep1.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<B>Step 2:</B> You can enter any part of a provider's name as a search criterion. 
	For example, a search for "Vin" would
	return <B>Vin</B>eyards, Coffee Cra<B>vin</b>gs, St. <B>Vin</b>cents, etc.
<p>
	You can also search for all providers with a particular status, like
	"Active" or "Inactive".<BR> <BR>
</p>
<p>
	Another option is to search for a particular type of people, like "Food" or "Funds".
	<BR> <BR> <a
		href="tutorial/screenshots/searchproviderstep2.png" class="image"
		title="searchproviderstep2.png" horizontalalign="center"
		target="tutorial/screenshots/searchproviderstep2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/searchproviderstep2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/searchproviderstep2.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<B>Step 3:</B> After typing your criteria in the appropriate box,
	select the <B>Search</B> button, like this:<BR> <BR> <a
		href="tutorial/screenshots/searchproviderstep3.png" class="image"
		title="searchproviderstep3.png"
		target="tutorial/screenshots/searchproviderstep3.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/searchproviderstep3.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/searchproviderstep3.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<B>Step 4:</B> Now you will see a list of the providers in the database
	that match your search criteria, like this:<BR> <BR> <a
		href="tutorial/screenshots/searchproviderstep4.png" class="image"
		title="searchproviderstep4.png"
		target="tutorial/screenshots/searchproviderstep4.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/searchproviderstep4.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/searchproviderstep4.png"
		border="1px" align="middle"> </a>
<p>
	Note that the provider's phone number and email will appear next to their name if 
	that information is in the database: <BR>
	<BR> <a href="tutorial/screenshots/searchproviderstep4-2.png"
		class="image" title="searchproviderstep4.png"
		target="tutorial/screenshots/searchproviderstep4-2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/searchproviderstep4-2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/searchproviderstep4-2.png"
		border="1px" align="middle"> </a>
</p>
<p>
	If you see the provider you want to view or edit, then <B>click on</B>
	that provider's name. <br>
<p>
	<B>Step 5:</B> If you don't see what you were looking for, you can try
	again by repeating <B>Step 2</B>. <BR> <BR>
</p>

<p>
	<B>Step 6:</B> When you finish, you can return to any other function by
	selecting it on the navigation bar.