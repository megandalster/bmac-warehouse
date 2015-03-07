<?php
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homerestore, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/**
 * Created on Mar 28, 2008
 * @author Oliver Radwan <oradwan@bowdoin.edu>
 */
?>
</div>
</div>
<html>
  <body>
  <div id="content">
			<?PHP
				include_once(dirname(__FILE__).'/database/dbPersons.php');
     			include_once(dirname(__FILE__).'/domain/Person.php');
     			if(($_SERVER['PHP_SELF'])=="/logout.php"){
     				//prevents infinite loop of logging in to the page which logs you out...
     				echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
     			}
				if(!array_key_exists('_submit_check', $_POST)){
					echo('<div align="left"><p>Access to <i>BMAC Warehouse</i> requires a Username and a Password. '  );
					echo('<ul><li>You must be a BMAC staff member to access this system. ' .
						'<li> Your Username is your first name followed by your phone number (no spaces). ');
					echo('<br> If you do not remember your Password, please contact the <a href="mailto:jeffm@bmacww.org"></a>Foodbank Director.</ul>');
					echo('<p><table><form method="post"><input type="hidden" name="_submit_check" value="true"><tr><td>Username:</td><td><input type="text" 
					name="user" tabindex="1"></td></tr><tr><td>Password:</td><td><input type="password" name="pass" tabindex="2"></td></tr><tr><td colspan="2" 
					align="center"><input type="submit" name="Login" value="Login"></td></tr></table>');
				}
				else{
			//check if they logged in as a guest:
					if($_POST['user']=="guest" && $_POST['pass']==""){
					$_SESSION['logged_in']=1;
					$_SESSION['access_level']=0;
					$_SESSION['_area']="all";
					$_SESSION['_id']="guest";
					echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
				}
					//otherwise authenticate their password
				else {
					$db_pass = md5($_POST['pass']);
					$db_id = $_POST['user'];
					$person = retrieve_dbPersons($db_id);	
					//	echo $person->get_id() . " = retrieved person_id<br>";
					if($person){ //avoids null results
						if($person->get_password()==$db_pass) { //if the passwords match, login
							$_SESSION['logged_in']=1;
							if ($person->get_type()=="manager")		// Foodbank Director
									$_SESSION['access_level'] = 3;
							else if ($person->get_type()=="staff")	// warehouse staff
									$_SESSION['access_level'] = 2;			
							else $_SESSION['access_level'] = 1;	    // office staff
							$_SESSION['f_name']=$person->get_first_name();
							$_SESSION['l_name']=$person->get_last_name();
							$_SESSION['_id']=$_POST['user'];
							echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
						}
						else {
							echo('<div align="left"><p class="error">Error: invalid username/password.');
							echo('<p>If you are a BMAC staff member, your Username is your first name followed by your phone number with no spaces. ' .
								'For instance, if your first name were John and your phone number were (843)-123-4567, ' .
								'then your Username would be <strong>John8431234567</strong>.  ');
							echo('<br /><br />if you cannot remember your password, ask the <a href="mailto:jeffm@bmacww.org">Foodbank Director</a> to reset it for you.</p>');
							echo('<p><table><form method="post"><input type="hidden" name="_submit_check" value="true">'.
								'<tr><td>Username:</td><td><input type="text" name="user" tabindex="1"></td></tr><tr><td>Password:</td>'.
								'<td><input type="password" name="pass" tabindex="2"></td></tr><tr><td colspan="2" align="center"><input type="submit" name="Login" 
								value="Login"></td></tr></table></div>');
						}
					}
					else{
					//At this point, they failed to authenticate
						echo('<div align="left"><p class="error">Error: invalid username/password.');
						echo('<p>If you are a BMAC staff member, your Username is your first name followed by your phone number with no spaces. ' .
							'For instance, if your first name were John and your phone number were (207)-123-4567, ' .
							'then your Username would be <strong>John2071234567</strong>.  ');
						echo('<br /><br />if you cannot remember your password, ask your <a href="mailto:jeffm@bmacww.org">Foodbank Director</a> to reset it for you.</p>');
						echo('<p><table><form method="post"><input type="hidden" name="_submit_check" value="true"><tr><td>Username:</td>'.
							'<td><input type="text" name="user" tabindex="1"></td></tr>'.
							'<tr><td>Password:</td><td><input type="password" name="pass" tabindex="2"></td></tr><tr><td colspan="2" align="center"><input type="submit" name="Login" 
							value="Login"></td></tr></table></div>');
					}
				}
				}
			?>
		</div>
		<?PHP include('footer.inc');?>
	</body>
</html>
