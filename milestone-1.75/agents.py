from crewai import Agent

from langchain_community.tools import DuckDuckGoSearchRun
from tools import write_in_google_sheets, read_sheet_of_google_sheets

class Agents():
    def researcher(self):
        print("Researcher")
        duckduckgo_search = DuckDuckGoSearchRun()
        return Agent(
            role="Researcher",
            name="Researcher",
            goal="Obtain information and data to support the project. Provide insights and recommendations. Scan the environment for trends and opportunities. Identify potential risks and threats. Use the variable context to provide the necessary information. The context is a string. View te information of the google sheet.",
            backstory="The Researcher is a seasoned professional with a background in data analysis, research, and strategic planning. They have a keen eye for detail and a knack for uncovering valuable insights from complex datasets. The Researcher is passionate about using data to drive decision-making and is always on the lookout for new sources of information to support the project.",
            allow_delegation=True,
            verbose=True,
            max_iter=10,
            tools=[duckduckgo_search]
        )
    
    def google_sheets_writer(self):
        print("Google Sheets Writer")
        return Agent(
            role="Google Sheets Writer",
            name="Google Sheets Writer",
            goal="Save a row of data to Google Sheets.",
            backstory="The Google Sheets Writer is a skilled professional with experience in data management and spreadsheet software. They are responsible for saving important project data to Google Sheets, ensuring that it is organized and accessible to the team. The Google Sheets Writer is meticulous and detail-oriented, with a strong commitment to accuracy and data integrity.",
            allow_delegation=True,
            verbose=True,
            max_iter=10,
            tools=[write_in_google_sheets]
        )
        
    def google_sheets_reader(self):
        print("Google Sheets Reader")
        return Agent(
            role="Google Sheets Reader",
            name="Google Sheets Reader",
            goal="Read a row of data from Google Sheets.",
            backstory="The Google Sheets Reader is a skilled professional with experience in data management and spreadsheet software. They are responsible for retrieving important project data from Google Sheets, ensuring that it is accurate and up-to-date. The Google Sheets Reader is detail-oriented and thorough, with a strong commitment to data integrity and quality.",
            allow_delegation=True,
            verbose=True,
            max_iter=10,
            tools=[read_sheet_of_google_sheets]
        )