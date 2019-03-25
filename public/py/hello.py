from sqlalchemy import create_engine
import pymysql
import pandas as pd
from sklearn.neural_network import MLPClassifier
from sklearn.model_selection import train_test_split
from sklearn.metrics import accuracy_score
from sklearn.metrics import classification_report,confusion_matrix

db_connection = 'mysql+pymysql://root:S1freyokki@localhost/laravel'
conn = create_engine(db_connection)

df = pd.read_sql("""
	SELECT rateds.user_id, rateds.movie_id, rateds.rate
	FROM rateds 
	LEFT JOIN movies ON rateds.movie_id = movies.id 
	WHERE rateds.rate > 0
	""", conn)

X = df.drop(columns=['rate'])
y = df['rate']

X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.1)

model = MLPClassifier(hidden_layer_sizes=(8,8))
model.fit(X, y)
predictions = model.predict(X_test)

score = classification_report(y_test, predictions)
print(score)