from sqlalchemy import create_engine
import pymysql
import pandas as pd
from sklearn.tree import DecisionTreeClassifier
from sklearn.model_selection import train_test_split
from sklearn.metrics import accuracy_score

db_connection = 'mysql+pymysql://root:S1freyokki@localhost/laravel'
conn = create_engine(db_connection)

df = pd.read_sql("""
	SELECT r1.user_id, r1.movie_id, (r1.rate - 1)*25 as rate, ROUND(movies.vote_average, 0) as vote_average
	FROM rateds AS r1,
		(SELECT r2.id, COUNT(*) AS the_count
		FROM rateds as r2
		GROUP BY r2.user_id) AS r2
	LEFT JOIN movies ON r1.movie_id = movies.id 
	WHERE r1.rate > 0 AND r1.id = r2.id
	""", conn)

X = df.drop(columns=['rate'])
y = df['rate']

X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.1)

model = DecisionTreeClassifier()
model.fit(X_train, y_train)
predictions = model.predict(X_test)

score = accuracy_score(y_test, predictions)
print(score)