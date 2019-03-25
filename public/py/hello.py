from sklearn.tree import DecisionTreeClassifier
import mysql.connector

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  passwd="S1freyokki",
  database="laravel"
)

mycursor = mydb.cursor()

mycursor.execute("SELECT rateds.user_id, rateds.movie_id, rateds.rate FROM rateds WHERE rateds.rate > 0")

myresult = mycursor.fetchall()

#for x in myresult:
  print(myresult)