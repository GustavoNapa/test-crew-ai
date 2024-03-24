from agents import Agents
agents = Agents()

def agentsFactory():
    arrayAgents = []
    researcher = agents.researcher()
    the_surgeon_programmer = agents.the_surgeon_programmer()
    the_copilot_programmer = agents.the_copilot_programmer()
    the_administrator = agents.the_administrator()
    the_editor = agents.the_editor()
    the_secretary = agents.the_secretary()
    the_program_clerk = agents.the_program_clerk()
    the_toolsmith = agents.the_toolsmith()
    the_tester = agents.the_tester()
    the_language_lawyer = agents.the_language_lawyer()
    
    
    arrayAgents.append(researcher)
    arrayAgents.append(the_surgeon_programmer)
    arrayAgents.append(the_copilot_programmer)
    arrayAgents.append(the_administrator)
    arrayAgents.append(the_editor)
    arrayAgents.append(the_secretary)
    arrayAgents.append(the_program_clerk)
    arrayAgents.append(the_toolsmith)
    arrayAgents.append(the_tester)
    arrayAgents.append(the_language_lawyer)
    
    return list(arrayAgents)