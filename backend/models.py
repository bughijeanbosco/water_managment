from app import db
from datetime import datetime

class Tank(db.Model):
    tank_id = db.Column(db.Integer, primary_key=True)
    location = db.Column(db.String(255), nullable=False)
    capacity = db.Column(db.Integer, nullable=False)
    install_date = db.Column(db.Date, nullable=False)

class Sensor(db.Model):
    sensor_id = db.Column(db.Integer, primary_key=True)
    tank_id = db.Column(db.Integer, db.ForeignKey('tank.tank_id'), nullable=False)
    sensor_type = db.Column(db.String(50), nullable=False)
    install_date = db.Column(db.Date, nullable=False)
    status = db.Column(db.String(50), nullable=False)

class WaterLevel(db.Model):
    reading_id = db.Column(db.Integer, primary_key=True)
    sensor_id = db.Column(db.Integer, db.ForeignKey('sensor.sensor_id'), nullable=False)
    reading_time = db.Column(db.DateTime, default=datetime.utcnow)
    water_level = db.Column(db.Integer, nullable=False)

class Alert(db.Model):
    alert_id = db.Column(db.Integer, primary_key=True)
    tank_id = db.Column(db.Integer, db.ForeignKey('tank.tank_id'), nullable=False)
    alert_time = db.Column(db.DateTime, default=datetime.utcnow)
    alert_type = db.Column(db.String(100), nullable=False)
    status = db.Column(db.String(50), nullable=False)

class UsageLog(db.Model):
    log_id = db.Column(db.Integer, primary_key=True)
    tank_id = db.Column(db.Integer, db.ForeignKey('tank.tank_id'), nullable=False)
    log_time = db.Column(db.DateTime, default=datetime.utcnow)
    usage_amount = db.Column(db.Integer, nullable=False)
    remaining_level = db.Column(db.Integer, nullable=False)
