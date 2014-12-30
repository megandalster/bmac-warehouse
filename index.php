<?PHP
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homerestore, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */
	session_start();
	session_cache_expire(30);
	
	// setting the default time zone
	date_default_timezone_set('America/New_York');
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
					include_once('database/dbVolunteers.php');
     				include_once('domain/Volunteer.php');
						
     				// include_once('database/dbLog.php');
     				if($_SESSION['_id']!="guest"){
     				    $person = retrieve_dbVolunteers($_SESSION['_id']);
     					$first_name = $person->get_first_name();
     					echo "<p>Welcome, ".$first_name.", to <i>Homerestore</i>! ";
     				}
     				else
     				    echo "<p>Welcome to <i>Homerestore</i>! ";
     				$today = time();
					echo "Today is ".date('l F j, Y', $today).".<p>";
					
				if ($person){
					/*
					 * Check type of person, and display home page based on that.
					 * level 0: General public, view and edit on-line application
					 * level 1: Volunteers, helpers, and subs: view today's route, upcoming driver schedule
					 * level 2: Day Captains: view this week's route data
					 * level 3: Coordinators: view weekly and monthly reports, export data
					*/
                    //DEFAULT PASSWORD CHECK
					if (md5($person->get_id())==$person->get_password()){
						 if(!isset($_POST['_rp_submitted']))
						 	echo('<div class="warning"><form method="post"><p><strong>We recommend that you change your password, which is currently default.</strong><table class="warningTable"><tr><td class="warningTable">Old Password:</td><td class="warningTable"><input type="password" name="_rp_old"></td></tr><tr><td class="warningTable">New password</td><td class="warningTable"><input type="password" name="_rp_newa"></td></tr><tr><td class="warningTable">New password<br />(confirm)</td><td class="warningTable"><input type="password" name="_rp_newb"></td></tr><tr><td colspan="2" align="right" class="warningTable"><input type="hidden" name="_rp_submitted" value="1"><input type="submit" value="Change Password"></td></tr></table></p></form></div>');
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
						 		update_dbVolunteers($person);
						 	}
						 }
					}
					echo "<p>Please select an item from the menu above to begin a scheduling activity.";
				}
				?>
				
			</div>
			<?PHP include('footer.inc');?>
		</div>
	</body>
</html>