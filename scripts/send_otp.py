import base64
import os.path
from email.message import EmailMessage
from google.auth.transport.requests import Request
from google_auth_oauthlib.flow import InstalledAppFlow
from google.oauth2.credentials import Credentials
from googleapiclient.discovery import build
import sys

otp = sys.argv[1]

SCOPES = ['https://www.googleapis.com/auth/gmail.send']
token_path = "C:\\xampp\\htdocs\\college-portal\\token.json"
credentials_path = "C:\\xampp\\htdocs\\college-portal\\credentials.json"

def get_service():
    creds = None
    if os.path.exists(token_path):
        creds = Credentials.from_authorized_user_file(token_path, SCOPES)

    if not creds or not creds.valid:
        if creds and creds.expired and creds.refresh_token:
            creds.refresh(Request())
        else:
            flow = InstalledAppFlow.from_client_secrets_file(credentials_path, SCOPES)
            creds = flow.run_local_server(port=0)
        
        with open(token_path, 'w') as token:
            token.write(creds.to_json())

    return build('gmail', 'v1', credentials=creds)

def create_message(sender, to, subject, message_text):
    message = EmailMessage()
    message.set_content(message_text)
    message['To'] = to
    message['From'] = sender
    message['Subject'] = subject

    raw = base64.urlsafe_b64encode(message.as_bytes()).decode()
    return {'raw': raw}

def send_message(service, user_id, message):
    try:
        sent_message = service.users().messages().send(userId=user_id, body=message).execute()
        print('Message Id:', sent_message['id'])
        return sent_message
    except Exception as e:
        print('An error occurred:', e)


service = get_service()
message = create_message(
    sender='pranavbairytempo@gmail.com',
    to='pranavbairy2005@gmail.com',
    subject='Otp for confirmation',
    message_text=f'Your otp is {otp}'
)
send_message(service, 'me', message)
