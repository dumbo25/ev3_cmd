# ev3_cmd
Python script (v2.7.6) for controlling envisalink 3 connected to DSC PC1616

Developing an instructable for the whole system.

ev3.py is a command line script.<br>
   * Once the envisalink3 board is installed and working, then <br>
    * Open a terminal window<br>
   * Execute the following command:<br>
    * $ python ev3.py<br>

The following files run on a Raspberry Pi:<br>
   * Put these in /usr/local/bin and make executable<br>
       * ev3pi.py adds support for SQLite<br>
       * ev3chk.sh, wih support of crontab entry, checks if ev3pi.py is running, and if not restarts<br>
       * ev3auto.py allows security.php to send commands to arm and disarm the security system<br>
   * Put this file in /var/www<br>
       * security.php is part of a larger home automation system, this can be changed to index.php and edited to meet your needs.
