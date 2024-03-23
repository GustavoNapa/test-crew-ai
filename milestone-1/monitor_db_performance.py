import psycopg2
import sys

def monitor_database_performance(db_connection_string):
    try:
        connection = psycopg2.connect(db_connection_string)
        cursor = connection.cursor()
        cursor.execute("SELECT query, state, elapsed_time FROM pg_stat_activity WHERE state='active' ORDER BY elapsed_time DESC LIMIT 10;")
        slow_queries = cursor.fetchall()
        print('Top slow-running queries:\n', slow_queries)

        cursor.execute("SELECT COUNT(*) FROM pg_stat_activity WHERE state='active';")
        active_connections = cursor.fetchone()[0]
        print('Number of active connections:', active_connections)

        # Additional monitoring can be added here

    except (Exception, psycopg2.DatabaseError) as error:
        print("Error while connecting to PostgreSQL", error)
    finally:
        if (connection):
            cursor.close()
            connection.close()
            print("PostgreSQL connection is closed")

if __name__ == '__main__':
    if len(sys.argv) > 1:
        db_connection_string = sys.argv[1]
        monitor_database_performance(db_connection_string)
    else:
        print("Please provide the database connection string as an argument.")