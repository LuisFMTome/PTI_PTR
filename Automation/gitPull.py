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
    
    print(current_hour, current_minute, current_sec)

    time.sleep(0.25)

    if current_hour == '13' and current_minute == '00' and current_sec == '00':
        os.chdir('/etc/var/www/html/PTI_PTR/')
        os.system(cmd)
        os.chdir('/etc/var/www/html/')
