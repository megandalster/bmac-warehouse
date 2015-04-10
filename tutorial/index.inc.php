<?php
/*
 * Copyright 2014 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker. This program is part of BMAC-Warehouse, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/
session_start();
session_cache_expire(30);
?>
<html>
<head>
<title>RMH Homebase</title>
</head>
<body>
	<p>
		<strong>BMAC-Warehouse Help Pages</strong>
	</p>
	<ol>
		<li><a href="?helpPage=bmac-warehouse/login.php">Signing in and out of the System</a>
		</li>
		<br>
		<ul>
			<li><a href="?helpPage=bmac-warehouse/index.php">About your Personal Home Page</a></li>
		</ul>
		<br>
		<li><strong>Working with Staff and Product Database Records</strong> (Foodbank Director Only)</li>
		<br>
		<ul>
			<li><a href="?helpPage=bmac-warehouse/personEdit.php">Adding and Updating Staff Logins</a></li>
			<li><a href="?helpPage=bmac-warehouse/personSearch.php">Searching for Products</a></li>
			<li><a href="?helpPage=bmac-warehouse/personEdit.php">Adding and Updating Products</a></li>
			<li><a href="?helpPage=bmac-warehouse/personAdd.php">Updating the Inventory Database </a></li>
			
		</ul>
		<br>
		<li><strong>Working with Shipments and Receipts</strong> (Warehouse Staff and Director)</li>
		<br>
		<ul>
			<li><a href="?helpPage=bmac-warehouse/personSearch.php">Searching for Shipments</a></li>
			<li><a href="?helpPage=bmac-warehouse/personEdit.php">Editing and Adding a New Shipment</a></li>
			<li><a href="?helpPage=bmac-warehouse/personSearch.php">Searching for Contributions</a></li>
			<li><a href="?helpPage=bmac-warehouse/personEdit.php">Editing and Adding a New Receipt</a></li>
		</ul>
		<br>
		<li><strong>Working with Contributors and Customers</strong> (Office Staff and Director)</li>
		<br>
		<ul>
			<li><a href="?helpPage=bmac-warehouse/personSearch.php">Searching for Contributors</a></li>
			<li><a href="?helpPage=bmac-warehouse/personEdit.php">Editing and Adding a New Contributor</a></li>
			<li><a href="?helpPage=bmac-warehouse/personSearch.php">Searching for Customers</a></li>
			<li><a href="?helpPage=bmac-warehouse/personEdit.php">Editing and Adding a New Customer</a></li>
		</ul>
		
		<br>
		<li><a href="?helpPage=bmac-warehouse/reports.php">Generating Reports</a> (Office Staff and Director)</li>
		<br>
		<ul><li><a href="?helpPage=bmac-warehouse/dataExport.inc.php">The Current Inventory Report</a></li>
		</ul><ul><li><a href="?helpPage=bmac-warehouse/dataExport.inc.php">The Inventory Shipments Report </a></li>
		</ul><ul><li><a href="?helpPage=bmac-warehouse/dataExport.inc.php">The Inventory Reipts Report</a></li>
		</ul><ul><li><a href="?helpPage=bmac-warehouse/dataExport.inc.php">The Current Customers Report</a></li>
		</ul><ul><li><a href="?helpPage=bmac-warehouse/dataExport.inc.php">The Current Providers Report</a></li>
		</ul><ul><li><a href="?helpPage=bmac-warehouse/dataExport.inc.php">Exporting Report Data (CSV for Excel)</a></li>
		</ul>
	</ol>
	<p>
		If these help pages don't answer your questions, please contact the <a
			href="mailto:jmathias@bmacww.org">Foodbank Director</a>.
	</p>
</body>
</html>

