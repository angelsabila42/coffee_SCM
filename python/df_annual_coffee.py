import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import json

from sklearn.metrics import r2_score, mean_squared_error, mean_absolute_error
from prophet import Prophet
from sklearn.linear_model import LinearRegression
from datetime import timedelta


#---Cleaning the data---#
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
# Drop fully empty rows (if any)
# df.dropna(how='all', inplace=True)

# Rename columns to meaningful names
print(df.columns)

df.columns = ['Year', '60Kg_Bags', 'Metric_Tons', 'Value_USD', 'Unit_Value_USD_per_Kg']

#Converting the years
forecast_years = 5
df['Year'] = df['Year'].apply(convert_year)
# print(df.head())

df.dropna(subset=['Year', 'Value_USD'], inplace=True)

#Preparing the data for Prophet
df['ds']= pd.to_datetime(df['Year'].astype(str) + '-07-07', format= '%Y-%m-%d')
df = df[df['ds'] >= '1990-07-07']
df = df.rename(columns={'Value_USD': 'y'})

#Safe Log transformation
df['y'] = np.log(df['y'])

#Renaming the regressors
df['unit_value'] = df['Unit_Value_USD_per_Kg']
df['volume'] = df['60Kg_Bags']

#Splitting training and test data
train = df[df['ds'] < '2013-07-07'].copy()
test =  df[df['ds'] >= '2013-07-07'].copy()

#Preparing the linear regression model for the regressors
df['year_num'] = df['ds'].dt.year

#Creating the future DataFrame
future = pd.DataFrame()
future_years =[year for year in range(2025, 2025 + forecast_years)]
future['ds'] = pd.to_datetime([f"{year}-07-07" for year in future_years])
future['year_num'] = future['ds'].dt.year

#Unit Value
reg1 = LinearRegression()
reg1.fit(df[['year_num']], df['unit_value'])

#Volume
reg2 = LinearRegression()
reg2.fit(df[['year_num']], df['volume'])

future['unit_value'] = reg1.predict(future[['year_num']])
future['volume'] = reg2.predict(future[['year_num']])

#Using Prophet
#Defining the number of changepoints
num_changepoints = 5

start_date = train['ds'].min()
end_date = train['ds'].max()

#Generating evenly spaced change[points within the training range
changepoints = pd.date_range(start=start_date, end=end_date, periods=num_changepoints + 2)[1:-1].tolist()

print("Using changepoints at: ", changepoints)

model = Prophet(yearly_seasonality=False,
                      seasonality_mode='multiplicative',
                      growth="linear",
                      changepoint_prior_scale=0.15,
                      changepoints= changepoints) #['1995-07-07', '2005-07-07'])
model.add_seasonality(name='yearly_custom', period=365.25, fourier_order=5)

model.add_regressor('unit_value')
model.add_regressor('volume')
model.fit(train[['ds','y','unit_value','volume']])

#Predicting on historical data
historical_with_regressors = df[['ds', 'unit_value', 'volume']].copy()
historical_forecast = model.predict(historical_with_regressors)

historical_forecast['yhat'] = np.exp(historical_forecast['yhat'])

df_eval = df.copy()
#df_eval['ds'] = pd.to_datetime(df_eval['ds'].dt.year.astype(str) + '-07-07')
df_eval['y'] = np.exp(df_eval['y'])
historical_merged = pd.merge(df_eval, historical_forecast[['ds','yhat']], on='ds', how='inner')
print(historical_merged[['ds', 'y', 'yhat']].tail(10))

#Accuracy of the prediction
eval_df = historical_merged[historical_merged['ds'] >= '2013-07-07']
mae = mean_absolute_error(eval_df['y'], eval_df['yhat'])
rmse = np.sqrt(mean_squared_error(eval_df['y'], eval_df['yhat']))
r2 = r2_score(eval_df['y'], eval_df['yhat'])

print("MAE", mae)
print("RMSE", rmse)
print("R2 Score", r2)
print("Merged shape:", historical_merged.shape)

#Predicting for the next forecast years
forecast =model.predict(future)
forecast['yhat'] = np.exp(forecast['yhat'])
print("\nForecast Dates:")
print(forecast['ds'].tail(10))

# Safely serialize datetime columns
historical_merged['ds'] = pd.to_datetime(historical_merged['ds']).dt.strftime('%Y-%m-%d')
forecast['ds'] = pd.to_datetime(forecast['ds']).dt.strftime('%Y-%m-%d')

#Saving the values in json
historical_json = historical_merged[['ds', 'y', 'yhat']].rename(columns={'y': 'actual', 'yhat': 'predicted'}).to_dict(orient='records')

with open('public/data/historical_annual_sales.json', 'w') as f:
    json.dump(historical_json, f, indent=2)

forecast_json = forecast[['ds', 'yhat']].rename(columns={'yhat': 'forecast'}).to_dict(orient='records')
with open('public/data/forecasted_annual_sales.json', 'w') as f:
    json.dump(forecast_json, f, indent=2)

