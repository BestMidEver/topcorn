from sqlalchemy import create_engine
import pymysql
import pandas as pd
from sklearn.tree import DecisionTreeClassifier

db_connection = 'mysql+pymysql://root:S1freyokki@localhost/laravel'
conn = create_engine(db_connection)

df = pd.read_sql("SELECT rateds.user_id, rateds.movie_id, rateds.rate FROM rateds WHERE rateds.rate > 0", conn)

X = df.drop(columns=['rate'])
y = df['rate']

model = DecisionTreeClassifier()
model.fit(X, y)
predictions = model.predict([ [7, 1124] ])


print(predictions)