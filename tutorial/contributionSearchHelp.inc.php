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
	<strong>Searching for Receipts</strong>
</p>
<p>
Here you can search for the receipts of contributions received. You can limit the search by specifying the date range in which receipts were made, 
the name of the provider, and/or the name of the received product. 
<p>
From this page, you can also select an individual receipt for editing its details, or else add an entirely new receipt.
</p>
<p>
	<B>Step 1:</B> On the navigation bar at the top of the page, you may click on the date range boxes to select a date range, like this:<BR> <BR><a
		href="tutorial/screenshots/contributionSearchHelp1.png" class="image"
		title="contributionSearchHelp1.png"
		target="tutorial/screenshots/contributionSearchHelp1.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionSearchHelp1.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionSearchHelp1.png"
		border="1px" align="middle"> </a>
</p>
<p>
	Also, you may limit the <b>Provider name </b> by typing the first few letters of the provider. Similarly, you can limit your search
	to a particular product by typing a few letters of its name in the <b>Receive items:</b> box.  Afterwards, hit <b>Search</b>. <BR> <BR> <a
		href="tutorial/screenshots/contributionSearchHelp1-2.png" class="image"
		title="contributionSearchHelp1-2.png"
		target="tutorial/screenshots/contributionSearchHelp1-2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionSearchHelp1-2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionSearchHelp1-2.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<B>Step 2:</B> The list of receipts that match your limits will be shown in chronological order by date of receipt.  Scroll down to see all the results. <BR> <BR><a
		href="tutorial/screenshots/contributionSearchHelp2.png" class="image"
		title="contributionSearchHelp2.png"
		target="tutorial/screenshots/contributionSearchHelp2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionSearchHelp2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionSearchHelp2.png"
		border="1px" align="middle"> </a>
<p>
As shown, the search produces a list of contributions alphabetized by provider.  Each contribution shows the date received, the provider, the 
total weight, amount billed, and a list of the products received, their case lotsm and weight. 

<p>
	<B>Step 3:</B> Clicking on the date of any receipt sends you to a page where you can <a href="help.php?helpPage=bmac-warehouse/contributionEdit.php">edit it.</a> <BR> <BR><a
		href="tutorial/screenshots/contributionSearchHelp3.png" class="image"
		title="contributionSearchHelp3.png"
		target="tutorial/screenshots/contributionSearchHelp3.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionSearchHelp3.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionSearchHelp3.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<B>Step 4:</B> Clicking on <a href="help.php?helpPage=bmac-warehouse/contributionEdit.php">Add new receipt</a> sends you to a page where you can create a receipt for a new contribution.  <BR> <BR><a
		href="tutorial/screenshots/contributionSearchHelp4.png" class="image"
		title="contributionSearchHelp4.png"
		target="tutorial/screenshots/contributionSearchHelp4.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionSearchHelp4.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionSearchHelp4.png"
		border="1px" align="middle"> </a>

<p>
	<B>Step 5:</B> Otherwise, you can return to any other activity by
	selecting it on the navigation bar at the top of the page. 