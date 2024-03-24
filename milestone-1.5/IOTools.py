import os

from langchain_community.agent_toolkits import FileManagementToolkit
from langchain_community.tools import DuckDuckGoSearchRun
from tempfile import TemporaryDirectory

from langchain_community.tools import tool

search_tool = DuckDuckGoSearchRun()
working_directory = TemporaryDirectory()

wd=os.getcwd();

toolkit = FileManagementToolkit(
    root_dir=wd,
    selected_tools=['copy_file', 'file_delete', 'file_search', 'move_file', 'read_file', 'write_file', 'list_directory'],
    verbose=True
)  # If you don't provide a root_dir, operations will default to the current working directory
toolkit.get_tools()
search_tool = DuckDuckGoSearchRun()

class IOTools:
    search_tool = search_tool
    file_manager_tools = toolkit
    
    @tool("Save file to disk")
    def write_file(code, filename):
        """Write code to disk. Input is code as a string."""
        print(code)
        with open(filename, "w") as file:
            file.write(code)
        return "File written successfully."
    
    @tool("Save row in Google Sheets")
    def google_sheets_writer(row_data):
        """Save a row of data to Google Sheets."""
        print(f"Saving row in Google Sheets: {row_data}")
        return "Row saved successfully."
    
    
    @tool("Execute CLI command")
    def execute_command(command):
        """Execute a command in the command line."""
        print(f"Executing command: {command}")
        return os.system(command)
    
    @tool("List directory")
    def list_directory(directory):
        """List the contents of a directory."""
        print(f"Listing directory: {directory}")
        return os.listdir(directory)