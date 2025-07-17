import pandas as pd
import matplotlib.pyplot as plt
import numpy as np
import os
from sklearn.linear_model import LinearRegression
from sklearn.model_selection import train_test_split
from sklearn.metrics import r2_score, mean_squared_error
from sklearn.preprocessing import StandardScaler

def convert_year(val):
    try:
        val_str = str(val).strip().replace('"','')

        if '/' in val_str:
            first = val_str.split('/')[0].strip()
            if len(first) == 4:
                return int(first)
            elif len(first) == 2:
                num = int(first)
                if num >= 64:
                    return num + 1900
                else:
                    return 2000 + num
        return int(val)
    except Exception as e:
        print(f"Could not convert year: {val} -> Error: {e} ")
        return None
    


df = pd.read_json('http://127.0.0.1:8000/api/v1/annual-sales')
#type:ignore
df = pd.json_normalize(df['data'])#type:ignore

# Rename columns to meaningful names
df.columns = ['Year', '60Kg_Bags', 'Metric_Tons', 'Value_USD', 'Unit_Value_USD_per_Kg']

# Drop the row that accidentally has 'Year' as a string in the 'Year' column
df = df[df['Year'] != 'Year']
df['Year'] = df['Year'].apply(convert_year)
df.dropna(subset=['Year', 'Value_USD'], inplace=True)
df['ds'] = pd.to_datetime(df['Year'].astype(int) ,format='%Y')
df = df[df['ds'] >= '1990-01-01']

df['60Kg_Bags'] = pd.to_numeric(df['60Kg_Bags'], errors='coerce')
df['Metric_Tons'] = pd.to_numeric(df['Metric_Tons'], errors='coerce')
df['Value_USD'] = pd.to_numeric(df['Value_USD'], errors='coerce')
df['Unit_Value_USD_per_Kg'] = pd.to_numeric(df['Unit_Value_USD_per_Kg'], errors='coerce')

print("\nCleaned Data:")
print(df.head())
print(df.tail())



# Drop the "Year" row and convert Year to a usable format
# df = df[df['Year'] != 'Year'].copy()
# df['Year'] = df['Year'].astype(str)

#SkLearn Create features, Target Variables
df['Revenue_Estimate'] = df['60Kg_Bags'] * df['Unit_Value_USD_per_Kg']
df['price_per_bag'] = df['Unit_Value_USD_per_Kg'] * 60
df['usd_per_bag'] = df['Value_USD'] / df['60Kg_Bags']

scaler = StandardScaler()

features= ['60Kg_Bags','Unit_Value_USD_per_Kg']
X = df[features]
X_scaled = scaler.fit_transform(X)
y = df['Value_USD']

print("Shape of X:", X.shape)
print("Shape of y:", y.shape)
print(df.head())


X_train, X_test,  y_train , y_test = train_test_split(
    X_scaled, y,
    test_size=0.2,
    shuffle=False
)

#training the model
model = LinearRegression()
model.fit(X_train, y_train)

#y_pred = model.predict(X_test)
y_pred = model.predict(X_test)

#Evaluation Results
rmse = np.sqrt(mean_squared_error(y_test, y_pred))
print("Mean Squared Error:", mean_squared_error(y_test, y_pred))
print("R^2 Score:", r2_score(y_test, y_pred))
print("Root Mean Squared Value:", rmse)


###---Predicting the features---###
df['Year'] = df['ds'].dt.year
X_years = df['Year'].to_numpy().reshape(-1,1)

#Fitting the values
bags_model = LinearRegression().fit(X_years, df['60Kg_Bags'])
price_model =LinearRegression().fit(X_years, df['Unit_Value_USD_per_Kg'])

#Creating the next 5 years
future_years = np.arange(2024, 2030).reshape(-1,1)
future_dates = pd.to_datetime(future_years.flatten(), format= '%Y')

#Making the feature predictions
future_bags = bags_model.predict(future_years)
future_prices = price_model.predict(future_years)

#Building the new Dataframe for the prediction
future_df = pd.DataFrame({
    'Year': future_years.flatten(),
    'ds': future_dates,
    '60Kg_Bags': future_bags,
    'Unit_Value_USD_per_Kg': future_prices,
})

future_df['Manual_Estimate'] = future_df['60Kg_Bags'] * future_df['Unit_Value_USD_per_Kg'] * 60

#Scaling the features
future_X = future_df[['60Kg_Bags', 'Unit_Value_USD_per_Kg']]
future_X_scaled = scaler.transform(future_X)
future_df['Predicted_Value_USD'] = model.predict(future_X_scaled)
print(future_df[['Year', '60Kg_Bags', 'Unit_Value_USD_per_Kg', 'Predicted_Value_USD', 'Manual_Estimate']])

# Append 2024 actuals to future_df for smooth graph
last_actual = df[['ds', 'Value_USD']].iloc[-1:]
future_plot_df = pd.concat([
    last_actual.rename(columns={'Value_USD': 'Predicted_Value_USD'}),
    future_df[['ds', 'Predicted_Value_USD']]
])

plot_df = df[(df['Year'] >= 2010) & (df['Year'] < 2024)]

#Preparing Historical data
historical_data = plot_df[['Year', 'Value_USD']].copy()
historical_data.rename(columns={'Value_USD': 'Value in US Dollars', 'Year': 'year'}, inplace=True)
#Preparing predictions
forecast_data = future_df[['Year', 'Predicted_Value_USD']].copy()
forecast_data.rename(columns={'Predicted_Value_USD': 'Value in US Dollars', 'Year': 'year'}, inplace=True)

#Converting to json
# Ensuring the directory exists
os.makedirs('../public/data', exist_ok=True)
historical_data.to_json('public/data/historical_sales.json', orient='records')
forecast_data.to_json('public/data/forecasted_sales.json', orient='records')

# Final Plot
plt.figure(figsize=(12,6))
plt.plot(plot_df['ds'], plot_df['Value_USD'], label='Actual (2010–2023)', color='blue')
plt.plot(future_plot_df['ds'], future_plot_df['Predicted_Value_USD'], linestyle='--', label='Model Forecast (2024–2029)', color='orange')
plt.title('Coffee Export Sales Forecast')
plt.xlabel('Year')
plt.ylabel('Value in USD')
plt.legend()
plt.grid(True)
plt.tight_layout()
plt.show()



