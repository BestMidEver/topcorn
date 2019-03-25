from sqlalchemy import create_engine
import pandas as pd

db_connection = 'mysql://root:S1freyokki@localhost/laravel'
conn = create_engine(db_connection)

df = pd.read_sql("SELECT rateds.user_id, rateds.movie_id, rateds.rate FROM rateds WHERE rateds.rate > 0", conn)