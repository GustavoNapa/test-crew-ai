from crewai import Agent, Task, Crew

from BoardTasks import provide_strategic_guidance, provide_expert_advice, facilitate_communication, define_project_architecture
from BoardAgents import board_member1, board_member2, board_member3

from dotenv import load_dotenv, find_dotenv

crew = Crew(
    verbose=True,
    agents=[board_member1, board_member2, board_member3],
    tasks=[provide_strategic_guidance, provide_expert_advice, facilitate_communication, define_project_architecture]
)

# Kickoff the crew
# crew.kickoff()

result = crew.kickoff()
print(result)