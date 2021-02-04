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
    "select Image as img from custfeedback where ImgDesc is null")
path = "C:\\Users\\deept\\Documents\\Deepthi\\TCS InfraMind\\Trial2\\imagelist.txt"
f = open(path, "a")
for (img) in cur:
    string = str(img)
    f.write(string[2:len(string)-1])
f.close()
print("successfully created list of images!");
