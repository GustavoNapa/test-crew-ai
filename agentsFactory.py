from agents import Agents
agents = Agents()

def agentsFactory():
    arrayAgents = []
    researcher = agents.researcher()
    arrayAgents.append(researcher)
    google_sheets_writer = agents.google_sheets_writer()
    arrayAgents.append(google_sheets_writer)
    google_sheets_reader = agents.google_sheets_reader()
    arrayAgents.append(google_sheets_reader)
    
    return list(arrayAgents)