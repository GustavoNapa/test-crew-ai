from crewai import Task

from agents import Agents

class Tasks():
    def research_information(self, agent):
        return Task(
            description='Research relevant information on a specific topic. Provide insights and recommendations based on the findings.',
            agent=agent,
            expected_output='The information should be thoroughly and accurately researched, using reliable sources. The findings should be documented in detail in a Google Sheets spreadsheet, with each result occupying a separate row.',
        )
        
    def write_to_google_sheets(self, agent):
        return Task(
            description='Write a row of data to a Google Sheets spreadsheet.',
            agent=agent,
            expected_output='The data should be accurately entered into the specified Google Sheets spreadsheet, with each value in the row corresponding to the appropriate column.',
        )