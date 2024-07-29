from flask import Flask, jsonify
from flask_cors import CORS
from model_ok import run_model

app = Flask(__name__)
CORS(app)

@app.route('/run-script', methods=['POST'])
def run_script():
    print("Request received")
    result = run_model()
    print("Result:", result)
    return jsonify(result)

if __name__ == '__main__':
    app.run(port=5000, debug=True)
