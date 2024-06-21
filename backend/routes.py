from flask import request, jsonify
from app import app, db
from models import WaterLevel

@app.route('/add_reading', methods=['POST'])
def add_reading():
    data = request.get_json()
    new_reading = WaterLevel(sensor_id=data['sensor_id'], water_level=data['water_level'])
    db.session.add(new_reading)
    db.session.commit()
    return jsonify({'message': 'Reading added successfully!'})
