from crewai import Task

from agents import Agents

from crewai.tasks.task_output import TaskOutput

def callback_function(output: TaskOutput):
    # Do something after the task is completed
    print(f"""Task completed! - Items List: {output.result}""")

class Tasks():
    def review_codebase(self, agent):
        return Task(
            description="""
                Review the codebase located in the "/codebase" folder and identify areas for improvement or evolution.
            
                1-Documento-De-Visão.md
                2-Plano-de-Projeto.md
                3-Diretrizes-para-endpoints.md
            """,
            agent=agent,
            expected_output="""
                A comprehensive report outlining identified issues, potential bugs, areas for optimization, and suggested enhancements within the codebase. Additionally, provide specific recommendations for each identified issue or improvement point, along with actionable steps for implementation.
                1-Documento-De-Visão.md
                2-Plano-de-Projeto.md
                3-Diretrizes-para-endpoints.md
                """
        )
        
    def analyze_project_progress(self, agent, context):
        return Task(
            description="""
                Read the Markdown files located in the "/codebase/docs" directory and draw conclusions about the remaining tasks required to complete the project.
                
                1-Documento-De-Visão.md
                2-Plano-de-Projeto.md
                3-Diretrizes-para-endpoints.md
            """,
            agent=agent,
            context=context,
            expected_output="""
                A comprehensive analysis of the project's current status and progress, based on the information extracted from the Markdown files. This analysis should include a breakdown of remaining tasks, dependencies, potential bottlenecks, and estimated completion timelines.
                """
        )
        
    def provide_strategic_guidance(self, agent, context):
        return Task(
            description="""Provide strategic guidance and recommendations based on the project's current status and future goals.""",
            agent=agent,
            context=context,
            expected_output='Actionable insights and strategic recommendations to help steer the project towards successful completion. These recommendations should be aligned with the project goals and address any identified challenges or opportunities.'
        )
        
    def facilitate_communication(self, agent, context):
        return Task(
            description="""Facilitate communication and collaboration among team members to ensure effective coordination and progress.""",
            agent=agent,
            context=context,
            expected_output='Improved communication channels and collaboration processes within the team, leading to enhanced coordination, productivity, and overall project success.'
        )
        
    def define_project_architecture(self, agent, context):
        return Task(
            description="""Define the project's architecture and technical requirements based on the current codebase and project goals.""",
            agent=agent,
            context=context,
            expected_output='A detailed project architecture document outlining the technical requirements, system design, component interactions, and data flow within the project. This document should serve as a blueprint for future development and implementation efforts.'
        )
        
    def write_tasks_list_in_google_sheets(self, agent, context):
        return Task(
            description="""Write the list of tasks to be completed in a Google Sheets spreadsheet for better tracking and organization.""",
            agent=agent,
            context=context,
            expected_output='A well-structured Google Sheets document containing a list of tasks to be completed, along with relevant details such as task descriptions, assignees, due dates, and completion status.'
        )
        
    def read_tasks_list_from_google_sheets(self, agent, context):
        return Task(
            description="""Read the list of tasks from the Google Sheets spreadsheet to gain insights into the project's task management and progress.""",
            agent=agent,
            context=context,
            expected_output='A detailed overview of the project tasks, including task descriptions, assignees, due dates, and completion status. This information will help in tracking progress, identifying bottlenecks, and ensuring timely completion of tasks.'
        )
        
    def update_project_timeline(self, agent, context):
        return Task(
            description="""Update the project timeline based on the current progress and task completion status.""",
            agent=agent,
            context=context,
            expected_output='An updated project timeline reflecting the current progress, completed tasks, upcoming milestones, and revised deadlines. This timeline will help in tracking project progress and ensuring timely delivery.'
        )
        
    def execute_code_review(self, agent, context):
        return Task(
            description="""Conduct a comprehensive code review of the project's codebase to identify bugs, vulnerabilities, and areas for improvement.""",
            agent=agent,
            context=context,
            expected_output='A detailed code review report highlighting identified issues, bugs, vulnerabilities, and areas for improvement within the codebase. The report should include specific recommendations for addressing each issue and improving code quality.'
        )
    
    def generate_documentation(self, agent, context):
        return Task(
            description="""Generate documentation for the project codebase to provide insights, instructions, and reference material for future development and maintenance.""",
            agent=agent,
            context=context,
            expected_output='Comprehensive documentation covering the project architecture, code structure, functionality, APIs, and usage instructions. The documentation should be well-organized, detailed, and accessible for developers and stakeholders.'
        )
        
    def schedule_functionalities_of_pending_tasks(self, agent, context):
        return Task(
            description="""Schedule the functionalities of pending tasks based on priority, dependencies, and resource availability.""",
            agent=agent,
            context=context,
            expected_output='A well-structured schedule outlining the order and timeline for completing pending tasks based on priority, dependencies, and resource availability. The schedule will help in managing task execution and ensuring timely completion.'
        )
        
    def provide_feedback_on_project_progress(self, agent, context):
        return Task(
            description="""Provide feedback and recommendations on the project's progress, challenges, and opportunities.""",
            agent=agent,
            context=context,
            expected_output='Constructive feedback and actionable recommendations to address project challenges, capitalize on opportunities, and enhance overall project progress and success.'
        )
        
    def monitor_project_metrics(self, agent, context):
        return Task(
            description="""Monitor project metrics and key performance indicators to track progress, identify trends, and make data-driven decisions.""",
            agent=agent,
            context=context,
            expected_output='Regular monitoring and analysis of project metrics and key performance indicators to track progress, identify trends, and make informed decisions for project optimization and success.'
        )
        