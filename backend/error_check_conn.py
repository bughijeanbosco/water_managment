import mysql.connector
try:
    conn = mysql.connector.connect(
        host='localhost',
        user='root',
        password='',  # Replace with your actual MySQL password
        database='smartwatermanagement'
    )
    print("Connected to MySQL database")
except mysql.connector.Error as err:
    print(f"Error: {err}")
