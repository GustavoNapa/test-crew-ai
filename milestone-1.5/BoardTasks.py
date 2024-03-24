from crewai import Task
from BoardAgents import board_member1

class BoardTasks:
    def provide_strategic_guidance(self):
        return Task(
            name='Provide Strategic Guidance',
            description='Provide strategic guidance and direction for the project.',
            duration=60,
            priority=1,
            complexity=3,
            expected_output='Strategic guidance successfully provided.'
        )

    def provide_expert_advice(self):
        return Task(
            name='Provide Expert Advice',
            description='Provide expert advice and insights on technical aspects of the project.',
            duration=60,
            priority=1,
            complexity=3,
            expected_output='Expert advice successfully provided.'
        )

    def facilitate_communication(self):
        return Task(
            name='Facilitate Communication',
            description='Facilitate communication and collaboration among team members.',
            duration=60,
            priority=1,
            complexity=3,
            expected_output='Communication successfully facilitated.'
        )
        
    def define_project_architecture(self): 
        return Task(
            description='Define the project architecture, including design patterns and technologies to be used.',
            agent=board_member1,
            expected_output='Project architecture successfully defined.',
            data='Project architecture',
        )