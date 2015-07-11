#!/bin/bash
# ps | grep will count: grep of ev3pi.py and the script ev3pi.py
ps -ef | grep -v grep | grep ev3pi.py
if [ $? != 0 ];
then
        echo $?, process not found, restart
        python /usr/local/bin/ev3pi.py >/dev/null 2>&1 &
else
        # ev3pi.py not found, so restart
        echo $?, process found, then do nothing
fi
# add the following lines to:
#	$ sudo crontab -e
# # check every 5 minutes if security system is running
# */5 * * * * /usr/local/bin/ev3chk.sh >/dev/null 2>&1
