import os
import datetime
import time
cmd = "sudo git pull"
while True:
    today = datetime.datetime.today()
    today= str(today)
    current_hour = today[11:13]
    current_minute = today[14:16]
    current_sec = today[17:19]
    time.sleep(0.25)
    if current_hour == '13' and current_minute == '00' and current_sec == '00':
        os.system(cmd)
