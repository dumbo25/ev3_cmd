<?php
//      // The security system script should pull the command and change it back to none
        $db = new SQLite3('/var/www/db/security.db');
        if(!$db){
                echo $db->lastErrorMsg();
        } else {
                if(isset($_GET['cmd'])) {
                        $cmd = $_GET['cmd'];
                        $results = $db->query('UPDATE status SET value = "' . $cmd . '" WHERE name = "command";');
                }
        }
        $results = $db->query('select * from status where name = "script";');
        $res = $results->fetchArray(SQLITE3_ASSOC);
        $statusScript = $res['value'];

        $results = $db->query('select * from status where name = "system";');
        $res = $results->fetchArray(SQLITE3_ASSOC);
        $statusSystem = $res['value'];

        $results = $db->query('select * from status where name = "alarm";');
        $res = $results->fetchArray(SQLITE3_ASSOC);
        $statusAlarm = $res['value'];

        $results = $db->query('select * from status where name = "zone";');
        $res = $results->fetchArray(SQLITE3_ASSOC);
        $statusZone = $res['value'];

        $results = $db->query('select * from status where name = "vacation";');
        $res = $results->fetchArray(SQLITE3_ASSOC);
        $statusVacation = $res['value'];

        $results = $db->query('select * from status where name = "schedule";');
        $res = $results->fetchArray(SQLITE3_ASSOC);
        $statusSchedule = $res['value'];

        $res = shell_exec('uptime');
        $strt = strpos($res,'up') + 2;
        $len = strpos($res, ',') - $strt;
        $t = substr($res, $strt, $len);

        $results = $db->query('select * from status where name = "command";');
        $res = $results->fetchArray(SQLITE3_ASSOC);
        $statusCommand = $res['value'];

        $results = $db->query('select * from schedule where day = "Sunday";');
        $res = $results->fetchArray(SQLITE3_ASSOC);
	$sunday = array($res['day'],$res['arm'],$res['disarm']);

        $results = $db->query('select * from schedule where day = "Monday";');
        $res = $results->fetchArray(SQLITE3_ASSOC);
        $monday = array($res['day'],$res['arm'],$res['disarm']);

        $results = $db->query('select * from schedule where day = "Tuesday";');
        $res = $results->fetchArray(SQLITE3_ASSOC);
        $tuesday = array($res['day'],$res['arm'],$res['disarm']);

        $results = $db->query('select * from schedule where day = "Wednesday";');
        $res = $results->fetchArray(SQLITE3_ASSOC);
        $wednesday = array($res['day'],$res['arm'],$res['disarm']);

        $results = $db->query('select * from schedule where day = "Thursday";');
        $res = $results->fetchArray(SQLITE3_ASSOC);
        $thursday = array($res['day'],$res['arm'],$res['disarm']);

        $results = $db->query('select * from schedule where day = "Friday";');
        $res = $results->fetchArray(SQLITE3_ASSOC);
        $friday = array($res['day'],$res['arm'],$res['disarm']);

        $results = $db->query('select * from schedule where day = "Saturday";');
        $res = $results->fetchArray(SQLITE3_ASSOC);
        $saturday = array($res['day'],$res['arm'],$res['disarm']);

	$db->close();
?>
<!DOCTYPE html>
<html>
        <head>
                <title>Security System</title>
                <meta name="apple-mobile-web-app-capable" content="yes">
        </head>
        <body>
                <table border="1" style="width:100%">
                        <tr>
                                <th colspan="4"><a id="security" href="/index.php"><font size="4" face="arial">Security System</font></a></th>
                        </tr>
                        <tr>
                                <th colspan="4"><a id="note"><font size="2" face="arial">Click on Security System above, rather than using refresh button</font></th>
                        </tr>
                        <tr>
                                <td style="width:25%"><a id="script"><font size="3" face="arial"><b>Script Status</b></font></td>
<?php
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\" color=\"green\">", $statusScript, "</font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\"><b>System Mode</b></font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\" color=\"green\">", $statusSystem, "</font></td>";
?>
                        </tr>
                        <tr>
                                <td style="width:25%"><a id="alarm"><font size="3" face="arial"><b>Alarm</b></font></a></td>
<?php
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\" color=\"green\">", $statusAlarm, "</font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\"><b>Zone</b></font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\" color=\"green\">", $statusZone, "</font></td>";
?>
                        </tr>
                        <tr>
                                <td style="width:25%"><a id="alarm"><font size="3" face="arial"><b>Vacation</b></font></a></td>
<?php
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\" color=\"green\">", $statusVacation, "</font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\"><b>Schedule</b></font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\" color=\"green\">", $statusSchedule, "</font></td>";
?>
                        </tr>
                        <tr>
                                <td style="width:25%"><a id="alarm"><font size="3" face="arial"><b>Uptime</b></font></a></td>
<?php
        echo "                          <td style=\"width:25%\"><a id=\"uptime2\"><font size=\"3\" face=\"arial\" color=\"green\">", $t, "</font></a></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\"><b>Pending Command</b></font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\" color=\"green\">", $statusCommand, "</font></td>";
?>
                        </tr>
                        <tr>
                                <td colspan="4" height="20"> </td>
                        </tr>
                        <tr>
                                <th colspan="4"><font size="4" face="arial">Commands</font></th>
                        </tr>
                        <tr>
                                <td style="width:25%"><a id="sleep" href="/index.php?cmd=sleep"><font size="3" face="arial">Sleep & Arm</font></a></td>
                                <td style="width:25%"><a id="leave" href="/index.php?cmd=leave"><font size="3" face="arial">Leave & Arm</font></a></td>
                                <td style="width:25%"><a id="disarm" href="/index.php?cmd=disarm"><font size="3" face="arial">Disarm</font></a></td>
                                <td style="width:25%"><a id="panic" href="/index.php?cmd=panic"><font size="3" face="arial">Panic Alarm</font></a></td>
                        </tr>
                        <tr>
                                <td style="width:25%"><a id="vacation" href="/index.php?cmd=vacation"><font size="3" face="arial">Vacation</font></a></td>
                                <td style="width:25%"><a id="vacation" href="/index.php?cmd=schedule"><font size="3" face="arial">Schedule</font></a></td>
                                <td style="width:25%"><a id="unuseda2"><font size="3" face="arial"></font></a></td>
                                <td style="width:25%"><a id="unuseda4"><font size="3" face="arial"></font></a></td>
                        </tr>
                        <tr>
                                <td colspan="4" height="20"> </td>
                        </tr>
                        <tr>
                                <th colspan="4"><font size="4" face="arial">Schedule</font></th>
                        </tr>
                        <tr>
                                <th colspan="4"><a id="note"><font size="2" face="arial">Schedule times are entered through SQLite3</font></th>
                        </tr>
                        <tr>
                                <td style="width:25%"><a id="armDayLabel"><font size="3" face="arial"><b>Day<b></font></a></td>
                                <td style="width:25%"><a id="armTimeLabel"><font size="3" face="arial"><b>Arm Time</b></font></a></td>
                                <td style="width:25%"><a id="disarmTimeLabel"><font size="3" face="arial"><b>Disarm Time</b></font></a></td>
                                <td style="width:25%"><a id="unused31"><font size="3" face="arial"></font></a></td>
                        </tr>
<?php
        echo "                          <tr>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\"><b>", $sunday[0], "</b></font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\" color=\"green\">", $sunday[1], "</font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\" color=\"green\">", $sunday[2], "</font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\"></font></td>";
        echo "                          </tr>";
        echo "                          <tr>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\"><b>", $monday[0], "</b></font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\" color=\"green\">", $monday[1], "</font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\" color=\"green\">", $monday[2], "</font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\"></font></td>";
        echo "                          </tr>";
        echo "                          <tr>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\"><b>", $tuesday[0], "</b></font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\" color=\"green\">", $tuesday[1], "</font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\" color=\"green\">", $tuesday[2], "</font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\"></font></td>";
        echo "                          </tr>";
        echo "                          <tr>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\"><b>", $wednesday[0], "</b></font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\" color=\"green\">", $wednesday[1], "</font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\" color=\"green\">", $wednesday[2], "</font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\"></font></td>";
        echo "                          </tr>";
        echo "                          <tr>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\"><b>", $thursday[0], "</b></font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\" color=\"green\">", $thursday[1], "</font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\" color=\"green\">", $thursday[2], "</font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\"></font></td>";
        echo "                          </tr>";
        echo "                          <tr>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\"><b>", $friday[0], "</b></font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\" color=\"green\">", $friday[1], "</font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\" color=\"green\">", $friday[2], "</font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\"></font></td>";
        echo "                          </tr>";
        echo "                          <tr>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\"><b>", $saturday[0], "</b></font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\" color=\"green\">", $saturday[1], "</font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\" color=\"green\">", $saturday[2], "</font></td>";
        echo "                          <td style=\"width:25%\"><font size=\"3\" face=\"arial\"></font></td>";
        echo "                          </tr>";
?>
                </table>
        </body>
</html>


