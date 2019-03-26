from sqlalchemy import create_engine
import pymysql
import pandas as pd
from sklearn.neural_network import MLPClassifier
from sklearn.model_selection import train_test_split
from sklearn.metrics import accuracy_score


db_connection = 'mysql+pymysql://root:S1freyokki@localhost/laravel'
conn = create_engine(db_connection)

df = pd.read_sql("""
	SELECT rateds.movie_id, rateds.rate, movies.vote_count, movies.vote_average, movies.popularity, UNIX_TIMESTAMP(movies.release_date) as release_date, budget, revenue
	FROM rateds
	INNER JOIN
	    (SELECT user_id, Count(1) As count
	    FROM rateds
	    WHERE rate > 0
	    GROUP BY user_id) NG
	ON rateds.user_id = NG.user_id
	LEFT JOIN movies ON rateds.movie_id = movies.id 
	WHERE rateds.rate > 0 AND NG.count > 66 AND rateds.user_id = 7
	""", conn)

X = df.drop(columns=['rate'])
y = df['rate']

X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.15)

model = MLPClassifier(hidden_layer_sizes=(8,100,100,8), max_iter=5000)#,max_iter=250)
model.fit(X_train,y_train)

#predictions = model.predict([[7,102651, 7878, 7]])
predictions = model.predict(X_test)

score = accuracy_score(y_test, predictions)
print(score)