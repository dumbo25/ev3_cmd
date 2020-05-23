#! /usr/bin/env python
#
# Disarm ev3
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
	Log.printMsg("in script disarm")
	try:
		e = Ev3auto()

		e.db_cmd.execute('UPDATE status SET value = "disarm" WHERE name = "command";')
		Log.printMsg("Security System mode: disarm")

	finally:
		e.db_con.commit();
		e.db_con.close()
