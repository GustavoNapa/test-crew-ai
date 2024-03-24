from crewai import Agent

from IOTools import search_tool, IOTools

class IOAgents:
    def files_manager(self):
        return Agent(
            role='File Manager',
            goal='Efficiently manage and save files',
            backstory='Specialized in organizing and storing files securely and accessibly.',
            verbose=True,
            allow_delegation=False,
            tools=[file_manager_tools.write_file]
        )

    def researcher(self):
        return Agent(
            role="Researcher",
            goal="""Identify a topic for a hands-on tutorial focusing on creating a pizza delivery application using Flask and Python.""",
            backstory="""
            Research Flask and Python's capabilities in web app development, particularly for creating a pizza delivery app. The tutorial should introduce Flask, demonstrate setting up a basic web server, handling user inputs, and integrating with a backend database.
            """,
            verbose=True,
            allow_delegation=False,
            tools=[search_tool, file_manager_tools.write_file]
        )

    def google_sheets_agent(self):
        return Agent(
            role="Google Sheets Logger",
            goal="Save logs to Google Sheets",
            backstory="An agent dedicated to recording important events in Google Sheets for future reference.",
            allow_delegation=True,
            tools=[IOTools.google_sheets_writer],
            verbose=True
        )

    def documenter_agent(self):
        return Agent(
            role="Documenter",
            goal="Create and organize the project's technical documentation",
            backstory="An agent responsible for generating and organizing the project's technical documentation in Markdown files in the 'documents' folder. With a focus on using PHP and Laravel technologies.",
            tools=[file_manager_tools.write_file, file_manager_tools.list_directory],
            verbose=True
        )