<?php 
/*
 * Created on April 1, 2012
 * @author Judy Yang <jyang2@bowdoin.edu>
 */
	
session_start();
session_cache_expire(30);
include_once('database/dbVolunteers.php');
include_once('database/dbSchedules.php');
include_once('domain/ScheduleEntry.php');
include_once('domain/Volunteer.php');
?>
<html>
	<head>
		<title>Master Schedule</title>
		<!--  Choose a style sheet -->
		<link rel="stylesheet" href="styles.css" type="text/css"/>
	</head>
	<body>
		<div id="container">
			<?php include_once("header.php");?>
			<div id="content">
				<?php
				if ($_SESSION['access_level']<2){
					die("<p>Only team captains can edit the master schedule.</p>");
				}
				$week_days = array("Mon"=>"Monday","Tue"=>"Tuesday","Wed"=>"Wednesday",
									"Thu"=>"Thursday","Fri"=>"Friday","Sat"=>"Saturday","Sun"=>"Sunday");
				$weekly_groups = array("odd"=>"odd", "even"=>"even");
				$monthly_groups = array("1"=>"1st","2"=>"2nd", "3"=>"3rd", "4"=>"4th", "5"=>"5th");
				$area = $_GET['area'];
				$areas = array("HHI"=>"Hilton Head", "SUN"=> "Bluffton", "BFT" => "Beaufort");
				echo "<p><strong>Resale Store Volunteer Schedule</strong><br><br>";
				show_master_weeks($areas, $area, $monthly_groups, $week_days);
				?>
			</div>
		</div>
		<?PHP include('footer.inc');?>			
	</body>
</html>

<?php 
	/*
	 * displays the master schedule for a given group (odd/even weeks of the year or weeks of the month)
	 * and series of days (Mon-Fri or Sat-Sun)
	 */
	function show_master_weeks($areas, $area, $groups, $days){
		echo "Store volunteer scheduling will be done in phase II of this software project.";
		echo " At that time, this page will be developed to provide an easy way to view and edit 
		the current week's store volunteer schedule.<p>";
		
		do_month($area, $groups, $days);	
	}
	
	function do_month($area, $groups, $days) {
		$today = strtotime("today")+1209600;
		$thisMonth=date("m",$today);
		$thisYear = date("y",$today);
		$dayses=array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
		echo '<p><strong>'; echo date("F Y",mktime(1,1,1,$thisMonth,1,$thisYear))."</strong>";
	  	echo '<br><br><table>';
	 	echo '<tr>';
		foreach ($days as $day=>$dayname)
		   echo '<td><b>' . $dayname . '</b></td>';  
		echo '</tr>';
		$dayCount = 1;
		$daytime = mktime(0,0,0,$thisMonth,1,$thisYear);
		$weekCount = 1;
		while($dayCount<=date("t",$today)){  // number of days in this month = date("t",$today)
		  	echo('<tr>');
		  	for ($i=1;$i<=7;++$i){
	  	 	  echo('<td valign="top">');
	  		  if($dayCount>date("t",$today))
	  		    continue;
	  		  else if($weekCount==1 && get_first_day($thisMonth, $thisYear)>$i)
	  		    continue;
	  	  	  else{
	  	    	echo('<strong>'.$dayCount.'</strong>');
		    	$shiftID=$thisYear.'-'.$thisMonth.'-'.date("d",mktime(0,0,0,$thisMonth,$dayCount,$thisYear));
		    	if ($area=="BFT")
		    		//$week = $groups[floor(($dayCount-1) / 7)];
		    		$week = substr($groups[floor(($dayCount-1) / 7) + 1],0,1);
		    	else if (date("W",$daytime) % 2 == 0) 
		    		$week="even";
		    	else $week="odd";
		    	// echo $week.$dayses[$i-1];
		    	$driver_ids = array();
				echo '<br>';
		    	foreach($driver_ids as $driver_id){
		    		$driver = retrieve_dbVolunteers($driver_id);
		      		if ($driver)
		    			echo $driver->get_first_name()." ".$driver->get_last_name()."<br>" ;
		    		else echo $driver_id;
		    	}
		    	echo'</td>';
		    	++$dayCount;
		    	$daytime += 86400;
	  	  	  }
		   	}
	   		echo('</tr>'); 
	   		$weekCount+=1; 
		}
	 	echo '</table>';
	}
	
	function get_first_day($mm, $yy) {
		return date("N",mktime(0,0,0,$mm,1,$yy));
	}
	
	function do_shift($master_shift) {
		/* $master_shift is a ScheduleEntry object
		*/		
		$s= "<td valign='top'>".
			//	"<a id=\"shiftlink\" href=\"scheduleEdit.php?area=".
			//	$master_shift->get_area()."&day=".$master_shift->get_day()."&group=".
			//	$master_shift->get_group()."\">".
				get_people_for_shift($master_shift).
			"</td>";
		return $s;
	}
	
	function get_people_for_shift($master_shift) {
		/* $master_shift is a ScheduleEntry object 
		*/
		$people=$master_shift->get_drivers(); // id's of drivers scheduled
		$p="";
		for($i=0;$i<count($people);++$i) {
			$person = retrieve_dbVolunteers($people[$i]);
			if ($person)
			   $p = $p."&nbsp;".$person->get_first_name()." ".$person->get_last_name()."<br>";
			else
			   $p = $p."&nbsp;".$people[$i]."<br>";
		}
		if(count($people)==0 )
			$p=$p."&nbsp;<strong>open</strong><br>";
		else 
		    $p=$p."&nbsp;<br>";
		return substr($p,0,strlen($p)-4) ;
	}
	
?>