from sqlalchemy import create_engine
import pymysql
import pandas as pd
from sklearn.neural_network import MLPClassifier
from sklearn.model_selection import train_test_split
from sklearn.metrics import accuracy_score

db_connection = 'mysql+pymysql://root:S1freyokki@localhost/laravel'
conn = create_engine(db_connection)

df = pd.read_sql("""
	SELECT rateds.user_id, rateds.movie_id, movies.vote_average, rateds.rate
	FROM rateds 
	LEFT JOIN movies ON rateds.movie_id = movies.id 
	WHERE rateds.rate > 0
	""", conn)

X = df.drop(columns=['rate'])
y = df['rate','vote_average']

X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.1)

model = MLPClassifier(hidden_layer_sizes=(4,8,15,10,4))
model.fit(X, y)
predictions = model.predict([[7,550],[7,389],[7,77],[7,603],[7,27205]
,[7,1124],[7,180864],[7,640],[7,8392],[7,11194]
,[7,9741],[7,203801],[7,9477],[7,115],[7,369972]
,[7,152603],[7,33909],[7,89584],[7,509335],[7,401981]
,[7,228967],[7,195589],[7,109414],[7,262543],[7,131634]])#X_test)

#score = accuracy_score(y_test, predictions)
print(predictions)