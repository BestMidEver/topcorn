from sklearn.tree import DecisionTreeClassifier
import mysql.connector

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  passwd="S1freyokkis"
)

print(mydb)