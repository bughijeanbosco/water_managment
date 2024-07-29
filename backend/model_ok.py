import mysql.connector
import pandas as pd
import matplotlib.pyplot as plt
import io
import base64
from sklearn.metrics import mean_squared_error, r2_score

def run_model():
    # Connect to MySQL Database
    try:
        conn = mysql.connector.connect(
            host='localhost',
            user='root',
            password='',  # Replace with your actual MySQL password
            database='smartwatermanagement2'
        )
        print("Connected to MySQL database")
    except mysql.connector.Error as err:
        return {'error': str(err)}

    # Fetch the dataset from the water_level table
    query = "SELECT * FROM water_level"
    df = pd.read_sql(query, conn)
    conn.close()

    # Preprocess the data
    df.fillna(method='ffill', inplace=True)

    # Convert location names to lowercase to ensure case-insensitive grouping
    df['location'] = df['location'].str.lower()

    # Example true values and predictions for MSE and R^2 calculations
    # Replace these with your actual data and model predictions
    y_true = df['water_level'][:10]  # Replace with actual true values
    y_pred = df['water_level'].shift(1)[:10].fillna(0)  # Replace with actual predictions

    mse = mean_squared_error(y_true, y_pred)
    r2 = r2_score(y_true, y_pred)

    # Bin the water levels into intervals
    bins = [0, 20, 40, 60, 80, 100]  # Adjust bins as needed
    labels = ['0-20', '21-40', '41-60', '61-80', '81-100']
    df['water_level_interval'] = pd.cut(df['water_level'], bins=bins, labels=labels, include_lowest=True)

    # Prepare the data for plotting
    location_interval_counts = df.groupby(['location', 'water_level_interval']).size().unstack(fill_value=0)

    # Create a stacked bar plot
    plt.figure(figsize=(14, 10))  # Increase figure size
    location_interval_counts.plot(kind='bar', stacked=True, figsize=(14, 8), colormap='tab20')
    plt.xlabel('Location')
    plt.ylabel('Number of Readings')
    plt.title('Water Level Intervals by Location')
    plt.legend(title='Water Level Intervals', bbox_to_anchor=(1.05, 1), loc='upper left')
    plt.xticks(rotation=45, ha='right')  # Rotate x-axis labels for better readability
    plt.grid(True)

    # Save plot to a PNG image in memory
    buf = io.BytesIO()
    plt.savefig(buf, format='png', bbox_inches='tight')
    buf.seek(0)
    image_base64 = base64.b64encode(buf.getvalue()).decode('utf-8')
    buf.close()

    return {'mse': mse, 'r2': r2, 'plot': image_base64}
