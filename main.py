from crewai import Crew

from dotenv import load_dotenv, find_dotenv
import os

from langchain_openai import ChatOpenAI
from langchain.agents import load_tools

from agentsFactory import agentsFactory
from tasksFactory import tasksFactory

import logging

logging.basicConfig(level=logging.INFO, filename='crewai.log', filemode='w', format='%(name)s - %(levelname)s - %(message)s')
logging.basicConfig(level=logging.ERROR, filename='crewai.log', filemode='w', format='%(name)s - %(levelname)s - %(message)s')
logging.basicConfig(level=logging.WARNING, filename='crewai.log', filemode='w', format='%(name)s - %(levelname)s - %(message)s')

load_dotenv(find_dotenv())

# llm = ChatOpenAI(model=os.getenv("OPENAI_MODEL_NAME") , api_key=os.getenv("OPENAI_API_KEY", "NA"))

print("CrewAI is ready to go!")
print("OpenAI URL:", os.getenv("OPENAI_API_URL"))
# print("OpenAI model:", os.getenv("OPENAI_MODEL_NAME"))

crew = Crew(
    verbose=True,
    agents=agentsFactory(),
    tasks=tasksFactory(),
    step_callback=logging.info,
    full_output=True,
)

result = crew.kickoff()
print(result)