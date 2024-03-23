from crewai import Agent, Task, Crew, Process
#from langchain_community.tools import DuckDuckGoSearchRun
from dotenv import load_dotenv, find_dotenv
import os
import openai

from tempfile import TemporaryDirectory
from langchain_community.agent_toolkits import FileManagementToolkit
from langchain_community.tools import DuckDuckGoSearchRun

from langchain.tools import tool

from langchain_openai import ChatOpenAI
from langchain_community.llms import Ollama
from langchain_mistralai.chat_models import ChatMistralAI
from langchain_google_vertexai import VertexAI
from langchain.pydantic_v1 import BaseModel, Field

import gspread
from oauth2client.service_account import ServiceAccountCredentials

# from interpreter import interpreter

search_tool = DuckDuckGoSearchRun()
working_directory = TemporaryDirectory()

wd=os.getcwd();

toolkit = FileManagementToolkit(
    root_dir=wd,
    selected_tools=['copy_file', 'file_delete', 'file_search', 'move_file', 'read_file', 'write_file', 'list_directory'],
    verbose=True
)  # If you don't provide a root_dir, operations will default to the current working directory
toolkit.get_tools()

load_dotenv(find_dotenv())

class FileManagerTools:
    @tool("Write code to disk")
    def write_file(code, filename):
        """Write code to disk. Input is code as a string."""
        print(code)
        with open(filename, "w") as file:
            file.write(code)
        return "File written successfully."

# Create FileManagerTools instance
file_manager_tools = FileManagerTools()
working_directory = TemporaryDirectory()
toolkit = FileManagementToolkit(
    root_dir=str(working_directory.name),
    selected_tools=["write_file", "list_directory"]
)
write_file_tool, list_directory_tool = toolkit.get_tools()


# openai.api_base = os.getenv("OPENAI_API_BASE", "http://localhost:1234/v1")
if(os.getenv("ENV") == "local"):
    # mistral_api_key = os.environ.get("OPENAI_API_KEY")
    openai.api_base = os.getenv("LOCAL_API_BASE", "http://localhost:1234/v1")
    # openai.api_key = os.getenv("LOCAL_MODEL_NAME", "NA")
    # openai.models = os.getenv("LOCAL_API_KEY", "text-davinci-003")
else:
    mistral_api_key = os.environ.get("OPENAI_API_KEY")
    openai.api_base = os.getenv("OPENAI_API_BASE", "https://api.openai.com/v1")
    openai.api_key = os.getenv("OPENAI_API_KEY", "NA")
    openai.models = os.getenv("OPENAI_MODEL_NAME", "text-davinci-003")
    # llm = ChatOpenAI(model="gpt-4-turbo-preview", api_key=os.getenv("OPENAI_API_KEY", "NA"))

# interpreter.auto

class CLITool:
    @tool("Execute CLI command")
    def execute_command(command):
        """Execute a command in the command line."""
        print(f"Executing command: {command}")
        return os.system(command)
    
class GoogleSheetsLogger:
    def __init__(self, sheet_id):
        self.sheet_id = sheet_id
        self.scope = ["https://spreadsheets.google.com/feeds", "https://www.googleapis.com/auth/drive"]
        self.credentials = ServiceAccountCredentials.from_json_keyfile_name("credentials.json", self.scope)
        self.client = gspread.authorize(self.credentials)
        self.sheet = self.client.open_by_key(sheet_id).sheet1

    def log_event(self, event):
        # Adicione uma linha à planilha do Google Sheets
        self.sheet.append_row([event])
        print(f"Event logged: {event}")
        
class MarkdownDocumentor(tool):
    def __init__(self, folder_path):
        self.folder_path = folder_path

    def generate_documentation(self, documentation_content, file_name):
        """
        Generate Markdown documentation and save it to a file.

        Args:
            documentation_content (str): The content of the documentation in Markdown format.
            file_name (str): The name of the file to save the documentation.

        Returns:
            str: A message indicating the success of the documentation generation and saving process.
        """
        file_path = os.path.join(self.folder_path, file_name)
        with open(file_path, 'w') as file:
            file.write(documentation_content)
        return f"Documentation saved successfully to '{file_path}'."
    
# Define a tool to manage folders
class FolderManager(tool):
    def __init__(self, root_path):
        self.root_path = root_path

    def create_folder(self, folder_name):
        """
        Create a folder in the root path.

        Args:
            folder_name (str): The name of the folder to create.

        Returns:
            str: A message indicating the success of folder creation.
        """
        folder_path = os.path.join(self.root_path, folder_name)
        os.makedirs(folder_path, exist_ok=True)
        return f"Folder '{folder_name}' created successfully."

# Create a FolderManager instance
folder_manager = FolderManager(root_path="./outputs")

# Define additional agents
board_member1 = Agent(
    role='Board Member 1',
    goal='Provide strategic guidance and direction for the project.',
    backstory='An experienced leader with a deep understanding of project management and software development methodologies.',
    verbose=True,
    allow_delegation=True,
    tools=[search_tool, file_manager_tools.write_file, list_directory_tool, CLITool.execute_command]
)

board_member2 = Agent(
    role='Board Member 2',
    goal='Provide expert advice and insights on technical aspects of the project.',
    backstory='A seasoned technologist with a strong background in software architecture and design.',
    verbose=True,
    allow_delegation=True,
    tools=[search_tool, file_manager_tools.write_file, list_directory_tool, CLITool.execute_command]
)

board_member3 = Agent(
    role='Board Member 3',
    goal='Facilitate communication and collaboration among team members.',
    backstory='An effective communicator and mediator with a passion for fostering teamwork and synergy.',
    verbose=True,
    allow_delegation=True,
    tools=[search_tool, file_manager_tools.write_file, list_directory_tool, CLITool.execute_command]
)

# Define additional agents
surgical_programmer1 = Agent(
    role='Surgical Programmer 1',
    goal='Implement critical and complex functionalities of the system.',
    backstory='A highly skilled programmer with a focus on delivering high-quality code and meeting project deadlines. With a focus on using PHP and Laravel technologies.',
    verbose=True,
    allow_delegation=True,
    tools=[search_tool, file_manager_tools.write_file, list_directory_tool, CLITool.execute_command]
)

surgical_programmer2 = Agent(
    role='Surgical Programmer 2',
    goal='Optimize performance and efficiency of the system.',
    backstory='A proficient problem solver with expertise in algorithm optimization and performance tuning. With a focus on using PHP and Laravel technologies.',
    verbose=True,
    allow_delegation=True,
    tools=[search_tool, file_manager_tools.write_file, list_directory_tool, CLITool.execute_command]
)

surgical_programmer3 = Agent(
    role='Surgical Programmer 3',
    goal='Ensure code quality and maintainability through refactoring and best practices.',
    backstory='A meticulous coder with a dedication to writing clean, maintainable code. With a focus on using PHP and Laravel technologies.',
    verbose=True,
    allow_delegation=True,
    tools=[search_tool, file_manager_tools.write_file, list_directory_tool, CLITool.execute_command]
)

language_defender = Agent(
    role='Language Defender',
    goal='Promote best practices and maintain code consistency in PHP with Laravel.',
    backstory='A passionate advocate for PHP with Laravel, committed to upholding coding standards and defending the integrity of the language.',
    verbose=True,
    allow_delegation=True,
    tools=[search_tool, file_manager_tools.write_file, list_directory_tool, CLITool.execute_command]
)

scrum_master = Agent(
    role="Scrum Master",
    goal="Improve project execution and coherence, and ensure conceptual integrity.",
    backstory="An experienced facilitator with a deep understanding of agile methodologies, dedicated to optimizing team performance and ensuring the conceptual integrity of the project.",
    tools=[],
    verbose=True
)

qa_engineer = Agent(
    role="Quality Assurance Engineer",
    goal="Ensure that the code meets the specified requirements and functions as expected.",
    backstory="A meticulous tester with expertise in identifying and resolving software defects.",
    tools=[],
    verbose=True
)

editor = Agent(
    role='Editor',
    goal='Ensure code quality and consistency through code reviews and documentation.',
    backstory='A meticulous reviewer with a keen eye for detail, dedicated to maintaining high standards of code quality and documentation.',
    verbose=True,
    allow_delegation=False,
    tools=[search_tool, file_manager_tools.write_file, list_directory_tool, CLITool.execute_command]
)

files_manager = Agent(
    role='File Manager',
    goal='Efficiently manage and save files',
    backstory='Specialized in organizing and storing files securely and accessibly.',
    verbose=True,
    allow_delegation=False,
    tools=[file_manager_tools.write_file]
)

researcher = Agent(
    role="Researcher",
    goal="""Identify a topic for a hands-on tutorial focusing on creating a pizza delivery application using Flask and Python.""",
    backstory="""
    Research Flask and Python's capabilities in web app development, particularly for creating a pizza delivery app. The tutorial should introduce Flask, demonstrate setting up a basic web server, handling user inputs, and integrating with a backend database.
    """,
    verbose=True,
    allow_delegation=False,
    tools=[search_tool, file_manager_tools.write_file, list_directory_tool, CLITool.execute_command]
)

google_sheets_agent = Agent(
    role="Google Sheets Logger",
    goal="Save logs to Google Sheets",
    backstory="An agent dedicated to recording important events in Google Sheets for future reference.",
    tools=[GoogleSheetsLogger("12tOwOjx5UjBdpA7kGIbUFNaq4aO-3tA4ZNtyXyN3zXw")],
    verbose=True
)

documenter_agent = Agent(
    role="Documenter",
    goal="Create and organize the project's technical documentation",
    backstory="An agent responsible for generating and organizing the project's technical documentation in Markdown files in the 'documents' folder. With a focus on using PHP and Laravel technologies.",
    tools=[MarkdownDocumentor("documents")],
    verbose=True
)

# Define the new agent to organize the project into folders
folder_organizer_agent = Agent(
    role="Folder Organizer",
    goal="Organize the project into folders",
    backstory="An agent dedicated to organizing the project files into folders for better structure and management. With a focus on using PHP and Laravel technologies.",
    tools=[folder_manager.create_folder],
    verbose=True
)

# Define additional tasks
define_project_architecture = Task(
    description='Define the project architecture, including design patterns and technologies to be used.',
    agent=board_member1,
    expected_output='Project architecture successfully defined.'
)

implement_payment_endpoints = Task(
    description='Implement payment endpoints, including creating PIX charges, checking charge status, creating PIX withdrawal transactions, and checking withdrawal status.',
    agent=surgical_programmer1,
    expected_output='Payment endpoints successfully implemented.'
)

# Define the task to integrate with the SuitPay gateway
integrate_with_suitpay = Task(
    description='Integrate with the SuitPay gateway for payment processing. Documentation available at https://api.suitpay.app/',
    agent=surgical_programmer1,
    expected_output='Successful integration with the SuitPay gateway.'
)

optimize_system_performance = Task(
    description='Optimize system performance and efficiency by identifying and resolving potential performance bottlenecks.',
    agent=surgical_programmer2,
    expected_output='System performance optimized successfully.'
)

refactor_codebase = Task(
    description='Refactor the codebase to ensure quality and maintainability, following best practices and coding standards.',
    agent=surgical_programmer3,
    expected_output='Codebase refactored successfully.'
)

code_verification_task = Task(
    description='Verify code functionality to ensure it is working as expected.',
    agent=qa_engineer,
    expected_output='Code functionality verified successfully.'
)

code_review_task = Task(
    description='Review code to ensure it meets quality standards and functions correctly.',
    agent=scrum_master,
    expected_output='Code reviewed and meets quality standards.'
)

defend_language_integrity = Task(
    description='Defend the integrity of the PHP with Laravel language, ensuring that the code follows recommended practices and coding standards.',
    agent=language_defender,
    expected_output='PHP with Laravel language integrity maintained successfully.'
)

review_and_document_code = Task(
    description='Review code and documentation to ensure quality and consistency, providing feedback and improvements as needed.',
    agent=editor,
    expected_output='Code and documentation reviewed and documented successfully.'
)

files_management_task = Task(
  description='Save received python code from coder in a file',
  agent=files_manager,
  tools=[file_manager_tools.write_file],
    expected_output='Python code saved in a file'
)

# Define the crew
crew = Crew(
    verbose=True,
    agents=[board_member1, board_member2, board_member3, surgical_programmer1, surgical_programmer2, surgical_programmer3, language_defender, editor, files_manager, researcher, google_sheets_agent, documenter_agent, folder_organizer_agent, scrum_master, qa_engineer],
    tasks=[define_project_architecture, implement_payment_endpoints, optimize_system_performance, refactor_codebase, defend_language_integrity, review_and_document_code],
    process=Process.sequential  # Sequential task execution
)

# Kickoff the crew
# crew.kickoff()

result = crew.kickoff()
print(result)