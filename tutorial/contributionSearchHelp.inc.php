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
Here you can search for the receipts of contributions received. You can search by the date range in which receipts were made, by the name of the provider, and by the name of the
received item. You can view the products received per contribution, their amount in case lots, and weight of each product. It also includes total weight of contribution and the amount
billed for the receipt. You can also select individual receipts to edit them, or add a new receipt.
</p>
<p>
	<B>Step 1:</B> On the navigation bar at the top of the page, click on the date range boxes and select the dates you want to search on by clicking on the day box:<BR> <BR><a
		href="tutorial/screenshots/contributionSearchHelp1.png" class="image"
		title="contributionSearchHelp1.png"
		target="tutorial/screenshots/contributionSearchHelp1.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionSearchHelp1.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionSearchHelp1.png"
		border="1px" align="middle"> </a>
</p>
<p>
	Afterwards, click on the <b>Provider name: </b>box and type the first letters of the provider in the receipt. You can also select
	the <b>Receive items:</b> box and type in the first letters of the product whose receipts you are looking for. Afterwards, hit <b>Search</b>. <BR> <BR> <a
		href="tutorial/screenshots/contributionSearchHelp1-2.png" class="image"
		title="contributionSearchHelp1-2.png"
		target="tutorial/screenshots/contributionSearchHelp1-2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionSearchHelp1-2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionSearchHelp1-2.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<B>Step 2:</B> The list of receipts that match your search parameters will be shown in chronological order by date of receipt. The receipt includes the products received, 
	amount in case lots, and weight per case. It also includes the total weight of the items received, and amount billed. Scroll down to see all the results. <BR> <BR><a
		href="tutorial/screenshots/contributionSearchHelp2.png" class="image"
		title="contributionSearchHelp2.png"
		target="tutorial/screenshots/contributionSearchHelp2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionSearchHelp2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionSearchHelp2.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<B>Step 3:</B> Click on the date of any receipt to edit it. <b><a href="help.php?helpPage=bmac-warehouse/contributionEdit.php">Editing a receipt</a></b> <BR> <BR><a
		href="tutorial/screenshots/contributionSearchHelp3.png" class="image"
		title="contributionSearchHelp3.png"
		target="tutorial/screenshots/contributionSearchHelp3.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionSearchHelp3.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionSearchHelp3.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<B>Step 4:</B> Click on <b>Add new receipt</b> to add a new receipt into the database. <b><a href="help.php?helpPage=bmac-warehouse/contributionEdit.php">Adding a new a receipt</a></b> <BR> <BR><a
		href="tutorial/screenshots/contributionSearchHelp4.png" class="image"
		title="contributionSearchHelp4.png"
		target="tutorial/screenshots/contributionSearchHelp4.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionSearchHelp4.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionSearchHelp4.png"
		border="1px" align="middle"> </a>
</p>