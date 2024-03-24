from langchain.tools import tool

import os

import gspread
from oauth2client.service_account import ServiceAccountCredentials
from interpreter import interpreter

# Loading Human Tools
human_tools = load_tools(["human"])

@tool("Log event to Google Sheets")
def write_in_google_sheets(event):
    """
    Logs an event and appends a row to the Google Sheets spreadsheet.

    Args:
        event (str): The event to be logged.

    Returns:
        None
    """
    # Add a row to the Google Sheets spreadsheet
    sheet_id = '12tOwOjx5UjBdpA7kGIbUFNaq4aO-3tA4ZNtyXyN3zXw'
    scope = ["https://spreadsheets.google.com/feeds", "https://www.googleapis.com/auth/drive"]
    credentials = ServiceAccountCredentials.from_json_keyfile_name("credentials.json", scope)
    client = gspread.authorize(credentials)
    sheet = client.open_by_key(sheet_id).sheet1
    
    sheet.append_row([event])
    print(f"Event logged: {event}")
    
@tool("Read sheet from Google Sheets")
def read_sheet_of_google_sheets():
    """
    Reads the contents of the Google Sheets spreadsheet.

    Returns:
        list: The contents of the Google Sheets spreadsheet.
    """
    # Read the contents of the Google Sheets spreadsheet
    sheet_id = '12tOwOjx5UjBdpA7kGIbUFNaq4aO-3tA4ZNtyXyN3zXw'
    scope = ["https://spreadsheets.google.com/feeds", "https://www.googleapis.com/auth/drive"]
    credentials = ServiceAccountCredentials.from_json_keyfile_name("credentials.json", scope)
    client = gspread.authorize(credentials)
    sheet = client.open_by_key(sheet_id).sheet1
    
    data = sheet.get_all_records()
    print(f"Sheet read: {data}")
    return data

@tool("Write file to disk")
def write_file(code, filename):
    """
    Writes code to a file on disk.

    Args:
        code (str): The code to be written to the file.
        filename (str): The name of the file to write to.

    Returns:
        str: A message indicating the success of the operation.
    """
    with open(filename, "w") as file:
        file.write(code)
    return f"File written successfully: {filename}"

@tool("Execute CLI command")
def execute_command(command):
    """Execute a command in the command line."""
    print(f"Executing command: {command}")
    return os.system(command)

@tool("Generate Markdown documentation")
def generate_documentation(documentation_content, file_name):
    """
    Generate Markdown documentation and save it to a file.

    Args:
        documentation_content (str): The content of the documentation in Markdown format.
        file_name (str): The name of the file to save the documentation.

    Returns:
        str: A message indicating the success of the documentation generation and saving process.
    """
    folder_path = 'outputs/documents'
    file_path = os.path.join(folder_path, file_name)
    with open(file_path, 'w') as file:
        file.write(documentation_content)
    return f"Documentation saved successfully to '{file_path}'."

@tool("Create folder")
def create_folder( folder_name):
    """
    Create a folder in the root path.

    Args:
        folder_name (str): The name of the folder to create.

    Returns:
        str: A message indicating the success of folder creation.
    """
    
    root_path = 'outputs'
    folder_path = os.path.join(root_path, folder_name)
    os.makedirs(folder_path, exist_ok=True)
    return f"Folder '{folder_name}' created successfully."

@tool("Interpret code with OpenAI")
def interpret_code_with_openai(code):
    """
    Interpret code using the OpenAI Codex model.

    Args:
        code (str): The code to be interpreted.

    Returns:
        str: The interpretation of the code.
    """
    return interpreter.chat(code)

@tool("Generate code with OpenAI")
def generate_code_with_openai(prompt):
    """
    Generate code using the OpenAI Codex model.

    Args:
        prompt (str): The prompt to generate code from.

    Returns:
        str: The generated code.
    """
    return interpreter.chat(prompt)

@tool("Accept human response")
def accept_human_response():
    """
    Accepts a human response during the execution of a task.

    Returns:
        str: The human response.
    """
    response = input("Enter your response: ")
    return response

@tool("Accept human feedback")
def accept_human_feedback():
    """
    Accepts human feedback during the execution of a task.

    Returns:
        str: The human feedback.
    """
    feedback = input("Enter your feedback: ")
    return feedback