import mysql.connector
import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import StandardScaler
from sklearn.linear_model import LinearRegression
from sklearn.metrics import mean_squared_error, r2_score
import matplotlib.pyplot as plt

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
    print(f"Error: {err}")
    exit(1)

# Fetch the dataset from the WaterLevels table
query = "SELECT * FROM WaterLevels"
df = pd.read_sql(query, conn)
conn.close()

# Display the first few rows of the dataset
print("First few rows of the dataset:")
print(df)
# Preprocess the data
df.fillna(method='ffill', inplace=True)

# Assume 'water_level' is the target variable and the rest are features
X = df[['reading_id', 'sensor_id']]  # Adjust columns as per your actual feature set
y = df['water_level']

# Standardize the data
scaler = StandardScaler()
X_scaled = scaler.fit_transform(X)

# Split data into training and testing sets
X_train, X_test, y_train, y_test = train_test_split(X_scaled, y, test_size=0.2, random_state=42)

# Train a Linear Regression Model
model = LinearRegression()
model.fit(X_train, y_train)

# Make predictions and evaluate the model
y_pred = model.predict(X_test)
mse = mean_squared_error(y_test, y_pred)
r2 = r2_score(y_test, y_pred)

# Print evaluation metrics
print(f'Mean Squared Error: {mse}')
print(f'R^2 Score: {r2}')

# Plot actual vs predicted values
plt.figure(figsize=(10, 6))
plt.scatter(y_test, y_pred, color='blue')
plt.plot([y_test.min(), y_test.max()], [y_test.min(), y_test.max()], '--', color='red', linewidth=2)
plt.xlabel('Actual Water Levels')
plt.ylabel('Predicted Water Levels')
plt.title('Actual vs Predicted Water Levels')
plt.grid(True)
plt.show()
