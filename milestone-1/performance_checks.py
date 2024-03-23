import os
import psutil

# Function to check CPU usage
def check_cpu_usage():
    print('CPU usage is: ' + str(psutil.cpu_percent()) + '%')

# Function to check for slow database queries (Pseudo code)
def check_database_performance():
    # This is a placeholder. Actual implementation would require access to the database logs or query monitoring tools
    print('Checking database performance...')

check_cpu_usage()
check_database_performance()