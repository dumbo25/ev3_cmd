<?php 
	$db = new SQLite3('/var/www/db/security.db');
	if(isset($_GET['cmd'])) {
		$cmd = $_GET['cmd'];
		$results = $db->query('UPDATE status SET value = "' . $cmd . '" WHERE name = "command";');
	// The security system script should pull the command and change it back to none
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Security System</title>
		<meta name="apple-mobile-web-app-capable" content="yes">	
	</head>
    <body>
		<table style="width:100%">
			<tr>
				<th colspan="4"><a id="HomeAutomation" href="/index.php"><font size="5">Home Automation</font></a></th>
			</tr>
		</table>
		<br>
		<table border="1" style="width:100%">
			<tr>
				<th colspan="4"><a id="security" href="/security.php"><font size="4">Security System</font></a></th>
			</tr>
			<tr>
				<td style="width:25%"><a id="script"><font size="3">Script Status</font></td>
<?php
//	$db = new SQLite3('/var/www/db/security.db');
	$results = $db->query('select * from status where name = "script";');
	$res = $results->fetchArray(SQLITE3_ASSOC);
	$statusScript = $res['value'];
        echo "				<td style=\"width:25%\"><font size=\"3\">", $statusScript, "</font></td>";				
	$results = $db->query('select * from status where name = "system";');
	$res = $results->fetchArray(SQLITE3_ASSOC);
	$statusSystem = $res['value'];
        echo "				<td style=\"width:25%\"><font size=\"3\">System</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $statusSystem, "</font></td>";
?>
			</tr>
			<tr>
				<td style="width:25%"><a id="alarm"><font size="3">Alarm</font></a></td>
<?php
//	$db = new SQLite3('/var/www/db/security.db');
	$results = $db->query('select * from status where name = "alarm";');
	$res = $results->fetchArray(SQLITE3_ASSOC);
	$statusAlarm = $res['value'];
        echo "				<td style=\"width:25%\"><font size=\"3\">", $statusAlarm, "</font></td>";				
	$results = $db->query('select * from status where name = "zone";');
	$res = $results->fetchArray(SQLITE3_ASSOC);
	$statusZone = $res['value'];
        echo "				<td style=\"width:25%\"><font size=\"3\">Zone</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $statusZone, "</font></td>";
?>
			</tr>
			<tr>
				<td style="width:25%"><a id="garage"><font size="3">Garage Door</font></a></td>
<?php
	// the following lines add sensor status from my Garage Door Opener instructable
	// if you don't have the sensor, uncomment the next two lines and comment/delete the sensor code:
	//	echo "				<td style=\"width:25%\"><font size=\"3\"></font></td>";
    //	echo "				<td style=\"width:25%\"><font size=\"3\"></font></td>";
	// garage door sensor code below
	$garageState = exec('gpio read 3');
	if ($garageState == 1) {
		echo "				<td style=\"width:25%\"><font size=\"3\">open</font></td>";
	} else {
		echo "				<td style=\"width:25%\"><font size=\"3\">closed</font></td>";		
	}
	// garage door sensor code above
		
	$results = $db->query('select * from status where name = "vacation";');
	$res = $results->fetchArray(SQLITE3_ASSOC);
	$statusVacation = $res['value'];
        echo "				<td style=\"width:25%\"><font size=\"3\">Vacation</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $statusVacation, "</font></td>";
?>
			</tr>
			<tr>
				<td colspan="4" height="20"> </td>
			</tr>
			<tr>
				<th colspan="4"><font size="4">Commands</font></th>
			</tr>
			<tr>
				<td style="width:25%"><a id="sleep" href="/security.php?cmd=sleep"><font size="3">Sleep & Arm</font></a></td>
				<td style="width:25%"><a id="leave" href="/security.php?cmd=leave"><font size="3">Leave & Arm</font></a></td>
				<td style="width:25%"><a id="disarm" href="/security.php?cmd=disarm"><font size="3">Disarm</font></a></td>
				<td style="width:25%"><a id="panic" href="/security.php?cmd=panic"><font size="3">Panic Alarm</font></a></td>
			</tr>
			<tr>
<?php
	$results = $db->query('select * from status where name = "command";');
	$res = $results->fetchArray(SQLITE3_ASSOC);
	$statusCommand = $res['value'];
        echo "				<td style=\"width:25%\"><font size=\"3\">Pending Command</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $statusCommand, "</font></td>";
?>
				<td style="width:25%"><a id="unused21"><font size="3"></font></a></td>
				<td style="width:25%"><a id="unused22"><font size="3"></font></a></td>
			</tr>
			<tr>
				<td colspan="4" height="20"> </td>
			</tr>
			<tr>
				<th colspan="4"><font size="4">Schedule</font></th>
			</tr>
			<tr>
				<td style="width:25%"><a id="armDayLabel"><font size="3">Day</font></a></td>
				<td style="width:25%"><a id="armTimeLabel"><font size="3">Arm Time</font></a></td>
				<td style="width:25%"><a id="disarmTimeLabel"><font size="3">Disarm Time</font></a></td>
				<td style="width:25%"><a id="unused31"><font size="3"></font></a></td>
			</tr>
<?php
	$results = $db->query('select * from schedule where day = "Sunday";');
	$res = $results->fetchArray(SQLITE3_ASSOC);
	$day = $res['day'];
	$arm = $res['arm'];
	$disarm = $res['disarm'];
        echo "				<tr>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $day, "</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $arm, "</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $disarm, "</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\"></font></td>";
        echo "				</tr>";
	$results = $db->query('select * from schedule where day = "Monday";');
	$res = $results->fetchArray(SQLITE3_ASSOC);
	$day = $res['day'];
	$arm = $res['arm'];
	$disarm = $res['disarm'];
        echo "				<tr>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $day, "</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $arm, "</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $disarm, "</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\"></font></td>";
        echo "				</tr>";
	$results = $db->query('select * from schedule where day = "Tuesday";');
	$res = $results->fetchArray(SQLITE3_ASSOC);
	$day = $res['day'];
	$arm = $res['arm'];
	$disarm = $res['disarm'];
        echo "				<tr>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $day, "</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $arm, "</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $disarm, "</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\"></font></td>";
        echo "				</tr>";
	$results = $db->query('select * from schedule where day = "Wednesday";');
	$res = $results->fetchArray(SQLITE3_ASSOC);
	$day = $res['day'];
	$arm = $res['arm'];
	$disarm = $res['disarm'];
        echo "				<tr>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $day, "</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $arm, "</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $disarm, "</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\"></font></td>";
        echo "				</tr>";
	$results = $db->query('select * from schedule where day = "Thursday";');
	$res = $results->fetchArray(SQLITE3_ASSOC);
	$day = $res['day'];
	$arm = $res['arm'];
	$disarm = $res['disarm'];
        echo "				<tr>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $day, "</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $arm, "</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $disarm, "</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\"></font></td>";
        echo "				</tr>";
	$results = $db->query('select * from schedule where day = "Friday";');
	$res = $results->fetchArray(SQLITE3_ASSOC);
	$day = $res['day'];
	$arm = $res['arm'];
	$disarm = $res['disarm'];
        echo "				<tr>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $day, "</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $arm, "</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $disarm, "</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\"></font></td>";
        echo "				</tr>";
	$results = $db->query('select * from schedule where day = "Saturday";');
	$res = $results->fetchArray(SQLITE3_ASSOC);
	$day = $res['day'];
	$arm = $res['arm'];
	$disarm = $res['disarm'];
        echo "				<tr>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $day, "</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $arm, "</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\">", $disarm, "</font></td>";
        echo "				<td style=\"width:25%\"><font size=\"3\"></font></td>";
        echo "				</tr>";
?>
		</table>
	</body>
</html>
