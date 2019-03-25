from sklearn.tree import DecisionTreeClassifier
import mysql.connector

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  passwd="S1freyokki",
  database="laravel"
)

mycursor = mydb.cursor()

mycursor.execute("SELECT * FROM rateds")

myresult = mycursor.fetchall()

for x in myresult:
  print(x)