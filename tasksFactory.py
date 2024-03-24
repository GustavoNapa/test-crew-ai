from tasks import Tasks
from agents import Agents

def tasksFactory():
    arrayTasks = []
    tasks = Tasks()
    agents = Agents()
    researcher = agents.researcher()
    the_surgeon_programmer = agents.the_surgeon_programmer()
    
    review_codebase = tasks.review_codebase(researcher)
    analyze_project_progress = tasks.analyze_project_progress(the_surgeon_programmer, [review_codebase])
    provide_strategic_guidance = tasks.provide_strategic_guidance(the_surgeon_programmer, [review_codebase, analyze_project_progress])
    facilitate_communication = tasks.facilitate_communication(the_surgeon_programmer, [review_codebase, analyze_project_progress, provide_strategic_guidance])
    define_project_architecture = tasks.define_project_architecture(the_surgeon_programmer, [review_codebase, analyze_project_progress, provide_strategic_guidance, facilitate_communication])
    write_tasks_list_in_google_sheets = tasks.write_tasks_list_in_google_sheets(the_surgeon_programmer, [review_codebase, analyze_project_progress, provide_strategic_guidance, facilitate_communication, define_project_architecture])
    read_tasks_list_from_google_sheets = tasks.read_tasks_list_from_google_sheets(the_surgeon_programmer, [review_codebase, analyze_project_progress, provide_strategic_guidance, facilitate_communication, define_project_architecture, write_tasks_list_in_google_sheets])
    update_project_timeline =  tasks.update_project_timeline(the_surgeon_programmer, [review_codebase, analyze_project_progress, provide_strategic_guidance, facilitate_communication, define_project_architecture, write_tasks_list_in_google_sheets, read_tasks_list_from_google_sheets])
    execute_code_review = tasks.execute_code_review(the_surgeon_programmer, [review_codebase, analyze_project_progress, provide_strategic_guidance, facilitate_communication, define_project_architecture, write_tasks_list_in_google_sheets, read_tasks_list_from_google_sheets, update_project_timeline])
    generate_documentation = tasks.generate_documentation(the_surgeon_programmer, [review_codebase, analyze_project_progress, provide_strategic_guidance, facilitate_communication, define_project_architecture, write_tasks_list_in_google_sheets, read_tasks_list_from_google_sheets, update_project_timeline, execute_code_review])
    schedule_functionalities_of_pending_tasks = tasks.schedule_functionalities_of_pending_tasks(the_surgeon_programmer, [review_codebase, analyze_project_progress, provide_strategic_guidance, facilitate_communication, define_project_architecture, write_tasks_list_in_google_sheets, read_tasks_list_from_google_sheets, update_project_timeline, execute_code_review, generate_documentation])
    provide_feedback_on_project_progress = tasks.provide_feedback_on_project_progress(the_surgeon_programmer, [review_codebase, analyze_project_progress, provide_strategic_guidance, facilitate_communication, define_project_architecture, write_tasks_list_in_google_sheets, read_tasks_list_from_google_sheets, update_project_timeline, execute_code_review, generate_documentation, schedule_functionalities_of_pending_tasks])
    monitor_project_metrics = tasks.monitor_project_metrics(the_surgeon_programmer, [review_codebase, analyze_project_progress, provide_strategic_guidance, facilitate_communication, define_project_architecture, write_tasks_list_in_google_sheets, read_tasks_list_from_google_sheets, update_project_timeline, execute_code_review, generate_documentation, schedule_functionalities_of_pending_tasks, provide_feedback_on_project_progress])
    
    arrayTasks.append(review_codebase)
    arrayTasks.append(analyze_project_progress)
    arrayTasks.append(provide_strategic_guidance)
    arrayTasks.append(facilitate_communication)
    arrayTasks.append(define_project_architecture)
    arrayTasks.append(write_tasks_list_in_google_sheets)
    arrayTasks.append(read_tasks_list_from_google_sheets)
    arrayTasks.append(update_project_timeline)
    arrayTasks.append(execute_code_review)
    arrayTasks.append(generate_documentation)
    arrayTasks.append(schedule_functionalities_of_pending_tasks)
    arrayTasks.append(provide_feedback_on_project_progress)
    arrayTasks.append(monitor_project_metrics)
    
    return list(arrayTasks)