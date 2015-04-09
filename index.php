<?PHP
/*
 * Copyright 2014 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker. This program is part of BMAC-Warehouse, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/
	session_start();
	session_cache_expire(30);
	
	// setting the default time zone
	date_default_timezone_set('America/Los_Angeles');
?>
<html>
	<head>
		<title>
			Homerestore
		</title>
		<link rel="stylesheet" href="styles.css" type="text/css" />
	</head>
	<body>
		<div id="container">
			<?PHP include('header.php');?>
			<div id="content">
				<?PHP
					include_once('database/dbPersons.php');
     				include_once('domain/Person.php');
					include_once('database/dbShipments.php');
     				include_once('domain/Shipment.php');
					include_once('database/dbContributions.php');
     				include_once('domain/Contribution.php');
						
     				// include_once('database/dbLog.php');
     				if($_SESSION['_id']!="guest"){
     				    $person = retrieve_dbPersons($_SESSION['_id']);
     					$first_name = $person->get_first_name();
     					echo "<p>Welcome, ".$first_name.", to <i>BMAC-Warehouse</i>! ";
     				}
     				else
     				    echo "<p>Welcome to <i>Homerestore</i>! ";
     				$today = time();
					echo "Today is ".date('l F j, Y', $today).".<p>";
					
				if ($person){
					/*
					 * Check type of person, and display home page based on that.
					 * level 1: Office staff
					 * level 2: Warehouse staff
					 * level 3: Foodbank Director
					*/
                    $ago = strtotime("-30 days",$today);
                    // echo "30 days ago = ".date('l F j, Y', $ago).".<p>";
					echo "<p>Last 30 days' shipments.";
					$shipments = getonlythose_dbShipments("",$ago,"","");
					echo('<div class="infobox">');
					echo "<table><b><tr><td>Ship Date</td><td>Customer</td><td>Total Weight</td></tr></b>";
					foreach ($shipments as $shipment) {
						echo '<tr><td><a href=shipmentEdit.php?id='.$shipment->get_ship_date().'>' . 
							pretty_date(substr($shipment->get_ship_date(),0,8)) .'</a></td>'. 
							'</td><td>'.$shipment->get_customer_id()  . 
							'</td><td align=right>'.$shipment->get_total_weight().'</tr>'; 	
					}
					echo "</table></div>";	 
				    echo "<p>Last 30 days' receipts.";
					$contributions = getonlythose_dbContributions("",$ago,"","");
					echo('<div class="infobox">');
					echo "<table><b><tr><td>Receive Date</td><td>Contributor</td><td>Total Weight</td></tr></b>";
					foreach ($contributions as $contribution) {
						echo '<tr><td><a href=contributionEdit.php?id='.$contribution->get_receive_date().'>' . 
							pretty_date(substr($contribution->get_receive_date(),0,8)) .'</a></td>'. 
							'</td><td>'.$contribution->get_provider_id()  . 
							'</td><td align=right>'.$contribution->get_total_weight().'</tr>'; 	
					}
					echo "</table></div>";	 	 
						 
				    //DEFAULT PASSWORD CHECK
					if (md5($person->get_id())==$person->get_password()){
						 if(!isset($_POST['_rp_submitted']))
						 	echo('<p><div class="warning"><form method="post"><p><strong>We recommend that you change your password, which is currently default.</strong><table class="warningTable"><tr><td class="warningTable">Old Password:</td><td class="warningTable"><input type="password" name="_rp_old"></td></tr><tr><td class="warningTable">New password</td><td class="warningTable"><input type="password" name="_rp_newa"></td></tr><tr><td class="warningTable">New password<br />(confirm)</td><td class="warningTable"><input type="password" name="_rp_newb"></td></tr><tr><td colspan="2" align="right" class="warningTable"><input type="hidden" name="_rp_submitted" value="1"><input type="submit" value="Change Password"></td></tr></table></p></form></div>');
						 else{
						 	//they've submitted
						 	if(($_POST['_rp_newa']!=$_POST['_rp_newb']) || (!$_POST['_rp_newa']))
						 		echo('<div class="warning"><form method="post">'.
						 		'<p>Error with new password. Ensure passwords match.</p><br />'.
						 		'<table class="warningTable">'.
						 		'<tr><td class="warningTable">Old Password:</td>'.
						 		'<td class="warningTable"><input type="password" name="_rp_old"></td></tr>'.
						 		'<tr><td class="warningTable">New password</td><td class="warningTable"><input type="password" name="_rp_newa"></td></tr>'.
						 		'<tr><td class="warningTable">New password<br />(confirm)</td><td class="warningTable"><input type="password" name="_rp_newb"></td></tr>'.
						 		'<tr><td colspan="2" align="center" class="warningTable"><input type="hidden" name="_rp_submitted" value="1"><input type="submit" value="Change Password"></form></td></tr>'.
						 		'</table></div>');
						 	else if(md5($_POST['_rp_old'])!=$person->get_password())
						 		echo('<div class="warning"><form method="post"><p>Error with old password.</p><br /><table class="warningTable">'.
						 		'<tr><td class="warningTable">Old Password:</td><td class="warningTable"><input type="password" name="_rp_old"></td></tr>'.
						 		'<tr><td class="warningTable">New password</td><td class="warningTable"><input type="password" name="_rp_newa"></td></tr>'.
						 		'<tr><td class="warningTable">New password<br />(confirm)</td><td class="warningTable"><input type="password" name="_rp_newb"></td></tr>'.
						 		'<tr><td colspan="2" align="center" class="warningTable"><input type="hidden" name="_rp_submitted" value="1"><input type="submit" value="Change Password"></form></td></tr>'.
						 		'</table></div>');
						 	else if((md5($_POST['_rp_old'])==$person->get_password()) && ($_POST['_rp_newa']==$_POST['_rp_newb'])){
						 		$newPass = md5($_POST['_rp_newa']);
						 		$person->set_password($newPass); 
						 		update_dbPersons($person);
						 	}
						 }
					}
					
				}
				function pretty_date($yy_mm_dd) {
					return date('M j, Y', mktime(0,0,0,substr($yy_mm_dd,3,2),substr($yy_mm_dd,6,2),substr($yy_mm_dd,0,2)));
				}
				?>
				
			</div>
			<?PHP include('footer.inc');?>
		</div>
	</body>
</html>