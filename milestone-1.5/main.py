from crewai import Agent, Task, Crew

from dotenv import load_dotenv, find_dotenv
from IOAgents import IOAgents

load_dotenv(find_dotenv())

save_logs_task = Task(
    description='Save row to Google Sheets',
    agent=IOAgents.google_sheets_agent,
    expected_output='Logs saved to Google Sheets successfully.'
)

crew = Crew(
    verbose=True,
    agents=[IOAgents.google_sheets_agent],
    tasks=[save_logs_task]
)

# Kickoff the crew
# crew.kickoff()

result = crew.kickoff()
print(result)