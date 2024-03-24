from crewai import Task

from agents import Agents

from crewai.tasks.task_output import TaskOutput

def callback_function(output: TaskOutput):
    # Do something after the task is completed
    print(f"""Task completed! - Items List: {output.result}""")

class Tasks():
    def look_to_possible_temes(self, agent):
        return Task(
            description='Look for possible themes to research. Use the variable context to provide the necessary information. The context is a string. View the information of the Google Sheet to view anterior researches.',
            agent=agent,
            expected_output='The themes should be relevant to the project and aligned with the research goals. The findings should be documented in detail in a Google Sheets spreadsheet, with each theme occupying a separate row.',
            callback=callback_function
        )
    
    def research_information(self, agent, context):
        return Task(
            description='Research relevant information on a specific topic. Provide insights and recommendations based on the findings. Scan the environment for trends and opportunities. Identify potential risks and threats. Use the variable context to provide the necessary information. The context is a string. View the information of the Google Sheet to view anterior researches.',
            agent=agent,
            expected_output='The information should be thoroughly and accurately researched, using reliable sources. The findings should be documented in detail in a Google Sheets spreadsheet, with each result occupying a separate row.',
            context=context,
            callback=callback_function
        )
        
    def write_to_google_sheets(self, agent):
        return Task(
            description='Write a row of data to a Google Sheets spreadsheet.',
            agent=agent,
            expected_output='The data should be accurately entered into the specified Google Sheets spreadsheet, with each value in the row corresponding to the appropriate column.',
            async_execution=True,
            callback=callback_function
        )