# ev3_cmd
Python script (v2.7.6) for controlling envisalink 3 connected to DSC PC1616

Developing an instructable for the whole system.

ev3.py is a command line script.
   Open a terminal window

   Execute the following command:
   $ python ev3.py

ev3pi.py adds support for SQLite

ev3chk.sh, wih support of crontab entry, checks if ev3pi.py is running, and if not restarts

ev3auto.py allows security.php to send commands to arm and disarm the security system

security.php is part of a larger home automation system, this can be changed to index.php and edited to meet your needs.
