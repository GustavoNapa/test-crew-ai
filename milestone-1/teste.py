import os, json
import openai
from dotenv import load_dotenv, find_dotenv
from langchain_openai import ChatOpenAI
from crewai import Agent, Task, Crew, Process
from langchain_openai import ChatOpenAI
from langchain_community.llms import Ollama
from langchain_mistralai.chat_models import ChatMistralAI
from langchain_google_vertexai import VertexAI
from tempfile import TemporaryDirectory
from langchain_community.agent_toolkits import FileManagementToolkit
from langchain.tools import tool
from langchain.pydantic_v1 import BaseModel, Field

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
openai.api_base = os.getenv("OPENAI_API_BASE", "https://api.openai.com/v1")
openai.api_key = os.getenv("OPENAI_API_KEY", "NA")
openai.models = os.getenv("OPENAI_MODEL_NAME", "text-davinci-003")
working_directory = TemporaryDirectory()
toolkit = FileManagementToolkit(
    root_dir=str(working_directory.name),
    selected_tools=["write_file", "list_directory"]
)
write_file_tool, list_directory_tool = toolkit.get_tools()

# Create Agents
coder = Agent(
  role='Software Engineer',
  goal='Develop innovative software solutions',
  backstory='A skilled software engineer who writes python code.',
  verbose=True,
  allow_delegation=False,
)

files_manager = Agent(
    role='File Manager',
    goal='Efficiently manage and save files',
    backstory='Specialized in organizing and storing files securely and accessibly.',
    verbose=True,
    allow_delegation=False,
    tools=[file_manager_tools.write_file]
)

# Create Tasks
software_development_task = Task(
  description='Write python code for a Flask application to find the stock of a company using yfinance',
  agent=coder,
  expected_output='Python code for a Flask application to find the stock of a company using yfinance'
)

files_management_task = Task(
  description='Save received python code from coder in a file',
  agent=files_manager,
  tools=[file_manager_tools.write_file],
    expected_output='Python code saved in a file'
)

# Create Crew
tech_crew = Crew(
  agents=[coder, files_manager],
  tasks=[software_development_task, files_management_task],
  process=Process.sequential  # Sequential task execution
)

# Execute tasks
result = tech_crew.kickoff()
print(result)