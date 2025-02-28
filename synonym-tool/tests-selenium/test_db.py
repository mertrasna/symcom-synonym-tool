import mysql.connector

DB_CONFIG = {
    "host": "localhost",
    "port": 6000,
    "user": "root",
    "password": "root",
    "database": "symcom_minified_db"
}

try:
    conn = mysql.connector.connect(**DB_CONFIG)
    print("✅ Successfully connected to MySQL!")
    conn.close()
except mysql.connector.Error as e:
    print(f"❌ Database Error: {e}")
