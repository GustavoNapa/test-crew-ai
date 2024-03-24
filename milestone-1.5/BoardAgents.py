from crewai import Agent
from main import search_tool, file_manager_tools, list_directory_tool, CLITool

class BoardAgents:
    def board_member1(self):
        return Agent(
            role='Board Member 1',
            goal='Provide strategic guidance and direction for the project.',
            backstory='An experienced leader with a deep understanding of project management and software development methodologies.',
            verbose=True,
            allow_delegation=True,
            tools=[search_tool, file_manager_tools.write_file, list_directory_tool, CLITool.execute_command]
        )

    def board_member2(self):
        return Agent(
            role='Board Member 2',
            goal='Provide expert advice and insights on technical aspects of the project.',
            backstory='A seasoned technologist with a strong background in software architecture and design.',
            verbose=True,
            allow_delegation=True,
            tools=[search_tool, file_manager_tools.write_file, list_directory_tool, CLITool.execute_command]
        )

    def board_member3(self):
        return Agent(
            role='Board Member 3',
            goal='Facilitate communication and collaboration among team members.',
            backstory='An effective communicator and mediator with a passion for fostering teamwork and synergy.',
            verbose=True,
            allow_delegation=True,
            tools=[search_tool, file_manager_tools.write_file, list_directory_tool, CLITool.execute_command]
        )
