from langchain.tools import tool

import gspread
from oauth2client.service_account import ServiceAccountCredentials

@tool("Log event to Google Sheets")
def write_in_google_sheets(event):
    """
    Logs an event and appends a row to the Google Sheets spreadsheet.

    Args:
        event (str): The event to be logged.

    Returns:
        None
    """
    # Add a row to the Google Sheets spreadsheet
    sheet_id = '12tOwOjx5UjBdpA7kGIbUFNaq4aO-3tA4ZNtyXyN3zXw'
    scope = ["https://spreadsheets.google.com/feeds", "https://www.googleapis.com/auth/drive"]
    credentials = ServiceAccountCredentials.from_json_keyfile_name("credentials.json", scope)
    client = gspread.authorize(credentials)
    sheet = client.open_by_key(sheet_id).sheet1
    
    sheet.append_row([event])
    print(f"Event logged: {event}")
    
@tool("Read sheet from Google Sheets")
def read_sheet_of_google_sheets():
    """
    Reads the contents of the Google Sheets spreadsheet.

    Returns:
        list: The contents of the Google Sheets spreadsheet.
    """
    # Read the contents of the Google Sheets spreadsheet
    sheet_id = '12tOwOjx5UjBdpA7kGIbUFNaq4aO-3tA4ZNtyXyN3zXw'
    scope = ["https://spreadsheets.google.com/feeds", "https://www.googleapis.com/auth/drive"]
    credentials = ServiceAccountCredentials.from_json_keyfile_name("credentials.json", scope)
    client = gspread.authorize(credentials)
    sheet = client.open_by_key(sheet_id).sheet1
    
    data = sheet.get_all_records()
    print(f"Sheet read: {data}")
    return data