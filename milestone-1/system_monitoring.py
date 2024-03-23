
import os
import psutil

# Function to monitor memory usage
def monitor_memory_usage():
    print(f"Total memory: {psutil.virtual_memory().total / (1024.0 ** 3)} GB")
    print(f"Available memory: {psutil.virtual_memory().available / (1024.0 ** 3)} GB")
    print(f"Used memory: {psutil.virtual_memory().used / (1024.0 ** 3)} GB")
    print(f"Memory usage: {psutil.virtual_memory().percent}%")

# Function to monitor I/O statistics
def monitor_io_stats():
    io_stats = psutil.disk_io_counters()
    print(f"Read count: {io_stats.read_count}")
    print(f"Write count: {io_stats.write_count}")
    print(f"Read bytes: {io_stats.read_bytes / (1024.0 ** 2)} MB")
    print(f"Write bytes: {io_stats.write_bytes / (1024.0 ** 2)} MB")

if __name__ == "__main__":
    monitor_memory_usage()
    monitor_io_stats()
