from crewai import Crew

from agents import Agents
from tasks import Tasks

from dotenv import load_dotenv, find_dotenv
import os
import openai

from langchain_openai import ChatOpenAI

load_dotenv(find_dotenv())

print("API_BASE:", os.getenv("OPENAI_API_BASE"));
print("API_KEY:", os.getenv("OPENAI_API_KEY"));
print("MODEL_NAME:", os.getenv("OPENAI_MODEL_NAME"));

mistral_api_key = os.environ.get("OPENAI_API_KEY")
openai.api_base = os.getenv("OPENAI_API_BASE", "https://api.openai.com/v1")
openai.api_key = os.getenv("OPENAI_API_KEY", "NA")
openai.models = os.getenv("OPENAI_MODEL_NAME", "text-davinci-003")
llm = ChatOpenAI(model=os.getenv("OPENAI_MODEL_NAME") , api_key=os.getenv("OPENAI_API_KEY", "NA"))

agents = Agents()
tasks = Tasks()

context = "The following is a conversation with an AI assistant. The assistant is helpful, creative, clever, and very friendly."
researcher = agents.researcher()
google_sheets_writer = agents.google_sheets_writer(context)

research_information = tasks.research_information(researcher, context)

crew = Crew(
    verbose=True,
    agents=[researcher, google_sheets_writer],
    tasks=[research_information]
)

result = crew.kickoff()
print(result)