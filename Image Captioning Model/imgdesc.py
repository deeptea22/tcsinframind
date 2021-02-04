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
path = "C:\\Users\\deept\\Documents\\Deepthi\\TCS InfraMind\\Trial2\\jandesc.txt"
f = open(path, "r")
doc = f.read()
for line in doc.split(','):
    image = []
    for img in line.split(':'):
        image.append(img)
    print(image)
    one = image[1]
    zero = image[0]
    print(one)
    print(zero)
    cur.execute("update custfeedback set ImgDesc = %s where Image = %s",(one,zero))
conn.commit()
f.close()
print("Successfully added Image Captions to Database!")



