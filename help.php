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
		<title>
			Help - <?PHP echo($_GET['helpPage']); ?>
		</title>
		<link rel="stylesheet" href="tutorial/styles.css" type="text/css" />
	</head>

	<body>
		<div id="container">
			<div id="content">
				<div align="center"><p><a href="?">Help Home</a></p></div>

				<?PHP
					//This array associates pages a person might be viewing
					//with the help page we assume they want. Note: it might be important
					//for each page to include within it a link to the 'home help' website
					//to allow us to get them to material somewhere else they might want.
					//you can guarantee a link to the home site by simply linking to
					//help.php with no variable passed through the GET method.
//developer templage
$assocHelp['helpPageTemplate.php']='helpPageTemplate.inc.php';
				
					//basic pages
					$assocHelp['login.php']='loginHelp.inc.php';
					$assocHelp['index.php']='indexHelp.inc.php';
					
					//staff and product searching and editing, inventory updating
					$assocHelp['personEdit.php']='personEditHelp.inc.php';
					$assocHelp['productSearch.php']='productSearchHelp.inc.php';
					$assocHelp['productEdit.php']='productEditHelp.inc.php';
					$assocHelp['inventory.php']='inventoryHelp.inc.php';
					
					//shipments and receipts
					$assocHelp['shipmentSearch.php']='shipmentSearchHelp.inc.php';
					$assocHelp['shipmentEdit.php']='shipmentEditHelp.inc.php';
					$assocHelp['contributionSearch.php']='contributionSearchHelp.inc.php';
					$assocHelp['contributionEdit.php']='contributionEditHelp.inc.php';
					
					// contributors and customers
					$assocHelp['providerSearch.php']='providerSearchHelp.inc.php';
					$assocHelp['providerEdit.php']='providerEditHelp.inc.php';
					$assocHelp['customerSearch.php']='customerSearchHelp.inc.php';
					$assocHelp['customerEdit.php']='customerEditHelp.inc.php';
					
					// reports
					$assocHelp['reports.php']='reportsHelp.inc.php';
					$assocHelp['dataExport.php']='dataExportHelp.inc.php';

					//Now if we have an undefined array value for the key they've passed us
					//what happens? This means that the page they're looking for help on doesn't have a
					//specific help page we defined above. So we pass them to the index page to see if they can find help from there.
					$loc = substr($_GET['helpPage'],strpos($_GET['helpPage'],"/")+1);
					if(!$assocHelp[$loc])
						$assocHelp[$loc]='index.inc.php';

					//this line actually snags the tutorial data they're requesting and displays it.
					include('tutorial/'.$assocHelp[$loc]);
				?>

				
			</div>
		
		</div>
		<?PHP include('footer.inc');?>
	</body>
</html>
