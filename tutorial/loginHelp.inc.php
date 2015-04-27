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
?>
<html>
<head>
<title>BMAC-Warehouse login help</title>
</head>
<body>
	<div align="left">
		<p>
			<strong> Signing in and out of the System</strong>
		
		
		<p>Access to all BMAC-Warehouse functionality and data requires a Username and a Password. The form
			looks like this:
		
		
		<p>
		
		
		<table align="center">
			<tr>
				<td>Username:</td>
				<td><input type="text" name="user" tabindex="1"></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type="password" name="pass" tabindex="2"></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="Login"
					value="Login"></td>
			</tr>
		</table>
		<p>
			If you are a <i>BMAC staff member</i>, your Username is your
			first name followed by your primary phone number with no spaces.  Your
			initial password is the same (you will be able to change your password after you log in).
		
		
		<ul>
			<li>For example, if your first name is John and your phone number is
				(509)-123-4567, your Username and Password would both be <strong>John5091234567</strong>.
			
			<li>Remember that your Username and Password are <em>case-sensitive</em>.
			
			<li>If you mistype your Username or Password, the following error
				message will appear:
				<p class="error">
					Error: invalid username/password<br />if you cannot remember your
					password, ask the Foodbank Director to reset it for you.
				</p>
				<p>At this point, you can retry entering your Username and Password
					(if you think you may have mistyped them).
			
			<li>If all else fails, or if you do not remember your password,
				please contact the <a href="mailto:jmathias@bmacww.org">Foodbank Director</a>.
		
		</ul>
		<p>
			Remember to <strong>logout</strong> when you are finished using the system.

</body>
</html>

