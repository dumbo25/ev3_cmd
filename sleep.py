#! /usr/bin/env python
#
# Put the ev3 in sleep mode
import mylog
global Log
Log = mylog.mylog('/home/pi', 'rpi-echo.log')
mylog.setLogObject(Log)

import sqlite3

class Ev3auto:
	def __init__(self):
		self.db_file = '/var/www/db/security.db'
		self.db_con = sqlite3.connect(self.db_file)
		self.db_cmd = self.db_con.cursor()

if __name__ == '__main__':
	Log.printMsg("in script sleep")
	try:
		e = Ev3auto()

		e.db_cmd.execute('UPDATE status SET value = "sleep" WHERE name = "command";')
                Log.printMsg("Security System mode: sleep")

	finally:
		e.db_con.commit();
		e.db_con.close()
