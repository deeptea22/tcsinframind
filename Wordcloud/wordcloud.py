import mysql.connector as mariadb
import sys
import os
try:
    conn = mariadb.connect(
        user="root", #- enter your username
        #password=" " - enter your password        
        database="tcsproject" # - enter your database name

    )
except mariadb.Error as e:
    print(f"Error connecting to MariaDB Platform: {e}")
    sys.exit(1)

# Get Cursor
cur = conn.cursor(buffered=True)
cur.execute(
    "select Feedback as feed from custfeedback")
path = "C:\\Users\\deept\\Documents\\Deepthi\\TCS InfraMind\\Trial2\\wordcloud.txt"
f = open(path, "a")
for (feed) in cur:
    string = str(feed)
    f.write(string[1:len(string)-1])
f.close()
