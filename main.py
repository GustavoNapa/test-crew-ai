from crewai import Crew

from dotenv import load_dotenv, find_dotenv
import os

from langchain_openai import ChatOpenAI
from langchain.agents import load_tools

from agentsFactory import agentsFactory
from tasksFactory import tasksFactory

# Loading Human Tools
human_tools = load_tools(["human"])

load_dotenv(find_dotenv())

llm = ChatOpenAI(model=os.getenv("OPENAI_MODEL_NAME") , api_key=os.getenv("OPENAI_API_KEY", "NA"))

print("CrewAI is ready to go!")
print("OpenAI model:", os.getenv("OPENAI_MODEL_NAME"))

crew = Crew(
    verbose=True,
    agents=agentsFactory(),
    tasks=tasksFactory()
)

result = crew.kickoff()
print(result)