# Smart Water Tank Level Detection System

## Introduction
This project aims to monitor and manage water levels in tanks using sensors and a web application. The system uses deep learning for efficient resource management.

## Project Structure
- `backend/`: Contains the Flask application and database models.
- `frontend/`: Contains the PHP frontend application.
- `scripts/`: Contains scripts for data analysis and notifications.

## Setup Instructions

### Backend
1. Navigate to the `backend` directory.
2. Install the dependencies:
    ```bash
    pip install -r requirements.txt
    ```
3. Run the Flask application:
    ```bash
    python app.py
    ```

### Frontend
1. Make sure your local server (XAMPP) is running.
2. Place the `frontend` directory in your web server's root directory (e.g., `htdocs` for XAMPP).

### Scripts
- Data Analysis:
    ```bash
    python scripts/data_analysis.py
    ```
- Notifications:
    ```bash
    python scripts/notifications.py
    ```

## Usage
1. Open the frontend application in your browser.
2. Add readings via the API or the frontend interface.
3. Monitor the water levels and alerts in the dashboard.
4. Analyze the data and receive notifications for critical alerts.

## Contribution
Feel free to fork this project and submit pull requests. Any contributions are welcome!
