import smtplib
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
from models import Alert

engine = create_engine('mysql://username:password@localhost/SmartWaterManagement')
Session = sessionmaker(bind=engine)
session = Session()

alerts = session.query(Alert).filter_by(status='unresolved').all()

for alert in alerts:
    # Setup the MIME
    message = MIMEMultipart()
    message['From'] = 'youremail@example.com'
    message['To'] = 'recipient@example.com'
    message['Subject'] = f'Alert: {alert.alert_type}'

    body = f"Alert Type: {alert.alert_type}\nTank ID: {alert.tank_id}\nTime: {alert.alert_time}\nStatus: {alert.status}"
    message.attach(MIMEText(body, 'plain'))

    # Send the email
    with smtplib.SMTP('smtp.example.com', 587) as server:
        server.starttls()
        server.login('youremail@example.com', 'password')
        server.sendmail('youremail@example.com', 'recipient@example.com', message.as_string())
