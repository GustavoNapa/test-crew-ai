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
                Review the codebase located in the folder and identify areas for improvement or evolution.
            
                1-Documento-De-Visão.md
                2-Plano-de-Projeto.md
                3-Diretrizes-para-endpoints.md
                
                Create tasks for the identified areas.
                Define the priority of the tasks.
                Create all the tasks in the Google Sheets.
                Organize the tasks in the Google Sheets.
                Garantee that the tasks are being executed.
                Create the project in Laravel.
                Program the functionalities of the tasks.
                Delegate the tasks to the team members.
                Provide feedback on the project progress.
                Monitor project metrics.
                Report the project progress.
                Ask for feedback from the team members.
                Ask feedback in the terminal to the user in the reminal (Translate the ask to portuguese brazilian).
                Define the project architecture.
                Facilitate communication.
                Provide strategic guidance.
                Generate documentation.
                Execute code review.
                Schedule functionalities of pending tasks.
                Garant files are being saved in the correct folder (/outputs).
                Garant project execution in Laravel.
                Garant the correct use of the Laravel framework.
                Garant the knowledge of the Laravel framework.
                Garant the knowledhe of all code in the '/codebase' folder.
                Use the correct tools for the project.
                Use the correct tools for the task.
                Use the '/codebase' folder for the project inprove.
                Use the '/outputs' folder for the project improved.
                Use the '/outputs/documents' folder for the project documentation.
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
                
                Analize the project progress.
                Engage correct agents to ensure all tasks are correct and implement improvements
            """,
            agent=agent,
            context=context,
            expected_output="""
                A comprehensive analysis of the project's current status and progress, based on the information extracted from the Markdown files. This analysis should include a breakdown of remaining tasks, dependencies, potential bottlenecks, and estimated completion timelines.
                """
        )
        
    def provide_strategic_guidance(self, agent, context):
        return Task(
            description="""
                Provide strategic guidance and recommendations based on the project's current status and future goals.
                
                For that, you need to:
                - Review the codebase
                - Analyze the project progress
                - Facilitate communication
                - Analize tasks in the Google Sheets
                - Update the project timeline
                - Execute code review
                - Generate documentation
                - Schedule functionalities of pending tasks
                
                Using the correct tools, folders and files.
                If You need help, ask for feedback from the team members.
                If you have any questions, ask feedback in the terminal to the user in the reminal (Translate the ask to portuguese brazilian).
                If you need to delegate tasks, define the scope of tasks and delegate the tasks to the team members.
            """,
            agent=agent,
            context=context,
            expected_output='Actionable insights and strategic recommendations to help steer the project towards successful completion. These recommendations should be aligned with the project goals and address any identified challenges or opportunities.'
        )
        
    def facilitate_communication(self, agent, context):
        return Task(
            description="""
                Facilitate communication and collaboration among team members to ensure effective coordination and progress.
                
                For that, you need to:
                - Review the codebase
                - Analyze the project progress
                - Analiyze tasks in the Google Sheets
                - Ask for feedback from the team members
                - Provide feedback on the project progress
                - Monitor project metrics
                - Ask feedback in the terminal to the user in the reminal (Translate the ask to portuguese brazilian)
                - Ask the team members for feedback
            """,
            agent=agent,
            context=context,
            expected_output='Improved communication channels and collaboration processes within the team, leading to enhanced coordination, productivity, and overall project success.'
        )
        
    def define_project_architecture(self, agent, context):
        return Task(
            description="""
                Define the project's architecture and technical requirements based on the current codebase and project goals.
                
                For that, you need to:
                - Review the codebase
                - Analyze the project progress
                - Analize tasks in the Google Sheets
                - Facilitate communication
                - Study the project documentation
                - Study the best practices for project architecture
                - Study the best practices for project documentation
                - Study the best practices for project management
                - Provide feedback on the project progress
                - Provide to your team the best practices for project management
                - Train your team in the best practices for project management
                - Monitor project metrics
                - Ask feedback in the terminal to the user in the reminal (Translate the ask to portuguese brazilian)
                - Ask the team members for feedback
            """,
            agent=agent,
            context=context,
            expected_output='A detailed project architecture document outlining the technical requirements, system design, component interactions, and data flow within the project. This document should serve as a blueprint for future development and implementation efforts.'
        )
        
    def write_tasks_list_in_google_sheets(self, agent, context):
        return Task(
            description="""
                Write the list of tasks to be completed in a Google Sheets spreadsheet for better tracking and organization.
                
                FOr that, you need to:
                - Review the codebase
                - Analyze the project progress
                - Analize tasks in the Google Sheets
                - Facilitate communication
                - Review the organization of the tasks
                - If you need help, ask for feedback from the team members
                - If you have any questions, ask feedback in the terminal to the user in the reminal (Translate the ask to portuguese brazilian)
                - If you need to delegate tasks, define the scope of tasks and delegate the tasks to the team members
                - Provide feedback on the project progress
                - Monitor project metrics
                - If you have update the organization of the tasks, ask the team members for feedback""",
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
        
    def initialize_project(self, agent, context):
        return Task(
            description="""Initialize the project Laravel by setting up the required environment, tools, and resources for development.""",
            agent=agent,
            context=context,
            expected_output='A fully initialized project environment with all the necessary tools, resources, and configurations set up for development. The project environment should be ready for coding, testing, and deployment.'
        )
        
    def code_the_project(self, agent, context):
        return Task(
            description="""
                Code the project based on the defined architecture, requirements, and functionalities.
                
                For that, you need to:
                - Review the codebase
                - Analyze the project progress
                - Define the project architecture
                - Write tasks list in Google Sheets
                - Read tasks list from Google Sheets
                - Program the functionalities of the tasks
                - Monitor project metrics
                - Update project timeline
                - Execute code review
                - Generate documentation
                - Schedule functionalities of pending tasks
                - Provide feedback on project progress
                - Understand the project architecture
                - Garant the correct use of the Laravel framework
                - Move the files to the correct folder (/outputs)
            """,
            agent=agent,
            context=context,
            expected_output='A fully functional project codebase developed according to the defined architecture, technical requirements, and project functionalities. The code should be well-structured, optimized, and thoroughly tested to ensure quality and reliability.'
        )
        
    def execute_code_review(self, agent, context):
        return Task(
            description="""
                Conduct a comprehensive code review of the project's codebase to identify bugs, vulnerabilities, and areas for improvement.
                
                For that, you need to:
                - Review the codebase
                - Analyze the project progress
                - Define the project architecture
                - Write tasks list in Google Sheets
                - Read tasks list from Google Sheets
                - Review the organization of the tasks
                - Read all code in the '/codebase' folder
                - Read all code produced in the project
                - Provide feedback on the project progress
                
                If you need help, ask for feedback from the team members
                If you have any questions, ask feedback in the terminal to the user in the reminal (Translate the ask to portuguese brazilian)
                If you need to delegate tasks, define the scope of tasks and delegate the tasks to the team members
                
                - Sugest improvements in the code
                - Call the team members to discuss the code
                - Call the team members to discuss the project
                - Call the team members to discuss the tasks
                - Call the team members to discuss the documentation
                - Call the team members to execute the code review
                - Garant the correct use of the Laravel framework
                - Garant the knowledge of the Laravel framework
                - Garant the knowledhe of all code in the '/codebase' folder
                - Use the correct tools for the project
                - Use the correct tools for the task
                - Use the '/codebase' folder for the project inprove
                - Use the '/outputs' folder for the project improved
                - Use the '/outputs/documents' folder for the project documentation""",
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
            description="""
                Schedule the functionalities of pending tasks based on priority, dependencies, and resource availability.
                
                For that, you need to:
                - Review the codebase
                - Analyze the project progress
                - Review the organization of the tasks
                - Verify the tasks in the Google Sheets
                - Update the project timeline
                - Update tasks status in the Google Sheets
                - Provide feedback on the project progress
                - Monitor project metrics
                - Ask feedback in the terminal to the user in the reminal (Translate the ask to portuguese brazilian)""",
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
        
    def review_files_organization(self, agent, context):
        return Task(
            description="""Review the organization of files and folders within the project to ensure consistency, clarity, and efficiency.""",
            agent=agent,
            context=context,
            expected_output='An organized and well-structured file and folder system within the project, ensuring consistency, clarity, and efficiency in file management and access.'
        )
        
    def test_the_project(self, agent, context):
        return Task(
            description="""
            Test the project functionalities to ensure quality, reliability, and compliance with requirements.
            If you need help, ask for feedback from the team members
            If you have any questions, ask feedback in the terminal to the user in the reminal (Translate the ask to portuguese brazilian)
            If you need to delegate tasks, define the scope of tasks and delegate the tasks to the team members
            If project is not working, call the team members to discuss the project
            If project is not working, call the team members and delegate the tasks
            Garant funcionality of the project""",
            agent=agent,
            context=context,
            expected_output='A comprehensive testing report highlighting test results, issues, bugs, and recommendations for improving project quality and reliability.'
        )
        
    def project_delivery(self, agent, context):
        return Task(
            description="""
            Deliver the completed project to the client or stakeholders according to the agreed-upon timeline and quality standards.
            """,
            agent=agent,
            context=context,
            expected_output='A successfully delivered project that meets the client or stakeholders\' requirements, quality standards, and timeline expectations.'
        )