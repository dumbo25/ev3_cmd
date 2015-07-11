#! /usr/bin/env python
#
# This script depends on ev3pi.py to be running, and if it is then it will automatically 
# arm and disarm the security system based on a daily schedule.
#
# The basic assumption behind this script is you want the security system on at night when 
# you are asleep and it shut offs when you are awake
#
# If on vacation, then don't make any changes. 
# When on vacation, system should be in leave mode, but this script won't make any changes.
#
# The day of week is: Sunday, Monday, ... Friday, Saturday (0-6)
# To simplify the logic, arm time must be after earliest arm time (22:00:00)
#
# run this script as a crontab every 15 minutes - arm/disarm doesn't need to be super accurate
#	sudo crontab -e

import socket
import sys
import time
import datetime
import string
import re
import select
import sqlite3
import smtplib

class Ev3auto:
	def __init__(self):
		self.db_file = '/var/www/db/security.db'
		self.db_con = sqlite3.connect(self.db_file)
		self.db_cmd = self.db_con.cursor()
		self.weekday = {0 : 'Monday', 1 : 'Tuesday', 2 : 'Wednesday', 3 : 'Thursday', 4 : 'Friday', 5 : 'Saturday', 6 : 'Sunday'}
		#
		# change the items in angle brackets below
		#
		self.gmail_password = <your gmail password>		# your gmail password
		self.gmail_address = <your gmail address>		# your gmail email address
		#
		# CHANGE THE ITEMS ABOVE
		#

	def sendAlert(self):
		subject = "Security system not armed"
		message = 'Subject: %s' % (subject)
		mail = smtplib.SMTP("smtp.gmail.com",587)
		mail.ehlo()
		mail.starttls()
		mail.login(self.gmail_address, self.gmail_password)
		mail.sendmail("cell","5122013169@txt.att.net",message)
		mail.close()

if __name__ == '__main__':
		try:
			e = Ev3auto()

			# e.dbInit() is performed by ev3pi.py

			# read vacation from database, but don't make any changes if vacation == yes
			v = e.db_cmd.execute('SELECT * FROM status WHERE name = "vacation";')
			for row in v:
				vacation = row[3]

			# read system from database
			v = e.db_cmd.execute('SELECT * FROM status WHERE name = "system";')
			for row in v:
				system = row[3]

			# vacation must be yes or no - don't use else
			if vacation == 'yes':
				if system == 'sleep' or system == 'disarm':
					# send alert that home security is not set
					e.sendAlert()

			if vacation == 'no':
				d = datetime.datetime.today().weekday()
				day = e.weekday[d]

				# read schedule from database
				t = e.db_cmd.execute('SELECT * from schedule where day = "' + day + '";')
				for row in t:
					armTime = row[3]
					disarmTime = row[4]
				
				current_time = time.strftime("%H:%M:%S")
				ct = time.strptime(current_time, "%H:%M:%S")
				at = time.strptime(armTime, "%H:%M:%S")
				dt = time.strptime(disarmTime, "%H:%M:%S")
				eat = time.strptime("22:00:00", "%H:%M:%S")
				mt = time.strptime("23:59:59", "%H:%M:%S")
				zt = time.strptime("00:00:00", "%H:%M:%S")
				# Should it arm between arm time and midnight?
				if at >= eat and at <= mt and ct >= eat and ct <= mt:
					if system == 'disarm':
						e.db_cmd.execute('UPDATE status SET value = "sleep" WHERE name = "command";')

				# Should it arm between midnight and disarm time?
				if at >= zt and at <= dt and ct >= zt and ct <= dt:
					if system == 'disarm':
						e.db_cmd.execute('UPDATE status SET value = "sleep" WHERE name = "command";')

				# Should it disarm between disarm and arm time
				if at == zt:
					if ct >= dt and ct < mt:
						if system == 'arm':
							e.db_cmd.execute('UPDATE status SET value = "disarm" WHERE name = "command";')
				else:
					if ct >= dt and ct < mt:
						if system == 'arm':
							e.db_cmd.execute('UPDATE status SET value = "disarm" WHERE name = "command";')

		finally:
			e.db_con.commit();
			e.db_con.close()
