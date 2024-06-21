import matplotlib.pyplot as plt
import pandas as pd
from sqlalchemy import create_engine

engine = create_engine('mysql://username:password@localhost/SmartWaterManagement')
df = pd.read_sql('SELECT * FROM WaterLevels', engine)

df['reading_time'] = pd.to_datetime(df['reading_time'])
df.set_index('reading_time', inplace=True)

plt.figure(figsize=(10,5))
plt.plot(df['water_level'])
plt.title('Water Level Over Time')
plt.xlabel('Time')
plt.ylabel('Water Level (liters)')
plt.show()
