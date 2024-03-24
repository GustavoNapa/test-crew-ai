from tasks import Tasks
from agents import Agents

def tasksFactory():
    arrayTasks = []
    tasks = Tasks()
    agents = Agents()
    researcher = agents.researcher()
    
    look_to_possible_temes = tasks.look_to_possible_temes(researcher)
    arrayTasks.append(look_to_possible_temes)
    research_information = tasks.research_information(researcher, [look_to_possible_temes])
    arrayTasks.append(research_information)
    
    return list(arrayTasks)